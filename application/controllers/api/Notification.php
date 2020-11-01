<?php

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class usr {}

class Notification extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('notification_model', 'notification');
    }

    function index_get()
    {
        $response = new usr();
        $id_user = $this->get('id_user');
        if ($id_user == '') {
            $response->message = "Kolom tidak boleh kosong";
            $response->success = false;
        } else {

            $response->success = true;
            $response->message = "Saldo, Kas Saldo, dan Brosur";
            $response->notification = $this->notification->getNotification($id_user);
        }

        $this->response($response, 200);
    }
}
