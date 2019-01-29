<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('application/libraries/mercadopago.php');

class Checkout extends MY_Controller {
	public function index() {
		
		$this->load->model('Carro_model');
		$this->load->model('Paises_model');
		$this->load->model('Parametros_model');
		$this->load->model('Provincias_model');
		$this->load->helper('form_field');
		$productosencarro = $this->Carro_model->productosencarro();
		$listadeprecios = $this->Parametros_model->param('tienda/listadeprecios');
		if ($productosencarro && $listadeprecios) {
			$this->data['total'] = $this->Carro_model->total();
		}

		// Información personal
		$personal = $this->input->get_post('personal');

		if ($personal) {
			if (isset($personal['user']) && isset($personal['pass'])) {
				$this->load->model('Usuarios_model');
				$login = $this->Usuarios_model->login($personal['user'], $personal['pass']);
				if ($login) {
					return redirect(base_url('checkout'));
				}
			}
		} else {
			// Usuario logueado
			$usuario = $this->session->userdata('usuario');
		}

		$usuario = $this->session->userdata('usuario');
		$this->data['steps'] = [
			['personal', 'Datos personales'],
			['direcciones', 'Direcciones']
		];
		$envio = false;
		if ($envio) {
			$this->data['steps'][] = ['envio', 'Método de envío'];
		}
		$mediospago = $this->Parametros_model->param('tienda/mediospago');
		if ($mediospago) {
			$this->data['steps'][] = ['mediospago', 'Pago'];
		}
		$checkout = $this->get_checkout();

		// Checkout completado ?
		if ($checkout['step'] > count($this->data['steps'])) {
		    // Guardar pedido
		    $this->load->model('Pedidos_model');
		    if ($idpresupuesto = $this->Pedidos_model->guardarpedido($checkout)) {
				// Envío de email al propietario de la tienda
				$this->load->model('Parametros_model');
				$data['cliente'] = $checkout;
				$data['body'] = 'email/pedidos/propietario';
				$data['carro'] = $this->Carro_model->carro();
				if ($listadeprecios) {
					$data['total'] = $this->Carro_model->total();
				}
				$data['idpresupuesto'] = $idpresupuesto;
				$this->load->library('email');
				/*$this->config->load('email');
				$email = $this->Parametros_model->param('tienda/email', $this->config->item('site_email'));
				$html = $this->load->view('email/layout', $data, true);
				$from_name = $this->config->item('site_name');
				$bcc = $this->config->item('bcc');
				if (!$bcc) $bcc = 'curykdiego@gmail.com';
				$this->email->from($email, $from_name);
				$this->email->to($email);
				$this->email->subject('Nuevo presupuesto web');
				$this->email->message($html);
				$this->email->set_mailtype('html');
				$this->email->bcc($bcc);
				$success = $this->email->send(false);

				// Envío de email al cliente
				$data['body'] = 'email/pedidos/cliente';
				$data['carro'] = $this->Carro_model->carro();
				if ($listadeprecios) {
					$data['total'] = $this->Carro_model->total();
				}
				$data['nombresitio'] = $this->Parametros_model->param('tienda/titulo');
				$email = $this->Parametros_model->param('tienda/email', $this->config->item('site_email'));
				$html = $this->load->view('email/layout', $data, true);
				$this->load->library('email');
				$this->config->load('email');
				$from_name = $this->config->item('site_name');
				$this->email->from($email, $from_name);
				if (!empty($checkout['idcliente'])) {
					// Cliente registrado
					$this->email->to($email);
				} else {
					$this->email->to($checkout['guest']['email']);
				}
				$this->email->subject('Detalle de su compra');
				$this->email->message($html);
				$this->email->set_mailtype('html');
				$success = $this->email->send(false);*/

				// Vaciar carro
				$this->Carro_model->vaciarcarro();
				// Reinicar checkout
				$checkout['step'] = 1;
				$this->set_checkout($checkout);
				// Redireccionar a home
				$mensaje = $this->Parametros_model->param('tienda/mensajes/pedidoprocesado');
				$this->session->set_flashdata('success', $mensaje);
				return redirect(base_url());

			}
		}
		$this->data['usuario'] = isset($this->session->userdata('user')['usuario']) ? $this->session->userdata('user')['usuario']: null ;;
		$this->data['paises'] = $this->Paises_model->obtenercombopaises();
		$this->data['provincias'] = $this->Provincias_model->obtenercomboprovincias();
		$this->data['checkout'] = $checkout;
		$this->data['carro'] = $this->Carro_model->carro();
		$this->data['view'] = 'checkout';
		$this->data['mediospago'] = $mediospago;
		$this->load->view('layout', $this->data);
	}

