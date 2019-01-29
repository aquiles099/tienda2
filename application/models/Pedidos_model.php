<?php
class Pedidos_model extends CI_Model {
	public function guardarpedido($checkout) {
	    $this->load->model('Carro_model');
	    $this->db->set('importe', $this->Carro_model->total());
	    $this->db->set('ip', $_SERVER['REMOTE_ADDR']);
	    if (!empty($checkout['guest']['idcliente'])) {
	        $this->db->set('idcliente', $checkout['guest']['idcliente']);
	    } 
 
	    $this->db->set('guest_nombre', $checkout['guest']['nombre']);
	    $this->db->set('guest_apellido', $checkout['guest']['apellido']);
		$this->db->set('guest_telefonocontacto', $checkout['guest']['telefonocontacto']);
	    $this->db->set('guest_email', $checkout['guest']['email']);
	    if (!empty($checkout['direcciones']['f_direccion'])) {
	        // Dirección facturación
	        $this->db->set('guest_f_direccion', $checkout['direcciones']['f_direccion']);
	        $this->db->set('guest_f_pais', $checkout['direcciones']['f_pais']);
	        $this->db->set('guest_f_provincia', $checkout['direcciones']['f_provincia']);
	        $this->db->set('guest_f_ciudad', $checkout['direcciones']['f_ciudad']);
	    }
		if ($this->db->insert('pedidos')) {
		    $idpedido = $this->db->insert_id();
		    // Crear presupuesto
		    $this->db->set('importe', $this->Carro_model->total());
		    $this->db->set('idpedido', $idpedido);
		    if ($this->db->insert('presupuestos')) {
			    $idpresupuesto = $this->db->insert_id();
			    // Detalle pedido
			    foreach ($this->Carro_model->carro() as $idproducto => $producto) {
			        $this->db->set('presupuestoid', $idpresupuesto);
			        $this->db->set('producto', $idproducto);
			        $this->db->set('cantidad', $producto->cantidad);
			        $this->db->set('descripcion', $producto->descripcion);
			        if (isset ($producto->precio)) {
			            $this->db->set('importe', $producto->precio);
			        }
			        $this->db->insert('detallepresupuestos');
			    }
			    return $idpresupuesto;
		    }
		}
		return false;
	}

}
