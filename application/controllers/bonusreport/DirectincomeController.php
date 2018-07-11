<?php
defined('BASEPATH') or exit('No direct script access allowed');



class DirectincomeController  extends MY_Controller
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
								'userid' 			=> $userid,
								'rank_name' 		=> $rank_name ,
								'achieved_date' 	=> $achieved_date ,
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' ORDER BY transaction_date DESC  LIMIT 5 ")->result()
								
							];

					return $this->load->view('bonusreport/directincome',$data);
				}
				else {
					redirect('login');
				}
	}

	public function get_history() {


		if( $this->is_logged_in() ) {

			$userid  = $this->auth_user_id;


			$data   =   [] ;

				$counter =	0 ;

				foreach ($this->model_transactionhistory->query("SELECT transactionhistory.*,users.username  FROM transactionhistory JOIN users ON transactionhistory.sender_id=users.user_id WHERE  transactionhistory.user_id='".$userid."' AND  transactionhistory.type_id='6' ORDER BY transaction_id desc LIMIT 1000 ")->result() as $key => $value) {
					
					$counter  += 1 ;

					array_push($data,
									[
										$counter,
										$value->transaction_no,
										$value->sender_id .'-'.$value->username,
										$value->credited_amount,
										date('F d, Y h:i:s A', strtotime($value->transaction_date)),
										$value->description

									]


								);


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


	public function search_history() {



		if( $this->is_logged_in() ) {

			$userid  = $this->auth_user_id;


			$data   =   [] ;
			$df 	=	$this->input->post('date_from');
			$dt 	=	$this->input->post('date_to');


			if( !empty($df) && !empty($dt)) {


				$counter =	0 ;

				foreach ($this->model_transactionhistory->query("SELECT transactionhistory.*,users.username  FROM transactionhistory JOIN users ON transactionhistory.sender_id=users.user_id WHERE  transactionhistory.user_id='".$userid."' AND  transactionhistory.type_id='6' AND (DATE(transaction_date) >='".$df."' AND DATE(transaction_date) <= '".$dt."')")->result() as $key => $value) {
					
					$counter  += 1 ;

					array_push($data,
									[
										$counter,
										$value->transaction_no,
										$value->sender_id .'-'.$value->username,
										$value->credited_amount,
										date('F d, Y h:i:s A', strtotime($value->transaction_date)),
										$value->description

									]

								);

				}

			}

			else {

				$counter =	0 ;

				foreach ($this->model_transactionhistory->query("SELECT transactionhistory.*,users.username  FROM transactionhistory JOIN users ON transactionhistory.sender_id=users.user_id WHERE  transactionhistory.user_id='".$userid."' AND  transactionhistory.type_id='6' ORDER BY transaction_id desc LIMIT 1000 ")->result() as $key => $value) {
					
					$counter  += 1 ;

					array_push($data,
									[
										$counter,
										$value->transaction_no,
										$value->sender_id .'-'.$value->username,
										$value->credited_amount,
										date('F d, Y h:i:s A', strtotime($value->transaction_date)),
										$value->description

									]

								);

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