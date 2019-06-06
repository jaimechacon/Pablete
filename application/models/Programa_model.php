<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Programa_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function listarProgramas()
	{
		$query = $this->db->query("call `institucionminsal`.`listarProgramas`;");
		return $query->result_array();
	}

	public function buscarPrograma($programa)
	{
		$query = $this->db->query("call `institucionminsal`.`buscarPrograma`('".$programa."');");
		return $query->result_array();
	}

	public function eliminarPrograma($idPrograma, $idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`eliminarPrograma`(".$idPrograma.", ".$idUsuario.");");
		return $query->result_array();
	}

	public function listarEAC()
	{
		$query = $this->db->query("select usu.id_usuario, usu.u_nombres as nombres, usu.u_apellidos as apellidos, usu.u_email as email, usu.u_cod_usuario as cod_eac
		from usuarios usu inner join usuarios_perfiles up on usu.id_usuario = up.id_usuario
						  inner join perfiles p on up.id_perfil = p.id_perfil
		where p.pf_analista = 4
		and usu.u_fecha_baja is null
		order by usu.u_cod_usuario;");
		return $query->result_array();
	}

	public function buscarEAC($eac)
	{
		$query = $this->db->query("call `gestion_calidad`.`buscarEAC`('".$eac."');");
		return $query->result_array();
	}

	public function guardarPrograma($idPrograma, $nombrePrograma, $abreviacionPrograma, $observacionesPrograma, $idUsuario)
	{
		$query = $this->db->query("call `gestion_calidad`.`agregarPrograma`(".$idPrograma.", '".$nombrePrograma."', '".$abreviacionPrograma."', '".$observacionesPrograma."', ".$idUsuario.");");

		return $query->result_array();
	}

	public function guardarEACPrograma($idPrograma, $idEac, $idUsuario)
	{
		$query = $this->db->query("call `gestion_calidad`.`agregarEACPrograma`(".$idPrograma.", ".$idEac.", ".$idUsuario.");");

		return $query->result_array();
	}

	public function eliminarEACPrograma($idPrograma, $idUsuario)
	{
		$query = $this->db->query("call `gestion_calidad`.`eliminarEACPrograma`(".$idPrograma.", ".$idUsuario.");");

		return $query->result_array();
	}

	public function obtenerPrograma($idPrograma)
	{
		$query = $this->db->query("call `gestion_calidad`.`obtenerPrograma`(".$idPrograma.");");

		return $query->result_array();
	}

	

	
}	