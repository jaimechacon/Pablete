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

	public function guardarPrograma($idPrograma, $nombrePrograma, $abreviacionPrograma, $observacionesPrograma, $idUsuario)
	{
		$query = $this->db->query("call `gestion_calidad`.`agregarPrograma`(".$idPrograma.", '".$nombrePrograma."', '".$abreviacionPrograma."', '".$observacionesPrograma."', ".$idUsuario.");");

		return $query->result_array();
	}

	public function obtenerPrograma($idPrograma)
	{
		$query = $this->db->query("call `gestion_calidad`.`obtenerPrograma`(".$idPrograma.");");

		return $query->result_array();
	}

	public function obtenerFormasPago()
	{
		$query = $this->db->query("call `institucionminsal`.`obtenerFormasPago`");

		return $query->result_array();
	}

	public function listarProgramasUsu($idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`listarProgramasUsu`(".$idUsuario.");");
		return $query->result_array();
	}

	public function agregarMarco($id_marco, $id_programa, $id_subtitulo, $id_institucion, $marco, $id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`agregarMarco`('.$id_marco.', '.$id_programa.', '.$id_subtitulo.', '.$id_institucion.', '.$marco.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function agregarArchivo($id_archivo, $id_marco, $id_convenio, $nombre_original, $nombreNuevo, $extension, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`agregarArchivo`(".$id_archivo.", ".$id_marco.", ".$id_convenio.", '".$nombre_original."', '".$nombreNuevo."', '".$extension."', ".$id_usuario.');');
		return $query->result_array();
	}

	public function listarMarcosUsuario($id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarMarcosUsuario`(".$id_usuario.');');
		return $query->result_array();
	}

	public function listarComunasMarco($id_marco, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarComunasMarco`(".$id_marco.", ".$id_usuario.');');
		return $query->result_array();
	}

	public function agregarConvenio($id_convenio, $id_marco, $id_comuna, $convenio, $id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`agregarConvenio`('.$id_convenio.', '.$id_marco.', '.$id_comuna.', '.$convenio.', '.$id_usuario.');');
		return $query->result_array();
	}
	
}	