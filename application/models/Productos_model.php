<?php
class Productos_model extends CI_Model {
    
	public function buscarproducto($criterio, $idproducto = null) {
		if(empty($idproducto)){
			$this->db->like ( 'descripcion', $criterio );
			$this->db->or_like ( 'codigo', $criterio );
			$this->db->order_by ( 'idproducto' );
			$this->db->limit ( 8 );
		} else {
			$this->db->where ( 'idproducto', $idproducto );
		}
        $this->db->where('status', 1);
		return $this->db->get ( 'productos' )->result_array ();
	}

	public function obtenerproducto($idproducto, $familias = false, $mostrar_iva = false) {
		$this->db->where( 'productos.idproducto', $idproducto );
		if ($familias) {
			$this->db->select('tipoproductos.nombre,
				tipoproductos.idcategoria AS tipoidcat,
				tipoproductos.descripcion_tipo,
				productos.*, g.src AS foto');
			$this->db->join('tipoproductos', 'productos.tipo = tipoproductos.id');
			$this->db->join('tipoproductos_galeria AS g', 'g.idtipo = tipoproductos.id', 'left');
			$this->db->group_by('tipoproductos.id');
		} else {
			$this->db->select('productos.*, descripcion AS nombre, g.src AS foto');
			$this->db->join('productos_galeria AS g', 'g.idproducto = productos.idproducto', 'left');
			$this->db->group_by('productos.idproducto');
		}
		$this->db->where('productos.status', 1);
		$producto = $this->db->get( 'productos' )->row(0, 'producto');

		if ($mostrar_iva) {
			// Si el cliente de NUBE desea que sus productos incluyan IVA en la Tienda ($mostrar_iva = on), se procede a sumar el IVA de cada producto
			$producto = $this->calcularivaproductos($producto);
		}

		return $producto;
	}

	public function buscarProductoNombre($term, $hide_stock = false) {
		$string = trim($term);
		$arr = explode(' ', $string);

		if (count($arr) > 1) {
			$where[] = "productos.descripcion LIKE '%$string%'";
			$where[] = "tipoproductos.nombre LIKE '%$string%'";
			$where[] = "categorias.categoria LIKE '%$string%'";
		}

		foreach ($arr as $value) {
			$where[] = "productos.descripcion LIKE '%$value%'";
			$where[] = "tipoproductos.nombre LIKE '%$value%'";
			$where[] = "categorias.categoria LIKE '%$value%'";
		}

		$this->db->where('(' . implode(' OR ', $where	) . ')');

		$this->db->select('productos.idproducto as idproducto, productos.descripcion, tipoproductos.id as id_familia,  tipoproductos.nombre, tipoproductos.descripcion_tipo, categorias.id as id_categoria, categorias.categoria');
		$this->db->join('tipoproductos', 'productos.tipo = tipoproductos.id');
		$this->db->join('categorias', 'categorias.id = tipoproductos.idcategoria');
		$this->db->where('productos.status', 1);
		$this->db->from('productos');

		if (!empty($hide_stock)) $this->db->where('productos.stock >', 0);

		$this->db->limit(10);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$data = $query->result('producto');
			foreach ($data as $key => $value) {
				$label = "";
				if (!empty($value->categoria)) {
					$label .= $value->categoria . " > ";
				}
				if (!empty($value->nombre)) {
					$label .= $value->nombre . " > ";
				}
				if (!empty($value->descripcion)) {
					$label .= $value->descripcion;
				}
				$value->ruta  = $value->ruta();
				$value->label = $label;
				$value->value = $label;
			}
			return $data;
		}
		return false;
	}

