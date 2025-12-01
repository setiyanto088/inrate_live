<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Login extends MX_Controller {

    public function __construct()
	{
		parent::__construct();	
		$this->load->model('login_model');
		//$this->load->helper(array('captcha'));
	
	}
	
	private function chap(){
		$gbr = imagecreate(200, 50);
 
		//warna background captcha
		imagecolorallocate($gbr, 69, 179, 157);
		 
		// pengaturan font captcha
		$color = imagecolorallocate($gbr, 253, 252, 252);
		$font = "Allura-Regular.otf"; 
		$ukuran_font = 20;
		$posisi = 32;
		// membuat nomor acak dan ditampilkan pada gambar
		$chtp = '';
		for($i=0;$i<=5;$i++) {
			// jumlah karakter
			$angka=rand(0, 9);
		 
			$chtp.=$angka;
			
		 
			$kemiringan= rand(20, 20);
			
			imagettftext($gbr, $ukuran_font, $kemiringan, 8+15*$i, $posisi, $color, $font, $angka);	
		}
		
		//$this->session->set_userdata('mycaptcha', $chtp);
		//untuk membuat gambar 
		// imagepng($gbr); 
		// imagedestroy($gbr);
		
		return imagepng($gbr); 
	}
	
	// public function index()
	// {

		// $this->session->sess_destroy();
		// $this->load->view('login_view');
		
	// }
	
	public function index()
	{
		//echo $this->session->userdata('user_id');die;
		
		//print_r($this->session->userdata());
		//print_r($this->session->userdata());die;
		//$msg 	= $this->session->userdata('msg');
		
		if ( ! empty($this->session->userdata('user_id')) ) {
			
			
			//echo $this->session->userdata('user_id');die;
			$user_id 	= $this->session->userdata('user_id');
			$token		= $this->session->userdata('token');
			$status 	= $this->session->userdata('status_pwd');
			
					 
					 // $query = $this->db->query('SELECT 	COUNT(id) as is_valid
					// FROM 	hrd_profile 
					// WHERE 	id = ?
					// AND id_unit <> 87;', array($user_id) );
					 // $row   = $query->row_array();
					 // if ( ! $row['is_valid']) {
						 
						 // $this->load->view('login_view');

					 // }
					 // else{
							$role		= $user_id 	= $this->session->userdata('role_id');
							$red_page		= $user_id 	= $this->session->userdata('red_page');
							//echo $red_page;die;
							
							//redirect(base_url().''.$red_page); 
							//redirect(base_url().'tvprogramun3');
							
							// if ($role == 10 ){
								// redirect(base_url().'dashboardfreetoair'); 
							// }
							// elseif ($role == 1 ||$role == 19  ){
								// redirect(base_url().'dashboard');
							// }
							// elseif ($role == 3 ){
								// redirect(base_url().'createuser');
							// }
							// elseif ($role == 40 ){
								// redirect(base_url().'createprofileglobal');
							// }
							// elseif ($role == 41 || $role == 42 ){
								// redirect(base_url().'dashboarddata');
							// }
							// elseif ($role == 25 ||  $role == 35 ||  $role == 27 ||  $role == 33){
								// redirect(base_url().'tvprogramun3');
							// }elseif ($role == 645 ){
								// redirect(base_url().'tvprogramun3tvsea');
							// }
							// elseif ($role == 1000001 || $role == 1000000 || $role == 1000002 || $role == 30000001 || $role == 50 || $role == 55 || $role == 74 || $role == 60 || $role == 49 || $role == 5555 || $role == 5566  || $role == 5577 || $role == 5599 ){
								// redirect(base_url().'tvprogramun3');
							// }elseif ($role == 90 ){
								// redirect(base_url().'dashboarduseetv');
							// }elseif ($role == 79 ){
								// redirect(base_url().'user_usee');
							// }elseif ($role == 999 ){
								// redirect(base_url().'tvprogramunpro');
							// }elseif ($role == 998 ){
								// redirect(base_url().'tvpostbuyures');
							// }elseif ($role == 656 ){
								// redirect(base_url().'respondent');
							// }elseif ($role == 969 ){
								// redirect(base_url().'tvprogramunres');
							// }
							// else{
								// redirect(base_url().'tvprogramun3');
							// }
							
							
							
				  //  }
		} else {
			
			$this->load->view('login_view');
			 
		}
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
		
		
		//if($query2 > 0){
			
			
				//$this->session->sess_destroy();
				//sleep(5);
				redirect("https://inrate.telkomsel.co.id/app/api_auth/get_logout/");
		//}
		
		
		
		
		
	}
	
}
