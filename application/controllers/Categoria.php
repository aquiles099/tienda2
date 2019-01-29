<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends MY_Controller {

	public function index($ruta, $url_marca = null) {
		$categoria = $this->Productos_model->obtenercategoriaporruta($ruta);
		$familias = $this->Parametros_model->param('tienda/usarfamilias');
		$hide_stock = $this->Parametros_model->param('tienda/ocultarproductos');
		$usar_marcas = $this->Parametros_model->param('tienda/usar_marcas');
		$mostrar_iva = $this->Parametros_model->param('tienda/mostrarIva');
		$url_attr = $this->input->get('attr');
		$url_vls = $this->input->get('vls');
		if ($categoria) {
			if ($usar_marcas){
				// Se obtienen las marcas relacionadas a productos dentro de la categoría seleccionada
				$marcas = $this->Productos_model->obtenermarcasporcategoria($categoria->id, $hide_stock);
				$this->data['marcas'] = $marcas;
			}

			// Se obtienen los atributos de productos relacionados a la categoría
			$atributos = $this->Productos_model->obteneratributosporcategoria($categoria->id);
			if (!empty($atributos)) {
				$this->data['atributos'] = $atributos;

				// Se obtienen los tipos de atributos
				foreach ($atributos as $key => $atributo) {
					$tipos_atributos[$atributo->id] = $this->Productos_model->obtenertiposatributos($atributo->id);
				}
				$this->data['tipos_atributos'] = $tipos_atributos;
			}

			if (!empty($url_marca)){
				$lamarca = $this->Productos_model->obtenermarcaporruta($url_marca);
				$this->data['lamarca'] = $lamarca;
			}

			if (!empty($url_attr) && !empty($url_vls)) {
				$url_attr = explode("_", $url_attr);
				$url_vls = explode("_", $url_vls);
				list($arr_atributos_valores, $arr_valores) = $this->Productos_model->obteneratributosporurl($url_attr,$url_vls);
				$this->data['arr_atributos_valores'] = $arr_atributos_valores;
			}

			$productos = $this->Productos_model->obtenerporcategoria($categoria->id, $familias, $hide_stock, (!empty($url_marca))? $lamarca->id : null, (!empty($arr_valores))? $arr_valores : null, (!empty($mostrar_iva)) ? $mostrar_iva : false);
			//$this->data['last_query'] = $this->db->last_query();
			$this->data['lacategoria'] = $categoria;
			// Preparar breadcrumbs
			if (!empty($lamarca)) {
				$breadcrumbs[] = ['title' => $lamarca->marca];
				$breadcrumbs[] = ['url' => base_url("categoria/$categoria->ruta"), 'title' => $categoria->categoria];
			}else{
				$breadcrumbs[] = ['title' => $categoria->categoria];
			}

			$parent = $categoria;
			while ($parent->parent) {
				$parent = $this->Productos_model->obtenercategoria($parent->parent);
				$breadcrumbs[] = ['url' => base_url("categoria/$parent->ruta"), 'title' => $parent->categoria];
			}

			krsort($breadcrumbs);
		}
		$categorias = $this->Productos_model->obtenercategorias($categoria->id);
		$this->data['categorias'] = $categorias ?: $this->Productos_model->obtenercategorias();
		$this->data['breadcrumbs'] = $breadcrumbs;
		$this->data['productos'] = $productos;
		$this->data['idcategoria'] = $categoria->id;
		$this->data['url_marca'] = $url_marca;
		$this->data['view'] = 'categoria';
		$this->load->view('layout', $this->data);
	}
}
