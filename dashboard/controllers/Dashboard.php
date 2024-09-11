<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('dashboard_model');
	}
	
	public function index()
	{
		$role_id = $this->session->userdata('role_id');
		if($role_id == 6){
			$this->template->load('maintemplate', 'dashboard/views/dashboard_view_tech');
		}else{
			
			$data['currentuser'] = $this->dashboard_model->currentuser();
			$data['loginuser'] = $this->dashboard_model->loginuser();
			$data['premiumuser'] = $this->dashboard_model->premiumuser();
			$data['trialuser'] = $this->dashboard_model->trialuser();
			$this->template->load('maintemplate', 'dashboard/views/dashboard_view_super', $data);
		}
		
		
	}
	
	public function activity()
	{
			$this->template->load('maintemplate', 'dashboard/views/dashboard_view_activity');
	}
	
	
	public function detailuseraktif($id)
	{
            $data['id'] = $id;
			$this->load->view('detailuseraktif_view', $data );
		
	}
	public function detailuser($id)
	{
            $data['id'] = $id;
            $data['detailuser'] = $this->dashboard_model->detail($id);
            $data['history'] = $this->dashboard_model->history($id);
            // print_r( $data['detailuser']); die;
			$this->template->load('maintemplate', 'dashboard/views/dashboard_view_activity', $data);
				// $this->load->view('detailuser_view', $data );
		
	}
	
	
	
	public function updateRole()
	{
        $postdata 	= file_get_contents("php://input");
		$request 	= json_decode($postdata,true);
      
		$result = $this->dashboard_model->updateRole($request);

		if ( $result ) {			
			$result = array( 'success' => true, 'message' => 'Approve Success!');
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		} else {
			$result = array( 'success' => false, 'message' => 'Error Ketika Memasukan Ke Database' );
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
	
	
	public function list_user2() 
	 {
		 
		 $role_id = $this->session->userdata('role_id');
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array( 'nama', 'activation', 'status_activation', 'expiredday');
		
		$search = $this->input->get_post('search');
		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		// Build params for calling model 
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		
		$list = $this->dashboard_model->list_user($params);
				
		//var_dump($list['data']);die;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		// echo "<pre>";
		// print_r($list['data']); die;
		$data = array();
		$ss = '';		
		$sa = '';		
		$sss = '';		
		$svart = '';		
		if(!empty($v['statappv'])){
			$svart = $v['statappv'];	
		}else{
			$svart = 0;	
		}
		
		
		if($role_id == 6){
						// echo 123; die;
					foreach ( $list['data'] as $k => $v ) {
						if($v['status_user'] == 6){
							$ss = "Dinas";
						}elseif($v['status_user'] == 4){
							$ss = "Admin";
						}else{
							if($v['activation'] == 0){
								$ss = "Not Registed";
							}elseif($v['activation'] == 1){
								$ss = "Paid";
							}elseif($v['activation'] == 2){
								$ss = "Trial";
							}elseif($v['activation'] == 3){
								$ss = "Expired";
							}
						}
							
							
							
							if($v['status_activation'] == 0){
								$sa = "Waiting Approved Trial";
							}elseif($v['status_activation'] == 1){
								$sa = "Approved Trial";
							}elseif($v['status_activation'] == 2){
								$sa = "Waiting Approved Paid";
							}elseif($v['status_activation'] == 3){
								$sa = "Rejected";
							}elseif($v['status_activation'] == 4){
								$sa = "Approved Paid";
							}
							if($v['expiredday']){
								$sas = $v['expiredday']." days";
							}elseif($v['expiredday'] < 0){
								$sas = "0 days";
							}else{
								$sas = "0 days";
							}
							
							if($v['statappv'] == 0){
								$sss = "<a href='javascript:void(0)' onClick='approved(".$v['id'].", 1)' ><button class='btn btn-success waves-effect' >Approve Trial</button></a><a href='javascript:void(0)' onClick='reject(".$v['id'].", 3)' ><button class='btn btn-danger waves-effect' >Reject</button></a>";
							}elseif($v['statappv'] == 2){
								$sss = "<a href='javascript:void(0)' onClick='approved(".$v['id'].", 4)' ><button class='btn btn-success waves-effect' >Approve Paid</button></a><a href='javascript:void(0)' onClick='reject(".$v['id'].", 3)' ><button class='btn btn-danger waves-effect' >Reject</button></a>";
							}elseif($v['statappv'] == 3){
								$sss = "<button class='btn btn-warning waves-effect' disabled>Rejected</button>";
							}elseif($v['statappv'] == 1){
								$sss = "<button class='btn btn-info waves-effect' disabled>Approved Trial</button>";
							}elseif($v['statappv'] == 4){
								$sss = "<button class='btn btn-info waves-effect' disabled>Approved Paid</button>";
							}
								
		
						array_push($data, 
							array(
								// $v['id'], 
								$v['nama'] ,
								$ss ,
								$sa,
								$sas,
								'<a  target="_blank" href="'.$v['doc'].'">Download</a>',
								$sss
								
							)
						);
					}
					
		}else{	
		
							// echo 456; die;
					foreach ( $list['data'] as $k => $v ) {
						
						if($v['status_user'] == 6){
							$ss = "Dinas";
						}elseif($v['status_user'] == 4){
							$ss = "Admin";
						}else{
							if($v['activation'] == 0){
								$ss = "Not Registed";
							}elseif($v['activation'] == 1){
								$ss = "Paid";
							}elseif($v['activation'] == 2){
								$ss = "Trial";
							}elseif($v['activation'] == 3){
								$ss = "Expired";
							}
						}
							
							
							
							if($v['status_activation'] == 0){
								$sa = "Waiting Approved Trial";
							}elseif($v['status_activation'] == 1){
								$sa = "Approved Trial";
							}elseif($v['status_activation'] == 2){
								$sa = "Waiting Approved Paid";
							}elseif($v['status_activation'] == 3){
								$sa = "Rejected";
							}elseif($v['status_activation'] == 4){
								$sa = "Approved Paid";
							}
							
							
							if($v['expiredday'] > 0){
								$sas = $v['expiredday']." days";
							}elseif($v['expiredday'] < 0){
								$sas = "0 days";
							}else{
								$sas = "0 days";
							}
						array_push($data, 
							array(
								"<a href='".base_url('dashboard/detailuser')."/".$v['id']."' >".$v['nama']."</a>" , 
								$ss ,
								"<a href='javascript:void(0)' onclick='modelmenu(".$v['id_role'].");'>".$v['role']."</a>" ,
								$sa,
								$sas
								
							)
						);
					}
		
		}
		
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	
	public function list_menu(){
		
		$id =  $this->input->post('menu');
		
		$mnu = $this->dashboard_model->list_menu($id);
		$ik = '';
		foreach($mnu as $datax){
					$ik  = $ik.'<tr><td>'.$datax['jenis'].'</td><td>'.$datax['namamenu'].'</td></tr>';;
				}
		
		echo json_encode($ik,true);
		//var_dump($data_ch);die;
		//echo $ik;
	}
	
	public function list_user3() 
	 {
		 
		 $role_id = $this->session->userdata('role_id');
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('id', 'nama', 'activation', 'status_activation', 'expiredday');
		
		$search = $this->input->get_post('search');
		$status = $this->input->get_post('status');
		// print_r($status); die;
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		if($status == 3){
			$jad = 'AND b.activation_id NOT IN (3)';
		}else{
			$jad = 'AND b.activation_id = '.$status.' ';
		}
		// Build params for calling model 
		$params['limit'] 		= (int) $length;
		$params['status'] 		= $jad;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		
		$list = $this->dashboard_model->list_user3($params);
				
		//var_dump($list['data']);die;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		// echo "<pre>";
		// print_r($list['data']); die;
		$data = array();
		$ss = '';		
		$sa = '';		
		$sss = '';		
		$svart = '';		
		if(!empty($v['statappv'])){
			$svart = $v['statappv'];	
		}else{
			$svart = 0;	
		}
		
						// echo 123; die;
					foreach ( $list['data'] as $k => $v ) {
							if($v['activation'] == 0){
								$ss = "Not Registed";
							}elseif($v['activation'] == 1){
								$ss = "Paid";
							}elseif($v['activation'] == 2){
								$ss = "Trial";
							}
							
							
							
							if($v['status_activation'] == 0){
								$sa = "Waiting Approved Trial";
							}elseif($v['status_activation'] == 1){
								$sa = "Approved Trial";
							}elseif($v['status_activation'] == 2){
								$sa = "Waiting Approved Paid";
							}elseif($v['status_activation'] == 3){
								$sa = "Rejected";
							}elseif($v['status_activation'] == 4){
								$sa = "Approved Paid";
							}
							if($v['expiredday']){
								$sas = $v['expiredday']." days";
							}elseif($v['expiredday'] < 0){
								$sas = "0 days";
							}else{
								$sas = "0 days";
							}
							
							if($v['statappv'] == 0){
								$sss = "<a href='javascript:void(0)' onClick='approved(".$v['id'].", 1)' ><button class='btn btn-success waves-effect' >Approve Trial</button></a><a href='javascript:void(0)' onClick='reject(".$v['id'].", 3)' ><button class='btn btn-danger waves-effect' >Reject</button></a>";
							}elseif($v['statappv'] == 2){
								$sss = "<a href='javascript:void(0)' onClick='approved(".$v['id'].", 4)' ><button class='btn btn-success waves-effect' >Approve Paid</button></a><a href='javascript:void(0)' onClick='reject(".$v['id'].", 3)' ><button class='btn btn-danger waves-effect' >Reject</button></a>";
							}elseif($v['statappv'] == 3){
								$sss = "<button class='btn btn-warning waves-effect' disabled>Rejected</button>";
							}elseif($v['statappv'] == 1){
								$sss = "<button class='btn btn-info waves-effect' disabled>Approved Trial</button>";
							}elseif($v['statappv'] == 4){
								$sss = "<button class='btn btn-info waves-effect' disabled>Approved Paid</button>";
							}
								
		
						array_push($data, 
							array(
								// $v['id'], 
								$v['nama'] ,
								$ss ,
								$sa,
								$sas,
								'<a target="_blank" href="'.$v['doc'].'">Download</a>',
								$sss
								
							)
						);
					}
					
		
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	public function list_user_admin() 
	 {
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('nama', 'status_user');
		
		$search = $this->input->get_post('search');
		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		// Build params for calling model 
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		
		$list = $this->dashboard_model->list_user_admin($params);
				
		//var_dump($list['data']);die;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		//print_r($list['data']);
		$data = array();
		$sss = '';
		
		foreach ( $list['data'] as $k => $v ) {
			
			$sss = "<a href='javascript:void(0)' onClick='editUser(".$v['id'].")' ><button class='btn btn-info waves-effect' >Edit</button></a>";
			 
		
			array_push($data, 
				array(
					$v['nama'] ,
					$v['status_user'],
					// $sss
					
				)
			);
		}
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	public function list_activity_detail($token,$id) 
	 {
		  //echo $token."-".$id;die;
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('aa.nama', 'aa.token', 'aa.logged', 'aa.date_login', 'aa.date_logout', 'bb.client_ip');
	
		$search = $this->input->get_post('search');
		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		// Build params for calling model 
		$params['limit'] 		= (int) $length;
		$params['id'] 		= $id;
		$params['token'] 		= $token;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		
		$list = $this->dashboard_model->list_activity_detail($params);
				
		//var_dump($list['data']);die;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		//print_r($list['data']);
		$data = array();
		$sss = '';
		
		foreach ( $list['data'] as $k => $v ) {
			
			if($v['status_login'] == 1){
				$stl = "Logged";
			}else{
				$stl = "Logout";
			}
			
			$new_array = array();
			$new_array[0] = "<p style='margin-left:20px'>".$v['client_ip']."</p>" ;
			$new_array[1] = $stl;
			$new_array[2] = $v['date_login'];
			$new_array[3] = $v['date_logout'];
			$new_array[4] = $v['duration'];
			$new_array[5] = $v['PAGE'] ;
			$new_array[6] = $v['token'] ;
			$new_array[7] = $v['date_formatted'] ;
			 
			
			array_push($data,$new_array);
		}
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	public function list_activity($id) 
	 {
		 
		
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('aa.nama', 'aa.token', 'aa.logged', 'aa.date_login', 'aa.date_logout', 'bb.client_ip');
	
		$search = $this->input->get_post('search');
		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		// Build params for calling model 
		$params['limit'] 		= (int) $length;
		$params['id'] 		= $id;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		
		$list = $this->dashboard_model->list_activity($params);
				
		//var_dump($list['data']);die;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		//print_r($list['data']);
		$data = array();
		$sss = '';
		
		foreach ( $list['data'] as $k => $v ) {
			
			if($v['status_login'] == 1){
				$stl = "Logged";
			}else{
				$stl = "Logout";
			}
			
			$new_array = array();
			$new_array[0] = "<p style='margin-left:20px'>".$v['client_ip']."</p>" ;
			$new_array[1] = $stl;
			$new_array[2] = $v['date_login'];
			$new_array[3] = $v['date_logout'];
			$new_array[4] = $v['duration'];
			$new_array[5] = $v['PAGE'] ;
			$new_array[6] = $v['token'] ;
			 
			
			array_push($data,$new_array);
		}
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	public function list_user_count() 
	 {
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 		
		
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'desc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 
		$order_fields = array('nama', 'currentuser');
		
		$search = $this->input->get_post('search');
		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}
		
		// Build params for calling model 
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		
		$list = $this->dashboard_model->list_user_count($params);
				
		//var_dump($list['data']);die;
		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		//print_r($list['data']);
		$data = array();
		$sss = '';
		
		foreach ( $list['data'] as $k => $v ) {
			
		
			array_push($data, 
				array(
					$v['nama'] ,
					$v['currentuser']
					
				)
			);
		}
		
		$result["data"] = $data;
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
	
	
}
