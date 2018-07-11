<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Dashboard  extends MY_Controller
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
		$this->load->model('model_purchasehistory');
		$this->load->model('model_transactionhistory');

	}

	public function index () {

				if($this->is_logged_in() ) {

					$userid = " ";
					$rank_name = " ";
					$achieved_date = "";
					$rank_id  = "";

					$this->load->model('model_matrixdownline');
					$this->load->model('model_ewallet');
					$this->load->model('model_rwallet');
					$this->load->model('model_userincomes');
					$this->load->model('model_portfolio');
					$this->load->model('model_rankachievement');
					$this->load->model('model_ranks');
					
					foreach ($this->model_users->query("Select users.user_id,users.rank_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								$userid = $value->user_id;
								$rank_name = $value->rank_name;
								$rank_id  = $value->rank_id;
								$achieved_date = $value->achieved_date;
					}

					$rank_next  = 0 ;

					if($rank_id < 12) {

						$rank_next = $rank_id + 1;
					}
					else {
						$rank_next = $rank_id;
					}

					$paid = 0 ;

					foreach ($this->model_matrixdownline->select('downline_id',['referral_id' => $userid]) as $key => $value) {
							if($this->model_portfolio->count_ref(['user_id' => $value->downline_id]) > 0) {

								$paid +=1;
							}
					}
					$data = [
								'userid' => $userid,
								'rank_name' => $rank_name ,
								'achieved_date' => $achieved_date,
								'rank_id'		=> $rank_id,
								'downlines'		=> $this->model_matrixdownline->count_ref(['referral_id' => $userid,'level <' => 22]),
								'ewallet'		=> $this->model_ewallet->select_data('current_balance',['user_id' => $userid]),
								'rwallet'		=> $this->model_rwallet->select_data('current_balance',['user_id' => $userid]),
								'incomes'		=> $this->model_userincomes->select('*',['user_id' => $userid]),
								'investments'	=> $this->model_portfolio->query("SELECT sum(portfolio.portfolio_amount) as amount,package_type.package_name FROM  portfolio JOIN package_type ON portfolio.package_type=package_type.package_id WHERE user_id='".$userid."' GROUP BY portfolio.package_type")->result(),
								'direct_downlines'	   => $this->model_matrixdownline->count_ref(['referral_id' => $userid,'level' => 1]),
								'current_rank'	=> $this->model_ranks->select('*',['rank_id' => $rank_id]),
								'next_rank'		=> $this->model_ranks->select('*',['rank_id' => $rank_next]),
								'paid_downline' => $paid,
								'imc'					=> $this->model_purchasehistory->sum('coins_received',['user_id' => $userid,'coin_type' => 'IMM']),
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' ORDER BY transaction_date DESC  LIMIT 5 ")->result()

							];

					return $this->load->view('dashboard/dashboard',$data);
				}
				else {

					redirect('login');
				}
	}


}
