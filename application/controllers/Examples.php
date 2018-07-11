<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Community Auth - Examples Controller
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2018, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

class Examples extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Force SSL
		//$this->force_ssl();

		// Form and URL helpers always loaded (just for convenience)
		$this->load->helper('url');
		$this->load->helper('form');
	}

	// -----------------------------------------------------------------------

	/**
	 * Demonstrate being redirected to login.
	 * If you are logged in and request this method,
	 * you'll see the message, otherwise you will be
	 * shown the login form. Once login is achieved,
	 * you will be redirected back to this method.
	 */
	public function index()
	{
		if( $this->is_logged_in() )
		{
			return redirect('dashboard','refresh');
		}
		else {

			 return redirect('login','refresh');
		}
	}

	// -----------------------------------------------------------------------

	/**
	 * A basic page that shows verification that the user is logged in or not.
	 * If the user is logged in, a link to "Logout" will be in the menu.
	 * If they are not logged in, a link to "Login" will be in the menu.
	 */
	public function home()
	{
		if( $this->is_logged_in() )
		{
			return redirect('dashboard','refresh');
		}
		else {

			 return redirect('login','refresh');
		}
	}

	// -----------------------------------------------------------------------

	/**
	 * Demonstrate an optional login.
	 * Remember to add "examples/optional_login_test" to the
	 * allowed_pages_for_login array in config/authentication.php.
	 *
	 * Notice that we are using verify_min_level to check if
	 * a user is already logged in.
	 */
	public function optional_login_test()
	{
		if( $this->verify_min_level(1) )
		{
			$page_content = '<p>Although not required, you are logged in!</p>';
		}
		elseif( $this->tokens->match && $this->optional_login() )
		{
			// Let Community Auth handle the login attempt ...
		}
		else
		{
			// Notice parameter set to TRUE, which designates this as an optional login
			$this->setup_login_form(TRUE);

			$page_content = '<p>You are not logged in, but can still see this page.</p>';

			// Form helper needed
			$this->load->helper('form');

			$page_content .= $this->load->view('examples/login_form', '', TRUE);
		}

		echo $this->load->view('examples/page_header', '', TRUE);

		echo $page_content;

		echo $this->load->view('examples/page_footer', '', TRUE);
	}

	// -----------------------------------------------------------------------

	/**
	 * Here we simply verify if a user is logged in, but
	 * not enforcing authentication. The presence of auth
	 * related variables that are not empty indicates
	 * that somebody is logged in. Also showing how to
	 * get the contents of the HTTP user cookie.
	 */
	public function simple_verification()
	{
		$this->is_logged_in();

		echo $this->load->view('examples/page_header', '', TRUE);

		echo '<p>';
		if( ! empty( $this->auth_role ) )
		{
			echo $this->auth_role . ' logged in!<br />
				User ID is ' . $this->auth_user_id . '<br />
				Auth level is ' . $this->auth_level . '<br />
				Username is ' . $this->auth_username;

			if( $http_user_cookie_contents = $this->input->cookie( config_item('http_user_cookie_name') ) )
			{
				$http_user_cookie_contents = unserialize( $http_user_cookie_contents );

				echo '<br />
					<pre>';

				print_r( $http_user_cookie_contents );

				echo '</pre>';
			}

			if( config_item('add_acl_query_to_auth_functions') && $this->acl )
			{
				echo '<br />
					<pre>';

				print_r( $this->acl );

				echo '</pre>';
			}

			/**
			 * ACL usage doesn't require ACL be added to auth vars.
			 * If query not performed during authentication,
			 * the acl_permits function will query the DB.
			 */
			if( $this->acl_permits('general.secret_action') )
			{
				echo '<p>ACL permission grants action!</p>';
			}
		}
		else
		{
			echo 'Nobody logged in.';
		}

		echo '</p>';

		echo $this->load->view('examples/page_footer', '', TRUE);
	}

	// -----------------------------------------------------------------------

	/**
	 * Most minimal user creation. You will of course make your
	 * own interface for adding users, and you may even let users
	 * register and create their own accounts.
	 *
	 * The password used in the $user_data array needs to meet the
	 * following default strength requirements:
	 *   - Must be at least 8 characters long
	 *   - Must be at less than 72 characters long
	 *   - Must have at least one digit
	 *   - Must have at least one lower case letter
	 *   - Must have at least one upper case letter
	 *   - Must not have any space, tab, or other whitespace characters
	 *   - No backslash, apostrophe or quote chars are allowed
	 */
	public function create_user()
	{
		// Customize this array for your user
		$user_data = [
			'user_id' =>  'IMM12356',
			'username'   => 'hannah',
			'passwd'     => 'Pass2)!*',
			'email'      => 'immdev@gmail.com',
			'auth_level' => '9', // 9 if you want to login @ examples/index.
		];

		$this->is_logged_in();

		echo $this->load->view('examples/page_header', '', TRUE);

		// Load resources
		$this->load->helper('auth');
		$this->load->model('examples/examples_model');
		$this->load->model('examples/validation_callables');
		$this->load->library('form_validation');

		$this->form_validation->set_data( $user_data );

		$validation_rules = [
			[
				'field' => 'username',
				'label' => 'username',
				'rules' => 'max_length[12]|is_unique[' . db_table('user_table') . '.username]',
				'errors' => [
					'is_unique' => 'Username already in use.'
				]
			],
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

		if( $this->form_validation->run() )
		{
			$user_data['passwd']     = $this->authentication->hash_passwd($user_data['passwd']);
			$user_data['user_id']    = $this->examples_model->get_unused_id();
			$user_data['created_at'] = date('Y-m-d H:i:s');

			// If username is not used, it must be entered into the record as NULL
			if( empty( $user_data['username'] ) )
			{
				$user_data['username'] = NULL;
			}

			$this->db->set($user_data)
				->insert(db_table('user_table'));

			if( $this->db->affected_rows() == 1 )
				echo '<h1>Congratulations</h1>' . '<p>User ' . $user_data['username'] . ' was created.</p>';
		}
		else
		{
			echo '<h1>User Creation Error(s)</h1>' . validation_errors();
		}

		echo $this->load->view('examples/page_footer', '', TRUE);
	}

	// -----------------------------------------------------------------------

	/**
	 * This login method only serves to redirect a user to a
	 * location once they have successfully logged in. It does
	 * not attempt to confirm that the user has permission to
	 * be on the page they are being redirected to.
	 */
	public function login()
	{
		$this->is_logged_in();

		if( $this->is_logged_in() )
		
			return redirect('dashboard','refresh');
		
		// Method should not be directly accessible
		if( $this->uri->uri_string() == 'examples/login')
			show_404();

		if( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' )
			$this->require_min_level(1);

		$this->setup_login_form();


	return $this->load->view('users/login');



	}

	// --------------------------------------------------------------

	/**
	 * Log out
	 */
	public function logout()
	{
		$this->authentication->logout();

		// Set redirect protocol
		$redirect_protocol = USE_SSL ? 'https' : NULL;

		redirect( site_url( LOGIN_PAGE . '?' . AUTH_LOGOUT_PARAM . '=1', $redirect_protocol ) );
	}

	// --------------------------------------------------------------

	/**
	 * User recovery form
	 */
	public function recover()
	{
		// Load resources
		$this->load->model('examples/examples_model');

		/// If IP or posted email is on hold, display message
		if( $on_hold = $this->authentication->current_hold_status( TRUE ) )
		{
			$view_data['disabled'] = 1;
		}
		else
		{
			// If the form post looks good
			if( $this->tokens->match && $this->input->post('email') )
			{
				if( $user_data = $this->examples_model->get_recovery_data( $this->input->post('email') ) )
				{
					// Check if user is banned
					if( $user_data->banned == '1' )
					{
						// Log an error if banned
						$this->authentication->log_error( $this->input->post('email', TRUE ) );

						// Show special message for banned user
						$view_data['banned'] = 1;
					}
					else
					{
						/**
						 * Use the authentication libraries salt generator for a random string
						 * that will be hashed and stored as the password recovery key.
						 * Method is called 4 times for a 88 character string, and then
						 * trimmed to 72 characters
						 */
						$recovery_code = substr( $this->authentication->random_salt()
							. $this->authentication->random_salt()
							. $this->authentication->random_salt()
							. $this->authentication->random_salt(), 0, 72 );

						// Update user record with recovery code and time
						$this->examples_model->update_user_raw_data(
							$user_data->user_id,
							[
								'passwd_recovery_code' => $this->authentication->hash_passwd($recovery_code),
								'passwd_recovery_date' => date('Y-m-d H:i:s')
							]
						);

						// Set the link protocol
						$link_protocol = USE_SSL ? 'https' : NULL;

						// Set URI of link
						$link_uri = 'password/recovery_verification/' . $user_data->user_id . '/' . $recovery_code;

						$this->sendLink($this->input->post('email'),site_url().$link_uri);

						$view_data['special_link'] = anchor(
							site_url( $link_uri, $link_protocol ),
							site_url( $link_uri, $link_protocol ),
							'target ="_blank"'
						);

						$view_data['confirmation'] = 1;
					}
				}
				// There was no match, log an error, and display a message
				else
				{
					// Log the error
					$this->authentication->log_error( $this->input->post('email', TRUE ) );

					$view_data['no_match'] = 1;
				}
			}
		}
		//echo $this->load->view('examples/page_header', '', TRUE);
		echo $this->load->view('examples/recover_form', ( isset( $view_data ) ) ? $view_data : '', TRUE );
		//echo $this->load->view('examples/page_footer', '', TRUE);
	}

	// --------------------------------------------------------------

	/**
	 * Verification of a user by email for recovery
	 *
	 * @param  int     the user ID
	 * @param  string  the passwd recovery code
	 */
	public function recovery_verification()
	{

		$user_id = $this->uri->segment(3) ;
		$recovery_code = $this->uri->segment(4);
		/// If IP is on hold, display message
		if( $on_hold = $this->authentication->current_hold_status( TRUE ) )
		{
			$view_data['disabled'] = 1;
		}
		else
		{
			// Load resources
			$this->load->model('examples/examples_model');

			if(strlen( $recovery_code ) == 72 &&

				$recovery_data = $this->examples_model->get_recovery_verification_data( $user_id ) )
			{
				/**
				 * Check that the recovery code from the
				 * email matches the hashed recovery code.
				 */
				if( $recovery_data->passwd_recovery_code == $this->authentication->check_passwd( $recovery_data->passwd_recovery_code, $recovery_code ) )
				{
					$view_data['user_id']       = $user_id;
					$view_data['username']     = $recovery_data->username;
					$view_data['recovery_code'] = $recovery_data->passwd_recovery_code;


				}
				// Link is bad so show message
				else
				{
					$view_data['recovery_error'] = 1;

					// Log an error
					$this->authentication->log_error('');
				}
			}
			// Link is bad so show message
			else
			{
				$view_data['recovery_error'] = 1;

				// Log an error
				$this->authentication->log_error('');
			}

			/**
			 * If form submission is attempting to change password
			 */
			if( $this->tokens->match )
			{
				$this->examples_model->recovery_password_change();
			}
		}

		//echo $this->load->view('examples/page_header', '', TRUE);

		echo $this->load->view( 'examples/choose_password_form', $view_data, TRUE );

		//echo $this->load->view('examples/page_footer', '', TRUE);
	}


	public function sendLink($emails,$link){

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
			                     <h4>Secure Login URL: https://immtradersclub.com/member/login </h4>
			                   	<h3>Reset Link :</h3>
			                    <a href="'.$link.'" style="margin: 8px 0px 10px !important;font-weight: 300;font-size: 20px"> '.$link.'</a>

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


				$mail->send();

				// $this->session->set_userdata(['myemail'=>$emails]);

				// if($this->model_users->count_ref(['email'=>$emails]) > 0 ){
				// 		if(!$mail->send()) {
				// 			//$this->session->set_userdata(['success_msg'=>''])

				// 			 array_push($data,[

				// 	 					'title' 	=>'Oops !',
				// 	 					'msg'		=> 'Something went wrong',
				// 	 					'status'	=>'error'
				// 	 				]);
				// 			}
				// 	else {

				// 		//echo json_encode('success');

				// 		$this->model_users->update(['passwd_recovery_code'=>$code],['email'=>$emails]);
				// 		array_push($data,[

				// 	 					'title' 	=>'Good Job !',
				// 	 					'msg'		=> 'Reset Link has been sent to your email',
				// 	 					'status'	=>'success'
				// 	 				]);
				// 	}
				// }else {


				// 	 array_push($data,[

				// 	 					'title' 	=>'Oops !',
				// 	 					'msg'		=> 'Email Not Found in our record',
				// 	 					'status'	=>'error'
				// 	 				]);
				// }
	}
	// -----------------------------------------------------------------------
}

/* End of file Examples.php */
/* Location: /community_auth/controllers/Examples.php */
