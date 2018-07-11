<?php
defined('BASEPATH') or exit('No direct script access allowed');



class PortfolioController  extends MY_Controller
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

						$config 					= array();
        				$config["base_url"] 		= base_url() . "portfolio/my-portfolio";
        				$config["total_rows"] 		= $this->model_portfolio->count_ref(['user_id' => $userid]);
				        $config["per_page"] 		= 10;
				        $config["uri_segment"] 		= 3;
				       

				        $choice 					= $config["total_rows"] / $config["per_page"];
   						$config["num_links"] 		= round($choice);
   						// $config['use_page_numbers'] = TRUE;
				     //    $config['page_query_string'] = TRUE;

   						$config['full_tag_open'] 	= '<ul class="pagination">';
				        $config['full_tag_close'] 	= '</ul>';
				        $config['first_link'] 		= false;
				        $config['last_link'] 		= false;
				        $config['first_tag_open'] 	= '<li>';
				        $config['first_tag_close'] 	= '</li>';
				        $config['prev_link'] 		= '&laquo';
				        $config['prev_tag_open'] 	= '<li class="prev">';
				        $config['prev_tag_close'] 	= '</li>';
				        $config['next_link'] 		= '&raquo';
				        $config['next_tag_open'] 	= '<li>';
				        $config['next_tag_close'] 	= '</li>';
				        $config['last_tag_open'] 	= '<li>';
				        $config['last_tag_close'] 	= '</li>';
				        $config['cur_tag_open'] 	= '<li class="active"><a href="#">';
				        $config['cur_tag_close'] 	= '</a></li>';
				        $config['num_tag_open'] 	= '<li>';
				        $config['num_tag_close'] 	= '</li>';


				        $this->pagination->initialize($config);

				        $page = $this->uri->segment( 3 );
				       
						$data = [
								'userid' 			=> $userid,
								'rank_name' 		=> $rank_name ,
								'achieved_date' 	=> $achieved_date ,
								'results'			=> $this->model_portfolio->fetch_record( $config["per_page"], $page , [ 'portfolio.user_id' => $userid ] ,'package_type','portfolio.package_type=package_type.package_id'),
								'links'				=> $this->pagination->create_links(),
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."'  ORDER BY transaction_date DESC  LIMIT 5 ")->result()
							];

					return $this->load->view('portfolio/portfolio',$data);
				}
				else {
					redirect('login');
				}
	}

	 public function portfolio_details() {


	 	if( $this->is_logged_in() ){

	 				$user_id = $this->auth_user_id;

	 				$this->load->model('model_portfolio');



	 					$result = [] ;
	 					$count =  0 ;
	 					$action = "n/a" ;

	 					foreach ($this->model_portfolio->query("SELECT * FROM  portfolio JOIN package_type ON portfolio.package_type=package_type.package_id WHERE user_id='".$user_id."'")->result() as $key => $value) {
	 						
	 					$count +=1;

	 					if($value->package_type != 3) {
	 								$action = "<button class='btn btn-danger btn-xs' id='close' data-id='".$value->portfolio_id."'><i class='fa fa-close'> </i> Close</button>" ;

	 					}
	 					else {

	 							$action = "N/A" ;

	 					}
	 					array_push($result, 

	 					  					[
	 					  						$count,
	 					  						$value->transaction_no,
	 					  						$value->package_name,
	 					  						date('F d, Y h:i:s A', strtotime($value->transaction_date)),
	 					  						$value->portfolio_amount,
	 					  						' <span class="status--process">Active</span>',
	 					  						$action

	 					  					]

	 					  				);
	 					}
	 					$data = array(
										"sEcho" => 1,
										"iTotalRecords" => count($result),
										"iTotalDisplayRecords" => count($result),
										"aaData"=>$result); 
					echo json_encode($data);


	 	}
		else {
				redirect('login');
			}
	 	}


	public function closeAccount() {


		if($this->is_logged_in()) {

			$id = $this->input->post('id');



			$this->load->model('model_portfolio');
			$this->load->model('model_closeportfolio');

			$msg = "";


			foreach ($this->model_portfolio->select('*',['portfolio_id' => $id]) as $key => $value) {
						

						$close_data  =[
										'portfolio_id'		=>	$value->portfolio_id,
										'user_id'			=>	$value->user_id,
										'package_type'		=>	$value->package_type,
										'portfolio_amount'	=>	$value->portfolio_amount,
										'transaction_no'	=>	$value->transaction_no,
										'date'				=>	$value->date,
										'expiry_date'		=>	$value->expiry_date,
										'transaction_date'	=>	$value->transaction_date,
										'status'			=>	0,
										'action'			=>	'close account'

									 ];
						$this->model_closeportfolio->insert($close_data);

						$this->model_portfolio->delete(['portfolio_id' => $id]);
						$msg = "Close account request has been successfully submitted";
			}


			echo json_encode(['message' => $msg]);


		}
	
	}

	public function cancelCloseAccount() {


		if($this->is_logged_in()) {

			$id = $this->input->post('id');



			$this->load->model('model_portfolio');
			$this->load->model('model_closeportfolio');

			$msg = "";


			foreach ($this->model_closeportfolio->select('*',['portfolio_id' => $id]) as $key => $value) {
						

						$close_data  =[
										'portfolio_id'		=>	$value->portfolio_id,
										'user_id'			=>	$value->user_id,
										'package_type'		=>	$value->package_type,
										'portfolio_amount'	=>	$value->portfolio_amount,
										'transaction_no'	=>	$value->transaction_no,
										'date'				=>	$value->date,
										'expiry_date'		=>	$value->expiry_date,
										'transaction_date'	=>	$value->transaction_date,
										'status'			=>	0,
										'action'			=>	'Package Purchase'

									 ];
						$this->model_portfolio->insert($close_data);

						$this->model_closeportfolio->delete(['portfolio_id' => $id]);
						$msg = "Close account request has been successfully cancelled";
			}


			echo json_encode(['message' => $msg]);


		}
	
	}


	 public function closeaccounts() {

	 			 	if( $this->is_logged_in() ){

	 				$user_id = $this->auth_user_id;

	 				$this->load->model('model_closeportfolio');



	 					$result = [] ;
	 					$count =  0 ;
	 					$action = "Closed" ;
	 					$status ="" ;
	 					$approved_date = "" ;

	 					foreach ($this->model_closeportfolio->query("SELECT * FROM  closeportfolio JOIN package_type ON closeportfolio.package_type=package_type.package_id WHERE user_id='".$user_id."'")->result() as $key => $value) {
	 						
	 					$count +=1;

	 					if($value->status == 0) {
	 								$action = "<button class='btn btn-danger btn-xs' id='cancel' data-id='".$value->portfolio_id."'><i class='fa fa-close'> </i> Cancel</button>" ;

	 								$status = '<span class="status--process">Request Sent</span>';

	 					}
	 					else {
	 							$action = "Closed" ;
	 							$status = '<span class="status--error">Account Closed</span>';

	 					}
	 					if(!empty($value->approved_date)){
	 						$approved_date = date('F d, Y h:i:s A', strtotime($value->approved_date));
	 					}
	 					array_push($result, 
	 					  					[
	 					  						$count,
	 					  						$value->transaction_no,
	 					  						$value->package_name,
	 					  						
	 					  						date('F d, Y h:i:s A', strtotime($value->transaction_date)),
	 					  						$value->portfolio_amount,
	 					  						$status,
	 					  						date('F d, Y h:i:s A', strtotime($value->request_date)),
	 					  						$approved_date,
	 					  						$action,
	 					  					]
	 					  				);
	 					}
	 					$data = array(
										"sEcho" => 1,
										"iTotalRecords" => count($result),
										"iTotalDisplayRecords" => count($result),
										"aaData"=>$result); 
					echo json_encode($data);


	 	}
		else {
				redirect('login');
			}
	 }

	public function closed() {


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

						$config 					= array();
        				$config["base_url"] 		= base_url() . "portfolio/my-portfolio";
        				$config["total_rows"] 		= $this->model_portfolio->count_ref(['user_id' => $userid]);
				        $config["per_page"] 		= 10;
				        $config["uri_segment"] 		= 3;
				       

				        $choice 					= $config["total_rows"] / $config["per_page"];
   						$config["num_links"] 		= round($choice);
   						// $config['use_page_numbers'] = TRUE;
				     //    $config['page_query_string'] = TRUE;

   						$config['full_tag_open'] 	= '<ul class="pagination">';
				        $config['full_tag_close'] 	= '</ul>';
				        $config['first_link'] 		= false;
				        $config['last_link'] 		= false;
				        $config['first_tag_open'] 	= '<li>';
				        $config['first_tag_close'] 	= '</li>';
				        $config['prev_link'] 		= '&laquo';
				        $config['prev_tag_open'] 	= '<li class="prev">';
				        $config['prev_tag_close'] 	= '</li>';
				        $config['next_link'] 		= '&raquo';
				        $config['next_tag_open'] 	= '<li>';
				        $config['next_tag_close'] 	= '</li>';
				        $config['last_tag_open'] 	= '<li>';
				        $config['last_tag_close'] 	= '</li>';
				        $config['cur_tag_open'] 	= '<li class="active"><a href="#">';
				        $config['cur_tag_close'] 	= '</a></li>';
				        $config['num_tag_open'] 	= '<li>';
				        $config['num_tag_close'] 	= '</li>';


				        $this->pagination->initialize($config);

				        $page = $this->uri->segment( 3 );
				       
						$data = [
								'userid' 			=> $userid,
								'rank_name' 		=> $rank_name ,
								'achieved_date' 	=> $achieved_date ,
								'results'			=> $this->model_portfolio->fetch_record( $config["per_page"], $page , [ 'portfolio.user_id' => $userid ] ,'package_type','portfolio.package_type=package_type.package_id'),
								'links'				=> $this->pagination->create_links(),
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."'  ORDER BY transaction_date DESC  LIMIT 5 ")->result()
							];

					return $this->load->view('portfolio/closeportfolio',$data);
				}
				else {
					redirect('login');
				}
	}

}
