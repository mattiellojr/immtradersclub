<?php
defined('BASEPATH') or exit('No direct script access allowed');



class EwalletController  extends MY_Controller
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
					return $this->load->view('ewallet/ewallet',$data);
				}
				else {
					redirect('login');
				}
	}

	public function transfer_fund() {

    		if( $this->is_logged_in() ) {


    			//sender
    			$sender_id  = $this->auth_user_id ;
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
	    														'description'		=> '$' .$amount . ' Fund transferred by ' . $sender_name . ' to ' . $sender_name .'(EWallet TO RWallet)',
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
	    														'description'		=> '$' .$amount_nets .' Fund transferred by ' . $sender_name . ' to ' . $sender_name .'(EWallet TO RWallet)',
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
														
												  						redirect('mywallets/ewallet','refresh');


    														}
    														else {



    																$this->session->set_flashdata('error', '<i class="fa fa-warning"></i>Insufficient Balance.');
							
					  												redirect('mywallets/ewallet','refresh');


    														}	

    								}

    								else {

    										$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Minimum amount is $10');
							
					  							redirect('mywallets/ewallet','refresh');


    								}

		    			}
		    			else {


		    				$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> User not found');
		    				return redirect('mywallets/ewallet','refresh');

		    			}
    			}
    			else {

    						$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Incorrect Transaction password');
		    				return redirect('mywallets/ewallet','refresh');


    			}


    		}
    		else {

    			redirect('login');
    		}
    	}

    	public function withdraw() {


    		if( $this->is_logged_in() ) {

    			$userid 	=	$this->auth_user_id;
    			$amount 	=	$this->input->post('amount');
    			$trans_pwd  =	$this->input->post('t_code');
    			$mode 		=	$this->input->post('withdrawal_mode');
    			$invoice_no = 	rand(100000,9999999);
    			$date 		= 	date('Y-m-d');


    			$amount_net = $amount - ($amount * 0.05);

    			$this->load->model('model_ewallet');
    			$this->load->model('model_withdrawals');
    			$this->load->model('model_userbankdetails');
    			$this->load->model('model_transactionhistory');

    			if($this->model_users->count_ref(['user_id' => $userid,'trans_password' => $this->input->post('t_code')]) > 0 ) {

    				if($amount >=10 ) {

    				$ewallet = 0 ;
	    				foreach ($this->model_ewallet->select('current_balance',['user_id' => $userid]) as $key => $value) {									
	    							$ewallet = $value->current_balance ;
	    				}
	    				if( $amount <= $ewallet ) {


	    							$withdrawal_data 	= [
	    													'user_id'			=> $userid,
	    													'transaction_no'	=> 'WD-'.$date.'-'.$userid.'-'.$invoice_no,
	    													'amount_withdrawn'	=>	$amount,
	    													'amount_net'		=>	$amount_net,
	    													'withdrawal_mode'	=>	$mode,
	    													'withdrawal_date'	=>	$date,
	    													'remarks'			=>	'Pending'
	    													];


	    								$sender_data = [
	    														'type_id'	 		=> 2 ,
	    														'user_id'	 		=> $userid ,
	    														'transaction_no'	=>	'WD-'.$date.'-'.$userid.'-'.$invoice_no,
	    														'sender_id'  		=> $userid,
	    														'receiver_id'		=> $userid,
	    														'wallet_used'		=> 'ewallet',
	    														'credited_amount'	=> 0,
	    														'debited_amount'	=> $amount,
	    														'description'		=> '$' .$amount . ' Withdrawn from EWallet with ' .$mode. ' as withdrawal mode',
	    														'status'			=> 0,
	    														'remarks'			=> 'Withdrawal'
    														] ;

	    							if($mode == 'Bankwire') {

	    									$account_no  = "";

	    									foreach ($this->model_userbankdetails->select('*',['user_id' => $userid]) as $key => $banks) {
	    									 	$account_no = $banks->account_no;
	    									 } 
	    								if( empty( $account_no ) ) {

	    									$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Withdrawal Failed ! Bank Details Not Found. Please go to Account Settings > Banks to update your bank details');
			    							return redirect('mywallets/ewallet','refresh');

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
	    										$this->model_transactionhistory->insert($sender_data);

	    										$this->session->set_flashdata('msg', '<i class="fa fa-check"> </i>Withdrawal has been successfully submitted. Go to withdrawals section to view the status of your withdrawal');

			    								return redirect('mywallets/ewallet','refresh');

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
	    										$this->model_transactionhistory->insert($sender_data);

	    										$this->session->set_flashdata('msg', '<i class="fa fa-check"> </i>Withdrawal has been successfully submitted. Go to withdrawals section to view the status of your withdrawal');

			    								return redirect('mywallets/ewallet','refresh');

	    							}



	    				}
	    				else {
	    						$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> You have an Insufficient Balance in your E-Wallet');
			    				return redirect('mywallets/ewallet','refresh');
	    				}

    				}
    				else {
    						$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Minimum withdrawal isn $10');
			    			return redirect('mywallets/ewallet','refresh');

    				}
    				



    			}

    			else {


    				$this->session->set_flashdata('error', 'Incorrect Transaction password');
		    		return redirect('mywallets/ewallet','refresh');


    			}

    		}
    		else {

    			 return redirect('login');
    		}

    	}

}