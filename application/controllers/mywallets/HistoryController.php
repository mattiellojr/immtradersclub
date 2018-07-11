<?php
defined('BASEPATH') or exit('No direct script access allowed');



class HistoryController  extends MY_Controller
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

					$this->load->model('model_transactionhistory');
					$this->load->model('model_transactiontype');
					

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
									'trans_type'			=> $this->model_transactiontype->select('*'),
									'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()
								];

					return $this->load->view('transactionhistory/transactionhistory',$data);
				}
				else {
					redirect('login');
				}
	}

	public function  search_history() {

		if( $this->is_logged_in() ) {

					$this->load->model('model_transactionhistory');
					$this->load->model('model_transactiontype');


					$userid 	=	$this->auth_user_id;
					$trans_type =	$this->input->post('trans_type');
					$df 		=	$this->input->post('date_from');
					$dt 		=	$this->input->post('date_to');
					$data 		=	[];


					if( !empty( $trans_type ) ) {

						if( !empty( $df ) && !empty( $dt ) ) {

								$count = 0 ;

								foreach ($this->model_transactionhistory->query("SELECT *,(SELECT username FROM users WHERE user_id=transactionhistory.receiver_id) as receiver_name,(SELECT username FROM users WHERE user_id=transactionhistory.sender_id) as sender_name from transactionhistory JOIN transactiontype ON transactionhistory.type_id=transactiontype.type_id WHERE transactionhistory.user_id='".$userid."' AND transactionhistory.type_id='".$trans_type."' AND DATE(transaction_date) >='".$df."' AND DATE(transaction_date <='".$dt."' ORDER BY transaction_date desc LIMIT 1000")->result() as $key => $value) {

									
									$count +=1;

									array_push($data,[
														$count,
														$value->transaction_no,
														$value->sender_id.'-'.$value->sender_name,
														$value->receiver_id.'-'.$value->receiver_name,
														$value->credited_amount,
														$value->debited_amount,
														$value->transaction_type,
														$value->description,
														$value->transaction_date,
														$value->wallet_used,
														$value->remarks

													 ]);


								}

						}
						else {



								$count = 0 ;

								foreach ($this->model_transactionhistory->query("SELECT *,(SELECT username FROM users WHERE user_id=transactionhistory.receiver_id) as receiver_name,(SELECT username FROM users WHERE user_id=transactionhistory.sender_id) as sender_name from transactionhistory JOIN transactiontype ON transactionhistory.type_id=transactiontype.type_id WHERE transactionhistory.user_id='".$userid."' AND transactionhistory.type_id='".$trans_type."'  ORDER BY transaction_date desc LIMIT 1000")->result() as $key => $value) {

									

									$count +=1;

									array_push($data,[
														$count,
														$value->transaction_no,
														$value->sender_id.'-'.$value->sender_name,
														$value->receiver_id.'-'.$value->receiver_name,
														$value->credited_amount,
														$value->debited_amount,
														$value->transaction_type,
														$value->description,
														$value->transaction_date,
														$value->wallet_used,
														$value->remarks

													 ]);
								}


						}

					}
					else {


							if( !empty( $df ) && !empty( $dt ) ) {

								$count = 0 ;

								foreach ($this->model_transactionhistory->query("SELECT *,,(SELECT username FROM users WHERE user_id=transactionhistory.receiver_id) as receiver_name,(SELECT username FROM users WHERE user_id=transactionhistory.sender_id) as sender_name from transactionhistory JOIN transactiontype ON transactionhistory.type_id=transactiontype.type_id WHERE transactionhistory.user_id='".$userid."'  AND DATE(transaction_date) >='".$df."' AND DATE(transaction_date <='".$dt."' ORDER BY transaction_date desc LIMIT 1000")->result() as $key => $value) {

									

									$count +=1;

									array_push($data,[
														$count,
														$value->transaction_no,
														$value->sender_id.'-'.$value->sender_name,
														$value->receiver_id.'-'.$value->receiver_name,
														$value->credited_amount,
														$value->debited_amount,
														$value->transaction_type,
														$value->description,
														$value->transaction_date,
														$value->wallet_used,
														$value->remarks

													 ]);
								}
						}
						else {


								$count = 0 ;

								foreach ($this->model_transactionhistory->query("SELECT *,(SELECT username FROM users WHERE user_id=transactionhistory.receiver_id) as receiver_name,(SELECT username FROM users WHERE user_id=transactionhistory.sender_id) as sender_name from transactionhistory JOIN transactiontype ON transactionhistory.type_id=transactiontype.type_id WHERE transactionhistory.user_id='".$userid."'   ORDER BY transaction_date desc LIMIT 1000")->result() as $key => $value) {

									

									$count +=1;

									array_push($data,[
														$count,
														$value->transaction_no,
														$value->sender_id.'-'.$value->sender_name,
														$value->receiver_id.'-'.$value->receiver_name,
														$value->credited_amount,
														$value->debited_amount,
														$value->transaction_type,
														$value->description,
														$value->transaction_date,
														$value->wallet_used,
														$value->remarks

													 ]);
								}

						}

					}

				$results = array(
									"sEcho" 				=> 1,
									"iTotalRecords"			=> count($data),
									"iTotalDisplayRecords"	=> count($data),
									"aaData" 				=>	$data 	
								); 

				echo json_encode($results);
			}
		else {

				redirect('login');

		}
	}
}