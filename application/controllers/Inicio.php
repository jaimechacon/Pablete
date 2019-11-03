<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model');
		$this->load->model('inicio_model');
	}

	public function index()
	{
		$usuario = $this->session->userdata();

		if($this->session->has_userdata('id_usuario'))
		{
			$perfil = $this->usuario_model->traerPerfilUsu($usuario["id_usuario"]);
			$usuario['controller'] = 'inicio';
			$usuario['perfil'] = $perfil[0];
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('inicioSesion', $usuario);
			$this->load->view('temp/footer', $usuario);
		}else
		{
			$this->session->sess_destroy();
			$login['login'] = 0;
			$this->load->view('temp/header_index', $login);
			$this->load->view('temp/menu_index');
			$this->load->view('inicio');
			$this->load->view('temp/footer');
		}
	}

	public function inicio()
	{
		$usuario = $this->session->userdata();
		if(!$usuario){
			$this->session->sess_destroy();
			echo 'asdfsadf';
		}else
		{
			$login['login'] = 0;
			$this->load->view('temp/header_index', $login);
			$this->load->view('temp/menu_index');
			$this->load->view('inicio');
			$this->load->view('temp/footer');
		}
	}

	public function listarConveniosGrafico(){
		$datos[] = array();
     	unset($datos[0]);
		$usuario = $this->session->userdata();
		if($this->session->userdata('id_usuario'))
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$resultado = $this->inicio_model->listarConveniosGrafico("null", "null", "null", "null", $usuario["id_usuario"]);
				$datos = array('resultado' => 1, 'estadosConvenios' => $resultado);
				echo json_encode($datos);
			}
		}else
		{
			redirect('Login');
		}
	}
}
