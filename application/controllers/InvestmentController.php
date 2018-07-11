<?php
defined('BASEPATH') or exit('No direct script access allowed');



class InvestmentController  extends MY_Controller
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

		$this->load->model('model_userincomes');
		

	}

	public function index () {
			
				
				if( $this->is_logged_in() ) {

					$this->load->model('model_rwallet');
					$this->load->model('model_packages');

						$userid  			= "" ;
						$rank_name 			= "" ;
						$achieved_date 		= "";
						$current_balance 	= 0 ;

						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}

						foreach ($this->model_rwallet->select('current_balance',['user_id' => $userid]) as $key => $value) {
								
								$current_balance = $value->current_balance;
						}

					$data = [
								'userid' 			=> $userid,
								'rank_name' 		=> $rank_name ,
								'achieved_date' 	=> $achieved_date ,
								'current_balance'	=> $current_balance ,
								'packages'			=> $this->model_packages->select('*'),
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()

							];

					return $this->load->view('investmentpackage/investmentpackage',$data);
				}
				else {
					redirect('login');
				}
	}




	public function referral_commision($referral_id, $user_id ,$rank, $amount , $invoice_no  ) {

		$percentage_commission = 0 ;

		$date 	= date('Y-m-d');


		if( $rank == 2 ) {

			$percentage_commission = 3 ;

		}
		else if( $rank == 3 ) {

			$percentage_commission = 5 ;

		}
		else if( $rank == 4 ) {

			$percentage_commission = 7 ;

		}
		else if( $rank == 5 ) {

			$percentage_commission = 8 ;

		}
		else if( $rank == 6 ) {

			$percentage_commission = 10 ;

		}
		else if( $rank == 7 ) {

			$percentage_commission = 10 ;

		}
		else {
			 $percentage_commission = 0 ;
		}


		$commission =  $percentage_commission * ( $amount / 100 ) ;

		if( $commission != 0 ) {

			$current_balance = 0 ;
			
		

			foreach ($this->model_ewallet->select('current_balance',['user_id' => $referral_id]) as $key => $value) {

				$current_balance = $value->current_balance;
			
				
			}


			$new_balance 	= $current_balance + $commission ;

			$this->model_ewallet->update(
											[ 
												'current_balance'	=>	$new_balance,
												'previous_balance'	=> 	$current_balance,
											],
											[
												'user_id'			=>	$referral_id

											]
										);

			$transaction_data = [
									'transaction_no'	=>	$invoice_no ,
									'type_id'			=>	6 ,
									'user_id'			=>	$referral_id,
									'sender_id'			=>	$user_id,
									'receiver_id'		=>	$referral_id,
									'wallet_used'		=>	'ewallet',
									'credited_amount'	=>	$commission,
									'debited_amount'	=>	0,
									'description'		=>	'Earn Referral Bonus/Commission from ' . $user_id . ' for package purchase with an amount of $' . $amount,
									'remarks'			=> 'Referral Bonus',
									'status'			=> 0


								];


				foreach ($this->model_userincomes->select('referral_income',['user_id' => $referral_id]) as $key => $value) {

							$this->model_userincomes->update([

																	'referral_income'  => $commission + $value->referral_income

															],
															[
																'user_id'		=> $referral_id

															]
														);
				}

				$this->model_transactionhistory->insert($transaction_data);



		}

			$this->unilevel_commission( $user_id , $amount , $invoice_no );

	}

	public function unilevel_commission( $user_id , $amount , $invoice_no  ) {

			$unilevel_commission_percetage = 0 ; 
			$level = 0;
			$referral_id = "";

			$this->load->model('model_matrixdownline');

			foreach ($this->model_matrixdownline->query("SELECT referral_id,level FROM matrixdownline WHERE downline_id='".$user_id."' AND level < 22 ")->result() as $key => $val) {

						$level = $val->level;
						$referral_id = $val->referral_id;
				
				foreach ( $this->model_users->select('rank_id',['upline_id' => $val->referral_id]) as $key => $rank ) {
						
						

						$rank = $rank->rank_id ;
					//CADET

					if ( $rank == 2 ) {

							
							if(  $level == 2 ) {

								$unilevel_commission_percetage = 2  ;

							}

							else if(  $level == 3 ) {

								$unilevel_commission_percetage = 1  ;

							}

					}

					//RISING STAR
					else if ( $rank == 3) {

							
							if( $level == 2 ) {

								$unilevel_commission_percetage = 2  ;

							}

							else if( $level == 4 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 5 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 6 ) {

								$unilevel_commission_percetage = 1  ;

							}
					}
					
					//FLYING STAR

					else if ( $rank == 4 ) {

							
							 if( $level == 2 ) {

								$unilevel_commission_percetage = 2  ;

							}
							else if( $level == 3 ) {

								$unilevel_commission_percetage = 2  ;

							}
							else if( $level == 4 ) {

								$unilevel_commission_percetage = 1  ;

							}

							else if( $level == 5 ) {

								$unilevel_commission_percetage = 1  ;

							}

							else if( $level == 6 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 7 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 8 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 9 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 10 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
					}
					//CHAMPION

					else if ( $rank == 5 ) {

						 	if( $level == 2 ) {

								$unilevel_commission_percetage = 2  ;

							}
							else if( $level == 3 ) {

								$unilevel_commission_percetage = 2  ;

							}
							else if( $level == 4 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 5 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 6 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 7 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 8 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 9 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 10 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 11 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 12 ) {

								$unilevel_commission_percetage = 1  ;

							}

							else if( $level == 13 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 14 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
					}

					//ELITE

					else if ( $rank == 6 ) {

							 if( $level == 2 ) {

								$unilevel_commission_percetage = 3  ;

							}
							else if( $level == 3 ) {

								$unilevel_commission_percetage = 2  ;

							}
							else if( $level == 4 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 5 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 6 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 7 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 8 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 9 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 10 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 11 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 12 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 13 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 14 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 15 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 16 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 17 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 18 ) {

								$unilevel_commission_percetage = 0.5  ;

							}

					}
					//CO FOUNDER
					else if ( $rank == 7 ) {

							 if( $level == 2 ) {

								$unilevel_commission_percetage = 3  ;

							}
							else if( $level == 3 ) {

								$unilevel_commission_percetage = 2  ;

							}
							else if( $level == 4 ) {

								$unilevel_commission_percetage = 2  ;

							}
							else if( $level == 5 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 6 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 7 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 8 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 9 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 10 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 11 ) {

								$unilevel_commission_percetage = 1  ;

							}
							else if( $level == 12 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 13 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 14 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 15 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 16 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 17 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 18 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 19 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 20 ) {

								$unilevel_commission_percetage = 0.5  ;

							}
							else if( $level == 21 ) {

								$unilevel_commission_percetage = 0.5  ;

							}

					}

				}

					$commission =  $unilevel_commission_percetage * ( $amount / 100 ) ;

					if( $commission != 0 ) {

						$current_balance = 0 ;
						
					

						foreach ($this->model_ewallet->select('current_balance',['user_id' => $referral_id]) as $key => $value) {

							$current_balance = $value->current_balance;
						
							
						}


						$new_balance 	= $current_balance + $commission ;

						$this->model_ewallet->update(
														[ 
															'current_balance'	=>	$new_balance,
															'previous_balance'	=> 	$current_balance,
														],
														[
															'user_id'			=>	$referral_id
														]
													);

						$transaction_data = [
												'transaction_no'	=>	'IMM-'.$user_id.'-'.$invoice_no ,
												'type_id'			=>	4 ,
												'user_id'			=>	$referral_id,
												'sender_id'			=>	$user_id,
												'receiver_id'		=>	$referral_id,
												'wallet_used'		=>	'ewallet',
												'credited_amount'	=>	$commission,
												'debited_amount'	=>	0,
												'description'		=>	'Earn Unilevel Bonus/Commission from ' . $user_id . ' for package purchase with an amount of $' . $amount ,
												'remarks'			=> 'Unilevel ' . $level . ' Bonus ',
												'status'			=> 0


											];


								foreach ($this->model_userincomes->select('level_income',['user_id' => $referral_id]) as $key => $value) {
									
											$this->model_userincomes->update([

																				'level_income'  => $commission + $value->level_income
																			],
																			[
																				'user_id'		=> $referral_id

																			]
																		);
								}

							$this->model_transactionhistory->insert($transaction_data);
					}
			}

	}

	public function rank_upgrade( $user_id ) {



			$this->load->model('model_rankachievement');

			$total_purchase  =  0 ;
			$rank = 0;

			foreach ($this->model_portfolio->query("SELECT SUM(portfolio.portfolio_amount) as total ,users.rank_id as rank FROM portfolio JOIN users ON portfolio.user_id=users.user_id WHERE portfolio.user_id='".$user_id."'")->result() as $key => $value) {
				
				$total_purchase 	= $value->total ;
				$rank 				= $value->rank;
			}


			if( $total_purchase >= 15000 &&  $rank < 5) {


				
				 		$rankachievement_data = [

				 									'user_id'		=> $user_id,
				 									'rank_id'		=> 5,
				 									'achieved_date' => date('Y-m-d')
				 								];

				 		$this->model_rankachievement->insert($rankachievement_data);

				 		 $this->model_users->update(['rank_id' => 5],['user_id' => $user_id]);
				

			}

			else if( $total_purchase >= 5000 && $rank < 4) {
				
				 		$rankachievement_data = [

				 									'user_id'		=> $user_id,
				 									'rank_id'		=> 4,
				 									'achieved_date' => date('Y-m-d')
				 								];

				 		$this->model_rankachievement->insert($rankachievement_data);

				 		 $this->model_users->update(['rank_id' => 4],['user_id' => $user_id]);
				

			}

			else if( $total_purchase >= 500 &&  $rank < 3) {

				
				 		$rankachievement_data = [

				 									'user_id'		=> $user_id,
				 									'rank_id'		=> 3,
				 									'achieved_date' => date('Y-m-d')
				 								];

				 		$this->model_rankachievement->insert($rankachievement_data);

				 		 $this->model_users->update(['rank_id' => 3],['user_id' => $user_id]);
				

			}

			else if( $total_purchase >= 10 && $rank < 2) {

				 		$rankachievement_data = [

				 									'user_id'		=> $user_id,
				 									'rank_id'		=> 2,
				 									'achieved_date' => date('Y-m-d')
				 								];

				 		$this->model_rankachievement->insert($rankachievement_data);

				 		 $this->model_users->update(['rank_id' => 2],['user_id' => $user_id]);
				

			}



	}

	public function purchase() {

			if( $this->is_logged_in() ) {


				$userid 	=	$this->auth_user_id;
				$amount 	=	$this->input->post('rwallet_amount');
				$trans_pwd 	=	$this->input->post('confirm_t_code');
				$package 	=	$this->input->post('package');

				$invoice_no = rand(0000000001,9000000000);
	    		$start 		= date('Y-m-d');
	    		$end 		= date('Y-m-d', strtotime('+36 months'));

	    		$transaction_no = 'PF-'.$userid.'-'.$invoice_no;


	    		$current_balance 	=	0	;

	    		foreach ($this->model_rwallet->select('current_balance',['user_id'=>$userid]) as $key => $balance) {
	    			$current_balance 	= $balance->current_balance;
	    		}

	    		if( $amount >= 10) {

	    				if( $amount <= $current_balance) {

		    						if($this->model_users->count_ref(['user_id' =>$userid ,'trans_password' => $trans_pwd]) > 0) {


		    								foreach ($this->model_users->select('upline_id,rank_id',['user_id' => $userid]) as $key => $user) {


		    							$this->load->model('model_portfolio');
						    			$portfolio_data 	=	[

						    										'user_id'			=>	$userid,
						    										'portfolio_amount'	=>	$amount,
						    										'package_type'		=>	$package,
						    										'transaction_no'	=>	$transaction_no,
						    										'date'				=>	$start,
						    										'expiry_date'		=>	$end,
						    										'status'			=>	0 ,
						    										'action'			=> 'buy package'
						    									];

						    			$this->model_portfolio->insert( $portfolio_data );

						    			$new_balance  =  $current_balance - $amount ;

						    			$rwallet_data 	=	[	
						    									'current_balance'	=> $new_balance ,
						    									'previous_balance'	=>	$current_balance
						    								];
						    			
						    			$this->model_rwallet->update($rwallet_data,['user_id' => $userid]);

						    			$transaction_data = [
															'transaction_no'	=>	'PP-'.$userid.'-'.$invoice_no ,
															'type_id'			=>	8 ,
															'user_id'			=>	$userid,
															'sender_id'			=>	$userid,
															'receiver_id'		=>	$userid,
															'wallet_used'		=>	'rwallet',
															'credited_amount'	=>	0,
															'debited_amount'	=>	$amount,
															'description'		=>	'Package Purchase with an amount of $' . $amount ,
															'remarks'			=> 'Package Purchase',
															'status'			=> 0

														];

										$this->model_transactionhistory->insert($transaction_data);
						    		}

						    		foreach ($this->model_users->select('upline_id,rank_id',['user_id' => $userid]) as $key => $ref) {
						    				
						    			
						    				$this->referral_commision( $ref->upline_id, $userid, $ref->rank_id, $amount, $invoice_no );
						    		}


						    		$this->rank_upgrade($userid);
						    		$this->session->set_flashdata('msg', 'Package has been successfully purchased');
										
								  	redirect('package/purchase','refresh');
		    						}
		    						else {

		    								$this->session->set_flashdata('error', '<i class="fa fa-warning"></i> Invalid Transaction Password');
										
								  			redirect('package/purchase','refresh');

		    						}

				    		}

				    		else {

				    					$this->session->set_flashdata('error', '<i class="fa fa-warning"> </i> Insufficient R-Wallet Balance');
										
								  		redirect('package/purchase','refresh');
				    		}
	    		}	

	    		else {

	    				$this->session->set_flashdata('error', '<i class="fa fa-warning"> </i> Minimum amount is $10');				
						redirect('package/purchase','refresh');

	    		}    		

			}
			else {

				redirect('login');
			}
	}

	

}