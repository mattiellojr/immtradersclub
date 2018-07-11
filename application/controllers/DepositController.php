<?php
defined('BASEPATH') or exit('No direct script access allowed');



class DepositController  extends MY_Controller
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


					$this->load->model('model_banks');

					
					foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value ) {

								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;

						}

					$data = [
								'userid' 		=> $userid,
								'rank_name' 	=> $rank_name ,
								'achieved_date' => $achieved_date ,
								'banks'			=> $this->model_banks->select('*'),
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()
							];

					return $this->load->view('deposits/bankwire',$data);

				}
				else {

						redirect('login');
				}
	}

	public function deposit(){


		if( $this->is_logged_in() ) {

			$userid 	= 	$this->auth_user_id ;

			$this->load->model('model_deposits');

			$amount 		= 	$this->input->post('amount');
			$receipt_no		=	$this->input->post('receipt_no');
			$receipt		=	$this->input->post('image');
			$bank 			=	$this->input->post('bank');
			$paymode 		=	'Bankwire';
			$trans_no		=	'FD-'.$userid.'-'.rand(1000000,9000000);
			$date 			=	date('Y-m-d');


			 $config['upload_path']   = 'assets/photos/'; 
		     $config['allowed_types'] = 'jpg|png|pdf'; 
		     $config['max_size']      = 1024;

		     $this->load->library('upload', $config);

		   
			if( $amount >= 10 ) {


				      if ( ! $this->upload->do_upload('image')) {
				         	
				         	$this->session->set_flashdata('error', $this->upload->display_errors());
						  	redirect('deposits/bankwire','refresh');
				    

				      }else { 
				         	$data = $this->upload->data();
				        
				    
				         		//$this->model_users->update(['image'=>$data['file_name']],['id'=>$use_id]);

				         		$deposit_data =	[

				  						'user_id'			=> $userid,
				  						'transaction_no'	=> $trans_no,
				  						'receipt_no'		=> $receipt_no,
				  						'deposit_mode'		=> $paymode,
				  						'bank'				=> $bank,
				  						'deposit_date'		=> $date,
				  						'status'			=> 0,
				  						'receipt_image'		=> $data['file_name'],
				  						'amount'			=> $amount ,
				  						'remarks'			=> 'Waiting for admin verification'

				  					];

				         			if( $this->model_deposits->insert( $deposit_data) ) {

						  					$this->session->set_flashdata('msg', 'Fund deposit successfully submitted');
						  					redirect('deposits/bankwire','refresh');

						  			}
						  			else {

						  					$this->session->set_flashdata('error', 'Something went wrong');
						  					redirect('deposits/bankwire','refresh');
						  			}
				        	
				      } 		
			}
			else {

				$this->session->set_flashdata('error', 'Minimum deposit is $10');

				redirect('deposits/bankwire','refresh');

			}
		}
		else {

				redirect('login');
		}
	}

	public function bitcoin_deposit() {

		if($this->is_logged_in() ) {


					$this->load->model('model_banks');
					$this->load->model('model_deposits');
					$userid 		= "";
					$rank_name 		= "";
					$achieved_date 	= "";
					
					foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value ) {

								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;

						}

						$address = "" ;
                        
						 if($this->model_deposits->count_ref(['user_id' => $this->auth_user_id,'deposit_mode' =>'BTC','status' => 0,'amount' => 0]) > 0 ){

						 	 foreach ($this->model_deposits->select('receipt_no',['user_id' => $this->auth_user_id]) as $key => $value) {
						 	 	
						 	 		$address = $value->receipt_no;
						 	 
						 	 }

						 }
						 else {

						 	$my_xpub 			="xpub6BnvEDqyN5A6PbxkaHPajN9X63Ac4HWfvi4u8yztZcchqQXLSJ7YdR7Bv7vmJgop4rhJeeTSS2nATVuftpPXYh2UxrSmBVWJMqdpfh3hAeu";
							$my_api_key 	    = "3739630b-0c66-4dd9-b245-280779d9afa2";
							$email 				= 'louisesalas8.26@gmail.com';
							$use_id 			= $this->auth_user_id;
							$price_in_usd  		= 20;
							$amount 			= 20;
							$price_in_btc       = file_get_contents('https://blockchain.info/' . "tobtc?currency=USD&value=" . $price_in_usd);

				     		$callback_url		=  "https://immtradersclub.com/member/account/payment-notifss/".$use_id."-".$email."/".$price_in_btc;


							$resp 				= file_get_contents("https://api.blockchain.info/v2/receive?key=" . $my_api_key . "&callback=" . urlencode($callback_url) . "&xpub=" .$my_xpub);
							$response 			= json_decode($resp);

							$address  = $response->address;
							$date 	  = date('Y-m-d');
							$trans_no = 'FD-'.$userid.'-'.rand(1000000,9000000);

								$deposit_data =	[
						  						'user_id'			=> $this->auth_user_id,
						  						'transaction_no'	=> $trans_no,
						  						'receipt_no'		=> $address,
						  						'deposit_mode'		=> 'BTC',
						  						'bank'				=> 'n/a',
						  						'deposit_date'		=> $date,
						  						'status'			=> 0,
						  						'amount'			=> 0,
						  						'remarks'			=> 'Waiting for payment'
				  							];

				  					$this->model_deposits->insert($deposit_data);
						 }
						
					$data = [
								'userid' 		=> $userid,
								'rank_name' 	=> $rank_name ,
								'achieved_date' => $achieved_date ,
								'banks'			=> $this->model_banks->select('*'),
								'address'		=> $address
							];

					return $this->load->view('deposits/bitcoin',$data);

				}
				else {

						redirect('login');
				}
	}
	public function submit_bitcoin(){


		if($this->is_logged_in() ) {


					$this->load->model('model_banks');
					$this->load->model('model_deposits');

					$userid  = $this->auth_user_id;

					$amount  = round($this->input->post('usd'));


					if( $amount <= 10 ) {

						$this->model_deposits->update(
														[
															'amount'    => $amount ,
															'remarks'	=> 'Waiting for Admin Verification'
														],
														[
															'user_id' 		=> $userid,
															'deposit_mode'  => 'BTC',
															'status'		=> 0 ,
															'amount'		=> 0
														]
													);

						$this->session->set_flashdata('msg', 'Fund deposit successfully submitted');
						
				  		redirect('deposits/bitcoin','refresh');


					}

					else {

						$this->session->set_flashdata('error', 'Amount must be greater than or equal to $10');
						return redirect('deposits/bitcoin','refresh');
					}




		}

		else {

			 redirect('login');
		}
	}

	public function credit_debit () {
			
				
				if($this->is_logged_in() ) {


					$this->load->model('model_banks');

					$userid 		= "";
					$rank_name 		= "";
					$achieved_date 	= "";
					foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value ) {

								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;

						}

					$data = [
								'userid' 		=> $userid,
								'rank_name' 	=> $rank_name ,
								'achieved_date' => $achieved_date ,
								
							];

					return $this->load->view('deposits/creditdebit',$data);

				}
				else {

						redirect('login');
				}
	}

	public function check()
	{
		$this->is_logged_in();
		$this->load->model('model_deposits');
		$this->load->model('model_rwallet');

		$userid = $this->auth_user_id;
		//check whether stripe token is not empty
		if(!empty($this->input->post('stripeToken')))
		{
			//get token, card and user info from the form
			$token  = $this->input->post('stripeToken');
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$card_num =  $this->input->post('card_num');
			$card_cvc = $this->input->post('cvc');
			$card_exp_month =  $this->input->post('exp_month');
			$card_exp_year = $this->input->post('exp_month');
			
			//include Stripe PHP library
			require_once APPPATH."third_party/stripe/init.php";
			
			//set api key
			$stripe = array(
			  "secret_key"      => "sk_test_0C3fi4zRGsFaWTibVEgiOsW8",
			  "publishable_key" => "pk_test_iu1l1HPuUeXqmyB193QpHzM0"
			);
			
			\Stripe\Stripe::setApiKey($stripe['secret_key']);
			
			//add customer to stripe
			$customer = \Stripe\Customer::create(array(
				'email' => $email,
				'source'  => $token
			));
			
			//item information
			$itemName = "FUND DEPOSIT";
			$itemNumber = "FD-".$userid.'-'.date('Y-m-d').'-'.rand(1000000,9999999);
			$itemPrice = $this->input->post('amount').'00';
			$currency = "usd";
			$orderID = "FD-".$userid.'-'.date('Y-m-d').'-'.rand(1000000,9999999);
			
			//charge a credit or a debit card
			$charge = \Stripe\Charge::create(array(
				'customer' => $customer->id,
				'amount'   => $itemPrice,
				'currency' => $currency,
				'description' => $itemNumber,
				'metadata' => array(
					'item_id' => $itemNumber
				)
			));
			
			//retrieve charge details
			$chargeJson = $charge->jsonSerialize();

			//check whether the charge is successful
			if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)
			{
				//order details 
				$amount = $chargeJson['amount'];
				$balance_transaction = $chargeJson['balance_transaction'];
				$currency = $chargeJson['currency'];
				$status = $chargeJson['status'];
				$date = date("Y-m-d H:i:s");
			
				
				//insert tansaction data into the database

					$trans_no = 'FD-'.$userid.'-'.rand(1000000,9000000);
					$deposit_data =	[
						  				'user_id'			=> $this->auth_user_id,
						  				'transaction_no'	=> $trans_no,
						  				'receipt_no'		=> "FD-".$userid.'-'.date('Y-m-d').'-'.rand(1000000,9999999),
						  				'deposit_mode'		=> 'CARD',
						  				'bank'				=> 'n/a',
						  				'deposit_date'		=> date('Y-m-d'),
						  				'approved_date'		=> date('Y-m-d'),
						  				'status'			=> 1,
						  				'amount'			=> $this->input->post('amount'),
						  				'remarks'			=> 'Paid'
				  				];
				

				if($status =="succeeded") {

							if ($this->model_deposits->insert($deposit_data)) {

								foreach ($this->model_rwallet->select('*',['user_id' => $userid]) as $key => $value) {
									

									$this->model_rwallet->update(
																	[
																		'current_balance'	=> $value->current_balance + $this->input->post('amount'),
																		'previous_balance'	=> $value->current_balance
																	],
																	[
																		'user_id'	=> $userid
																	]

																);
								}

								$this->session->set_flashdata('msg', '<i class="fa fa-check"></i> Fund has been credited to R-Wallet !');
								return redirect('deposits/creditdebit-card','refresh');
	
							}
							else
							{
								$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Transaction Failed !');
								return redirect('deposits/creditdebit-card','refresh');
							}
				}
				else {

						$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Transaction Failed !');
						return redirect('deposits/creditdebit-card','refresh');
				}

			}
			else
			{
				
				$statusMsg = "";
				$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Invalid Token!');
				return redirect('deposits/creditdebit-card','refresh');

			}
		}
		else {

				$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Invalid Token!');
				return redirect('deposits/creditdebit-card','refresh');

		}
	}


