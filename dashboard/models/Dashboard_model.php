<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
	}
	
	
	public function list_menu($id){
		
		// $query = 	"
			// SELECT h.*,j.* FROM `pmt_menu_profile` h
						// LEFT JOIN `pmt_menu_ev` j ON h.`id_menu` = j.`id`
						// WHERE h.`id_profile` = ".$id." AND statusmenu = 1 AND menu <> '#'
						// ORDER BY sequence
						// ";
						
						$query = 	"
							SELECT h.*,j.* FROM `matrix_menu_profile` h
							LEFT JOIN `matrix_menu` j ON h.`matrix_id` = j.`id`
							WHERE h.`profile_id` = ".$id."
							ORDER BY j.`sequence`

						";
		
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		// print_r($sql->result_array()); die;
		return $sql->result_array();
		
	}
	
	public function list_user($params = array()) {					
        if(!empty($params['filter'])){
            $filter = 'AND ( a.id LIKE "%'.$params['filter'].'%" OR a.nama LIKE "%'.$params['filter'].'%" OR a.activation LIKE "%'.$params['filter'].'%" OR status_activation LIKE "%'.$params['filter'].'%"  )';
        }else{
            $filter = '';
        }
        
        if(!empty($params['order_dir'])){
            $order_dir = $params['order_dir'];
        }else{
            $order_dir = 'asc';
        }
        
		$sql 	= 'SELECT a.id, a.nama,a.status_user, a.`id_role`, c.`role`,IF(status_user = 6, "Dinas","User") AS user_tp,COALESCE(b.activation_id, b.activation_id, 0) AS activation, COALESCE(b.status, b.status, 0) AS status_activation, 
					TIMESTAMPDIFF(DAY, NOW(),b.expired_date) AS expiredday,
					`status` as statappv, b.doc
					FROM hrd_profile a
					LEFT JOIN t_activation b ON b.user_id = a.id
					LEFT JOIN pmt_role c ON a.`id_role` = c.`id`
					WHERE a.status_user in(1,6,4)
                    
                        '.$filter.'
						
						
						
                    ORDER BY '.$params['order_column'].' '.$order_dir.'
                    LIMIT ? 
			        OFFSET ?';
		
		$out = array();
		$query 	=  $this->db->query($sql,
			array(
                
				$params['limit'],
				$params['offset']
				
			));
		//var_dump($this->db->last_query());
		$result = $query->result_array();
		
		$this->load->helper('db');
		free_result($this->db->conn_id);
		
		$total_filtered = $this->db->query('SELECT COUNT(id) as total_filtered FROM hrd_profile WHERE status_user in(1,6,4)')->row_array();
		$total = $this->db->query('SELECT COUNT(a.id) as total FROM hrd_profile a
					LEFT JOIN t_activation b ON b.user_id = a.id WHERE a.status_user in(1,6,4)')->row_array();
		$totalall = '';
        if(empty($total)){
            $totalall = 0;
        }else{
            $totalall = $total['total'];
        }
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['total_filtered'],
			'total' => $totalall,
		);
		
		return $return;
	}
	
	
	public function list_user3($params = array()) {					
        if(!empty($params['filter'])){
            $filter = 'AND ( a.id LIKE "%'.$params['filter'].'%" OR a.nama LIKE "%'.$params['filter'].'%" OR a.activation LIKE "%'.$params['filter'].'%" OR status_activation LIKE "%'.$params['filter'].'%"  )';
        }else{
            $filter = '';
        }
        
        if(!empty($params['order_dir'])){
            $order_dir = $params['order_dir'];
        }else{
            $order_dir = 'asc';
        }
        
		$sql 	= 'SELECT a.id, a.nama, COALESCE(b.activation_id, b.activation_id, 0) AS activation, COALESCE(b.status, b.status, 0) AS status_activation, 
					TIMESTAMPDIFF(DAY, NOW(),b.expired_date) AS expiredday,
					`status` AS statappv, b.doc
					FROM hrd_profile a
					LEFT JOIN t_activation b ON b.user_id = a.id
					
                    WHERE a.status_user = 1
					'.$params['status'].'
                        '.$filter.'
						
						
						
                    ORDER BY '.$params['order_column'].' '.$order_dir.'
                    LIMIT ? 
			        OFFSET ?';
		
		$out = array();
		$query 	=  $this->db->query($sql,
			array(
                
				$params['limit'],
				$params['offset']
				
			));
		//var_dump($this->db->last_query());
		$result = $query->result_array();
		
		$this->load->helper('db');
		free_result($this->db->conn_id);
		
		$total_filtered = $this->db->query('SELECT COUNT(a.id) as total_filtered FROM hrd_profile a LEFT JOIN t_activation b ON b.user_id = a.id WHERE a.status_user = 1 '.$params['status'])->row_array();
		$total = $this->db->query('SELECT COUNT(a.id) as total FROM hrd_profile a
					LEFT JOIN t_activation b ON b.user_id = a.id WHERE a.status_user = 1 '.$params['status'])->row_array();
		$totalall = '';
        if(empty($total)){
            $totalall = 0;
        }else{
            $totalall = $total['total'];
        }
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['total_filtered'],
			'total' => $totalall,
		);
		
		return $return;
	}
	
	
	
	
	public function list_user_admin($params = array()) {					
        if(!empty($params['filter'])){
            $filter = 'AND ( id LIKE "%'.$params['filter'].'%" OR nama LIKE "%'.$params['filter'].'%" )';
        }else{
            $filter = '';
        }
		
        
        if(!empty($params['order_dir'])){
            $order_dir = $params['order_dir'];
        }else{
            $order_dir = 'desc';
        }
		
		// echo $params['order_dir']; die;
        
		// $sql 	= 'SELECT a.id, a.nama, COALESCE(b.activation_id, b.activation_id, 0) AS activation, COALESCE(b.status, b.status, 0) AS status_activation, TIMESTAMPDIFF(DAY, b.paid_date,b.expired_date) AS expiredday
					// FROM hrd_profile a
					// LEFT JOIN t_activation b ON b.user_id = a.id

                    
                        // '.$filter.'
                    // ORDER BY '.$params['order_column'].' '.$order_dir.'
                    // LIMIT ? 
			        // OFFSET ?';
		// $sql 	= 'SELECT id, nama, IF(status_user = 2, "Sales",IF(status_user = 	5,"Supervisor","Tech")) AS status_user
					// FROM hrd_profile
					// WHERE status_user IN (2,3,5)
                        // '.$filter.'
                    // ORDER BY '.$params['order_column'].' '.$order_dir.'
                    // LIMIT ? 
			        // OFFSET ?';
					
						$sql 	= 'SELECT id, nama, "Dinas" AS status_user
					FROM hrd_profile
					WHERE status_user IN (6)
                        '.$filter.'
                    ORDER BY '.$params['order_column'].' '.$order_dir.'
                    LIMIT ? 
			        OFFSET ?';
		
		$out = array();
		$query 	=  $this->db->query($sql,
			array(
                
				$params['limit'],
				$params['offset']
				
			));
		// var_dump($this->db->last_query());
		$result = $query->result_array();
		
		$this->load->helper('db');
		free_result($this->db->conn_id);
		
		$total_filtered = $this->db->query('SELECT COUNT(id) as total_filtered FROM hrd_profile WHERE status_user IN (6)')->row_array();
		$total = $this->db->query('SELECT COUNT(id) as total FROM hrd_profile WHERE status_user IN (6)')->row_array();
		$totalall = '';
        if(empty($total)){
            $totalall = 0;
        }else{
            $totalall = $total['total'];
        }
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['total_filtered'],
			'total' => $totalall,
		);
		
		return $return;
	}
	
	public function list_activity_detail($params = array()) {					
        if(!empty($params['filter'])){
            $filter = 'AND ( aa.nama LIKE "%'.$params['filter'].'%" OR aa.token LIKE "%'.$params['filter'].'%" OR aa.logged LIKE "%'.$params['filter'].'%" OR aa.`date_login` LIKE "%'.$params['filter'].'%" OR date_logout LIKE "%'.$params['filter'].'%"  OR client_ip LIKE "%'.$params['filter'].'%"  )';
        }else{
            $filter = '';
        }
		
        
        if(!empty($params['order_dir'])){
            $order_dir = $params['order_dir'];
        }else{
            $order_dir = 'desc';
        }
		
		// echo $params['order_dir']; die;
        
		// $sql 	= 'SELECT a.id, a.nama, COALESCE(b.activation_id, b.activation_id, 0) AS activation, COALESCE(b.status, b.status, 0) AS status_activation, TIMESTAMPDIFF(DAY, b.paid_date,b.expired_date) AS expiredday
					// FROM hrd_profile a
					// LEFT JOIN t_activation b ON b.user_id = a.id

                    
                        // '.$filter.'
                    // ORDER BY '.$params['order_column'].' '.$order_dir.'
                    // LIMIT ? 
			        // OFFSET ?';
		$sql 	= 'SELECT a.*,b.client_ip,b.request_uri,b.referer_page,PAGE,DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%Y-%m-%d %H:%i:%s") AS date_formatted FROM (
					SELECT IF(status_login = 1,TIMEDIFF(NOW(),date_login),TIMEDIFF(date_logout,date_login)) AS duration,H.* FROM t_curr_user H WHERE H.`user_id` = "'.$params['id'].'" 
					) a LEFT JOIN
					(
																	
						SELECT 
						session_id,referer_page,request_uri,client_ip,PAGE,`timestamp` FROM 
						(
							SELECT *
							,ROW_NUMBER() OVER (PARTITION BY session_id ORDER BY `timestamp` DESC) AS ROWSG    
							FROM tb_usertracking k
							WHERE referer_page <> ""
							AND `user_identifier` = "'.$params['id'].'" 
							AND session_id = "'.$params['token'].'"
						) L LEFT JOIN PAGE_URL P ON L.referer_page = P.`URL`
						
					) b
					ON a.token = b.session_id
					WHERE client_ip IS NOT NULL
					AND PAGE IS NOT NULL
					ORDER BY b.timestamp ASC, a.`date_login` DESC 
                    LIMIT ? 
			        OFFSET ?';
		
		$out = array();
		$query 	=  $this->db->query($sql,
			array(
                
				$params['limit'],
				$params['offset']
				
			));
		// var_dump($this->db->last_query());
		$result = $query->result_array();
		
		$this->load->helper('db');
		free_result($this->db->conn_id);
		 
		$total_filtered = $this->db->query('
		SELECT COUNT(client_ip) as total_filtered  FROM (
SELECT a.*,b.client_ip,b.request_uri,b.referer_page,PAGE,DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%Y-%m-%d %H:%i:%s") AS date_formatted FROM (
					SELECT IF(status_login = 1,TIMEDIFF(NOW(),date_login),TIMEDIFF(date_logout,date_login)) AS duration,H.* FROM t_curr_user H WHERE H.`user_id` = "'.$params['id'].'" 
					) a LEFT JOIN
					(
																	
						SELECT 
						session_id,referer_page,request_uri,client_ip,PAGE,`timestamp` FROM 
						(
							SELECT *
							,ROW_NUMBER() OVER (PARTITION BY session_id ORDER BY `timestamp` DESC) AS ROWSG    
							FROM tb_usertracking k
							WHERE referer_page <> ""
							AND `user_identifier` = "'.$params['id'].'" 
							AND session_id = "'.$params['token'].'"
						) L LEFT JOIN PAGE_URL P ON L.referer_page = P.`URL`
						
					) b
					ON a.token = b.session_id
					WHERE client_ip IS NOT NULL
					AND PAGE IS NOT NULL
					ORDER BY b.timestamp ASC, a.`date_login` DESC ) o
		')->row_array();
		$total = $this->db->query('SELECT COUNT(user_id) as total  FROM (
SELECT a.*,b.client_ip,b.request_uri,b.referer_page,PAGE,DATE_FORMAT(FROM_UNIXTIME(`timestamp`), "%Y-%m-%d %H:%i:%s") AS date_formatted FROM (
					SELECT IF(status_login = 1,TIMEDIFF(NOW(),date_login),TIMEDIFF(date_logout,date_login)) AS duration,H.* FROM t_curr_user H WHERE H.`user_id` = "'.$params['id'].'" 
					) a LEFT JOIN
					(
																	
						SELECT 
						session_id,referer_page,request_uri,client_ip,PAGE,`timestamp` FROM 
						(
							SELECT *
							,ROW_NUMBER() OVER (PARTITION BY session_id ORDER BY `timestamp` DESC) AS ROWSG    
							FROM tb_usertracking k
							WHERE referer_page <> ""
							AND `user_identifier` = "'.$params['id'].'" 
							AND session_id = "'.$params['token'].'"
						) L LEFT JOIN PAGE_URL P ON L.referer_page = P.`URL`
						
					) b
					ON a.token = b.session_id
					WHERE client_ip IS NOT NULL
					AND PAGE IS NOT NULL
					ORDER BY b.timestamp ASC, a.`date_login` DESC ) o  ')->row_array();
		$totalall = '';
        if(empty($total)){
            $totalall = 0;
        }else{
            $totalall = $total['total'];
        }
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['total_filtered'],
			'total' => $totalall,
		);
		
		return $return;
	}
	
	public function list_activity($params = array()) {					
        if(!empty($params['filter'])){
            $filter = 'AND ( aa.nama LIKE "%'.$params['filter'].'%" OR aa.token LIKE "%'.$params['filter'].'%" OR aa.logged LIKE "%'.$params['filter'].'%" OR aa.`date_login` LIKE "%'.$params['filter'].'%" OR date_logout LIKE "%'.$params['filter'].'%"  OR client_ip LIKE "%'.$params['filter'].'%"  )';
        }else{
            $filter = '';
        }
		
        
        if(!empty($params['order_dir'])){
            $order_dir = $params['order_dir'];
        }else{
            $order_dir = 'desc';
        }
		
		// echo $params['order_dir']; die;
        
		// $sql 	= 'SELECT a.id, a.nama, COALESCE(b.activation_id, b.activation_id, 0) AS activation, COALESCE(b.status, b.status, 0) AS status_activation, TIMESTAMPDIFF(DAY, b.paid_date,b.expired_date) AS expiredday
					// FROM hrd_profile a
					// LEFT JOIN t_activation b ON b.user_id = a.id

                    
                        // '.$filter.'
                    // ORDER BY '.$params['order_column'].' '.$order_dir.'
                    // LIMIT ? 
			        // OFFSET ?';
		$sql 	= 'SELECT a.*,b.client_ip,b.request_uri,b.referer_page,PAGE FROM (
					SELECT IF(status_login = 1,TIMEDIFF(NOW(),date_login),TIMEDIFF(date_logout,date_login)) AS duration,H.* FROM t_curr_user H WHERE H.`user_id` = "'.$params['id'].'" 
					) a LEFT JOIN
					(
																	
						SELECT 
						session_id,referer_page,request_uri,client_ip,PAGE FROM 
						(
							SELECT *
							,ROW_NUMBER() OVER (PARTITION BY session_id ORDER BY `timestamp` DESC) AS ROWSG    
							FROM tb_usertracking k
							WHERE referer_page <> ""
							and user_identifier = '.$params['id'].'
						) L LEFT JOIN PAGE_URL P ON L.referer_page = P.`URL`
						WHERE ROWSG = 1 
					) b
					ON a.token = b.session_id
					ORDER BY a.status_login DESC, a.`date_login` DESC 
                    LIMIT ? 
			        OFFSET ?';
		
		$out = array();
		$query 	=  $this->db->query($sql,
			array(
                
				$params['limit'],
				$params['offset']
				
			));
		// var_dump($this->db->last_query());
		$result = $query->result_array();
		
		$this->load->helper('db');
		free_result($this->db->conn_id);
		 
		$total_filtered = $this->db->query('
		SELECT COUNT(a.user_id) as total_filtered  FROM (
		SELECT H.* FROM t_curr_user H WHERE H.`user_id` = "'.$params['id'].'" 
		) a LEFT JOIN
		(
														
			SELECT
			session_id,referer_page,request_uri,client_ip FROM 
			(
				SELECT *
				,ROW_NUMBER() OVER (PARTITION BY session_id ORDER BY `timestamp` DESC) AS ROWSG    
				FROM tb_usertracking k
				WHERE referer_page <> ""
				and user_identifier = '.$params['id'].'
			) L WHERE ROWSG = 1
		) b
		ON a.token = b.session_id
		ORDER BY a.status_login DESC, a.`date_login` DESC
		')->row_array();
		$total = $this->db->query('SELECT COUNT(a.user_id) as total  FROM (
		SELECT H.* FROM t_curr_user H WHERE H.`user_id` = "'.$params['id'].'" 
		) a LEFT JOIN
		(
														
			SELECT
			session_id,referer_page,request_uri,client_ip FROM 
			(
				SELECT *
				,ROW_NUMBER() OVER (PARTITION BY session_id ORDER BY `timestamp` DESC) AS ROWSG    
				FROM tb_usertracking k
				WHERE referer_page <> ""
				and user_identifier = '.$params['id'].'
			) L WHERE ROWSG = 1
		) b
		ON a.token = b.session_id
		ORDER BY a.status_login DESC, a.`date_login` DESC  ')->row_array();
		$totalall = '';
        if(empty($total)){
            $totalall = 0;
        }else{
            $totalall = $total['total'];
        }
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['total_filtered'],
			'total' => $totalall,
		);
		
		return $return;
	}

	public function list_user_count($params = array()) {					
        if(!empty($params['filter'])){
            $filter = 'AND ( nama LIKE "%'.$params['filter'].'%" OR currentuser LIKE "%'.$params['filter'].'%" )';
        }else{
            $filter = '';
        }
		
        
        if(!empty($params['order_dir'])){
            $order_dir = $params['order_dir'];
        }else{
            $order_dir = 'desc';
        }
		
		// echo $params['order_dir']; die;
        
		// $sql 	= 'SELECT a.id, a.nama, COALESCE(b.activation_id, b.activation_id, 0) AS activation, COALESCE(b.status, b.status, 0) AS status_activation, TIMESTAMPDIFF(DAY, b.paid_date,b.expired_date) AS expiredday
					// FROM hrd_profile a
					// LEFT JOIN t_activation b ON b.user_id = a.id

                    
                        // '.$filter.'
                    // ORDER BY '.$params['order_column'].' '.$order_dir.'
                    // LIMIT ? 
			        // OFFSET ?';
		$sql 	= 'SELECT b.nama, COUNT(a.id) AS currentuser 
						FROM t_curr_user a
						LEFT JOIN hrd_profile b ON b.id = a.user_id
						WHERE a.status_login = 1
						AND b.status_user  in (1,6)
                        '.$filter.'
						GROUP BY a.`user_id`
                    ORDER BY '.$params['order_column'].' '.$order_dir.'
                    LIMIT ? 
			        OFFSET ?';
		
		$out = array();
		$query 	=  $this->db->query($sql,
			array(
                
				$params['limit'],
				$params['offset']
				
			));
		// var_dump($this->db->last_query());
		$result = $query->result_array();
		
		$this->load->helper('db');
		free_result($this->db->conn_id);
		
		$total_filtered = $this->db->query('SELECT  COUNT(a.id) AS total_filtered 
						FROM t_curr_user a
						LEFT JOIN hrd_profile b ON b.id = a.user_id
						WHERE a.status_login = 1
						AND b.status_user  in (1,6) ')->row_array();
		$total = $this->db->query('SELECT COUNT(a.id) AS total 
						FROM t_curr_user a
						LEFT JOIN hrd_profile b ON b.id = a.user_id
						WHERE a.status_login = 1
						AND b.status_user  in (1,6) ')->row_array();
		$totalall = '';
        if(empty($total)){
            $totalall = 0;
        }else{
            $totalall = $total['total'];
        }
		$return = array(
			'data' => $result,
			'total_filtered' => $total_filtered['total_filtered'],
			'total' => $totalall,
		);
		
		return $return;
	}

	
    public function updateRole($data){
        // print_r($data); die;
            $sql 	= 'UPDATE t_activation SET `status` = ?, reason = ? WHERE user_id = ? ';
        $st = '';
		
		if( $data['status'] == 1){
			 $st = 'TRIAL APPROVED';
		}elseif( $data['status'] == 4){
			 $st = 'PAID APPROVED';
		}elseif( $data['status'] == 3){
			 $st = 'REJECT';
		}
		
		
            if ($sql) {
                $sca = $this->db->query($sql,array(
                                                            $data['status'],
                                                            $data['reason'],
                                                            $data['id']
                                                   )
                                               );
											   
				if($sca){
						$sql2 	= "INSERT INTO t_activation_log
							( user_id, date_log, `status`)
							VALUES
							(".$data['id'].", NOW(), '".$st."')";
						return $this->db->query($sql2);
						
				}else {
					return false;
				}							   
            } 
            else {
                return false;
            }
    }
	
	
	
	public function currentuser(){
		
		$query = "SELECT  COUNT(a.id) AS currentuser 
						FROM t_curr_user a
						LEFT JOIN hrd_profile b ON b.id = a.user_id
						WHERE a.status_login = 1
						AND b.status_user  in (6,1)";
		  
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function loginuser(){
		
		$query = "SELECT COUNT(id) AS totaluser 
					FROM hrd_profile
					WHERE status_user IN (6)";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function premiumuser(){
		
		$query = "SELECT COUNT(a.id) AS premiumuser 
				FROM t_activation a
				LEFT JOIN hrd_profile b ON b.`id` = a.`user_id`
				WHERE b.status_user = 1

AND a.activation_id = 1";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function trialuser(){
		
		$query = "SELECT COUNT(a.id) AS trialuser 
FROM t_activation a
LEFT JOIN hrd_profile b ON b.`id` = a.`user_id`
WHERE b.status_user = 1

AND a.activation_id = 2";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	public function detail($id){
		
		$query = "SELECT a.*, b.* , c.role
FROM t_activation a
LEFT JOIN hrd_profile b ON b.`id` = a.`user_id`
LEFT JOIN pmt_role c ON c.id = b.`id_role`
WHERE b.id = ".$id;
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	public function history($id){
		
		$query = "SELECT date_log, `status` FROM t_activation_log WHERE user_id =  ".$id." ORDER BY date_log DESC ";
		 
		$sql	= $this->db->query($query);
		$this->db->close();
		$this->db->initialize(); 
		return $sql->result_array();			
	}
	
	
}	
