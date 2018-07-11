<?php
defined('BASEPATH') or exit('No direct script access allowed');



class  Investmentpurchase  extends MY_Controller
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
		$this->load->model('model_matrix_downline_ref');	
		$this->load->model('model_final_e_wallet');
		$this->load->model('model_final_reg_wallet');
		$this->load->model('model_lifejacket_subscription');
		$this->load->model('model_credit_amt');
		$this->load->model('model_final_imm_coin_wallet');
		$this->load->model('model_final_ethereum_wallet');
		$this->load->model('model_final_ethereum_classic_wallet');
		$this->load->model('model_final_imm_coin_wallet');
		$this->load->model('model_final_ripple_wallet');
		$this->load->model('model_final_bitcoin_wallet');
		$this->load->model('model_lifejacket_subscription_coin_converted');
		$this->load->model('model_acc_close_request');
		$this->db->cache_off();
	


	}

	
		public function index(){


			if($this->is_logged_in()){

				$use_id 	=	$this->auth_user_id;
				$data 		=		[];
				$userinfo 	= 		[];

				$this->db->cache_off();
				foreach ($this->model_users->select('*',['user_id'=>$use_id]) as $key => $value) {

							$userinfo = [
											'user_id' 		=>	$value->user_id,
											'username'		=> 	$value->username,
											'rank'			=> 	$value->user_rank_name,
											'image_name' 	=>  $value->image,
											'fname'			=>  $value->first_name,
											'lname'			=>  $value->last_name,
											'username'		=>  $value->email,
											'id'			=>  $value->id,
										];
						}

						$data  = [

									'user_id' => $this->auth_user_id,
									'info'	  => $userinfo,
										

								];
					return $this->load->view('users/packagepurchase',$data);

			}
			else {

				redirect('login');
			}
		}

	/* Sponsor Commission Code Starts Here*/
	public function commission_of_referal($ref,$useridss,$amount,$invoice_no,$packages){

		$spc = 0;
		$date=date('Y-m-d');

   		$this->db->cache_off();
		foreach ($this->model_users->select('*',['user_id'=>$ref]) as $key => $value) {
			
			if($value->user_rank_name=='Cadet')
			{
				$spc=3;
			}
			else if($value->user_rank_name=='Rising Star')
			{
				$spc=5;
			}
			else if($value->user_rank_name=='Flying Star')
			{
				$spc=7;
			}
			else if($value->user_rank_name=='Champion')
			{
				$spc=8;
			}
			else if($value->user_rank_name=='Elite')
			{
				$spc=10;
			}
			else if($value->user_rank_name=='Co Founder')
			{
				$spc=10;
			}
			else 
			{
				$spc=0;
			}

		}

		$amount = $amount ;
		$pb 	= $amount ;

		$withdrawal_commission	=	$spc*$amount/100;
		$rwallet 				= 	$withdrawal_commission;

		if($withdrawal_commission!='' && $withdrawal_commission!=0)
			{
					$urls="http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	
   					$this->model_credit_amt->query("update final_e_wallet set amount=(amount+$rwallet) where user_id='$ref'");
   						
   					$this->model_credit_amt->query("insert into credit_debit values(NULL,'$invoice_no','$ref','$rwallet','0','0','$ref','$useridss','$date','Referral Bonus','Earn Referral Bonus from $useridss for $packages Package','Commission of MYR $rwallet For Package ".$amount." ','Referral Bonus','$invoice_no','Referral Bonus','0','Withdrawal Wallet',CURRENT_TIMESTAMP,'$urls')");

			}
			$this->commission_of_level($useridss,$amount,$invoice_no,$packages);

	}
	/* Sponsor Commission Code Ends Here*/

	/* Sponsor Commission Code Starts Here*/

	public function  commission_of_level($useridss,$amount,$invoice_no,$packages){

			$date =		date('Y-m-d');
			$spc  =		0;

			$this->db->cache_off();
			foreach ($this->model_matrix_downline_ref->query("select * from matrix_downline_ref where down_id='$useridss' and level<7")->result() as $key => $value) {
						$ref = $value->income_id;
						$level = $value->level;
				foreach ($this->model_users->select('*',['user_id'=>$value->income_id]) as $key => $value1) {
									if($value1->user_rank_name=='Cadet' && $value->level==2)
									{
											$spc=2;
									}
									else if($value1->user_rank_name=='Cadet' && $value->level==3)
									{
										$spc=1;
									}
									else if($value1->user_rank_name=='Rising Star' && $value->level==2)
									{
										$spc=3;
									}
									else if($value1->user_rank_name=='Rising Star' && $value->level==3)
									{
										$spc=2;
									}
									else if($value1->user_rank_name=='Flying Star' && $value->level==2)
									{
										$spc=3;
									}
									else if($value1->user_rank_name=='Flying Star' && $value->level==3)
									{
										$spc=2;
									}
									else if($value1->user_rank_name=='Flying Star' && $value->level==4)
									{
										$spc=1;
									}
									else if($value1->user_rank_name=='Champion' && $value->level==2)
									{
										$spc=5;
									}
									else if($value1->user_rank_name=='Champion' && $value->level==3)
									{
								 		$spc=3;
									}
									else if($value1->user_rank_name=='Champion' && $value->level==4)
									{
										$spc=2;
									}
									else if($value1->user_rank_name=='Champion' && $value->level==5)
									{
										$spc=1;
									}
									else if($value1->user_rank_name=='Elite' && $value->level==2)
									{
										$spc=5;
									}
									else if($value1->user_rank_name=='Elite' && $value->level==3)
									{
										$spc=3;
									}
									else if($value1->user_rank_name=='Elite' && $value->level==4)
									{
										$spc=3;
									}
									else if($value1->user_rank_name=='Elite' && $value->level==5)
									{
										$spc=2;
									}
									else if($value1->user_rank_name=='Elite' && $value->level==6)
									{
										$spc=1;
									}
									else if($value1->user_rank_name=='Co Founder' && $value->level==2)
									{
									 	$spc=5;
									}
									else if($value1->user_rank_name=='Co Founder' && $value->level==3)
									{
										$spc=4;
									}
									else if($value1->user_rank_name=='Co Founder' && $value->level==4)
									{
										$spc=3;
									}
									else if($value1->user_rank_name=='Co Founder' && $value->level==5)
									{
										$spc=2;
									}
									else if($value1->user_rank_name=='Co Founder' && $value->level==6)
									{
										$spc=1;
									}
									else 
									{
										$spc=0;
									}
	
					}
					$withdrawal_commission=$spc*$amount/100;
    
					$rwallet=$withdrawal_commission;

					if($withdrawal_commission!='' && $withdrawal_commission!=0)
					{
			
										$this->model_credit_amt->query("update final_e_wallet set amount=(amount+$rwallet) where user_id='$ref'");

		 								$urls="http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	    								
	    								$this->model_credit_amt->query("insert into credit_debit values(NULL,'$invoice_no','$ref','$rwallet','0','0','$ref','$useridss','$date','Unilevel Bonus','Earn Unilevel Bonus from $useridss for $packages Package','Commission of USD $rwallet For Package ".$amount." ','Unilevel $level Bonus','$invoice_no','Unilevel Bonus','0','Withdrawal Wallet',CURRENT_TIMESTAMP,'$urls')");
	    						 				//Rank_update($useridss);
					}
			}
	}

	/* Sponsor Commission Code Ends Here*/


	public function purchase(){


			$this->is_logged_in();

			$use_id 		= $this->auth_user_id;
			$amount   		=  $this->input->post('amount');
			$password		=  $this->input->post('password');
			$data 			=	[];
			$ewa='final_reg_wallet';
			$walls="Withdrawal Reg Wallet";	

			$rand = rand(0000000001,9000000000);

			$invoice_no = $rand;
    		$start=date('Y-m-d');
    		$end = date('Y-m-d', strtotime('+12 months'));
    		$user_ewalletamt = 0;
    		$new_bal 		= 0;
    		$balance  		= 0;

    		$id = "";
			$this->db->cache_off();
				if($amount < 10){

									
										array_push($data,[

														'title'		=> 'Oops !',
														'msg'		=> 'Minimum Amount is $10',
														'status'	=> 'error'

												]);
				}
				else {

							$this->db->cache_off();
								foreach ($this->model_final_reg_wallet->select('*',['user_id'=>$use_id]) as $key => $value) {
											$user_ewalletamt=$value->amount;
								}

								$lfid="LJ".$use_id.$rand;
										

								if($user_ewalletamt > $amount){

										$balance = $user_ewalletamt - $amount ;
										foreach ($this->model_users->select('*',['user_id'=>$use_id]) as $key => $value) {
										
										  	$urls="http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

											$id = $value->ref_id;

											if($this->model_final_reg_wallet->update(['amount'=>$balance],['user_id'=>$use_id])){


		    									$this->model_credit_amt->query("INSERT INTO `lifejacket_subscription` (`id`, `user_id`, `package`, `amount`, `pay_type`, `pin_no`, `transaction_no`, `date`, `expire_date`, `remark`, `ts`, `status`, `invoice_no`,`lifejacket_id`,`username`,`sponsor`,`pb`) VALUES (NULL, '$use_id', '$amount', '$amount', '$walls', '$password', '$rand', '$start', '$end', 'Package Purchase', CURRENT_TIMESTAMP, 'Active', '$rand','$lfid','".$use_id."','".$value->ref_id."','$amount')");

		    									$this->model_credit_amt->query("insert into credit_debit (`transaction_no`,`user_id`,`credit_amt`,`debit_amt`,`admin_charge`,`receiver_id`,`sender_id`,`receive_date`,`ttype`,`TranDescription`,`Cause`,`Remark`,`invoice_no`,`product_name`,`status`,`ewallet_used_by`,`current_url`) values('$rand','$use_id','0','$amount','0','$use_id','$use_id','$start','Package Purchase','Package Purchase by $use_id','Package Purchase by $use_id ','Package Purchase $use_id','$rand','Package Purchase by $use_id','0','$walls','$urls')");
											

		    										if($value->user_rank_name=='Normal User'){
		    													$this->model_credit_amt->query("INSERT INTO `rank_achiever` (`id`, `user_id`, `last_rank`, `move_rank`, `ts`, `qualify_date`,`price`) VALUES (NULL, '$use_id', 'Normal User', 'Cadet', CURRENT_TIMESTAMP, '$start','0')");
		    													$this->model_users->update(['user_rank_name'=>'Cadet','designation'=>'Cadet'],['user_id'=>$use_id]);
											
		    										}
		    										
											}


											else {

													array_push($data,[

																		'title'		=> 'Oops !',
																		'msg'		=> 'Something went wrong',
																		'status'	=> 'error'

																	]);
											}
										}


											foreach ($this->model_users->select('*',['user_id'=>$use_id]) as $key => $value3) {
		    												$this->commission_of_referal($value3->ref_id,$use_id,$amount,$invoice_no,$amount); //commison for referral
		    										
											}
												$this->rankfile(); //Update user ranks

												array_push($data,[
																		'title'		=> 'Good Job !',
																		'msg'		=> 'Package has been purchased',
																		'status'	=> 'success'
																	]);

								}

								else {

											array_push($data,[
																'title'		=> 'Oops !',
																'msg'		=> 'Insufficient Fund',
																'status'	=> 'error'


														]);


								}
									
				}

				echo json_encode($data);
	
	}


	public function rankfile(){


					$user = "";
					$totsum=0;
					$totsum = 0 ;
					$rank  = "";

					$this->db->cache_off();
				 foreach ($this->model_lifejacket_subscription->query('select distinct(user_id) from lifejacket_subscription')->result() as $key => $value) {
				
				 		 $user = $value->user_id;

				 		 foreach ($this->model_lifejacket_subscription->query("select sum(amount) as newsum from lifejacket_subscription where user_id='$user' and status='Active'")->result() as $key => $value1) {
				 		 			$totsum=$value1->newsum;
				 		 }
				 		 foreach ($this->model_lifejacket_subscription->query("select * from user_registration where user_id='$user'")->result() as $key => $value2) {
				 		 			$rank=$value2->user_rank_name;
				 		 }


				 		 if($totsum>=75000 && ($rank=='Elite' || $rank=='Champion' || $rank=='Flying Star' || $rank=='Rising Star' || $rank=='Cadet' || $rank=='Normal User'))
							{
       	 						
       	 						 $this->model_lifejacket_subscription->query("update user_registration set user_rank_name='Co Founder', designation='Co Founder' where user_id='$user'");
       	 						 $this->model_lifejacket_subscription->query("INSERT INTO `rank_achiever` (`id`, `user_id`, `last_rank`, `move_rank`, `ts`, `qualify_date`, `price`) VALUES (NULL, '$user', 'Elite', 'Co Founder', CURRENT_TIMESTAMP, '".date('Y-m-d')."', '0')");
       	 						
							}
						else if($totsum>=30000 && ($rank=='Champion' || $rank=='Flying Star' || $rank=='Rising Star' || $rank=='Cadet' || $rank=='Normal User'))
							{

	  						

       	 						 $this->model_lifejacket_subscription->query("update user_registration set user_rank_name='Elite', designation='Elite' where user_id='$user'");

	    						 $this->model_lifejacket_subscription->query("INSERT INTO `rank_achiever` (`id`, `user_id`, `last_rank`, `move_rank`, `ts`, `qualify_date`, `price`) VALUES (NULL, '$user', 'Champion', 'Elite', CURRENT_TIMESTAMP, '".date('Y-m-d')."', '0')");

							}
						else if($totsum>=15000 && ($rank=='Flying Star' || $rank=='Rising Star' || $rank=='Cadet' || $rank=='Normal User'))
						{
         						
         						$this->model_lifejacket_subscription->query("update user_registration set user_rank_name='Champion', designation='Champion' where user_id='$user'");


         						$this->model_lifejacket_subscription->query("INSERT INTO `rank_achiever` (`id`, `user_id`, `last_rank`, `move_rank`, `ts`, `qualify_date`, `price`) VALUES (NULL, '$user', 'Flying Star', 'Champion', CURRENT_TIMESTAMP, '".date('Y-m-d')."', '0')");
          					
						}
						else if($totsum>=5000 && ($rank=='Rising Star' || $rank=='Cadet' || $rank=='Normal User'))
						{
       								$this->model_lifejacket_subscription->query("update user_registration set user_rank_name='Flying Star', designation='Flying Star' where user_id='$user'");

       								$this->model_lifejacket_subscription->query("INSERT INTO `rank_achiever` (`id`, `user_id`, `last_rank`, `move_rank`, `ts`, `qualify_date`, `price`) VALUES (NULL, '$user', 'Rising Star', 'Flying Star', CURRENT_TIMESTAMP, '".date('Y-m-d')."', '0')");
         						
						}
						else if($totsum>=500 && ($rank=='Cadet' || $rank=='Normal User'))
						{
									
									$this->model_lifejacket_subscription->query("update user_registration set user_rank_name='Rising Star', designation='Rising Star' where user_id='$user'");


									$this->model_lifejacket_subscription->query("INSERT INTO `rank_achiever` (`id`, `user_id`, `last_rank`, `move_rank`, `ts`, `qualify_date`, `price`) VALUES (NULL, '$user', 'Cadet', 'Rising Star', CURRENT_TIMESTAMP, '".date('Y-m-d')."', '0')");

	 								
						}
						else if($totsum>=10 && $rank=='Normal User')
						{
									

									$this->model_lifejacket_subscription->query("update user_registration set user_rank_name='Cadet', designation='Cadet' where user_id='$user'");

										$this->model_lifejacket_subscription->query("INSERT INTO `rank_achiever` (`id`, `user_id`, `last_rank`, `move_rank`, `ts`, `qualify_date`, `price`) VALUES (NULL, '$user', 'Normal User', 'Cadet', CURRENT_TIMESTAMP, '".date('Y-m-d')."', '0')");
	 								
						}
						else
						{
      
						} 

				}
	}
}