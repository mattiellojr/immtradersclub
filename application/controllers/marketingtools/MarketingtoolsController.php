<?php
defined('BASEPATH') or exit('No direct script access allowed');



class MarketingtoolsController  extends MY_Controller
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
								'usedata'  		=> $this->model_users->query("Select users.user_id as usrid,users.email ,userinfo.* from users JOIN userinfo ON users.user_id=userinfo.user_id WHERE  users.user_id='".$this->auth_user_id."' ")->result(),
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' ORDER BY transaction_date DESC LIMIT 5 ")->result()

							];


					return $this->load->view('marketingtools/referrallink',$data);
				}
				else {
					redirect('login');
				}
	}
	public function educMaterial() {

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


					return $this->load->view('marketingtools/educt_material',$data);
				}
				else {
					redirect('login');
				}
	}
	public function promo() {

				if($this->is_logged_in() ) {

					$userid 		= " ";
					$rank_name 		= " ";
					$achieved_date 	= " ";

					
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


					return $this->load->view('marketingtools/promo',$data);
				}
				else {
					redirect('login');
				}
	}
}