public function history () {
			
				
				if($this->is_logged_in() ) {


					$this->load->model('model_banks');

					$userid 		= "";
					$rank_name 		= "";
					$achieved_date 	= "";
					foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value ) {

								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;

						}

					$data = [
								'userid' 		=> $userid,
								'rank_name' 	=> $rank_name ,
								'achieved_date' => $achieved_date ,
								
							];

					return $this->load->view('deposits/history',$data);

				}
				else {

						redirect('login');
				}
	}

	public function get_history() {

			if($this->is_logged_in()){

				$userid 	= $this->auth_user_id;
				$result 	= [];

				$this->load->model('model_deposits');

			
				$count = 0 ;
				foreach ($this->model_deposits->select('*',['user_id' => $userid],[],['deposit_id' =>'desc']) as $key => $value) {
							
						$count +=1;
						$mode = $value->deposit_mode;

						$image = "" ;


						if($mode =="Bankwire"){
							 
							 $image='<img src="'.base_url().'assets/photos/'.$value->receipt_image.'" size="200">';
						}
						else {

							 $image ="N/A";
						}


						array_push($result,
											[
												$count,
												$value->transaction_no,
												$value->receipt_no,
												$image,
												$value->amount,
												$value->deposit_mode,
												$value->deposit_date,
												$value->approved_date,
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

	public function search_deposits() {

		if( $this->is_logged_in() ) {

			$userid 	= $this->auth_user_id;

			$mode 		= $this->input->post('withdrawal_mode');
			$df 		= $this->input->post('date_from');
			$dt 		= $this->input->post('date_to');

			$result 	= [];

			$this->load->model('model_deposits');

			
			$count = 0 ;

			if(!empty($mode)) {

					if( !empty($df) && !empty($dt)) {
							foreach ($this->model_deposits->select('*',['user_id' => $userid,'deposit_mode' => $mode,'deposit_date >=' => $df,'deposit_date <=' > $dt],[],['deposit_id' =>'desc']) as $key => $value) {
							
									$count +=1;
									$mode = $value->deposit_mode;

									$image = "" ;


									if($mode =="Bankwire"){
											$image='<img src="'.base_url().'assets/photos/'.$value->receipt_image.'" size="200">';
									}
									else {

										$image ="N/A";
									}

									array_push($result,
														[
															$count,
															$value->transaction_no,
															$value->receipt_no,
															$image,
															$value->amount,
															$value->deposit_mode,
															$value->deposit_date,
															$value->approved_date,
															$value->remarks
														]
												);
							}
						}

						else {

								foreach ($this->model_deposits->select('*',['user_id' => $userid,'deposit_mode' => $mode]) as $key => $value) {
								
									$count +=1;
									$mode = $value->deposit_mode;

									$image = "" ;


									if($mode =="Bankwire"){
											$image='<img src="'.base_url().'assets/photos/'.$value->receipt_image.'" size="200">';
									}
									else {

										$image ="N/A";
									}

									array_push($result,
														[
															$count,
															$value->transaction_no,
															$value->receipt_no,
															$image,
															$value->amount,
															$value->deposit_mode,
															$value->deposit_date,
															$value->approved_date,
															$value->remarks
														]

												);
							}
						}

			}

			else {

						if( !empty($df) && !empty($dt)) {
							foreach ($this->model_deposits->select('*',['user_id' => $userid,'deposit_date >=' => $df,'deposit_date <=' > $dt]) as $key => $value) {
							
									$count +=1;
									$mode = $value->deposit_mode;

									$image = "" ;


									if($mode =="Bankwire"){
											$image='<img src="'.base_url().'assets/photos/'.$value->receipt_image.'" size="200">';
									}
									else {

										$image ="N/A";
									}

									array_push($result,
														[
															$count,
															$value->transaction_no,
															$value->receipt_no,
															$image,
															$value->amount,
															$value->deposit_mode,
															$value->deposit_date,
															$value->approved_date,
															$value->remarks
														]

												);
							}
						}

						else {
								foreach ($this->model_deposits->select('*',['user_id' => $userid]) as $key => $value) {
								
									$count +=1;
									$mode = $value->deposit_mode;

									$image = "" ;


									if($mode =="Bankwire"){
											$image='<img src="'.base_url().'assets/photos/'.$value->receipt_image.'" size="200">';
									}
									else {

										$image ="N/A";
									}

									array_push($result,
														[
															$count,
															$value->transaction_no,
															$value->receipt_no,
															$image,
															$value->amount,
															$value->deposit_mode,
															$value->deposit_date,
															$value->approved_date,
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