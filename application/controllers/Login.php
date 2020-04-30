<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model');
	}

	public function index()
	{
		$this->cerrar_sesion();
		$login['login'] = 1;
		$this->load->view('temp/header_index', $login);
		$this->load->view('login');
		$this->load->view('temp/footer');
	}

	public function ingresar()
	{
		$email = addslashes($this->input->post('email'));
		$contrasenia = addslashes($this->input->post('contrasenia'));
		$result = $this->usuario_model->login($email, $contrasenia);
		var_dump($this->input->post());
		/*if($result)
		{
			if(password_verify($contrasenia, $result['u_contrasenia']))
			{
				$menus = $this->obtener_menu($result['id_usuario']);
				$this->session->set_userdata('id_usuario', $result['id_usuario']);
				$this->session->set_userdata('u_rut', $result['u_rut']);
				$this->session->set_userdata('u_nombres', $result['u_nombres']);
				$this->session->set_userdata('u_apellidos', $result['u_apellidos']);
				$this->session->set_userdata('u_menu', $menus);
				redirect('Inicio');
			}else
			{
				$login['login'] = 1;
				$data['message'] = 'Verifique su email y contrase&ntilde;a.';
				$this->load->view('temp/header_index', $login);
				$this->load->view('login', $data);
				$this->load->view('temp/footer');
			}
		}else{
			$login['login'] = 1;
			$data['message'] = 'Ocurrió un error al ingresar, favor intentelo nuevamente.';
			$this->load->view('temp/header_index', $login);
			$this->load->view('login', $data);
			$this->load->view('temp/footer');
		}*/
	}

	private function obtener_menu($id_usuario)
	{
		$data = $this->usuario_model->obtener_menu_usuario($id_usuario);
		$menus[] = array();
		unset($menus);
		$cont = 0;
		foreach ($data as $row) {
			if(isset($row['cant_submenu']) && $row['cant_submenu'] == '0')
			{
				$menu['id_menu'] = $row['id_menu'];
				$menu['me_nombre'] = $row['me_nombre'];
				$menu['me_url'] = $row['me_url'];
				$menu['me_orden'] = $row['me_orden'];
				$menu['id_modulo'] = $row['id_modulo'];
				$menu['id_rol'] = $row['id_rol'];
				$menu['cant_submenu'] = $row['cant_submenu'];
				$menu['sub_menu'] = array();
				$menus[$cont] = $menu;
				$cont++;
			}elseif (isset($row['cant_submenu']) && (int)$row['cant_submenu'] > 0) {
				for ($i=0; $i < count($menus); $i++) {
					if($menus[$i]['id_modulo'] === $row['id_modulo'])
					{
						$sub_menu['id_menu'] = $row['id_menu'];
						$sub_menu['me_nombre'] = $row['me_nombre'];
						$sub_menu['me_url'] = $row['me_url'];
						$sub_menu['me_orden'] = $row['me_orden'];
						$sub_menu['id_modulo'] = $row['id_modulo'];
						$sub_menu['id_rol'] = $row['id_rol'];
						$sub_menu['cant_submenu'] = $row['cant_submenu'];
						array_push($menus[$i]['sub_menu'], $sub_menu);
					}
				}
			}
		}
		return $menus;
	}

	public function cerrar_sesion()
	{
		$usuario = $this->session->userdata();
		if($usuario)
		{
			$this->session->sess_destroy();
		}
	}
}