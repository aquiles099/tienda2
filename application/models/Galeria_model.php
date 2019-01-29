<?php
class Galeria_model extends CI_Model {
	public function obtenergaleriafamilia($idtipo) {
		$this->db->where('idtipo', $idtipo);
		$this->db->order_by('orden');
		$query = $this->db->get('tipoproductos_galeria');
		return $query->result();
	}

	public function obtenergaleriaproducto($idproducto) {
		$this->db->where('idproducto', $idproducto);
		$this->db->order_by('orden');
		$query = $this->db->get('productos_galeria');
		return $query->result();
	}
}
