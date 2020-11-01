<?php

class Notification_model extends CI_Model
{
    private $_table = 'notification';
        
    public function getNotification($id_user)
    {
        return $this->db->get_where($this->_table, ['user_id' => $id_user])->result();
    }

    public function pushNotification($id_user, $title, $body){
        define('API_ACCESS_KEY', 'AAAA_Y-zQDg:APA91bEG89qpFJUxHXJ-zbmidXpUEmixZy1v6oQB9Or1_ea7RljC0SxTcybEoX3gHcqNW-XuNZVS-2MGHeiRjwIiiRS1-64IVKzQ3syanHU1EhT2-nNItbUaspiLrPLzjxQ_Bni6pXTY');

        $activity = "com.zerodev.kasremaja";

        $msg = array(
            'title' => $title,
            'body' => $body,
            'click_action' => $activity,
            'sound' => 'default',
        );

        $fields = array(
            'to' => '/topics/'.$id_user,
            'priority' => 'high',
            'data' => $msg,
        );

        $headers = array(
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
        curl_close( $ch );
		return json_encode($result);
    }

}