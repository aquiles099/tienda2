<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provincias extends MY_Controller {

	public function getSelect() {
		$this->load->model('Provincias_model');
		$idpais = $this->input->get_post('idpais');
		$provincias = $this->Provincias_model->obtenercomboprovincias($idpais);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($provincias));
	}
}
