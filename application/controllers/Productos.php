<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends MY_Controller {

	public function index($ruta) {
		$this->load->model('Galeria_model');
		$idproducto = preg_replace('/.*-([0-9]+)$/', '$1', $ruta);
		$familias = $this->Parametros_model->param('tienda/usarfamilias');
		$hide_stock = $this->Parametros_model->param('tienda/ocultarproductos');
		$mostrar_iva = $this->Parametros_model->param('tienda/mostrarIva');
		$producto = $this->Productos_model->obtenerproducto($idproducto, $familias, (!empty($mostrar_iva)) ? $mostrar_iva : false);
		if ($familias) {
			$this->data['productos'] = $this->Productos_model->obtenerportipo($producto->tipo, $hide_stock, (!empty($mostrar_iva)) ? $mostrar_iva : false);
		}
		$breadcrumbs[] = ['title' => $producto->nombre];
		$idcat = empty($producto->tipoidcat) ? $producto->idcategoria : $producto->tipoidcat;
		if ($idcat) {
			$categoria = $this->Productos_model->obtenercategoria($idcat);
			if ($categoria) {
				// Preparar breadcrumbs
				$breadcrumbs[] = ['url' => base_url("categoria/$categoria->ruta"), 'title' => $categoria->categoria];
				$parent = $categoria;
				while ($parent->parent) {
					$parent = $this->Productos_model->obtenercategoria($parent->parent);
					$breadcrumbs[] = ['url' => base_url("categoria/$parent->ruta"), 'title' => $parent->categoria];
				}
				krsort($breadcrumbs);
			}
		}
		if ($familias) {
			$this->data['fotos'] = $this->Galeria_model->obtenergaleriafamilia($producto->tipo);
		} else {
			$this->data['fotos'] = $this->Galeria_model->obtenergaleriaproducto($idproducto);
		}
		$this->data['categorias'] = $this->Productos_model->obtenercategorias();
		$this->data['breadcrumbs'] = $breadcrumbs;
		$this->data['elproducto'] = $producto;
		$this->data['view'] = 'producto';
		$this->load->view('layout', $this->data);
	}

	public function agregar($idproducto) {
		if (!$idproducto) return;
		$this->load->model('Carro_model');
		$cantidad = $this->input->get_post('cantidad') ?: 1;
		$this->Carro_model->agregarproducto($idproducto, $cantidad);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode([
			'productosencarro' => $this->Carro_model->productosencarro(),
			'success' => 'Producto agregado correctamente'
		]));
	}

	public function quitar($idproducto) {
	    if (!$idproducto) return;
	    $this->load->model('Carro_model');
	    $this->Carro_model->quitarproducto($idproducto);
	    $this->output->set_content_type('application/json');
	    $this->output->set_output(json_encode([
	        'productosencarro' => $this->Carro_model->productosencarro(),
	        'total' => $this->Carro_model->total(),
	        'success' => 'Producto quitado correctamente'
	    ]));
	}

	public function cantidad($idproducto) {
	    if (!$idproducto) return;
	    $this->load->model('Carro_model');
	    $cantidad = $this->input->get_post('cantidad') ?: 1;
	    $this->Carro_model->cantidadproducto($idproducto, $cantidad);
	    $this->output->set_content_type('application/json');
	    $this->output->set_output(json_encode([
	        'productosencarro' => $this->Carro_model->productosencarro(),
	        'total' => $this->Carro_model->total(),
	        'success' => 'Producto actualizado correctamente'
	    ]));
	}

	public function buscar() {
		$this->load->model('Productos_model');
		$string = $_GET['term'];
		$hide_stock = $this->Parametros_model->param('tienda/ocultarproductos');
		$data = $this->Productos_model->buscarProductoNombre($string, $hide_stock);
		echo json_encode($data);
	}

	public function search() {
		$this->load->model('Productos_model');
		$buscar_str = $this->input->get('buscar');
		$familias = $this->Parametros_model->param('tienda/usarfamilias');
		$hide_stock = $this->Parametros_model->param('tienda/ocultarproductos');
		$mostrar_iva = $this->Parametros_model->param('tienda/mostrarIva');
		$productos = $this->Productos_model->obtenerProductos($buscar_str, $familias, $hide_stock, (!empty($mostrar_iva)) ? $mostrar_iva : false);
		$this->data['last_query'] = $this->db->last_query();
		$breadcrumbs[] = ['title' => "Resultados"];
		krsort($breadcrumbs);
		$this->data['titulo'] = "Resultados de la búsqueda";
		$this->data['categorias'] = $this->Productos_model->obtenercategorias();
		$this->data['breadcrumbs'] = $breadcrumbs;
		$this->data['productos'] = $productos;
		$this->data['view'] = 'busqueda';
		$this->load->view('layout', $this->data);
	}
}
