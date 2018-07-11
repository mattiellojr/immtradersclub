<?php
defined('BASEPATH') or exit('No direct script access allowed');



class AccountController  extends MY_Controller
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

					
						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}

					$data = [
								'userid' 		=> $userid,
								'rank_name' 	=> $rank_name ,
								'achieved_date' => $achieved_date ,
								'usedata'  		=> $this->model_users->query("Select users.user_id as usrid,users.email ,userinfo.* from users JOIN userinfo ON users.user_id=userinfo.user_id WHERE  users.user_id='".$this->auth_user_id."' ")->result(),
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()

							];


					return $this->load->view('accountsettings/profile',$data);
				}
				else {
					redirect('login');
				}
	}

	public function bankdetails() {

				if($this->is_logged_in() ) {

					$userid 		= "";
					$rank_name 		= "";
					$achieved_date 	= "";

					
						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}

					$data = [
								'userid' 		=> $userid,
								'rank_name' 	=> $rank_name ,
								'achieved_date' => $achieved_date ,
								'usedata'  		=> $this->model_users->query("Select users.user_id as usrid,users.email ,userbankdetails.* from users JOIN userbankdetails ON users.user_id=userbankdetails.user_id WHERE  users.user_id='".$this->auth_user_id."' ")->result(),
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()

							];

					return $this->load->view('accountsettings/bankdetails',$data);
				}
				else {
					redirect('login');
				}

	}

	public function wallet() {

				if($this->is_logged_in() ) {

					$userid 		= " ";
					$rank_name 		= " ";
					$achieved_date 	= "";

					$this->load->model('model_cryptowallet');

					
						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}

					$data = [
								'userid' 		=> $userid,
								'rank_name' 	=> $rank_name ,
								'achieved_date' => $achieved_date ,
								'cryptowallet'  => $this->model_cryptowallet->select("*",['user_id' => $userid]),
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()
							];

					return $this->load->view('accountsettings/wallet',$data);
				}
				else {
					redirect('login');
				}

	}

	public function password() {

				if($this->is_logged_in() ) {

					$userid 		= "";
					$rank_name 		= "";
					$achieved_date 	= "";

					
						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {

								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}

					$data = [
								'userid' 		=> $userid,
								'rank_name' 	=> $rank_name ,
								'achieved_date' => $achieved_date ,
								'usedata'  		=> $this->model_users->query("Select user_id,passwd,trans_password from users WHERE  users.user_id='".$this->auth_user_id."' ")->result(),
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()

							];	

					return $this->load->view('accountsettings/password',$data);
				}
				else {
					redirect('login');
				}

	}

	public function updateProfile(){

				if($this->is_logged_in() ) {


						$this->load->model('model_userinfo');

						$userid 		=	$this->auth_user_id;
						$first_name 	=	$this->input->post('first_name');
						$last_name		=	$this->input->post('last_name');
						$dob			=	$this->input->post('dob');
						$contact		=	$this->input->post('contact');
						$marital_status	=	$this->input->post('marital_status');
						$gender			=	$this->input->post('gender');


						$userinfo_data	=	[
												'first_name'		=>	$first_name,
												'last_name'			=>	$last_name,
												'birthdate'			=>	$dob,
												'contact_no'		=>	$contact,
												'marital_status'	=>	$marital_status,
												'gender'			=>	$gender,
											];

							 
							 if( $this->model_userinfo->update( $userinfo_data, ['user_id' => $userid] ) ) {

							 			$this->session->set_flashdata('msg', 'Your information has been successfully updated.');

							 }

							 else {

							 		$this->session->set_flashdata('msg', 'Something went wrong !. Please try again later');

							 }

							 return redirect('account/profile','refresh');
						
				}
				else {
					redirect('login');
				}

	}	

	public function updateAddress() {

			if($this->is_logged_in() ) {


						$this->load->model('model_userinfo');

						$userid 		=	$this->auth_user_id;
						
						$address		=	$this->input->post('address');
						$city			=	$this->input->post('city');
						$state			=	$this->input->post('state');
						$country		=	$this->input->post('country');

						$userinfo_address	=	[
							
												'address'			=>	$address,
												'city'				=>	$city,
												'state'				=>	$state,
												'country'			=>	$country
											];

							 
							 if( $this->model_userinfo->update( $userinfo_address, ['user_id' => $userid] ) ) {

							 			$this->session->set_flashdata('msg', 'Your address details has been successfully updated.');

							 }

							 else {

							 		$this->session->set_flashdata('msg', 'Something went wrong !. Please try again later');

							 }

							 return redirect('account/profile','refresh');
						
				}
				else {
					redirect('login');
				}

	}
	public function updateBankDetails() {



		if($this->is_logged_in() ) {


						$this->load->model('model_userbankdetails');

						$userid 		=	$this->auth_user_id;
						
						$account_no		=	$this->input->post('account_no');
						$account_name	=	$this->input->post('account_name');
						$bank_name		=	$this->input->post('bank_name');
						$branch_name	=	$this->input->post('branch_name');
						$swift_code		=	$this->input->post('swift_code');

						$userinfo_bankdetails	=	[
							
														'account_no'	=>	$account_no,
														'account_name'	=>	$account_name,
														'bank_name'		=>	$bank_name,
														'branch_name'	=>	$branch_name,
														'swift_code'	=>  $swift_code
												];

							 
							 if( $this->model_userbankdetails->update( $userinfo_bankdetails, ['user_id' => $userid] ) ) {

							 			$this->session->set_flashdata('msg', 'Your bank details has been successfully updated.');

							 }

							 else {

							 		$this->session->set_flashdata('msg', 'Something went wrong !. Please try again later');

							 }

							 return redirect('account/bankdetails','refresh');
						
				}
				else {
					redirect('login');
				}


	}


	public function updateWallet(){

				if( $this->is_logged_in() ) {


						$this->load->model('model_cryptowallet');

						$userid 			=	$this->auth_user_id;
						$eth_address 		=	$this->input->post('eth');
						$btc_address		=	$this->input->post('btc');
						$xrp_address		=	$this->input->post('xrp');
						$xrp_destination	=	$this->input->post('destination_tag');
						


						$wallet_data	=	[
												'eth_address'			=>	$eth_address,
												'btc_address'			=>	$btc_address,
												'xrp_address'			=>	$xrp_address,
												'xrp_destination_tag'	=>	$xrp_destination,
	
											];

							 
							 if( $this->model_cryptowallet->update( $wallet_data, ['user_id' => $userid] ) ) {

							 			$this->session->set_flashdata('msg', 'Your information has been successfully updated.');

							 }

							 else {

							 		$this->session->set_flashdata('msg', 'Something went wrong !. Please try again later');

							 }

							 return redirect('account/wallet','refresh');
						
				}
				else {
					redirect('login');
				}

	}	

	public function updatePassword(){

			if( $this->is_logged_in() ){

				$userid 	 =	$this->auth_user_id;
				


				$this->load->library('form_validation');
                $this->load->helper('auth');
				$this->load->model('examples/examples_model');
				$this->load->model('examples/validation_callables');
				$this->load->model('model_users');

				$passwd 	 = $this->authentication->hash_passwd( $this->input->post('cpasswd') );
				$currentpd 	 = 	$this->input->post('password');
				$passwd_c    =	$this->input->post('password_confirm');


				$authpass 	 = "";
				foreach ($this->model_users->select('passwd',['user_id' => $userid]) as $key => $value) {
						
						$authpass = $value->passwd;
				}
				


					 $rules = array(
	                			[
				                    'field' => 'password',
				                    'label' => 'Password',
				                    'rules' => 'callback_valid_password',
	                			],
				                [
				                    'field' => 'password_confirm',
				                    'label' => 'Repeat Password',
				                    'rules' => 'matches[password]',
						                ],
			            );
			            $this->form_validation->set_rules( $rules );
			            if ( $this->form_validation->run() ) {


			            	  $this->model_users->update([
			            	  								'passwd'	=> $this->authentication->hash_passwd($this->input->post('password')) ,
			            	  								
			            	  							],
			            	  							[
			            	  								'user_id' => $userid
			            	  							]
			            	  						);

			            	   $this->session->set_flashdata('msg', 'Password has been updated');
			                
			                return redirect('account/password','refresh');

			                
			            }
			            else {
			                
			                $this->session->set_flashdata('error', validation_errors('<li>', '</li>'));
			                
			                return redirect('account/password','refresh');

			            }


			}

			else {

				redirect('login');
			}

	}

	 public function valid_password($password = '')
    {
        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
        if (empty($password))
        {
            $this->form_validation->set_message('valid_password', 'The {field} field is required.');
            return FALSE;
        }
        if (preg_match_all($regex_lowercase, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');
            return FALSE;
        }
        if (preg_match_all($regex_uppercase, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least one uppercase letter.');
            return FALSE;
        }
        if (preg_match_all($regex_number, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');
            return FALSE;
        }
        if (preg_match_all($regex_special, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));
            return FALSE;
        }
        if (strlen($password) < 8)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least 8 characters in length.');
            return FALSE;
        }
        if (strlen($password) > 32)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 32 characters in length.');
            return FALSE;
        }
        return TRUE;
    }

    public function updateTransPassword() {


    	if( $this->is_logged_in() ){

				$userid 	 =	$this->auth_user_id;
				


				$this->load->library('form_validation');
                $this->load->helper('auth');
				$this->load->model('examples/examples_model');
				$this->load->model('examples/validation_callables');
				$this->load->model('model_users');


				$transaction_code = $this->input->post('transaction_code');

				

					 $rules = array(
	                			[
				                    'field' => 'transaction_code',
				                    'label' => 'Transaction Code',
				                    'rules' => 'required'
	                			],
				                [
				                    'field' => 'confirm_transaction_code',
				                    'label' => 'Repeat Transaction Code',
				                    'rules' => 'matches[transaction_code]',
						         ],
			            );
			            $this->form_validation->set_rules( $rules );
			            if ( $this->form_validation->run() ) {


			            	  $this->model_users->update([
			            	  								'trans_password'	=> $this->input->post('transaction_code'),
			            	  								
			            	  							],
			            	  							[
			            	  								'user_id' => $userid
			            	  							]
			            	  						);

			            	   $this->session->set_flashdata('msg', 'Transaction Password has been updated');
			                
			                return redirect('account/password','refresh');

			                
			            }
			            else {
			                
			                $this->session->set_flashdata('error', validation_errors('<li>', '</li>'));
			                
			                return redirect('account/password','refresh');

			            }


				

				// else {
			

			}

			else {

				redirect('login');
			}

    }


}
