<?php
defined('BASEPATH') or exit('No direct script access allowed');



class  Register  extends MY_Controller
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
		
	}

	public function index(){
			return $this->load->view('users/register');
	}
	public function register(){
		$this->index();
	}
	
	public function referral() {
	
	       $ref_id = $this->uri->segment(4) ;
	       $this->session->set_userdata(['sponsor_id'=>$ref_id]);
	       $this->index();
	}

	public function password_reset(){
			return $this->load->view('users/password_reset');
	}


	public function sendCode(){
		//$this->load->library('email');

		$emails  = $this->input->post('emails');
		
		$rand = rand(10000,99999);
		$code = md5($rand);
		$data = [];
		$this->session->set_userdata(['reset_code'=>$code]);
		$msg = '<!doctype html>
			<html>

			<head>
			    <meta charset="utf-8">
			    <title>PASSWORD RESET</title>
			    <link href="https://fonts.googleapis.com/css?family=Expletus+Sans" rel="stylesheet" type="text/css">
			    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
			</head>

			<body style="margin:0px; padding:0px; font-family: Open Sans, Tahoma, Times, serif; background: rgb(77, 158, 185) none repeat scroll 0% 0%; width: 100%; float: left;">
			    <div class="container" style="width:590px; margin:auto;margin-top:50px;margin-bottom:50px;">
			        <div class="container1" style="background: #fff;width: 100%;float: left;margin-bottom:50px;">
			            <div class="cont" style="width: 490px;float: left;text-align: center;margin: 25px 0px 0px 43px;">
			                <img src="http://immtradersclub.com/images/logo.png" style="margin:0 0 20px 0;width:200px;  "><br/><br/>
			                <div class="header" style="font-weight: 600;color: rgb(255, 255, 255);font-size: 30px;
			line-height: 30px;padding: 18px 0px 12px;background-color: rgb(255, 114, 67); font-family: Arial, cursive;">
			                   Password Reset Confirmation
			                </div>
			                <div class="pay-head" style="font-family: Lato;font-weight: 400;color: rgb(72, 72, 72);font-size: 25px;line-height: 35px; margin-top: 13px;">
			                    Dear '.$emails.',
			                </div>
			                <div class="border" style="width: 500px;text-align: left;height: 1px;background-color: #000;float: left;">
			                </div>
			                <div class="txt" style="font-family: Lato,Arial;font-weight: 400;font-size: 15px;line-height: 23px;
			color: rgb(38, 38, 38);width: 100%;margin-top: 24px;">
			                    <p style="margin: 0px !important;">PASSWORD RESET VERIFICATION</p>
			                </div>
			                <div class="amount" style="color: rgb(72, 72, 72);line-height: 35px;font-family: Lato;">


			                     <h4>PLEASE CLICK ON THE LINK BELOW TO RESET YOUR PASSWORD.</h4>

			                       <h4>Secure Login URL: https://immtradersclub.com/member/login </h4>
			                 
			                   	<h3>Reset Link :</h3>
			                    <a href="https://immtradersclub.com/member/reset/password/'.$code.'" style="margin: 8px 0px 10px !important;font-weight: 300;font-size: 20px"> https://immtradersclub.com/member/reset/password/'.$code.'/'.$emails.'</a>
			                   
			         
			                    <h3>ACCOUNT NOTIFICATIONS</h3>
			                    <p>To ensure that you receive all our notifications, we recommend that you give your valid email address and

			check your email on regular basis.</p>
			<h3>NEED ASSISTANCE?</h3>
			<p>If you have any further questions please feel free leave comments on contact us.</p>
			                   <p> Thank you,<br/>Interday Markets Management.<br/>Operation Dept.</p>
			                  </div>
			                <div class="line" style="height: 1px;background: rgb(218, 218, 218) none repeat scroll 0% 0%;margin-top: 20px;">		               
			                </div>
			                <p style="font-family: Lato, Arial; font-weight: 400; font-size: 15px; line-height: 24px; color: #0c0b0c; -webkit-font-smoothing: antialiased; margin: 26px 0px 0px !important;">
			                  Copyrights 2016 Immtradersclub. All Rights Reserved. </p>
			                
			            </div>
			        </div>
			    </div>
			    </div><br/><br/>
			</body>

			</html>';

	
		 	$this->load->library("phpmailer_library");
		    $mail = $this->phpmailer_library->load();

			$mail->SMTPDebug = 4; // Enable verbose debug output
				$mail->isSMTP();
				$mail->SMTPAutoTLS = false;
				$mail->SMTPOptions = array(
									    'ssl' => array(
									        'verify_peer' => false,
									        'verify_peer_name' => false,
									        'allow_self_signed' => true
									    )
									);
				$mail->SMTPSecure = 'ssl'; 
				$mail->SMTPAuth = true; 
				$mail->Host = 'ssl://smtp.gmail.com'; 
				$mail->Username = 'cyberspace418@gmail.com'; 
				$mail->Password = 'Louise2)!&'; 
				$mail->Port = 465;
				$mail->SetLanguage("tr", "phpmailer/language");
				$mail->CharSet ="utf-8";
				$mail->Encoding="base64";
				$mail->SMTPDebug = false;
				$mail->do_debug = 0;
				$mail->setFrom('cyberspace418@gmail.com', 'IMM TRADERS');
				$mail->addAddress($emails,$emails); 
				$mail->isHTML(true); 
				$mail->Subject = "PASSWORD RESET";
				$mail->Body = $msg;

				$this->session->set_userdata(['myemail'=>$emails]);
			
				if($this->model_users->count_ref(['email'=>$emails]) > 0 ){
						if(!$mail->send()) {
						    
							 array_push($data,[

					 					'title' 	=>'Oops !',
					 					'msg'		=> 'Something went wrong',
					 					'status'	=>'error'
					 				]);
							}
					else {
						$this->model_users->update(['passwd_recovery_code'=>$code],['email'=>$emails]);
						array_push($data,[

					 					'title' 	=>'Good Job !',
					 					'msg'		=> 'Reset Link has been sent to your email',
					 					'status'	=>'success'
					 				]);
					}
				}else {


					 array_push($data,[

					 					'title' 	=>'Oops !',
					 					'msg'		=> 'Email Not Found in our record',
					 					'status'	=>'error'
					 				]);
				}

			echo json_encode($data);

	}



	public function confirmCode(){

			$code =$this->uri->segment(3);
			$generated = $this->session->userdata('reset_code');

			$data = [

					'email' =>$this->uri->segment(4)
					];

			if($code == $generated){
				redirect('reset/password/confirm/confirms');
			}
			else {

					echo 'Link Expire';
			}

		}

	public function resetView(){
			$this->load->view('users/confirm_reset');

	}

	public function resetPassword () {

			$data = [];

			$password 		 = $this->input->post('password');
			$confirmpassword = $this->input->post('confirmpassword');
		
			$email = $this->session->userdata('myemail') ;
				 					

			if($password == $confirmpassword){


				if($this->model_users->update(['passwd'=>$this->authentication->hash_passwd($password)],['email'=>$email])){

						array_push($data,[

				 					'title' 	=>'Good Job !',
				 					'msg'		=> 'Password has been updated. Got to Login page and login in',
				 					'status'	=>'success'
				 				]);
				}
				else {
						array_push($data,[

				 					'title' 	=>'Oops !',
				 					'msg'		=> 'Something went wrong',
				 					'status'	=>'error'
				 				]);
				}

			}
			else {
					array_push($data,[

				 					'title' 	=>'Oops !',
				 					'msg'		=> 'Password Mismatch',
				 					'status'	=>'error'
				 				]);
			}
		echo json_encode($data);
	}
    public function resetPass(){
				$this->load->view('users/reset');
    }

    public function rst() {


				$this->load->helper(array('form', 'url'));

                $this->load->library('form_validation');
                $this->load->helper('auth');
				$this->load->model('examples/examples_model');
				$this->load->model('examples/validation_callables');

				$userid 			= $this->input->post('userid');
				$email 				= $this->input->post('email');
				$passwd 			= $this->input->post('passwd');
				$cpasswd 			= $this->input->post('confirm_passwd');
			
				$tcode 				= $this->input->post('tcode');

				$pass = $this->authentication->hash_passwd(	$passwd );


				$user_data = [
								'passwd'   			=> $passwd,
								'email'				=> $email,
								'user_id'			=> $userid
							];

				$this->form_validation->set_data( $user_data );

        		$validation_rules = [
        		
        			[
        				'field' => 'email',
        				'label' => 'email',
        				'rules' => [
        					'trim',
        					'required',
        					
        				],
        				'errors' => [
        					'required' => 'The email field is required.'
        				]
        			],
        		];

	
		$this->form_validation->set_rules( $validation_rules );

		if($this->form_validation->run()){
				
					 $this->db->cache_off();

					 if($this->model_users->count_ref(['email'=>$email]) > 0){
		
    					 	    foreach($this->model_users->select('t_code',['username' => $email ]) as $key => $value){
    					 	
    					 	        $this->sendTCode($email,$value->t_code);
    					 	    }
    		 
    					 	   $this->session->set_flashdata('msg', 'Transaction Password has been sent to your email.');
					 	    }
					 	
					 else {

					 	$this->session->set_flashdata('msg', 'USER NOT FOUND');
					 }
				$this->resetPass();
		}

		else {
			
			$this->resetPass();
		}


    }


    public function create_user() {

				$imm_token 			= $this->input->post('imm_token');
				$phoneNumber 		= $this->input->post('phoneNumber');
				$defaultCountry 	= $this->input->post('defaultCountry');
				$carrierCode 		= $this->input->post('carrierCode');
				$sponsor 			= $this->input->post('sponsor');
				$email 				= $this->input->post('email');
				$passwd 			= $this->input->post('password');
				$tcode 				= $this->input->post('tcode');


				$tcode =	rand(1000000,9999999);


				$this->load->helper(array('form', 'url'));

                $this->load->library('form_validation');
                $this->load->helper('auth');
				$this->load->model('examples/examples_model');
				$this->load->model('examples/validation_callables');
				$this->load->model('model_userinfo');
				$this->load->model('model_rankachievement');
				$this->load->model('model_ewallet');
				$this->load->model('model_rwallet');
				$this->load->model('model_userbankdetails');
				$this->load->model('model_cryptowallet');
				$this->load->model('model_userincomes');


				$data = [] ;
				$ref_id 		= '';
				$ref_name 		= '';

     

                $user_data = [	
								'passwd'     => $passwd,
								'email'      => $email,
								'sponsor'	=> $sponsor,
								'auth_level' => '9', 
							];
				$this->form_validation->set_data( $user_data );


					$validation_rules = [
								
								[
									'field' => 'passwd',
									'label' => 'passwd',
									'rules' => [
										'trim',
										'required',
										[ 
											'_check_password_strength', 
											[ $this->validation_callables, '_check_password_strength' ] 
										]
									],
									'errors' => [
										'required' => 'The password field is required.'
									]
								],
																[
									'field' => 'sponsor',
									'label' => 'sponsor',
									'rules' => [
										'trim',
										'required',
									],
									'errors' => [
										'required' => 'The sponsor field is required.'
									]
								],
								[
									'field'  => 'email',
									'label'  => 'email',
									'rules'  => 'trim|required|valid_email|is_unique[' . db_table('user_table') . '.email]',
									'errors' => [
										'is_unique' => 'Email address already in use.'
									]
								],
								[
									'field' => 'auth_level',
									'label' => 'auth_level',
									'rules' => 'required|integer|in_list[1,6,9]'
								]
						];
					
				$this->form_validation->set_rules( $validation_rules );

				if( $this->form_validation->run()  ) {
						
					foreach ($this->model_users->query("Select user_id from users where user_id='$sponsor' OR email='$sponsor'")->result() as $key => $value) {
							$ref_id = $value->user_id;				
					}

						$nuser_id = "IMM".$this->userid();
				
				
							//user created credentials
		        			$userdata = [
		        							'user_id'			=> $nuser_id,
		        							'email'				=>	$email,
		        							'username'          => $email,
		        							'passwd'			=> 	$this->authentication->hash_passwd(	$passwd ),
		        							'trans_password'	=>  $tcode,
		        							'status'			=> '0',
		        							'auth_level'		=> '9',
		        							'upline_id'			=> $ref_id,
		        							'rank_id'			=> '1',
		        						] ;
				
						   if(!empty($ref_id)) {
						       
						       		//insert data in users tabale
						       if($this->model_users->insert($userdata)) {
						       			$userinfo = [
						       							'user_id' => $nuser_id
						       						];
						       		//insert data userinfo table for users details
						       		$this->model_userinfo->insert($userinfo);
						        	
						       		//create ewallet for newly registered user
						        	$this->model_ewallet->insert([
						        									'user_id' 				=> $nuser_id,
						        									'current_balance'  	=> 0,
						        									'previous_balance' 	=> 0 ,


						        								]);

						        	//create rwallet for newly registered user
						        	$this->model_rwallet->insert([
						        									'user_id' 				=> $nuser_id,
						        									'current_balance'  	=> 0,
						        									'previous_balance' 	=> 0 

						        								]);
						      
						        //insert into rankachievement for user
						       	$this->model_rankachievement->insert([
						       											'user_id'		=> $nuser_id ,
						       											'rank_id'		=> 1,
						       											'achieved_date' => date('Y-m-d')
						       										]);
						       	//insert bank details default
						       	$this->model_userbankdetails->insert([
						       											'user_id'	=> $nuser_id

						       										]);

						       	//crypto wallet
						       		$this->model_cryptowallet->insert([
						       											'user_id'	=> $nuser_id

						       										]);


						       		$this->model_userincomes->insert([
						       											'user_id'	=> $nuser_id

						       										]);

 								//send email to users credentials after successful registration

                                 //$this->sendEmail($email,$nuser_id,$this->input->post('password'),$tcode);

						       	//insert into matrix downline
        						 $this->insertReferrer($ref_id,$nuser_id);
        						 //$this->sendEmail($email,$nuser_id,$this->input->post('password'),$tcode);
        						 $this->session->set_flashdata('msg', 'You have successfully created your account. Go to login page and login to your account. Please check your email to confirm your Account Credentials');
        						
						}
						
						else {
						    
						    $this->session->set_flashdata('error', 'Something went wrong. Please try again later');
						    return redirect('register','refresh');
						    
						    
						}

						       
						   }
						   
						   
						else {
						      $this->session->set_flashdata('error', 'Something went wrong. Please try again later');
						      return redirect('register','refresh');
						    
						}
					    	
					
						return redirect('register','refresh');
						
				}

				else {

						 $this->session->set_flashdata('error', validation_errors('<li>', '</li>'));

						 return redirect('register','refresh');
						//$this->index();
				}



	}

	public function insertReferrer($ref_id,$user_id){

				$this->load->model('model_matrixdownline') ;

				$nom123=$ref_id;
				$date=date('Y-m-d');
				$l1=1;
				while($nom123!='cmp'){
			    if($nom123!='cmp'){

			    	if($l1 <=21) {
						$this->model_matrixdownline->insert([
																'downline_id' 		=> $user_id ,
																'referral_id' 		=> $nom123,
																'registration_date'	=> $date ,
																'level'				=> $l1,
																'account_status'	=> 0
															]);
						}
					else {

						 	$nom123 ='cmp';
					}
					$l1++;
					foreach ($this->model_users->select('upline_id',['user_id'=>$nom123]) as $key => $value) {
								$nom123 = $value->upline_id;
					}
					
				}
			}
	}

	public function userid() {
		//generated unique userid 
    	$table_name='users';
    	$encypt1=uniqid(rand(10000000,999999999), true);
    	$usid1=str_replace(".", "", $encypt1);
    	$pre_userid = substr($usid1, 0, 7);
    	//$checkid=mysql_query("select user_id from $table_name where user_id='$pre_userid'");
    	if($this->model_users->count_ref(['user_id'=>$pre_userid]) > 0)
    	{
    	userid();
    	}
    	else
    	return strtoupper($pre_userid);
    }

    public function sendEmail($email,$userid,$pass,$tcode) {
    
    
                   
    				$strSubject = "iMM-Traders Club Registration Confirmation";
    				$from = 'info@immtradersclub.com';
    	     		
    		    	$headeruser1="Mime-Version: 1.0\r\n";
    $headeruser1.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headeruser1.="Mime-Version: 1.0\r\n";
    $headeruser1.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headeruser1.= "From:iMM-Traders <$from>" . "\r\n";
    
    
    $msg = '<!doctype html>
    <html>
    
    <head>
        <meta charset="utf-8">
        <title>Account Credential</title>
        <link href="https://fonts.googleapis.com/css?family=Expletus+Sans" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    </head>
    
    <body style="margin:0px; padding:0px; font-family: Open Sans, Tahoma, Times, serif; background: rgb(77, 158, 185) none repeat scroll 0% 0%; width: 100%; float: left;">
        <div class="container" style="width:590px; margin:auto;margin-top:50px;margin-bottom:50px;">
            <div class="container1" style="background: #fff;width: 100%;float: left;margin-bottom:50px;">
                <div class="cont" style="width: 490px;float: left;text-align: center;margin: 25px 0px 0px 43px;">
                    <img src="http://immtradersclub.com/images/logo.png" style="margin:0 0 20px 0;width:200px;  "><br/><br/>
                    <div class="header" style="font-weight: 600;color: rgb(255, 255, 255);font-size: 30px;
    line-height: 30px;padding: 18px 0px 12px;background-color: rgb(255, 114, 67); font-family: Arial, cursive;">
                       Registration Confirmation
                    </div>
                    <div class="pay-head" style="font-family: Lato;font-weight: 400;color: rgb(72, 72, 72);font-size: 25px;line-height: 35px; margin-top: 13px;">
                        Dear '.$email.',
                    </div>
                    <div class="border" style="width: 500px;text-align: left;height: 1px;background-color: #000;float: left;">
                    </div>
                    <div class="txt" style="font-family: Lato,Arial;font-weight: 400;font-size: 15px;line-height: 23px;
    color: rgb(38, 38, 38);width: 100%;margin-top: 24px;">
                        <p style="margin: 0px !important;">Welcome to Interday Markets Management Limited, where we provide your Fiat Currency and Crypto
    
    Currency investment needs all in one place.</p>
                    </div>
                    <div class="amount" style="color: rgb(72, 72, 72);line-height: 35px;font-family: Lato;">
    
                        <h3>ACCOUNT LOGIN</h3>
    
                         <h4>Please login with the given Email address and password below where you can change your password. If you have not already done so, you may now part of Immtradersclub Family members.</h4>
    
                           <h4>Secure Login URL: https://immtradersclub.com/member/login </h4>
                     
                         <h3 style="margin: 8px 0px 10px !important;font-weight: 300;font-size: 20px"> User ID  : '.$userid.'</h3>
                        <h3 style="margin: 8px 0px 10px !important;font-weight: 300;font-size: 20px"> Username  : '.$email.'</h3>
                       
                        <h3 style="margin: 8px 0px 10px !important;font-weight: 300;font-size: 20px"> Password  : '.$pass.'</h3>
                        <h3 style="margin: 8px 0px 10px !important;font-weight: 300;font-size: 20px"> Transaction Password  : '.$tcode.'</h3>
    
                        <h3>ACCOUNT NOTIFICATIONS</h3>
                        <p>To ensure that you receive all our notifications, we recommend that you give your valid email address and
    
    check your email on regular basis.</p>
    <h3>NEED ASSISTANCE?</h3>
    <p>If you have any further questions please feel free leave comments on contact us.</p>
                       <p> Thank you,<br/>Interday Markets Management.<br/>Operation Dept.</p>
                      </div>
                    
                    <div class="line" style="height: 1px;background: rgb(218, 218, 218) none repeat scroll 0% 0%;margin-top: 20px;">
    
                   
                    </div>
                    <p style="font-family: Lato, Arial; font-weight: 400; font-size: 15px; line-height: 24px; color: #0c0b0c; -webkit-font-smoothing: antialiased; margin: 26px 0px 0px !important;">
                      Copyrights 2018 iMM-Traders Club. All Rights Reserved. </p>
                    
                </div>
            </div>
        </div>
        </div><br/><br/>
    </body>
    
    </html>';
    
    	mail ( $email, $strSubject, $msg, $headeruser1 );
    
    	
    }
    public function sendTCode($email,$tcode) {
    
    
                   
    				$strSubject = "Transaction Password Request";
    				$from = 'info@immtradersclub.com';
    	     		
    		    	$headeruser1="Mime-Version: 1.0\r\n";
                    $headeruser1.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headeruser1.="Mime-Version: 1.0\r\n";
                    $headeruser1.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headeruser1.= "From:iMM-Traders <$from>" . "\r\n";
                    
                    
                    $msg = '<!doctype html>
                    <html>
                    
                    <head>
                        <meta charset="utf-8">
                        <title>Account Credential</title>
                        <link href="https://fonts.googleapis.com/css?family=Expletus+Sans" rel="stylesheet" type="text/css">
                        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
                    </head>
                    
                    <body style="margin:0px; padding:0px; font-family: Open Sans, Tahoma, Times, serif; background: rgb(77, 158, 185) none repeat scroll 0% 0%; width: 100%; float: left;">
                        <div class="container" style="width:590px; margin:auto;margin-top:50px;margin-bottom:50px;">
                            <div class="container1" style="background: #fff;width: 100%;float: left;margin-bottom:50px;">
                                <div class="cont" style="width: 490px;float: left;text-align: center;margin: 25px 0px 0px 43px;">
                                    <img src="http://immtradersclub.com/images/logo.png" style="margin:0 0 20px 0;width:200px;  "><br/><br/>
                                    <div class="header" style="font-weight: 600;color: rgb(255, 255, 255);font-size: 30px;
                    line-height: 30px;padding: 18px 0px 12px;background-color: rgb(255, 114, 67); font-family: Arial, cursive;">
                                       Registration Confirmation
                                    </div>
                                    <div class="pay-head" style="font-family: Lato;font-weight: 400;color: rgb(72, 72, 72);font-size: 25px;line-height: 35px; margin-top: 13px;">
                                        Dear '.$email.',
                                    </div>
                                    <div class="border" style="width: 500px;text-align: left;height: 1px;background-color: #000;float: left;">
                                    </div>
                                    <div class="txt" style="font-family: Lato,Arial;font-weight: 400;font-size: 15px;line-height: 23px;
                    color: rgb(38, 38, 38);width: 100%;margin-top: 24px;">
                                        <p style="margin: 0px !important;">You have requested your transaction password through the Reset Transaction Password Link. Below is your transaction password.</p>
                                    </div>
                                    <div class="amount" style="color: rgb(72, 72, 72);line-height: 35px;font-family: Lato;">
                    
                                        <h4>Secure Login URL: https://immtradersclub.com/member/login </h4>
                                        <h3 style="margin: 8px 0px 10px !important;font-weight: 300;font-size: 20px"> Transaction Password  : '.$tcode.'</h3>
                                        <h3>ACCOUNT NOTIFICATIONS</h3>
                                        <p>To ensure that you receive all our notifications, we recommend that you give your valid email address and check your email on regular basis.</p>
                                        <h3>NEED ASSISTANCE?</h3>
                                        <p>If you have any further questions please feel free leave comments on contact us.</p>
                                        <p> Thank you,<br/>Interday Markets Management.<br/>Operation Dept.</p>
                                      </div>
                                    
                                    <div class="line" style="height: 1px;background: rgb(218, 218, 218) none repeat scroll 0% 0%;margin-top: 20px;">
                    
                                   
                                    </div>
                                    <p style="font-family: Lato, Arial; font-weight: 400; font-size: 15px; line-height: 24px; color: #0c0b0c; -webkit-font-smoothing: antialiased; margin: 26px 0px 0px !important;">
                                      Copyrights 2018 iMM-Traders Club. All Rights Reserved. </p>
                                    
                                </div>
                            </div>
                        </div>
                        </div><br/><br/>
                    </body>
                    
                    </html>';
    
    	mail ( $email, $strSubject, $msg, $headeruser1 );
    
    	
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
    													'email' 	=> 'Sponsor not found !',
    													'name' 		=> 	'',
    													'user_id' 	=> ''
    												]
    										);
    				}
    
    			}
    			else {
    
    					array_push($data,
    									    [
    										    'email' => 'Please enter your sponsor !',
    											'name' 	=> 	'',
    											'user_id' => ''
    										]
    									);
    			}
    				echo json_encode($data);			
    	}


}