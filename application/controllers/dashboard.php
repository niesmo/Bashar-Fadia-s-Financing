<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("User_model", "MUser");
	}

	public function index(){
		$data = array();
		$header = array();
		$user = $this->MUser->get_user();

		$data['user'] = $user;
		$header['title'] = "User Dashboard";
		$this->load->view('templates/head.php', $header);
		$this->load->view('templates/header.php');
		$this->load->view('dashboard/user.php', $data);
		$this->load->view('templates/footer.php');

	}

	public function submit(){
		$data = array();
		$header = array();
		$postedData = $this->input->post();
		$isNewUser = !isset($postedData['user_id']);

		//setting up file upload config
		$cnf['allowed_types'] 	= 'gif|jpg|png';
		$cnf['max_size'] 		= '5120'; //5MB
		$cnf['upload_path'] 	= 'assets/img';
		$this->load->library('upload', $cnf);
		$this->upload->display_errors("<div class='alert alert-danger' role='alert'>", "</div>");

		//setting validation rules
		$this->form_validation->set_error_delimiters("<div class='alert alert-danger' role='alert'>", "</div>");
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('name', 'Full Name', 'required');

		// validating the submited form
		$validation = $this->form_validation->run();

		// form submission failed
		if($validation == FALSE){
			$data['errors'][] = validation_errors();
			$header['title'] = "Submission Failed";
		}


		//form was successfully validated
		else{

			//upload the file
			$uploaded = $this->upload->do_upload();

			//file was not uploaded
			if ($uploaded == FALSE){
				if($isNewUser){
					$data['errors'][] = $this->upload->display_errors();
					$header['title'] = "Submission Failed";	
				}
				else{
					$newUser= $this->upload_data($postedData);
					$data['user'] = $newUser;
				}
			}	
			
			// file was successfully updated
			else{
				$data['avatar'] = $this->upload->data();
				$postedData['avatar'] = $data['avatar']['file_name'];
				
				$newUser= $this->upload_data($postedData);
				$data['user'] = $newUser;
			}
		}
		$this->load->view('templates/head.php', $header);
		$this->load->view('templates/header.php');
		$this->load->view('dashboard/user.php', $data);
		$this->load->view('templates/footer.php');
	}

	private function upload_data($postedData){
		$userArr = array(
			"username"=>$postedData['username'],
			"fullName"=>$postedData['name']
			);

		if(isset($postedData['avatar'])){
			$userArr["avatar"] = "assets/img/".$postedData['avatar'];
		}

		if(isset($postedData['user_id'])){
			$userArr['userId'] = $postedData['user_id'];
		}

		$newUser = new $this->MUser($userArr);
		$newUser->save();
		return $newUser;
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */