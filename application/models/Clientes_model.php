<?php
class clientes_model extends CI_Model {



	public function registrarcliente($data,$idusuario) {
		
		$this->db->set('razonsocial', $data['nombre']." ".$data['apellido'] );
		$this->db->set('telefono', $data['telephone']);
		$this->db->set('email', $data['email']);
		$this->db->set('cuit', $data['cuit']);	
		$this->db->set('status', 1);
		$this->db->set('id_usuario_tienda', $idusuario);

		if ($this->db->insert('clientes')) {
			return $this->db->insert_id();
		}
		return false;
	}

	public function obtenercliente($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('clientes');
		$cliente = $query->row(0, 'cliente');
		return $cliente;
	}

	public function checkclientecuit($cuit) {
		$this->db->where('cuit', $cuit);
		$query = $this->db->get('clientes');
		if ($query->num_rows() > 0) {
			$datos = $query->row_array();
			return $datos['id'];
		} else {
			return false;
		}

	}

	public function setidusuariotienda($id,$idusuariotienda) {
		$this->db->set('id_usuario_tienda', $idusuariotienda);
		$this->db->where('id', $id);
		$this->db->update('clientes');
	}

}

	
