<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tvpc_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		//$this->db2 = $this->load->database('db_prod', TRUE);
	}
  
	public function list_profile($iduser,$idrole,$period) {
 
    if($period == ""){
        $sPeriod = date('Y-m');     
    } else {
        $experiod = explode("/",$period);
        $sPeriod = $experiod[2]."-".$experiod[1];         
    }
    
    $query = "SELECT a.id, `name`, grouping, postbuy_status FROM t_profiling_ub2 a JOIN M_MONTH_PROFILE_PTV c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."'";
    
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function list_channel() {
		$db = $this->clickhouse->db();
		
		$query = "SELECT CHANNEL_NAME_PROG as channel, COLOR FROM CHANNEL_PARAM_FINAL WHERE F2A_STATUS IN (0,-99) order by UPPER(CHANNEL_NAME_PROG)";  	 		
		
		
		//echo $query;die;
		
		$sql	= $db->select($query);
		$result = $sql->rows();		

		return 	$result;	
	}          
  
  public function list_channel_by_genre($strGenre) {     
    if($strGenre == "0"){
        $strWhere = "";
    } else {
        $strWhere = "AND GENRE = '".$strGenre."' ";
    }
    
 		

$query = " SELECT CHANNEL_NAME AS channel FROM `CHANNEL_PARAM_FINAL` C
      WHERE C.`GENRE_SHOW` = 1 ".$strWhere."  
      ORDER BY C.`CHANNEL_NAME`";
	  
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->result_array();	   
	}                               
  
  public function list_daypart($userid) {
		$query = 'SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID="'.$userid.'" AND MENUS="0" ORDER BY DAYPART1 ';			
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
  
  public function list_channel_genre() {
 
	  $query = " SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM_FINAL` C
      WHERE C.`GENRE_SHOW` = 1
      ORDER BY C.`GENRE`";
 		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();	   
	}
	
	public function content_grouping($profile) {
		$query = 'SELECT grouping
					FROM t_profiling_ub
					WHERE id = '.$profile.'
					AND STATUS = 1;';  			
		$sql	= $this->db2->query($query,array($profile));
		$this->db2->close();
		$this->db2->initialize(); 
		return $sql->row_array();	   
	}

	public function get_userid($data) {
		$query = "SELECT USERID	FROM SINGLE_SOURCE_VALUE"." ".$data;
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	   
	}	
  
  public function current_date() {
		$query = "SELECT DATE_FORMAT(TVPC_PTV,'%d/%m/%Y') AS CURRDATE	FROM T_PARAM_DATA";
    
		$sql	= $this->db->query($query); 
		$this->db->close();
		$this->db->initialize(); 	
		return $sql->result_array();	   
	}
  
  public function list_tvpc_export($params = array()) {
	$db = $this->clickhouse->db();
	
		$sql2 = "
		SELECT DATE,PROGRAM,CHANNEL_NAME_PROG,GENRE_PROGRAM , BEGIN_PROGRAM , IF( BEGIN_PROGRAM > END_PROGRAM, date_add(DAY, 1, END_PROGRAM), END_PROGRAM  ) END_PROGRAM ,
		VIEWERS , TOTAL_VIEWS ,
		DURATION , AUDIENCE  FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV A JOIN CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME
		WHERE B.CHANNEL_NAME_PROG IN (".$params['channel'].") AND DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
		AND ( BEGIN_PROGRAM BETWEEN '".$params['start_date']." ".$params['starttime']."' AND '".$params['end_date']." ".$params['endtime']."'
		OR END_PROGRAM BETWEEN '".$params['start_date']." ".$params['starttime']."' AND '".$params['end_date']." ".$params['endtime']."' )
		AND TIME_PERIODE = 'TVPC' 
		AND PROFILE_ID = ".$params['profile']."
		AND AUDIENCE <> 0
		ORDER BY TOTAL_VIEWS DESC "
		;
		 
		//echo $sql2;die;
			// $sql = '
		// SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV WHERE CHANNEL IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
		// AND (BEGIN_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
		// OR END_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00" )
		// AND TIME_PERIODE = "TVPC" 
		// AND PROFILE_ID = '.$params['profile'].'
		// ORDER BY TOTAL_VIEWS DESC 
		// ';
		
 		
		$sql	= $db->select($sql2);
		$result = $sql->rows();		
		
		return $result;
	}
  
	public function list_tvpc($params = array()) {
		
		$db = $this->clickhouse->db();
		
		$query = "
		SELECT DATE,PROGRAM,CHANNEL_NAME_PROG,GENRE_PROGRAM , BEGIN_PROGRAM , IF( BEGIN_PROGRAM > END_PROGRAM, date_add(DAY, 1, END_PROGRAM), END_PROGRAM  ) END_PROGRAM ,
		VIEWERS , TOTAL_VIEWS ,
		DURATION , AUDIENCE 
		FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV A JOIN CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME 
		WHERE B.CHANNEL_NAME_PROG IN (".$params['channel'].") AND DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
		AND ( BEGIN_PROGRAM BETWEEN '".$params['start_date']." ".$params['starttime']."' AND '".$params['end_date']." ".$params['endtime']."'
		OR END_PROGRAM BETWEEN '".$params['start_date']." ".$params['starttime']."' AND '".$params['end_date']." ".$params['endtime']."' )
		AND TIME_PERIODE = 'TVPC' 
		AND AUDIENCE <> 0
		AND PROFILE_ID = ".$params['profile'];
		
		//echo $query;die;
		
		$sql	= $db->select($query);
		$result = $sql->rows();		
		
		// $sql = 'SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV WHERE CHANNEL IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
		// AND ( BEGIN_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
		// OR END_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00" )
		// AND TIME_PERIODE = "TVPC" 
		// AND PROFILE_ID = '.$params['profile'];
    
 
		// $out		= array();
		// $query		= $this->db2->query($sql);
		// $result = $query->result_array();

		// while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		// if($l_result = mysqli_store_result($this->db2->conn_id)){
			  // mysqli_free_result($l_result);
			// }
		// }

		//$total_filtered = $this->db2->query('SELECT FOUND_ROWS() AS ROWS')->row_array();
		$total_filtered['ROWS'] = count($result);
		$total 			= count($result);
		
		if(($params['offset']+10) > $total_filtered['ROWS']){
			$limit_data = $total_filtered['ROWS'] - $params['offset']; 
		}else{
			$limit_data = $params['limit'] ;
		}
		 
		  $sql2 = "
		SELECT 0 AS rank, DATE,PROGRAM,CHANNEL_NAME_PROG,GENRE_PROGRAM , BEGIN_PROGRAM , IF( BEGIN_PROGRAM > END_PROGRAM, date_add(DAY, 1, END_PROGRAM), END_PROGRAM  ) END_PROGRAM ,
		VIEWERS , TOTAL_VIEWS ,
		DURATION , AUDIENCE  FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV A JOIN CHANNEL_PARAM_FINAL B ON A.CHANNEL = B.CHANNEL_NAME
		WHERE B.CHANNEL_NAME_PROG IN (".$params['channel'].") AND DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
		AND ( BEGIN_PROGRAM BETWEEN '".$params['start_date']." ".$params['starttime']."' AND '".$params['end_date']." ".$params['endtime']."'
		OR END_PROGRAM BETWEEN '".$params['start_date']." ".$params['starttime']."' AND '".$params['end_date']." ".$params['endtime']."' )
		AND TIME_PERIODE = 'TVPC' 
		AND PROFILE_ID = ".$params['profile']."
		AND AUDIENCE <> 0
		ORDER BY ".$params['order_column']." ".$params['order_dir']."
						LIMIT ".$params['offset'].",".$limit_data
		;
				//echo $sql2;die;		
						// $sql2		= 'SELECT 0 AS rank, * FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV WHERE CHANNEL IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
					// AND (BEGIN_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
					// OR END_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00" )
					// AND TIME_PERIODE = "TVPC" 
					// AND PROFILE_ID = '.$params['profile'].'
						// ORDER BY '.$params['order_column'].' '.$params['order_dir'].'
						// LIMIT '.$params['offset'].','.$limit_data;				
     
		// $query2		= $this->db2->query($sql2);
		// $result2 = $query2->result_array();
		
		$query2	= $db->select($sql2);
		$result2 = $query2->rows();		

		$return = array(
			'data' => $result2,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total,
		);
		
		return $return;
	}

	public function listchart_tvpc($params = array()) {	
		 
				$db = $this->clickhouse->db();
				// $sql		= 'SELECT * FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV WHERE CHANNEL IN ('.$params['channel'].') AND DATE BETWEEN "'.$params['start_date'].'" AND "'.$params['end_date'].'"
				// AND (BEGIN_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00"
				// OR END_PROGRAM BETWEEN "'.$params['start_date'].' '.$params['starttime'].':00" AND "'.$params['end_date'].' '.$params['endtime'].':00")
				// AND TIME_PERIODE = "TVPC" 
				// AND PROFILE_ID = '.$params['profile'].'
				// ORDER BY '.$params['cgroup'].' DESC
				// LIMIT 4000 ';
				
				 $sql = "
				SELECT 0 AS rank, DATE,PROGRAM,CHANNEL_NAME_PROG,GENRE_PROGRAM , BEGIN_PROGRAM , IF( BEGIN_PROGRAM > END_PROGRAM, date_add(DAY, 1, END_PROGRAM), END_PROGRAM  ) END_PROGRAM ,
		VIEWERS , TOTAL_VIEWS ,
		DURATION , AUDIENCE  FROM M_SUMMARY_MEDIA_PLAN_D_PTV_NEW_DTV WHERE CHANNEL IN (".$params['channel'].") AND DATE BETWEEN '".$params['start_date']."' AND '".$params['end_date']."'
				AND ( BEGIN_PROGRAM BETWEEN '".$params['start_date']." ".$params['starttime']."' AND '".$params['end_date']." ".$params['endtime']."'
				OR END_PROGRAM BETWEEN '".$params['start_date']." ".$params['starttime']."' AND '".$params['end_date']." ".$params['endtime']."' )
				AND TIME_PERIODE = 'TVPC' 
				AND PROFILE_ID = ".$params['profile']."
				ORDER BY ".$params['cgroup']." DESC 
				LIMIT 4000"
				;
								
		$query2	= $db->select($sql);
		$result2 = $query2->rows();		
		
		return $result2;
	}
  
	public function list_tvpc_allviwers($params = array()) {	
		$sql = 'SELECT 
								SQL_CALC_FOUND_ROWS 
									
								COUNT(DISTINCT pm.USER_ID) AS all_viewers
							      FROM t_people_meter AS pm , t_epg AS epg
							      WHERE epg.channel = pm.channel
									DATE_FORMAT(epg.tanggal, "%Y-%m-%d") BETWEEN CAST("'.$params['start_date'].'" AS DATE) AND CAST("'.$params['end_date'].'" AS DATE)
									AND epg.date = DATE_FORMAT(pm.begin_session, "%Y-%m-%d")
									AND epg.user_id "'.$params['profile'].'"
									
							GROUP BY epg.start_time
							ORDER BY epg.start_time ASC';
      
		$out		= array();
		$query		= $this->db2->query($sql,
			array(
				$params['limit'],
				$params['offset'],
				$params['order_column'],
				$params['order_dir'],
				$params['filter'],
				$params['start_date'],
				$params['end_date']
			));
    $result = $query->result_array();
    
		while(mysqli_more_results($this->db2->conn_id) && mysqli_next_result($this->db2->conn_id)){
		if($l_result = mysqli_store_result($this->db2->conn_id)){
			  mysqli_free_result($l_result);
			}
		}
		$total_filtered = $this->db2->query('SELECT FOUND_ROWS() AS ROWS')->row_array();
		$total 			= $this->db2->query('SELECT COUNT(a.id) as total
											FROM t_people_meter a')->row_array();
		
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['ROWS'],
			'total' => $total['total'],
		);
		
		return $return;
	}
	
	public function universe($profile) {
		$query = "SELECT COUNT(pm.USER_ID) AS universe 
				FROM t_people_meter AS pm 
				WHERE pm.user_id"." ".$profile;
		$sql	= $this->db2->query($query);
		$this->db2->close();
		$this->db2->initialize(); 	
		return $sql->result_array();	
  }                                 
    
  public function profilesearch($strSearch,$iduser,$period){
      if($period == ""){
          $sPeriod = date('Y-m');     
      } else {
          $experiod = explode("/",$period);
          $sPeriod = $experiod[2]."-".$experiod[1]; 
      }
            
      $sql = "SELECT a.id AS ID, a.`name` AS NAME FROM t_profiling_ub2 a JOIN M_MONTH_PROFILE_PTV c ON a.`id` = c.`PROFILE_ID` WHERE (STATUS = 1 OR STATUS = 3) AND (user_id_profil= 0 OR user_id_profil=".$iduser.") AND c.`STATUS_PROCESS` = 1 AND c.`PERIODE` = '".$sPeriod."' AND a.`name` LIKE '%".$strSearch."%'";
       $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  } 
  
  public function genresearch($strSearch,$role){ 
      $sql = "SELECT DISTINCT(GENRE) AS GENRE FROM `CHANNEL_PARAM` C
      WHERE C.`F2A_STATUS` IN (0,-99) AND GENRE LIKE '%".strtoupper($strSearch)."%'  
      ORDER BY C.`GENRE`";               
       $out		= array();
      $query		= $this->db->query($sql);
      $result = $query->result_array();
      
      return $result;
  }                          
    
  public function channelsearch($strSearch,$strGenre,$role){
  
      $db = $this->clickhouse->db();
		
      if($strGenre == "0"){
          $strWhere = "AND UPPER(CHANNEL_NAME_PROG) LIKE '%".strtoupper($strSearch)."%' ";
      }ELSE if($strGenre == ""){
          $strWhere = "AND UPPER(CHANNEL_NAME_PROG) LIKE '%".strtoupper($strSearch)."%' ";
      }else {
          $strWhere = "AND GENRE = '".$strGenre."' AND UPPER(CHANNEL_NAME_PROG) LIKE '%".strtoupper($strSearch)."%' ";
      }
      
      $sql = "SELECT CHANNEL_NAME_PROG AS CHANNEL FROM `CHANNEL_PARAM_FINAL` C
      WHERE C.`F2A_STATUS` IN (0,-99) ".$strWhere."  
      ORDER BY UPPER(CHANNEL_NAME_PROG)";
       $out		= array();
	   
     $sql	= $db->select($sql);
		$result = $sql->rows();		
      
      return $result;
  }             
  
  public function checkdaypart($user_id,$daypart){ 
      $query 	= "SELECT COUNT(DAYPART1) AS CODAP FROM DAYPART WHERE USERID = '".$user_id."' AND DAYPART1 = '".$daypart."'";
             
      $sql	= $this->db->query($query);
  		$this->db->close();
  		$this->db->initialize(); 	
      $retval = $sql->result_array();
  		return $retval[0]['CODAP'];
  }                                 
  
  public function setdaypart($user_id,$start_time,$end_time){ 
      $sql 	= "INSERT INTO DAYPART(`USERID`,`DAYPART1`,`MENUS`) VALUES('".$user_id."','".$start_time.":00-".$end_time.":00','0')";
             
      if ($sql) {
          $this->db->query($sql);
          
          $query = 'SELECT DAYPART1 AS DPART FROM DAYPART WHERE USERID="'.$user_id.'" AND MENUS="0" ORDER BY DAYPART1 ';			
      		$sql	= $this->db->query($query);
      		$this->db->close();
      		$this->db->initialize(); 
      		return $sql->result_array();	
      } 
      else {
          return false;
      }
  }
}	
