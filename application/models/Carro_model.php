<?php
class Carro_model extends CI_Model {
	public function carro() {
		$carro = $this->session->userdata('carro');
		if (!$carro) $carro = [];
		return $carro;
	}

	public function agregarproducto($idproducto, $cantidad) {
		$this->cantidadproducto($idproducto, $cantidad, true);
	}

	public function quitarproducto($idproducto) {
		$carro = $this->carro();
		if (isset($carro[$idproducto])) {
			unset($carro[$idproducto]);
		}
		$this->session->set_userdata('carro', $carro);
	}

	public function cantidadproducto($idproducto, $cantidad, $sumar = false) {
	    $carro = $this->carro();
	    if (isset($carro[$idproducto])) {
	        if ($sumar) {
	            $carro[$idproducto]->cantidad += $cantidad;
	        } else {
	            $carro[$idproducto]->cantidad = $cantidad;
	        }
	    } else {
	        $this->load->model('Productos_model');
	        $this->load->model('Parametros_model');
	        $familias = $this->Parametros_model->param('tienda/usarfamilias');
	        $listadeprecios = $this->Parametros_model->param('tienda/listadeprecios');
			$mostrar_iva = $this->Parametros_model->param('tienda/mostrarIva');
	        $producto = $this->Productos_model->obtenerproducto($idproducto,$familias,(!empty($mostrar_iva)) ? $mostrar_iva : false);
	        $carro[$idproducto] = (object) [
	            'foto' => $producto->thumb(),
	            'descripcion' => $producto->descripcion,
	            'ruta' => $producto->ruta(),
	            'cantidad' => $cantidad
	        ];
	        if ($listadeprecios) {
	            $carro[$idproducto]->precio = $producto->$listadeprecios;
	        }
	    }
	    $this->session->set_userdata('carro', $carro);
	}

	public function productosencarro() {
		$carro = $this->carro();
		$total = 0;
		foreach ($carro as $producto) {
			$total += $producto->cantidad;
		}
		return $total;
	}

	public function vaciarcarro() {
		$carro = [];
		$this->session->set_userdata('carro', $carro);
	}

	public function total() {
		$carro = $this->carro();
		$total = 0;
		foreach ($carro as $producto) {
			$total += $producto->cantidad * $producto->precio;
		}
		return $total;
	}
}
