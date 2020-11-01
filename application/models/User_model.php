<?php

class User_model extends CI_Model
{
    private $_table = 'user';

    
    public function updateUser($id_user, $fullname, $phone, $email)
    {
        $this->fullname = $fullname;
        $this->phone = $phone;
        $this->email = $email;
        if ($this->db->update($this->_table, $this, ['id_user' => $id_user])) {
            return true;
        }else{
            return false;
        }
    }

    public function updatePass($id_user, $pass)
    {
        $this->password = password_hash($pass, PASSWORD_DEFAULT);
        if ($this->db->update($this->_table, $this, ['id_user' => $id_user])) {
            return true;
        }else{
            return false;
        }
    }

    public function getUserById($id)
    {
        return $this->db->get_where($this->_table, ['id_user' => $id])->row();
    }

}