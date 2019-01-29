<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {
	public function email() {
		die();
		if (isset($_POST['send'])) {
			$idpresupuesto = 1;
			$checkout = $this->session->userdata('checkout');
			$this->load->model('Parametros_model');
			$data['body'] = 'email/pedidos/propietario';
			$data['carro'] = $this->Carro_model->carro();
			$data['total'] = $this->Carro_model->total();
			$data['idpresupuesto'] = $idpresupuesto;
			$email = 'ventas@officemondo.com';
			$html = $this->load->view('email/layout', $data, true);
			$this->load->library('email');
			$this->config->load('email');
			$from_name = 'OfficeMondo';
			$bcc = $this->config->item('bcc');
			if (!$bcc) $bcc = 'curykdiego@gmail.com';
			$this->email->from($email, $from_name);
			$this->email->to('diego@nube360plus.com');
			$this->email->subject('Nuevo presupuesto web');
			$this->email->message($html);
			$this->email->set_mailtype('html');
			$this->email->cc($bcc);
			$success = $this->email->send(false);
			if ($success) echo 'success';
			else echo 'error';
		}
		die('<form method="post" action="">
			<input name="send" value="1" type="hidden">
			<input type="submit" value="Enviar">
		</form>');
	}
}
