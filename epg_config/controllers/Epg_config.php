<?php
date_default_timezone_set('Asia/Jakarta');
defined('BASEPATH') OR exit('No direct script access allowed');

class epg_config extends JA_Controller {
 
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
		$iduser = $this->session->userdata('user_id');
		$menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);
		
		if(!$this->session->userdata('user_id') || in_array("237",$array_menu) == 0) {
          redirect ('/login');die;
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

		
		$this->template->load('maintemplate', 'epg_config/views/Tvprogramun', $data);
	}	
	
	public function process_data(){
		
		$params['iduser'] = $this->session->userdata('user_id');
		$token =  $this->Anti_si($this->input->post('data_rdn',true));
		
		$array_token = explode('|',$token);
		
		if($params['iduser'] == ''){
			$array_file_s['msg'] = "User Session End, Please Login Again ";
			$array_file_s['sts'] = 2;
			$this->output->set_content_type('application/json')->set_output(json_encode($array_file_s));
			
			
		}else{
		
			
			foreach($array_token as $array_tokens){
				
				$params['token'] = $array_tokens;
				
				$list = $this->tvprogramun_model->get_epg_file($params);
				//print_r($list);die;
				
				foreach($list as $lists){
					$this->tvprogramun_model->delete_data_epg($lists,$params);
					$this->tvprogramun_model->process_data_epg($lists,$params);
				}
				
			}
			
			$array_file_s['msg'] = "File Processed Successfully.. ";
			$array_file_s['sts'] = 1;
			$this->output->set_content_type('application/json')->set_output(json_encode($array_file_s));
		
		}
		
	}
	
	 public function upload_file()
	{
		$iduser = $this->session->userdata('user_id');
		$token =  $this->Anti_si($this->input->post('data_rdn',true));
		$token_rd =  $this->Anti_si($this->input->post('arr_data_tok_int',true));
		require 'spreadsheet/vendor/autoload.php';
		
		
		
		if($iduser == ''){
			$array_file_s['msg'] = "User Session End, Please Login Again ";
			$array_file_s['sts'] = 2;
			$this->output->set_content_type('application/json')->set_output(json_encode($array_file_s));
			
			
		}else{
		//echo $token.' - '.$token_rd;die;
		
		$lists = $this->tvprogramun_model->get_epg_param_file();
				
		foreach($lists as $list){
			
			$channelparam[$list['CHANNEL']]['CHANNEL_EPG'] = $list['CHANNEL'];
			$channelparam[$list['CHANNEL']]['CHANNEL_ORIGIN'] = $list['CHANNEL_ORIGIN'];
			$channelparam[$list['CHANNEL']]['CHANNEL_CDR'] = $list['CHANNEL_CDR'];
			
		}
		
		$array_field = ['','CHANNEL','SCHEDULE_NAME','START_TIME','END_TIME','GENRE'];
		
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
			
			
		$sheetCount = $spreadsheet->getSheetCount();
		
		//echo $sheetCount;die;

		for($ish = 0; $ish < $sheetCount; $ish++){
				
				
			$spreadsheet->setActiveSheetIndex($ish);
			
						
			//read excel data and store it into an array
			$xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
			/* $xls_data contains this array:
			[1=>['A'=>'Domain', 'B'=>'Category', 'C'=>'Nr. Pages'], 2=>['A'=>'CoursesWeb.net', 'B'=>'Web Development', 'C'=>4000], 3=>['A'=>'MarPlo.net', 'B'=>'Courses & Games', 'C'=>15000]]
			*/
			
			//print_r($xls_data);die;
			
			$array_index = [];
			$header = $xls_data[1];
			$i_ket = 0;
			foreach($header as $headers){

				if(array_search($headers,$array_field,true) <> '' ){
					
					$key = array_keys($header,$headers);
					
					$array_index[$i_ket]['index'] = $key[0];
					$array_index[$i_ket]['field'] = $headers;
					$i_ket++;
				}
			}
			
			//print_r($array_index);die;
			
			$params['FILE_NAME'] = $_FILES["upload_file"]["name"][$f];
			$params['FILE_SIZE'] = $_FILES["upload_file"]["size"][$f];
			$params['TOKEN'] = $array_token[$array_token_index[$f]];
			$params['USERID'] = $iduser;
			$params['UPLOADTIME'] = date('Y-m-d H:i:s');
			

			
			//now it is created a html table with the excel file data
			//$html_tb ='<table border="1"><tr><th>'. implode('</th><th>', $xls_data[1]) .'</th></tr>';
			$html_tb ='';
			$channel = '';
			$start_time = '';
			$end_time = '';
			$nr = count($xls_data); //number of rows
			for($i=2; $i<=$nr; $i++){
				$row = '';
				 foreach($array_index as $array_indexs){
					 
					 if($i == 2){
					 
						 if($array_indexs['field'] == 'CHANNEL'){
							$channel = $channelparam[$xls_data[$i][$array_indexs['index']]]['CHANNEL_CDR'];
						 }
						 
						 if($array_indexs['field'] == 'START_TIME'){
							$start_time = $xls_data[$i][$array_indexs['index']];
						 }
					 
					 }
					 
						if($array_indexs['field'] == 'START_TIME'){
							$end_time = $xls_data[$i][$array_indexs['index']];
						 }
					 
					 if($array_indexs['field'] == 'CHANNEL'){
						$row .= preg_replace('~[\r\n]+~', '', str_replace("'","",str_replace(",","",$channelparam[$xls_data[$i][$array_indexs['index']]]['CHANNEL_CDR']))).'|';
					 }else{
						$row .= preg_replace('~[\r\n]+~', '', str_replace("'","",str_replace(",","",$xls_data[$i][$array_indexs['index']]))).'|';
					 }
				 }
				 $row .= $array_token[$array_token_index[$f]].'|';
				 
				$row = substr($row, 0, -1);
$html_tb .= $row.'
';
			}
			
			//echo $html_tb;die;
						
			$params['CHANNEL'] = $channel;
			$params['START_TIME'] = $start_time;
			$params['END_TIME'] = $end_time;
			$params['TOT_ROW'] = $i-2;
			$params['CHANNEL_STATUS'] = '';
			$params['CHANNEL_COLOR'] = 'BLACK';
			if($params['CHANNEL'] == ''){
				$params['CHANNEL_STATUS'] = ' - EPG Channel Not Found or Format File Not Correct';
				$params['CHANNEL_COLOR'] = 'RED';
			}
			
			$array_file_s['data'][] = $params;
			
			$this->tvprogramun_model->save_file_channel($params);

			$fp = fopen($folder.'data.csv', 'w');
			fclose($fp);
			file_put_contents($folder.'data.csv', $html_tb);
			
			$myfile = fopen($folder."load_cdr_zte.sql", "w");
				//$txt = 'LOAD DATA LOCAL INFILE "C:/xampp56/htdocs/inrate_ch/uploads/data.csv" INTO TABLE EPG_RAW1_TEMP FIELDS TERMINATED BY "," LINES TERMINATED BY "\n"  
			//(CHANNEL,PROGRAM,START_TIME,END_TIME,GENRE,TOKEN)';
		$txt = 'LOAD DATA LOCAL INFILE "'.$this->loc_file().'uploads/data.csv" INTO TABLE EPG_RAW1_TEMP FIELDS TERMINATED BY "|" LINES TERMINATED BY "\n"  
			(CHANNEL,PROGRAM,START_TIME,END_TIME,GENRE,TOKEN)';
			
			//echo $txt;die;
				fwrite($myfile, $txt);
				fclose($myfile);
			
				file_put_contents($file, $text_cont);
							
				fclose($my_file);
				
				//$command = 'C:\xampp56\mysql\bin\mysql -h dev-datamart.u.1elf.net -u inrate -pa2cd-0c6d851fc9de inrate < C:/xampp56/htdocs/inrate_ch/uploads/load_cdr_zte.sql 2>&1 ';
				// mariadb -h dev-datamart.u.1elf.net -u inrate -pa2cd-0c6d851fc9de inrate < /var/www/html/epg/uploads/load_cdr_zte.sql 2>&1 
				$command = 'mysql -h dev-datamart.u.1elf.net -u inrate -pa2cd-0c6d851fc9de inrate < '.$this->loc_file().'uploads/load_cdr_zte.sql 2>&1 ';
				$pid = shell_exec($command);
			
		
		}

		}
		
		$array_file_s['sts'] = 1;
		if($move){
			$array_file_s['msg'] = "File uploaded successfully..";
		}else{
			$array_file_s['msg'] = "Uploading failed!";
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($array_file_s));
		}
	}
	
 

}

