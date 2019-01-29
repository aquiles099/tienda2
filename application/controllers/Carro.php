<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carro extends MY_Controller {
	public function index() {
		$this->load->model('Carro_model');
		$this->load->model('Parametros_model');
		$productosencarro = $this->Carro_model->productosencarro();
		$listadeprecios = $this->Parametros_model->param('tienda/listadeprecios');
		if ($productosencarro && $listadeprecios) {
		    $this->data['total'] = $this->Carro_model->total();
		}
		$this->data['usuario'] = isset($this->session->userdata('user')['usuario']) ? $this->session->userdata('user')['usuario']: null ;
		$this->data['carro'] = $this->Carro_model->carro();
		$this->data['view'] = 'carro';
		$this->load->view('layout', $this->data);
	}
}
