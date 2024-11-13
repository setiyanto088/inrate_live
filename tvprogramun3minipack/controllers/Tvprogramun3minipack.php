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
		$data['monthdt'] = $this->tvprogramun_model->get_curr_month(date("Y"));

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
	
	
	function audiencebar_by_channel42(){
		
		$userid = $this->session->userdata('user_id');
		$params['user_id'] = $userid;
		
		
		$data['where'] =  $this->Anti_si($this->input->post('cond',true));
		$data['type'] =  $this->Anti_si($this->input->post('type',true));
		//$data['type'] =  'UV';
		$data['tahun']=$this->Anti_si($this->input->post('tahun',true));
		$data['bulan']=$this->Anti_si($this->input->post('bulan',true));
		$data['profile']=$this->Anti_si($this->input->post('profile',true));
		$data['week']=$this->Anti_si($this->input->post('week',true));
		$data['start_date']=$this->Anti_si($this->input->post('start_date',true));
		$data['end_date']=$this->Anti_si($this->input->post('end_date',true));
		$data['check']=$this->Anti_si($this->input->post('check',true));
		$data['tipe_filter']=$this->Anti_si($this->input->post('tipe_filter',true));
		$data['channel'] = $this->Anti_si($this->input->post('channel',true));
		$data['preset'] = $this->Anti_si($this->input->post('preset',true));
		$data['tipe_area'] = $this->Anti_si($this->input->post('tipe_area',true));
		
		if($data['end_date'] == 'All'){
			
			$data_vol = $this->tvprogramun_model->list_data_month($data);
			
			$data_array = [];
			
			foreach($data_vol['data'] as $datas){
				$data_arrays = [];
				$data_arrays['PERIODE'] = $datas['PERIODE'];
				$data_arrays['MINIPACK'] = $datas['MINIPACK'];
				$data_arrays['VIEWERS'] = $datas['VIEWERS'];
				$data_array[$data_arrays['PERIODE']][$datas['MINIPACK']] = $data_arrays;

			}
						
			
			$data_return['monthdt'] = $this->tvprogramun_model->get_sel_month_all($data['start_date'],$data['end_date']);
			
			$html_table = '<table aria-describedby="table" id="example42" class="table table-striped example" style="width: 100%;">
										<thead style="color:red">
												<th scope="row">Ranks </th>
												<th scope="row">Minipack </th>';
			
			$html_table_body = '';
			$html_table_body_total = '';			
			
			$rnk = 1;
			
			$bulan_label = [];
			foreach($data_return['monthdt'] as $monthdts){
				$html_table .= '<th scope="row" >'.$monthdts['PERIODE'].'</th>';
				$bulan_label[] = $monthdts['PERIODE'];
			}			
			
			
			
			$scama42 = array();
			$scama42 = array();
			$rkn2 = 1;
			foreach($data_array[$data['start_date']] as $minipack_name ){
				
				$scam42['Rangking'] = $rkn2; 
				$scam42['channel'] = $minipack_name['MINIPACK'];
				$sq = 1;
				foreach($data_return['monthdt'] as $ssss){
										
					if(isset($data_array[$ssss['PERIODE_FULL']][$minipack_name['MINIPACK']])){
						$scam42['V'.$sq] = number_format($data_array[$ssss['PERIODE_FULL']][$minipack_name['MINIPACK']]['VIEWERS'],0,',','.');
						$scam42['AV'.$sq] = $data_array[$ssss['PERIODE_FULL']][$minipack_name['MINIPACK']]['VIEWERS'];
					}else{
						$scam42['V'.$sq] = 0;
						$scam42['AV'.$sq] = 0;
					}
					
					$sq++;
				}
				$scam42['TOTAL'] = number_format($data_array[$data['start_date']][$minipack_name['MINIPACK']]['VIEWERS'],0,',','.');
				
				array_push($scama42, $scam42); 
				
				$rkn2++;
			}
												
			$html_table .= '<th scope="row">Total</th></thead></table>';
			$data_chart = $scama42;
			
			
			
		}else{
			
			$data_vol = $this->tvprogramun_model->list_data_weekly($data);
			$data_vol_count = $this->tvprogramun_model->list_data_count($data);
			

			$cnt = $data_vol_count['total'];

			$data_array = [];
			$data_array2 = [];
						
			foreach($data_vol['data'] as $datas){
				$data_arrays = [];
				$data_arrays['PERIODE'] = $datas['PERIODE'];
				$data_arrays['MINIPACK'] = $datas['MINIPACK'];
				$data_arrays['VIEWERS'] = $datas['VIEWERS'];
				$data_array[$data_arrays['PERIODE']][] = $data_arrays;
				$data_array2[$data_arrays['PERIODE']][$datas['MINIPACK']] = $data_arrays;
			}
			
			$scam42 = array();
			$scama42 = array();
			$scam42c = array();
			$scama42c = array();
						
			foreach($data_vol_count['data'] as $mpack){
				$scam42c['channel'] = $mpack['MINIPACK'];
				$sq = 1;
				FOREACH($data_array2 as $minipack_name){
					if(isset($minipack_name[$mpack['MINIPACK']])){
						$scam42c['AV'.$sq] = $minipack_name[$mpack['MINIPACK']]['VIEWERS'];
					}else{
						$scam42c['AV'.$sq] = 0;
					}
					$sq++;
				}
				array_push($scama42c, $scam42c); 
			}
			
			for($i=0;$i < $cnt;$i++){
				$sq = 1;
				FOREACH($data_array as $minipack_name){
					
					if(isset($minipack_name[$i])){
						$scam42['V'.$sq] = number_format($minipack_name[$i]['VIEWERS'],0,',','.');
						$scam42['Vs'.$sq] = $minipack_name[$i]['MINIPACK'];
						$scam42['AV'.$sq] = $minipack_name[$i]['VIEWERS'];
						$scam42['Rangking'] = $i+1;
						$scam42['channel'] = $minipack_name[$i]['MINIPACK'];
					}else{
						$scam42['V'.$sq] = '';
						$scam42['Vs'.$sq] = '';
						$scam42['AV'.$sq] = 0;
						$scam42['Rangking'] = $i+1;
						$scam42['channel'] = $minipack_name[$i]['MINIPACK'];
					}
					
					$sq++;
				}
				array_push($scama42, $scam42); 
				
			}
			
			$html_table_body = '';
			$html_table_body_total = '';			
			
			$rnk = 1;
			$th_tb = "";
			$th_tbs = "<tr>";
			$ri = 1;
			$data_return['monthdt'] = $this->tvprogramun_model->get_sel_week($data['start_date'],$data['end_date']);
			
			$bulan_label = [];
			foreach($data_return['monthdt'] as $wkwk){
					
				$th_tb = $th_tb."<th colspan = '2' >Week ".$ri." (".$wkwk['PER'].")</th>";
				$th_tbs = $th_tbs."<td>Minipack</td><td>".$data['type']."</td>";
				$bulan_label[] = $wkwk['PER'];
				$ri++;
			}

			
			$th_tbs = $th_tbs."</tr>";
			
			$html_table = '
			<table id="example42" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th rowspan = "2" >Rank </th>
										'.$th_tb.'
									</tr>
										'.$th_tbs.'
								</thead>
							</table>
			';
			$data_chart = $scama42c;
			
		}
				
		$data_return['table'] = $html_table;
		$data_return['data'] = $scama42;
		$data_return['data_chart'] = $data_chart;
		$data_return['bulan_label'] = $bulan_label;
		echo json_encode($data_return,true);
		
	}
	
	function audiencebar_by_channel43(){
		
		$userid = $this->session->userdata('user_id');
		$params['user_id'] = $userid;
		
		
		$data['where'] =  $this->Anti_si($this->input->post('cond',true));
		$data['type'] =  $this->Anti_si($this->input->post('type',true));
		//$data['type'] =  'UV';
		$data['tahun']=$this->Anti_si($this->input->post('tahun',true));
		$data['bulan']=$this->Anti_si($this->input->post('bulan',true));
		$data['profile']=$this->Anti_si($this->input->post('profile',true));
		$data['week']=$this->Anti_si($this->input->post('week',true));
		$data['start_date']=$this->Anti_si($this->input->post('start_date',true));
		$data['end_date']=$this->Anti_si($this->input->post('end_date',true));
		$data['check']=$this->Anti_si($this->input->post('check',true));
		$data['tipe_filter']=$this->Anti_si($this->input->post('tipe_filter',true));
		$data['channel'] = $this->Anti_si($this->input->post('channel',true));
		$data['preset'] = $this->Anti_si($this->input->post('preset',true));
		$data['tipe_area'] = $this->Anti_si($this->input->post('tipe_area',true));
		
		if($data['end_date'] == 'All'){
			
			$data_vol = $this->tvprogramun_model->list_data_month_ch($data);
			
			$data_array = [];
			
			foreach($data_vol['data'] as $datas){
				$data_arrays = [];
				$data_arrays['PERIODE'] = $datas['PERIODE'];
				$data_arrays['MINIPACK'] = $datas['MINIPACK'];
				$data_arrays['CHANNEL'] = $datas['CHANNEL'];
				$data_arrays['VIEWERS'] = $datas['VIEWERS'];
				$data_array[$data_arrays['PERIODE']][$datas['CHANNEL'].'-'.$datas['MINIPACK']] = $data_arrays;

			}
						
			$data_return['monthdt'] = $this->tvprogramun_model->get_sel_month_all($data['start_date'],$data['end_date']);
			
			$html_table = '<table aria-describedby="table" id="example43" class="table table-striped example" style="width: 100%;">
										<thead style="color:red">
												<th scope="row">Ranks </th>
												<th scope="row">Channel </th>
												<th scope="row">Minipack </th>';
			
			$html_table_body = '';
			$html_table_body_total = '';			
			
			$rnk = 1;
			
			$bulan_label = [];
			foreach($data_return['monthdt'] as $monthdts){
				$html_table .= '<th scope="row" >'.$monthdts['PERIODE'].'</th>';
				$bulan_label[] = $monthdts['PERIODE'];
			}			
			
			
			
			$scama42 = array();
			$scama42 = array();
			$rkn2 = 1;
			foreach($data_array[$data['start_date']] as $minipack_name ){
								
				$scam42['Rangking'] = $rkn2; 
				$scam42['channel'] = $minipack_name['CHANNEL'];
				$scam42['minipack'] = $minipack_name['MINIPACK'];
				$sq = 1;
				foreach($data_return['monthdt'] as $ssss){
										
					if(isset($data_array[$ssss['PERIODE_FULL']][$minipack_name['CHANNEL'].'-'.$minipack_name['MINIPACK']])){
						$scam42['V'.$sq] = number_format($data_array[$ssss['PERIODE_FULL']][$minipack_name['CHANNEL'].'-'.$minipack_name['MINIPACK']]['VIEWERS'],0,',','.');
					}else{
						$scam42['V'.$sq] = 0;
					}
					
					$sq++;
				}
				$scam42['TOTAL'] = number_format($data_array[$data['start_date']][$minipack_name['CHANNEL'].'-'.$minipack_name['MINIPACK']]['VIEWERS'],0,',','.');
				
				array_push($scama42, $scam42); 
				
				$rkn2++;
			}
															
			$html_table .= '<th scope="row">Total</th></thead></table>';
			$data_chart = $scama42;
			
			
			
		}else{
			
			$data_vol = $this->tvprogramun_model->list_data_weekly_ch($data);
			$data_vol_count = $this->tvprogramun_model->list_data_count_ch($data);
			

			$cnt = $data_vol_count['total'];

			$data_array = [];
			$data_array2 = [];
						
			foreach($data_vol['data'] as $datas){
				$data_arrays = [];
				$data_arrays['PERIODE'] = $datas['PERIODE'];
				$data_arrays['MINIPACK'] = $datas['MINIPACK'];
				$data_arrays['CHANNEL'] = $datas['CHANNEL'];
				$data_arrays['VIEWERS'] = $datas['VIEWERS'];
				$data_array[$data_arrays['PERIODE']][] = $data_arrays;
				$data_array2[$data_arrays['PERIODE']][$datas['CHANNEL'].'-'.$datas['MINIPACK']] = $data_arrays;
			}
			
			$scam42 = array();
			$scama42 = array();
			$scam42c = array();
			$scama42c = array();
						

			for($i=0;$i < $cnt;$i++){
				$sq = 1;
				FOREACH($data_array as $minipack_name){
					
					if(isset($minipack_name[$i])){
						$scam42['V'.$sq] = number_format($minipack_name[$i]['VIEWERS'],0,',','.');
						$scam42['Vs'.$sq] = $minipack_name[$i]['MINIPACK'];
						$scam42['Vsc'.$sq] = $minipack_name[$i]['CHANNEL'];
						$scam42['AV'.$sq] = $minipack_name[$i]['VIEWERS'];
						$scam42['Rangking'] = $i+1;
						$scam42['channel'] = $minipack_name[$i]['CHANNEL'];
						$scam42['minipack'] = $minipack_name[$i]['MINIPACK'];
					}else{
						$scam42['V'.$sq] = '';
						$scam42['Vs'.$sq] = '';
						$scam42['Vsc'.$sq] = '';
						$scam42['AV'.$sq] = 0;
						$scam42['Rangking'] = $i+1;
						$scam42['channel'] = $minipack_name[$i]['CHANNEL'];
						$scam42['minipack'] = $minipack_name[$i]['MINIPACK'];
					}
					
					$sq++;
				}
				array_push($scama42, $scam42); 
				
			}
			
			$html_table_body = '';
			$html_table_body_total = '';			
			
			$rnk = 1;
			$th_tb = "";
			$th_tbs = "<tr>";
			$ri = 1;
			$data_return['monthdt'] = $this->tvprogramun_model->get_sel_week($data['start_date'],$data['end_date']);
			
			$bulan_label = [];
			foreach($data_return['monthdt'] as $wkwk){
					
				$th_tb = $th_tb."<th colspan = '3' >Week ".$ri." (".$wkwk['PER'].")</th>";
				$th_tbs = $th_tbs."<td>Channel</td><td>Minipack</td><td>".$data['type']."</td>";
				$bulan_label[] = $wkwk['PER'];
				$ri++;
			}

			
			$th_tbs = $th_tbs."</tr>";
			
			$html_table = '
			<table id="example43" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th rowspan = "2" >Rank </th>
										'.$th_tb.'
									</tr>
										'.$th_tbs.'
								</thead>
							</table>
			';
			$data_chart = $scama42c;
			
		}
				
		$data_return['table'] = $html_table;
		$data_return['data'] = $scama42;
		$data_return['bulan_label'] = $bulan_label;
		echo json_encode($data_return,true);
		
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