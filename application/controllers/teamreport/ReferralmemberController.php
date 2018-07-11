<?php
defined('BASEPATH') or exit('No direct script access allowed');



class ReferralmemberController  extends MY_Controller
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

						$total_downline_purchase 		 = 0 ;
						$total_downline_purchase_current = 0 ;
						$total_self_purchase_current 	 = 0 ;
						$total_self_purchase 	 		 = 0 ;

						$start = date('Y-m-').'01';
						$end   = date("Y-m-t", strtotime( $start ) );

						foreach ($this->model_users->query("Select users.user_id,users.username,users.create_at,first_name,last_name from users JOIN userinfo ON users.user_id=userinfo.user_id WHERE upline_id='".$userid."'")->result() as $key => $user) {

							foreach ($this->model_matrixdownline->select('downline_id',['referral_id' => $user->user_id]) as $key => $downline) {
									
									$total_downline_purchase = $total_downline_purchase + $this->model_portfolio->sum('portfolio_amount',[ 'user_id' => $downline->downline_id ]);

									$total_downline_purchase_current = $total_downline_purchase_current + $this->model_portfolio->sum('portfolio_amount',[ 'user_id' => $downline->downline_id,'DATE(transaction_date) >=' => $start ,'DATE(transaction_date) <=' => $end ]);
							}

							$total_self_purchase 		= $total_self_purchase + $this->model_portfolio->sum('portfolio_amount',[ 'user_id' => $user->user_id ]);

							$total_self_purchase_current = $total_self_purchase_current + $this->model_portfolio->sum('portfolio_amount',[ 'user_id' => $user->user_id ,'DATE(transaction_date) >=' => $start ,'DATE(transaction_date) <=' => $end]);


							$total 			= $total_downline_purchase + $total_self_purchase ;
							$total_current  = $total_downline_purchase_current + $total_self_purchase_current;

							array_push($result,['user_id' => $user->user_id,'username' => $user->username,'member_name' => $user->first_name .' '. $user->last_name,'date_registered' => $user->create_at,'total_purchase' => $total ,'total_current' => $total_current]);

						}

						$data = [
									'userid' 			=> $userid,
									'rank_name' 		=> $rank_name ,
									'achieved_date' 	=> $achieved_date ,
									'referral_members'	=> $result,
									'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()
								];

						return $this->load->view('teamreport/directmembers',$data);
				}
				else {
						redirect('login');
				}
	}

	public function get_direct_members() {

			if( $this->is_logged_in() ) {


				$this->load->model('model_rwallet');
				$this->load->model('model_portfolio');
				$this->load->model('model_matrixdownline');

				$total_downline_purchase 		 = 0 ;
				$total_downline_purchase_current = 0 ;
				$total_self_purchase_current 	 = 0 ;
				$total_self_purchase 	 		 = 0 ;

						
				$userid  = $this->auth_user_id;

				$start = date('Y-m-').'01';
				$end   = date("Y-m-t", strtotime( $start ) );

							
					
				$result =  [] ;

				$count = 0 ;

				foreach ($this->model_users->query("Select users.user_id,users.username,users.create_at,first_name,last_name from users JOIN userinfo ON users.user_id=userinfo.user_id WHERE upline_id='".$userid."'")->result() as $key => $user) {

					foreach ($this->model_matrixdownline->select('downline_id',['referral_id' => $user->user_id,'level <' => 22]) as $key => $downline) {
									
									$total_downline_purchase = $total_downline_purchase + $this->model_portfolio->sum('portfolio_amount',[ 'user_id' => $downline->downline_id ]);

									$total_downline_purchase_current = $total_downline_purchase_current + $this->model_portfolio->sum('portfolio_amount',[ 'user_id' => $downline->downline_id,'DATE(transaction_date) >=' => $start ,'DATE(transaction_date) <=' => $end ]);
					}

					$count +=1 ;

					$total_self_purchase 		= $total_self_purchase + $this->model_portfolio->sum('portfolio_amount',[ 'user_id' => $user->user_id ]);

					$total_self_purchase_current = $total_self_purchase_current + $this->model_portfolio->sum('portfolio_amount',[ 'user_id' => $user->user_id ,'DATE(transaction_date) >=' => $start ,'DATE(transaction_date) <=' => $end]);


					$total 			= $total_downline_purchase + $total_self_purchase ;
					$total_current  = $total_downline_purchase_current + $total_self_purchase_current;

							array_push($result,[$count,$user->user_id, $user->username,$user->first_name .' '. $user->last_name, $total , $total_current,$user->create_at]);

				}



						$data = array(
												"sEcho" => 1,
												"iTotalRecords" => count($result),
												"iTotalDisplayRecords" => count($result),
												"aaData"=>$result); 
					echo json_encode($data);

			}
			else {

				redirect('login');

			}
	}

	


}