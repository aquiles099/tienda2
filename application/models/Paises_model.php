<?php
class Paises_model extends CI_Model {
	public function obtenerpaises() {
		$this->db->order_by('paisnombre');
		$query = $this->db->get('paises');
		return $query->result();
	}

	public function obtenercombopaises() {
		$paises = ['' => 'Seleccione un país'];
		foreach ($this->obtenerpaises() as $pais) {
			$paises[$pais->id] = $pais->paisnombre;
		}
		return $paises;
	}
}
