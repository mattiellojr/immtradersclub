<?php
defined('BASEPATH') or exit('No direct script access allowed');



class MembertreememberController  extends MY_Controller
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
						$upline_id  		= "";


						foreach ($this->model_users->query("Select users.upline_id,users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
								$upline_id 		= $value->upline_id;
						}

						
						$data = [
									'userid' 			=> $userid,
									'rank_name' 		=> $rank_name ,
									'achieved_date' 	=> $achieved_date ,
									'referral_members'	=> $result ,
									'upline'			=> $this->model_users->select('*',['user_id' => $upline_id]),
									'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()
								];

						return $this->load->view('teamreport/membertree',$data);
				}
				else {
						redirect('login');
				}
	}

	public function get_downline_tree() {

				$this->is_logged_in();

				$userid  = $this->auth_user_id;
				$level 	 = $this->input->post('level');
				$data 	 = [] ;

				$this->load->model('model_matrixdownline');
				$this->load->model('model_portfolio');

				$referred_by = "";
				$status 	= "";
				$count = 0 ;
				foreach ($this->model_matrixdownline->query("SELECT users.user_id,users.create_at,users.upline_id,users.username,userinfo.first_name,userinfo.last_name from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN matrixdownline  ON matrixdownline.downline_id=users.user_id WHERE matrixdownline.referral_id='".$userid."' AND matrixdownline.level='".$level."' ")->result() as $key => $user) {
					
					$count +=1;
					foreach ($this->model_users->select('*',['user_id' => $user->upline_id ]) as $key => $referred) {
							
							$referred_by = $referred->user_id . '-' .$referred->username;
					}

					if($this->model_portfolio->count_ref(['user_id' => $user->user_id]) > 0) {

						$status = "Active";
					}
					else {
						 $status ="Inactive";
					}

					array_push($data,[$count,$user->user_id,$user->username,$user->first_name .' '. $user->last_name,$referred_by,$user->create_at,$status]);



				}

				$results = array(
										"sEcho" => 1,
										"iTotalRecords" => count($data),
										"iTotalDisplayRecords" => count($data),
										"aaData"=>$data); 

			echo json_encode($results);
	}

}