<?php

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class usr {}

class Kas extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('kas_model', 'kas');
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
            $kas = $this->db->get('kas')->result();
            $kas_user = $this->db->get_where('user_kas', ['user_id' => $id_user])->result();

            //cek user kas
            $idKasUser = array();
            foreach($kas_user as $dataKasUser) {
                $idKasUser[] = $dataKasUser->kas_id;
            }
            
            //cek user kas sudah ada belum
            foreach($kas as $dataKas) {
                if (!in_array($dataKas->id_kas, $idKasUser)) {
                    $this->kas->insertKasbyId($id_user, $dataKas->id_kas);
                }
            }

            $response->success = true;
            $response->message = "Saldo, Kas Saldo, dan Brosur";
            $response->saldo = $this->kas->getSaldo()->saldo;
            $response->kas_saldo = $this->kas->getKasSaldo($id_user);
            $response->brosur = $this->kas->getBrosur();
        }

        $this->response($response, 200);
    }

    function index_post()
    {
        $response = new usr();
        $id_user = $this->post('id_user');

        $response->success = true;
        $response->message = "Mengirim notif";
        $response->notif     = $this->notification->pushNotification($id_user, "Pemberitahuan", "Teman-teman segera berangkat kelompok, dan jangan lupa membawa uang kas senilai Rp. 8000");

        $this->response($response, 200);
    }
}
