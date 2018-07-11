<?php
defined('BASEPATH') or exit('No direct script access allowed');



class LevelincomeController  extends MY_Controller
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
        				$config["base_url"] 		= base_url() . "bonus-reports/level-income";
        				$config["total_rows"] 		= $this->model_transactionhistory->count_ref(['user_id' => $userid,'type_id' => 4]);
				        $config["per_page"] 		= 10;
				        $config["uri_segment"] 		= 3;
				        $choice 					= $config["total_rows"] / $config["per_page"];
   						$config["num_links"] 		= round($choice);
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

				        $page = 0 ;

				        //$page = ( $this->uri->segment( 3 ) ) ? $this->uri->segment( 3 ) : 0;
				        if ( !empty($this->uri->segment( 3 ))) {
				        	
				        	$page  = $this->uri->segment( 3 );
				        }
				        else {
				        	$page = 0 ;
				        }
				       
						$data = [
								'userid' 			=> $userid,
								'rank_name' 		=> $rank_name ,
								'achieved_date' 	=> $achieved_date ,
								'results'			=> $this->model_transactionhistory->fetch_record( $config["per_page"], $page , [ 'transactionhistory.user_id' => $userid ,'transactionhistory.type_id' => 4] ,'transactiontype','transactionhistory.type_id=transactiontype.type_id'),
								'links'				=> $this->pagination->create_links(),
								'recent_history' => $this->model_transactionhistory->query("SELECT * from transactionhistory WHERE user_id='".$userid."' AND DATE(transaction_date) = '".date('Y-m-d')."' ORDER BY transaction_date DESC  LIMIT 5 ")->result()
							];

					return $this->load->view('bonusreport/levelincome',$data);
				}
				else {
					redirect('login');
				}
	}


	public function get_history() {


		if( $this->is_logged_in() ) {
			$userid  = $this->auth_user_id;


			$data   =   [] ;

				$counter =	0 ;

				foreach ($this->model_transactionhistory->query("SELECT transactionhistory.*,users.username  FROM transactionhistory JOIN users ON transactionhistory.sender_id=users.user_id WHERE  transactionhistory.user_id='".$userid."' AND  transactionhistory.type_id='4' ORDER BY transaction_id desc LIMIT 1000 ")->result() as $key => $value) {
					
					$counter  += 1 ;

					array_push($data,
									[
										$counter,
										$value->transaction_no,
										$value->sender_id .'-'.$value->username,
										$value->credited_amount,
										$value->remarks,
										date('F d, Y h:i:s A', strtotime($value->transaction_date)),
										$value->description

									]


								);


				}


			$results = array(
									"sEcho" 				=> 1,
									"iTotalRecords"			=> count($data),
									"iTotalDisplayRecords"	=> count($data),
									"aaData" 				=>	$data 	
						); 

				echo json_encode($results);
		}
			else {
				redirect('login');
		}
	}

	public function search_history() {



		if( $this->is_logged_in() ) {

			$userid  = $this->auth_user_id;


			$data   =   [] ;
			$df 	=	$this->input->post('date_from');
			$dt 	=	$this->input->post('date_to');


			if( !empty($df) && !empty($dt)) {


				$counter =	0 ;

				foreach ($this->model_transactionhistory->query("SELECT transactionhistory.*,users.username  FROM transactionhistory JOIN users ON transactionhistory.sender_id=users.user_id WHERE  transactionhistory.user_id='".$userid."' AND  transactionhistory.type_id='4' AND (DATE(transaction_date) >='".$df."' AND DATE(transaction_date) <= '".$dt."')")->result() as $key => $value) {
					
					$counter  += 1 ;

					array_push($data,
									[
										$counter,
										$value->transaction_no,
										$value->sender_id .'-'.$value->username,
										$value->credited_amount,
										$value->remarks,
										date('F d, Y h:i:s A', strtotime($value->transaction_date)),
										$value->description

									]

								);

				}

			}

			else {

				$counter =	0 ;

				foreach ($this->model_transactionhistory->query("SELECT transactionhistory.*,users.username  FROM transactionhistory JOIN users ON transactionhistory.sender_id=users.user_id WHERE  transactionhistory.user_id='".$userid."' AND  transactionhistory.type_id='4' ORDER BY transaction_id desc LIMIT 1000 ")->result() as $key => $value) {
					
					$counter  += 1 ;

					array_push($data,
									[
										$counter,
										$value->transaction_no,
										$value->sender_id .'-'.$value->username,
										$value->credited_amount,
										$value->remarks,
										date('F d, Y h:i:s A', strtotime($value->transaction_date)),
										$value->description

									]

								);

				}


			}
				
			$results = array(
									"sEcho" 				=> 1,
									"iTotalRecords"			=> count($data),
									"iTotalDisplayRecords"	=> count($data),
									"aaData" 				=>	$data 	
						); 

				echo json_encode($results);
		}
			else {
				redirect('login');
		}




	}


}