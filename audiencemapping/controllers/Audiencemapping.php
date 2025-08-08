<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audiencemapping extends JA_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvcc_model');
	}
	
	public function index()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		$menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);

		if(!$this->session->userdata('user_id') || in_array("97",$array_menu) == 0) {
          redirect ('/login');
		}
		
		$data['profile'] = $this->tvcc_model->list_profile($iduser,$idrole,"");
		$data['channel'] = $this->tvcc_model->list_channel();    
    $data['daypart'] = $this->tvcc_model->list_daypart($iduser);  
    $data['currdate'] = $this->tvcc_model->current_date();
    $data['genre'] = $this->tvcc_model->list_channel_genre();

		$this->template->load('maintemplate', 'audiencemapping/views/tvcc_view', $data);
	}
	
	public function get_profile_id($profiles){
		$grouping_json = $this->tvcc_model->content_grouping($profiles); 
		$res = json_decode($grouping_json['grouping'],true);		
		$values = [];
		$tag = '';
		$values1 = '';
		
		$strsql='';
		$strsql2='';
		
		$asas = " WHERE 1=1 ";
		
		if($res){		
			foreach($res as $mydata)
			{
				if($mydata['Operation']){
					$key = array_keys($mydata['Operation']);
					$asas = $asas."AND JSON_EXTRACT_STRING(ASTEROID_VALUE,'".$key[0]."') IN (";
					foreach($mydata['Operation'] as $val){
						foreach($val as $value){
							$asas = $asas."'".$value."',";
						}						
					}
					$asas = substr($asas,0,-1).") ";
				}
			}
		}
		
		$where = $asas; 
	
    if($res){		
			foreach($res as $mydata)
			{
				if($mydata['Operation']){
					$values[] = json_encode($mydata['Operation']);
				}
			}
		}
    
		$where = " WHERE 1=1 ";
		
		foreach($values as $vv){
			$str = str_replace("[{","",$vv);
			$str = str_replace("}]","",$str);
			$str_array = explode(",",$str);
			
			foreach($str_array as $str_arrays){
				$vals = explode(":",$str_arrays);
					
				$where = $where.' AND JSON_EXTRACT_STRING(ASTEROID_VALUE,'.$vals[0].') = '.$vals[1];				
			}
			
		} 
		
		$get_userid = $this->tvcc_model->get_userid($where);					
		if($res){		
			$key1 = '';
			foreach($get_userid as $key)
			{
				$key1 .= "'".$key['USERID']."'".",";
			}
			$profile = rtrim($key1,",");
		}else{
			$profile = '';	
		}
		
		return $profile;	
	}
  
  
	 public function export_city(){	                
      if( ! empty($_POST['start_date']) ) {
          $start_date = $_POST['start_date'];
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($_POST['end_date']) ) {
         
          $end_date = $_POST['end_date'];
      } else {
          $end_date = NULL;
      }
      
      
      if( ! empty($_POST['genre']) ) {
          $genre = str_replace("AND","&",$_POST['genre']);
      } else {
          $genre = "0";
      }
	  
	   if( ! empty($_POST['province']) ) {
          $province = str_replace("AND","&",$_POST['province']);
      } else {
          $province = "0";
      }
	  
	   if( ! empty($_POST['program']) ) {
          $program = str_replace("AND","&",$_POST['program']);
      } else {
          $program = "0";
      }
      
      if( ! empty($_POST['channel']) ) {
          $channel = $_POST['channel'];
          
          if($channel == "0"){
              $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
              for($i=0;$i < sizeof($channel_array);$i++){
                  $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
              }
          } else {
			   $channel = "'".str_replace(",","','",substr($channel, 1))."'"; 
			  $channel = explode(',',$channel);
              for($i=0;$i < sizeof($channel);$i++){
                  $order_fields[$i+2] = str_replace("'","",$channel[$i]);
              }
          }
      } else {
          $channel = "0";  
          $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
        
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->input->get_post('search');		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
      $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
     
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['program']		= str_replace("AND","&",$program);
      $params['province']		= str_replace("AND","&",$province);
     

	    $arr_tvcc = [];
	  
	  
	   $list = $this->tvcc_model->list_tvcc_city_d($params);
	   
	  
	   $this->load->library('excel');
	  
	    $objPHPExcel = new PHPExcel();
	   
	   
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Reporting Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	  
				 	
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'City')
						->setCellValue('B1', 'Viewers')
						->setCellValue('C1', 'Views')
						->setCellValue('D1', 'Duration');
						
			$int_data = 2;
				foreach($list['data'] as $lists){
					
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$int_data, $lists['SEGMENT'])
						->setCellValue('B'.$int_data, $lists['VIEWERS'])
						->setCellValue('C'.$int_data, $lists['TOTAL_VIEWS'])
						->setCellValue('D'.$int_data, $lists['DURASI']);
					
					$int_data++;
				}
				
				 $objPHPExcel->setActiveSheetIndex(0);
	  
				
			header('Content-Type: application/vnd.ms-excel'); // For .xls files
            header('Content-Disposition: attachment;filename="Export City.xls"');
            header('Cache-Control: max-age=0');

            // Save the Excel file to output
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // 'Excel5' for .xls
            $objWriter->save('php://output');
		     
  }
  
  
   public function export_province(){	                
      if( ! empty($_POST['start_date']) ) {
          $start_date = $_POST['start_date'];
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($_POST['end_date']) ) {
         
          $end_date = $_POST['end_date'];
      } else {
          $end_date = NULL;
      }
      
      
      if( ! empty($_POST['genre']) ) {
          $genre = str_replace("AND","&",$_POST['genre']);
      } else {
          $genre = "0";
      }
	  
	   if( ! empty($_POST['program']) ) {
          $program = str_replace("AND","&",$_POST['program']);
      } else {
          $program = "0";
      }
      
    
      
      if( ! empty($_POST['channel']) ) {
          $channel = $_POST['channel'];
          
          if($channel == "0"){
              $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
              for($i=0;$i < sizeof($channel_array);$i++){
                  $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
              }
          } else {
			  $channel = "'".str_replace(",","','",substr($channel, 1))."'"; 
			  $channel = explode(',',$channel);
              for($i=0;$i < sizeof($channel);$i++){
                  $order_fields[$i+2] = str_replace("'","",$channel[$i]);
              }
          }
      } else {
          $channel = "0";  
          $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
        
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->input->get_post('search');		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
      $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
     
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['program']		= str_replace("AND","&",$program);
     

	    $arr_tvcc = [];
	  
	  
	   $list = $this->tvcc_model->list_tvcc($params);
	   
	  
	   $this->load->library('excel');
	  
	    $objPHPExcel = new PHPExcel();
	   
	   
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Reporting Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	  
				 	
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'Province')
						->setCellValue('B1', 'Viewers')
						->setCellValue('C1', 'Views')
						->setCellValue('D1', 'Duration');
						
			$int_data = 2;
				foreach($list['data'] as $lists){
					
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$int_data, $lists['SEGMENT'])
						->setCellValue('B'.$int_data, $lists['VIEWERS'])
						->setCellValue('C'.$int_data, $lists['TOTAL_VIEWS'])
						->setCellValue('D'.$int_data, $lists['DURASI']);
					
					$int_data++;
				}
				
				 $objPHPExcel->setActiveSheetIndex(0);
	  
			header('Content-Type: application/vnd.ms-excel'); // For .xls files
            header('Content-Disposition: attachment;filename="Export Province.xls"');
            header('Cache-Control: max-age=0');

            // Save the Excel file to output
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // 'Excel5' for .xls
            $objWriter->save('php://output');
		
		     
  }
  
  
    public function list_tvcc_city(){	                
      if( ! empty($_POST['start_date']) ) {
          $start_date = $_POST['start_date'];
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($_POST['end_date']) ) {
         
          $end_date = $_POST['end_date'];
      } else {
          $end_date = NULL;
      }
      
      
      if( ! empty($_POST['genre']) ) {
          $genre = str_replace("AND","&",$_POST['genre']);
      } else {
          $genre = "0";
      }
	  
	   if( ! empty($_POST['province']) ) {
          $province = str_replace("AND","&",$_POST['province']);
      } else {
          $province = "0";
      }
	  
	   if( ! empty($_POST['program']) ) {
          $program = str_replace("AND","&",$_POST['program']);
      } else {
          $program = "0";
      }
      
    
      
      if( ! empty($_POST['channel']) ) {
          $channel = $_POST['channel'];
          
          if($channel == "0"){
              $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
              for($i=0;$i < sizeof($channel_array);$i++){
                  $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
              }
          } else {
              for($i=0;$i < sizeof($channel);$i++){
                  $order_fields[$i+2] = str_replace("'","",$channel[$i]);
              }
          }
      } else {
          $channel = "0";  
          $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
        
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->input->get_post('search');		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
      $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
     
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['program']		= str_replace("AND","&",$program);
      $params['province']		= str_replace("AND","&",$province);
     

	    $arr_tvcc = [];
	  
	  
	   $list = $this->tvcc_model->list_tvcc_city_d($params);
	   
	   
      $n_a = $list['data'];
      
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      
      $paging_array = array_slice($n_a,$params['offset'],$params['limit']);
      
      $data = array();		
      for($i=0;$i<count($paging_array);$i++){
		  $new_array = array();
		$new_array[0] =	$paging_array[$i]['SEGMENT'];
		$new_array[1] = "<p style='text-align:right'>".number_format($paging_array[$i]['VIEWERS'],0,",",".").'</p>';
		$new_array[2] = "<p style='text-align:right'>".number_format($paging_array[$i]['TOTAL_VIEWS'],0,",",".").'</p>';
		$new_array[3] = "<p style='text-align:right'>".number_format($paging_array[$i]['DURASI'],2,",",".").'</p>';
		  
          array_push($data,$new_array);
      } 
	  
      
      $result["data"] = $data;
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }
  
  
  public function list_tvcc(){	                
      if( ! empty($_POST['start_date']) ) {
          $start_date = $_POST['start_date'];
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($_POST['end_date']) ) {
         
          $end_date = $_POST['end_date'];
      } else {
          $end_date = NULL;
      }
      
      
      if( ! empty($_POST['genre']) ) {
          $genre = str_replace("AND","&",$_POST['genre']);
      } else {
          $genre = "0";
      }
	  
	   if( ! empty($_POST['program']) ) {
          $program = str_replace("AND","&",$_POST['program']);
      } else {
          $program = "0";
      }
      
    
      
      if( ! empty($_POST['channel']) ) {
          $channel = $_POST['channel'];
          
          if($channel == "0"){
              $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
              for($i=0;$i < sizeof($channel_array);$i++){
                  $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
              }
          } else {
              for($i=0;$i < sizeof($channel);$i++){
                  $order_fields[$i+2] = str_replace("'","",$channel[$i]);
              }
          }
      } else {
          $channel = "0";  
          $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
        
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->input->get_post('search');		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
      $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
     
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['program']		= str_replace("AND","&",$program);
     

	    $arr_tvcc = [];
	  
	  
	   $list = $this->tvcc_model->list_tvcc($params);
	   
	   
      $n_a = $list['data'];
      
      $result["recordsTotal"] = $list['total'];
      $result["recordsFiltered"] = $list['total_filtered'];
      $result["draw"] = $draw;
      
      $paging_array = array_slice($n_a,$params['offset'],$params['limit']);
      
      $data = array();		
      for($i=0;$i<count($paging_array);$i++){
		  
		  $new_array = array();
		$new_array[0] = "<p style='margin-left:20px'>".$paging_array[$i]['SEGMENT'].'</p>';
		$new_array[1] = "<p style='text-align:right'>".number_format($paging_array[$i]['VIEWERS'],0,",",".").'</p>';
		$new_array[2] = "<p style='text-align:right'>".number_format($paging_array[$i]['TOTAL_VIEWS'],0,",",".").'</p>';
		$new_array[3] = "<p style='text-align:right'>".number_format($paging_array[$i]['DURASI'],2,",",".").'</p>';
		$new_array[4] = "<span style='text-align:right'><button id='button_filters' onClick='export_city(\"".$paging_array[$i]['SEGMENT']."\")' class='button_black'>Export</button><span>";
		
          array_push($data,$new_array);
		  
		  
      } 
      
      $result["data"] = $data;
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }
  
  public function list_charttvcc()
	{	                
    if( ! empty($_POST['start_date']) ) {
          $start_date = $_POST['start_date'];
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($_POST['end_date']) ) {
         
          $end_date = $_POST['end_date'];
      } else {
          $end_date = NULL;
      }
      
      
      if( ! empty($_POST['genre']) ) {
          $genre = str_replace("AND","&",$_POST['genre']);
      } else {
          $genre = "0";
      }
	  
	   if( ! empty($_POST['program']) ) {
          $program = str_replace("AND","&",$_POST['program']);
      } else {
          $program = "0";
      }
      
    
      
      if( ! empty($_POST['channel']) ) {
          $channel = $_POST['channel'];
          
          if($channel == "0"){
              $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
              for($i=0;$i < sizeof($channel_array);$i++){
                  $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
              }
          } else {
              for($i=0;$i < sizeof($channel);$i++){
                  $order_fields[$i+2] = str_replace("'","",$channel[$i]);
              }
          }
      } else {
          $channel = "0";  
          $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('tanggal,ranged', 'tanggal,ranged', 'TVS1','TVS2','TVS3','TVR1','TVR2','TVR3','VIEWER1', 'VIEWER2', 'VIEWER3');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->input->get_post('search');		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
    $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
     
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['program']		= str_replace("AND","&",$program);
	  $params['cgroup'] 		= $_POST['cgroup'];

      $arr_tvcc = [];
      
      
      $list = $this->tvcc_model->list_charttvcc($params);
             $data = array();
		
		if($params['cgroup'] == 'viewers'){
			
			$ss = 'VIEWERS';
			
		}elseif($params['cgroup'] == 'total_views'){
			
			$ss = 'TOTAL_VIEWS';
		}else{
			$ss = 'DURASI';
		}
		
		  foreach ( $list['data'] as $k => $v ) {
            
            array_push($data, 
                array(
                    $v['SEGMENT'],					
                    $v[$ss]
                )
            );
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }  
  
  
  public function list_charttvcc2()
	{	                
    if( ! empty($_POST['start_date']) ) {
          $start_date = $_POST['start_date'];
      } else {
          $start_date = NULL;
      }
      
      if( ! empty($_POST['end_date']) ) {
         
          $end_date = $_POST['end_date'];
      } else {
          $end_date = NULL;
      }
      
      
      if( ! empty($_POST['genre']) ) {
          $genre = str_replace("AND","&",$_POST['genre']);
      } else {
          $genre = "0";
      }
	  
	   if( ! empty($_POST['program']) ) {
          $program = str_replace("AND","&",$_POST['program']);
      } else {
          $program = "0";
      }
	  
	  if( ! empty($_POST['cgroup']) ) {
          $cgroup = str_replace("AND","&",$_POST['cgroup']);
      } else {
          $cgroup = "viewers";
      }
      
    
      
      if( ! empty($_POST['channel']) ) {
          $channel = $_POST['channel'];
          
          if($channel == "0"){
              $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
              for($i=0;$i < sizeof($channel_array);$i++){
                  $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
              }
          } else {
              for($i=0;$i < sizeof($channel);$i++){
                  $order_fields[$i+2] = str_replace("'","",$channel[$i]);
              }
          }
      } else {
          $channel = "0";  
          $channel_array = $this->tvcc_model->channelsearch("",$genre);
          
          for($i=0;$i < sizeof($channel_array);$i++){
              $order_fields[$i+2] = $channel_array[$i]['CHANNEL'];
          }
      }
      
      if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
      if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
      if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
      $order_fields = array('tanggal,ranged', 'tanggal,ranged', 'TVS1','TVS2','TVS3','TVR1','TVR2','TVR3','VIEWER1', 'VIEWER2', 'VIEWER3');
      $order = $this->input->get_post('order');
      if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
      if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'];} else{$order_column = 0;}; 	
      
      $search = $this->input->get_post('search');		
      if( ! empty($search['value']) ) {
          $search_value = $search['value'];
      } else {
          $search_value = null;
      }
      
    $params['limit'] 		= (int) $length;
      $params['offset'] 		= (int) $start;
     
      $params['order_dir'] 	= $order_dir;
      $params['filter'] 		= $search_value;
      $params['start_date'] 	= $start_date;
      $params['end_date']		= $end_date;
      $params['genre']		= str_replace("AND","&",$genre);
      $params['channel']		= str_replace("AND","&",$channel);
      $params['program']		= str_replace("AND","&",$program);
	   $params['cgroup'] 		= $cgroup;
     
	 
      $arr_tvcc = [];
      
      
      $list = $this->tvcc_model->list_charttvcc2($params);
             $data = array();
		
		
		if($params['cgroup'] == 'viewers'){
			
			$ss = 'VIEWERS';
			
		}elseif($params['cgroup'] == 'total_views'){
			
			$ss = 'TOTAL_VIEWS';
		}else{
			$ss = 'DURASI';
		}
		
		$arr_color = [];
		
		for($tr = 0; $tr < 100;$tr++){
			$col = $this->generateColor($tr);
			$arr_color[] = '#'.$col;
			
		}
		
		  foreach ( $list['data'] as $k => $v ) {
            			
            array_push($data, 
                array( 
                    $v['SEGMENT'],					
                    intval($v[$ss]),
					floatval($v['LONGITUDE']),
					floatval($v['LATITUDE']),
					$arr_color[ceil($v['VIEWERS_PER']*100)],
					number_format(ceil($v['VIEWERS_PER']*100),0,".",","),
					number_format(ceil($v['TOTAL_VIEWS_PER']*100),0,".",","),
					number_format(ceil($v['DURASI_PER']*100),0,".",",")
                )
            );
        }	
	  
      $result["data"] = $data;	
      $this->output->set_content_type('Application/json')->set_output(json_encode($result));
  }  
  
    function generateColor($tr) {
		$length = 6;
		$str = "";
		$characters = array_merge(range('A','F'), range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = $tr + 16;
			$str .= $characters[$rand];
		}
		return $str;
	}
                                                                    
    
  public function genresearch(){
	    if(!$this->session->userdata('user_id') || in_array("97",$array_menu) == 0) {
			
			$result = array('success' => false, 'message' => "Failed to Process", 'data' => '');
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}else{
			
      $typerole = $this->session->userdata('type_role');
	  
	  $search_t =   str_replace('_','',str_replace('%','',str_replace('\\','',str_replace('"','',str_replace("'","",$this->Anti_si($_GET['q']))))));
	  
      $list = $this->tvcc_model->genresearch($search_t,$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
	  
		}
  }                                                                                                        
    
  public function profilesearch(){
	    if(!$this->session->userdata('user_id') || in_array("97",$array_menu) == 0) {
			
			$result = array('success' => false, 'message' => "Failed to Process", 'data' => '');
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}else{
			
      $iduser = $this->session->userdata('user_id');
	  $search_t =   str_replace('_','',str_replace('%','',str_replace('\\','',str_replace('"','',str_replace("'","",$this->Anti_si($_GET['q']))))));
		
      $list = $this->tvcc_model->profilesearch($search_t,$iduser,$_GET['f']);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
	  
		}
  }          
  
  public function setprofile(){
	  
	    if(!$this->session->userdata('user_id') || in_array("97",$array_menu) == 0) {
			
			$result = array('success' => false, 'message' => "Failed to Process", 'data' => '');
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}else{
			
      $iduser = $this->session->userdata('user_id');
      $list = $this->tvcc_model->list_profile($iduser,"",$_GET['f']);          
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
	  
		}
  }                                                     
    
	 
	public function programsearch(){
		  if(!$this->session->userdata('user_id') || in_array("97",$array_menu) == 0) {
			
			$result = array('success' => false, 'message' => "Failed to Process", 'data' => '');
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}else{
			
      $params['channel'] = str_replace("AND","&",$_GET['q']);
	  
	   $sec1 = strtotime($_GET['d']); 
       $params['start_date'] = date("Y-m-d", $sec1); 
	   
	   $sec1 = strtotime($_GET['de']); 
       $params['end_date'] = date("Y-m-d", $sec1); 
	  
	  $list = $this->tvcc_model->programsearch($params);
	  
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
	  
		}
  }  
	
  public function channelsearch(){
	  
	  if(!$this->session->userdata('user_id') || in_array("97",$array_menu) == 0) {
			
			$result = array('success' => false, 'message' => "Failed to Process", 'data' => '');
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}else{
			
      $genre = str_replace("AND","&",$_GET['g']);
	  
	  $search_t =   str_replace('_','',str_replace('%','',str_replace('\\','',str_replace('"','',str_replace("'","",$this->Anti_si($_GET['q']))))));
	   
      $list = $this->tvcc_model->channelsearch($search_t,$genre);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
	  
		}
  }          

}
