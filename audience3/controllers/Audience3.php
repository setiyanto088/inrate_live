<?php
date_default_timezone_set('Asia/Jakarta');
defined('BASEPATH') OR exit('No direct script access allowed');

class Audience3 extends JA_Controller {
  public function __construct()
	{
      parent::__construct();			
      $this->load->model('audience_model');
      $this->load->model('createprofileu/createprofileu_model');
	 
	  
	}
	
	public function channelsearch(){
        $typerole = $this->session->userdata('type_role');
		
		
		
        $list = $this->audience_model->channelsearch($this->Anti_si($_GET['q']),$typerole);
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
	
	public function channelsearchss(){
        $typerole = $this->session->userdata('type_role');
        $list = $this->audience_model->channelsearch($this->Anti_si($_GET['q']),$typerole);
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
	
	public function index(){
      $id = $this->session->userdata('project_id');
      $iduser = $this->session->userdata('user_id');
      
	 $test_prod = $this->audience_model->test_new();
	   
	  
      if($id == null){
          $id = 0;
      }else{
          $id = $this->session->userdata('project_id');
      }
      $menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);

		if(!$this->session->userdata('user_id') || in_array("61",$array_menu) == 0) {
          redirect ('/login');
		}
      
      $data['profile'] = $this->audience_model->list_profile();
      $data['daypart'] = $this->audience_model->list_daypart($iduser);
	  $data['channels'] = $this->audience_model->get_channel(); 
      
      $typerole = $this->session->userdata('type_role');
      //$data['listparent'] = $this->createprofileu_model->listdataprofilenew($typerole);
      $data['currdate'] = $this->audience_model->current_date();
      
      $this->template->load('maintemplate', 'audience3/views/audience_view', $data);
	}
	
	
	public function list_audience(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      
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

      $params['start_date'] 	= $start_date;
	   $params['end_date']		= $end_date;
      $params['channel'] 		= $channel;
      
      $params['programsss'] 		=  $programsss;
    
	  $list = $this->audience_model->list_audience($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
		$not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                   $not,
                    $v['SEGMENT'],					
                   number_format($v['VIEWERSS'], 0, ",", "."),
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}

	public function list_audience_city(){	
     if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));			
      
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

      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['channel'] 		= $channel;
      
      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_audience_city($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
		$not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   number_format($v['VIEWERSS'], 0, ",", "."),
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_audience_comm(){	
     if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;
	   
      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_audience_comm($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
		
		 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   number_format($v['VIEWERSS'], 0, ",", "."),
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	
		public function list_audience_web(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
     $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_audience_web($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   number_format($v['VIEWERSS'], 0, ",", "."),
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	public function list_audience_ses(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_audience_ses($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   number_format($v['VIEWERSS'], 0, ",", "."),
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	public function list_audience_arpu(){	
     if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_audience_arpu($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   number_format($v['VIEWERSS'], 0, ",", "."),
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_audience_house(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
	  
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_audience_house($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   number_format($v['VIEWERSS'], 0, ",", "."),
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_audience_digi(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_audience_digi($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   number_format($v['VIEWERSS'], 0, ",", "."),
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_audience_age(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_audience_age($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
 
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   number_format($v['VIEWERSS'], 0, ",", "."),
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	
	public function list_audience_gender(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
	  
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_audience_gender($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   number_format($v['VIEWERSS'], 0, ",", "."),
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_audience_persona(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_audience_persona($params);
	  
	  
	    $result["recordsTotal"] = $list['total'];
        $result["recordsFiltered"] = $list['total_filtered'];
        $result["draw"] = $draw;
        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   number_format($v['VIEWERSS'], 0, ",", "."),
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	
	
	
	public function list_chart_audience_web(){	
     if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_chart_audience_web($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                  	$v['VIEWERSS'],
					 number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
				public function list_chart_audience_ses(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_chart_audience_ses($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                  	 	$v['VIEWERSS'],
					 number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
			public function list_chart_audience_arpu(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_chart_audience_arpu($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   	 	$v['VIEWERSS'],
					 number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
		public function list_chart_audience_house(){	
     if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
     $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_chart_audience_house($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                    	$v['VIEWERSS'],
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience_digi(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_chart_audience_digi($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   	 	$v['VIEWERSS'],
					 number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
		public function list_chart_audience_age(){	
     if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_chart_audience_age($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                   	$v['VIEWERSS'],
					 number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience_gender(){	
     if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_chart_audience_gender($params);

        $data = array();
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                    	$v['VIEWERSS'],
					 number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience_personas(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_chart_audience_personas($params);

        $data = array();
		
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                    	$v['VIEWERSS'],
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
		public function list_chart_audience_comm(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));	
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_chart_audience_comm($params);

        $data = array();
		
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
					 	$v['VIEWERSS'],
					 number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience_city(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_chart_audience_city($params);

        $data = array();
		
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
					 	$v['VIEWERSS'],
					 number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience(){	
      if( ! empty($this->Anti_si($_GET['start_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
	     if( ! empty($this->Anti_si($_GET['end_date'])) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
          $end_date = $date->format('Y-m-d');
      } else {
          $end_date = NULL;
      }
	  
      if( !empty($this->Anti_si($_GET['channel'])) ) {
          $channel = $this->Anti_si($_GET['channel']);
      } else {
          $channel = NULL;
      }
      
      if( !empty($this->Anti_si($_GET['program'])) ) {
          $programsss = $this->Anti_si($_GET['program']);
      } else {
          $programsss = NULL;
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('Field','Segment');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
      
      $search = $this->Anti_si($this->input->get_post('search'));		
      
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

      $params['start_date'] 	= $start_date;
      $params['channel'] 		= $channel;
       $params['end_date']		= $end_date;

      $params['programsss'] 		=  $programsss;
    
      
	  $list = $this->audience_model->list_chart_audience($params);

        $data = array();
		
		
 $not = 1;
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $not,
                    $v['SEGMENT'],					
                    	$v['VIEWERSS'],
				    number_format($v['VIEWERS_DAY'], 2, ",", ".")
                )
            );
			
			$not++;
        }		
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	
	public function list_chart_audience324(){	
      if( ! empty($_POST['start_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['start_date']);
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( !empty($_POST['stime']) ) {
          $start_time = $_POST['stime'];
      } else {
          $start_time = NULL;
      }
      
      if( !empty($_POST['etime']) ) {
          $end_time = $_POST['etime'];
      } else {
          $end_time = NULL;
      }
      
      if( !empty($_POST['tvs']) ) {
          $tvs = $_POST['tvs'];
      } else {
          $tvs = NULL;
      }
      
      if( !empty($_POST['tvr']) ) {
          $tvr = $_POST['tvr'];
      } else {
          $tvr = NULL;
      }
      
      if( !empty($_POST['viewers']) ) {
          $viewers = $_POST['viewers'];
      } else {
          $viewers = NULL;
      }
      if( !empty($_POST['group']) ) {
          $group = $_POST['group'];
      } else {
          $group = NULL;
      }
      
      if( !empty($_POST['subgroup']) ) {
          $subgroup = $_POST['subgroup'];
      } else {
          $subgroup = NULL;
      }
      
      $params['starttime'] 	= $start_time;
      $params['endtime'] 		= $end_time;
      $params['start_date'] 	= $start_date;
      $params['tvs']		= $tvs;
      $params['tvr']		= $tvr;
      $params['viewers']		= $viewers;
      $params['group']		= $group;
      $params['group2']		= '';
      $params['subgroup']		= $subgroup;
      
      foreach($group as $helix){     
          $helix = str_replace("GENDER","DEM_GENDER_PRED",$helix);
          $helix = str_replace("HOUSEHOLD_COMM_EXPENSE","HOUSEHOLD_PROFILE",$helix);
          
          $HELIX_PROF = EXPLODE("=",$helix);
          $list_id = "";
          
          if(count($HELIX_PROF) < 2){
          
          } else {
              $list_KO = $this->audience_model->list_audience($params,$list_id,$HELIX_PROF);
              $arr_data[] =  $list_KO;
          }
      }
      
      if ($arr_data){
          $data = array();
          
          foreach ( $arr_data as $k => $v ) {
              array_push($data, 
                  array(
                      $v['data'][0]['FIELD'],	
                      $v['data'][0]['SEGMENT'],
                      round($v['data'][0]['ANTV'],2),
                      round($v['data'][0]['IVM'],2),
                      round($v['data'][0]['KOMPASTV'],2),
                      round($v['data'][0]['METRO'],2),
                      round($v['data'][0]['NET'],2),
                      round($v['data'][0]['OCHNL'],2),
					  round($v['data'][0]['SCTV'],2),
                      round($v['data'][0]['TRANS'],2),
                      round($v['data'][0]['TRANS7'],2),
                      round($v['data'][0]['TVONE'],2),
                      round($v['data'][0]['TVRI'],2)
                  )
              );
          }	
      }
      
      $result["data"] = $data;
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}
	
	public function list_chart_audience_new(){	
      if( ! empty($_POST['start_date']) ) {
          $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $_POST['start_date']);
          $start_date = $date->format('Y-m-d');
      } else {
          $start_date = NULL;
      }
      
      if( !empty($_POST['stime']) ) {
          $start_time = $_POST['stime'];
      } else {
          $start_time = NULL;
      }
      
      if( !empty($_POST['etime']) ) {
          $end_time = $_POST['etime'];
      } else {
          $end_time = NULL;
      }
      
      if( !empty($_POST['tvs']) ) {
          $tvs = $_POST['tvs'];
      } else {
          $tvs = NULL;
      }
      
      if( !empty($_POST['tvr']) ) {
          $tvr = $_POST['tvr'];
      } else {
          $tvr = NULL;
      }
      
      if( !empty($_POST['viewers']) ) {
          $viewers = $_POST['viewers'];
      } else {
          $viewers = NULL;
      }
      
      if( !empty($_POST['group2']) ) {
          $group = $_POST['group2'];
      } else {
          $group = NULL;
      }
      
      if( !empty($_POST['subgroup']) ) {
          $subgroup = $_POST['subgroup'];
      } else {
          $subgroup = NULL;
      }
      
      $params['starttime'] 	= $start_time;
      $params['endtime'] 		= $end_time;
      $params['start_date'] 	= $start_date;
      $params['tvs']		= $tvs;
      $params['tvr']		= $tvr;
      $params['viewers']		= $viewers;
      $params['group']		= $group;
      
      $HELIX_PROF = EXPLODE("=",$group);
      $list_id = $this->audience_model->get_listid($params,$HELIX_PROF);
      $arr_id = '';
      
      foreach($list_id as $ass){
          $arr_id = $arr_id.'"'.$ass['people'].'",';		
      }
      
      $clean_arr = substr($arr_id, 0, -1);
      
      $list_KO = $this->audience_model->list_audience($params,$clean_arr,$HELIX_PROF);
      
      $arr_data[] =  $list_KO;
      
      if ($arr_data){
          $data = array();
          
          foreach ( $arr_data as $k => $v ) {
              array_push($data, 
                  array(
                      $v['data'][0]['FIELD'],	
                      $v['data'][0]['SEGMENT'],
                      round($v['data'][0]['ANTV'],2),
                      round($v['data'][0]['IVM'],2),
                      round($v['data'][0]['KOMPASTV'],2),
                      round($v['data'][0]['METRO'],2),
                      round($v['data'][0]['OCHNL'],2),
					  round($v['data'][0]['NET'],2),
                      round($v['data'][0]['SCTV'],2),
                      round($v['data'][0]['TRANS'],2),
                      round($v['data'][0]['TRANS7'],2),
                      round($v['data'][0]['TVONE'],2),
                      round($v['data'][0]['TVRI'],2)
                  )
              );
          }	
      }
      
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
	}               
  
      public function list_program(){
        

        
        $param['channel']	= $this->Anti_si($this->input->post('valselect',true));
        $param['date']	= $this->Anti_si($this->input->post('dateselect',true));
        $param['dateend']	= $this->Anti_si($this->input->post('dateend',true));
		
		
      
		 $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $param['dateend']);
          $param['dateend'] = $date->format('Y-m-d');
		  
		   $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $param['date']);
          $param['date'] = $date->format('Y-m-d');
        
        $list = $this->audience_model->list_program($param);
		
        
        if ( $list ) {
            $result = array(
                'success' => true,
                'data' => $list
            );
        } else {
            $result = array(
                'success' => false,
                'message' => 'Data not found'
            );
        } 
        
		 $this->output->set_content_type('application/json')->set_output(json_encode($result));
        
    }
  
  
   public function listsearch(){
        $typerole = $this->session->userdata('type_role');
		
		 $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['d']));
          $_GET['d'] = $date->format('Y-m-d');
		  
		   $dt   = new DateTime();
          $date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['dend']));
          $_GET['dend'] = $date->format('Y-m-d');
		
        $list = $this->audience_model->listsearch($this->Anti_si($_GET['q']),$this->Anti_si($_GET['d']),$this->Anti_si($_GET['dend']),$this->Anti_si($_GET['c']), $typerole);
		
        
        if ( $list ) {			
            $this->output->set_content_type('application/json')->set_output(json_encode($list));
        } else {
            $result = array( 'Value not found!' );
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }                
  
  public function setdaypart(){
      $typerole = $this->session->userdata('type_role');
      $userid = $this->session->userdata('user_id');
      
      if( ! empty($this->Anti_si($_GET['f'])) ) {
          $from = $this->Anti_si($_GET['f']);
      } else {
          $from = "00:00";
      }
      
      if( ! empty($this->Anti_si($_GET['t'])) ) {
          $to = $this->Anti_si($_GET['t']);
      } else {
          $to = "00:00";
      }
      
      $daypart = $this->audience_model->setdaypart($userid,$from,$to);
      
      if ( $daypart ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($daypart));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}