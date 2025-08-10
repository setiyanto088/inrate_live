<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Login extends MX_Controller {

    public function __construct()
	{
		parent::__construct();	
		$this->load->model('login_model');
	
	}
	
	public function index()
	{
		
		$this->session->sess_destroy();
		$this->load->view('login_view');
		
	}

	function _submitLogin()
	{	
		$uname = $this->input->post('username',TRUE); 
		
		echo $uname;

		
		
	}
	
	
	public function keluar()
	{
		
       $user_id = $this->session->userdata['user_id'];
        $token = $this->session->userdata['token'];	
		$sql2	= 'UPDATE t_curr_user SET status_login = 0, date_logout = NOW() where token = ? and user_id = ?';
	
		$query2 	=  $this->db->query($sql2,
			array(
			   $token,
			   $user_id
			));
		
		
		if($query2 > 0){
			
			
				$this->session->sess_destroy();
				redirect(base_url());
		}
		
		
		
	}
	
}
