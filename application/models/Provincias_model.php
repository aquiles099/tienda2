<?php
class Provincias_model extends CI_Model {
	public function obtenerprovincias($idpais = null) {
		$this->db->order_by('provincia');
		if ($idpais) {
			$this->db->where(['idpais' => $idpais]);
		}
		$query = $this->db->get('provincias');
		return $query->result();
	}

	public function obtenercomboprovincias($idpais = null) {
		$provincias = ['' => 'Seleccione una provincia'];
		if (!$idpais) return [];
		foreach ($this->obtenerprovincias($idpais) as $provincia) {
			$provincias[$provincia->idprovincia] = $provincia->provincia;
		}
		return $provincias;
	}
}
