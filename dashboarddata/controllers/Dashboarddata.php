<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboarddata extends JA_Controller {
 
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvprogramun_model');
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

		if(!$this->session->userdata('user_id') || in_array("89",$array_menu) == 0) {
          redirect ('/login');
		}
		
		$datefg = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];
		 
		$data['tanggal'] = $datefg; 
		 
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		
		$data['bln'] = $this->tvprogramun_model->get_bulan();
		$data['thn'] = $this->tvprogramun_model->get_tahun();
		
		$data['profile'] = $this->tvprogramun_model->get_profile($iduser,$idrole);
		
		$data['file_date'] = $this->tvprogramun_model->get_file_date();
		
		//echo $this->session->userdata('role_id');die;
		
		if(!$this->session->userdata('user_id') && $this->session->userdata('role_id') <> 878 && $this->session->userdata('role_id') <> 6) {
			redirect ('/login');
		}
		
		if($this->input->post('filter_text')){
				
				$filter = $this->input->post('filter_text');
				$starttime = $this->input->post('starttime');
				$endtime = $this->input->post('endtime');
				$mindur = $this->input->post('mindur');
				$maxdur = $this->input->post('maxdur');
				
				
				
				$f_array = json_decode($filter,true);
				
				$where = " AND";
				foreach($f_array as $farray){
					
					
					if(isset($farray["children"])){
						
						$where = $where." ".$farray['id']." IN (";
						
						foreach($farray["children"] as $child){
							
							$where = $where."'".$child["id"]."',"; 
							
						}
						$where = rtrim($where, ",");
						
						$where = $where.") AND";
					}
					
				} 
				
				$where = rtrim($where, "AND");
				
				if($starttime <> "00:00:00"){
					
					$where = $where." AND DATE_FORMAT(STR_TO_DATE(start_time, '%T'), '%T') >= DATE_FORMAT(STR_TO_DATE('".$starttime."', '%T'), '%T') AND DATE_FORMAT(STR_TO_DATE(end_time, '%T'), '%T') < DATE_FORMAT(STR_TO_DATE('".$endtime."', '%T'), '%T') ";
					
				}
				
				if($mindur <> "00:00:00"){
					
					$where = $where." AND DATE_FORMAT(STR_TO_DATE(duration, '%T'), '%T') >= DATE_FORMAT(STR_TO_DATE('".$mindur."', '%T'), '%T') AND DATE_FORMAT(STR_TO_DATE(duration, '%T'), '%T') <= DATE_FORMAT(STR_TO_DATE('".$maxdur."', '%T'), '%T') ";
					
				}
			
		}else{
			
			$where = " ";
		}
		
		
		
		
		
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$nmonth = date("m", strtotime($bulan));
		$data['hariawal'] = $this->days_in_month($nmonth, $tahun) ;
		$data['hariakhir'] = $this->days_in_month($nmonth, $tahun) ;
		
		$pilihaudiencebar=$this->input->post('audiencebar');
		$pilihprog=$this->input->post('product_program');
		
		
		if (!isset($tahun)){ 
		
			
			$tahun= $data['thn'][0]['TANGGAL'];
		}
		$periode=$tahun;
		$data['mingguan1'] = $this->tvprogramun_model->get_week_channel($periode);
		$data['mingguan2'] = $this->tvprogramun_model->get_week_program($periode);
		$data['active_audience'] = $this->tvprogramun_model->get_active_audience($periode);
		$data['bulanselected'] = $bulan;
		$data['tahunselected'] = $tahun;
		
		
		
		
		$data['cond'] = $where;
		$data['daytime'] = $this->tvprogramun_model->list_spot_by_daytime_all2($where,$periode);
		$data['prime'] = $this->tvprogramun_model->list_spot_by_prime_all2($where,$periode);
		$data['daypart'] = $this->tvprogramun_model->list_spot_by_daypart($where,$periode);
		$data['date'] = $this->tvprogramun_model->list_spot_by_date_all2($where,$periode);
		
		
		
		
		
		
		
			
		
			
		
		$prime = 0;
		$nprime = 0;
		
			
		
		if ($data['daypart'] <> null){
			foreach($data['daypart'] as $datass){
				$data_daytime[] = '"'.$datass['TIME'].'"';
				$spot_daytime[] = $datass['VIEWERS'];
			}	
		}
		else{
			$data_daytime[] = '';
			$spot_daytime[] = 0;
		}
		
		
		
		
		
		if ($data['date'] <> null){
			foreach($data['date'] as $datasss){
				$data_date[] = '"'.$datasss['date'].'"';
				$spot_date[] = $datasss['spot'];
			}
		}		
		else {
			$data_date[]='';
			$spot_date[] =0;
		}		
		$data['prime'] = $prime;
		$data['nprime'] = $nprime;
		
		$data['programsu'] = $this->tvprogramun_model->list_spot_by_program_all2Ps("Program",$where,$periode,$pilihprog,'0');
		
		$daily = $this->tvprogramun_model->daily($where,$periode,$pilihprog,'0');
		
		
		
		$data['channels'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$pilihaudiencebar,"0"); 
		
		$dataM=$data['channels'];
		for ($i=0;$i<count($dataM);$i++){
			$data_cha[] = '"'.$dataM[$i]['channel'].'"';
			$spot_cha[] = $dataM[$i]['Spot'];
		}
		
		$dataMa=$data['programsu'];
		$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];
		$scamas = array();
		for ($i=0;$i<count($dataMa);$i++){
			
			if($dataMa[$i]['FILE_TYPE'] == 0){
				$ft = 'Original';
			}else if($dataMa[$i]['FILE_TYPE'] == 99){
				$ft = 'File Not Found';
			}else{
				$ft = 'Rev '.$dataMa[$i]['FILE_TYPE'];
			}
			
			$fn = explode("/",$dataMa[$i]['FILE_NAME']);
			
			$scamu['Date'] = $dataMa[$i]['LOG_DATE'];
			$scamu['file_name'] = end($fn);
			$scamu['file_size'] = $dataMa[$i]['FILESIZE'];
			$scamu['row_file'] = $dataMa[$i]['ROW_COUNT_FILE'];
			$scamu['row_load'] = $dataMa[$i]['ROW_COUNT_LOAD'];
			$scamu['row_cleansing'] = $dataMa[$i]['ROW_COUNT_CLEANSING'];
			$scamu['date_load'] = $dataMa[$i]['DATE_LOAD'];
			$scamu['file_type'] = $ft;
				if($dataMa[$i]['STATUS_FILE'] == 3){
						$scamu['status'] = $status_array[$dataMa[$i]['STATUS_FILE']]."<br><button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$dataMa[$i]['LOG_DATE']."' onclick='onqueue(\"".$dataMa[$i]['LOG_DATE']."\",1)' >Process</button>".'<br>'.$dataMa[$i]['CHANNEL'];
					}else{
						$scamu['status'] = $status_array[$dataMa[$i]['STATUS_FILE']]."<br>".$dataMa[$i]['NOTE'].'<br>'.$dataMa[$i]['CHANNEL'];
					}
					
					if($dataMa[$i]['STATUS_FILE'] == 4){
						

						$scamu['check_data'] = "<span style='color:green'><strong>In Checking</strong></span>";

						
					}else{
						
						$scamu['check_data'] = "<button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' id='chek_btn_".$dataMa[$i]['LOG_DATE']."' data-id='".$dataMa[$i]['LOG_DATE']."' onclick='checkdata_day(\"".$dataMa[$i]['LOG_DATE']."\",".$type.")' >Check File</button>";
	
					}
					
			
			array_push($scamas, $scamu);
		}

		$status_array = ['Not Process','Success','Failed','On Process','','','','',''];
		$array_jobs_detail = ['LOAD_EPG','SPLIT_EPG','LOAD_CDR','CLEANSING_CDR','SPLIT_CDR','JOIN_CDR_EPG','RATING_PERMINUTES','TVCC','MEDIAPLAN','BEFORE_AFTER','MIGRATION','AUDIENCE','DASHBOARD'];
		$detail_daily = array();
		for ($i=0;$i<count($daily);$i++){
			$scamud['LOG_DATE'] = $daily[$i]['LOG_DATE'];
			$ssucc = 0;
			$prog = 0;
			
			foreach($array_jobs_detail AS $detail_name){
							$note[$detail_name] = explode("||",$daily[$i][$detail_name.'_NOTE']);
							
							if($daily[$i][$detail_name] == null){
								$scamud[$detail_name] = $status_array[0];
							}else{
								
								$scamud[$detail_name] = '<span style="color:red">'.$status_array[$daily[$i][$detail_name]].'<br>'.$note[$detail_name][0].'</span>';
								if($note[$detail_name][0] == ''){
									$scamud[$detail_name] = '<span>'.$status_array[$daily[$i][$detail_name]].'<br>'.$note[$detail_name][0].'</span>';
								}
							}
				
				$note[$detail_name] = explode("||",$daily[$i][$detail_name.'_NOTE']);
				$scamud[$detail_name.'_NOTE'] = $note[$detail_name][0];
				$scamud[$detail_name.'_NOTE_FL'] = $scamud[$detail_name]."||".$note[$detail_name][0];
				
				if($daily[$i][$detail_name] == 1){
					$ssucc++ ;
				}
				
				if($daily[$i][$detail_name] == 3){
						
						$prog++;
				}
			}
			
			
				if($daily[$i]['STATUS_J'] == 3){
					
					$scamud['SUCC'] = "On Progress";
				}else{
					
					if($ssucc < 13 && $ssucc > 2){
						if($ssucc == 0){
							$scamud['SUCC'] = "Process Not Running";
						}else{
							if($prog == 0){
								$scamud['SUCC'] = "Process Not Complete<br><button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' id='btn_repro_".$daily[$i]['LOG_DATE']."' data-id='".$daily[$i]['LOG_DATE']."' onclick='onreproc(\"".$daily[$i]['LOG_DATE']."\",1)' >Reprocess</button>";
							}else{
								$scamud['SUCC'] = "Process Not Complete";
							}
						}
					}elseif($ssucc == 2){
						$scamud['SUCC'] = "Process Not Complete";
					}else{
						$scamud['SUCC'] = "Process Complete<br><button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' id='btn_repro_".$daily[$i]['LOG_DATE']."' data-id='".$daily[$i]['LOG_DATE']."' onclick='onreproc(\"".$daily[$i]['LOG_DATE']."\",1)' >Reprocess</button>";
					}
					
				}
			
			
			
			array_push($detail_daily, $scamud);
		}
		
		
		$data['daily'] = json_encode($detail_daily,true); 
		$data['programs'] = json_encode($scamas,true); 
		
		$data['detail_daily_name'] = $array_jobs_detail;
		foreach($data['channels'] as $datac){
			$data_cha[] = '"'.$datac['channel'].'"';
			$spot_cha[] = $datac['Spot'];
			
		}
		
		$data['spots'] = $this->tvprogramun_model->list_spot_all2($where,$periode);
		
		
		$data['json_days'] = $data_daytime;
		$data['json_spot_days'] = $spot_daytime;
		
		$data['json_date'] = $data_date;
		$data['json_spot_date'] = $spot_date;
		$data['prg'] = json_decode($data['programs'],true);
		$data['jmlchannel'] = $this->tvprogramun_model->count_channel();
		$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2($periode);
		$data['check_stat'] = $this->tvprogramun_model->check_stat();
		
		
		$this->template->load('maintemplate', 'dashboarddata/views/Tvprogramun', $data);
	}	
	
	function insert_queue_rep_f(){
		
		$date_data =  $this->input->post('date_data');
		$type_jobs =  $this->input->post('type_jobs');
		
		
		$this->tvprogramun_model->insert_queue_f($date_data,$type_jobs);
		
		
		
		$periode =  date_format(date_create($date_data),"Y-F");
		
		$data['programs'] = $this->tvprogramun_model->filter_table("Program",$periode,$type_jobs);
		$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];

		if(sizeof($data['programs']) > 0){
  		  $i = 1;
  			$ik = 0;
				foreach($data['programs'] as $datax){
					
					if($datax['FILE_TYPE'] == 0){
						$ft = 'Original';
					}else if($datax['FILE_TYPE'] == 99){
						$ft = 'File Not Found';
					}else{
						$ft = 'Rev '.$datax['FILE_TYPE'];
					}
					
					$fn = explode("/",$datax['FILE_NAME']);
					
					$data_ch[$ik]['Date'] = $datax['LOG_DATE'];
					$data_ch[$ik]['file_name'] = end($fn);
					$data_ch[$ik]['file_size'] = $datax['FILESIZE'];
					$data_ch[$ik]['row_file'] = $datax['ROW_COUNT_FILE'];
					$data_ch[$ik]['row_load'] = $datax['ROW_COUNT_LOAD'];
					$data_ch[$ik]['row_cleansing'] = $datax['ROW_COUNT_CLEANSING'];
					$data_ch[$ik]['date_load'] = $datax['DATE_LOAD'];
					$data_ch[$ik]['file_type'] = $ft;
					
					if($datax['STATUS_FILE'] == 3){
						$data_ch[$ik]['status'] = $status_array[$datax['STATUS_FILE']]."<br><button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='onqueue(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Process</button>".'<br>'.$datax[$i]['CHANNEL'];
					}else{
						$data_ch[$ik]['status'] = $status_array[$datax['STATUS_FILE']]."<br>".$datax['NOTE'].'<br>'.$datax[$i]['CHANNEL'];
					}
					
					
					
					if($datax['STATUS_FILE'] == 1){
						
						if($datax['STATUS_J'] == 1 ){
							$data_ch[$ik]['check_data'] = "<span style='color:blue'><strong>Checked</strong></span>";
						}elseif($datax['STATUS_J'] == 2 ){
							$data_ch[$ik]['check_data'] = "<button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='onreproc_f(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Reprocess</button>";
						}elseif($datax['STATUS_J'] == 3 ){
							$data_ch[$ik]['check_data'] = "<span style='color:green'><strong>In Checking</strong></span>";
							
						}elseif($datax['STATUS_J'] == 4 ){
							$data_ch[$ik]['check_data'] = "<span style='color:green'><strong>In Queue</strong></span>";
							
						}else{
						
							$data_ch[$ik]['check_data'] = "<button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='checkdata_day(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Check File</button>";
						}
						
					}else{
						$data_ch[$ik]['check_data']  = "";
					}
					
					$i++;
					$ik++;
				}
		} else {
			$data_ch = null;
		}
		
		echo json_encode($data_ch,true);
		
		
		
	}

	function insert_queue_rep(){
		
		$date_data =  $this->input->post('date_data');
		$type_jobs =  $this->input->post('type_jobs');
		
		
		$this->tvprogramun_model->insert_queue_rep($date_data,$type_jobs);
		
		
		
		$periode =  date_format(date_create($date_data),"Y-F");
		
		
		
		$type = $type_jobs;
		$tahun= $periode;
		$detail_file = 9;
		
		if($type == "1"){
		
			$daily = $this->tvprogramun_model->daily_filter($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_EPG','SPLIT_EPG','LOAD_CDR','CLEANSING_CDR','SPLIT_CDR','JOIN_CDR_EPG','RATING_PERMINUTES','TVCC','MEDIAPLAN','BEFORE_AFTER','MIGRATION','AUDIENCE','DASHBOARD'];
			$iii = 13;

		}elseif($type == "2"){
			
			$daily = $this->tvprogramun_model->daily_filter_2($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
			$iii = 9;

			
		}elseif($type == "3"){
			
			$daily = $this->tvprogramun_model->daily_filter_3($tahun);

			$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
			$iii = 9;

			
		}elseif($type == "4"){
			
			$daily = $this->tvprogramun_model->daily_filter_4($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_CIM','SPLIT_CIM','DETAIL_CIM','DETAIL_LOGPROOF','CIM_RATING','REACH_PRODUCT','REACH_SECTOR','REACH_ADVERTISER','REACH_PRODUCT_MONTHLY','REACH_SECTOR_MONTHLY','REACH_ADVERTISER_MONTHLY','SUB_CAT','DASHBOARD_POSTBUY'];
			$iii = 13;

			
		}elseif($type == "5"){
			
			$daily = $this->tvprogramun_model->daily_filter_5($tahun,$detail_file);

			$array_jobs_detail = ['LOAD_RATECARD','CLEANSING_RATECARD','SPLIT_RATECARD','DETAIL_RATECARD','RATING_PERMINUTES','MEDIAPLAN_RATING','TVCC','AFTER_BEFORE','MIGRATION','AUDIENCE','DASHBOARD_MEDIAPLAN'];
			$iii = 11;

			
		}
		
		
			$status_array = ['Not Process','Success','Failed','On Process','On Queue'];

			$detail_daily = array();
			for ($i=0;$i<count($daily);$i++){
				$scamud['LOG_DATE'] = $daily[$i]['LOG_DATE'];
				$ssucc = 0;
				$prog = 0;
				
				foreach($array_jobs_detail AS $detail_name){
					if($daily[$i][$detail_name] == null){
						$scamud[$detail_name] = $status_array[0];
					}else{
						$scamud[$detail_name] = $status_array[$daily[$i][$detail_name]];
					}
					
							if($daily[$i][$detail_name] == null){
								$scamud[$detail_name] = $status_array[0];
							}else{
								
								$scamud[$detail_name] = '<span style="color:red">'.$status_array[$daily[$i][$detail_name]].'<br>'.$note[$detail_name][0].'</span>';
								if($note[$detail_name][0] == ''){
									$scamud[$detail_name] = '<span>'.$status_array[$daily[$i][$detail_name]].'<br>'.$note[$detail_name][0].'</span>';
								}
							}
					
					$note[$detail_name] = explode("||",$daily[$i][$detail_name.'_NOTE']);
					$scamud[$detail_name.'_NOTE'] = $note[$detail_name][0];
					$scamud[$detail_name.'_NOTE_FL'] = $scamud[$detail_name]."||".$note[$detail_name][0];
					
					if($daily[$i][$detail_name] == 1){
						$ssucc++ ;
					}
					
					if($daily[$i][$detail_name] == 3){
						
						$prog++;
					}
				}

				if($daily[$i]['STATUS_J'] == 3){
					
					$scamud['SUCC'] = "On Progress";
				}else{
				
					if($ssucc < $iii && $ssucc > 2){
						if($ssucc == 0){
							$scamud['SUCC'] = "Process Not Running";
						}else{
							if($prog == 0){
								$scamud['SUCC'] = "Process Not Complete<br><button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' id='btn_repro_".$daily[$i]['LOG_DATE']."' data-id='".$daily[$i]['LOG_DATE']."' onclick='onreproc(\"".$daily[$i]['LOG_DATE']."\",".$type.")' >Reprocess</button>";
							}else{
								$scamud['SUCC'] = "Process Not Complete";
							}
						}
					}elseif($ssucc == 2){
						$scamud['SUCC'] = "Process Not Complete";
					}else{
						$scamud['SUCC'] = "Process Complete<br><button class='button_black' id='btn_repro_".$daily[$i]['LOG_DATE']."'  style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$daily[$i]['LOG_DATE']."' onclick='onreproc(\"".$daily[$i]['LOG_DATE']."\",1)' >Reprocess</button>";
					}
				
				}
				
				array_push($detail_daily, $scamud);
			}
			
			$data['daily'] = json_encode($detail_daily,true); 
			
			echo $data['daily'];
		
	}
	
	function insert_queue(){
		
		$date_data =  $this->input->post('date_data');
		$type_jobs =  $this->input->post('type_jobs');
		
		
		$this->tvprogramun_model->insert_queue($date_data,$type_jobs);
		
		$get_file = $this->tvprogramun_model->get_file_prop($date_data,$type_jobs);
		
		$arr_file = explode("/",$get_file[0]['FILE_NAME']);
		
		

		
		
		
		$tahun=$this->input->post('tahun');

		$periode=$tahun; 

			
		if($type_jobs == 7 || $type_jobs == 8 ){
			$data['programs'] = $this->tvprogramun_model->filter_table2("Program",$periode,$type_jobs);
		}else{
			$data['programs'] = $this->tvprogramun_model->filter_table("Program",$periode,$type_jobs);
		}
		
		$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];

		if(sizeof($data['programs']) > 0){
  		  $i = 1;
  			$ik = 0;
				foreach($data['programs'] as $datax){
					
					if($datax['FILE_TYPE'] == 0){
						$ft = 'Original';
					}else if($datax['FILE_TYPE'] == 99){
						$ft = 'File Not Found';
					}else{
						$ft = 'Rev '.$datax['FILE_TYPE'];
					}
					
					$fn = explode("/",$datax['FILE_NAME']);
					
					$data_ch[$ik]['Date'] = $datax['LOG_DATE'];
					$data_ch[$ik]['file_name'] = end($fn);
					$data_ch[$ik]['file_size'] = $datax['FILESIZE'];
					$data_ch[$ik]['row_file'] = $datax['ROW_COUNT_FILE'];
					$data_ch[$ik]['row_load'] = $datax['ROW_COUNT_LOAD'];
					$data_ch[$ik]['row_cleansing'] = $datax['ROW_COUNT_CLEANSING'];
					$data_ch[$ik]['date_load'] = $datax['DATE_LOAD'];
					$data_ch[$ik]['file_type'] = $ft;
					
					if($datax['STATUS_FILE'] == 3){
						$data_ch[$ik]['status'] = $status_array[$datax['STATUS_FILE']]."<br><button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='onqueue(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Process</button>".'<br>'.$datax[$i]['CHANNEL'];
					}else{
						$data_ch[$ik]['status'] = $status_array[$datax['STATUS_FILE']]."<br>".$datax['NOTE'].'<br>'.$datax[$i]['CHANNEL'];
					}
					
					
					
					if($datax['STATUS_FILE'] == 1){
						
						if($datax['STATUS_J'] == 1 ){
							$data_ch[$ik]['check_data'] = "<span style='color:blue'><strong>Checked</strong></span>";
						}elseif($datax['STATUS_J'] == 2 ){
							$data_ch[$ik]['check_data'] = "<button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='onreproc_f(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Reprocess</button>";
						}elseif($datax['STATUS_J'] == 3 ){
							$data_ch[$ik]['check_data'] = "<span style='color:green'><strong>In Checking</strong></span>";
							
						}elseif($datax['STATUS_J'] == 4 ){
							$data_ch[$ik]['check_data'] = "<span style='color:green'><strong>In Queue</strong></span>";
							
						}else{
						
							$data_ch[$ik]['check_data'] = "<button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$datax['LOG_DATE']."' onclick='checkdata_day(\"".$datax['LOG_DATE']."\",".$type_jobs.")' >Check File</button>";
						}
						
					}else{
						$data_ch[$ik]['check_data']  = "";
					}
					
					$i++;
					$ik++;
				}
		} else {
			$data_ch = null;
		}
		
		echo json_encode($data_ch,true);
		
	}
	
	function days_in_month($month, $year) 
	{ 
		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
	}
	
	function checkdata_day(){
		
			
		$params['type'] =  $this->Anti_si($this->input->post('type'));
		$params['date_file'] = $this->Anti_si($this->input->post('date_file'));
		$params['token'] = $this->Anti_si($this->input->post('token'));
		
		$params['token']= $token;
		$params['uid']= $this->session->userdata('user_id');
		$tahun = $date_file;
			
			if($params['type'] == "5"){
			
				// $queue_id = 6;
				// $sc_duplicate = "php /data/opep/srcs/jobs/check_epg_file.php ".$tahun." ";
				// $tbs = 'DAILY_CHECK_REPORT';
				
				$raw_epg = $this->tvprogramun_model->get_epg_raw($params);
				$cnt_raw_epg = count($raw_epg);
				
				$epg_click = $this->tvprogramun_model->epg_click($params);
				$cnt_epg_click = count($epg_click);
				
				if($cnt_raw_epg == $cnt_epg_click){
					
					$nerr = 0;
					for($is = 0; $is < $cnt_raw_epg ;$is++){
						if($raw_epg[$is]['CHANNEL'] == $epg_click[$is]['CHANNEL'] && $raw_epg[$is]['PROGRAM'] == $epg_click[$is]['PROGRAM'] && $raw_epg[$is]['BEGIN_PROGRAM'] == $epg_click[$is]['BEGIN_PROGRAM'] && $raw_epg[$is]['END_PROGRAM'] == $epg_click[$is]['END_PROGRAM'] && $raw_epg[$is]['KATEGORI_CHANNEL'] == $epg_click[$is]['KATEGORI_CHANNEL'] && $raw_epg[$is]['GENRE_PROGRAM'] == $epg_click[$is]['GENRE_PROGRAM'] ){
							
							$button_process = '';
							$button_check = 1;
							
							$nerr++;
						}else{
							$button_check = 2;
							
							$button_process = "<div id='note_div_".$params['date_file']."'>File Ready to Process<br><button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' id='process_btn_".$params['date_file']."' data-id='".$params['date_file']."' onclick='onqueue(\"".$params['date_file']."\",".$params['type'].")' >Process</button></div>";
							$this->tvprogramun_model->update_epg_process($params);
							break; 
						}
					}
				}else{
					//$button_check = "<button class='btn urate-outline-btn' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$params['date_file']."' onclick='checkdata_day(\"".$params['date_file']."\",".$params['type'].")' >Check Data</button>";
					$button_process = "<div id='note_div_".$params['date_file']."'>Process Success<br><br></div>";
					$button_check = 1;
					$this->tvprogramun_model->update_epg_process($params);
				}


			}elseif($params['type'] == "1"){
			
				$queue_id = 6;
				// $sc_duplicate = "php /data/opep/srcs/jobs/check_cdr_file.php ".$tahun." ";
				// $tbs = 'DAILY_CHECK_REPORT';
				
				$this->tvprogramun_model->recheck_cdr_process($params);
				
				$button_process = "<div id='note_div_".$params['date_file']."'>Process Success<br><br></div>";
				$button_check = 1;
				

			}
			
			//$this->tvprogramun_model->insert_queue_check($tahun,$queue_id,$sc_duplicate,$tbs);
						
			$res = array(
					'status' => 'success',
					'message' => 'Success Process',
					'btn' => $button_process,
					'btn_check' => $button_check
			);
			
		
		// }
		
		$this->output->set_content_type('application/json')->set_output(json_encode($res));
		
		
	}
	
	
	function datadash(){
		 $menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);
		//if(!$this->session->userdata('user_id') || in_array("89",$array_menu) == 0) {
		if(in_array("0",$array_menu) == 1) {
			$result = array('success' => false, 'message' => "Failed to Process", 'data' => '');
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}else{
			$channel_error = 0;
			$type =  $this->input->post('type');
			$array_tp = [1 => 1,2 => 2,3 => 3,4 => 4,5 => 5,6 => 6,7 => 7,8 => 8];
			
			
			$tahun= $this->input->post('tahun');
			$detail_file = $this->input->post('detail_file');
			$token = $this->input->post('token');
			
			$params['token']= $token;
			$params['uid']= $this->session->userdata('user_id');
			
			if($array_tp[$type]==''){
				$channel_error++;
			}
			
				$get_list_channel = $this->tvprogramun_model->get_list_periode();
				$arr_chnel_l = [];
				foreach($get_list_channel as $get_list_channelsa){
					$arr_chnel_l[] = $get_list_channelsa['TANGGAL'];
				}
								
				if(in_array(str_replace("'","",$tahun),$arr_chnel_l) == 0){
					$channel_error++;
				}
			
				if($channel_error > 0){
					$result = array('success' => false, 'message' => "Parameters not Valid", 'data' => '');
					$this->output->set_content_type('application/json')->set_output(json_encode($result));
				}else{
					
					$validate = $this->tvprogramun_model->validate_password($params);

				
					if($type == "1"){
					
						$daily = $this->tvprogramun_model->daily_filter($tahun,$detail_file);

						$array_jobs_detail = ['LOAD_EPG','SPLIT_EPG','LOAD_CDR','CLEANSING_CDR','SPLIT_CDR','JOIN_CDR_EPG','RATING_PERMINUTES','TVCC','MEDIAPLAN','BEFORE_AFTER','MIGRATION','AUDIENCE','DASHBOARD'];
						$iii = 13;

					}elseif($type == "2"){
						
						$daily = $this->tvprogramun_model->daily_filter_2($tahun,$detail_file);

						$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
						$iii = 9;

						
					}elseif($type == "3"){
						
						$daily = $this->tvprogramun_model->daily_filter_3($tahun);

						$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
						$iii = 9;

						
					}elseif($type == "4"){
						
						$daily = $this->tvprogramun_model->daily_filter_4($tahun,$detail_file);

						$array_jobs_detail = ['LOAD_CIM','SPLIT_CIM','DETAIL_CIM','DETAIL_LOGPROOF','CIM_RATING','REACH_PRODUCT','REACH_SECTOR','REACH_ADVERTISER','REACH_PRODUCT_MONTHLY','REACH_SECTOR_MONTHLY','REACH_ADVERTISER_MONTHLY','SUB_CAT','DASHBOARD_POSTBUY'];
						$iii = 13;

						
					}elseif($type == "5"){
						
						$daily = $this->tvprogramun_model->daily_filter_5($tahun,$detail_file);

						$array_jobs_detail = ['LOAD_RATECARD','CLEANSING_RATECARD','SPLIT_RATECARD','DETAIL_RATECARD','RATING_PERMINUTES','MEDIAPLAN_RATING','TVCC','AFTER_BEFORE','MIGRATION','AUDIENCE','DASHBOARD_MEDIAPLAN'];
						$iii = 11;

						
					}elseif($type == "7"){
						
						$daily = $this->tvprogramun_model->daily_filter_7($tahun,$detail_file);

						$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
						$iii = 9;

						
					}elseif($type == "8"){
						
						$daily = $this->tvprogramun_model->daily_filter_8($tahun,$detail_file);

						$array_jobs_detail = ['LOAD_LOGPROOF','SPLIT_LOGPROOF','JOIN_LOGPROOF_CDR','DETAIL_LOGPROOF','PTV_CIM_RATING','REACH_BRAND','REACH_AGENCY','REACH_ADVERTISER','SUB_CAT'];
						$iii = 9;

						
					}
					
					$status_array = ['Not Process','Success','Failed','On Process','On Queue'];

					$detail_daily = array();
					for ($i=0;$i<count($daily);$i++){
						$scamud['LOG_DATE'] = $daily[$i]['LOG_DATE'];
						$ssucc = 0;
						$prog = 0;
						
						foreach($array_jobs_detail AS $detail_name){
							
							$note[$detail_name] = explode("||",$daily[$i][$detail_name.'_NOTE']);
							
							if($daily[$i][$detail_name] == null){
								$scamud[$detail_name] = $status_array[0];
							}else{
								
								$scamud[$detail_name] = '<span style="color:red">'.$status_array[$daily[$i][$detail_name]].'<br>'.$note[$detail_name][0].'</span>';
								if($note[$detail_name][0] == ''){
									$scamud[$detail_name] = '<span>'.$status_array[$daily[$i][$detail_name]].'<br>'.$note[$detail_name][0].'</span>';
								}
							}
							
							$note[$detail_name] = explode("||",$daily[$i][$detail_name.'_NOTE']);
							$scamud[$detail_name.'_NOTE'] = $note[$detail_name][0];
							$scamud[$detail_name.'_NOTE_FL'] = $scamud[$detail_name]."||".$note[$detail_name][0];
							
							if($daily[$i][$detail_name] == 1){
								$ssucc++ ;
							}
							
							if($daily[$i][$detail_name] == 3){
								
								$prog++;
							}
						}

						if($daily[$i]['STATUS_J'] == 3){
							
							$scamud['SUCC'] = "On Progress";
						}else{
							
							if($ssucc < $iii){
								if($ssucc == 0){
									$scamud['SUCC'] = "Process Not Running";
								}else{
									if($prog == 0){
										$scamud['SUCC'] = "Process Not Complete<br><button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$daily[$i]['LOG_DATE']."' onclick='onreproc(\"".$daily[$i]['LOG_DATE']."\",".$type.")' >Reprocess</button>";
									}else{
										$scamud['SUCC'] = "Process Not Complete";
									}
								}
							}else{
								$scamud['SUCC'] = "Process Complete<br><br><button class='button_black' style='cursor: pointer;padding:1px;padding-left:10px;padding-right:10px' data-id='".$daily[$i]['LOG_DATE']."' onclick='onreproc(\"".$daily[$i]['LOG_DATE']."\",1)' >Reprocess</button>";
							}
							
						}
						

						
						
						
						array_push($detail_daily, $scamud);
					}
					 
					
					$data['daily'] = json_encode($detail_daily,true); 
					
					echo $data['daily'];
				}
		}
		
	}
	
	function cost_by_program(){
		 $menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);
		if(!$this->session->userdata('user_id') || in_array("89",$array_menu) == 0) {
			$result = array('success' => false, 'message' => "Failed to Process", 'data' => '');
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}else{
			$channel_error = 0;
			
			$array_tp = [1 => 1,2 => 2,3 => 3,4 => 4,5 => 5,6 => 6,7 => 7,8 => 8];
			
			$field =  $this->input->post('field');
			$tahun= $this->input->post('tahun');
			$token = $this->input->post('token');
						
			$params['token']= $token;
			$params['uid']= $this->session->userdata('user_id');
			
				
				
				$get_list_channel = $this->tvprogramun_model->get_list_periode();
				$arr_chnel_l = [];
				foreach($get_list_channel as $get_list_channelsa){
					$arr_chnel_l[] = $get_list_channelsa['TANGGAL'];
				}
								
				if(in_array(str_replace("'","",$tahun),$arr_chnel_l) == 0){
					$channel_error++;
				}
				
				if($channel_error > 0){
					$result = array('success' => false, 'message' => "Parameters not Valid", 'data' => '');
					$this->output->set_content_type('application/json')->set_output(json_encode($result));
				}else{
					$periode=$tahun; 


					$data['programs'] = $this->tvprogramun_model->filter_table($periode,$type);
					
					//print_r($data['programs']);die;
					
					$status_array = ['Not Process','Process Success','Process Fail','File Ready to Process','On Queue','On Progress','Checking File'];
					
					$process_status = ['Process Incomplete','Process Success','Process Error','On Process','Process Done with Error'];
					$process_color = ['','#5ee6a2','#e0675e','yellow','orange'];
					$process_color_p = ['','green','#red','yellow','orange'];
					
					$array_jobs_detail = [['SPLIT_EPG','Split EPG'],['CLEANSING_CDR','Cleansing CDR'],['SPLIT_CDR','Split CDR'],['JOIN_CDR_EPG','Join CDR EPG'],['RATING_PERMINUTES','Rating per Minutes'],['TVCC','TVCC'],['MEDIAPLAN','TVPC'],['BEFORE_AFTER','Summart Before After'],['MIGRATION','Channel Migration'],['AUDIENCE','Channel Audience'],['DASHBOARD','Dashboard']];
					
					
					if(sizeof($data['programs']) > 0){
					  $i = 1;
						$ik = 0;
							foreach($data['programs'] as $datax){
								
								if($datax['FILE_TYPE'] == 0){
									$ft = 'Original';
								}else if($datax['FILE_TYPE'] == 99){
									$ft = 'File Not Found';
								}else{
									$ft = 'Rev '.$datax['FILE_TYPE'];
								}

								$data_ch[$ik]['Date'] = $datax['LOG_DATE'];
								$data_ch[$ik]['status'] = '<span style="color:'.$process_color[$datax['STATUS_J']].'">'.$process_status[$datax['STATUS_J']].'</span>';
								$data_ch[$ik]['status_color'] = $process_color[$datax['STST']];
								$data_ch[$ik]['start_process'] = $datax['START_DATE'];
								$data_ch[$ik]['end_process'] = $datax['END_DATE'];
								$data_ch[$ik]['detail'] = $datax['DETAILS'];
								
								$details_d = explode("--,",$datax['DETAILS']);
								
								
								IF($datax['LOAD_EPG'] == null){
									$data_ch[$ik]['load_epg'] = 'File Not Ready';
									$data_ch[$ik]['load_epg_color'] = $process_color[0];
									$data_ch[$ik]['load_epg_time'] = '';
								}else{
									$datad = explode("||",$details_d[0]);
									$fn = explode("/",$datad[0]);
									$detail_loads = explode("||",$datax['LOAD_EPG_NOTE']);
									$data_ch[$ik]['load_epg'] = $process_status[$datax['LOAD_EPG']].'<br>'.$detail_loads[0].'<br>'.end($fn).' '.$datad[1].' Rows, '.round(($datad[2]/1024),2).' KB ';
									
									$data_ch[$ik]['load_epg_time'] = $detail_loads[1].' - '.$detail_loads[2];
									$data_ch[$ik]['load_epg_color'] = $process_color[$datax['LOAD_EPG']];
								}
								
								IF($datax['LOAD_CDR'] == null){
									$data_ch[$ik]['load_cdr'] = 'File Not Ready';
									$data_ch[$ik]['load_cdr_color'] = $process_color[0];
									$data_ch[$ik]['load_cdr_time'] = '';
								}else{
									$datad = explode("||",$details_d[1]);
									$fn = explode("/",$datad[0]);
									$data_ch[$ik]['load_cdr'] = $process_status[$datax['LOAD_CDR']].'<br>'.end($fn).' '.$datad[1].' Rows, '.round(($datad[2]/(1024*1024)),2).' MB ';
									
									$detail_loads = explode("||",$datax['LOAD_CDR_NOTE']);
									
									$data_ch[$ik]['load_cdr_time'] = $detail_loads[1].' - '.$detail_loads[2];
									$data_ch[$ik]['load_cdr_color'] = $process_color[$datax['LOAD_CDR']];
								}
								
								
								foreach($array_jobs_detail as $array_jobs_details){
								
									$data_ch[$ik][$array_jobs_details[0].'_NAME']  = $array_jobs_details[1];
									IF($datax[$array_jobs_details[0]] == null){
										$data_ch[$ik][$array_jobs_details[0]] = 'File Not Ready';
										$data_ch[$ik][$array_jobs_details[0].'_COLOR'] = $process_color[0];
										$data_ch[$ik][$array_jobs_details[0].'_TIME'] = '';
									}else{
										$datad = explode("||",$details_d[1]);
										$fn = explode("/",$datad[0]);
										$data_ch[$ik][$array_jobs_details[0]] = $process_status[$datax[$array_jobs_details[0]]];
										
										$detail_loads = explode("||",$datax[$array_jobs_details[0].'_NOTE']);
										
										$data_ch[$ik][$array_jobs_details[0].'_TIME'] = $detail_loads[1].' - '.$detail_loads[2];
										$data_ch[$ik][$array_jobs_details[0].'_COLOR'] = $process_color[$datax[$array_jobs_details[0]]];
									}
								
								}
								
								
								$i++;
								$ik++;
							}
					} else {
						$data_ch = null;
					}

					echo json_encode($data_ch,true);
				}
		}
	}
	
	function audiencebar_by_channel(){
		
		$where =  $this->input->post('cond');
		$type =  $this->input->post('type');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$profile=$this->input->post('profile');
		$nmonth = date("m", strtotime($tahun));
		$week=$this->input->post('week');
		$tgl=$this->input->post('tgl');
		
		$datef = $tgl."/".$nmonth."/".substr($tahun,0,4);
		$periode=$tahun;
		
			if ($week=="0"){
				
				if($tgl=="0"){
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_all_bar("channel_name",$where,$periode,$type,$profile); 
				}else{
					$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_date("channel_name",$where,$periode,$datef,$type,$profile); 
				}
				
			}else{
				$data['channel'] = $this->tvprogramun_model->list_spot_by_program_hari_bar("channel_name",$where,$periode,$week,$type,$profile); 
			}
			
			$data['totpopulasi'] = $this->tvprogramun_model->list_populasi2new();
			
      if(sizeof($data['channel']) > 0){
    			if($type == 'Reach'){
    				foreach($data['channel'] as $datax){
    					$data_ch['cat'][] = $datax['channel'];
    					$data_ch['data'][] = round(($datax['Spot']/$data['totpopulasi'][0]['tot_pop'])*100,2);
    				}
    			}else{
    				foreach($data['channel'] as $datax){
    					$data_ch['cat'][] = $datax['channel'];
    					$data_ch['data'][] = $datax['Spot'];
    				}
    			}
      } else {
          $data_ch['cat'][] = "";
          $data_ch['data'][] = "";
      }
      
		echo json_encode($data_ch,true);
	}

}

