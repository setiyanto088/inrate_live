<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvprogramun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ClickHouse');
	}
	
	public function get_channel($data){
		
		$db = $this->clickhouse->db();
		$query = "
			SELECT count(*) cnt_user  FROM MASTER_P_CHANNEL A
			LEFT JOIN MASTER_P_CHANNEL_OPEN B ON A.CHANNEL = B.CHANNEL
			WHERE A.CHANNEL = '".$data['cdr']."' AND A.STANDAR_CHANNEL = '".$data['standard']."' 
			AND B.CHANNEL_OPEN = '".$data['quality']."'
		";
		 
	 

		$result = $db->select($query);
		return $result->rows();				
		
	}
	
	public function get_channel_edit($channel, $channelcurr){
		
		$db = $this->clickhouse->db();
		$query = "
			SELECT count(*) cnt_user  FROM MASTER_P_CHANNEL A
			LEFT JOIN MASTER_P_CHANNEL_OPEN B ON A.CHANNEL = B.CHANNEL
			WHERE A.CHANNEL = '".$channel."' AND A.CHANNEL <> '".$channelcurr."'
		";
		
		$result = $db->select($query);
		return $result->rows();				
		
	}
	
	public function get_channel_param($data){
		
		$db = $this->clickhouse->db();
		$query = "
			SELECT count(*) cnt_user  FROM CHANNEL_PARAM A
			WHERE A.CHANNEL_NAME = '".$data['standard']."' 
		";
		
		$result = $db->select($query);
		return $result->rows();				
		
	}
	
	public function get_channel_param_final($data){
		
		$db = $this->clickhouse->db();
		$query = "
			SELECT count(*) cnt_user  FROM CHANNEL_PARAM_FINAL A
			WHERE A.CHANNEL_NAME = '".$data['standard']."' 
		";
		
		$result = $db->select($query);
		return $result->rows();				
		
	}
	
	public function add_new_channel_param_final_res($data){
		$db = $this->clickhouse->db();
		
		$query = "INSERT INTO CHANNEL_PARAM_FINAL_RES VALUES ('".$data['standard']."','',1,'','','','','','','','','',1,0) ";
		$sql	= $db->write($query);
	}
	
	public function get_channel_param_final_res($data){
		
		$db = $this->clickhouse->db();
		$query = "
			SELECT count(*) cnt_user  FROM CHANNEL_PARAM_FINAL_RES A
			WHERE A.CHANNEL_NAME = '".$data['standard']."' 
		";
		
		$result = $db->select($query);
		return $result->rows();				
		
	}
	
		public function add_new_channel_param_final_eval($data){
		$db = $this->clickhouse->db();
		
		$query = "INSERT INTO CHANNEL_PARAM_FINAL_EVAL VALUES ('".$data['standard']."','',1,'','','','','','','','','',1,0) ";
		$sql	= $db->write($query);
	}
	
	public function get_channel_param_final_eval($data){
		
		$db = $this->clickhouse->db();
		$query = "
			SELECT count(*) cnt_user  FROM CHANNEL_PARAM_FINAL_EVAL A
			WHERE A.CHANNEL_NAME = '".$data['standard']."' 
		";
		
		$result = $db->select($query);
		return $result->rows();				
		
	}
	
	public function add_new_channel_param_final($data){
		$db = $this->clickhouse->db();
		
		$query = "INSERT INTO CHANNEL_PARAM_FINAL VALUES ('".$data['standard']."','',1,'','','','','','','','','',1,0) ";
		$sql	= $db->write($query);
	}
	
	public function add_new_channel_param($data){
		$db = $this->clickhouse->db();
		
		$query = "INSERT INTO CHANNEL_PARAM VALUES ('".$data['standard']."','".$data['standard']."',1,'','','',0,'','','','','','',0) ";
		$sql	= $db->write($query);
	}
	
	public function edit_new_channel($data){
		$db = $this->clickhouse->db();
		
		$query = " ALTER TABLE MASTER_P_CHANNEL DELETE WHERE CHANNEL = '".$data['edit_data'][0]."' AND STANDAR_CHANNEL = '".$data['edit_data'][1]."' ";
		$sql	= $db->write($query);
		
		
		$query = "INSERT INTO MASTER_P_CHANNEL VALUES ('".$data['cdr']."','".$data['standard']."') ";
		$sql	= $db->write($query);
	}
	
	public function edit_new_channel_open($data){
		$db = $this->clickhouse->db();
		
		$query = " ALTER TABLE MASTER_P_CHANNEL_OPEN DELETE WHERE CHANNEL = '".$data['edit_data'][0]."' AND STANDAR_CHANNEL = '".$data['edit_data'][1]."' AND CHANNEL_OPEN = '".$data['edit_data'][2]."' ";
		$sql	= $db->write($query);
		
		
		$query = "INSERT INTO MASTER_P_CHANNEL_OPEN VALUES ('".$data['cdr']."','".$data['standard']."','".$data['quality']."') ";
		$sql	= $db->write($query);
	}
	
	public function list_channel() {
 		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT B.`CHANNEL_NAME_PROG` AS channel FROM  `CHANNEL_PARAM_FINAL` B WHERE CHANNEL_NAME_PROG IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia') ORDER BY CHANNEL_NAME_PROG ";
		
		$sql	= $db->select($query);
		return $sql->rows();			   
	}          
	
	
	public function add_new_channel($data)
	{
		$db = $this->clickhouse->db();
		$query = "INSERT INTO MASTER_P_CHANNEL VALUES ('".$data['cdr']."','".$data['standard']."') ";
		$sql	= $db->write($query);
		

	}	
	
	public function add_new_channel_open($data)
	{
		$db = $this->clickhouse->db();
		$query = "INSERT INTO MASTER_P_CHANNEL_OPEN VALUES ('".$data['cdr']."','".$data['standard']."','".$data['quality']."') ";
		$sql	= $db->write($query);

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

		$db = $this->clickhouse->db();
		$query = "
			SELECT A.*,B.CHANNEL_OPEN  FROM MASTER_P_CHANNEL A
			LEFT JOIN MASTER_P_CHANNEL_OPEN B ON A.CHANNEL = B.CHANNEL
			ORDER BY CHANNEL
		";
		 
	 

		$result = $db->select($query);
		return $result->rows();						
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
