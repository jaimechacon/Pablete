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
		$query = $this->db->query("call `institucionminsal`.`obtenerFormasPago`();");

		return $query->result_array();
	}

	public function listarProgramasUsu($idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`listarProgramasUsu`(".$idUsuario.");");
		return $query->result_array();
	}

	public function agregarMarco($id_grupo_marco, $id_marco, $id_presupuesto, $id_institucion, $id_hospital, $id_comuna, $marco, $asignacion, $id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`agregarMarco`('.$id_grupo_marco.', '.$id_marco.', '.$id_presupuesto.', '.$id_institucion.', '.$id_hospital.', '.$id_comuna.', '.$marco.', '.$asignacion.','.$id_usuario.');');
		return $query->result_array();
	}

	public function agregarArchivo($id_archivo, $id_presupuesto, $id_marco, $id_convenio, $nombre_original, $nombreNuevo, $extension, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`agregarArchivo`(".$id_archivo.", ".$id_presupuesto.", ".$id_marco.", ".$id_convenio.", '".$nombre_original."', '".$nombreNuevo."', '".$extension."', ".$id_usuario.');');
		return $query->result_array();
	}

	public function listarMarcosUsuario($id_institucion, $id_presupuesto, $id_programa, $inicio, $cantidad, $filtro, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarMarcosUsuario`(".$id_institucion.', '.$id_presupuesto.', '.$id_programa.', '.$inicio.', '.$cantidad.', '.($filtro == "null" ? $filtro : ("'".$filtro."'")).', '.$id_usuario.');');
		return $query->result_array();
	}

	public function listarCantMarcosUsuario($id_institucion, $id_presupuesto, $id_programa, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`cant_listarMarcosUsuario`(".$id_institucion.', '.$id_presupuesto.', '.$id_programa.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function cantMarcosUsuarioFiltro($id_institucion, $id_presupuesto, $id_programa,  $filtro, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`cantMarcosUsuarioFiltro`(".$id_institucion.', '.$id_presupuesto.', '.$id_programa.', '.($filtro == "null" ? $filtro : ("'".$filtro."'")).', '.$id_usuario.');');
		return $query->result_array();
	}
	

	public function listarComunasMarco($id_institucion, $id_marco, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarComunasMarco`(".$id_institucion.', '.$id_marco.", ".$id_usuario.');');
		return $query->result_array();
	}

	public function agregarConvenio($id_convenio, $num_resolucion, $fecha, $id_marco, $convenio, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`agregarConvenio`(".$id_convenio.", ".$num_resolucion.",".($fecha == "null" ? $fecha : ("'".$fecha."'")).", ".$id_marco.", ".$convenio.", ".$id_usuario.");");
		return $query->result_array();
	}
	
	public function listarMarcos($id_institucion, $id_presupuesto, $id_programa, $inicio, $cantidad, $filtro, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarMarcos`(".$id_institucion.', '.$id_presupuesto.', '.$id_programa.', '.$inicio.', '.$cantidad.', '.($filtro == "null" ? $filtro : ("'".$filtro."'")).', '.$id_usuario.');');
		return $query->result_array();
	}

	public function cantlistarMarcos($id_institucion, $id_presupuesto, $id_programa, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`cantlistarMarcos`(".$id_institucion.', '.$id_presupuesto.', '.$id_programa.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function cantlistarMarcosFiltro($id_institucion, $id_presupuesto, $id_programa, $filtro, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`cantlistarMarcosFiltro`(".$id_institucion.', '.$id_presupuesto.', '.$id_programa.', '.($filtro == "null" ? $filtro : ("'".$filtro."'")).', '.$id_usuario.');');
		return $query->result_array();
	}

	public function listarConvenios($id_institucion, $id_programa, $id_comuna, $id_estado, $inicio, $cantidad, $filtro, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarConvenios`(".$id_institucion.', '.$id_programa.', '.$id_comuna.', '.$id_estado.', '.$inicio.', '.$cantidad.', '.($filtro == "null" ? $filtro : ("'".$filtro."'")).', '.$id_usuario.');');
		return $query->result_array();
	}

	public function cantlistarConvenios($id_institucion, $id_programa, $id_comuna, $id_estado, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`cantlistarConvenios`(".$id_institucion.', '.$id_programa.', '.$id_comuna.', '.$id_estado.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function cantConvenioUsuarioFiltro($id_institucion, $id_programa, $id_comuna, $id_estado, $filtro, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`cantConvenioUsuarioFiltro`(".$id_institucion.', '.$id_programa.', '.$id_comuna.', '.$id_estado.', '.($filtro == "null" ? $filtro : ("'".$filtro."'")).', '.$id_usuario.');');
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

	public function agregarPresupuesto($id_presupuesto, $id_programa, $presupuesto_6, $presupuesto_3, $presupuesto_4, $presupuesto_5, $id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`agregarPresupuesto`('.$id_presupuesto.', '.$id_programa.', '.$presupuesto_6.', '.$presupuesto_3.', '.$presupuesto_4.', '.$presupuesto_5.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function listarPresupuestos($id_programa, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarPresupuestos`(".$id_programa.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function listarPresupuestosMarco($id_programa, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarPresupuestosMarco`(".$id_programa.', '.$id_usuario.');');
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

	public function obtenerComponentesMarco($idMarco)
	{
		$query = $this->db->query("call `institucionminsal`.`obtenerComponentesMarco`(".$idMarco.");");
		return $query->result_array();
	}

	public function obtenerPresupuesto($idUsuario, $id_presupuesto)
	{
		$query = $this->db->query("call `institucionminsal`.`obtenerPresupuesto`(".$idUsuario.", ".$id_presupuesto.");");
		return $query->result_array();
	}

	public function obtenerMarco($idUsuario, $id_marco)
	{
		$query = $this->db->query("call `institucionminsal`.`obtenerMarco`(".$idUsuario.", ".$id_marco.");");
		return $query->result_array();
	}

	public function revisionConvenio($id_convenio, $id_estado, $observacion, $id_usuario)
	{
		$query = $this->db->query("call `institucionminsal`.`revisionConvenio`(".$id_convenio.", ".$id_estado.", '".$observacion."', ".$id_usuario.");");
		return $query->result_array();
	}

	public function listarComunasInstitucion($id_usuario, $id_institucion, $id_region)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarComunasInstitucion`(".$id_usuario.', '.$id_institucion.", ".$id_region.');');
		return $query->result_array();
	}

	public function listarMarcosSinDistribucion($id_institucion, $id_programa, $inicio, $cantidad, $filtro, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarMarcosSinDistribucion`(".$id_institucion.', '.$id_programa.', '.$inicio.', '.$cantidad.', '.($filtro == "null" ? $filtro : ("'".$filtro."'")).', '.$id_usuario.');');
		return $query->result_array();
	}

	public function cantlistarMarcosSDF($id_institucion, $id_programa, $filtro, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`cantlistarMarcosSDF`(".$id_institucion.', '.$id_programa.', '.($filtro == "null" ? $filtro : ("'".$filtro."'")).', '.$id_usuario.');');
		return $query->result_array();
	}

	public function cantlistarMarcosSD($id_institucion, $id_programa, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`cantlistarMarcosSD`(".$id_institucion.', '.$id_programa.', '.$id_usuario.');');
		return $query->result_array();
	}

	public function agregarMarcoConvenio($id_grupo_marco, $id_marco, $hospital, $comuna, $convenio, $numResolucion, $fechaResolucion, $id_usuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`agregarMarcoConvenio`(".$id_grupo_marco.', '.$id_marco.', '.$hospital.', '.$comuna.', '.$convenio.', '.$numResolucion.', '.($fechaResolucion == "null" ? $fechaResolucion : ("'".$fechaResolucion."'")).', '.$id_usuario.');');
		return $query->result_array();
	}
	
}	