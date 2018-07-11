<?php
defined('BASEPATH') or exit('No direct script access allowed');



class WithdrawalsController  extends MY_Controller
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

	}

	public function index () {
			
				
				if($this->is_logged_in() ) {

					$userid 		= " ";
					$rank_name 		= " ";
					$achieved_date 	= "";
					$current_balance = 0;

					$this->load->model('model_cryptowallet');
					$this->load->model('model_ewallet');

					
						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}

						

					$data = [
								'userid' 		=> $userid,
								'rank_name' 	=> $rank_name ,
								'achieved_date' => $achieved_date ,
								'current_balance'		=> $current_balance,
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()

							];		
					return $this->load->view('withdrawals/withdrawals',$data);
				}
				else {
					redirect('login');
				}
	}

	public function get_withdrawals() {

			if($this->is_logged_in()){

				$userid 	= $this->auth_user_id;
				$result 	= [];

				$this->load->model('model_withdrawals');

			
				$count = 0 ;
				foreach ($this->model_withdrawals->select('*',['user_id' => $userid],[],['withdrawal_id' => 'desc']) as $key => $value) {
							
						$count +=1;
						array_push($result,
											[
												$count,
												$value->transaction_no,
												 $value->amount_withdrawn,
												 ($value->amount_withdrawn * 0.05),
												 $value->amount_net,
												$value->withdrawal_mode,
												$value->withdrawal_date,
												$value->paid_date,
												$value->remarks
											]

									);
				}


				$data = array(
								"sEcho" 				=> 1,
								"iTotalRecords" 		=> count($result),
								"iTotalDisplayRecords"	=> count($result),
								"aaData"				=>$result
							); 

				echo json_encode($data);

			}

			else {

				return redirect('login','refresh');
			}
	}
	public function search_withdrawals() {

		if( $this->is_logged_in() ) {

			$userid 	= $this->auth_user_id;

			$mode 		= $this->input->post('withdrawal_mode');
			$df 		= $this->input->post('date_from');
			$dt 		= $this->input->post('date_to');

			$result 	= [];

			$this->load->model('model_withdrawals');

	
			$count = 0 ;

			if(!empty($mode)) {

					if( !empty($df) && !empty($dt)) {
							foreach ($this->model_withdrawals->select('*',['user_id' => $userid,'withdrawal_mode' => $mode,'withdrawal_date >=' => $df,'withdrawal_date <=' > $dt],[],['withdrawal_id' => 'desc']) as $key => $value) {
							
									$count +=1;
									array_push($result,
														[
															$count,
															$value->transaction_no,
															$value->amount_withdrawn,
															($value->amount_withdrawn * 0.05),
															$value->amount_net,
															$value->withdrawal_mode,
															$value->withdrawal_date,
															$value->paid_date,
															$value->remarks
														]

												);
							}
						}

						else {

								foreach ($this->model_withdrawals->select('*',['user_id' => $userid,'withdrawal_mode' => $mode],[],['withdrawal_id' => 'desc']) as $key => $value) {
								
									$count +=1;
									array_push($result,
														[
															$count,
															$value->transaction_no,
															 $value->amount_withdrawn,
															 ($value->amount_withdrawn * 0.05),
															 $value->amount_net,
															$value->withdrawal_mode,
															$value->withdrawal_date,
															$value->paid_date,
															$value->remarks
														]

												);
							}
						}

			}

			else {

						if( !empty($df) && !empty($dt)) {
							foreach ($this->model_withdrawals->select('*',['user_id' => $userid,'withdrawal_date >=' => $df,'withdrawal_date <=' > $dt],[],['withdrawal_id' => 'desc']) as $key => $value) {
							
									$count +=1;
									array_push($result,
														[
															$count,
															$value->transaction_no,
															 $value->amount_withdrawn,
															 ($value->amount_withdrawn * 0.05),
															 $value->amount_net,
															$value->withdrawal_mode,
															$value->withdrawal_date,
															$value->paid_date,
															$value->remarks
														]

												);
							}
						}

						else {
								foreach ($this->model_withdrawals->select('*',['user_id' => $userid],[],['withdrawal_id' => 'desc']) as $key => $value) {
								
									$count +=1;
									array_push($result,
														[
															$count,
															$value->transaction_no,
															 $value->amount_withdrawn,
															 ($value->amount_withdrawn * 0.05),
															 $value->amount_net,
															$value->withdrawal_mode,
															$value->withdrawal_date,
															$value->paid_date,
															$value->remarks
														]

												);
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
		else {

			return redirect('login');
		}

	}

}