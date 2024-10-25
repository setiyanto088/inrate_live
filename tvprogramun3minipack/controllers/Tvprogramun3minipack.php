<?php
date_default_timezone_set('Asia/Makassar');
defined('BASEPATH') OR exit('No direct script access allowed');

class Tvprogramun3minipack extends JA_Controller {
 
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


	public function filter_days(){
		
		$type =  $this->Anti_si($this->input->post('audiencebarday',true));
		$periode =  $this->Anti_si($this->input->post('periode',true));
		$where = '';
		
		if($type == 'Viewers'){
			$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2_viewer($where,$periode);
		}elseif($type == 'Duration'){
			$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2_duration($where,$periode);
		}else{
			$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode);
		}
		
		if ($data['date'] <> null){
			foreach($data['date'] as $datasss){
				$data_date[] = $datasss['date'];
				$spot_date[] = floatval($datasss['spot']);
			}
		}		
		else {
			$data_date[]='';
			$spot_date[] =0;
		}		
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		
		echo json_encode($data,true); 
 		
	}

  public function index()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		 
		 
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
		
 
		
		$tahun=$this->input->post('tahun',true);
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		
		
	 
		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun) ;
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun) ;
 
		$pilihaudiencebar=$this->Anti_si($this->input->post('audiencebar',true));
		$pilihprog=$this->Anti_si($this->input->post('product_program',true));
		
		if (!isset($tahun)){ 
 
			
			$tahun= $data['thn'][0]['TANGGAL'];
 		}
		$periode=$tahun;
		
		//echo 'thn '.$periode;die;
 		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole,$periode);
		$data['channel_list'] = $this->tvprogramun_model->channel_list($periode);
	 
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;

 		$data['cond'] = '';
	 

 
		$html = "";
 
	
 		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,"AUDIENCE","0","True","ALL"); 
	 
		$dataM=$data['channels'];
		$scama = array();
		
		$tot_s = 0;
		
		for ($i=0;$i<count($dataM);$i++){
			$scam['Rangking'] = $i+1;
			$scam['Spot'] = $dataM[$i]['VIEWERS'];
			$scam['channel'] = $dataM[$i]['MINIPACK'];
			$data_cha[] = $dataM[$i]['MINIPACK'];
			$spot_cha[] = $dataM[$i]['VIEWERS'];
			$tot_s += $dataM[$i]['VIEWERS'];
			array_push($scama, $scam);
		}	
		
		$data['tot_s'] = $tot_s;
		$data['json_channel'] = json_encode($data_cha,true);
		$data['json_spot'] = json_encode($spot_cha,true);
		
		$data['audiencebychannel'] = json_encode($scama,true); 
		
		$this->template->load('maintemplate', 'tvprogramun3minipack/views/Tvprogramun', $data);
	}	

	function days_in_month($month, $year) 
	{ 
 		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
	}
	
	
	function audiencebar_by_channel_export(){
		
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('type',true));
		$check =  $this->Anti_si($this->input->post('check',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$tgl=$this->Anti_si($this->input->post('tgl',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter',true));
		
			if 	($type=='GRP')	 {
				$types = 'GRP';
			}elseif ($type=='Viewers')	 {
				$types = 'Total Views';
			}elseif ($type=='Duration')	 {
				$types = 'Duration';
			}elseif ($type=='share')	 {
				$types = 'Audience Share';
			}elseif ($type=='avgtotdur')	 {
				$types = 'AVG Dur/Views';
			}elseif ($type=='Reach')	 {
				$types = 'Reach';
			}else{
				$types = 'Audience';
			}
		
	 
		$datef = substr($tahun,0,4)."-".$nmonth."-".$tgl;
		$periode=$tahun;
		
		 
		if($tipe_filter == 'live'){	
			
		if ($week=="ALL"){
			if ($tgl=="0"){
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$type,$profile,$check); 
			}else {
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_date("channel_name",$where,$periode,$datef,$type,$profile,$check); 
			}
		}else {
			$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_bar("channel_name",$where,$periode,$week,$type,$profile,$check); 
		}
			$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
			
		}else{
			
			if ($week=="ALL"){
				if ($tgl=="0"){
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar_tvod("channel_name",$where,$periode,$type,$profile,$check,$tipe_filter); 
				}else {
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_date("channel_name",$where,$periode,$datef,$type,$profile,$check); 
				}
			}else {
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_bar("channel_name",$where,$periode,$week,$type,$profile,$check); 
			}
			
		}
       if(sizeof($data['channel']) > 0){
    			$i = 1;
    			$ik = 0;
          
    			if($type == 'Reach'){
    				foreach($data['channel'] as $datax){
     					$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
     					$data_ch[$ik]['Spot'] = round(($datax['Spot']/$data['totpopulasi'][0]['tot_pop'])*100,2);
    					$i++;
    					$ik++;
    				}
    			}else{
    				foreach($data['channel'] as $datax){
     					$data_ch[$ik]['Rangking'] = $i;
    					$data_ch[$ik]['channel'] = $datax['channel'];
    					$data_ch[$ik]['Spot'] = $datax['Spot'];
    					$i++;
    					$ik++;
    				}
    			}
       } else {
          $data_ch = null;
      }
      
	   $this->load->library('excel');
	   
	   $objPHPExcel = new PHPExcel();
	   
	   
	   
	   $objPHPExcel->getProperties()->setCreator("Unics")
									 ->setLastModifiedBy("Unics")
									 ->setTitle("Postbuy Analytics")
									 ->setSubject("Postbuy Analytics")
									 ->setDescription("Report Postbuy")
									 ->setKeywords("Postbuy Analytics")
									 ->setCategory("Report");
	   
	   $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Rangking')
					->setCellValue('B1', 'Channel')
					->setCellValue('C1', $types);
	   
	   $it1 = 2;
		 foreach($data_ch as $frt){
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['Rangking'])
					->setCellValue('B'.$it1, $frt['channel'])
					->setCellValue('C'.$it1, $frt['Spot']);

			$it1++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Audience by Channel Summary');
 		$objPHPExcel->setActiveSheetIndex(0);

		 

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		 
		$objWriter->save('/data/opep/srcs/html/tmp_doc/Audience_by_channel.xls');

	   
	}
	
	function audiencebar_by_channel(){
		
		$where =  $this->Anti_si($this->input->post('cond',true));
		$type =  $this->Anti_si($this->input->post('type',true));
		$tahun=$this->Anti_si($this->input->post('tahun',true));
		$bulan=$this->Anti_si($this->input->post('bulan',true));
		$profile=$this->Anti_si($this->input->post('profile',true));
		$nmonth = date("m", strtotime($tahun));
		$week=$this->Anti_si($this->input->post('week',true));
		$tgl=$this->Anti_si($this->input->post('tgl',true));
		$check=$this->Anti_si($this->input->post('check',true));
		$tipe_filter=$this->Anti_si($this->input->post('tipe_filter',true));
		$tipe_area=$this->Anti_si($this->input->post('tipe_area',true));
	 
		$datef = substr($tahun,0,4)."-".$nmonth."-".$tgl;
		$periode=$tahun;
		 
		$datad['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$type,$profile,$check,$tipe_area); 
			
       if(sizeof($datad['channel']) > 0){
    			$i = 1;
    			$ik = 0;
          
    			foreach($datad['channel'] as $datax){
    				$data_ch[$ik]['Rangking'] = $i;
    				$data_ch[$ik]['channel'] = $datax['MINIPACK'];
    				$data_ch[$ik]['Spot'] = $datax['VIEWERS'];
					$chart_label[$ik] = $datax['MINIPACK'];
					$chart_data[$ik] = $datax['VIEWERS'];
    				$i++;
    				$ik++;
    			}
       } else {
          $data_ch = null;
      }
      
		$data['data_ch'] = $data_ch;
		$data['chart_label'] = $chart_label;
		$data['chart_data'] = $chart_data;
		
		echo json_encode($data,true);
	}

}