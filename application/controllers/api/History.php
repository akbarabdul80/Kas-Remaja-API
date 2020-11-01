<?php

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class usr {}

class History extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('history_model', 'history');
    }

    function index_get()
    {
        $response = new usr();
        $response->success = true;
        $response->message = "History Kas";
        $response->history = $this->history->getHistory();

        $this->response($response, 200);
    }
}
