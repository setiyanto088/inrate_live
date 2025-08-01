<?php
date_default_timezone_set('Asia/Jakarta');
defined('BASEPATH') OR exit('No direct script access allowed');

class Cdr_channel_config extends JA_Controller {
 
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('tvprogramun_model');
	}

	public function Anti_sql_injection($string) {
		$string = strip_tags(trim(addslashes(htmlspecialchars(stripslashes($string)))));
		return $string;
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

	public function add_channel() {
		
		$userid = $this->session->userdata('user_id');


		$data_post['cdr'] = $this->Anti_sql_injection($this->input->post('cdr', TRUE));
		$data_post['userid'] = $userid;
		$data_post['standard'] = $this->Anti_sql_injection($this->input->post('standard', TRUE));
		$data_post['quality'] = $this->Anti_sql_injection($this->input->post('quality', TRUE));

		//print_r($data_post);die;
	
		$u_id = $this->tvprogramun_model->get_channel($data_post);
				
		$result = array('success' => true, 'message' => "");
		$cnt = 0;
		if($u_id[0]['cnt_user'] > 0){
			$result = array('success' => false, 'message' => "Channel " . $data_post['cdr'] . " sudah terdaftar, silahkan input channel yang lain");
			$cnt++;
		}

		
		if($cnt == 0){

			$this->tvprogramun_model->add_new_channel($data_post);
			$this->tvprogramun_model->add_new_channel_open($data_post);
			
			$u_idcp = $this->tvprogramun_model->get_channel_param($data_post);
			if($u_idcp[0]['cnt_user'] == 0){ 
				$this->tvprogramun_model->add_new_channel_param($data_post);
			}
			
			$u_idcpf = $this->tvprogramun_model->get_channel_param_final($data_post);
			if($u_idcpf[0]['cnt_user'] == 0){ 
				$this->tvprogramun_model->add_new_channel_param_final($data_post);
			}
			
			$u_idcpfr = $this->tvprogramun_model->get_channel_param_final_res($data_post);
			if($u_idcpfr[0]['cnt_user'] == 0){ 
				$this->tvprogramun_model->add_new_channel_param_final_res($data_post);
			}
			
			$u_idcpfev = $this->tvprogramun_model->get_channel_param_final_eval($data_post);
			if($u_idcpfev[0]['cnt_user'] == 0){ 
				$this->tvprogramun_model->add_new_channel_param_final_eval($data_post);
			}
			
			$list = $this->tvprogramun_model->get_list_channel();
			$status_tpe[0] = 'Not Active';
			$status_tpe[1] = 'Active';
			
			$html = '
				<table aria-describedby="table" id="example4" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th  scope="col" style="vertical-align:top;text-align:center" >No</th>
										<th  scope="col" style="vertical-align:top;text-align:center" >CDR Channel </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Standard Channel </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Standard Channel Quality </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Update</th>
									</tr>
								</thead>
								<tbody>';
								
								$nu = 1; 
								foreach($list as $array_data_channels){
									$html .= '<tr>
										<th  scope="col" style="vertical-align:top;text-align:center" >'.$nu.'</th>
										<th  scope="col" style="vertical-align:top;text-align:left" >'.$array_data_channels['CHANNEL'].'</th>
										<th  scope="col" style="vertical-align:top;text-align:left" >'.$array_data_channels['STANDAR_CHANNEL'].'</th>
										<th  scope="col" style="vertical-align:top;text-align:left" >'.$array_data_channels['CHANNEL_OPEN'].'</th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><button onclick="update(\''.$array_data_channels['CHANNEL'].'\',\''.$array_data_channels['STANDAR_CHANNEL'].'\',\''.$array_data_channels['CHANNEL_OPEN'].'\')" id="exportWidget" class="button_black" data-complete-text="" style="float: right;"><strong>Update</strong></button></th>
									</tr>';
								 $nu++; 
								}
								
								$html .= '</tbody></table>';
								
								$result = array('success' => true, 'message' => "", 'html' => $html);
		}
		
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
		
	}
	
	public function edit_channel() {
		
		
		if(!$this->session->userdata('user_id') || in_array("246",$array_menu) == 0) {
			
			$result = array('success' => false, 'message' => "Failed to Edit", 'html' => '');
         // redirect ('/login');
		}else{
		
		$userid = $this->session->userdata('user_id');


		$data_post['cdr'] = $this->Anti_sql_injection($this->input->post('cdr_edit', TRUE));
		$data_post['userid'] = $userid;
		$data_post['standard'] = $this->Anti_sql_injection($this->input->post('standard_edit', TRUE));
		$data_post['quality'] = $this->Anti_sql_injection($this->input->post('quality_edit', TRUE));
		$data_post['cdr_edit_data'] = $this->Anti_sql_injection($this->input->post('cdr_edit_data', TRUE));
		
		$epg_edit_data = explode("|",$data_post['cdr_edit_data']);
		
		$data_post['edit_data'] = $epg_edit_data;
		
		$u_id = $this->tvprogramun_model->get_channel_edit($data_post['cdr'],$epg_edit_data[0]);
				
		$result = array('success' => true, 'message' => "");
		$cnt = 0;
		if($u_id[0]['cnt_user'] > 0){
			$result = array('success' => false, 'message' => "Channel " . $data_post['cdr'] . " sudah terdaftar, silahkan input channel yang lain");
			$cnt++;
		}

		
		if($cnt == 0){

			$this->tvprogramun_model->edit_new_channel($data_post);
			$this->tvprogramun_model->edit_new_channel_open($data_post);
			
			$u_idcp = $this->tvprogramun_model->get_channel_param($data_post);
			if($u_idcp[0]['cnt_user'] == 0){ 
				$this->tvprogramun_model->add_new_channel_param($data_post);
			}
			
			$u_idcpf = $this->tvprogramun_model->get_channel_param_final($data_post);
			if($u_idcpf[0]['cnt_user'] == 0){ 
				$this->tvprogramun_model->add_new_channel_param_final($data_post);
			}
			
			$u_idcpfr = $this->tvprogramun_model->get_channel_param_final_res($data_post);
			if($u_idcpfr[0]['cnt_user'] == 0){ 
				$this->tvprogramun_model->add_new_channel_param_final_res($data_post);
			}
			
			$u_idcpfev = $this->tvprogramun_model->get_channel_param_final_eval($data_post);
			if($u_idcpfev[0]['cnt_user'] == 0){ 
				$this->tvprogramun_model->add_new_channel_param_final_eval($data_post);
			}
			
			$list = $this->tvprogramun_model->get_list_channel();
			$status_tpe[0] = 'Not Active';
			$status_tpe[1] = 'Active';
			
			$html = '
				<table aria-describedby="table" id="example4" class="table table-striped example" style="width: 100%">
								<thead style="color:red">
									<tr>
										<th  scope="col" style="vertical-align:top;text-align:center" >No</th>
										<th  scope="col" style="vertical-align:top;text-align:center" >CDR Channel </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Standard Channel </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Standard Channel Quality </th>
										<th  scope="col" style="vertical-align:top;text-align:center" >Update</th>
									</tr>
								</thead>
								<tbody>';
								
								$nu = 1; 
								foreach($list as $array_data_channels){
									$html .= '<tr>
										<th  scope="col" style="vertical-align:top;text-align:center" >'.$nu.'</th>
										<th  scope="col" style="vertical-align:top;text-align:left" >'.$array_data_channels['CHANNEL'].'</th>
										<th  scope="col" style="vertical-align:top;text-align:left" >'.$array_data_channels['STANDAR_CHANNEL'].'</th>
										<th  scope="col" style="vertical-align:top;text-align:left" >'.$array_data_channels['CHANNEL_OPEN'].'</th>
										<th  scope="col" style="vertical-align:top;text-align:left" ><button onclick="update(\''.$array_data_channels['CHANNEL'].'\',\''.$array_data_channels['STANDAR_CHANNEL'].'\',\''.$array_data_channels['CHANNEL_OPEN'].'\')" id="exportWidget" class="button_black" data-complete-text="" style="float: right;"><strong>Update</strong></button></th>
									</tr>';
								 $nu++; 
								}
								
								$html .= '</tbody></table>';
								
								$result = array('success' => true, 'message' => "", 'html' => $html);
		}
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
		
		
	}
	
  public function index()
	{
		$iduser = $this->session->userdata('user_id');
		$menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);

		if(!$this->session->userdata('user_id') || in_array("246",$array_menu) == 0) {
          redirect ('/login');
		}
		
		$array_data_channel = [];
		
		$list = $this->tvprogramun_model->get_list_channel();
		$list_cat = $this->tvprogramun_model->get_list_cat();
		
		$data['array_data_channel'] = $list;
		$data['array_data_cat'] = $list_cat;
		$data['status_tpe'][0] = 'Not Active';
		$data['status_tpe'][1] = 'Active';
		
		$this->template->load('maintemplate', 'cdr_channel_config/views/Tvprogramun', $data);
	}	
	
	public function process_data(){
		
		$params['iduser'] = $this->session->userdata('user_id');
		$token =  $this->Anti_si($this->input->post('data_rdn',true));
		
		$array_token = explode('|',$token);
		
		//print_r($array_token);die;
	
		
		foreach($array_token as $array_tokens){
			
			$params['token'] = $array_tokens;
			
			$list = $this->tvprogramun_model->get_epg_file($params);
			//print_r($list);die;
			
			foreach($list as $lists){
				$this->tvprogramun_model->delete_data_epg($lists,$params);
				$this->tvprogramun_model->process_data_epg($lists,$params);
			}
			
		}
		
		echo "File Processed Successfully..";
		
	}
	
	 public function upload_file()
	{
		$iduser = $this->session->userdata('user_id');
		$token =  $this->Anti_si($this->input->post('data_rdn',true));
		$token_rd =  $this->Anti_si($this->input->post('arr_data_tok_int',true));
		require 'spreadsheet/vendor/autoload.php';
		
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
						$row .= str_replace("'","",str_replace(",","",$channelparam[$xls_data[$i][$array_indexs['index']]]['CHANNEL_CDR'])).',';
					 }else{
						$row .= str_replace("'","",str_replace(",","",$xls_data[$i][$array_indexs['index']])).',';
					 }
				 }
				 $row .= $array_token[$array_token_index[$f]].',';
				 
				$row = substr($row, 0, -1);
