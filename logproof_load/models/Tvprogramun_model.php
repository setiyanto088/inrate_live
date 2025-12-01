<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvprogramun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	

	
	public function list_channel() {
 		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT B.`CHANNEL_NAME_PROG` AS channel FROM  `CHANNEL_PARAM_FINAL` B WHERE CHANNEL_NAME_PROG IN ('Al Jazeera','Bloomberg','Channel News Asia','CNBC Asia','CNN International','DW TV','Euronews','France 24','SEA Today','TRT World','TVBS News','TV One','CNN Indonesia','Metro TV','Kompas TV','TVRI','Berita Satu','TVRI','iNews','IDX Channel','MNC News','CNBC Indonesia') ORDER BY CHANNEL_NAME_PROG ";
		
		$sql	= $db->select($query);
		return $sql->rows();			   
	}          
	
	public function get_profile($iduser) {  
	 
		
		$i0 =  date_format(date_create($periode),"Y-m");
 			
			$sql = "SELECT id, nama FROM hrd_profile  ";
		
		 
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
		
		$db = $this->clickhouse->db();
		$query = " SELECT * FROM FILE_UPLOAD_LOGPROOF WHERE ID_USER = '".$param['iduser']."' AND TOKEN = '".$param['token']."' AND ERROR = '' AND PROCESS_DATE IS NULL ";
		
		$sql	= $db->select($query);
		return $sql->rows();				
	}
	
		
	public function get_epg_file_t($param){
		
		$db = $this->clickhouse->db();
		$query = " SELECT * FROM FILE_UPLOAD_LOGPROOF WHERE TOKEN = '".$param."' ";
		
		$sql	= $db->select($query);
		return $sql->rows();				
	}	
		
		
	public function get_house_number($param){
		
		$db = $this->clickhouse->db();
		$query = " select arrayCompact(groupArray(HOUSE_NUMBER))  HOUSE_NUMBERS, length(HOUSE_NUMBERS) lenHN,
				arrayCompact(groupArray(DATE))  DATES, length(DATES) lenDate from(
				   select * from LOGPROOF_LOAD_FULL_P2 WHERE TOKEN = '".$param['token']."' )";
		
		$sql	= $db->select($query);
		return $sql->rows();				
	}	
	
	public function get_file_data($param,$tbl){
		
		$db = $this->clickhouse->db();
		$query = " 
			SELECT B.*,C.`VIEWERS` AS VIEWERSS FROM LOGPROOF_LOAD_FULL_P2 B
			LEFT JOIN (SELECT X.SPLIT_MINUTES AS SPLIT_MINUTES, Y.CHANNEL CHANNEL, X.VIEWERS VIEWERS FROM RATING_PER_MINUTES_".$tbl." X 
			INNER JOIN P_CHANNEL_RATECARD_USEETV_V2 Y ON X.CHANNEL=Y.CHANNEL_NAME
			WHERE PROFILE_ID = 0) C ON B.`CHANNEL` = C.`CHANNEL`
			AND CONCAT(`DATE`,' ',SUBSTRING(B.`TIME` ,1, 2),':',SUBSTRING(B.`TIME`, 4, 2),':00' ) = toString(C.`SPLIT_MINUTES`)
			WHERE  B.TOKEN = '".$param."'
			ORDER BY toInt32(NO) ASC,DATE
		";
		
		//ECHO $query;die;
		$sql	= $db->select($query);
		return $sql->rows();				
	}
	
	public function get_list_channel($date){
		
		$query = "
		SELECT GROUP_CONCAT(A.CHANNEL_ORIGIN ORDER BY A.CHANNEL_ORIGIN ASC SEPARATOR ', ') as CLS,COUNT(A.CHANNEL_ORIGIN) SD FROM (
		SELECT * FROM CHANNEL_EPG_CONFIG A
		WHERE A.`STATUS` = 1
		) A LEFT JOIN (
			SELECT CHANNEL,COUNT(*) SD, DATE_FORMAT(START_TIME,'%Y-%d-%d') AS DTS FROM (SELECT * FROM EPG_RAW1_TEST GROUP BY `CHANNEL`,`PROGRAM`,`START_TIME`) ec 
			WHERE START_TIME BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59'
			GROUP BY CHANNEL,DTS
		) B ON A.CHANNEL_CDR = B.CHANNEL 
		WHERE B.CHANNEL IS NULL OR SD < 8
		ORDER BY A.CHANNEL_ORIGIN
		";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function get_epg_param_file(){
		
		$db = $this->clickhouse->db();
		$query = "SELECT * FROM P_CHANNEL_RATECARD_USEETV_V2 ";
		
		$sql	= $db->select($query);
		return $sql->rows();				
	}
	
	public function save_file_channel($params){ 
		
		$db = $this->clickhouse->db();
		
		$sql 	= "INSERT INTO FILE_UPLOAD_LOGPROOF
		VALUES('".$params['FILE_NAME']."','".$params['CHANNEL']."','".$params['START_TIME']."',
		'".$params['END_TIME']."','".$params['UPLOADTIME']."','".$params['TOKEN']."','".$params['USERID']."','".$params['TOT_ROW']."')";
		//ECHO $sql;DIE;
       $sql	= $db->write($sql);

	}   	

	public function save_row_excel($params){ 
		
		$db = $this->clickhouse->db();
		
		$sql 	= "INSERT INTO LOGPROOF_LOAD_FULL_P2 VALUES ".$params." ";
		//ECHO $sql;DIE;
       $sql	= $db->write($sql);

	}   	
	
	public function save_file_upload($params){ 
		
		$db = $this->clickhouse->db();
		
		$sql 	= "
			INSERT INTO FILE_UPLOAD_LOGPROOF 
			SELECT '".$params['FILE_NAME']."' as FILENAME, MIN(DATE), MAX(DATE), '".$params['ERROR']."' as ERROR,'".$params['UPLOADTIME']."' as UPLOADTIME,NULL AS PROCESS_TIME, '".$params['USERID']."' as USERID,'".$params['ROW']."' as ROWSS, '".$params['TOKEN']."' as TOKEN , '".$params['TITLE']."' as TITLE, '".$params['TYPE']."' as TPE  FROM  ( SELECT * FROM  inrate.LOGPROOF_LOAD_FULL_P2	WHERE TOKEN = '".$params['TOKEN']."' ) A
		";
		//ECHO $sql;DIE;
       $sql	= $db->write($sql);

	}   	
	
	public function check_channel_load($params){
		
		$db = $this->clickhouse->db();
		$query = "	
			SELECT X.CHANNEL,Y.CHANNEL_NAME  FROM LOGPROOF_LOAD_FULL_P2 X
			LEFT JOIN P_CHANNEL_RATECARD_USEETV_V2 Y ON X.CHANNEL=Y.CHANNEL
			WHERE Y.CHANNEL_NAME = ''
			AND X.TOKEN = '".$params['TOKEN']."'
			GROUP BY X.CHANNEL,Y.CHANNEL_NAME 
			";
		
		$sql	= $db->select($query);
		return $sql->rows();				
	}
	
	
	public function list_epg_fil_his($where) {

		$db = $this->clickhouse->db();
		$query = "
			
						SELECT *,IF(TYPE = '1','MAIN','TEST') TPE FROM FILE_UPLOAD_LOGPROOF A
						".$where."
						ORDER BY A.UPLOAD_DATE DESC
		
		";
		
		
		$sql	= $db->select($query);
		return $sql->rows();	   
	}
	
	
	public function data_stat($date){
		
		
		$query = "
		SELECT COUNT(LOG_DATE) AS CNT_DATA, SUM(RATING_PERMINUTES) AS CNT_AVA, 
		IF(COUNT(LOG_DATE) = SUM(RATING_PERMINUTES),'Data Available','Data Not Available') AS AVA FROM `DAILY_JOBS_REPORT`
		WHERE LOG_DATE BETWEEN '".$date['START_DATE']."' AND '".$date['END_DATE']."'
		";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	
	public function delete_data_epg($lis,$params){ 
		
		
		$db = $this->clickhouse->db();
		
		$sql 	= "ALTER TABLE ".$params['table_all']." DELETE WHERE DATE IN (".$params['dates'].") AND HOUSE_NUMBER IN (".$params['house_number'].") AND TYPE = '".$params['type']."'  ";
		$sql	= $db->write($sql);
	   
	   
	   
		$sql2 	= "ALTER TABLE ".$params['table_full']." DELETE WHERE formatDateTime(parseDateTimeBestEffortOrNull(DATE),'%Y-%m-%d') IN (".$params['dates'].") AND HOUSE_NUMBER IN (".$params['house_number'].") AND TYPE = '".$params['type']."' ";
		$sql2	= $db->write($sql2);

	}   

	public function process_data_epg($lis,$params){ 

		$db = $this->clickhouse->db();
		
		$sql 	= " INSERT INTO ".$params['table_all']." 
					SELECT NO,CHANNEL,DATE,TIME,HOUSE_NUMBER, PRODUCT, DURATION, STATUS, RATE,'".$params['type']."' AS TPE  FROM LOGPROOF_LOAD_FULL_P2
					WHERE TOKEN = '".$params['token']."'
		";
		
		$sql	= $db->write($sql);
		
		$sql2 	= "
			INSERT INTO ".$params['table_full']." 
			SELECT NO, NOTEL ,BRAND, ADVERTISER, AGENCY, CHANNEL,formatDateTime(toDate(DATE),'%d/%m/%Y') DATES,TIME,HOUSE_NUMBER, PRODUCT, DURATION, STATUS, RATE, 
			if(VIEWERS = '',toString(C.VIEWERS),VIEWERS ) as VW, if(RATECARD = '','0',replaceAll(RATECARD,' ','')) rts, 
				'".$params['type']."' AS TPE  FROM LOGPROOF_LOAD_FULL_P2 B
			LEFT JOIN (SELECT X.SPLIT_MINUTES AS SPLIT_MINUTES, Y.CHANNEL CHANNEL, X.VIEWERS VIEWERS FROM RATING_PER_MINUTES_".$params['tbl2']." X 
			INNER JOIN P_CHANNEL_RATECARD_USEETV_V2 Y ON X.CHANNEL=Y.CHANNEL_NAME
			WHERE PROFILE_ID = 0) C ON B.`CHANNEL` = C.`CHANNEL`
			AND CONCAT(`DATE`,' ',SUBSTRING(B.`TIME` ,1, 2),':',SUBSTRING(B.`TIME`, 4, 2),':00' ) = toString(C.`SPLIT_MINUTES`)
			WHERE  B.TOKEN = '".$params['token']."'
			ORDER BY toInt32(NO) ASC,DATE;	
		";
		$sql2	= $db->write($sql2);	
		
		$sql3 	= " ALTER TABLE FILE_UPLOAD_LOGPROOF UPDATE PROCESS_DATE = '".date('Y-m-d H:i:s')."'
					WHERE TOKEN = '".$params['token']."'
		";
		$sql3	= $db->write($sql3);
		
		
		$query = " INSERT INTO JOBS_QUEUE VALUES('".$params['start_date']."',' php /var/www/oth_script/daily_postbuy_logproof.php ".$params['token']."> /var/www/jobs/daily_postbuy_logproof_".$params['token']." &','".$params['token']."',null,'2','".date('Y-m-d H:i:s')."','4',null,null,'2','') " ; 
		
		$sql	= $this->db->query($query);
		$this->db->close();	

	}   	
	

	
}	
