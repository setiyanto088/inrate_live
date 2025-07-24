<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tvprogramun_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ClickHouse');
		
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
	
	 	public function list_spot_by_date_all2($where,$periode) {
		 

$db = $this->clickhouse->db();
		$query = "SELECT DATE AS `date`, VIEWERS AS spot FROM M_SUM_TV_DASH_DATE_PTV
				  WHERE 1=1 AND TANGGAL='".$periode."' ".$where." 
				  ".$where." 
				  ORDER BY DATE";			
		$result = $db->select($query);
		return $result->rows();	   	   
		
	}	 	
	
	public function get_periodes($where,$periode) {
		 

$db = $this->clickhouse->db();
		$query = "	SELECT formatDateTime(toDate(TIME_PERIODE),'%Y-%m') DTY  FROM 
				( SELECT * FROM SERVER_PERF_SUMMARY  
				WHERE PERIODE = 'DAILY' ) A
				GROUP BY DTY
				ORDER BY DTY
				
				";			
		$result = $db->select($query);
		return $result->rows();	   	   
		
	}
	
	public function get_curr_data($periode) {
		
		$data_file = date('Y-m-d');
		$n_period = date_format(date_create($periode),"Y-m");

$db = $this->clickhouse->db();
		$query = "     
					
					 select A.CPU_USAGE AS CPU_USAGE,A.MEM_ACTIVE AS MEM_ACTIVE, A.STORE_AVAIL AS STORE_AVAIL, A.STORE_SIZE AS STORE_SIZE, A.MEM_TOTAL AS MEM_TOTAL,
					 left(A.STORE_USE_P, -1) STORE_PER, B.PERIODE,MAX_MEM_ACTIVE,AVG_MEM_ACTIVE, MAX_CPU_USAGE,AVG_CPU_USAGE, AVG_MAX_CPU, AVG_MAX_MEM from (
					    SELECT * FROM inrate.SERVER_PERF A WHERE SERVER_NODE <> 'Sub Main Server'
					    ORDER BY DATETIME DESC,SERVER_NODE
					    LIMIT 2
				    ) A join (
				   		SELECT * FROM inrate.SERVER_PERF_SUMMARY A WHERE TIME_PERIODE IN ('".$data_file."','".$periode."')  
				    ) B on A.SERVER_NODE = B.SERVER_NODE
				    LEFT JOIN (
				    	 SELECT SERVER_NODE, AVG(MAX_CPU_USAGE) AS AVG_MAX_CPU, AVG(MAX_MEM_ACTIVE) AS AVG_MAX_MEM FROM SERVER_PERF_SUMMARY 
				    	 WHERE SERVER_NODE <> 'Sub Main Server' AND PERIODE = 'DAILY' AND TIME_PERIODE LIKE '".$n_period."%' 
				    	 GROUP BY SERVER_NODE
				    ) C on A.SERVER_NODE = C.SERVER_NODE
					 ORDER BY A.SERVER_NODE,B.PERIODE
					 
					 ";			
					 
					 
		$result = $db->select($query);
		return $result->rows();	   	   
		
	}
	
}	
