<?php
date_default_timezone_set("Asia/Jakarta");
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api Contact
 * Controller berhubungan dengan data-data contact
 *
 * @author triswansyah.yuliano@gmail.com
 * @copyright (c) 2015 PT. Swamedia Informatika
 */
 //require APPPATH . '/libraries/REST_Controller.php';
 
class Api_auth extends REST_Controller {
//class Api_auth extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('api_auth/api_auth_model');
	}
	
	public function Anti_si($string) {
        $string = strip_tags(trim(addslashes(htmlspecialchars(stripslashes($string)))));
        return $string;
    }
	
		public function get_login_get() {

		$param['token'] =  $this->Anti_si($id = $this->get('token')); 
		//echo $param['token'];die;
			

$param['client_secret'] = 'Bki3F8hQHxd0UmZ7H7fm';
$param['apps_id'] = '68ad822cc88e0';
$param['token_f'] = $param['token'];

//echo $param['token'];die;
			
$shcrop = 'curl --location --insecure "https://10.59.131.12:8002/utoip-be/api_v1_1/Surrounding_apps/decryptData" --header "Cookie: ci_session=h73amrmi9kqjeqadhis5dsgainb8i8o4" --form "token_data='.$param['token_f'].'" --form "client_secret='.$param['client_secret'].'" --form "apps_id='.$param['apps_id'].'"';

			$SS = shell_exec($shcrop);

			$dataApi = json_decode($SS,true);
			//print_r($dataApi);die;
			
			$msgStatus = 'success';
			$msgD = 'success login';
			
			
			if($dataApi['status'] == 'error'){
				
				$newdata = array(
					'status'		=> 'error',
					'msg'			=> $dataApi['err_msg'],
                                );
								
				//print_r($newdata);die; 		
				$this->session->set_userdata($newdata);
				
				
				redirect(base_url().'login');
				die;
			}
			//print_r($dataApi);die;
			
			$login_result = $this->api_auth_model->loginCheck($dataApi['userinfo']);
						

			
$param['token'] = $dataApi['userinfo']['token'];
$param['apps_id'] = $dataApi['userinfo']['apps_id'];
$param['username'] = $dataApi['userinfo']['username'];
$param['group_id'] = $dataApi['userinfo']['group_id'];

// print_r($param);die;
			
$shcrop2 = 'curl --location --insecure "https://10.59.131.12:8002/utoip-be/api_v1_1/Surrounding_apps/getMenuList" --header "Cookie: ci_session=h73amrmi9kqjeqadhis5dsgainb8i8o4" --form "token='.$param['token'].'" --form "apps_id='.$param['apps_id'].'" --form "username='.$param['username'].'" ';
			
			//echo $shcrop2;die;

			$SSw = shell_exec($shcrop2);
			$dataApiMenu = json_decode($SSw,true);
			
			// echo "<pre>";
			// print_r($dataApiMenu);die;
			// echo "</pre>";
			
			$menuW = '';
			foreach($dataApiMenu['menu_info'] as $dataApiMens){
				$menuW .= "'".$dataApiMens['MODULE_ID']."',";
			}
			
			$menuW = substr($menuW, 0, -1);
			
			$weh = $this->api_auth_model->menuLists($menuW);
			
			$menuS = '';
			foreach($weh as $wehs){
				$menuS .= $wehs['id'].",";
			}
			$menuS = substr($menuS, 0, -1);
			
			$array_menu = explode(',',$menuS);
			
			$array_log['user'] = $dataApi;
			$array_log['menu'] = $dataApiMenu;
			$array_log['date'] = date('YmdHis');
			
			file_put_contents('/data/opep/srcs/file/log_users/log_menu_'.$param['username'].'_'.$array_log['date'].'.txt', print_r($array_log, true));
	
			$red_page = '';
			if(in_array("48",$array_menu)){
				$red_page = 'tvprogramun3';
			}elseif(in_array("237",$array_menu)){
				$red_page = 'epg_config';
			}elseif(in_array("254",$array_menu)){
				$red_page = 'logproof_load';
			}else{
			
				$newdata = array(
					'status'		=> 'error',
					'msg'			=> 'Menu Not Found',
                                );
								
				//print_r($newdata);die; 		
				$this->session->set_userdata($newdata);
				
				
				redirect(base_url().'login');
				die;
			}
			
			
			// echo "<pre>";
			// print_r($dataApiMenu);die;
			// echo "</pre>";
			
			
			
			if ( ! empty($this->session->userdata('user_id')) ) {
				//$this->session->sess_destroy();
			}
				
				$newhasil = $dataApi['userinfo'];
				 $newdata = array
                                        (
											'status'		=> 'success',
											'msg'			=> 'success login',
                                            'user_id'		=> $login_result['id'],
                                            'token'		    => $newhasil['token'],
                                            'username' 		=> $newhasil['username'],
                                            'nama' 			=> $newhasil['fullname'],					
                                            'id_role' 		=> $newhasil['group_id'],
                                            'role_id' 		=> $newhasil['group_id'],
                                            'role_name' 	=> $newhasil['group'],
                                            'type_role' 	=> '2',
                                            'day_activation'=> '0',
                                            'id_unit'		=> '0',
                                            'nokontak2'		=> '',
                                            'nokontak3'		=> '',
                                            'id_profile'	=> '',
                                            'id_profile2'	=> '',
                                            'id_profile3'	=> '',
											'id_profile4'	=> '',
											'red_page'	=> $red_page,
											'menuL'	=> $menuS,
											'menuAPI'	=> $menuW
											


                                );
								
				//print_r($newdata);die; 		
				$this->session->set_userdata($newdata);
				//session_regenerate_id(true); 
	
			$res = array(
				'status' => 'success',
				'data' => $newdata,
				'message' => ''
			);
		
		//print_r($this->session->userdata());die;
		
		//$this->output->set_content_type('application/json')->set_output(json_encode($res));
		
		//redirect("https://inrate.telkomsel.co.id/app/tvprogramun3");
		redirect(base_url().$red_page);
		//redirect(base_url().'tvprogramun3tvvir');
	}
	
	// public function login() {		
			// //$this->session->sess_destroy();
			// $_POST = json_decode(file_get_contents("php://input"), true);
			
			// //$att = $this->api_auth_model->limitr($data);
			// $att = 0;
			
			// if($att > 30){
				// $return = array('success' => false, 'message' => 'Too Many Requests ', 'data' => array());
				// $this->output->set_content_type('application/json')->set_output(json_encode($return));
			// }else{
				// $this->api_auth_model->insert_att($insert_att);
				
				
				// $this->load->library('form_validation');
				// $this->form_validation->set_rules('username', 'Username', 'required');
				
				// $newdata = array();
				// if ($this->form_validation->run() == FALSE)  {
					// $result = array( 'success' => false, 'message' => validation_errors() );
					// $this->output->set_content_type('application/json')->set_output(json_encode($result));
				// } else if ($this->form_validation->run() == TRUE)  {
					
					// $user =   str_replace('_','',str_replace('%','',str_replace('\\','',str_replace('"','',str_replace("'","",$this->Anti_si($this->input->post('username', true)))))));
					// $pass =   str_replace('_','',str_replace('%','',str_replace('\\','',str_replace('"','',str_replace("'","",$this->Anti_si($this->input->post('password', true)))))));
					
					
					// $data = array (
						// 'username' 		=> $user,
						// 'password' 		=> $pass,
					// );
					
					// $login_result = $this->api_auth_model->login($data);
					// if ( $login_result['message']== 'Success') {
					
						// $hasilnya = $this->api_auth_model->get_profile($data);              
						 
						// if(isset($hasilnya[0])){
						  
							// if($hasilnya[0]['role_id'] == 1 || $hasilnya[0]['role_id'] == 3 || $hasilnya[0]['role_id'] == 19 || $hasilnya[0]['role_id'] == 79 || $hasilnya[0]['role_id'] == 90 || $hasilnya[0]['role_id'] == 40 || $hasilnya[0]['role_id'] == 999 || $hasilnya[0]['role_id'] == 74 ){
								
									// foreach($hasilnya as $newhasil){
										// $newdata = array
												// (
													// 'user_id'		=> $newhasil['user_id'],
													// 'token'		    => $login_result['data']['token'],
													// 'username' 		=> $newhasil['username'],
													// 'nama' 			=> $newhasil['nama'],					
													// 'id_role' 		=> $newhasil['id_role'],
													// 'user_name' 		=> $newhasil['user_name'],
													// 'user_full_name' 		=> $newhasil['user_full_name'],
													// 'role_id' 		=> $newhasil['role_id'],
													// 'role_name' 		=> $newhasil['role_name'],
													// 'status_pwd' 		=> $newhasil['status_pwd'],
													// 'type_role' 		=> $newhasil['type_role'],
													// 'day_activation' 		=> '0',
													// 'id_unit'		=> $newhasil['id_unit'],
													// 'nokontak2'		=> $newhasil['nokontak2'],
													// 'nokontak3'		=> $newhasil['nokontak3'],
													// 'id_profile'	=> $newhasil['id_profile'],
													// 'id_profile2'	=> $newhasil['id_profile2'],
													// 'id_profile3'	=> $newhasil['id_profile3'],
													// 'id_profile4'	=> $newhasil['id_profile4'],
													// 'menuL'	=> $newhasil['menuL']


										// );
									// }
									
									
									 // $this->session->set_userdata($newdata);
									 

								 // $return = array(
									// 'success' => true,
									// 'message' => 'Success',
									// 'data' => $newdata
									// );
									
									// session_regenerate_id(true); 
									
							// }else{
								  // $aktivasi = $this->api_auth_model->get_activation($data, $hasilnya);
								// if(isset($aktivasi[0])){
									
									// if(!$aktivasi){
									  
											 // $return = array('success' => false, 'message' => 'Your account has been expired!', 'data' => array());
									// }else{
											// if($aktivasi[0]['activation_id'] == 2){
												
													// foreach($hasilnya as $newhasil){
														// $newdata = array
																// (
																	// 'user_id'		=> $newhasil['user_id'],
																	// 'token'		    => $login_result['data']['token'],
																	// 'username' 		=> $newhasil['username'],
																	// 'nama' 			=> $newhasil['nama'],					
																	// 'id_role' 		=> $newhasil['id_role'],
																	// 'user_name' 		=> $newhasil['user_name'],
																	// 'user_full_name' 		=> $newhasil['user_full_name'],
																	// 'role_id' 		=> $newhasil['role_id'],
																	// 'role_name' 		=> $newhasil['role_name'],
																	// 'status_pwd' 		=> $newhasil['status_pwd'],
																	// 'type_role' 		=> $aktivasi[0]['activation_id'],
																	// 'day_activation' 		=> $aktivasi[0]['expiredday'],
																   // 'id_unit'		=> $newhasil['id_unit'],
																	// 'nokontak2'		=> $newhasil['nokontak2'],
																	// 'nokontak3'		=> $newhasil['nokontak3'],
																	// 'id_profile'	=> $newhasil['id_profile'],
																	// 'id_profile2'	=> $newhasil['id_profile2'],
																	// 'id_profile3'	=> $newhasil['id_profile3'],
																	// 'id_profile4'	=> $newhasil['id_profile4'],
																	// 'menuL'	=> $newhasil['menuL']
				
				
														// );
													// }
													
													// $this->session->set_userdata($newdata);

													// $role		= $newhasil['id_role'];
													// if ($role == 10 ){
														// $urlss = 'dashboardfreetoair'; 
													// }
													// elseif ($role == 1 ||$role == 19  ){
														// $urlss = 'dashboard';
													// }
													// elseif ($role == 3 ){
														// $urlss = 'createuser';
													// }
													// elseif ($role == 40 ){
														// $urlss = 'createprofileglobal';
													// }
													// elseif ($role == 41 || $role == 42 ){
														// $urlss = 'dashboarddata';
													// }
													// elseif ($role == 25 ||  $role == 35 ||  $role == 27 ||  $role == 33){
														// $urlss = 'tvprogramun3';
													// }elseif ($role == 645 ){
														// $urlss = 'tvprogramun3tvsea';
													// }
													// elseif ($role == 1000001 || $role == 1000000 || $role == 1000002 || $role == 30000001 || $role == 50 || $role == 55 || $role == 74 || $role == 60 || $role == 49 || $role == 5555 || $role == 5566  || $role == 5577 || $role == 5599 ){
														// $urlss = 'tvprogramun3';
													// }elseif ($role == 90 ){
														// $urlss = 'dashboarduseetv';
													// }elseif ($role == 79 ){
														// $urlss = 'user_usee';
													// }elseif ($role == 999 ){
														// $urlss = 'tvprogramunpro';
													// }elseif ($role == 998 ){
														// $urlss = 'tvpostbuyures';
													// }elseif ($role == 656 ){
														// $urlss = 'respondent';
													// }elseif ($role == 969 ){
														// $urlss = 'tvprogramunres';
													// }elseif ($role == 5002 ){
														// $urlss = 'epg_config';
													// }else{
														// $urlss = 'tvprogramun3';
													// }
													
													// $return = array(
														// 'success' => true,
														// 'message' => 'Success',
														// 'data' => $newdata,
														// 'url' => $urlss
													// );
													
													// session_regenerate_id(true); 
				
											// }elseif($aktivasi[0]['activation_id'] == 3){
												// $return = array('success' => false, 'message' => 'Your account has been expired!', 'data' => array());
											// }else{
												// $return = array('success' => false, 'message' => 'Your account has been suspended!', 'data' => array());
											// }
									// }
									
								// }else{
									// $return = array('success' => false, 'message' => 'Your account has been expired!', 'data' => array());
								// }
								// // die;
								
							// }
						// }
						
						
					// }elseif($login_result['message']== 'OVERLIMIT') {
						// $return = array('success' => false, 'message' => 'User Limit Reach 10 !', 'data' => array());
					// }else{
						// $return = array('success' => false, 'message' => 'Username and Password Incorrect', 'data' => array());
					// }

					// $this->output->set_content_type('application/json')->set_output(json_encode($return));
					
				// }else{
					// $return = array('success' => false, 'message' => 'Validation False ', 'data' => array());
					// $this->output->set_content_type('application/json')->set_output(json_encode($return));
				// }
			// //}
		// }
	// }
	
		
	public function get_logout_get() {

		
		$param['token'] =  $this->session->userdata('token');
		$param['username'] =  $this->session->userdata('username');


$param['client_secret'] = 'Bki3F8hQHxd0UmZ7H7fm';
$param['apps_id'] = '68ad822cc88e0';
$param['token_f'] = $param['token'];
			
$shcrop = 'curl --location --insecure "https://10.59.131.12:8002/utoip-be/api_v1_1/Surrounding_apps/SrLogout" --header "Cookie: ci_session=h73amrmi9kqjeqadhis5dsgainb8i8o4" --form "token='.$param['token_f'].'" --form "username='.$param['username'].'" --form "apps_id='.$param['apps_id'].'"';

			$SS = shell_exec($shcrop);
			$this->session->sess_destroy();
		
		redirect("https://utoip.telkomsel.co.id/Welcome_page");
	}
}