	public function step() {
		$this->output->set_content_type('application/json');
		$checkout = $this->get_checkout();
		$this->output->set_output(json_encode(['step' => $checkout['step']]));
	}

	public function guest() {
		$nombre = is_null($this->input->get_post('nombre')) ? $this->session->userdata('user')['nombre']: $this->input->get_post('nombre');
		$apellido = is_null($this->input->get_post('apellido')) ? $this->session->userdata('user')['apellido'] :$this->input->get_post('apellido');
		$telefonocontacto = is_null($this->input->get_post('telefonocontacto')) ? $this->session->userdata('user')['telephone'] :$this->input->get_post('telefonocontacto');
		$email = is_null($this->input->get_post('email')) ? $this->session->userdata('user')['email'] :$this->input->get_post('email');

		$idcliente= is_null($this->session->userdata('user')['idcliente']) ?  "" : $this->session->userdata('idcliente');


		$checkout = $this->get_checkout();
		
		
		$checkout['guest'] = [
			'nombre' => trim($nombre),
			'apellido' => trim($apellido),
			'telefonocontacto' => trim($telefonocontacto),
			'email' => trim($email), 
			'idcliente' => $idcliente
		];
		/*print_r($email);
		print_r($checkout);

		return($checkout);*/

		$checkout['error'] = [];
		if (!$nombre) {
			$checkout['error']['guest']['nombre'] = 'Por favor, indique su nombre.';
		}
		if (!$apellido) {
			$checkout['error']['guest']['apellido'] = 'Por favor, indique su apellido.';
		}
		if (!$email) {
			$checkout['error']['guest']['email'] = 'Por favor, indique su email.';
		} else if (!preg_match('/[^@]+@[^@]+\.[^@]+/', $email)) {
			$checkout['error']['guest']['email'] = 'Por favor, ingrese un email válido.';
		}
		if (empty($checkout['error'])) {
			$checkout['step'] = 2;
		} else {
			$checkout['step'] = 1;
		}
		$this->set_checkout($checkout);
		redirect(base_url('checkout'));
	}

	public function direcciones() {
		$f_direccion = $this->input->get_post('f_direccion');
		$f_pais = $this->input->get_post('f_pais');
		$f_provincia = $this->input->get_post('f_provincia');
		$f_ciudad = $this->input->get_post('f_ciudad');
		$checkout = $this->get_checkout();
		$checkout['direcciones'] = [
			'f_direccion' => trim($f_direccion),
			'f_pais' => trim($f_pais),
			'f_provincia' => trim($f_provincia),
			'f_ciudad' => trim($f_ciudad)
		];
		$checkout['error'] = [];
		if (!$f_direccion) {
			$checkout['error']['direcciones']['f_direccion'] = 'Por favor, indique la dirección de facturación.';
		}
		if (!$f_pais) {
			$checkout['error']['direcciones']['f_pais'] = 'Por favor, indique el país.';
		}
		if (!$f_provincia) {
			$checkout['error']['direcciones']['f_provincia'] = 'Por favor, indique la provincia.';
		}
		if (!$f_ciudad) {
			$checkout['error']['direcciones']['f_ciudad'] = 'Por favor, indique la ciudad.';
		}
		if (empty($checkout['error'])) {
			$checkout['step'] = 3;
		} else {
			$checkout['step'] = 2;
		}
		$this->set_checkout($checkout);
		redirect(base_url('checkout'));
	}

	public function logout() {
		// @todo: Do logout
		redirect(base_url('checkout'));
	}

	public function mercadopago() {
		// @todo: Do logout
		$mp = new MP ("3423276286501417", "qLPt0LUzlkuZORjw2SWAzUn9Uhh02D5F");
		$preference_data = array (
		    "items" => array (
		        array (
		            "title" => "Test",
		            "quantity" => 1,
		            "currency_id" => "ARS",
		            "unit_price" => 10
		        )
		    )
		);

		$preference = $mp->create_preference($preference_data);

		print_r ($preference);
		echo "Hola fercys ra ";
		return "h";
	}
	protected function get_checkout() {
		$checkout = $this->session->userdata('checkout');
		if (!$checkout) $checkout = ['step' => 1];
		return $checkout;
	}

	protected function set_checkout($checkout) {
		$this->session->set_userdata('checkout', $checkout);
	}
}
