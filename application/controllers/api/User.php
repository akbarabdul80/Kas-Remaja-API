<?php

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class usr {}

class User extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('user_model', 'user');
    }

    function edit_post()
    {
        $response = new usr();

        $id_user = $this->post('id_user');
        $fullname = $this->post('fullname');
        $phone = $this->post('phone');
        $email = $this->post('email');

        if ($fullname == '') {
            $response->message = "Kolom tidak boleh kosong";
            $response->success = false;
        } else {
            if ($this->user->updateUser($id_user, $fullname, $phone, $email)) {
                $response->success = true;
                $response->message = "Sukses edit profile";
                $response->data = $this->user->getUserById($id_user);
            }else{
                $response->message = "Silahkan coba lagi nanti";
                $response->success = false;
            }
        }

        $this->response($response, 200);
    }

    function password_post()
    {
        $response = new usr();

        $id_user = $this->post('id_user');
        $oldpass = $this->post('oldpass');
        $newpass = $this->post('newpass');
        $repass = $this->post('repass');

        if ($id_user == null or $oldpass == null or $newpass == null or $repass == null) {
            $response->message = "Kolom tidak boleh kosong";
            $response->success = false;
        }elseif ($newpass != $repass){
            $response->message = "Password tidak sama";
            $response->success = false;
        } else {
            $user = $this->db->get_where('user', ['id_user' => $id_user])->row();
            if (!empty($user->username)) {
                $isPasswordTrue = password_verify($this->post('oldpass'), $user->password);
                if ($isPasswordTrue) {
                    if ($this->user->updatePass($id_user, $newpass)) {
                        $response->success = true;
                        $response->message = "Sukses edit password";
                    }else{
                        $response->message = "Silahkan coba lagi nanti";
                        $response->success = false;
                    }
                } else {
                    $response->success = false;
                    $response->message = "Tolong cek password anda!";
                }
            } else {
                $response->success = false;
                $response->message = "Anda siapa jangan main-main disini";
            }
        }

        $this->response($response, 200);
    }
}
