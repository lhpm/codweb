<?php

class M_modelo extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // Consulta
    public function ver(){

        $consulta=$this->db->query("SELECT * FROM contactos;");

        return $consulta->result();
    }

}