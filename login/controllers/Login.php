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
