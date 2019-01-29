<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
abstract class MY_Controller extends CI_Controller {

	public $data = [];

	public function __construct() {
		parent::__construct();
		$this->load->model('Parametros_model');
		$this->load->model('Productos_model');
		$this->load->model('Social_model');
		$this->load->model('Banner_model');
		$this->load->model('Carro_model');
		$destacados = $this->Productos_model->obtenerdestacados();
		$masvistos = $this->Productos_model->obtenermasvistos();
		$redessociales = $this->Social_model->obtenerredes();
		$banner_sidebar = $this->Banner_model->get_banner_sidebar();
		$productosencarro = $this->Carro_model->productosencarro();
		$this->data['analytics'] = $this->config->item('analytics');
		$this->data['success'] = $this->session->flashdata('success');
		$this->data['warning'] = $this->session->flashdata('warning');
		$this->data['error'] = $this->session->flashdata('error');
		$this->data['banner_header'] = false;
		$this->data['nav'] = [];
		$this->data['masvendidos'] = [];
		$this->data['ofertas'] = [];
		$this->data['categorias'] = [];
		$this->data['logo'] = $this->Parametros_model->param('tienda/logo');
		$this->data['title'] = $this->Parametros_model->param('tienda/titulo', 'Tienda online - Nube 360');
		$this->data['footer'] = $this->Parametros_model->param('tienda/footer', 'Copyright &copy; ' . date('Y') . ' Nube 360. Todos los derechos reservados.');
		$this->data['datoscontacto'] = $this->Parametros_model->param('tienda/contacto');
		$this->data['telefonowhatsapp'] = $this->Parametros_model->param('tienda/telefonoWhatsApp');
		$this->data['banner_sidebar'] = $banner_sidebar;
		$this->data['destacados'] = $destacados;
		$this->data['masvistos'] = $masvistos;
		$this->data['redessociales'] = $redessociales;
		$this->data['listadeprecios'] = $this->Parametros_model->param('tienda/listadeprecios');
		$this->data['productosencarro'] = $productosencarro;
		$this->data['recaptcha'] = $this->config->item('recaptcha');
	}
}
