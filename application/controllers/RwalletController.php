<?php
defined('BASEPATH') or exit('No direct script access allowed');



class RwalletController  extends MY_Controller
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
					$this->load->model('model_rwallet');

					
						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}

						foreach ($this->model_rwallet->select('current_balance',['user_id' => $userid]) as $key => $value) {
								$current_balance = $value->current_balance;
						}

					$data = [
								'userid' 				=> $userid,
								'rank_name' 			=> $rank_name ,
								'achieved_date' 		=> $achieved_date ,
								'current_balance'		=> $current_balance,
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()
							];		

					return $this->load->view('rwallet/rwallet',$data);
				}

				else {

					redirect('login');

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


    	public function transfer_fund() {

    		if( $this->is_logged_in() ) {


    			//sender
    			$sender_id   = $this->auth_user_id ;
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
														
												  						redirect('mywallets/rwallet','refresh');


    														}
    														else {



    																$this->session->set_flashdata('error', 'Insufficient Balance.');
							
					  												redirect('mywallets/rwallet','refresh');

    														}	
    								}

    								else {

    										$this->session->set_flashdata('error', 'Minimum amount is $10');
							
					  							redirect('mywallets/rwallet','refresh');


    								}
    								

    						}
    						else {
    								$this->session->set_flashdata('error', 'Not Allowed to transfer');
		    						return redirect('mywallets/rwallet','refresh');

    						}
	

		    			}
		    			else {


		    				$this->session->set_flashdata('error', 'User not found');
		    				return redirect('mywallets/rwallet','refresh');

		    			}
    			}
    			else {


    						$this->session->set_flashdata('error', 'Incorrect Transaction password');
		    				return redirect('mywallets/rwallet','refresh');


    			}

    		


    		}
    		else {

    			redirect('login');
    		}
    	}



}