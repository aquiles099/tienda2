<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index()
	{
		$banner_header = $this->Banner_model->get_banner_header();
		$this->data['banner_header'] = $banner_header;
		$this->data['categorias'] = $this->Productos_model->obtenercategorias();
		$this->data['view'] = 'home';
		$this->data['usuario'] = isset($this->session->userdata('user')['usuario']) ? $this->session->userdata('user')['usuario']: null ;
		$this->load->view('layout', $this->data);
	}
}
