<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacto extends MY_Controller {
	protected $errors = [];

	public function sendContactMail() {
		$this->load->model('Parametros_model');
		$this->load->library('email');
		$this->config->load('email');

		$data['contact_name'] = $this->input->post('contact_name');
		$data['contact_email'] = $this->input->post('contact_email');
		$data['contact_phone'] = $this->input->post('contact_phone');
		$data['contact_subject'] = $this->input->post('contact_subject');
		$data['contact_message'] = $this->input->post('contact_message');
		$captchaResult = $this->evaluateCaptcha();
		$data['body'] = 'email/contacto/contacto';

		// Get errors
		if (!$data['contact_name']) $this->pushError('contact_name', 'Por favor, escriba su nombre');
		if (!$data['contact_email']) $this->pushError('contact_email', 'Por favor, indique su email');
		if (!$data['contact_phone']) $this->pushError('contact_phone', 'Por favor, indique su teléfono');
		if (!$data['contact_message']) $this->pushError('contact_message', 'Por favor, escriba un mensaje');
		if (!$captchaResult['success']) $this->pushError('contact_captcha', $this->parseCaptchaMessage($captchaResult));

		if ($this->errors) {
			return $this->error('Por favor, revise el formulario');
		}

		$email = $this->Parametros_model->param('tienda/email', $this->config->item('site_email'));
		$html = $this->load->view('email/layout', $data, true);
		$from_name = $this->config->item('site_name');
		$bcc = $this->config->item('bcc');
		if (!$bcc) $bcc = 'curykdiego@gmail.com';
		$this->email->from($email, $from_name);
		$this->email->reply_to($data['contact_email']);
		$this->email->to($email);
		$this->email->subject($data['contact_subject']);
		$this->email->message($html);
		$this->email->set_mailtype('html');
		$this->email->bcc($bcc);
		$success = $this->email->send(false);

		if ($success) {
			$mensaje = $this->Parametros_model->param('tienda/mensajes/mensajeenviado', 'Muchas gracias por su consulta. Su mensaje ha sido enviado y será respondido a la brevedad.');
			return $this->success($mensaje);
		} else {
			$mensaje = 'Se ha producido un error al enviar su mensaje. Por favor, intente nuevamente en unos instantes.';
			return $this->error($mensaje);
		}
	}

	protected function evaluateCaptcha() {
		$config = $this->config->item('recaptcha');
		$captchaValue = $this->input->post('g-recaptcha-response');
		$ch = curl_init($config['url']);
		curl_setopt($ch, CURLOPT_POSTFIELDS, [
			'secret' => $config['secret'],
			'response' => $captchaValue,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$captchaResponse = curl_exec($ch);
		curl_close($ch);
		return json_decode($captchaResponse, true);
	}

	protected function parseCaptchaMessage($captchaResult) {
		$messages = [
			'missing-input-secret' => 'Error de configuración (falta el secreto)',
			'invalid-input-secret' => 'Error de configuración (el secreto es inválido)',
			'missing-input-response' => 'Por favor, marque la casilla "no soy un robot"',
			'invalid-input-response' => 'La respuesta al captcha en incorrecta.',
			'bad-request' => 'La respuesta al captcha en incorrecta.',
		];
		$out = [];
		foreach ($captchaResult['error-codes'] as $code) {
			$out[] = $messages[$code];
		}
		return implode('<br>', $out);
	}

	protected function pushError($field, $message) {
		$this->errors[] = [
			'name' => $field,
			'message' => $message
		];
	}

	protected function success($message) {
		return $this->returnJson($message, true);
	}

	protected function error($message) {
		return $this->returnJson($message, false);
	}

	protected function returnJson($message, $success) {
		$this->output->set_content_type('text/json');
		$this->output->set_output(json_encode([
			'success' => $success,
			'message' => $message,
			'errors' => $this->errors
		]));
	}
}
