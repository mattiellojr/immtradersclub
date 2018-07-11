<?php
defined('BASEPATH') or exit('No direct script access allowed');



class CoinsController  extends MY_Controller
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
		$this->load->model('model_matrixdownline');
		

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
									'achieved_date' 		=> $achieved_date,
									'imc'					=> $this->model_purchasehistory->sum('coins_received',['user_id' => $userid,'coin_type' => 'IMM']),
									'eth'					=> $this->model_purchasehistory->sum('coins_received',['user_id' => $userid,'coin_type' => 'ETH']),
									'xrp'					=> $this->model_purchasehistory->sum('coins_received',['user_id' => $userid,'coin_type' => 'XRP']),
									'etc'					=> $this->model_purchasehistory->sum('coins_received',['user_id' => $userid,'coin_type' => 'ETC']),
									'ltc'					=> $this->model_purchasehistory->sum('coins_received',['user_id' => $userid,'coin_type' => 'LTC']),
									'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()
						
								];

					return $this->load->view('mycoins/purchases',$data);
				}
				else {
					redirect('login');
				}
	}
	public function coin_histoy() {


		   if($this->is_logged_in()) {


		   		$userid 	=	$this->auth_user_id;

		   		$data 		=  [] ;

		   		$count = 0 ;
		   		foreach ($this->model_purchasehistory->select('*',['user_id' => $userid]) as $key => $value) {
		   				
		   				$count +=1;


		   				array_push($data ,[
		   									$count,
		   									$value->transaction_no,
		   									$value->coin_type,
		   									$value->price,
		   									$value->purchased_amount,
		   									$value->coins_received,
		   									$value->purchase_date,
		   									'Paid'
		   								]);
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

		   	 	redirect('login','refresh');
		   }
	}
	public function downlines() {


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
						
								];

					return $this->load->view('mycoins/downlinepurchases',$data);
				}
				else {
					redirect('login');
				}
	}

	public function search_downline_purchases() {


		if($this->is_logged_in()) {

			$userid  = $this->input->post('user_id');
			$df 	 = $this->input->post('date_from');
			$dt 	 = $this->input->post('date_to');


			$data = [] ;


			if(!empty($userid)) {
					if(!empty($df) && !empty($dt)) {


							$count = 0 ;
							 	foreach ($this->model_matrixdownline->select('*',['referral_id' => $userid ,'level <' => 22]) as $key => $value) {
										foreach ($this->model_users->query("SELECT user_id,username from users  WHERE user_id='".$value->downline_id."'")->result() as $key => $user) {



										foreach ($this->model_purchasehistory->select('*',['user_id'=>$user->user_id,'purchased_amount >=' => $df,'purchased_amount <=' => $dt]) as $key => $value2) {
												
												$count +=1;
												
												array_push($data ,[
					   									$count,
					   									$value2->transaction_no,
					   									$user->user_id .'-'.$user->username,
					   									$value2->coin_type,
					   									$value2->price,
					   									$value2->purchased_amount,
					   									$value2->coins_received,
					   									$value2->purchase_date,
					   									'Paid'

					   									]);
											}
									}
								}

					}
					else {

								$count = 0 ;
							 	foreach ($this->model_matrixdownline->select('*',['referral_id' => $userid ,'level <' => 22]) as $key => $value) {
										foreach ($this->model_users->query("SELECT user_id,username from users  WHERE user_id='".$value->downline_id."'")->result() as $key => $user) {



										foreach ($this->model_purchasehistory->select('*',['user_id'=>$user->user_id]) as $key => $value2) {
												
												$count +=1;
												
												array_push($data ,[
								   									$count,
								   									$value2->transaction_no,
								   									$user->user_id .'-'.$user->username,
								   									$value2->coin_type,
								   									$value2->price,
								   									$value2->purchased_amount,
								   									$value2->coins_received,
								   									$value2->purchase_date,
								   									'Paid'
					   										]);
											}
									}
								}

					}

					

			}
			else {


					$userid = $this->auth_user_id;

					if(!empty($df) && !empty($dt)) {


							$count = 0 ;
							 	foreach ($this->model_matrixdownline->select('*',['referral_id' => $userid ,'level <' => 22]) as $key => $value) {
										foreach ($this->model_users->query("SELECT user_id,username from users  WHERE user_id='".$value->downline_id."'")->result() as $key => $user) {



										foreach ($this->model_purchasehistory->select('*',['user_id'=>$user->user_id,'purchased_amount >=' => $df,'purchased_amount <=' => $dt]) as $key => $value2) {
												
												$count +=1;
												
												array_push($data ,[
								   									$count,
								   									$value2->transaction_no,
								   									$user->user_id .'-'.$user->username,
								   									$value2->coin_type,
								   									$value2->price,
								   									$value2->purchased_amount,
								   									$value2->coins_received,
								   									$value2->purchase_date,
								   									'Paid'
					   											]);
											}
									}
								}

					}
					else {

								$count = 0 ;
							 	foreach ($this->model_matrixdownline->select('*',['referral_id' => $userid ,'level <' => 22]) as $key => $value) {
										foreach ($this->model_users->query("SELECT user_id,username from users  WHERE user_id='".$value->downline_id."'")->result() as $key => $user) {



										foreach ($this->model_purchasehistory->select('*',['user_id'=>$user->user_id]) as $key => $value2) {
												
												$count +=1;
												
												array_push($data ,[
								   									$count,
								   									$value2->transaction_no,
								   									$user->user_id .'-'.$user->username,
								   									$value2->coin_type,
								   									$value2->price,
								   									$value2->purchased_amount,
								   									$value2->coins_received,
								   									$value2->purchase_date,
								   									'Paid'

					   											]);
											}
									}
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

		   	 	redirect('login','refresh');
		   }


	}
}