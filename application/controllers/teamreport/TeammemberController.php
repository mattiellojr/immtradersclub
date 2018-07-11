<?php
defined('BASEPATH') or exit('No direct script access allowed');



class TeammemberController  extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Force SSL
		//$this->force_ssl();
		// Form and URL helpers always loaded (just for convenience)
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->model('model_users');	
		$this->load->model('model_transactionhistory');
		$this->load->model('model_rwallet');
		$this->load->model('model_ewallet');
		$this->load->model('model_purchasehistory');
		

	}

	public function index () {
			
				
				if( $this->is_logged_in() ) {

					$this->load->model('model_rwallet');
					$this->load->model('model_portfolio');
					$this->load->model('model_matrixdownline');
					

						$userid  			= " " ;
						$rank_name 			= " " ;
						$achieved_date 		= " ";
						$current_balance 	= 0 ;

						$result 			= array() ;

						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}
						$total = 0 ;
						foreach ($this->model_matrixdownline->select('*',['referral_id' => $userid ,'level <' => 22]) as $key => $value) {
							foreach ($this->model_users->query("SELECT users.user_id,users.username,users.create_at,userinfo.first_name,userinfo.last_name,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id WHERE users.user_id='".$value->downline_id."' AND rankachievement.rank_id=users.rank_id ")->result() as $key => $user) {


								$total	= $this->model_portfolio->sum('portfolio_amount',[ 'user_id' => $value->downline_id ]);

								array_push($result,['user_id' => $user->user_id,'username' => $user->username,'member_name' => $user->first_name .' '. $user->last_name,'date_registered' => $user->create_at,'total_purchase' => $total ,'rank' => $user->rank_name,'level' => $value->level,'date_achieved' => $user->achieved_date ]);
								
							}
						}

			

						$data = [
									'userid' 			=> $userid,
									'rank_name' 		=> $rank_name ,
									'achieved_date' 	=> $achieved_date ,
									'referral_members'	=> $result,
									'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()
								];

						return $this->load->view('teamreport/teammembers',$data);
				}
				else {
						redirect('login');
				}
	}

}