	public function obtenerProductos($term, $p_familias = false, $hide_stock = false, $mostrar_iva = false) {
		$string = trim($term);
		$arr = explode(' ', $string);

		if (count($arr) > 1) {
			$where[] = "categorias.categoria LIKE '%$string%'";
		}

		foreach ($arr as $value) {
			$where[] = "categorias.categoria LIKE '%$value%'";
		}

		if ($p_familias) {
			$this->db->select('tipoproductos.nombre, tipoproductos.idcategoria AS tipoidcat, productos.*, g.src AS foto');
			$this->db->join('tipoproductos', 'productos.tipo = tipoproductos.id');
			$this->db->join('tipoproductos_galeria AS g', 'g.idtipo = tipoproductos.id', 'left');
			$this->db->join('categorias', 'categorias.id = tipoproductos.idcategoria');
			if (count($arr) > 1) {
				$where[] = "tipoproductos.nombre LIKE '%$string%'";
			}
			foreach ($arr as $value) {
				$where[] = "tipoproductos.nombre LIKE '%$value%'";
			}
			$this->db->group_by('tipoproductos.id');
		} else {
			$this->db->select('productos.descripcion AS nombre, productos.*, g.src AS foto');
			$this->db->join('productos_galeria AS g', 'g.idproducto = productos.idproducto', 'left');
			$this->db->join('categorias', 'categorias.id = productos.idcategoria');
			if (count($arr) > 1) {
				$where[] = "productos.descripcion LIKE '%$string%'";
			}
			foreach ($arr as $value) {
				$where[] = "productos.descripcion LIKE '%$value%'";
			}
			$this->db->group_by('productos.idproducto');
		}
		$this->db->where('productos.status', 1);
		$this->db->from('productos');

		$this->db->where('(' . implode(' OR ', $where	) . ')');

		if (!empty($hide_stock)) $this->db->where('productos.stock >', 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$productos = $query->result('producto');

			if ($mostrar_iva) {
				// Si el cliente de NUBE desea que sus productos incluyan IVA en la Tienda ($mostrar_iva = on), se procede a sumar el IVA de cada producto
				$productos = $this->calcularivaproductos($productos);
			}

			return $productos;
		}

		return false;
	}

	public function actualizarutilidades() {
		if (function_exists('actualizarutilidades')) {
			actualizarutilidades();
		}
	}

	public function obtenerdestacados() {
		return null;
		// @todo: implementar destacados
	}

	public function obtenermasvistos() {
		return null;
		// @todo: implementar más vistos
	}

	public function obtenerfamilias() {
		$this->db->order_by('descripcion');
		$query = $this->db->get('tipoproductos');
		return $query->result();
	}

	public function obtenercategorias($parent = null) {
		$this->db->order_by('categoria');
		$this->db->where('parent', $parent);
		$query = $this->db->get('categorias');
		return $query->result();
	}

	public function obtenercategoria($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('categorias');
		return $query->row();
	}

	public function obtenercategoriaporruta($ruta) {
		$this->db->where('ruta', $ruta);
		$query = $this->db->get('categorias');
		return $query->row();
	}

