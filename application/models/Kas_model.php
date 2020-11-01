<?php

class Kas_model extends CI_Model
{
    private $_table = 'user_kas';
    private $_table_saldo = 'saldo';
    private $_table_brosur = 'brosur';

    public function insertKasbyId($id_user, $id_kas)
    {
        return $this->db->insert($this->_table, ['user_id' => $id_user, 'kas_id' => $id_kas]);
    }
    
    public function getSaldo()
    {
        return $this->db->get($this->_table_saldo)->row();
    }
        
    public function getKasSaldo($id_user)
    {
        $user_kas = $this->db->get_where($this->_table, ['user_id' => $id_user])->result();
        $kas = 0;
        foreach ($user_kas as $data) {
            $kas += $data->total;
        }
        return "$kas";
    }

    public function getBrosur(){
        $this->db->order_by("id_brosur","DESC");
        return $this->db->get($this->_table_brosur)->result();
    }

    public function getUser()
    {
        return $this->db->get_where($this->_table, ['level' => 'user'])->result();
    }

}