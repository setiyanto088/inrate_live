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
	
	public function get_bulan(){
		
		$query = "SELECT DISTINCT SUBSTR(TANGGAL,6) bulan FROM M_SUM_TV_DASH_ACTIVE_PTV ORDER BY STR_TO_DATE(TANGGAL, '%Y-%M')";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	
	public function channel_list($periode){
		
		$db = $this->clickhouse->db();
		$query = "SELECT DISTINCT `CHANNEL` FROM M_SUM_TV_DASH_CHAN_PTV WHERE TANGGAL='".$periode."' AND CHANNEL <> '' ORDER BY UPPER(CHANNEL) ";
		 
	 	
		$result = $db->select($query);
		return $result->rows();			
	}
	
	public function get_sel_week($first_day,$this_day) {  

			
			$sql = "
						
						SELECT * FROM (
							SELECT *,CONCAT(DATE_FORMAT(START_DATE,'%d%b'),' - ',DATE_FORMAT(EMD_DATE,'%d%b')) AS PER FROM `WEEK_PARAM_DATE`
							WHERE `YEAR` ='".$first_day."'
							AND DATE_FORMAT(START_DATE,'%Y-%m') = '".$first_day."-".$this_day."'
							ORDER BY START_DATE DESC
							#LIMIT 4
						) A ORDER BY START_DATE ASC
						
						
					";
					
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}	
	
		public function get_sel_week_month($first_day,$this_day) {  

			
			$sql = "
					SELECT *,CONCAT(DATE_FORMAT(START_DATE,'%d%b'),' - ',DATE_FORMAT(EMD_DATE,'%d%b')) AS PER FROM `WEEK_PARAM_DATE`
							WHERE DATE_FORMAT(START_DATE,'%Y-%m') = '".$first_day."-".$this_day."'
							AND (START_DATE < '".date("Y-m-d")."'
							OR EMD_DATE <= '".date("Y-m-d")."' )
							AND `YEAR` = '".$first_day."' 
							ORDER BY START_DATE ASC
					";
//echo $sql;die;

		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}	

 	public function list_spot_by_program_all_bar($field,$where,$periode,$type,$profile,$check,$tipe_area) {
		$db = $this->clickhouse->db();
		if($check == "True"){
				$wh_chn = '';
		}else{
					$wh_chn = " AND CHANNEL NOT IN (SELECT `CHANNEL_NAME_PROG` FROM `CHANNEL_PARAM_FINAL` A
							JOIN `CHANNEL_PARAM` B ON A.`CHANNEL_NAME` = B.`CHANNEL_NAME`
							WHERE B.`FLAG_TV` = 0) " ;
		}
		
					$query = "
					select * from inrate.M_SUM_TV_DASH_MINIPACK_AREA_PTV
					where PERIODE =  ".$this->db->escape($periode)."
					AND AREA = '".$tipe_area."'
					AND REGIONAL = 'ALL'
					AND BRANCH = 'ALL'
					AND TYPE_PERIODE = 'MONTHLY'
					AND TYPE_DATA = 'LIVE'
					AND TYPE_VALUE = '".$type."'
					AND MINIPACK <> 'BASIC'
					".$wh_chn." 
					".$where."
					ORDER BY VIEWERS DESC
					 "; 
	
	 
		$result = $db->select($query);
			return $result->rows();	   
		
	}
	
	public function get_curr_month($tgl) {  
			
			$first_date = strtotime(date("Y-m-d"));
			$today = strtotime('-1 day', $first_date);
			$today = date('Y-m-d', $today);

					$sql = "
						SELECT 
						DATE_FORMAT(START_DATE,'%b-%y') AS PERIODE,
						DATE_FORMAT(START_DATE,'%Y-%M') AS PERIODE_FULL FROM WEEK_PARAM_DATE
						WHERE `YEAR` = '".$tgl."'
						AND START_DATE < '".date("Y-m-d")."'
						AND START_DATE > '".date($tgl."-01-01")."'
						GROUP BY DATE_FORMAT(START_DATE,'%b-%y')
						ORDER BY START_DATE
					";
					

		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}	
	
	public function get_sel_month_all($first_day,$this_day) {  



			
			$sql = "
						SELECT 
						DATE_FORMAT(START_DATE,'%b-%y') AS PERIODE,
						DATE_FORMAT(START_DATE,'%Y-%M') AS PERIODE_FULL FROM WEEK_PARAM_DATE
						WHERE DATE_FORMAT(START_DATE,'%Y') = '".$first_day."'
						AND START_DATE <= '".date("Y-m-d")."'
						GROUP BY DATE_FORMAT(START_DATE,'%b-%y')
						ORDER BY START_DATE
					";
		
		$out		= array();
		$query		= $this->db->query($sql);
		$result = $query->result_array();
			
		return $result;
	}
	
	
	public function list_data_month($params = array(),$where) {
			
				
			$sql = "
			SELECT * FROM M_SUM_TV_DASH_MINIPACK_AREA_PTV
			WHERE TYPE_PERIODE IN ('MONTHLY','YEARLY') 
			AND PERIODE LIKE '%".$params['start_date']."%'
			AND TYPE_VALUE = '".$params['type']."'
			AND AREA = '".$params['tipe_area']."'
			AND REGIONAL = 'ALL'
			AND BRANCH = 'ALL'
			AND TYPE_DATA = '".$params['tipe_filter']."'
			AND MINIPACK <> 'BASIC'
			ORDER BY PERIODE,VIEWERS DESC
			";

	
		$db = $this->clickhouse->db();
		$out		= array();
		$resultS = $db->select($sql);
		$result = $resultS->rows();	  
    
		$total_filtered['ROWS'] = count($result);
		$total 			= count($result);
		
					    
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
    
		return $return;
  
	}
	
	public function list_data_month_ch($params = array(),$where) {
			
				
			$sql = "
			SELECT * FROM M_SUM_TV_DASH_CHANNEL_MINIPACK_AREA_PTV
			WHERE TYPE_PERIODE IN ('MONTHLY','YEARLY') 
			AND PERIODE LIKE '%".$params['start_date']."%'
			AND TYPE_VALUE = '".$params['type']."'
			AND AREA = '".$params['tipe_area']."'
			AND REGIONAL = 'ALL'
			AND BRANCH = 'ALL'
			AND TYPE_DATA = '".$params['tipe_filter']."'
			AND MINIPACK <> 'BASIC'
			ORDER BY PERIODE,VIEWERS DESC
			";

		$db = $this->clickhouse->db();
		$out		= array();
		$resultS = $db->select($sql);
		$result = $resultS->rows();	  
    
		$total_filtered['ROWS'] = count($result);
		$total 			= count($result);
		
					    
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
    
		return $return;
  
	}
	
	public function list_data_weekly($params = array(),$where) {
			
				
			$sql = "
			SELECT * FROM M_SUM_TV_DASH_MINIPACK_AREA_PTV
			WHERE TYPE_PERIODE IN ('WEEKLY') 
			AND PERIODE LIKE '%".$params['start_date']."%'
			AND TYPE_VALUE = '".$params['type']."'
			AND AREA = '".$params['tipe_area']."'
			AND REGIONAL = 'ALL'
			AND BRANCH = 'ALL'
			AND TYPE_DATA = '".$params['tipe_filter']."'
			AND MINIPACK <> 'BASIC'
			ORDER BY PERIODE,VIEWERS DESC
			";

	
		$db = $this->clickhouse->db();
		$out		= array();
		$resultS = $db->select($sql);
		$result = $resultS->rows();	  
    
		$total_filtered['ROWS'] = count($result);
		$total 			= count($result);
		
					    
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
    
		return $return;
  
	}
	
	public function list_data_weekly_ch($params = array(),$where) {
			
				
			$sql = "
			SELECT * FROM M_SUM_TV_DASH_CHANNEL_MINIPACK_AREA_PTV
			WHERE TYPE_PERIODE IN ('WEEKLY') 
			AND PERIODE LIKE '%".$params['start_date']."%'
			AND TYPE_VALUE = '".$params['type']."'
			AND AREA = '".$params['tipe_area']."'
			AND REGIONAL = 'ALL'
			AND BRANCH = 'ALL'
			AND TYPE_DATA = '".$params['tipe_filter']."'
			AND MINIPACK <> 'BASIC'
			ORDER BY PERIODE,VIEWERS DESC
			";

	
		$db = $this->clickhouse->db();
		$out		= array();
		$resultS = $db->select($sql);
		$result = $resultS->rows();	  
    
		$total_filtered['ROWS'] = count($result);
		$total 			= count($result);
		
					    
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
    
		return $return;
  
	}
	
	public function list_data_count($params = array(),$where) {
			
				
			$sql = "
			SELECT DISTINCT MINIPACK FROM M_SUM_TV_DASH_CHANNEL_MINIPACK_AREA_PTV
			WHERE TYPE_PERIODE IN ('WEEKLY') 
			AND PERIODE LIKE '%".$params['start_date']."%'
			AND TYPE_VALUE = '".$params['type']."'
			AND AREA = '".$params['tipe_area']."'
			AND REGIONAL = 'ALL'
			AND BRANCH = 'ALL'
			AND TYPE_DATA = '".$params['tipe_filter']."'
			AND MINIPACK <> 'BASIC'
			";

	
		$db = $this->clickhouse->db();
		$out		= array();
		$resultS = $db->select($sql);
		$result = $resultS->rows();	  
    
		$total_filtered['ROWS'] = count($result);
		$total 			= count($result);
		
					    
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
    
		return $return;
  
	}
	
	public function list_data_count_ch($params = array(),$where) {
			
				
			$sql = "
			SELECT DISTINCT MINIPACK,CHANNEL FROM M_SUM_TV_DASH_CHANNEL_MINIPACK_AREA_PTV
			WHERE TYPE_PERIODE IN ('WEEKLY') 
			AND PERIODE LIKE '%".$params['start_date']."%'
			AND TYPE_VALUE = '".$params['type']."'
			AND AREA = '".$params['tipe_area']."'
			AND REGIONAL = 'ALL'
			AND BRANCH = 'ALL'
			AND TYPE_DATA = '".$params['tipe_filter']."'
			AND MINIPACK <> 'BASIC'
			";

	
		$db = $this->clickhouse->db();
		$out		= array();
		$resultS = $db->select($sql);
		$result = $resultS->rows();	  
    
		$total_filtered['ROWS'] = count($result);
		$total 			= count($result);
		
					    
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
    
		return $return;
  
	}
	
}	
