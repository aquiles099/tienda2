<?php
class Social_model extends CI_Model {
	public function obtenerredes() {
		$query = $this->db->get('redessociales');
		return $query->result();
	}

	public function agregar($red, $url) {
		$this->db->set('red', $red);
		$this->db->set('url', $url);
		$this->db->insert('redessociales');
	}

	public function actualizar($red, $url) {
		$this->db->set('url', $url);
		$this->db->where('red', $red);
		$this->db->update('redessociales');
	}

	public function eliminar($red) {
		$this->db->where('red', $red);
		$this->db->delete('redessociales');
	}
}
