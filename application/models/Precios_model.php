<?php
class precios_model extends CI_Model {

    public function obtenermapadelistas() {
        $precios = array();
        $query = $this->db->get('precioslista');
        foreach ($query->result() as $row) {
            $precios[$row->id] = $row;
        }
        return $precios;
    }

    public function obtenerporcampo($campo) {
		$this->db->where('campo', $campo);
		$query = $this->db->get('precioslista');
		return $query->row();
	}

}