	public function obtenerporcategoria($idcategoria, $familias = false, $hide_stock = false, $idmarca = null, $valores = null, $mostrar_iva = false) {
		if ($familias) {
			$this->db->select('tipoproductos.nombre, tipoproductos.idcategoria AS tipoidcat, productos.*, g.src AS foto');
			$this->db->join('tipoproductos', 'productos.tipo = tipoproductos.id');
			// Se requieren tres niveles de consultas anidadas para poder determinar
			// el primer elemento de la galería, dado que `orden` podría no ser = 1
			$this->db->join('(
				SELECT g.idtipo, g.src
				FROM tipoproductos_galeria AS g
				JOIN (
					SELECT idtipo, MIN(orden) AS orden
					FROM tipoproductos_galeria
					GROUP BY idtipo
				) AS m ON g.idtipo = m.idtipo AND g.orden = m.orden
			) AS g', 'g.idtipo = tipoproductos.id', 'left');
			if (!empty($valores)) {
				$this->db->join('atributos_tipoproductos AS atrtp', 'atrtp.idtipoproductos = tipoproductos.id');
				$this->db->join('atributos_productos AS atrp', 'atrp.idproducto = productos.idproducto');
			}
			$this->db->where(sprintf('%d IN(tipoproductos.idcategoria, productos.idcategoria)', $idcategoria));
			$this->db->where('tipoproductos.publicar', 1);
			if (!empty($idmarca)) $this->db->where(sprintf('%d IN (productos.idmarca, tipoproductos.idmarca)', $idmarca));
			if (!empty($hide_stock)) $this->db->where('productos.stock >', 0);
			if (!empty($valores)) $this->db->where_in('atrp.valor', $valores);
			$this->db->group_by('tipoproductos.id');
		} else {
			$this->db->select('productos.descripcion AS nombre, productos.*, g.src AS foto');
			// Se requieren tres niveles de consultas anidadas para poder determinar
			// el primer elemento de la galería, dado que `orden` podría no ser = 1
			$this->db->join('(
				SELECT g.idproducto, g.src
				FROM productos_galeria AS g
				JOIN (
					SELECT idproducto, MIN(orden) AS orden
					FROM productos_galeria
					GROUP BY idproducto
				) AS m ON g.idproducto = m.idproducto AND g.orden = m.orden
			) AS g', 'g.idproducto = productos.idproducto', 'left');
			if (!empty($valores)) $this->db->join('atributos_productos AS atrp', 'atrp.idproducto = productos.idproducto');
			$this->db->where('idcategoria', $idcategoria);
			if (!empty($idmarca)) $this->db->where('productos.idmarca', $idmarca);
			if (!empty($hide_stock)) $this->db->where('productos.stock >', 0);
			if (!empty($valores)) $this->db->where_in('atrp.valor', $valores);
			$this->db->group_by('productos.idproducto');
		}
		$this->db->where('productos.status', 1);
		$query = $this->db->get('productos');
		$productos = $query->result('producto');

		if($mostrar_iva){
			//Si el cliente de NUBE desea que sus productos incluyan IVA en la Tienda ($mostrar_iva = on), se procede a sumar el IVA de cada producto
			$productos = $this->calcularivaproductos($productos);
		}

		return $productos;
	}

	public function obtenerportipo($idtipo, $hide_stock = false, $mostrar_iva = false) {
		$this->db->select('productos.descripcion AS nombre, productos.*');
		$this->db->where('tipo', $idtipo);
		if (!empty($hide_stock)) $this->db->where('productos.stock >', 0);
		$this->db->where('productos.status', 1);
		$query = $this->db->get('productos');
		$productos = $query->result('producto');

		if($mostrar_iva){
			//Si el cliente de NUBE desea que sus productos incluyan IVA en la Tienda ($mostrar_iva = on), se procede a sumar el IVA de cada producto
			$productos = $this->calcularivaproductos($productos);
		}

		return $productos;
	}

	public function obtenermarcasporcategoria($idcategoria, $hide_stock = false) {
		$this->db->distinct();
		$this->db->select('marcas.*');
		$this->db->join('productos', 'productos.idmarca = marcas.id');
		$this->db->join('tipoproductos', 'productos.tipo = tipoproductos.id');
		$this->db->where('productos.status', 1);
		$this->db->where('tipoproductos.idcategoria', $idcategoria);
		if (!empty($hide_stock)) $this->db->where('productos.stock >', 0);
		$query = $this->db->get('marcas');
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return null;
	}

	public function obtenermarca($idmarca) {
		$this->db->where('marcas.id', $idmarca);
		$query = $this->db->get('marcas');
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}

	public function obtenermarcaporruta($idmarca) {
		$this->db->where('ruta', $idmarca);
		$query = $this->db->get('marcas');
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}

	public function obtenerfamiliaspormarcas($idmarca, $idcategoria, $familias = false, $hide_stock = null) {
		$this->db->distinct();
		$this->db->select('tipoproductos.*');
		$this->db->join('productos', 'productos.tipo = tipoproductos.id', 'left');
		if ($familias) {
			$this->db->where('tipoproductos.idcategoria', $idcategoria);
			$this->db->where('productos.idmarca', $idmarca);
			if (!empty($hide_stock)) $this->db->where('productos.stock > ', 0);
		} else {
			$this->db->where('productos.idcategoria', $idcategoria);
			$this->db->where('productos.idmarca', $idmarca);
			if (!empty($hide_stock)) $this->db->where('productos.stock > ', 0);
		}
		$this->db->where('productos.status', 1);
		$query = $this->db->get('tipoproductos');
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return null;
	}

