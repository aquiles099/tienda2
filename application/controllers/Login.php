<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
    public function index() {
        if (defined('SUSPEND') && SUSPEND) {
            // Servicio suspendido, deshabilitar login
            $this->load->view('suspend');
            return;
        }
        
        if ($this->session->userdata('ses_usuario')) redirect('index', 'location');
        else $this->_cargar_login_view();
    }
    public function loginusuario($usuario, $password) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $this->_generar_sesion_login($usuario, $password);       
        //echo json_encode($output_string);
    }

    public function login() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $output_string = $this->_generar_sesion_login($_POST['usuario'], $_POST['password']);          
        echo json_encode($output_string);
    }

    public function logout() {
        $this->set_usersession([]);
        $this->session->set_userdata('checkout', []);
        redirect('', 'refresh');
        exit;
    }


    public function validar_form() {
        $arrValidaciones = array(array('field' => 'txtEmail', 'label' => 'Email', 'rules' => 'required|min_length[10]|max_length[50]
        |valid_email|callback__existe_email'), array('field' => 'txtPassword', 'label' => 'contrasea', 'rules' => 'required|min_length[6]|max_length[25]|md5'), array('field' => 'txtSesLimite', 'label' => 'duracin de la sesin', 'rules' => 'required|min_length[1]|max_length[3]|integer'));
        $this->form_validation->set_rules($arrValidaciones);
        $this->form_validation->set_error_delimiters('<div class="div_error">* ', '</div>');
        $this->form_validation->set_message('_existe_email', 'El <b>Email</b> introducido no existe');
        $sEmail = $this->input->post('txtEmail');
        $sPassword = $this->input->post('txtPassword');
        $SesLimite = $this->input->post('txtSesLimite');
        if ($this->form_validation->run() == FALSE) $this->_cargar_login_view();
        elseif ($this->login_m->no_existe_cuenta($sEmail, $sPassword, 2)) $this->_cargar_login_view('El <b>Email</b> y la <b>contrasea</b>
      no coinciden');
        else $this->_generar_sesion($sEmail, $SesLimite);
    }


    public function passwordreset( $hash=null ){

        $banner_header = $this->Banner_model->get_banner_header();

        if ( !$hash ) {
            $this->data['banner_header'] = $banner_header;
            $this->data['view'] = 'passwordreset';            
            $this->load->view('layout', $this->data);
            
        }
        else {

            $banner_header = $this->Banner_model->get_banner_header();
            $this->data['banner_header'] = $banner_header;
        
            $this->load->model('usuarios_model');
            $usuario = $this->usuarios_model->buscar($hash);
            $this->data['hash'] = $hash;
            if ( is_object($usuario) && get_class($usuario)=='usuario' ) {
                $date_request = new DateTime($usuario->date_created);
                $exp_date = new DateTime($date_request->format('Y-m-d H:i:s'));
                $exp_date->add(new DateInterval('PT6H'));
                $current_date = new DateTime();
                if ( $current_date->format('Y-m-d H:i:s') > $exp_date->format('Y-m-d H:i:s') ) {
                    redirect(base_url().'');
                }
                else {
                    $this->data['view'] = 'passwordreset';            
                    $this->load->view('layout', $this->data);              
                }
            }
            else {
                redirect( base_url());
            }

        }


    }

    //recuperar clave
    public function forgotpass(){
        $this->load->library('email');
        $this->load->config('email');
        $this->load->model('usuarios_model');

        $usuario = $this->usuarios_model->checkuserobj($_POST['usuario']);
        

        $respuesta=array(
                'title'=>'INFO',
                'text'=>'',
                'type'=>''
            );
        if ( $usuario != 'error' ) {
            //Enviar el correo
            $recipient = $usuario->email;
            $hash = $this->usuarios_model->passwordreset($usuario);
            if ( !$hash ) {
                $respuesta['text']='Se produjo un error inesperado, por favor notificar al administrador del sitio.';
                $respuesta['type']='info';
            }
            else {
                $html = $this->load->view('passwordreset_email', array('usuario'=>$usuario,'hash'=>$hash), true);
                $from = $this->config->item('site_email');
                $from_name = $this->config->item('site_name');
                $this->email->from($from, $from_name);
                $this->email->to($recipient);
                $this->email->subject("Solicitud de cambio de clave");
                $this->email->message($html);
                $this->email->set_mailtype('html');
                $success = $this->email->send(false);

                if ($success) {
                    $respuesta['title']='REALIZADO';
                    $respuesta['text']='Se ha enviado un correo electronico con las instrucciones para cambiar la clave.';
                    $respuesta['type']='success';
                } else {
                    $respuesta['text']='Se produjo un error inesperado, por favor notificar al administrador del sitio.';
                    $respuesta['type']='info';
                }
            }
            echo json_encode($respuesta);
        }
        else {
                $respuesta['title']='ERROR';
                $respuesta['text']='No existe el usuario o correo electronico. '.$_POST['usuario'];
                $respuesta['type']='error';
            echo json_encode($respuesta);
        }
    }


    function _cargar_login_view($sMsjError = '') {
        $this->load->view('login', "");
    }

    function _existe_email($sEmail) {
        return ($this->login_m->no_existe_cuenta($sEmail)) ? false : true;
    }

    function _generar_sesion($sEmail = '[desconocido]', $SesLimite = 1) {
        $arrSesion = array(
            'is_logged' => true,
            'email' => $sEmail,
            'seslimite' => time() + ($SesLimite * 60)
        );
        $this->session->set_userdata('ses_usuario', $arrSesion);
        redirect('index', 'location');
    }

    function _generar_sesion_login($usuario, $pass) {
        $this->load->model('usuarios_model');

        $this->load->library('session');
        $data['usuario'] = $usuario;
        $data['password'] = $pass;


        $loggedin = $this->usuarios_model->verificalogin($data);
        $user=$this->get_usersession();
        if ($loggedin !== 'error') {
            $output_string = '';
            $user = array(
                'logged_in' => TRUE,
                'id' => $loggedin->id,
                'usuario' => $loggedin->usuario,
                'nombre' => $loggedin->nombre,
                'apellido' => $loggedin->apellido,
                'email' => $loggedin->email,
                'telephone' => $loggedin->telephone,
                'idcliente' => $loggedin->idcliente,
            );

            $this->set_usersession($user);

            //$this->session->set_userdata($data);
        } else {
            $output_string = 'err';
        }
        return $output_string;
    }

    public function registrar(){
        $this->load->library('email');
        $this->load->config('email');

        $this->load->model('usuarios_model');
        $this->load->model('clientes_model');
        $pass=md5($_POST['password']);

        $usuario = $this->usuarios_model->nuevo();
        $usuario->nombre=$_POST['nombre'];
        $usuario->apellido=$_POST['apellido'];
        $usuario->cuit=$_POST['cuit'];
        $usuario->email=$_POST['email'];
        $usuario->usuario=$_POST['usuario'];
        $usuario->telephone=$_POST['telephone'];
        $usuario->password=$pass;
        $usuario->checkcode=md5($_POST['usuario'].$_POST['email']);
        $usuario->habilitado=true;
        $usuario->verificado=false;
        $usuario->fechacreacion=date('Y-m-d H:i:s');
        $usuario->fechaactualizacion=date('Y-m-d H:i:s');

        $respuesta=array(
            'title'=>'',
            'text'=>'',
            'type'=>''
        );
    
        $checkuser = $this->usuarios_model->checkuser($_POST['usuario']);
        $checkmail = $this->usuarios_model->checkuser($_POST['email']);
        
        if($checkuser==true){
            $respuesta['title']='ERROR';
            $respuesta['text']='El nombre de usuario debe ser unico';
            $respuesta['type']='error';   
            echo json_encode($respuesta);
            return $respuesta;
        
        }

        if($checkmail==true){
            $respuesta['title']='ERROR';
            $respuesta['text']='El email se encuentra registrado';
            $respuesta['type']='error';   
            echo json_encode($respuesta);
            return $respuesta;
        }


   
        $idusuario=$usuario->guardar();
        $idcliente=$this->clientes_model->checkclientecuit($_POST['cuit']);

        if($idcliente!=false){
            $usuario->actulizaridcliente($idcliente);
            $this->clientes_model->setidusuariotienda($idcliente,$idusuario);

        }else{
            $cliente=$this->clientes_model->registrarcliente($_POST, $idusuario);
            $usuario->actulizaridcliente($cliente);
        }
        
        $this->loginusuario($_POST['usuario'],$_POST['password']);


        $respuesta['title']='BIENVENIDO';
        $respuesta['text']=$_POST['nombre'].' '.$_POST['apellido'];
        $respuesta['type']='success';

        echo json_encode($respuesta);

        $recipient = $_POST['email'];
        $html = $this->load->view('/email/usuarios/registrousuario', array('usuario'=>$_POST['nombre'].' '.$_POST['apellido']), true);
        $from = $this->config->item('site_email');
        $from_name = $this->config->item('site_name');
        $this->email->from($from, $from_name);
        $this->email->to($recipient);
        $this->email->subject("Registro de Nuevo Usuario en tienda 360 ");
        $this->email->message($html);
        $this->email->set_mailtype('html');
        $success = $this->email->send(false);

    }


    public function cambio_clave() {
        if ( !$this->input->is_ajax_request() ) {
            redirect('perfil/perfil');
        }

        $datos = array('response'=>'0','mensaje'=>'Debe completar los campos.');
        if (
            $this->input->post('clave_actual') &&
            $this->input->post('nueva_clave') &&
            $this->input->post('nueva_clave_confirm')
        ) {
            $this->form_validation->set_rules('clave_actual','Clave actual','required|trim');
            $this->form_validation->set_rules('nueva_clave','Nueva clave','required|min_length[4]|trim');
            $this->form_validation->set_rules('nueva_clave_confirm','Confirmar clave','required|min_length[4]|trim');

            if ($this->form_validation->run() !=false) {

                $this->load->model('usuarios_model');
                
                if ( ! $this->session->userdata('id') ) {
                    $usuario = $this->usuarios_model->buscar($this->input->post('clave_actual'));
                }
                else {
                    $usuario = $this->usuarios_model->buscar($this->session->userdata('id'));
                }
                
                $usuario->password = md5($this->input->post('nueva_clave'));
                $result = $usuario->guardar();
                $datos['response'] = ($result) ? 1 : 0;
                $datos['mensaje'] = ($result) ? 'Se ha cambiado su clave satisfactoriamente.' : 'No se ha podido cambiar la clave.';
            }
            else {
                $datos['response'] = 0;
                $datos['mensaje'] = 'No se ha podido cambiar la clave.';
            }
        }
        else {

        }
        echo json_encode($datos);
    }


    protected function get_usersession() {
        $user = $this->session->userdata('user');
        return $user;
    }

    protected function set_usersession($user) {
        $this->session->set_userdata('user', $user);
    }
};
