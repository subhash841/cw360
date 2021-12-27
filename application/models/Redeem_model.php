<?php

class Redeem_model extends CI_Model {

    public function insert_redeem_data(){
        $insert_array=array(
                                'user_id' =>$_POST['user_id'] ,
                                'coins' => $_POST['point_redeem'],
                                'created_date' => date("Y-m-d H:i:s"),
                             );
        // print_r($insert_array);
            if($this->db->insert('redeem_history',$insert_array)){
                $this->db->set('coins', 'coins - '.$_POST['point_redeem'], false);
                $this->db->where('user_id',$this->user_id);
                $this->db->update('coins');
                    if ($this->db->affected_rows() > 0) {
                        $insert_wallet_history = array(
                                    'user_id' => $this->user_id,
                                    'coins' => $_POST['point_redeem'],
                                    'type' => '7',//deduct coin for redemption
                                    'created_date' => date('Y-m-d H:i:s')
                                );
                        $this->db->insert('wallet_history',$insert_wallet_history);
                    }
            }
        $title="Redeemable Coins Request";
        $message ="";
            $message .= "Dear User, <br /><br />";
            $message .= "We are in receipt of your redemption request of ";
            $message .=$_POST['point_redeem'];
            $message .=" Coins.It takes us a max of 48 hours to send in the appropriate reward via e-mail and a week if it has to be sent by post.<br /><br />";
            $message .= "In case of weekends, please add a couple of days more to the turnaround time. In case you are concerned, <br />";          
            $message .= "don’t hesitate to write to us admin@crowdwisdom.live and we will respond as quickly as possible.<br /><br />";
            $message .= "Thanks and Regards,<br /><br />CrowdWisdom Team";
            $res=send_email( $_POST['email'], '', $title, $message );
            $data=explode(',', $res);

            // print_r($res);
            return true;
    }

}