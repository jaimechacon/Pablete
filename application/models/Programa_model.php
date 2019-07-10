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

	public function agregarPrograma($idPrograma, $codigo, $nombre, $id_forma_pago, $observacion, $idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`agregarPrograma`(".$idPrograma.", '".$codigo."', '".$nombre."', ".$id_forma_pago.", '".$observacion."', ".$idUsuario.");");

		return $query->result_array();
	}

	public function obtenerPrograma($idPrograma)
	{
		$query = $this->db->query("call `institucionminsal`.`obtenerPrograma`(".$idPrograma.");");

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

	public function agregarMarco($id_marco, $id_presupuesto, $id_dependencia, $id_institucion, $marco, $id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`agregarMarco`('.$id_marco.', '.$id_presupuesto.', '.$id_dependencia.', '.$id_institucion.', '.$marco.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function agregarArchivo($id_archivo, $id_presupuesto, $id_marco, $id_convenio, $nombre_original, $nombreNuevo, $extension, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`agregarArchivo`(".$id_archivo.", ".$id_presupuesto.", ".$id_marco.", ".$id_convenio.", '".$nombre_original."', '".$nombreNuevo."', '".$extension."', ".$id_usuario.');');
		return $query->result_array();
	}

	public function listarMarcosUsuario($id_institucion, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarMarcosUsuario`(".$id_institucion.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function listarComunasMarco($id_institucion, $id_marco, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarComunasMarco`(".$id_institucion.', '.$id_marco.", ".$id_usuario.');');
		return $query->result_array();
	}

	public function agregarConvenio($id_convenio, $id_marco, $id_comuna, $convenio, $id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`agregarConvenio`('.$id_convenio.', '.$id_marco.', '.$id_comuna.', '.$convenio.', '.$id_usuario.');');
		return $query->result_array();
	}
	
	public function listarMarcos($id_institucion, $id_programa, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarMarcos`(".$id_institucion.', '.$id_programa.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function listarConvenios($id_institucion, $id_programa, $id_comuna, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarConvenios`(".$id_institucion.', '.$id_institucion.', '.$id_comuna.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function eliminarConvenio($idConvenio, $idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`eliminarConvenio`(".$idConvenio.", ".$idUsuario.");");
		return $query->result_array();
	}

	public function eliminarMarco($idMarco, $idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`eliminarMarco`(".$idMarco.", ".$idUsuario.");");
		return $query->result_array();
	}

	public function listarConveniosUsuario($id_institucion, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarConveniosUsuario`(".$id_institucion.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function agregarPresupuesto($id_presupuesto, $id_programa, $id_subtitulo, $presupuesto, $id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`agregarPresupuesto`('.$id_presupuesto.', '.$id_programa.', '.$id_subtitulo.', '.$presupuesto.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function listarPresupuestos($id_programa, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarPresupuestos`(".$id_programa.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function eliminarPresupuesto($idPresupuesto, $idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`eliminarPresupuesto`(".$idPresupuesto.", ".$idUsuario.");");
		return $query->result_array();
	}

	public function listarDependencias()
	{
		$query = $this->db->query("call `institucionminsal`.`listarDependencias`;");
		return $query->result_array();
	}
}	