<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Parametros_model extends CI_Model
{
	protected $params = array();
	
	public function __construct() {
		$query = $this->db->get('parametros');
		foreach ($query->result() as $row) {
			$this->params[$row->parametro] = $row->valor;
		}
	}

	public function param($param, $default = null) {
		return isset($this->params[$param]) ? $this->params[$param] : $default;
	}

	public function set_param($param, $value) {
		$this->db->set('parametro', $param);
		$this->db->set('valor', $value);
		$this->db->replace('parametros');
		$this->params[$param] = $value;
	}
}