<?php
date_default_timezone_set('Asia/Makassar');
defined('BASEPATH') OR exit('No direct script access allowed');

class Tvprogramun3mon extends JA_Controller {
 
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvprogramun_model');
	}
	
	
	function getPeriodFromRange($start, $end, $format = 'Y-F') { 
      
		// Declare an empty array 
		$array = array(); 
		  
		// Variable that store the date interval 
		// of period 1 day 
		$interval = new DateInterval('P1M'); 
	  
		$realEnd = new DateTime($end); 
		$realEnd->add($interval); 
	  
		$period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
	  
		// Use loop to store date into array 
		foreach($period as $date) {                  
			$array[] = $date->format($format);  
		} 
	  
		// Return the array elements 
		return $array; 
	}   

	
  public function index()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		 $menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);

		if(!$this->session->userdata('user_id') || in_array("255",$array_menu) == 0) {
          redirect ('/login');
		}
		 
		$datefg = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];
		 
		$data['tanggal'] = $datefg; 
		 
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
 		$data['thn'] = $this->tvprogramun_model->get_tahun();
		
		//print_r($data['thn']);die;
	 
		if(!$this->session->userdata('user_id')) { 
 		}

		$tahun= $data['thn'][0]['TANGGAL'];
 		
		$periode=$tahun;
		
		$per = $this->tvprogramun_model->get_periodes();
		
		//print_r($per);die;
		$data['array_per'] = $prime;
		$ut = 0;
		foreach($per as $pers){
			$data['array_per'][] = date_format(date_create($pers['DTY']),"Y-F");
			$ut++;
		}

		
		$this->template->load('maintemplate', 'tvprogramun3mon/views/Tvprogramun', $data);
	}	
	
	
	function get_data_last(){
		
		if(!$this->session->userdata('user_id') || in_array("255",$array_menu) == 0) {
			$result = array('success' => false, 'message' => "Failed to Edit", 'data' => '');
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}else{
		
			$types =  $this->input->post('types',true);
			$periode =  $this->input->post('periode',true);
			//print_r($types);die;
			$data = $this->tvprogramun_model->get_curr_data($periode);
			//print_r($data);die;
			if($types == 1){
				$array_file_s['dataw'] = $data[0];
				$array_file_s['datawm'] = $data[1];
			}else{
				$array_file_s['dataw'] = $data[2];
				$array_file_s['datawm'] = $data[3];
			}
		
			$this->output->set_content_type('application/json')->set_output(json_encode($array_file_s));
		}
		
	}


}

