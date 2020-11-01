<?php

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class usr {}

class Login extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
    }

    // validasi member
    function index_post()
    {
        $response = new usr();
        $username = $this->post('username');
        $password = $this->post('password');
        if ($username == '' && $password == '') {
            $response->message = "Kolom tidak boleh kosong";
            $response->success = 0;
            $error_code = 200;

        } else {
            $user = $this->db->get_where('user', ['username' => $username])->row();
            if (!empty($user->username)) {
                $isPasswordTrue = password_verify($this->post('password'), $user->password);
                if ($isPasswordTrue) {
                    $response->success = true;
                    $response->message = "Berhasil Login";
                    $response->data = $user;
                    $error_code = 200;
                } else {
                    $response->success = false;
                    $response->message = "Tolong Cek username dan password";
                    $error_code = 200;
                }
            } else {
                $response->success = false;
                $response->message = "Tolong Cek username dan password";
                $error_code = 200;
            }
        }

        $this->response($response, $error_code);
    }
}