	public function obteneratributosporcategoria($idcategoria) {
		$this->db->select('pp.*');
		$this->db->join('atributos_tipoproductos AS atrtp', 'atrtp.idatributo = pp.id');
		$this->db->join('tipoproductos AS tp', 'atrtp.idtipoproductos = tp.id');
		$this->db->where('tp.idcategoria', $idcategoria);
		$this->db->group_by('pp.id');
		$query = $this->db->get('parametrosproductos AS pp');
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return null;
	}

	public function obteneratributos($idatributo) {
		$this->db->where('id', $idatributo);
		$query = $this->db->get('parametrosproductos');
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}

	public function obtenertiposatributos($idatributo) {
		$this->db->where('idatributo', $idatributo);
		$this->db->group_by('valor');
		$query = $this->db->get('atributos_tipoproductos');
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return null;
	}

	public function obtenertipoatributo($idtipo) {
		$this->db->where('id', $idtipo);
		$query = $this->db->get('atributos_tipoproductos');
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return null;
	}

	public function obteneratributosporurl($idsatributos,$str_idsvalores) {
		foreach ($idsatributos as $key => $idatributo) {
			$atributo = $this->obteneratributos($idatributo);
			$idsvalores = explode('-', $str_idsvalores[$key]);
			$valores = array();
			foreach ($idsvalores as $k => $idvalor) {
				$valores[$k] = $this->obtenertipoatributo($idvalor);
				$str_valores[] = $valores[$k]->valor;
			}

			$atributos[] = array(
				'atributo' => $atributo,
				'valores'  => $valores
			);
		}

		return array($atributos, $str_valores);
	}

	public function calcularivaproductos($productossiniva) {
		$this->load->model('Parametros_model');
		$this->load->model('Precios_model');
		$productos = [];
		$listadeprecios = $this->Parametros_model->param('tienda/listadeprecios');
		$precio = $this->Precios_model->obtenerporcampo($listadeprecios);

		if (is_array($productossiniva)) {
			$in = $productossiniva;
		} else {
			$in = [$productossiniva];
		}
		foreach ($in as $producto) {
			$importe = $producto->$listadeprecios;
			if (!$precio->ivaincluido) {
				$importe = $importe * (1 + $producto->iva / 100);
			}
			$producto->$listadeprecios = number_format($importe, 2, '.', '');

			$productos[] = $producto;
		}

		if (is_array($productossiniva)) {
			return $productos;
		}
		return $productos[0];
	}
}

class producto {
	public function thumb() {
		if ($this->foto) {
			return base_url("assets/uploads/files/$this->foto");
		}
		return base_url('assets/img/no-foto.png');
	}

	public function ruta() {
		$acute      = 'áéíóúÁÉÍÓÚ';
		$grave      = 'àèìòùÀÈÌÒÙ';
		$umlaut     = 'äëïöüÄËÏÖÜ';
		$circumflex = 'âêîôûÂÊÎÔÛ';
		$tilde      = 'ñãõçÑÃÕÇ';
		$clean      = 'aeiouAEIOUaeiouAEIOUaeiouAEIOUaeiouAEIOUnaocnaoc';
		$search = str_split($acute . $grave . $umlaut . $circumflex . $tilde, 2);
		$replace = str_split($clean);
		$nombre = isset($this->nombre) ? trim($this->nombre) : trim($this->descripcion);
		$ruta = str_replace($search, $replace, $nombre);
		$lower = strtolower($ruta);
		$clean = preg_replace('/[^a-z0-9_\.\-]/', '-', $lower);
		return "$clean-$this->idproducto";
	}
}
