<?php
defined('BASEPATH') or exit('No direct script access allowed');



class DownlinepurchaseController  extends MY_Controller
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
		

	}

	public function index () {
			
				
				if( $this->is_logged_in() ) {

					$this->load->model('model_rwallet');
					$this->load->model('model_portfolio');
					$this->load->library("pagination");
					

						$userid  			= " " ;
						$rank_name 			= " " ;
						$achieved_date 		= " ";
						$current_balance 	= 0 ;

						foreach ($this->model_users->query("Select users.user_id,ranks.rank_name,rankachievement.achieved_date from users JOIN userinfo ON users.user_id=userinfo.user_id JOIN ranks ON users.rank_id=ranks.rank_id JOIN rankachievement ON users.user_id=rankachievement.user_id where users.user_id='".$this->auth_user_id."'")->result() as $key => $value) {
								$userid 		= $value->user_id;
								$rank_name 		= $value->rank_name;
								$achieved_date 	= $value->achieved_date;
						}

						
				      
				       
						$data = [
									'userid' 			=> $userid,
									'rank_name' 		=> $rank_name ,
									'achieved_date' 	=> $achieved_date ,
									'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' LIMIT 5 ")->result()
								];

					return $this->load->view('otherreport/downline_purchases',$data);
				}
				else {
					redirect('login');
				}
	}

	public function search_downline_purchases() {

						$this->is_logged_in() ;

						$userid =	$this->input->post('user_id');
						$start 	=	$this->input->post('date_from');
						$end 	=	$this->input->post('date_to');


						$total_downline_purchase 		 = 0 ;
						$total_downline_purchase_current = 0 ;
						$total_self_purchase_current 	 = 0 ;
						$total_self_purchase 	 		 = 0 ;

						$result = [] ;

						
						$this->load->model('model_matrixdownline');
						$this->load->model('model_portfolio');
						if( !empty($userid) ) {

							 if(  !empty( $start )  && !empty( $end )   ) {

							 	$count = 0 ;
							 	foreach ($this->model_matrixdownline->select('*',['referral_id' => $userid ,'level <' => 22]) as $key => $value) {
										foreach ($this->model_users->query("SELECT user_id,username from users  WHERE user_id='".$value->downline_id."'")->result() as $key => $user) {


											//$total	= $this->model_portfolio->sum('portfolio_amount',[ 'user_id' => $value->downline_id ]);
											foreach ($this->model_portfolio->select('portfolio_amount,transaction_date',['user_id'=>$user->user_id,'DATE(transaction_date) >=' => $start ,'DATE(transaction_date) <=' => $end]) as $key => $value2) {

												$count +=1;
												
												array_push($result,[ $count,$user->user_id,$user->username, $value2->portfolio_amount ,$value->level,date('F d, Y h:i:s A', strtotime($value2->transaction_date))]);
											}
										}
									}
							 }
							 else {

							 	$count = 0 ;
							 	foreach ($this->model_matrixdownline->select('*',['referral_id' => $userid ,'level <' => 22]) as $key => $value) {
										foreach ($this->model_users->query("SELECT user_id,username from users  WHERE user_id='".$value->downline_id."'")->result() as $key => $user) {


											


										foreach ($this->model_portfolio->select('portfolio_amount,transaction_date',['user_id'=>$user->user_id]) as $key => $value2) {
												
												$count +=1;
												array_push($result,[ $count,$user->user_id,$user->username, $value2->portfolio_amount ,$value->level,date('F d, Y h:i:s A', strtotime($value2->transaction_date))]);
											}
									}
								}

							 }

						}

						else {

								$userid 	= $this->auth_user_id;

								if( !empty( $start )  && !empty( $end ) ) {
									$count = 0 ;
							 		
							 		foreach ($this->model_matrixdownline->select('*',['referral_id' => $userid ,'level <' => 22]) as $key => $value) {
										foreach ($this->model_users->query("SELECT user_id,username from users  WHERE user_id='".$value->downline_id."'")->result() as $key => $user) {


											

											foreach ($this->model_portfolio->select('portfolio_amount,transaction_date',['user_id'=>$user->user_id,'DATE(transaction_date) >=' => $start ,'DATE(transaction_date) <=' => $end]) as $key => $value2) {
												$count +=1;
												array_push($result,[ $count,$user->user_id,$user->username, $value2->portfolio_amount ,$value->level,date('F d, Y h:i:s A', strtotime($value2->transaction_date))]);
											}

											
										}
									}
							 }
							 else {
							 		$count = 0 ;

							 	
							 	foreach ($this->model_matrixdownline->select('*',['referral_id' => $userid ,'level <' => 22]) as $key => $value) {
										foreach ($this->model_users->query("SELECT user_id,username from users  WHERE user_id='".$value->downline_id."'")->result() as $key => $user) {

											

										foreach ($this->model_portfolio->select('portfolio_amount,transaction_date',['user_id'=>$user->user_id]) as $key => $value2) {
												$count +=1;
												array_push($result,[ $count,$user->user_id,$user->username, $value2->portfolio_amount ,$value->level,date('F d, Y h:i:s A', strtotime($value2->transaction_date))]);
											}
									}
								}

							 }
						}

				$data = array(
										"sEcho" => 1,
										"iTotalRecords" => count($result),
										"iTotalDisplayRecords" => count($result),
										"aaData"=>$result); 
			echo json_encode($data);
	}

}