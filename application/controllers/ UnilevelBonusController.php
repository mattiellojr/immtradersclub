<?php
defined('BASEPATH') or exit('No direct script access allowed');



class UnilevelBonusController  extends MY_Controller
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
									'description'		=>	'Earn Referral Bonus/Commission (Bonus From Profit) from ' . $user_id . ' for Profit Sharing Bonus  with an amount of $' . $amount,
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

							else if(  $level == 1 ) {

								$unilevel_commission_percetage = 3  ;

							}
							if(  $level == 2 ) {

								$unilevel_commission_percetage = 2  ;

							}

							else if(  $level == 3 ) {

								$unilevel_commission_percetage = 1  ;

							}

					}

					//RISING STAR
					else if ( $rank == 3) {

							if( $level == 1 ) {

								$unilevel_commission_percetage = 4  ;

							}

							
							else if( $level == 2 ) {

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

							if( $level == 1 ) {

								$unilevel_commission_percetage = 4  ;

							}
							else if( $level == 2 ) {

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

							if( $level == 1 ) {

								$unilevel_commission_percetage = 5  ;

							}

						 	else if( $level == 2 ) {

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

							if( $level == 1 ) {

								$unilevel_commission_percetage = 5  ;

							}

							 else if( $level == 2 ) {

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

						 	if( $level == 1 ) {

								$unilevel_commission_percetage = 6  ;
							}

							else if( $level == 2 ) {

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
												'type_id'			=>	9 ,
												'user_id'			=>	$referral_id,
												'sender_id'			=>	$user_id,
												'receiver_id'		=>	$referral_id,
												'wallet_used'		=>	'ewallet',
												'credited_amount'	=>	$commission,
												'debited_amount'	=>	0,
												'description'		=>	'Earn Unilevel Bonus/Commission (Bonus From Profit) from ' . $user_id . ' for Profit Sharing Bonus with an amount of $' . $amount ,
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

	public function distribute() {


			$datek = date('Y-m-d');
			$date=date('Y-m-d', strtotime($datek. ' -1 day'));

			$invoice_no = rand(0000000001,9000000000);
			
			foreach ($this->model_transactionhistory->select('transaction_id,user_id,credited_amount',['type_id' => 5,'status' => 0 ,'DATE(transaction_date)' => $date]) as $key => $value) {
			
				foreach ($this->model_users->select('upline_id,rank_id',['user_id' => $value->user_id]) as $key => $ref) {
						
					$this->referral_commision( $ref->upline_id, $value->userid, $ref->rank_id, $value->$amount, $invoice_no );
				}
				
				$this->model_transactionhistory->update(['status' => 1],['transaction_id' => $value->transaction_id]);

		}
	}

	

}