<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs_man extends JA_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('createprofileu_model');
	}
	
	public function Anti_sql_injection($string) {
		$string = strip_tags(trim(addslashes(htmlspecialchars(stripslashes($string)))));
		return $string;
	}
	
	public function index()
	{
		//session_regenerate_id(TRUE); 
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		$data['token'] = $this->session->userdata('token');
		$menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);
		if(!$this->session->userdata('user_id') || in_array("91",$array_menu) == 0) {
          redirect ('/login');
		}
		
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		if(!$this->session->userdata('user_id') && $this->session->userdata('role_id') <> 878 && $this->session->userdata('role_id') <> 6) {
			redirect ('/login');
		}
		$data['listprofile'] = $this->createprofileu_model->listprofile($iduser,$idrole);
		
		
		$typerole = $this->session->userdata('type_role');
		//$data['listparent'] = $this->createprofileu_model->listdataprofilenew($typerole);
		$data['listperiode'] = $this->createprofileu_model->listperiode();
		$data['min_row'] = $this->createprofileu_model->min_row($typerole);
    
		$data['arr_hours'] = ['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'];
		
		$data['arr_min'] = ['00','05','10','15','20','25','30','35','40','45','50','55'];
		$data['notyet'] = $this->createprofileu_model->listnotyet($iduser,$idrole);
	
		$this->template->load('maintemplate', 'jobs_man/views/listu_view', $data);
	}
	
	public function create(){
		
		
        $typerole = $this->session->userdata('type_role');
		$data['listparent'] = $this->createprofileu_model->listdataprofilenew($typerole);
		
		$this->template->load('maintemplate', 'jobs_man/views/createprofileu_view', $data);
		
	}
	
	public function detail($id){
		$data['detail'] = $this->createprofileu_model->detailnew($id);
		$this->template->load('maintemplate', 'jobs_man/views/detailprofileu_view', $data);
		
	}
	
	
		
	public function list_job_set() 
	 {
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('a.id', 'name', 'people');
		
		$search = $this->input->get_post('search');
		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		$arr_hours = ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'];
		
		$arr_min = ['00','15','30','45'];
		
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		$params['iduser'] 		= $iduser;
		$params['idrole'] 		= $idrole;
		$list = $this->createprofileu_model->list_jobs_set($params);
				
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		
		$data = array();			
		$array_jobs_name = array('MANUAL RUN','AUTO RUN');
		foreach ( $list['data'] as $k => $v ) {
				$ss = '';
				
				if($v['JOBS_STATUS'] == "0"){
					$done_ph = "<select class='sel_set form-control urate-form-input' onchange='getval(this);' name = 'sel_run_".$v['JOBS_ID']."' id = 'sel_run_".$v['JOBS_ID']."'><option value = '0-".$v['JOBS_ID']."' SELECTED = 'SELECTED'>MANUAL RUN</option><option value = '1-".$v['JOBS_ID']."'>AUTO RUN</option></select>";
					
					$hl = '<button id="time_'.$v['JOBS_ID'].'" type="button" onClick="change_time('.$v['JOBS_ID'].',&apos;'.substr($v['TIME_S'],0,-3).'&apos;)" class="button_black" disabled="disabled" style="background-color:#E5E5E5" >'.substr($v['TIME_S'],0,-3).'</button>';
				}else{
					
					$done_ph = "<select class='sel_set form-control urate-form-input' onchange='getval(this);' name = 'sel_run_".$v['JOBS_ID']."' id = 'sel_run_".$v['JOBS_ID']."'><option value = '0-".$v['JOBS_ID']."' >MANUAL RUN</option><option value = '1-".$v['JOBS_ID']."' SELECTED = 'SELECTED'>AUTO RUN </options></select>";
					
					$hl = '<button id="time_'.$v['JOBS_ID'].'" type="button" onClick="change_time('.$v['JOBS_ID'].',&apos;'.substr($v['TIME_S'],0,-3).'&apos;)" class="button_black" >'.substr($v['TIME_S'],0,-3).'</button>';
				}
				
				
				$expl_arr = explode('/',$v['JOBS_LOC']);
				
				$html_sel = 
				array_push($data, 
					array(
						"<p style='text-align:left;vertical-align:middle'>".$v['JOBS_NAME']."</p>",
						"<p style='text-align:left;vertical-align:middle'>".$expl_arr[count($expl_arr)-1]."</p>",
						"<p style='text-align:center'>".$done_ph."<p>",
						"<p style='text-align:center'>".$hl."<p>"
					)
				);
				

			

		}
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	public function list_periode(){
		
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('id', 'name');
		
		$search = $this->input->get_post('search');
		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		$params['iduser'] 		= $iduser;
		$params['idrole'] 		= $idrole;
		$list = $this->createprofileu_model->list_periode($params);
				
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		
		$data = array();		
		foreach ( $list['data'] as $k => $v ) {
			
			$periode = explode('_',$v['name']);
			$dates=date_create($periode[2]);
			$date_name = date_format($dates,"F Y");
			
			array_push($data, 
					array(
						'<p style="text-align:left;vertical-align:middle">'.$date_name.'</p>',
						'<button id="time_'.$v['id'].'" type="button" onClick="change_univ('.$v['id'].',&apos;'.$v['val_int'].'&apos;,&apos;'.$v['name'].'&apos;)" class="button_black" >'.$v['val_int'].'</button>'
					)
				);
			
		}
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
		
	}
	
	public function list_profile() 
	 {
		$menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);
		if(!$this->session->userdata('user_id') || in_array("91",$array_menu) == 0) {
			$result = array('success' => false, 'message' => "Failed to Process", 'data' => '');
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}else{
			
			if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
			if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
			if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
			
			$order = $this->input->get_post('order');
			if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
			if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
			$order_fields = array('a.id', 'name', 'people');
			
			$search = $this->input->get_post('search');
			
			if( ! empty($search['value']) ) {
				$search_value = $search['value'];
			} else {
				$search_value = null;
			}
			
			$params['limit'] 		= (int) $length;
			$params['offset'] 		= (int) $start;
			$params['order_column'] = $order_fields[$order_column];
			$params['order_dir'] 	= $order_dir;
			$params['filter'] 		= $search_value;
			$iduser = $this->session->userdata('user_id');
			$idrole = $this->session->userdata('id_role');
			$params['iduser'] 		= $iduser;
			$params['idrole'] 		= $idrole;
			$list = $this->createprofileu_model->list_profile($params);
					
			$result["recordsTotal"] = $list['total'];
			$result["recordsFiltered"] = $list['total_filtered'];
			$result["draw"] = $draw;
			
			$data = array();			
			$array_jobs_st = array('DONE','ON PROGRESS','ON QUEQUE');
			$array_jobs_name = array('DAILY JOBS EPG','DAILY JOBS CDR','LOGPROOF USEETV JOBS','LOGPROOF MEDIAHUB JOBS','POSTBUY JOBS','MEDIAPLAN JOBS','CHECKING DATA DAILY',
			'CHECKING DATA LOGPROOF','CHECKING DATA LOGPROOF MEDIAHUB','CHECKING DATA MEDIAPLAN','PROCESS EPG','PROCESS LOGPROOF USEETV MONTHLY',
			'PROCESS LOGPROOF MEDIAHUB MONTHLY','DAILY PROFILING FTA','DAILY PROFILING PTV','PROFILING FTA','PROFILING PTV','ANALYZE TABLE','EXTERNAL SCRIPT' );
			foreach ( $list['data'] as $k => $v ) {
					$ss = '';
					
					if($v['STATUS_JOBS'] == 1){
						
						$dad = "<p style='text-align:left;vertical-align:middle;color:green'>".$array_jobs_st[$v['STATUS_JOBS']]."</p>";
						
					}else{
						$dad = "<p style='text-align:left;vertical-align:middle;color:red'>".$array_jobs_st[$v['STATUS_JOBS']]."</p>";
					}
					
					if($v['QUEUE'] == 66 || $v['QUEUE'] == 61){
						array_push($data, 
						array(
							$dad,
							"<p style='text-align:left;vertical-align:middle'>Treg Jobs</p>",
							"<p style='text-align:left;vertical-align:middle'>".$v['JOBS_DATE']."</p>",
							"<p style='text-align:left'>".$v['JOBS_DESC']."<p>"
						)
					);
					}else{
						array_push($data, 
						array(
							$dad,
							"<p style='text-align:left;vertical-align:middle'>".$array_jobs_name[$v['QUEUE']]."</p>",
							"<p style='text-align:left;vertical-align:middle'>".$v['JOBS_DATE']."</p>",
							"<p style='text-align:left'>".$array_jobs_name[$v['QUEUE']]." ".$v['JOBS_DATE']."<p>"
						)
					);
					}
					
					
					

				

			}
			$result["data"] = $data;
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
    }
	
	public function fe_view($kkk){
		
		if($kkk == "0"){
			
			$rtr = "<span'>Not Process<span>";
			
		}elseif($kkk == "1"){
			
			$rtr = "<span'>0 %<span>";
			
		}else{
			
			$rtr = "<span>".$kkk."<span>";
		}
		
		return $rtr;
		
	}
	

	public function change_min_row(){
		$menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);
		if(!$this->session->userdata('user_id') || in_array("89",$array_menu) == 0) {
			$result = array('success' => false, 'message' => "Failed to Process", 'data' => '');
		}else{
			
			$set_min = $_POST['set_min'];
			$tokens = $_POST['tokens'];
			$token = $_POST['token'];
			$secs = $this->validate_owdol($token);
			
			if($secs > 0){
				$result = array( 'success' => false, 'message' => 'Request Failed to Process', 'data' => array('hasil' => 'aaaa'));
			}else{
				
				if(is_numeric($set_min)==0 || $set_min < 0){
					
					$result = array( 'success' => false, 'message' => 'Parameter not Valid', 'data' => array('hasil' => 'aaaa'));
				}else{
					
					$params['token']= $token;
					$params['uid']= $this->session->userdata('user_id');

					$curr = $this->createprofileu_model->change_min_row($set_min);
					$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => 'aaaa'));
			
				}
			
			}
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}		
	
	public function change_npr(){
		

		$str = $_POST['str'];
		$token = $_POST['tokens'];
		
		$dates=date_create($str);
		$date_name = date_format($dates,"Ym");
		
		$params['token']= $token;
		$params['uid']= $this->session->userdata('user_id');
		
		$validate = $this->tvprogramun_model->validate_password($params);
		
		if($validate['status'] == 0){
			$result = array(
					 'success' => true,
					'status' => 'error',
					'message' => $validate['message'],
					'data' => array('hasil' => 'aaaa')
				);
		
		}else{
			$command = 'php /var/www/jobs/steve/JOBS/testing/zte/nper_jobs.php '.$date_name;
			$pid = shell_exec($command);
			$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => 'aaaa'));
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
	}	
	
	
	
	public function change_time_jobs(){
		 $menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);
		if(!$this->session->userdata('user_id') || in_array("89",$array_menu) == 0) {
			
			$result = array('success' => false, 'message' => "Failed to Edit", 'data' => '');
         // redirect ('/login');
		}else{
		//$data_post['str'] = $_POST['id'];
			$data_post['str'] = $this->Anti_sql_injection($this->input->post('id', TRUE));
			$data_post['set_hours'] = $_POST['set_hours'];
			$data_post['set_min'] = $_POST['set_min'];
			$data_post['token'] = $_POST['token'];
			$secs = $this->validate_owdol($data_post['token']);
			
			if($secs > 0){
				$result = array( 'success' => false, 'message' => 'Request Failed to Process', 'data' => array('hasil' => 'aaaa'));
			}else{
				
				$arr_hours = ['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'];
				$arr_min = ['00','05','10','15','20','25','30','35','40','45','50','55'];
				$arr_od = ['10','11'];
				
				$channel_error = 0;
				if(in_array(str_replace("'","",$data_post['set_hours']),$arr_hours) == 0){
						$channel_error++;
				}
				
				if(in_array(str_replace("'","",$data_post['set_min']),$arr_min) == 0){
						$channel_error++;
				}
				
				if(in_array(str_replace("'","",$data_post['str']),$arr_od) == 0){
						$channel_error++;
				}
				
				if($channel_error > 0){
						$result = array('success' => false, 'message' => "Parameters not Valid", 'html' => $channel_error);
						//$this->output->set_content_type('application/json')->set_output(json_encode($result));
				}else{
				
					$data_post['token'] = $_POST['tokens'];
							
					$params['token']= $token;
					$params['uid']= $this->session->userdata('user_id');
				
					$curr = $this->createprofileu_model->change_jobs_time($data_post['str'],$data_post['set_hours'],$data_post['set_min']);
					$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => 'aaaa'));
				}
			
			}
		
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
	}
	
	public function change_univ_jobs(){
		 $menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);
		if(!$this->session->userdata('user_id') || in_array("89",$array_menu) == 0) {
			
			$result = array('success' => false, 'message' => "Failed to Edit", 'data' => '');
         // redirect ('/login');
		}else{
			
			$str = $_POST['id'];
			$set_name = $_POST['set_name'];
			$set_univ = $_POST['set_univ'];
			$token = $_POST['token'];
			$secs = $this->validate_owdol($token);
			
			if($secs > 0){
				$result = array( 'success' => false, 'message' => 'Request Failed to Process', 'data' => array('hasil' => 'aaaa'));
			}else{
				if(is_numeric($set_univ)==0 || $set_univ < 0){
					
					$result = array( 'success' => false, 'message' => 'Parameter not Valid', 'data' => array('hasil' => 'aaaa'));
				}else{
					$params['token']= $token;
					$params['uid']= $this->session->userdata('user_id');
					
					$channel_error = 0;
					$get_list_channel = $this->createprofileu_model->get_list_per();
					$arr_chnel_l = [];
					foreach($get_list_channel as $get_list_channelsa){
						$arr_chnel_l[] = $get_list_channelsa['name'];
					}
					
					if(in_array(str_replace("'","",$set_name),$arr_chnel_l) == 0){
						$channel_error++;
					}
					
					if($channel_error > 0){
						$result = array('success' => false, 'message' => "Parameters not Valid", 'html' => $channel_error);
						//$this->output->set_content_type('application/json')->set_output(json_encode($result));
					}else{
					
						$curr = $this->createprofileu_model->change_jobs_univ($str,$set_name,$set_univ);
						$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => 'aaaa'));
					
					}
				}
			
			}
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
	}
	
	public function change_jobs(){
		
		$str = $_POST['str'];
		
		
		$ar_str = explode("-",$str);
		
		$curr = $this->createprofileu_model->change_jobs($ar_str);
		
		$result = array( 'success' => true, 'message' => 'Success', 'data' => array('hasil' => 'aaaa'));
			
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
	}


}