$html_tb .= $row.'
';
			}
			
			$params['CHANNEL'] = $channel;
			$params['START_TIME'] = $start_time;
			$params['END_TIME'] = $end_time;
			$params['TOT_ROW'] = $i-2;
			
			$this->tvprogramun_model->save_file_channel($params);

			$fp = fopen($folder.'data.csv', 'w');
			fclose($fp);
			file_put_contents($folder.'data.csv', $html_tb);
			
			$myfile = fopen($folder."load_cdr_zte.sql", "w");
				//$txt = 'LOAD DATA LOCAL INFILE "C:/xampp56/htdocs/inrate_ch/uploads/data.csv" INTO TABLE EPG_RAW1_TEMP FIELDS TERMINATED BY "," LINES TERMINATED BY "\n"  
			//(CHANNEL,PROGRAM,START_TIME,END_TIME,GENRE,TOKEN)';
			$txt = 'LOAD DATA LOCAL INFILE "'.$this->loc_file().'uploads/data.csv" INTO TABLE EPG_RAW1_TEMP FIELDS TERMINATED BY "," LINES TERMINATED BY "\n"  
			(CHANNEL,PROGRAM,START_TIME,END_TIME,GENRE,TOKEN)';
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

		if($move){
			echo "File uploaded successfully..";
		}else{
			echo "Uploading failed!";
		}

	}
	
 

}

