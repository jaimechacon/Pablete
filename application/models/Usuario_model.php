<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function login($email, $contrasenia)
	{
		$usuario = $this->db->get_where('usuarios', array('u_email' => $email, 'u_contrasenia' => $contrasenia), 1);
		return $usuario->row_array();
	}

	public function obtener_menu_usuario($id_usuario)
	{
		//$usuario = $this->db->get_where('usuarios', array('u_email' => $email, 'u_contrasenia' => $contrasenia), 1);
		$query = $this->db->query("		select distinct me.id_menu, me.me_nombre, me.me_url, me.me_orden, me.id_modulo, me.id_rol,
	   (if(isnull(me.id_rol), 0, (select count(men.id_menu) from menus men where men.id_modulo = me.id_modulo and not isnull(men.id_rol)))) as cant_submenu
		from usuarios usu inner join usuarios_perfiles up on usu.id_usuario = up.id_usuario
						  inner join perfiles p on up.id_perfil = p.id_perfil
                    inner join perfiles_modulos_roles pmr on p.id_perfil = pmr.id_perfil
                    left join menus me on (if(isnull(pmr.id_rol), (pmr.id_modulo = me.id_modulo and me.id_rol is null), (pmr.id_modulo = me.id_modulo and pmr.id_rol = me.id_rol)))
		where usu.id_usuario = ".$id_usuario."
		and isnull(me.me_fecha_baja)
		order by me.id_rol, me.me_orden;");
		return $query->result_array();
	}

	public function obtenerEmpresasUsu($id_usuario)
	{
		$query = $this->db->query('call `gestion_calidad`.`obtenerEmpresasUsu`('.$id_usuario.');');
		return $query->result_array();
	}

	public function listarCampaniasUsu($id_usuario)
	{
		$query = $this->db->query('call `gestion_calidad`.`listarCampaniasUsu`('.$id_usuario.');');
		return $query->result_array();
	}

	public function listarAnalistaUsu()
	{
		$query = $this->db->query("			select concat(usu.u_nombres, ' ', usu.u_apellidos) as nombre_usu from usuarios usu inner join usuarios_perfiles up on usu.id_usuario = up.id_usuario
			inner join perfiles p on up.id_perfil = p.id_perfil
			where p.pf_analista in (2, 3);");
		return $query->result_array();
	}

	public function traerPerfilUsu($id_usuario)
	{
		$query = $this->db->query("		select p.pf_nombre as perfil from usuarios usu inner join usuarios_perfiles up on usu.id_usuario = up.id_usuario
		inner join perfiles p on up.id_perfil = p.id_perfil
		where usu.id_usuario = ".$id_usuario." group by p.pf_nombre;");
		return $query->result_array();
	}

	public function buscarUsuario($usuario, $idUsuario)
	{
		$query = $this->db->query("call `gestion_calidad`.`buscarUsuario`('".$usuario."', ".$idUsuario.");");
		return $query->result_array();
	}

	public function eliminarUsuario($idUsuarioE, $idUsuario)
	{
		$query = $this->db->query("call `gestion_calidad`.`eliminarUsuario`(".$idUsuarioE.", ".$idUsuario.");");
		return $query->result_array();
	}

	public function guardarUsuario($idUsuario, $rut, $idEmpresa, $nombres, $apellidos, $email, $codUsuario, $contabilizar, $idPerfil, $idUsuarioCreador)
	{
		$query = $this->db->query("call `gestion_calidad`.`agregarUsuario`(".$idUsuario.", ".($rut == "null" ? $rut : ("'".$rut."'")).", ".$idEmpresa.", ".($nombres == "null" ? $nombres : ("'".$nombres."'")).", ".($apellidos == "null" ? $apellidos : ("'".$apellidos."'")).", ".($email == "null" ? $email : ("'".$email."'")).", ".($codUsuario == "null" ? $codUsuario : ("'".$codUsuario."'")).", ".$contabilizar.", ".$idPerfil.", ".$idUsuarioCreador.");");

		return $query->result_array();
	}

	public function obtenerUsuario($idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`obtenerUsuario`(".$idUsuario.");");

		return $query->result_array();
	}

	public function obtenerUsuariosAnalista($idUsuario)
	{
		$query = $this->db->query("call `gestion_calidad`.`obtenerUsuariosAnalista`(".$idUsuario.");");
		return $query->result_array();
	}

	public function obtenerUsuariosEvaluadores($idUsuario)
	{
		$query = $this->db->query("call `gestion_calidad`.`obtenerUsuariosEvaluadores`(".$idUsuario.");");
		return $query->result_array();
	}
}	
