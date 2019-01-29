<?php
class usuarios_model extends CI_Model
{
	public function nuevo() {
		$usuario = new usuario($this);
		return $usuario;
	}

	public function buscar($id) {
		if (preg_match('/[a-zA-Z0-9]{32}/i',$id)) {
			$this->db->from('usuarios_tienda');
			$this->db->join('password_reset_tienda', 'usuarios_tienda.id = password_reset_tienda.user_id');
			$this->db->where('hash', $id);
		}
		else {
			$this->db->from('usuarios_tienda');
			$this->db->where('id', $id);
		}
		$query = $this->db->get();
		$usuario = $query->row(0, 'usuario');
		$usuario->setId($usuario->id);
		return $usuario;
	}

	public function eliminar($id) {
		$this->db->where('idusuario', $id);
		$this->db->delete('usuarios');
	}

	public function defaultuserid() {
		$this->db->limit(1);
		$query = $this->db->get('usuarios');
		return $query->row()->idusuario;
	}

	public function verificalogin($data) {

		$query = $this->db->query('select * from usuarios_tienda 
			where (usuario = '. $this->db->escape ( $data ['usuario'] ) .' 
			or email = '. $this->db->escape ( $data ['usuario'] ) .') and 
			password = md5('. $this->db->escape ($data['password']) .') collate \'utf8_general_ci\';');

		if ($query->num_rows() > 0) {
			return $query->row (0, 'usuario');
		} else {
			return 'error';
		}
	}

	public function passwordreset($usr){
		$datos = array(
				'user_id'=>$usr->id,
				'hash'=>md5($usr->usuario . $usr->email . time() ),
				'date_created'=> date('Y-m-d H:i:s')
			);
		$this->db->insert('password_reset_tienda', $datos);
		if ( $this->db->insert_id() ) {
			return $datos['hash'];		
		}
		else {
			return false;
		}
	}

	public function checkuser($usuario){
		$this->db->select('*');
		$this->db->from('usuarios_tienda');
		$this->db->where( sprintf('(email = %s or usuario = %s)', $this->db->escape($usuario), $this->db->escape($usuario)));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function checkuserobj($usuario){
		$this->db->select('*');
		$this->db->from('usuarios_tienda');
		$this->db->where( sprintf('(email = %s or usuario = %s)', $this->db->escape($usuario), $this->db->escape($usuario)));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row (0, 'usuario');
		} else {
			return 'error';
		}
	}



	public function obtenerusuariosnovendedores() {
		$query = $this->db->query("SELECT * FROM usuarios 
							WHERE idusuario NOT IN (
								SELECT usuarios.idusuario
								FROM usuarios
								JOIN vendedores ON vendedores.idusuario = usuarios.idusuario
							);"
				);
		if ($query->num_rows() > 0) {
			$return = array();
			foreach ($query->result() as $key => $usuario) {
				$return[$usuario->idusuario] = $usuario->nombre;
			}
			return $return;
		}
		return null;
	}

}

class usuario {
	protected $model;
	public $id;
	public $usuario;
	public $password;
	public $checkcode;
	public $email;
	public $nombre;
	public $apellido;
	public $salt;
	public $cuit;
	public $telefono;
	public $avatar;
	public $idcliente;
	public $verificado;
	public $habilitado;
	public $fechacreacion;
	public $fechaactualizacion;
	public $fechacompra;

	public function __construct() {
		$this->model = new usuarios_model();
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function guardar() {
		if (empty($this->usuario)) {
			throw new Exception('El nombre de usuario no puede estar vacío');
			return false;
		}
		if (empty($this->password)) {
			throw new Exception('La contraseña no puede estar vacía');
			return false;
		}
		if (empty($this->email)) {
			throw new Exception('El email no puede estar vacío');
			return false;
		}
		if (empty($this->salt)) {
			$this->salt = substr(sha1($this->usuario . date('Y-m-d H:i:s')), 0, 32);
		}

		if (!(empty($this->checkcode))) {
			$this->model->db->set('checkcode', $this->checkcode);
		}

		$this->model->db->set('usuario', $this->usuario);
		$this->model->db->set('password', $this->password);
		$this->model->db->set('checkcode', $this->checkcode);
		$this->model->db->set('email', $this->email);		
		$this->model->db->set('nombre', $this->nombre);
		$this->model->db->set('apellido', $this->apellido);
		$this->model->db->set('verficado', $this->verificado);
		$this->model->db->set('cuit', $this->cuit);
		$this->model->db->set('telephone', $this->telephone);
		$this->model->db->set('habilitado', $this->habilitado);

		$this->model->db->set('fecha_creacion',      $this->fechacreacion);		
		$this->model->db->set('fecha_actualizacion', $this->fechaactualizacion);

		

		$this->model->db->set('salt', $this->salt);

		// Nullable fields
		$this->model->db->set('avatar', $this->avatar ?: null);
		$this->model->db->set('idcliente', $this->idcliente ?: null);
		$this->model->db->set('fecha_ultima_compra', $this->fechacompra ?: null);
		

		if ($this->id) {
			$this->model->db->where('id', $this->id);
			$this->model->db->update('usuarios_tienda');
		} else {
			$this->model->db->insert('usuarios_tienda');
			$this->setId($this->model->db->insert_id());
		}
		return $this->id;
	}

	public function actulizaridcliente($idcliente) {
			$this->model->db->set('idcliente', $idcliente);
			$this->model->db->where('id', $this->id);
			$this->model->db->update('usuarios_tienda');
	}

}
