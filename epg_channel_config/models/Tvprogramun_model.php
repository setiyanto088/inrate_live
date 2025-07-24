<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvprogramun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	

	public function get_channel($username){
		
		$sql 	= 'select count(*) cnt_user from CHANNEL_EPG_CONFIG 
		where CHANNEL = "'.$username.'" ';

		$query_all 	=  $this->db->query($sql);

		$result = $query_all->result_array();
		
		$this->db->close();
		$this->db->initialize();
		
		return $result;
		
	}
	
	public function get_channel_click($channel){
		
		$db = $this->clickhouse->db();
		$query = "
			SELECT count(*) cnt_user  FROM CDR_EPG_CHANNEL A
 			WHERE A.CHANNEL_CDR = '".$channel['cdr']."' AND A.CHANNEL_EPG = '".$channel['epg']."'
		";
		
		$result = $db->select($query);
		return $result->rows();				
		
	}
	
	public function add_cdr_param($data){
		$db = $this->clickhouse->db();
		
		$query = " ALTER TABLE CDR_EPG_PARAM DELETE WHERE CHANNEL_CDR = '".$data['cdr']."' AND CHANNEL_EPG = '".$data['epg']."' ";
		$sql	= $db->write($query);
		
		
		$query = "INSERT INTO CDR_EPG_PARAM VALUES ('".$data['cdr']."','".$data['epg']."','".$data['status_epg']."') ";
		$sql	= $db->write($query);
	}
	
	public function get_channel_edit($username,$channelcurr){
		
		$sql 	= 'select count(*) cnt_user from CHANNEL_EPG_CONFIG 
		where CHANNEL = "'.$username.'" AND CHANNEL <> "'.$channelcurr.'" ';

		$query_all 	=  $this->db->query($sql);

		$result = $query_all->result_array();
		
		$this->db->close();
		$this->db->initialize();
		
		return $result;
		
	}
	
	public function add_new_channel($data)
	{

		$datas = array(
			'CHANNEL' => $data['epg'],
			'STATUS' => $data['status_epg'],
			'NOTE' => '',
			'CHANNEL_ORIGIN' => $data['origin'],
			'CHANNEL_CDR' => $data['cdr']
		);


		$this->db->insert('CHANNEL_EPG_CONFIG', $datas);


		$this->db->close();
		$this->db->initialize();


		return $arr_result;
	}	
	
	public function edit_new_channel($data){
				
			$sql 	= 'UPDATE CHANNEL_EPG_CONFIG SET `CHANNEL` = ?, STATUS = ?, CHANNEL_ORIGIN = ?, CHANNEL_CDR = ? WHERE CHANNEL = ? AND STATUS = ? AND CHANNEL_ORIGIN = ? AND CHANNEL_CDR = ? ';
			$sca = $this->db->query($sql,array(
                $data['epg'],
                $data['status_epg'],
				$data['origin'],
				$data['cdr'],
				$data['edit_data'][1],
                $data['edit_data'][3],
				$data['edit_data'][0],
				$data['edit_data'][2]
			));
	}
	
	public function edit_new_mr_kat($data){
			$sql 	= 'UPDATE MR_KAT_CHANNEL SET `CHANNEL` = ?, KATEGORI = ?, CHANNEL_PROG = ? WHERE CHANNEL = ? AND KATEGORI = ? AND CHANNEL_PROG = ?  ';
			$sca = $this->db->query($sql,array(
                $data['epg'],
                $data['cat_epg'],
				$data['origin'],
				$data['edit_data'][1],
                $data['edit_data'][4],
				$data['edit_data'][0]
			));
	}
	
	public function add_new_mr_kat($data)
	{
		// $sql 	= 'insert into t_eksternal  (kode_eksternal,eksternal_address,name_eksternal,phone_1,fax,bank1,rek1,bank2,rek2,bank3,rek3,type_eksternal) values (?,?,?,?,?,?,?,?,?,?,?,?)';

		$datas = array(
			'CHANNEL' => $data['epg'],
			'KATEGORI' => $data['cat_epg'],
			'CHANNEL_PROG' => $data['origin']
		);


		$this->db->insert('MR_KAT_CHANNEL', $datas);


		$this->db->close();
		$this->db->initialize();


		return $arr_result;
	}	
	
	public function list_channel() {
 		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT B.`CHANNEL_NAME_PROG` AS channel FROM  `CHANNEL_PARAM_FINAL` B WHERE CHANNEL_NAME_PROG IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia') ORDER BY CHANNEL_NAME_PROG ";
		
		$sql	= $db->select($query);
		return $sql->rows();			   
	}          
	
	public function get_profile($iduser,$idrole,$periode) {  
	 
		
		$i0 =  date_format(date_create($periode),"Y-m");
 			
			$sql = "SELECT A.* FROM ( 
					SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub2 a WHERE (STATUS = 1 OR STATUS = 3)  
					AND user_id_profil IN (".$iduser.",0)  ORDER BY `name`
					) A JOIN
					`M_MONTH_PROFILE_PTV`  B ON A.id = B.`PROFILE_ID`
					WHERE B.`PERIODE` = '".$i0."' AND B.`STATUS_PROCESS` = 1
					";
		
		 
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}
	
	public function get_tahun(){
		
		$query = "SELECT DISTINCT(PERIODE_STR)  TANGGAL FROM T_PERIODE ORDER BY PERIODE DESC";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}	
	
	public function get_epg_file($param){
		
		$query = " SELECT * FROM FILE_UPLOAD_EPG WHERE ID_USER = '".$param['iduser']."' AND TOKEN = '".$param['token']."' ";
		//echo $query;die;
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_list_channel(){
		
		$query = "
		SELECT A.*,KATEGORI FROM `CHANNEL_EPG_CONFIG` A LEFT JOIN 
		 MR_KAT_CHANNEL B ON A.CHANNEL_CDR = B.`CHANNEL`
		 ORDER BY A.CHANNEL
		";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}	
	
	public function get_list_cat(){
		
		$query = "
		 
		 SELECT KATEGORI from MR_KAT_CHANNEL
		 group by `KATEGORI`
		 order by KATEGORI
		";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_epg_param_file(){
		
		$query = "
		SELECT * FROM `CHANNEL_EPG_CONFIG`
		";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function save_file_channel($params){ 

		$sql 	= "INSERT INTO FILE_UPLOAD_EPG(`FILENAME`,`CHANNEL`,`START_TIME`,END_TIME,UPLOAD_DATE,TOKEN,ID_USER,TOTAL_ROW) 
		VALUES('".$params['FILE_NAME']."','".$params['CHANNEL']."','".$params['START_TIME']."',
		'".$params['END_TIME']."','".$params['UPLOADTIME']."','".$params['TOKEN']."','".$params['USERID']."','".$params['TOT_ROW']."')";
		//ECHO $sql;DIE;
        $this->db->query($sql);

	}   	

	public function delete_data_epg($lis,$params){ 

		$sql 	= "
		DELETE FROM EPG_RAW1_TEST 
		WHERE CHANNEL = '".$lis['CHANNEL']."'
		AND START_TIME BETWEEN '".$lis['START_TIME']."' AND '".$lis['END_TIME']."'
		";
		//ECHO $sql;DIE;
        $this->db->query($sql);

	}   

	public function process_data_epg($lis,$params){ 

		$sql 	= "
		INSERT INTO EPG_RAW1_TEST 
		SELECT CHANNEL,PROGRAM,START_TIME,END_TIME,GENRE FROM EPG_RAW1_TEMP
		WHERE CHANNEL = '".$lis['CHANNEL']."'
		AND START_TIME BETWEEN '".$lis['START_TIME']."' AND '".$lis['END_TIME']."'
		AND TOKEN = '".$params['token']."'
		";
		//ECHO $sql;DIE;
        $this->db->query($sql);

	}   	
	
	
	
}	
