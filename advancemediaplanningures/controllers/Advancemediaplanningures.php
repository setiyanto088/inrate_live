<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advancemediaplanningures extends JA_Controller {
  public function __construct()
	{
		parent::__construct();			
		$this->load->model('mediaplanningu_model');
		
	}
	
	public function index()
	{
		$id = $this->session->userdata('project_id');
		$iduser = $this->session->userdata('user_id');
		$idrole = $this->session->userdata('id_role');
		if($id == null){
			$id = 0;
		}else{
			$id = $this->session->userdata('project_id');
		}
		$menuL = $this->session->userdata('menuL');
		$array_menu = explode(',',$menuL);
		
		if(!$this->session->userdata('user_id') || in_array("169",$array_menu) == 0) {
          redirect ('/login');
		}
		
		$data['profile'] = $this->mediaplanningu_model->get_profile3($iduser,$idrole,"");
		$data['channels'] = $this->mediaplanningu_model->get_channel(); 
    $data['currdate'] = $this->mediaplanningu_model->current_date();
		$this->template->load('maintemplate', 'advancemediaplanningures/views/Mediaplanningu_view', $data);
	}
  
	public function list_planning()
	{	
			if( !empty($this->Anti_si($this->input->post('start_date',true))) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($this->input->post('start_date',true)));
			$start_date = $date->format('Y-m-d');
		} else {
			$start_date = NULL;
		}
		if( !empty($this->Anti_si($this->input->post('start_date_ads',true))) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($this->input->post('start_date_ads',true)));
			$start_date_ads = $date->format('Y-m-d');
		} else {
			$start_date_ads = NULL;
		}
		
		if( !empty($this->Anti_si($this->input->post('end_date',true))) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($this->input->post('end_date',true)));
			$end_date = $date->format('Y-m-d');
		} else {
			$end_date = NULL;
		}

		if( !empty($this->Anti_si($this->input->post('end_date_ads',true))) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($this->input->post('end_date_ads',true)));
			$end_date_ads = $date->format('Y-m-d');
		} else {
			$end_date_ads = NULL;
		}

		if( !empty($this->Anti_si($this->input->post('cost',true))) ) {
			$cost = $this->Anti_si($this->input->post('cost',true));	
		} else {
			$cost = NULL;
		}	
		
		if( !empty($this->Anti_si($this->input->post('discount',true))) ) {
			$discount = $this->Anti_si($this->input->post('discount',true));	
		} else {
			$discount = 0;
		}	
		
		if( !empty($this->Anti_si($this->input->post('profile',true))) ) {			
			if($this->Anti_si($this->input->post('profile',true)) == "all"){
				$profiles = "0";
			}else{
				$profiles = $this->Anti_si($this->input->post('profile',true));	
			}
		} else {
			$profiles = "0";
		}
     
		$high_tvr = $this->Anti_si($this->input->post('high_tvr',true));		
		$maximum_cost = $this->Anti_si($this->input->post('maximum_cost',true));	
		$minimum_cprp = $this->Anti_si($this->input->post('minimum_cprp',true));			
		$index = $this->Anti_si($this->input->post('index',true));
		$maximum_reach = $this->Anti_si($this->input->post('maximum_reach',true));
		
		$ordernya = '';
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 
		$order_fields = array('date', 'channel', 'program', 'level1', 'level2', 'tvr', 'tvs', 'cprp', 'cost');
				
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
		
		$search = $this->Anti_si($this->input->get_post('search',true));		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}	
			
		$cs = 0;
		if($high_tvr == 1){
			$cs = 4;
		}
     
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$params['start_date'] 	= $start_date;
		$params['start_date_ads'] 	= $start_date_ads;
		$params['end_date'] 	= $end_date;
		$params['end_date_ads'] 	= $end_date_ads;
		$params['cost']			= $cost;
		$params['discount']		= 100-$discount;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['maximum_reach']	= $maximum_reach; 
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['channel']	= $this->input->post('channel'); 
		
		
		$arr_ch = explode(',',$params['channel']);
		
		$chna = '';
		foreach($arr_ch as $arr_chs){
			
			$chna .= "'".$arr_chs."',";
			
		}
		
		$params['channel'] = substr($chna,0,-1);
		
		$list = $this->mediaplanningu_model->list_planning($params);
		
		
		

		$data_mp = array();	
		
		$cost_m = 0;
		$cpv = 0;
		$tvr = 0;
		$mintvr = 1000;
		$maxtvr = 0;
		
		$array_summ = array();	
		$array_summd = array();	
		
		foreach ( $list as $v ) {
			
			
			$cost_m = $cost_m+($v['RATE_D']*1000);
			
			if($cost_m < $cost){
				$data_mp[] = $v;
				$rank = $v['RANK'];
				$tvr = $tvr+ $v['TVR_A'];
				$cpv = $cpv+ $v['REACH'];
				
				if($mintvr > $v['TVR_A'] ){
					$mintvr = $v['TVR_A'];
				}
				
				if($maxtvr < $v['TVR_A'] ){
					$maxtvr = $v['TVR_A'];
				} 
				
				$array_summ[$v['CHANNEL']][$v['PROGRAM']][$v['TYPE']][] = $v;
				$array_summd[$v['CHANNEL']][$v['TYPE']][] = $v;
				
			}else{
				$cost_m = $cost_m-($v['RATE_D']*1000); 
				break;
			}
		}	
		
		
		$array_summ1 = [];
		$is = 0;
		$ichannel = 0;
		foreach($array_summ as $array_summss){
			
			
			$iprogram = 0;
			foreach($array_summss as $array_summss2){
				
				
				$iads = 0;
				$tvr_ss = 0;
				$rate_ss = 0;
				$spot_ss = 0;
				foreach($array_summss2 as $array_summss3){
					
					$ads_summ1 = array_keys($array_summss2);
					
					$channel_summ1 = array_keys($array_summ);
					$program_summ1 = array_keys($array_summss);
					
					
					foreach($array_summss3 as $array_summss3ggg){
						$tvr_ss = $tvr_ss+$array_summss3ggg['TVR_A'];
						$rate_ss = $rate_ss+$array_summss3ggg['RATE_D'];
						$spot_ss++;
					}
					
					$array_summ1[$is]['CHANNEL'] = $channel_summ1[$ichannel];
					$array_summ1[$is]['PROGRAM'] = $program_summ1[$iprogram];
					$array_summ1[$is]['ADSTYPE'] = $ads_summ1[$iads];
					$array_summ1[$is]['SPOT'] =  number_format(COUNT($array_summss3),0, ",", ".");
					$array_summ1[$is]['COST'] =  number_format(($rate_ss/$spot_ss)*1000,0, ",", ".");
					$array_summ1[$is]['TVR'] = number_format($tvr_ss,2, ",", ".");
					$array_summ1[$is]['RATE'] = $array_summss3ggg['RATE'];
					$is++;
					$iads++;
					
				}
				
				$iprogram++;
			}
		
		$ichannel++;
		}
		
		
		
		$array_summ2 = [];
		$is = 0;
		$ichannel = 0;
		foreach($array_summd as $array_summssd){
			$iads = 0;
			$tvr_ss = 0;
				$rate_ss = 0;
				$spot_ss = 0;	
				
				foreach($array_summssd as $array_summss3d){
					
					$ads_summ1 = array_keys($array_summssd);
					$channel_summ1 = array_keys($array_summd);
					
					foreach($array_summss3d as $array_summss3dggg){
						$tvr_ss = $tvr_ss+$array_summss3dggg['TVR_A'];
						$rate_ss = $rate_ss+$array_summss3dggg['RATE_D'];
						$spot_ss++;
					}
					
					$array_summ2[$is]['CHANNEL'] = $channel_summ1[$ichannel];
					$array_summ2[$is]['ADSTYPE'] = $ads_summ1[$iads];
					$array_summ2[$is]['SPOT'] =  number_format(COUNT($array_summss3d),0, ",", ".");
					$array_summ2[$is]['COST'] =  number_format(($rate_ss/$spot_ss)*1000,0, ",", ".");
					$array_summ2[$is]['TVR'] = number_format($tvr_ss,2, ",", ".");
					$array_summ2[$is]['RATE'] = $array_summss3dggg['RATE'];
					$is++;
				}
			
			$ichannel++;
		}
		
		
		$ads_summ = [];
		$array_kurang = [];
		$cnt_adsbb = [];
		
		
		
		foreach($array_summ1 as $array_summ2ggg){
			
							
				
				
				if(isset($cnt_adsbb[$array_summ2ggg['CHANNEL']])){
					$cnt_adsbb[$array_summ2ggg['CHANNEL']] = $cnt_adsbb[$array_summ2ggg['CHANNEL']]."'".$array_summ2ggg['PROGRAM']."',";
				}else{
					$cnt_adsbb[$array_summ2ggg['CHANNEL']] = "'".$array_summ2ggg['PROGRAM']."',";
				}
			
			$lists = $this->mediaplanningu_model->list_ads($params,$array_summ2ggg);
			
			
			if(isset($array_kurang[$array_summ2ggg['CHANNEL']])){
				
				$array_kurang[$array_summ2ggg['CHANNEL']] = $array_kurang[$array_summ2ggg['CHANNEL']] + ($array_summ2ggg['SPOT'] - COUNT($lists));
				
			}else{
				
				$array_kurang[$array_summ2ggg['CHANNEL']] = ($array_summ2ggg['SPOT'] - COUNT($lists));
				
			}
			
			

			foreach($lists as $lists1){
				
				$ads_summ[] =  $lists1;
				
			}
			 
		}
		
		
		$cnt_ads = [];
		$cnt_adsaa = [];
		
		$total_kurang = 0;
		foreach($array_kurang as $kk){
			
			$total_kurang = $total_kurang + $kk;
			
		}
		
		
		$slays = "";
		
			
			foreach($array_summ1 as $array_kurangs){

					
					if($array_kurang[$array_kurangs['CHANNEL']] <> 0 ){
						
						$listss = $this->mediaplanningu_model->list_ads_ext($params,$array_kurangs);
						
						foreach($listss as $lists11){
							
							$ads_summ[] =  $lists11;
							
						}
						
						$array_kurangs['SPOT'] = $array_kurangs['SPOT'] - count($listss);
						$array_kurang[$array_kurangs['CHANNEL']] = $array_kurang[$array_kurangs['CHANNEL']] - count($listss);
					}				
			}
		
		
		
						
		
		$total_kurang_a = 0;
		foreach($array_kurang as $kk){
			
			$total_kurang_a = $total_kurang_a + $kk;
			
		}
		
			
			foreach($array_summ1 as $array_kurangs){
					
					
					$prog = substr($cnt_adsbb[$array_kurangs['CHANNEL']],0,-1);
					
					if($array_kurang[$array_kurangs['CHANNEL']] <> 0 ){
						
						$listss = $this->mediaplanningu_model->list_ads_ext2($params,$array_kurangs['CHANNEL'],$array_kurangs['RATE'],$array_kurang[$array_kurangs['CHANNEL']],$prog,$array_kurangs['ADSTYPE']);
						
						foreach($listss as $lists11){
							
							$ads_summ[] =  $lists11;
							
						}
						
						$array_kurangs['SPOT'] = $array_kurangs['SPOT'] - count($listss);
						$array_kurang[$array_kurangs['CHANNEL']] = $array_kurang[$array_kurangs['CHANNEL']] - count($listss);
					}				
			}
			
			foreach($array_summ1 as $array_kurangs){
					
					
					$prog = substr($cnt_adsbb[$array_kurangs['CHANNEL']],0,-1);
					
					if($array_kurang[$array_kurangs['CHANNEL']] <> 0 ){
						
						$listss = $this->mediaplanningu_model->list_ads_ext3($params,$array_kurangs['CHANNEL'],$array_kurangs['RATE'],$array_kurang[$array_kurangs['CHANNEL']],$prog,$array_kurangs['ADSTYPE']);
						
						foreach($listss as $lists11){
							
							$ads_summ[] =  $lists11;
							
						}
						
						$array_kurangs['SPOT'] = $array_kurangs['SPOT'] - count($listss);
						$array_kurang[$array_kurangs['CHANNEL']] = $array_kurang[$array_kurangs['CHANNEL']] - count($listss);
					}				
			}
		
		
		$total_kurang_a = 0;
		foreach($array_kurang as $kk){
			
			$total_kurang_a = $total_kurang_a + $kk;
			
		}
		
		
			
			
			
				
					
					
			
			
		
		
		
		$data_mp9 = array();	
		
		$cost_m9 = 0;
		$cpv9 = 0;
		$tvr9 = 0;
		$mintvr9 = 1000;
		$maxtvr9 = 0;
		
		$array_summ9 = array();	
		$array_summd9 = array();	
		
		foreach ( $ads_summ as $v2 ) {
			
			
			$cost_m9 = $cost_m9+($v2['RATE_D']*1000);
			
				$data_mp9[] = $v2;
				$tvr9= $tvr9+ $v2['TVR_A'];
				$cpv9 = $cpv9+ $v2['REACH'];
				
				if($mintvr9 > $v2['TVR_A'] ){
					$mintvr9 = $v2['TVR_A'];
				}
				
				if($maxtvr9 < $v2['TVR_A'] ){
					$maxtvr9 = $v2['TVR_A'];
				} 
				
				$array_summ9[$v2['CHANNEL']][$v2['PROGRAM']][$v2['TYPE']][] = $v2;
				$array_summd9[$v2['CHANNEL']][$v2['TYPE']][] = $v2;
				
		}	
		
		
		
		
		
		$array_summ19 = [];
		$is9 = 0;
		$ichannel9 = 0;
		foreach($array_summ9 as $array_summss9){
			
			
			$iprogram9 = 0;
			foreach($array_summss9 as $array_summss29){
				
				
				$iads9 = 0;
				$tvr_ss = 0;
				$rate_ss = 0;
				$spot_ss = 0;
				foreach($array_summss29 as $array_summss39){
					
					$ads_summ19 = array_keys($array_summss29);
					
					$channel_summ19 = array_keys($array_summ9);
					$program_summ19 = array_keys($array_summss9);
					
					
					foreach($array_summss39 as $array_summss39ggg){
						$tvr_ss = $tvr_ss+$array_summss39ggg['TVR_A'];
						$rate_ss = $rate_ss+$array_summss39ggg['RATE_D'];
						$spot_ss++;
					}
					
					
					$array_summ19[$is9]['CHANNEL'] = $channel_summ19[$ichannel9];
					$array_summ19[$is9]['PROGRAM'] = $program_summ19[$iprogram9];
					$array_summ19[$is9]['ADSTYPE'] = $ads_summ19[$iads9];
					$array_summ19[$is9]['SPOT'] =  number_format(COUNT($array_summss39),0, ",", ".");
					$array_summ19[$is9]['COST'] =  number_format(($rate_ss/$spot_ss)*1000,0, ",", ".");
					$array_summ19[$is9]['TVR'] = number_format($tvr_ss,2, ",", ".");
					$is9++;
					$iads9++;
					
				}
				
				$iprogram9++;
			}
		
		$ichannel9++;
		}
		
		
		$array_summ29 = [];
		$is9 = 0;
		$ichannel9 = 0;
		foreach($array_summd9 as $array_summssd9){
			$channel_summ19 = array_keys($array_summd9);
			$iads9 = 0;
				
				$array_color[$channel_summ19[$ichannel9]] = substr(str_shuffle('AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899'), 0, 6);
				
				
				$tvr_ss = 0;
				$rate_ss = 0;
				$spot_ss = 0;
				foreach($array_summssd9 as $array_summss3d9){
					
					$ads_summ19 = array_keys($array_summssd9);
					
					foreach($array_summss3d9 as $array_summss3d9ggg){
						$tvr_ss = $tvr_ss+$array_summss3d9ggg['TVR_A'];
						$rate_ss = $rate_ss+$array_summss3d9ggg['RATE_D'];
						$spot_ss++;
					}
					
					
					$array_summ29[$is9]['CHANNEL'] = $channel_summ19[$ichannel9];
					$array_summ29[$is9]['ADSTYPE'] = $ads_summ19[$iads9];
					$array_summ29[$is9]['SPOT'] =  number_format(COUNT($array_summss3d9),0, ",", ".");
					$array_summ29[$is9]['COST'] =   number_format(($rate_ss/$spot_ss)*1000,0, ",", ".");
					$array_summ29[$is9]['TVR'] = number_format($tvr_ss,2, ",", ".");
					$is9++;
				}
			
			$ichannel9++;
		}
		
		$data_cal = array();	
		$in = 0;
		
		
		foreach ( $ads_summ as $k => $v ) { 
		
		  
				$cprp = number_format($v['CPRP'], 0, ",", ".");			
					$cost = $v['RATE']*1000;
					$tvs = $v['TVS_A'];
					$index = $v['IDX_A']*100;
					
					$time = explode('-',$v['DATE']);
					$reach = $cost / $v['VIEWER_A'];
					$newformat = $v['DATE'];
					
			array_push($data_cal, 
				array(
					$in,
					$newformat,
					$v['CHANNEL'],	
					$v['PROGRAM'],					
					$newformat.' '.$v['START_TIME'],					
					$newformat.' '.$v['END_TIME'],					
					$v['TYPE'],					
					number_format($v['TVR'],2, ",", "."),
					number_format($tvs,2, ",", "."),
					$cprp,
					number_format($cost,0, ",", "."),
					number_format($reach,2, ",", "."),
					number_format($index,2, ",", "."), 
					$array_color[$v['CHANNEL']]
				)
			);
			
			$in++;
		}	
		
		
		$result['cost9'] = number_format($cost_m9,0, ",", ".");
		$result['spot9'] = number_format(count($ads_summ),0, ",", ".");
		$result['tvr9'] = number_format($tvr9,2, ",", ".");
		$result['maxtvr9'] = number_format($maxtvr9,2, ",", ".");
		$result['mintvr9'] = number_format($mintvr9,2, ",", ".");
		$result['cpv19'] = number_format($cpv9,2, ",", "."); 
		
		if(count($ads_summ) == 0){
			
			$result['avgtvr9'] = 0;
			$result['cprp19'] = 0;
			
		}else{
			
			$result['avgtvr9'] = number_format($tvr9/count($ads_summ),2, ",", ".");
			$result['cprp19'] = number_format(ceil($cost_m9/$tvr9),0, ",", ".");
			
		}
		
		
		
		$result['cost'] = number_format($cost_m,0, ",", ".");
		$result['spot'] = number_format(count($data_mp),0, ",", ".");
		$result['tvr'] = number_format($tvr,2, ",", ".");
		$result['maxtvr'] = number_format($maxtvr,2, ",", ".");
		$result['mintvr'] = number_format($mintvr,2, ",", ".");
		$result['cpv1'] = number_format($cpv,2, ",", ".");
		 
		 if(count($data_mp) == 0){
			$result['avgtvr'] = 0;
			$result['cprp1'] = 0;  
		 }else{
			$result['avgtvr'] = number_format($tvr/count($data_mp),2, ",", ".");
			$result['cprp1'] = number_format(ceil($cost_m/$tvr),0, ",", "."); 
		 }
		 
		
		
		$result["data"] = $data_mp; 
		$result["data_2"] = $array_summ1; 
		$result["data_3"] = $array_summ2; 
		$result["data_4"] = $ads_summ; 
		$result["data_21"] = $array_summ19; 
		$result["data_31"] = $array_summ29; 
		
		$result["recordsFiltered"] = count($ads_summ);
		$result["data_cal"] = $data_cal;
		
		echo json_encode($result,true);
		
	}	
	
	public function list_calander2()
	{	
		if( !empty($this->Anti_si($this->input->post('start_date',true))) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($this->input->post('start_date',true)));
			$start_date = $date->format('Y-m-d');
		} else {
			$start_date = NULL;
		}
		
		if( !empty($this->Anti_si($this->input->post('count_data',true))) ) {
			$count_data =$this->Anti_si( $this->input->post('count_data',true));
		} else {
			$count_data = 0;
		}
		
		if( !empty($this->Anti_si($this->input->post('cr_data',true))) ) {
			$cr_data = $this->Anti_si($this->input->post('cr_data',true));
		} else {
			$cr_data = 0;
		}
		
		
		
		$data_cal = array();	
		$in = 0;
		
		$ads_summ = json_decode($cr_data,true);
		
		foreach ( $ads_summ as $k => $v ) { 
		
		
			if(!isset($array_color[$v['CHANNEL']])){
				
				$array_color[$v['CHANNEL']] = substr(str_shuffle('AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899'), 0, 6);
	
			}
				

	
				$cprp = number_format($v['CPRP'], 0, ",", ".");			
					$cost = $v['RATE']*1000;
					$tvs = $v['TVS'];
					$index = $v['IDX']*100;
					
					$time = explode('/',$v['DATE']);
					
					
					if(count($time) < 3 ){
						
						$newformat = $v['DATE'];
						
					}else{
						$newformat = $time[2].'-'.$time[1].'-'.$time[0];
					}
					
					
					$reach = $cost / $v['VIEWER'];
					
			array_push($data_cal, 
				array(
					$in,
					$newformat,
					$v['CHANNEL'],	
					$v['PROGRAM'],					
					$newformat.' '.$v['START_TIME'],					
					$newformat.' '.$v['END_TIME'],					
					$v['TYPE'],					
					number_format($v['TVR'],2, ",", "."),
					number_format($tvs,2, ",", "."),
					$cprp,
					number_format($cost,0, ",", "."),
					number_format($reach,2, ",", "."),
					number_format($index,0, ",", "."), 
					$array_color[$v['CHANNEL']]
				)
			);
			
			$in++;
		}	
		
		$result["recordsFiltered"] = count($ads_summ);
		$result["data"] = $data_cal;
		
		
		echo json_encode($result,true);
	}
	
	public function print_calender()
	{	
	
		if( !empty($this->Anti_si($this->input->post('start_date',true))) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($this->input->post('start_date',true)));
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( !empty($this->Anti_si($this->input->post('count_data',true))) ) {
			$count_data = $this->Anti_si($this->input->post('count_data',true));
		} else {
			$count_data = 0;
		}
		
		if( !empty($this->Anti_si($this->input->post('cr_data',true))) ) {
			$cr_data = $this->Anti_si($this->input->post('cr_data',true));
		} else {
			$cr_data = 0;
		}
		
		
		$data_cal = array();	
		$in = 0;
		
		$ads_summ = json_decode($cr_data,true);
		
		$data_cal = array();	
		$in = 0;
		
		
		foreach ( $ads_summ as $k => $v ) { 
		if(!isset($array_color[$v['CHANNEL']])){
				
				$array_color[$v['CHANNEL']] = substr(str_shuffle('AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899'), 0, 6);
	
			}
		  
				$cprp = number_format($v['CPRP'], 0, ",", ".");			
					$cost = $v['RATE']*1000;
					$tvs = $v['TVS'];
					$index = $v['IDX']*100;
					
					$time = explode('/',$v['DATE']);
					$reach = $cost / $v['VIEWER'];
					$newformat = $time[2].'-'.$time[1].'-'.$time[0];
					
			array_push($data_cal, 
				array(
					$in,
					$newformat,
					$v['CHANNEL'],	
					$v['PROGRAM'],					
					$newformat.' '.$v['START_TIME'],					
					$newformat.' '.$v['END_TIME'],					
					$v['TYPE'],					
					number_format($v['TVR'],2, ",", "."),
					number_format($tvs,2, ",", "."),
					$cprp,
					number_format($cost,0, ",", "."),
					number_format($reach,2, ",", "."),
					number_format($index,0, ",", "."), 
					$array_color[$v['CHANNEL']]
				)
			);
			
			$in++;
		}	
		
		
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
					->setCellValue('A1', 'TANGGAL')
					->setCellValue('B1', 'CHANNEL')
					->setCellValue('C1', 'PROGRAM')
					->setCellValue('D1', 'BEGIN PROGRAM') 
					->setCellValue('E1', 'END PROGRAM')
					->setCellValue('F1', 'ADS TYPE')
					->setCellValue('G1', 'TVR')
					->setCellValue('H1', 'TVS')
					->setCellValue('I1', 'CPRP')
					->setCellValue('J1', 'COST')
					->setCellValue('I1', 'COST PER AUDIENCE');
			
			$cell = 2;
			foreach($data_cal as $dataes){ 
				
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$cell, $dataes[1])
					->setCellValue('B'.$cell, $dataes[2])
					->setCellValue('C'.$cell, $dataes[3])
					->setCellValue('D'.$cell, $dataes[4])
					->setCellValue('E'.$cell, $dataes[5])
					->setCellValue('F'.$cell, $dataes[6])
					->setCellValue('G'.$cell, $dataes[7])
					->setCellValue('H'.$cell, $dataes[8])
					->setCellValue('I'.$cell, $dataes[9])
					->setCellValue('J'.$cell, $dataes[10])
					->setCellValue('I'.$cell, $dataes[11]); 
			
				$cell++;
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('Ads Replacement Summary');
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
		
		$objWriter->save('/data/opep/srcs/html/tmp_doc/cal_print.xls');
	}
	
	public function print_summary(){
		
		$spot_com = $this->Anti_si($this->input->post('spot_com',true)); 
		$spot_com2 = $this->Anti_si($this->input->post('spot_com2',true)); 
		$cost_com = $this->Anti_si($this->input->post('cost_com',true)); 
		$cost_com2 = $this->Anti_si($this->input->post('cost_com2',true)); 
		$tvred_com = $this->Anti_si($this->input->post('tvred_com',true)); 
		$tvred_com2 = $this->Anti_si($this->input->post('tvred_com2',true)); 
		$maxtvr_com = $this->Anti_si($this->input->post('maxtvr_com',true)); 
		$maxtvr_com2 = $this->Anti_si($this->input->post('maxtvr_com2',true)); 
		$mintvr_com = $this->Anti_si($this->input->post('mintvr_com',true)); 
		$mintvr_com2 = $this->Anti_si($this->input->post('mintvr_com2',true)); 
		$avgtvr_com = $this->Anti_si($this->input->post('avgtvr_com',true)); 
		$avgtvr_com2 = $this->Anti_si($this->input->post('avgtvr_com2',true)); 
		$cprp1_com = $this->Anti_si($this->input->post('cprp1_com',true)); 
		$cprp1_com2 = $this->Anti_si($this->input->post('cprp1_com2',true)); 
		$sel_spot = $this->Anti_si($this->input->post('sel_spot',true)); 
		$sel_cost = $this->Anti_si($this->input->post('sel_cost',true)); 
		$sel_cprp = $this->Anti_si($this->input->post('sel_cprp',true)); 
		
		$cpv_com = $this->Anti_si($this->input->post('cpv_com',true)); 
		$cpv_com2 = $this->Anti_si($this->input->post('cpv_com2',true)); 
		$sel_apv = $this->Anti_si($this->input->post('sel_apv',true)); 
		$aku_apv = $this->Anti_si($this->input->post('aku_apv',true)); 
		
		$aku_spot = $this->Anti_si($this->input->post('aku_spot',true)); 
		$costa3 = $this->Anti_si($this->input->post('costa3',true)); 
		$costb3 = $this->Anti_si($this->input->post('costb3',true)); 
		$cprpa3 = $this->Anti_si($this->input->post('cprpa3',true)); 
		$cprpb3 = $this->Anti_si($this->input->post('cprpb3',true)); 
		$aku_cost = $this->Anti_si($this->input->post('aku_cost',true)); 
		$aku_cprp = $this->Anti_si($this->input->post('aku_cprp',true)); 
		$sel_tottvr = $this->Anti_si($this->input->post('sel_tottvr',true)); 
		$aku_tottvr = $this->Anti_si($this->input->post('aku_tottvr',true)); 
		$sel_maxtvr = $this->Anti_si($this->input->post('sel_maxtvr',true)); 
		$aku_maxtvr = $this->Anti_si($this->input->post('aku_maxtvr',true)); 
		$sel_mintvr = $this->Anti_si($this->input->post('sel_mintvr',true)); 
		$aku_mintvr = $this->Anti_si($this->input->post('aku_mintvr',true)); 
		$sel_avgtvr = $this->Anti_si($this->input->post('sel_avgtvr',true)); 
		$aku_avgtvr = $this->Anti_si($this->input->post('aku_avgtvr',true)); 
		
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
					->setCellValue('A1', 'Deskripsi')
					->setCellValue('B1', 'Mediaplan')
					->setCellValue('C1', 'Placement Ads')
					->setCellValue('D1', 'Selisih') 
					->setCellValue('E1', 'Akurasi (%)')
					->setCellValue('A2', 'Total Spot')
					->setCellValue('A3', 'Total Cost')
					->setCellValue('A4', 'Total TVR')
					->setCellValue('A5', 'Maximum TVR')
					->setCellValue('A6', 'Minimum TVR')
					->setCellValue('A7', 'Average TVR')
					->setCellValue('A8', 'CPRP')
					->setCellValue('A9', 'Cost per Audience');
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('B2', $spot_com)
					->setCellValue('C2', $spot_com2)
					->setCellValue('B3', $cost_com)
					->setCellValue('C3', $cost_com2)
					->setCellValue('B4', $tvred_com)
					->setCellValue('C4', $tvred_com2)
					->setCellValue('B5', $maxtvr_com)
					->setCellValue('C5', $maxtvr_com2)
					->setCellValue('B6', $mintvr_com)
					->setCellValue('C6', $mintvr_com2)
					->setCellValue('B7', $avgtvr_com)
					->setCellValue('C7', $avgtvr_com2)
					->setCellValue('B8', $cprp1_com)
					->setCellValue('C8', $cprp1_com2)
					->setCellValue('B9', $cpv_com)
					->setCellValue('C9', $cpv_com2);
					
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('D2', str_replace('.',',',$sel_spot))
					->setCellValue('E2', str_replace('.',',',$aku_spot))
					->setCellValue('D3', $sel_cost)
					->setCellValue('E3', str_replace('.',',',$aku_cost))
					->setCellValue('D4', str_replace('.',',',$sel_tottvr))
					->setCellValue('E4', str_replace('.',',',$aku_tottvr))
					->setCellValue('D5', str_replace('.',',',$sel_maxtvr))
					->setCellValue('E5', str_replace('.',',',$aku_maxtvr))
					->setCellValue('D6', str_replace('.',',',$sel_mintvr))
					->setCellValue('E6', str_replace('.',',',$aku_mintvr))
					->setCellValue('D7', str_replace('.',',',$sel_mintvr))
					->setCellValue('E7', str_replace('.',',',$aku_avgtvr))
					->setCellValue('D8', $sel_cprp)
					->setCellValue('E8', str_replace('.',',',$aku_cprp))
					->setCellValue('D9', $sel_apv)
					->setCellValue('E9', $aku_apv); 

					
					$objPHPExcel->getActiveSheet()->setTitle('Ads Replacement Summary');
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
		
		$objWriter->save('/data/opep/srcs/html/tmp_doc/cal_print_summary.xls');
					
	}
	
	
	
	public function list_calander()
	{	
		if( !empty($this->Anti_si($_GET['start_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		if( !empty($this->Anti_si($_GET['start_date_ads'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date_ads']));
			$start_date_ads = $date->format('d/m/Y');
		} else {
			$start_date_ads = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['end_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( !empty($this->Anti_si($_GET['end_date_ads'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date_ads']));
			$end_date_ads = $date->format('d/m/Y');
		} else {
			$end_date_ads = NULL;
		}

		if( !empty($this->Anti_si($_GET['cost'])) ) {
			$cost = $this->Anti_si($_GET['cost']);
		} else {
			$cost = NULL;
		}	
		
		if( !empty($this->Anti_si($_GET['discount'])) ) {
			$discount = $this->Anti_si($_GET['discount']);
		} else {
			$discount = 0;
		}	
		
		if( !empty($this->Anti_si($_GET['profile'])) ) {			
			if($this->Anti_si($_GET['profile']) == "all"){
				$profiles = "0";
			}else{
				$profiles = $this->Anti_si($_GET['profile']);
			}
		} else {
			$profiles = "0";
		}
     
		$high_tvr = $_GET['high_tvr'];	
		$maximum_cost = $_GET['maximum_cost'];	
		$minimum_cprp = $_GET['minimum_cprp'];		
		$index = $_GET['index'];
		$maximum_reach = $_GET['maximum_reach'];
		
		$ordernya = '';
		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 
		$order_fields = array('date', 'channel', 'program', 'level1', 'level2', 'tvr', 'tvs', 'cprp', 'cost');
				
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
		
		$search = $this->Anti_si($this->input->get_post('search'));		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}	
			
		$cs = 0;
		if($high_tvr == 1){
			$cs = 4;
		}
     
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$params['start_date'] 	= $start_date;
		$params['start_date_ads'] 	= $start_date_ads;
		$params['end_date'] 	= $end_date;
		$params['end_date_ads'] 	= $end_date_ads;
		$params['cost']			= $cost;
		$params['discount']		= 100-$discount;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['maximum_reach']	= $maximum_reach; 
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['channel']	= $_GET['channel']; 
		
		
		$list = $this->mediaplanningu_model->list_planning_cal($params);


		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();	
		$in = 0;
		foreach ( $list['data'] as $k => $v ) { 
				$cprp = number_format($v['CPRP'], 0, ",", ".");			
					$cost = $v['RATE']*1000;
					$tvs = $v['TVS'];
					$index = $v['IDX']*100;
					
					$time = explode('/',$v['DATE']);
					$reach = $cost / $v['VIEWER'];
					$newformat = $time[2].'-'.$time[1].'-'.$time[0];
					
			array_push($data, 
				array(
					$in,
					$newformat,
					$v['CHANNEL'],	
					$v['PROGRAM'],					
					$newformat.' '.$v['START_TIME'],					
					$newformat.' '.$v['END_TIME'],					
					$v['TYPE'],					
					number_format($v['TVR'],2, ",", "."),
					number_format($tvs,2, ",", "."),
					$cprp,
					number_format($cost,0, ",", "."),
					number_format($reach,2, ",", "."),
					number_format($index,0, ",", "."),
					$v['COLOR']
				)
			);
			
			$in++;
		}	
			
		$result["data"] = $data;
		$this->json_result($result);	
	}

	public function list_planning_sub_ads()
	{	
		if( !empty($this->Anti_si($_GET['start_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['start_date_mp'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date_mp']));
			$start_date_mp = $date->format('d/m/Y');
		} else {
			$start_date_mp = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['end_date_mp'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date_mp']));
			$end_date_mp = $date->format('d/m/Y');
		} else {
			$end_date_mp = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['end_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( !empty($this->Anti_si($_GET['cost'])) ) {
			$cost = $this->Anti_si($_GET['cost']);
		} else {
			$cost = NULL;
		}	
    
		if( !empty($this->Anti_si($_GET['profile'])) ) {	
			if($this->Anti_si($_GET['profile']) == "all"){
				$profiles = "0";
			}else{
				$profiles = $this->Anti_si($_GET['profile']);
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($this->Anti_si($_GET['discount'])) ) {
			$discount = $this->Anti_si($_GET['discount']);
		} else {
			$discount = 0;
		}	
    
		$high_tvr = $this->Anti_si($_GET['high_tvr']);	
		$maximum_cost = $this->Anti_si($_GET['maximum_cost']);	
		$minimum_cprp = $this->Anti_si($_GET['minimum_cprp']);			
		$index = $this->Anti_si($_GET['index']);		
		$maximum_reach = $this->Anti_si($_GET['maximum_reach']);

		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		$order_fields = array('channel', 'program', 'program', 'spot', 'cost', 'tvr');
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
		
		$search = $this->Anti_si($this->input->get_post('search'));		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}		
		
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$params['start_date_mp'] 	= $start_date_mp;
		$params['start_date'] 	= $start_date;
		$params['end_date_mp'] 	= $end_date_mp;
		$params['end_date'] 	= $end_date;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['maximum_reach']	= $maximum_reach; 
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];
		
		$list = $this->mediaplanningu_model->list_planning_sub_mp($params);

		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();	
		foreach ( $list['data'] as $k => $v ) {
			array_push($data, 
				array(
					$v['CHANNEL'],	
					$v['PROGRAM'],					
					$v['TYPE'],					
					$v['SPOT'],					
					$v['RATE'] = number_format($v['RATE']*1000,0, ",", "."),
					number_format($v['TVR'],2, ",", ".")			
				)
			);
		}	
	
		$result["data"] = $data;
		$this->json_result($result);	
	}
	
	public function list_planning_sub()
	{	
		if( !empty($this->Anti_si($_GET['start_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['end_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( !empty($this->Anti_si($_GET['cost'])) ) {
			$cost = $this->Anti_si($_GET['cost']);
		} else {
			$cost = NULL;
		}	
    
		if( !empty($this->Anti_si($_GET['profile'])) ) {	
			if($this->Anti_si($_GET['profile']) == "all"){
				$profiles = "0";
			}else{
				$profiles = $this->Anti_si($_GET['profile']);
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($this->Anti_si($_GET['discount'])) ) {
			$discount = $this->Anti_si($_GET['discount']);
		} else {
			$discount = 0;
		}	
    
		$high_tvr = $this->Anti_si($_GET['high_tvr']);	
		$maximum_cost = $this->Anti_si($_GET['maximum_cost']);	
		$minimum_cprp = $this->Anti_si($_GET['minimum_cprp']);			
		$index = $this->Anti_si($_GET['index']);	
		$maximum_reach = $this->Anti_si($_GET['maximum_reach']);		

		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		$order_fields = array('channel', 'program', 'program', 'spot', 'cost', 'tvr');
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
		
		$search = $this->Anti_si($this->input->get_post('search'));		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}		
		
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$params['start_date'] 	= $start_date;
		$params['end_date'] 	= $end_date;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['maximum_reach']	= $maximum_reach; 
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];
		
		$list = $this->mediaplanningu_model->list_planning_sub($params);

		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();	
		foreach ( $list['data'] as $k => $v ) {
			array_push($data, 
				array(
					$v['CHANNEL'],	
					$v['PROGRAM'],					
					$v['TYPE'],					
					$v['SPOT'],					
					$v['RATE'] = number_format($v['RATE']*1000,0, ",", "."),
					number_format($v['TVR'],2, ",", ".")			
				)
			);
		}	
	
		$result["data"] = $data;
		$this->json_result($result);	
	}

	public function list_planning_total()
	{	
		if( !empty($this->Anti_si($_GET['start_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['end_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( !empty($this->Anti_si($_GET['cost'])) ) {
			$cost = $this->Anti_si($_GET['cost']);
		} else {
			$cost = NULL;
		}
    
    if( !empty($this->Anti_si($_GET['profile'])) ) {
			if($this->Anti_si($_GET['profile']) == "all"){
				$profiles = "0";
			}else{
				$profiles = $this->Anti_si($_GET['profile']);
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($this->Anti_si($_GET['discount'])) ) {
			$discount = $this->Anti_si($_GET['discount']);
		} else {
			$discount = 0;
		}	
				
		$high_tvr = $this->Anti_si($_GET['high_tvr']);	
		$maximum_cost = $this->Anti_si($_GET['maximum_cost']);	
		$minimum_cprp = $this->Anti_si($_GET['minimum_cprp']);		
		$index = $this->Anti_si($_GET['index']);		
		$maximum_reach = $this->Anti_si($_GET['maximum_reach']);

		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		$order_fields = array('channel', 'spot', 'spot', 'cost', 'tvr');
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
		
		$search = $this->Anti_si($this->input->get_post('search'));		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}		
		
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$params['start_date'] 	= $start_date;
		$params['end_date'] 	= $end_date;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['maximum_reach']	= $maximum_reach; 
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];
		
		$list = $this->mediaplanningu_model->list_planning_total($params); 
		
    $sum = 0;

		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();	
		foreach ( $list['data'] as $k => $v ) {
			$sum+= $v['SPOT'];
			array_push($data, 
				array(
					$v['CHANNEL'],	
					$v['TYPE'],	
					$v['SPOT'],					
					$v['COSTS'] = number_format($v['COSTS']*1000,0, ",", "."),		
					number_format($v['TVRS'],2, ",", "."),
					$sum	
				)
			);
		}	
    
    $result["data"] = $data;
    $this->json_result($result);	
	}	
	
	public function list_planning_total_ads()
	{	
		if( !empty($this->Anti_si($_GET['start_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['end_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['start_date_mp'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date_mp']));
			$start_date_mp = $date->format('d/m/Y');
		} else {
			$start_date_mp = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['end_date_mp'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date_mp']));
			$end_date_mp = $date->format('d/m/Y');
		} else {
			$end_date_mp = NULL;
		}

		if( !empty($this->Anti_si($_GET['cost'])) ) {
			$cost = $this->Anti_si($_GET['cost']);
		} else {
			$cost = NULL;
		}
    
    if( !empty($this->Anti_si($_GET['profile'])) ) {
			if($this->Anti_si($_GET['profile']) == "all"){
				$profiles = "0";
			}else{
				$profiles = $this->Anti_si($_GET['profile']);
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($this->Anti_si($_GET['discount'])) ) {
			$discount = $this->Anti_si($_GET['discount']);
		} else {
			$discount = 0;
		}	
				
		$high_tvr = $this->Anti_si($_GET['high_tvr']);	
		$maximum_cost = $this->Anti_si($_GET['maximum_cost']);	
		$minimum_cprp = $this->Anti_si($_GET['minimum_cprp']);		
		$index = $this->Anti_si($_GET['index']);		
		$maximum_reach = $this->Anti_si($_GET['maximum_reach']);

		if( $this->input->get_post('draw') != FALSE )   {$draw   = $this->input->get_post('draw');}   else{$draw   = 1;}; 
		if( $this->input->get_post('length') != FALSE ) {$length = $this->input->get_post('length');} else{$length = 10;}; 
		if( $this->input->get_post('start') != FALSE )  {$start  = $this->input->get_post('start');}  else{$start  = 0;}; 				
		$order_fields = array('channel', 'spot', 'spot', 'cost', 'tvr');
		$order = $this->input->get_post('order');
		if( ! empty($order[0]['dir']))    {$order_dir    = $order[0]['dir'];}    else{$order_dir    = 'asc';}; 
		if( ! empty($order[0]['column'])) {$order_column = $order[0]['column'] + 1;} else{$order_column = 0;}; 	
		
		$search = $this->Anti_si($this->input->get_post('search'));		
		if( ! empty($search['value']) ) {
			$search_value = $search['value'];
		} else {
			$search_value = null;
		}		
		
		$params['limit'] 		= (int) $length;
		$params['offset'] 		= (int) $start;
		$params['order_column'] = $order_fields[$order_column];
		$params['order_dir'] 	= $order_dir;
		$params['filter'] 		= $search_value;
		$params['start_date'] 	= $start_date;
		$params['start_date_mp'] 	= $start_date_mp;
		$params['end_date'] 	= $end_date;
		$params['end_date_mp'] 	= $end_date_mp;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['maximum_reach']	= $maximum_reach; 
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];
		
		$list = $this->mediaplanningu_model->list_planning_total_ads($params); 
		
    $sum = 0;

		$result["recordsTotal"] = $list['total'];
		$result["recordsFiltered"] = $list['total_filtered'];
		$result["draw"] = $draw;
		$data = array();	
		foreach ( $list['data'] as $k => $v ) {
			$sum+= $v['SPOT'];
			array_push($data, 
				array(
					$v['CHANNEL'],	
					$v['TYPE'],	
					$v['SPOT'],					
					$v['COSTS'] = number_format($v['COSTS']*1000,0, ",", "."),		
					number_format($v['TVRS'],2, ",", "."),
					$sum	
				)
			);
		}	
    
    $result["data"] = $data;
    $this->json_result($result);	
	}	
	
	public function list_planning_grandtotal()
	{	
    if( ! empty($this->Anti_si($_GET['start_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( ! empty($this->Anti_si($_GET['end_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( ! empty($this->Anti_si($_GET['cost'])) ) {
			$cost = $this->Anti_si($_GET['cost']);
		} else {
			$cost = NULL;
		}	
		
		if( !empty($this->Anti_si($_GET['profile'])) ) {
			if($this->Anti_si($_GET['profile']) == "all"){
				$profiles = "0";
			}else{
				$profiles = $this->Anti_si($_GET['profile']);
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($this->Anti_si($_GET['discount'])) ) {
			$discount = $this->Anti_si($_GET['discount']);
		} else {
			$discount = 0;
		}	
		
		
		$high_tvr = $this->Anti_si($_GET['high_tvr']);	
		$maximum_cost = $this->Anti_si($_GET['maximum_cost']);	
		$minimum_cprp = $this->Anti_si($_GET['minimum_cprp']);			
		$index = $this->Anti_si($_GET['index']);	
		$maximum_reach = $this->Anti_si($_GET['maximum_reach']);		

		$params['start_date'] 	= $start_date;
		$params['end_date'] 	= $end_date;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['maximum_reach']	= $maximum_reach; 
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];

		$list = $this->mediaplanningu_model->list_planning_grandtotal($params);
		

		$spot = 0;
		$cost = 0;
		$tvr = 0;
		
		foreach ( $list as $k => $v ) {
			$spot+= $v['SPOT'];
			$cost+=  $v['RATE']*1000;			
			$tvr+= $v['TVR'];
		}
		
		$cost = number_format($cost, 0,",",".");
		
		$data = array(
					'spot' => $spot,
					'cost' => $cost,
					'tvr' => number_format($tvr,2,",",".")				
    );		

    $result = array('success' => true, 'data' => $data);
    $this->json_result($result);
	}	
	
	public function list_planning_grandtotal_ads()
	{	
    if( ! empty($this->Anti_si($_GET['start_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( ! empty($this->Anti_si($_GET['end_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( ! empty($this->Anti_si($_GET['start_date_mp'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date_mp = $date->format('d/m/Y');
		} else {
			$start_date_mp = NULL;
		}
		
		if( ! empty($this->Anti_si($_GET['end_date_mp'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date_mp = $date->format('d/m/Y');
		} else {
			$end_date_mp = NULL;
		}

		if( ! empty($this->Anti_si($_GET['cost'])) ) {
			$cost = $this->Anti_si($_GET['cost']);
		} else {
			$cost = NULL;
		}	
		
		if( !empty($this->Anti_si($_GET['profile'])) ) {
			if($this->Anti_si($_GET['profile']) == "all"){
				$profiles = "0";
			}else{
				$profiles = $this->Anti_si($_GET['profile']);
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($this->Anti_si($_GET['discount'])) ) {
			$discount = $this->Anti_si($_GET['discount']);
		} else {
			$discount = 0;
		}	
		
		
		$high_tvr = $_GET['high_tvr'];	
		$maximum_cost = $_GET['maximum_cost'];	
		$minimum_cprp = $_GET['minimum_cprp'];			
		$index = $_GET['index'];		
		$maximum_reach = $_GET['maximum_reach'];

		$params['start_date'] 	= $start_date;
		$params['end_date'] 	= $end_date;
		$params['start_date_mp'] 	= $start_date_mp;
		$params['end_date_mp'] 	= $end_date_mp;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['maximum_reach']	= $maximum_reach; 
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];

		$list = $this->mediaplanningu_model->list_planning_grandtotal_ads($params);
		

		$spot = 0;
		$cost = 0;
		$tvr = 0;
		
		foreach ( $list as $k => $v ) {
			$spot+= $v['SPOT'];
			$cost+=  $v['RATE']*1000;			
			$tvr+= $v['TVR'];
		}
		
		$cost = number_format($cost, 0,",",".");
		
		$data = array(
					'spot' => $spot,
					'cost' => $cost,
					'tvr' => number_format($tvr,2,",",".")				
    );		

    $result = array('success' => true, 'data' => $data);
    $this->json_result($result);
	}	
	
	public function list_planning_rest()
	{	
		if( !empty($this->Anti_si($_GET['start_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( !empty($this->Anti_si($_GET['end_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( !empty($this->Anti_si($_GET['cost'])) ) {
			$cost = $this->Anti_si($_GET['cost']);
		} else {
			$cost = NULL;
		}	
		
    if( !empty($this->Anti_si($_GET['profile'])) ) {
			if($this->Anti_si($_GET['profile']) == "all"){
				$profiles = "0";
			}else{
				$profiles = $this->Anti_si($_GET['profile']);
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($this->Anti_si($_GET['discount'])) ) {
			$discount = $this->Anti_si($_GET['discount']);
		} else {
			$discount = 0;
		}	
    
		$high_tvr = $this->Anti_si($_GET['high_tvr']);	
		$maximum_cost = $this->Anti_si($_GET['maximum_cost']);	
		$minimum_cprp = $this->Anti_si($_GET['minimum_cprp']);			
		$index = $this->Anti_si($_GET['index']);	
		$maximum_reach = $this->Anti_si($_GET['maximum_reach']);		

		$params['start_date'] 	= $start_date;
		$params['end_date'] 	= $end_date;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['maximum_reach']	= $maximum_reach; 
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];
		
		$list = $this->mediaplanningu_model->list_planning_rest($params);

		$sum = 0;
		$cost = 0;
		$mincprp = 0;
		$cprp = 0;
		$total_tvr = 0;
		$cpv = 0;
		
		$tvr = array();
		$totaltvr = 0;
		
		if(count($list)==0){
        $data = array(
        		'maxtvr' => 0.00,
        		'mintvr' => 0.00,
        		'avgtvr' => 0.00,
				'cprp1'	=>	0,
				'cpv' => 0.00,
        );
		}else{ 
			foreach ( $list as $k => $v ) {
				$total_tvr += $v['TVR'];
				$tvr[$k] = $v['TVR'];
				$cost += $v['RATE']*1000;
				$totaltvr+= $v['TVR']; 
				$cprp += $v['CPRP'];
				$cpv += $v['REACH'];
        
				$sum+= 1;
			}
			
			$data = array(
						'maxtvr' => number_format(max($tvr),2,",","."),
						'mintvr' => number_format(min($tvr),2,",","."),
						'avgtvr' => number_format($totaltvr/$sum,2,",","."),
						'cprp1'	=>	number_format($cost/$totaltvr,0,",","."),
						'cpv1'	=>	number_format($cpv,2,",","."),
				);	
		}
		
		$result = array('success' => true, 'data' => $data);
		$this->json_result($result);
	}
	
	public function list_planning_rest_ads()
	{	
		if( ! empty($this->Anti_si($_GET['start_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date = $date->format('d/m/Y');
		} else {
			$start_date = NULL;
		}
		
		if( ! empty($this->Anti_si($_GET['end_date'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date = $date->format('d/m/Y');
		} else {
			$end_date = NULL;
		}

		if( ! empty($this->Anti_si($_GET['start_date_mp'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['start_date']));
			$start_date_mp = $date->format('d/m/Y');
		} else {
			$start_date_mp = NULL;
		}
		
		if( ! empty($this->Anti_si($_GET['end_date_mp'])) ) {
			$dt   = new DateTime();
			$date = $dt->createFromFormat('d/m/Y', $this->Anti_si($_GET['end_date']));
			$end_date_mp = $date->format('d/m/Y');
		} else {
			$end_date_mp = NULL;
		}

		if( ! empty($this->Anti_si($_GET['cost'])) ) {
			$cost = $this->Anti_si($_GET['cost']);
		} else {
			$cost = NULL;
		}	
		
		if( !empty($this->Anti_si($_GET['profile'])) ) {
			if($this->Anti_si($_GET['profile']) == "all"){
				$profiles = "0";
			}else{
				$profiles = $this->Anti_si($_GET['profile']);
			}
		} else {
			$profiles = "0";
		}
		
		if( !empty($this->Anti_si($_GET['discount'])) ) {
			$discount = $this->Anti_si($_GET['discount']);
		} else {
			$discount = 0;
		}	
		
		
		$high_tvr = $_GET['high_tvr'];	
		$maximum_cost = $_GET['maximum_cost'];	
		$minimum_cprp = $_GET['minimum_cprp'];			
		$index = $_GET['index'];		
		$maximum_reach = $_GET['maximum_reach'];

		$params['start_date'] 	= $start_date;
		$params['start_date_mp'] 	= $start_date_mp;
		$params['end_date'] 	= $end_date;
		$params['end_date_mp'] 	= $end_date_mp;
		$params['cost']			= $cost;
		$params['high_tvr']		= $high_tvr;
		$params['maximum_cost']	= $maximum_cost;
		$params['minimum_cprp']	= $minimum_cprp;
		$params['maximum_reach']	= $maximum_reach; 
		$params['index']	= $index;
		$params['profiles']	= $profiles;
		$params['discount']		= 100-$discount;
		$params['channel']	= $_GET['channel'];
		
		$list = $this->mediaplanningu_model->list_planning_rest_ads($params);

		$sum = 0;
		$cost = 0;
		$mincprp = 0;
		$cprp = 0;
		$total_tvr = 0;
		$cpv = 0;
		
		$tvr = array();
		$totaltvr = 0;
		
		if(count($list)==0){
        $data = array(
        		'maxtvr' => 0.00,
        		'mintvr' => 0.00,
        		'avgtvr' => 0.00,
            'cprp1'	=>	0,
			'cpv' => 0.00,
        );
		}else{ 
			foreach ( $list as $k => $v ) {
				$total_tvr += $v['TVR'];
				$tvr[$k] = $v['TVR'];
				$cost += $v['RATE']*1000;
				$totaltvr+= $v['TVR']; 
				$cprp += $v['CPRP'];
				$cpv += $v['REACH'];
        
				$sum+= 1;
			}
			
			$data = array(
						'maxtvr' => number_format(max($tvr),2,",","."),
						'mintvr' => number_format(min($tvr),2,",","."),
						'avgtvr' => number_format($totaltvr/$sum,2,",","."),
            'cprp1'	=>	number_format($cost/$totaltvr,0,",","."),
			'cpv1'	=>	number_format($cpv,2,",","."),
				);	
		}
		
		$result = array('success' => true, 'data' => $data);
		$this->json_result($result);
	}		                                                                          
    
  public function profilesearch(){
      $iduser = $this->session->userdata('user_id');
      $list = $this->mediaplanningu_model->profilesearch($this->Anti_si($_GET['q']),$iduser,$this->Anti_si($_GET['f']));
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                                          
  
  public function setprofile(){
      $iduser = $this->session->userdata('user_id');
      $idrole = $this->session->userdata('id_role');
      $list = $this->mediaplanningu_model->get_profile3($iduser,$idrole,$this->Anti_si($_GET['f']));          
                               
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }                                  
    
  public function channelsearch(){
      $typerole = $this->session->userdata('type_role');
      $list = $this->mediaplanningu_model->channelsearch($this->Anti_si($_GET['q']),$typerole);
      
      if ( $list ) {			
          $this->output->set_content_type('application/json')->set_output(json_encode($list));
      } else {
          $result = array( 'Value not found!' );
          $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
  }
}
