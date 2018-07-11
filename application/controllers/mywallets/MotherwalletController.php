<?php
defined('BASEPATH') or exit('No direct script access allowed');



class MotherwalletController  extends MY_Controller
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

						foreach ($this->model_ewallet->select('current_balance',['user_id' => $userid]) as $key => $value) {
								
								$current_balance = $value->current_balance;
						}

					$data = [
								'userid' 		=> $userid,
								'rank_name' 	=> $rank_name ,
								'achieved_date' => $achieved_date ,
								'current_balance'		=> $current_balance,
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()

							];		
					return $this->load->view('motherwallet/wallet',$data);
				}
				else {
					redirect('login');
				}
	}
	public function setupAccount() {

			if( $this->is_logged_in() ) {

					$this->load->model('model_mywallets');

					$current_user_id 	=	$this->auth_user_id;
					$sub_account_id 	=	$this->input->post('userid');
					$sub_username_id 	=	$this->input->post('username');
					$sub_t_code 		=	$this->input->post('t_code');
					$c_t_code 			=	$this->input->post('c_t_code');

	
					if($this->model_users->count_ref( [ 'user_id' => $current_user_id, 'trans_password' => $c_t_code ] ) > 0){


						if( $this->model_users->count_ref( [ 'user_id' => $sub_account_id, 'trans_password' => $sub_t_code ,'username' => $sub_username_id] ) > 0 ){

							
							if($this->model_mywallets->count_ref( [ 'sub_account_user_id' => $sub_account_id ,'user_id' => $current_user_id ] )  <= 0 ){

							
									$sub_account_data 		=	[

																	'user_id' 				=>  $current_user_id,
																	'sub_account_user_id'	=>	$sub_account_id
																];


									$this->model_mywallets->insert($sub_account_data);

									$this->session->set_flashdata('msg', 'Success !  Account has been added to your motherwallet
										.');
									redirect('mywallets/mother-wallet','refresh');

							}
							else {

								$this->session->set_flashdata('error', 'Failed ! Record already exist.');

								redirect('mywallets/mother-wallet','refresh');
							}
						}
						else {

								$this->session->set_flashdata('error', 'Sub account details did not match in our record. Please check the details and try again.');

									redirect('mywallets/mother-wallet','refresh');

						}


					}
					else {
						$this->session->set_flashdata('error', 'Wrong transaction password');

						redirect('mywallets/mother-wallet','refresh');


					}

			}
			else {
					redirect('login');
			}

	}
 
	 public function subaccount_details() {


	 	if( $this->is_logged_in() ){

	 				$user_id = $this->auth_user_id;

	 				$this->load->model('model_mywallets');



	 					$result = [] ;
	 					$count =  0 ;
	 					
	 					foreach ($this->model_mywallets->query("SELECT mywallets.wallet_id,mywallets.sub_account_user_id as user_id,rwallet.current_balance as rwallet_balance,ewallet.current_balance as ewallet_balance,users.username FROM `mywallets` JOIN ewallet ON mywallets.sub_account_user_id=ewallet.user_id JOIN rwallet ON mywallets.sub_account_user_id=rwallet.user_id JOIN users ON mywallets.sub_account_user_id=users.user_id WHERE mywallets.user_id='".$user_id."'")->result() as $key => $value) {
	 						

	 						$count +=1;
	 						array_push($result,


	 										//mywallets/mother-wallet/rwallet

	 											[
	 												$count,
	 												$value->user_id . '-' .$value->username,
	 												$value->rwallet_balance,
	 												$value->ewallet_balance ,
	 												"<a  href='".site_url()."mywallets/mother-wallet/rwallet/".$value->user_id."' class='btn btn-info btn-xs'><i class='fa fa-forward'> </i>RWALLET</a><a  href='".site_url()."mywallets/mother-wallet/ewallet/".$value->user_id."' class='btn btn-info btn-xs'><i class='fa fa-forward'> </i>EWALLET</a>"
	 											]
	 										);
	 					}


	 					$data = array(
										"sEcho" 				=> 1,
										"iTotalRecords" 		=> count($result),
										"iTotalDisplayRecords" 	=> count($result),
										"aaData"				=>	$result
									); 

					echo json_encode($data);


	 	}
		else {
				redirect('login');
			}
	 	}

	public function ewallet() {

		if($this->is_logged_in() ) {

					$userid 		= " ";
					$rank_name 		= " ";
					$achieved_date 	= "";
					$current_balance = 0;

					$this->load->model('model_cryptowallet');
					$this->load->model('model_ewallet');

					$wallet_user = $this->uri->segment(4);

					
					
						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}

						$this->load->model('model_mywallets');

						if($this->model_mywallets->count_ref(['user_id' => $userid ,'sub_account_user_id' => $wallet_user]) > 0) {

							foreach ($this->model_ewallet->select('current_balance',['user_id' => $wallet_user]) as $key => $value) {
								$current_balance = $value->current_balance;
							}

						$data = [
											'userid' 		=> $userid,
											'rank_name' 	=> $rank_name ,
											'achieved_date' => $achieved_date ,
											'current_balance'		=> $current_balance,
											'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()

										];		
								return $this->load->view('motherwallet/ewallet',$data);
							}

						

						else {

									$this->session->set_flashdata('error', 'You dont have permission to success the wallet');
														
									redirect('mywallets/mother-wallet','refresh');


						}
					}
						
				else {
					redirect('login');
				}
	}
	public function rwallet() {


			if($this->is_logged_in() ) {

					$userid 		= " ";
					$rank_name 		= " ";
					$achieved_date 	= "";
					$current_balance = 0;

					$this->load->model('model_cryptowallet');
					$this->load->model('model_rwallet');

					$wallet_user = $this->uri->segment(4);

					
						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}


						$this->load->model('model_mywallets');

						if($this->model_mywallets->count_ref(['user_id' => $userid ,'sub_account_user_id' => $wallet_user]) > 0) {

							foreach ($this->model_rwallet->select('current_balance',['user_id' => $wallet_user]) as $key => $value) {
									$current_balance = $value->current_balance;
							}

						$data = [
									'userid' 				=> $userid,
									'rank_name' 			=> $rank_name ,
									'achieved_date' 		=> $achieved_date ,
									'current_balance'		=> $current_balance,
									'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()
								];		

						return $this->load->view('motherwallet/rwallet',$data);

					}

					else {

							$this->session->set_flashdata('error', 'You dont have permission to success the wallet');
														
									redirect('mywallets/mother-wallet','refresh');

					}
				}

				else {

					redirect('login');

			}
	}
	public function transfer_fund_ewallet() {

    		if( $this->is_logged_in() ) {


    			//sender
    			$sender_id  = $this->input->post('sender_id') ;
    			$sender_name = "" ;

    			$amount = $this->input->post('amount');

    			$this->load->model('model_ewallet');
    			$this->load->model('model_rwallet');
    			$this->load->model('model_transactionhistory');

    			foreach ($this->model_users->query("Select users.user_id,userinfo.first_name,userinfo.last_name from users JOIN userinfo ON users.user_id=userinfo.user_id WHERE users.user_id='".$sender_id."'")->result() as $key => $value) {
    				
    				$sender_name = $value->first_name .' '. $value->last_name;
    			}

    			//receiver
    			$receiver   = $this->input->post('receiver');
    			$receiver_id = "" ;
    			$receiver_name = "";
    			$invoice_no = rand(100000,9999999);


    			foreach ($this->model_users->query("Select users.user_id,userinfo.first_name,userinfo.last_name from users JOIN userinfo ON users.user_id=userinfo.user_id WHERE users.user_id='".$receiver."' OR users.email='".$receiver."'")->result() as $key => $value) {
    				
    				$receiver_id = $value->user_id;
    				$receiver_name = $value->first_name . ' ' . $value->last_name;
    			}

    			if($this->model_users->count_ref(['user_id' => $sender_id,'trans_password' => $this->input->post('t_code')]) > 0 ) {
    					if( !empty( $sender_id ) ) {

  

    								if( $amount >= 10 ) {

    										$sender_data = [
	    														'type_id'	 		=> 7 ,
	    														'user_id'	 		=> $sender_id ,
	    														'transaction_no'	=>	'IMM-'.$sender_id.'-'.$invoice_no ,
	    														'sender_id'  		=> $sender_id,
	    														'receiver_id'		=> $sender_id,
	    														'wallet_used'		=> 'ewallet',
	    														'credited_amount'	=> 0,
	    														'debited_amount'	=> $amount,
	    														'description'		=> '$' .$amount . ' Fund transferred by ' . $sender_name . ' to ' . $sender_name .'(EWallet TO RWallet) using the mother wallet account: ' .$this->auth_user_id,
	    														'status'			=> 0,
	    														'remarks'			=> 'Fund Transfer'
    														] ;

    										$amount_nets  = $amount - ($amount * 0.05);
    										$receiver_data = [
	    														'type_id'	 		=> 7 ,
	    														'user_id'	 		=> $sender_id,
	    														'sender_id'  		=> $sender_id,
	    														'receiver_id'		=> $sender_id,
	    														'transaction_no'	=>	'IMM-'.$sender_id.'-'.$invoice_no ,
	    														'wallet_used'		=> 'ewallet',
	    														'credited_amount'	=> $amount_nets,
	    														'debited_amount'	=> 0,
	    														'description'		=> '$' .$amount_nets .' Fund transferred by ' . $sender_name . ' to ' . $sender_name .'(EWallet TO RWallet) using the mother wallet account: ' .$this->auth_user_id,
	    														'status'			=> 0,
	    														'remarks'			=> 'Fund Transfer '
    														] ;


    														$ewallet = 0 ;
    														foreach ($this->model_ewallet->select('current_balance',['user_id' => $sender_id]) as $key => $value) {
    																
    																$ewallet = $value->current_balance ;
    														}
    														if( $amount <= $ewallet ) {

    																//sender
					    													foreach ($this->model_ewallet->select('current_balance',['user_id' => $sender_id]) as $key => $value) {


					    														$senderbalance = ($value->current_balance ) - $amount ;


					    														
					    														$this->model_ewallet->update(
					    																				[
					    																					'previous_balance' => $value->current_balance ,
					    																					'current_balance'  => $senderbalance
					    																				],
					    																				[
					    																					'user_id' => $sender_id
					    																				]
					    																			);
					    														
					    														$this->model_transactionhistory->insert($sender_data);
							    												}
							    												
							    												//receiver

							    												$amount_net  = $amount - ($amount * 0.05);
							    												foreach ($this->model_rwallet->select('current_balance',['user_id' => $sender_id]) as $key => $value) {

							    													$receiver_balance = ($value->current_balance) + $amount_net;
							    													$this->model_rwallet->update(
							    																				[
							    																					'previous_balance' => $value->current_balance,
							    																					'current_balance'  => $receiver_balance
							    																				],
							    																				[
							    																					'user_id' => $sender_id
							    																				]
							    																			);
							    													$this->model_transactionhistory->insert($receiver_data);

							    												}
							    												
							    										$this->session->set_flashdata('msg', 'Fund has been transferred');
														
												  						redirect('mywallets/mother-wallet/ewallet/'.$sender_id,'refresh');


    														}
    														else {



    																$this->session->set_flashdata('error', '<i class="fa fa-warning"></i>Insufficient Balance.');
							
					  												redirect('mywallets/mother-wallet/ewallet/'.$sender_id,'refresh');


    														}	

    								}

    								else {

    										$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Minimum amount is $10');
							
					  							redirect('mywallets/mother-wallet/ewallet/'.$sender_id,'refresh');


    								}

		    			}
		    			else {


		    				$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> User not found');
		    				return redirect('mywallets/mother-wallet/ewallet/'.$sender_id,'refresh');

		    			}
    			}
    			else {

    						$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Incorrect Transaction password');
		    				return redirect('mywallets/mother-wallet/ewallet/'.$sender_id,'refresh');


    			}


    		}
    		else {

    			redirect('login');
    		}
    	}

    	public function withdraw() {


    		if( $this->is_logged_in() ) {

    			$userid 	=	$this->input->post('user_id');
    			$amount 	=	$this->input->post('amount');
    			$trans_pwd  =	$this->input->post('t_code');
    			$mode 		=	$this->input->post('withdrawal_mode');
    			$invoice_no = 	rand(100000,9999999);
    			$date 		= 	date('Y-m-d');


    			$amount_net = $amount - ($amount * 0.05);

    			$this->load->model('model_ewallet');
    			$this->load->model('model_withdrawals');
    			$this->load->model('model_userbankdetails');

    			if($this->model_users->count_ref(['user_id' => $userid,'trans_password' => $this->input->post('t_code')]) > 0 ) {

    				if($amount >=10 ) {

    				$ewallet = 0 ;
	    				foreach ($this->model_ewallet->select('current_balance',['user_id' => $userid]) as $key => $value) {									
	    							$ewallet = $value->current_balance ;
	    				}
	    				if( $amount <= $ewallet ) {


	    							$withdrawal_data 	= [
	    													'user_id'			=> $userid,
	    													'transaction_no'	=> 'WD-'.$date.'-'.$userid.'-'.$invoice_no.'-'.$this->auth_user_id,
	    													'amount_withdrawn'	=>	$amount,
	    													'amount_net'		=>	$amount_net,
	    													'withdrawal_mode'	=>	$mode,
	    													'withdrawal_date'	=>	$date,
	    													'remarks'			=>	'Pending'
	    													];

	    							if($mode == 'Bankwire') {

	    									$account_no  = "";

	    									foreach ($this->model_userbankdetails->select('*',['user_id' => $userid]) as $key => $banks) {
	    									 	$account_no = $banks->account_no;
	    									 } 
	    								if( empty( $account_no ) ) {

	    									$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Withdrawal Failed ! Bank Details Not Found. Please go to Account Settings > Banks to update your bank details');
			    							return redirect('mywallets/mother-wallet/ewallet/'.$userid,'refresh');

	    								}

	    								else {

	    										$userbalance = $ewallet -  $amount;

	    										$this->model_ewallet->update(
					    														[
					    															'previous_balance' => $ewallet ,
					    															'current_balance'  => $userbalance
					    														],
					    														[
					    															'user_id' => $userid
					    														]
					    													);

	    										$this->model_withdrawals->insert($withdrawal_data);

	    										$this->session->set_flashdata('msg', '<i class="fa fa-check"> </i>Withdrawal has been successfully submitted. Go to withdrawals section to view the status of your withdrawal');

			    								return redirect('mywallets/mother-wallet/ewallet/'.$userid,'refresh');

	    								}

	    							}
	    							else {

	    									$userbalance = $ewallet -  $amount;

	    										$this->model_ewallet->update(
					    														[
					    															'previous_balance' => $ewallet ,
					    															'current_balance'  => $userbalance
					    														],
					    														[
					    															'user_id' => $userid
					    														]
					    													);

	    										$this->model_withdrawals->insert($withdrawal_data);

	    										$this->session->set_flashdata('msg', '<i class="fa fa-check"> </i>Withdrawal has been successfully submitted. Go to withdrawals section to view the status of your withdrawal');

			    								return redirect('mywallets/mother-wallet/ewallet/'.$userid,'refresh');

	    							}



	    				}
	    				else {
	    						$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> You have an Insufficient Balance in your E-Wallet');
			    				return redirect('mywallets/mother-wallet/ewallet/'.$userid,'refresh');
	    				}

    				}
    				else {
    						$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Minimum withdrawal isn $10');
			    			return redirect('mywallets/mother-wallet/ewallet/'.$userid,'refresh');

    				}
    				



    			}

    			else {


    				$this->session->set_flashdata('error', 'Incorrect Transaction password');
		    		return redirect('mywallets/mother-wallet/ewallet/'.$userid,'refresh');


    			}

    		}
    		else {

    			 return redirect('login');
    		}

    	}


    	public function searchUser(){
    
    			$user 		= $this->input->post('user');
    			$data 		= [] ;
    			$email 		= "" ;
    				
    			if(	$user !=""	) {
    
    				if($this->model_users->query("Select users.email,userinfo.first_name,userinfo.last_name,users.user_id from users  JOIN userinfo ON users.user_id=userinfo.user_id where users.user_id='$user' OR users.email='$user' ")->result()) {
    
    						foreach ($this->model_users->query("Select users.email,userinfo.first_name,userinfo.last_name,users.user_id from users  JOIN userinfo ON users.user_id=userinfo.user_id where users.user_id='$user' OR users.email='$user' ")->result() as $key => $value) {
    							$email = $value->email;
    							
    							array_push($data,
    							
    											[
    												'email' 		=>	$value->email,
    												'user_id' 		=>	$value->user_id,
    												'name' 			=> 	$value->first_name . ' ' .$value->last_name,
    											]
    									);
    						}
    				}
    				else {
    								array_push($data,
    												[
    													'email' 	=> 'User not found !',
    													'name' 		=> 	'',
    													'user_id' 	=> ''
    												]
    										);
    				}
    
    			}
    			else {
    
    					array_push($data,
    									    [
    										    'email' => 'Please enter receiver !',
    											'name' 	=> 	'',
    											'user_id' => ''
    										]
    									);
    			}
    				echo json_encode($data);			
    	}


    	public function transfer_fund_rwallet() {

    		if( $this->is_logged_in() ) {


    			//sender
    			$sender_id   = $this->input->post('sender_id') ;
    			$sender_name = "" ;

    			$amount = $this->input->post('rwallet_amount');

    			$this->load->model('model_rwallet');
    			$this->load->model('model_transactionhistory');

    			foreach ($this->model_users->query("Select users.user_id,userinfo.first_name,userinfo.last_name from users JOIN userinfo ON users.user_id=userinfo.user_id WHERE users.user_id='".$sender_id."'")->result() as $key => $value) {
    				
    				$sender_name = $value->first_name .' '. $value->last_name;
    			}

    			//receiver
    			$receiver   = $this->input->post('receiver');
    			$receiver_id = "" ;
    			$receiver_name = "";



    			foreach ($this->model_users->query("Select users.user_id,userinfo.first_name,userinfo.last_name from users JOIN userinfo ON users.user_id=userinfo.user_id WHERE users.user_id='".$receiver."' OR users.email='".$receiver."'")->result() as $key => $value) {
    				
    				$receiver_id = $value->user_id;
    				$receiver_name = $value->first_name . ' ' . $value->last_name;
    			}

    			if($this->model_users->count_ref(['user_id' => $sender_id,'trans_password' => $this->input->post('confirm_t_code')]) > 0 ) {
    					if( !empty( $receiver_id ) ) {

    						if( $receiver_id != $sender_id ) {

    								if( $amount >= 10 ) {

    										$sender_data = [
	    														'type_id'	 		=> 7 ,
	    														'transaction_no'	=> 'FT'.'-'.$this->auth_user_id.rand(100000,999999),
	    														'user_id'	 		=> $sender_id ,
	    														'sender_id'  		=> $sender_id,
	    														'receiver_id'		=> $receiver_id,
	    														'wallet_used'		=> 'rwallet',
	    														'credited_amount'	=> 0,
	    														'debited_amount'	=> $amount,
	    														'description'		=> '$' .$amount . ' Fund transferred by ' . $sender_name . ' to ' . $receiver_name ,
	    														'status'			=> 0,
	    														'remarks'			=> 'Fund Transfer'
    														] ;

    										$receiver_data = [
	    														'type_id'	 		=> 7 ,
	    														'transaction_no'	=> 'FT'.'-'.$this->auth_user_id.rand(100000,999999),
	    														'user_id'	 		=> $receiver_id ,
	    														'sender_id'  		=> $sender_id,
	    														'receiver_id'		=> $receiver_id,
	    														'wallet_used'		=> 'rwallet',
	    														'credited_amount'	=> $amount,
	    														'debited_amount'	=> 0,
	    														'description'		=> '$' .$amount .' Fund transferred by ' . $sender_name . ' to ' . $receiver_name ,
	    														'status'			=> 0,
	    														'remarks'			=> 'Fund Transfer'
    														] ;


    														$rwallet = 0 ;
    														foreach ($this->model_rwallet->select('current_balance',['user_id' => $sender_id]) as $key => $value) {
    																
    																$rwallet = $value->current_balance ;
    														}
    														if( $amount <= $rwallet ) {


    																//sender
					    													foreach ($this->model_rwallet->select('current_balance',['user_id' => $sender_id]) as $key => $value) {


					    														$senderbalance = ($value->current_balance ) - $amount ;


					    														
					    														$this->model_rwallet->update(
					    																				[
					    																					'previous_balance' => $value->current_balance ,
					    																					'current_balance'  => $senderbalance
					    																				],
					    																				[
					    																					'user_id' => $sender_id
					    																				]
					    																			);
					    														
					    														$this->model_transactionhistory->insert($sender_data);
							    												}
							    												
							    												//receiver
							    												foreach ($this->model_rwallet->select('current_balance',['user_id' => $receiver_id]) as $key => $value) {

							    													$receiver_balance = ($value->current_balance) + $amount;
							    													$this->model_rwallet->update(
							    																				[
							    																					'previous_balance' => $value->current_balance,
							    																					'current_balance'  => $receiver_balance
							    																				],
							    																				[
							    																					'user_id' => $receiver_id
							    																				]
							    																			);
							    												$this->model_transactionhistory->insert($receiver_data);

							    												}
							    												
							    										$this->session->set_flashdata('msg', 'Fund has been transferred');
														
												  						redirect('mywallets/mother-wallet/rwallet/'.$sender_id,'refresh');


    														}
    														else {



    																$this->session->set_flashdata('error', 'Insufficient Balance.');
							
					  												
												  						redirect('mywallets/mother-wallet/rwallet/'.$sender_id,'refresh');

    														}	
    								}

    								else {

    										$this->session->set_flashdata('error', 'Minimum amount is $10');
							
					  							
												  						redirect('mywallets/mother-wallet/rwallet/'.$sender_id,'refresh');

    								}
    								

    						}
    						else {
    								$this->session->set_flashdata('error', 'Not Allowed to transfer');
		    						
												  						redirect('mywallets/mother-wallet/rwallet/'.$sender_id,'refresh');

    						}
	

		    			}
		    			else {


		    				$this->session->set_flashdata('error', 'User not found');
		    				
												  						redirect('mywallets/mother-wallet/rwallet/'.$sender_id,'refresh');

		    			}
    			}
    			else {


    						$this->session->set_flashdata('error', 'Incorrect Transaction password');
		    				
												  						redirect('mywallets/mother-wallet/rwallet/'.$sender_id,'refresh');


    			}

    		


    		}
    		else {

    			redirect('login');
    		}
    	}


}