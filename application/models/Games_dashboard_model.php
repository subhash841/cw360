<?php

class Games_dashboard_model extends CI_Model {

    public function getGame_idList($user_id) {
        $this->db->select('game_id');
        $this->db->from('points');
        $this->db->where('user_id',$user_id);
        $this->db->order_by('game_id','DESC');
        return $this->db->get()->result_array();
    }
    public function predictions_data($game_id,$user_id) {
        $this->db->select("p.id,ep.`user_id`, ep.`game_id`, ep.`prediction_id`,
            (case when ep.wrong_prediction ='0'   Then ep.`executed_points` else 0 END) as executed_points
         ,(case when ep.wrong_prediction ='0' Then p.current_price else 0 END) as current_price,ep.swipe_status,(select count(id) from predictions where game_id= $game_id) as total_predictions,p.wrong_prediction");
        $this->db->from('predictions p');
        $this->db->join('executed_predictions ep','ep.prediction_id=p.id','LEFT');
        $this->db->where('p.game_id',$game_id);
        $this->db->where('ep.user_id',$user_id);
        $predictions_data_res=$this->db->get()->result_array();
        // echo $this->db->last_query();die;
        // print_r( $predictions_data_res);die;
        $this->db->select('count(id) as total_predictions');
        $this->db->from('predictions');
        $this->db->where('game_id',$game_id);
        $res=$this->db->get()->row_array();        
        $total_predictions=$res['total_predictions'];
        $data=array();
        $agreed_array=array();
		$disagreed_array=array();
		
		foreach ($predictions_data_res as $key => $value) {
			if($value['swipe_status']=='agreed'){
				$agreed_array[]=$value;
			}else{
				$disagreed_array[]=$value;
			}
		}
		$data['total_count_executed_predictions']=count($predictions_data_res);
        $data['count_agreed']=count($agreed_array);
        $data['count_disagreed']=count($disagreed_array);
        $data['total_predictions']=!empty($predictions_data_res)?$predictions_data_res[0]['total_predictions']:$total_predictions;
        $current_price=array_sum(array_column($agreed_array, 'current_price'));
        $executed_points=array_sum(array_column($agreed_array, 'executed_points'));
        $data['current_profit']=number_format((float)$current_price-$executed_points, 2, '.', '');
        $data['not_swipped']=!empty($predictions_data_res)?$predictions_data_res[0]['total_predictions']-count($predictions_data_res):$total_predictions;
        return $data;
    }
    public function game_dashboard_data($game_id,$game_status) {       
        $this->db->select("id,topic_id,title,image,DATEDIFF(date_format(str_to_date(end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'), NOW()) ,(case when date_format(str_to_date(end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') > NOW() Then 'Active' else 'Completed' END) as game_status,DATEDIFF(date_format(str_to_date(end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'), NOW())  ,(case when date_format(str_to_date(end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') > NOW() Then 'greenActive' else 'grayActive' END) as game_status_class,date_format(str_to_date(date_format(str_to_date(end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'), '%D %b %Y %h:%i %p') as endDate,end_date");
        $this->db->from('games');
        $this->db->where('id',$game_id);
        // $this->db->where('is_published',$game_status);
        if($game_status==0){
              	$this->db->where("date_format(str_to_date(end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') BETWEEN NOW() - INTERVAL 30  DAY AND NOW()");
        }else{
        	$this->db->where("NOW() between date_format(str_to_date(start_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s') and (date_format(str_to_date(end_date, '%Y-%m-%d %H:%i:%s'), '%Y-%m-%d %H:%i:%s'))");
        }
        // $this->db->order_by('id','DESC');
        $res=$this->db->get()->row_array();
        // echo $this->db->last_query();die;
        return $res;
    }
    
}
?>
