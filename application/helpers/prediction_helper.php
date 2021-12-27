<?php
    function get_visible_class($key){
        switch ($key) {
            case 0:
                $visible_class = 'visible first';
                break;
            case 1:
                $visible_class = 'second';
                break;
            case 2:
                $visible_class = 'third';
                break;
            default:
                $visible_class = '';
        }
        return $visible_class;
    }

    /*function get_current_price($prediction_data){
        // print_r($prediction_data);die;
        if ($current_datetime >= $prediction_data['start_date'] && $current_datetime <= $prediction_data['fpt_end_datetime']){
            $current_price = $prediction_data['current_price'];
        }else if ($prediction_data['agreed']=='0') {
            $current_price = $prediction_data['current_price'];
        }else{
            $current_price = $prediction_data['current_price']; 
        }
        return $current_price;
    }*/

    function predictionClassDetails($prediction){
        $price_diff = $prediction['swipe_status']=='disagreed' || $prediction['wrong_prediction']=='1' ? '0' : $prediction['current_price']-$prediction['executed_points'];
        $price_fontColor = $price_diff<0 ? 'text-danger' : '';
        $buttonName =  $prediction['end_date']<date('Y-m-d H:i:s') ? 'Completed' : ($prediction['swipe_status']=='agreed' ? 'Change to No' : 'Change to YES');
        $popup =  $prediction['end_date']<date('Y-m-d H:i:s') ? 'Completed' : ($prediction['swipe_status']=='agreed' ? 'Are You Sure You Want To Change The Prediction To No ?' : 'Are You Sure You Want To Change The Prediction To Yes ?');
        $condition =  $prediction['end_date']<date('Y-m-d H:i:s') ? 'Completed' : ($prediction['swipe_status']=='agreed' ? 'No' : 'Yes');
        $className =  $prediction['end_date']<date('Y-m-d H:i:s') ? 'border-green' : ($prediction['swipe_status']=='disagreed' ? 'bg-blue' : '');

        $result = array('price_diff' => number_format((float)$price_diff, 2, '.', ''),
                        'price_fontColor' => $price_fontColor,
                        'buttonName' => $buttonName,
                        'popup' => $popup,
                        'className' => $className,
                        'condition' => $condition,
                    );

        return $result;
    }

    function get_possibility_percentage($prediction){
        if ($prediction['agreed'] > 0) {
            $TotalCount = $prediction['agreed'] + $prediction['disagreed'];
            $total_percentage =  $prediction['agreed'] * 100 / $TotalCount;
        }else{
            $total_percentage = '0';
        }

        if ($total_percentage <= 30) {
            $data['textPossibility'] = 'Low Predictor Interest';
            $data['fontClass'] = 'low-predect';
        }elseif($total_percentage > 30 && $total_percentage < 75){
            $data['textPossibility'] = 'Moderate Predictor Interest';
            $data['fontClass'] = 'mod-predect';
        }else{
            $data['textPossibility'] = 'High Predictor Interest';
            $data['fontClass'] = 'high-predect';
        }
        return $data;
        
    }

    function check_cookie($rewards_sess_cookie,$rewards_no_sess_cookie,$rewards_view_game_cookie,$user_id){

        if (empty($user_id) && empty($rewards_no_sess_cookie)) {    
            return true;
        }else if(!empty($user_id) && empty($rewards_no_sess_cookie) && empty($rewards_view_game_cookie)){
            return true;
        }else{
            return false;
        }    
    }
    
?>