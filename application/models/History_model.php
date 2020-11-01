<?php

class History_model extends CI_Model
{
    private $_table = 'history';
    
    public function getHistory()
    {
        return $this->db->get($this->_table)->result();
    }


}