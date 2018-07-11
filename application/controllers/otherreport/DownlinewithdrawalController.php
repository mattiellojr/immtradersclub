<?php
defined('BASEPATH') or exit('No direct script access allowed');



class DownlinewithdrawalController  extends MY_Controller
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
					$this->load->model('model_rankachievement');
					$this->load->library("pagination");
					

						$userid  			= " " ;
						$rank_name 			= " " ;
						$achieved_date 		= " ";
						$current_balance 	= 0 ;

						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}

						
				      
				       
						$data = [
									'userid' 				=> $userid,
									'rank_name' 			=> $rank_name ,
									'achieved_date' 		=> $achieved_date ,
									'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()
								];

					return $this->load->view('otherreport/downline_withdrawals',$data);
				}
				else {
					redirect('login');
				}
	}

	public function search_withdrawal() {

			if( $this->is_logged_in()) {

				$this->load->model('model_withdrawals');
				$this->load->model('model_matrixdownline');

				$userid  = $this->auth_user_id;
				$mode 	 = $this->input->post('withdrawal_mode');
				$df 	 = $this->input->post('date_from');
				$dt 	 = $this->input->post('date_to');


				$result  =[];


				if( !empty($mode)){

					if( !empty( $df ) && !empty( $dt ) ){
						$count = 0 ;
						foreach ($this->model_matrixdownline->select('downline_id',['referral_id' => $userid,'level <' => 22]) as $key => $value) {
							
							foreach ($this->model_withdrawals->query("SELECT * from withdrawals JOIN users ON withdrawals.user_id=users.user_id WHERE withdrawals.user_id='".$value->downline_id."' AND withdrawals.withdrawal_mode='".$mode."' AND withdrawals.withdrawal_date >='".$df."' AND withdrawals.withdrawal_date='".$dt."'")->result() as $key => $withdrawal) {

								$count += 1;

								array_push($result,[
													$count,
													$withdrawal->user_id,
													$withdrawal->username,
													$withdrawal->transaction_no,
													$withdrawal->amount_withdrawn,
													($withdrawal->amount_withdrawn * 0.05),
													$withdrawal->amount_net,
													$withdrawal->withdrawal_mode,
													$withdrawal->withdrawal_date,
													$withdrawal->paid_date,
													$withdrawal->remarks
												]);	
							}

						}
					}
					else {


						$count = 0 ;
						foreach ($this->model_matrixdownline->select('downline_id',['referral_id' => $userid,'level <' => 22]) as $key => $value) {
							
							foreach ($this->model_withdrawals->query("SELECT * from withdrawals JOIN users ON withdrawals.user_id=users.user_id WHERE withdrawals.user_id='".$value->downline_id."' AND withdrawals.withdrawal_mode='".$mode."'")->result() as $key => $withdrawal) {

								$count += 1;

								array_push($result,[
														$count,
														$withdrawal->user_id,
														$withdrawal->username,
														$withdrawal->transaction_no,
														$withdrawal->amount_withdrawn,
														($withdrawal->amount_withdrawn * 0.05),
														$withdrawal->amount_net,
														$withdrawal->withdrawal_mode,
														$withdrawal->withdrawal_date,
														$withdrawal->paid_date,
														$withdrawal->remarks
													]);
							}

						}

					}

				}
				else {

					if( !empty($df) && !empty($dt)){
						$count = 0 ;
						foreach ($this->model_matrixdownline->select('downline_id',['referral_id' => $userid,'level <' => 22]) as $key => $value) {
							
							foreach ($this->model_withdrawals->query("SELECT * from withdrawals JOIN users ON withdrawals.user_id=users.user_id WHERE withdrawals.user_id='".$value->downline_id."' AND withdrawals.withdrawal_date >='".$df."' AND withdrawals.withdrawal_date='".$dt."'")->result() as $key => $withdrawal) {

								$count += 1;

								array_push($result,[
													$count,
													$withdrawal->user_id,
													$withdrawal->username,
													$withdrawal->transaction_no,
													$withdrawal->amount_withdrawn,
													($withdrawal->amount_withdrawn * 0.05),
													$withdrawal->amount_net,
													$withdrawal->withdrawal_mode,
													$withdrawal->withdrawal_date,
													$withdrawal->paid_date,
													$withdrawal->remarks
												]);
							}

						}
					}
					else {

						$count = 0 ;
						foreach ($this->model_matrixdownline->select('downline_id',['referral_id' => $userid,'level <' => 22]) as $key => $value) {
							
							foreach ($this->model_withdrawals->query("SELECT * from withdrawals JOIN users ON withdrawals.user_id=users.user_id WHERE withdrawals.user_id='".$value->downline_id."' ")->result() as $key => $withdrawal) {

								$count += 1;

								array_push($result,[
													$count,
													$withdrawal->user_id,
													$withdrawal->username,
													$withdrawal->transaction_no,
													$withdrawal->amount_withdrawn,
													($withdrawal->amount_withdrawn * 0.05),
													$withdrawal->amount_net,
													$withdrawal->withdrawal_mode,
													$withdrawal->withdrawal_date,
													$withdrawal->paid_date,
													$withdrawal->remarks
												]);
									
							}

						}

					}
				}


				$data = array(
								"sEcho" 				=> 1,
								"iTotalRecords" 		=> count($result),
								"iTotalDisplayRecords"	=> count($result),
								"aaData"				=>$result
							); 

				echo json_encode($data);

			}
			else{

				redirect('login');
			}
	}
}
