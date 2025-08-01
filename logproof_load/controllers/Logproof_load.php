<?php
date_default_timezone_set('Asia/Jakarta');
defined('BASEPATH') OR exit('No direct script access allowed');

class logproof_load extends JA_Controller {
 
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvprogramun_model');
	}

		
	function getDatesFromRange($start, $end, $format = 'Y-m-d') { 
      
     $array = array(); 
      
   
    $interval = new DateInterval('P1D'); 
  
    $realEnd = new DateTime($end); 
    $realEnd->add($interval); 
  
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
  
     foreach($period as $date) {                  
        $array[] = $date->format($format);  
    } 
  
     return $array; 
} 
	
  public function index()
	{
		$menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);
		
		// print_r($array_menu );die;
		//echo in_array("254",$array_menu);die;

		if(!$this->session->userdata('user_id') || in_array("254",$array_menu) == 0) {
          redirect ('/login');
		}
		
		$first_date = date('Y-m-d', strtotime($Date. ' -1 days'));
		$last_date = date('Y-m-d', strtotime($Date. ' 6 days'));
						
		$array_date = $this->getDatesFromRange($first_date,$last_date);
		$array_data_channel = [];
		foreach($array_date as $array_dats){
			
			$list = $this->tvprogramun_model->get_list_channel($array_dats);
			$array_data_channel[$array_dats] = $list[0]['CLS'];
			
		}
		
		//print_r($array_data_channel);die;
		
		$data['array_data_channel'] = $array_data_channel;
		$data['array_date'] = $array_date;

		
		$this->template->load('maintemplate', 'logproof_load/views/Tvprogramun', $data);
	}	
	
	function audiencebar_by_channel_file(){
		 $menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);
		if(!$this->session->userdata('user_id') || in_array("254",$array_menu) == 0) {
			$result = array('success' => false, 'message' => "Failed to Edit", 'data' => '');
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}else{
			
		
			$param['start_date'] =  $this->Anti_si($this->input->post('start_date',true));
			$param['end_date'] =  $this->Anti_si($this->input->post('end_date',true));
			
			$s_date = explode('/',$param['start_date']);
			$s_date_f = $s_date[2].'-'.$s_date[1].'-'.$s_date[0];
			
			$e_date = explode('/',$param['end_date']);
			$e_date_f = $e_date[2].'-'.$e_date[1].'-'.$e_date[0];
					
			$where = " WHERE A.UPLOAD_DATE BETWEEN '".$s_date_f." 00:00:00' AND '".$e_date_f." 23:59:59'  ";
			
			$list_us = $this->tvprogramun_model->get_profile($params);
			$arr_uss = [];
			
			foreach($list_us as $uss){
				$arr_uss[$uss['id']] = $uss['nama'];
			}
					  
			 $channel = $this->tvprogramun_model->list_epg_fil_his($where); 
			 
			 
			 
			 $arr_uss_file = [];
			 foreach($channel as  $channels){
				 $data_sds = [];
				 $data_sds['FILENAME'] = $channels['FILENAME'];
				 $data_sds['PERIODE'] = $channels['START_DATE'].' - '.$channels['END_DATE'];
				 $data_sds['ERROR'] = $channels['ERROR'];
				 $data_sds['UPLOAD_DATE'] = $channels['UPLOAD_DATE'];
				 $data_sds['PROCESS_DATE'] = $channels['PROCESS_DATE'];
				 $data_sds['USER'] = $arr_uss[$channels['ID_USER']];
				 $data_sds['ROW_TOTAL'] = $channels['ROW_TOTAL'];
				 $data_sds['TOKEN'] = $channels['TOKEN'];
				 $data_sds['TYPE'] = $channels['TPE'];
				 if($channels['PROCESS_DATE'] == null){
					$data_sds['STATUS'] = 'File Uploaded';
					$data_sds['BTN'] = '';
				 }else{
					 if($channels['ERROR'] <> ''){
						$data_sds['STATUS'] = 'File Failed to Uploaded';
						$data_sds['BTN'] = '';
					 }else{
						$data_stat = $this->tvprogramun_model->data_stat($channels); 
						$data_sds['STATUS'] = 'File Proccesed';
						if($data_stat[0]['AVA'] == 'Data Available'){
							$data_sds['ERROR'] = '<span style="color:green">Data Viewers Available</span>';
						}else{
							$data_sds['ERROR'] = '<span style="color:red">Data Viewers Not Available</span>';
						}
						$data_sds['BTN'] = '<button id="'.$data_sds['TOKEN'].'" onClick="download_file_exs(\''.$data_sds['TOKEN'].'\')" class="button_black">Download</button>';
					 }
				 }
				  
				 $arr_uss_file[] = $data_sds;
			 }
			 
			 //print_r($arr_uss_file);die;
			 echo json_encode($arr_uss_file,true);
		}
	} 
	
	public function audiencebar_by_program_export(){

		$token_p=$this->Anti_si($this->input->post('token_p'));
		
		$list = $this->tvprogramun_model->get_epg_file_t($token_p);
		
		
		$tbl = strtoupper(date_format(date_create($list[0]['START_DATE']),"yM")); 
		
		//print_r($list);DIE;
		
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
						->setCellValue('A1', $list[0]['TITLE']);

		
						
		$array_field = ['NO','NO TEL','BRAND','ADV','AGENCY','CHANNEL','DATE','TIME','HOUSE NUMBER','PRODUCT/VERSION','DUR','STATUS','RATE','RATECARD','VIEWERS'];
		$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A3', 'NO')
						->setCellValue('B3', 'NO TEL')
						->setCellValue('C3', 'BRAND')
						->setCellValue('D3', 'ADV')
						->setCellValue('E3', 'AGENCY')
						->setCellValue('F3', 'CHANNEL')
						->setCellValue('G3', 'DATE')
						->setCellValue('H3', 'TIME')
						->setCellValue('I3', 'HOUSE NUMBER')
						->setCellValue('J3', 'PRODUCT/VERSION')
						->setCellValue('K3', 'DUR')
						->setCellValue('L3', 'STATUS')
						->setCellValue('M3', 'RATE')
						->setCellValue('N3', 'RATECARD')
						->setCellValue('O3', 'VIEWERS');
		
		$list_data = $this->tvprogramun_model->get_file_data($token_p,$tbl);
		
		$it1 = 4;
	   // $ii = 0;
		foreach($list_data as $frt){
			
			IF($frt['VIEWERS'] == ''){
				$vd = $frt['VIEWERSS'];
			}else{
				$vd = $frt['VIEWERS'];
			}
			
			 $objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$it1, $frt['NO'])
					->setCellValue('B'.$it1, $frt['NOTEL'])
					->setCellValue('C'.$it1, $frt['BRAND'])
					->setCellValue('D'.$it1, $frt['ADVERTISER'])
					->setCellValue('E'.$it1, $frt['AGENCY'])
					->setCellValue('F'.$it1, $frt['CHANNEL']);
					
					$date=date_create($frt['DATE']);
					
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('G'.$it1,  date_format($date,"d-m-Y"))
					->setCellValue('H'.$it1, $frt['TIME'])
					->setCellValue('I'.$it1, $frt['HOUSE_NUMBER'])
					->setCellValue('J'.$it1, $frt['PRODUCT'])
					->setCellValue('K'.$it1, $frt['DURATION'])
					->setCellValue('L'.$it1, $frt['STATUS'])
					->setCellValue('M'.$it1, $frt['RATE'])
					->setCellValue('N'.$it1, number_format($frt['RATECARD'],0,".",","))
					->setCellValue('O'.$it1, $vd);

			$it1++;
		}
		
		$ends = $it1-1;
		$sheet = $objPHPExcel->getActiveSheet();				
		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
		$sheet->getStyle('A3:O3')->getFont()->setBold(true)->setSize(11);
		$sheet->getStyle('A3:O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A4:O'.$ends)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->setTitle('Logproof');
 		$objPHPExcel->setActiveSheetIndex(0);
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		 
		//$objWriter->save('uploads/sopos.xls');	
		$objWriter->save('/data/opep/srcs/html/tmp_doc/sopos.xls');	

		$fname_arr = explode('.',$list[0]['FILENAME']);

		$array_file_s['filename'] = $fname_arr[0].'xls';
		$this->output->set_content_type('application/json')->set_output(json_encode($array_file_s));

			
	}
	
	public function process_data(){
		
		$params['iduser'] = $this->session->userdata('user_id');
		$token =  $this->Anti_si($this->input->post('data_rdn',true));
		
		$array_token = explode('|',$token);
		
		//print_r($array_token);die;
		$array_token_f = [];
		
		foreach($array_token as $array_tokens){
			
			if($array_tokens <> '' ){
				
				$array_token_f[] = $array_tokens;
				$params['token'] = $array_tokens;
				
				$list = $this->tvprogramun_model->get_epg_file($params);
				
				if(count($list) > 0 ){
					
					$list_ds = $this->tvprogramun_model->get_house_number($params);
					$whn = '';
					foreach ($list_ds[0]['HOUSE_NUMBERS'] as $HOUSE_NUMBERS){
						$whn .= "'".$HOUSE_NUMBERS."',";
					}
					
					$whndts = '';
					foreach ($list_ds[0]['DATES'] as $DATES){
						$whndts .= "'".$DATES."',";
					}
					
					$tbl = strtoupper(date_format(date_create($list[0]['START_DATE']),"Fy")); 
					$params['tbl2'] = strtoupper(date_format(date_create($list[0]['START_DATE']),"yM")); 
					$params['table_all'] = 'LOGPROOF_'.$tbl.'_ALL';
					$params['table_full'] = 'LOGPROOF_'.$tbl.'_FULL';
					$params['start_date'] = $list[0]['START_DATE'];
					$params['end_date'] = $list[0]['END_DATE'];
					$params['type'] = $list[0]['TYPE'];
					$params['house_number'] = substr($whn, 0, -1);
					$params['dates'] = substr($whndts, 0, -1);
					
					// print_r($params);die;
					// die;
					
					
					$this->tvprogramun_model->delete_data_epg($list,$params);
					$this->tvprogramun_model->process_data_epg($list,$params);
				
				}
			
			}
			
		}
		
		

		$array_file_s['msg'] = "File Processed Successfully..";
		$array_file_s['token'] = $array_token_f;
		
		
		$this->output->set_content_type('application/json')->set_output(json_encode($array_file_s));
		
		
	}
	
	 public function upload_file()
	{
		$iduser = $this->session->userdata('user_id');
		$token =  $this->Anti_si($this->input->post('data_rdn',true));
		$token_rd =  $this->Anti_si($this->input->post('arr_data_tok_int',true));
		require 'spreadsheet/vendor/autoload.php';
		
		
		$lists = $this->tvprogramun_model->get_epg_param_file();
				
		foreach($lists as $list){
			
			$channelparam[$list['CHANNEL']]['CHANNEL_FILE'] = $list['CHANNEL'];
			$channelparam[$list['CHANNEL']]['CHANNEL_NAME'] = $list['CHANNEL_NAME'];
			
		}
		
		$array_field = ['','NO','NO TEL','BRAND','ADV','AGENCY','CHANNEL','DATE','TIME','HOUSE NUMBER','PRODUCT/VERSION','DUR','STATUS','RATE','RATECARD','VIEWERS'];
		$array_field2 = ['','NO','NO TEL','BRAND','ADV','AGENCY','CHANNEL','DATE','TIME','HOUSE NUMBER','PRODUCT / VERSION','DUR','STATUS','RATE','RATECARD','VIEWERS'];
		
		$folder="uploads/";
		if (!file_exists($folder)) {
			mkdir($folder, 0777);
		}
		
		$array_token = explode('|',$token);
		$array_token_index = explode('|',$token_rd);
				
		$array_file_s = [];
		
		for($f=0; $f<count($_FILES["upload_file"]["tmp_name"]); $f++ ){
			$move = move_uploaded_file($_FILES["upload_file"]["tmp_name"][$f], $folder . $_FILES["upload_file"]["name"][$f]);
			
			$file_excel = $folder . $_FILES["upload_file"]["name"][$f];
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_excel);
			
			//echo $file_excel;die;
			
			
		//$sheetCount = $spreadsheet->getSheetCount();
		$sheetCount = 1;
		
		//echo $sheetCount;die;

		for($ish = 0; $ish < $sheetCount; $ish++){
				
				
			$spreadsheet->setActiveSheetIndex($ish);
			
			
						
			//read excel data and store it into an array
			$xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
			$array_col = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
			/* $xls_data contains this array:
			[1=>['A'=>'Domain', 'B'=>'Category', 'C'=>'Nr. Pages'], 2=>['A'=>'CoursesWeb.net', 'B'=>'Web Development', 'C'=>4000], 3=>['A'=>'MarPlo.net', 'B'=>'Courses & Games', 'C'=>15000]]
			*/
			
			$params['TITLE'] = $xls_data[1]['A'];
			//print_r($title);die;
			$error = '';
			$array_index = [];
			$header = $xls_data[3];
			$i_ket = 0;
			foreach($header as $headers){

				if(array_search($headers,$array_field,true) <> '' ){
					
					$key = array_keys($header,$headers);
					
					$array_index[$i_ket]['index'] = $key[0];
					$array_index[$i_ket]['field'] = $headers;
					$i_ket++;
				}
			}
						
			if($i_ket <> 15){
				// $error .= 'Header File Not Correct 
// '; 
				//print_r($title);die;
				$error = '';
				$array_index = [];
				$header = $xls_data[3];
				$i_ket = 0;
				foreach($header as $headers){

					if(array_search($headers,$array_field2,true) <> '' ){
						
						$key = array_keys($header,$headers);
						
						$array_index[$i_ket]['index'] = $key[0];
						$array_index[$i_ket]['field'] = $headers;
						$i_ket++;
					}
				}
				
				if($i_ket <> 15){
					
					$error .= 'Header File Not Correct 
'; 
					
				}
			
			}
			
			
			
			$params['FILE_NAME'] = $_FILES["upload_file"]["name"][$f];
			$params['FILE_SIZE'] = $_FILES["upload_file"]["size"][$f];
			$params['TOKEN'] = $array_token[$array_token_index[$f]];
			$params['USERID'] = $iduser;
			$params['UPLOADTIME'] = date('Y-m-d H:i:s');
			
			$arr_dur = ['0.00017361111111111' => '00:00:15', '0.00034722222222222' => '00:00:30', '0.00011574074074074' => '00:00:10', '0.00069444444444444' => '00:01:00' ];

			//print_r($arr_dur);
			//now it is created a html table with the excel file data
			//$html_tb ='<table border="1"><tr><th>'. implode('</th><th>', $xls_data[1]) .'</th></tr>';
			$html_tb ='';
			$channel = '';
			$start_time = '';
			$end_time = '';
			$nr = count($xls_data); //number of rows
			$insert_d = '';
			$int_rpws = 0;
			$int_arr = 0;
			$curr_adv = [];
			for($i=4; $i<=$nr; $i++){
				
				$data_row_excel = $xls_data[$i];

				if($data_row_excel['A'] <> ''){
					if(strlen($data_row_excel['G']) == 10){
						if($i == 4){
							$curr_adv[$int_arr] = $data_row_excel['D'];
						}else{
							if($curr_adv[$int_arr] <> $data_row_excel['D']){
								$int_arr++;
								$curr_adv[$int_arr] = $data_row_excel['D'];
							}
						}

						$data_param['NO'] = $data_row_excel['A'];
						$data_param['NOTEL'] = $data_row_excel['B'];
						$data_param['BRAND'] = $data_row_excel['C'];
						$data_param['ADVERTISER'] = $data_row_excel['D'];
						$data_param['AGENCY'] = $data_row_excel['E'];
						$data_param['CHANNEL'] = $data_row_excel['F'];
						
						$date_row = explode('-',$data_row_excel['G']);
						
						$data_param['DATE'] = $date_row[2].'-'.$date_row[1].'-'.$date_row[0];
						$data_param['TIME'] = $data_row_excel['H'];
						$time_row = strlen($data_row_excel['H']);
											
						if($time_row == 7){
							$data_param['TIME'] = '0'.$data_row_excel['H'];
						}

						$data_param['HOUSE_NUMBER'] = $data_row_excel['I'];
						$data_param['PRODUCT'] = $data_row_excel['J'];
						if(strlen($data_row_excel['K']) > 8 ){
							$data_param['DURATION']= date("00:00:s",(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($data_row_excel['K'])));	
						}else{
							if(strlen($data_row_excel['K']) == 8){
								$data_param['DURATION']= $data_row_excel['K'];	
							}else{
								'0'.$data_param['DURATION']= $data_row_excel['K'];	
							}
						}
						//$data_param['DURATION']= date("00:00:s",(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($data_row_excel['K'])));		
						$data_param['STATUS'] = $data_row_excel['L'];
						$data_param['RATE'] = $data_row_excel['M'];
						$data_param['VIEWERS'] = $data_row_excel['O'];
						$data_param['RATECARD'] = str_replace(',','',$data_row_excel['N']);
						$data_param['TOKEN'] = $params['TOKEN'];
						
						$insert_d .= "('".$data_param['NO']."','".$data_param['NOTEL']."','".$data_param['BRAND']."','".$data_param['ADVERTISER']."','".$data_param['AGENCY']."','".$data_param['CHANNEL']."','".$data_param['DATE']."','".$data_param['TIME']."','".$data_param['HOUSE_NUMBER']."','".$data_param['PRODUCT']."','".$data_param['DURATION']."','".$data_param['STATUS']."','".$data_param['RATE']."','".$data_param['VIEWERS']."','".$data_param['RATECARD']."','".$data_param['TOKEN']."'),";
						$int_rpws++;
					}else{
						$error .= ', Date Format Not Correct 
'; 
						break;
					}
				}
			}
						
			if($curr_adv[0] == 'TESTING CPM'){
				$params['TYPE'] = 2;
			}else{
				$params['TYPE'] = 1;
			}
			
			$insert_d = substr($insert_d, 0, -1);

			$this->tvprogramun_model->save_row_excel($insert_d);
			
			$cch = $this->tvprogramun_model->check_channel_load($params);
			
			if(count($cch) > 0){
				$ch_err = '';
				foreach($cch as $cchs){
					$ch_err .= $cchs['CHANNEL'].' ,';
				}
				
				$error .= ', Channel Code '.substr($ch_err, 0, -1).' Not Found
'; 
			}
			
			$params['ERROR'] = $error;
			$params['ROW'] = $int_rpws;
			IF($error == ''){
				$params['CHANNEL_COLOR'] = 'BLACK';
			}else{
				$params['CHANNEL_COLOR'] = 'RED';
			}
						
			$this->tvprogramun_model->save_file_upload($params);
			$array_file_s['data'][] = $params;

		}

		}
		
		if($move){
			$array_file_s['msg'] = "File uploaded successfully..";
		}else{
			$array_file_s['msg'] = "Uploading failed!";
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($array_file_s));

	}
	
 

}

