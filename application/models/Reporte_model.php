<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function listarInstitucionesUsu($id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarInstitucionesUsu`('.$id_usuario.');');
		return $query->result_array();
	}

	public function listarReporteResumen($id_usuario, $id_institucion, $id_hospital, $id_cuenta)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteResumen`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.');');
		return $query->result_array();
	}

	public function listarReporteResumenGasto($id_usuario, $id_institucion, $id_hospital, $id_cuenta)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteResumenGasto`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.');');
		return $query->result_array();
	}

	public function listarReporteResumenTipo($id_usuario, $id_institucion, $id_hospital, $id_cuenta)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteResumenTipo`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.');');
		return $query->result_array();
	}

	public function listarReporteResumenTipoGasto($id_usuario, $id_institucion, $id_hospital, $id_cuenta)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteResumenTipoGasto`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.');');
		return $query->result_array();
	}

	public function listarReporteResumenItem($id_usuario, $id_institucion, $id_hospital, $id_cuenta, $id_tipo)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteResumenItem`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.', '.$id_tipo.');');
		return $query->result_array();
	}

	public function listarReporteResumenAsignacion($id_usuario, $id_institucion, $id_hospital, $id_cuenta, $id_item, $id_tipo)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteResumenAsignacion`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.', '.$id_item.', '.$id_tipo.');');
		return $query->result_array();
	}

	public function listarReporteResumenSubAsignacion($id_usuario, $id_institucion, $id_hospital, $id_cuenta, $id_item, $id_asignacion, $id_tipo)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteResumenSubAsignacion`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.', '.$id_item.', '.$id_asignacion.', '.$id_tipo.');');
		return $query->result_array();
	}

	public function listarReporteResumenEspecifico($id_usuario, $id_institucion, $id_hospital, $id_cuenta, $id_item, $id_asignacion, $id_sub_asignacion, $id_tipo)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteResumenEspecifico`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.', '.$id_item.', '.$id_asignacion.', '.$id_sub_asignacion.', '.$id_tipo.');');
		return $query->result_array();
	}

	public function obtenerAniosTransacciones()
	{
		$query = $this->db->query('CALL `institucionminsal`.`obtenerAniosTransacciones`;');
		return $query->result_array();
	}

	public function listarReporteResumenFecha($id_usuario, $id_institucion, $id_hospital, $id_cuenta, $mes, $anio, $inflactor, $id_tipo)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteResumenFecha`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.', '.$mes.', '.$anio.', '.$inflactor.', '.$id_tipo.');');
		return $query->result_array();
	}

	public function listarReporteGrafico($id_usuario, $id_institucion, $id_hospital, $id_cuenta, $id_tipo)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteGrafico`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.', '.$id_tipo.');');
		return $query->result_array();
	}

	public function listarReporteResumenGrafico($id_usuario, $id_institucion, $id_hospital, $id_tipo)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteResumenGrafico`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_tipo.');');
		return $query->result_array();
	}	

	public function listarReporteGrafico22($id_usuario, $id_institucion, $id_hospital)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteGrafico22`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.');');
		return $query->result_array();
	}

	public function listarReporteGraficoProduccion($id_usuario, $id_institucion, $id_hospital, $id_grupo_prestacion)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteGraficoProduccion`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_grupo_prestacion.');');
		return $query->result_array();
	}

	public function listarReporteEquilibrioFinanciero($id_usuario, $id_institucion, $id_hospital, $id_cuenta, $mes, $anio)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteEquilibrioFinanciero`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.', '.$mes.', '.$anio.');');
		return $query->result_array();
	}

	public function listarReporteRecaudacionIngresos($id_usuario, $id_institucion, $id_hospital, $anio, $mes)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteRecaudacionIngresos`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$anio.', '.$mes.');');
		return $query->result_array();
	}

	public function listarUsuariosEvaluados($id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarUsuariosEvaluados`('.$id_usuario.');');
		return $query->result_array();
	}

	public function listarUsuariosEvaluadosUsuario($id_usuario, $id_institucion)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarUsuariosEvaluadosUsuario`('.$id_usuario.', '.$id_institucion.');');
		return $query->result_array();
	}

	public function listarReporteRecaudacionIngresosSS($id_usuario, $id_institucion, $id_hospital, $anio, $mes)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteRecaudacionIngresosSS`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$anio.', '.$mes.');');
		return $query->result_array();
	}

	public function listarReporteEquilibrioFinancieroSS($id_usuario, $id_institucion, $id_hospital, $id_cuenta, $mes, $anio)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteEquilibrioFinancieroSS`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$id_cuenta.', '.$mes.', '.$anio.');');
		return $query->result_array();
	}

	public function listarReporteRecaudacionIngresosPDF($id_usuario, $id_institucion, $id_hospital, $anio, $mes)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteRecaudacionIngresosPDF`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$anio.', '.$mes.');');
		return $query->result_array();
	}

	public function listarUsuariosEvaluadosUsuarioSubDirector($id_usuario, $id_institucion)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarUsuariosEvaluadosUsuarioSubDirector`('.$id_usuario.', '.$id_institucion.');');
		return $query->result_array();
	}

	public function listarReporteEquilibrioFinancieroPDF($id_usuario, $id_institucion, $id_hospital, $anio, $mes)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarReporteEquilibrioFinancieroPDF`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$anio.', '.$mes.');');
		return $query->result_array();
	}

	public function listarPagosTesoreriaUsu($id_usuario, $id_institucion, $id_hospital, $rut_proveedor)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarPagosTesoreriaUsu`('.$id_usuario.', '.$id_institucion.', '.$id_hospital.', '.$rut_proveedor.');');
		return $query->result_array();
	}

	public function listarResumenProgramas($id_usuario, $id_institucion, $id_region, $id_comuna)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarResumenProgramas`('.$id_usuario.', '.$id_institucion.', '.$id_region.', '.$id_comuna.');');
		return $query->result_array();
	}

	public function listarResumenProgramasAPS($id_usuario, $id_institucion, $id_region, $id_comuna)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarResumenProgramasAPS`('.$id_usuario.', '.$id_institucion.', '.$id_region.', '.$id_comuna.');');
		return $query->result_array();
	}

	public function listarResumenProgramasAPSSS($id_usuario, $id_institucion, $id_region, $id_comuna)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarResumenProgramasAPSSS`('.$id_usuario.', '.$id_institucion.', '.$id_region.', '.$id_comuna.');');
		return $query->result_array();
	}

	public function listarRegionesUsu($id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarRegionesUsu`('.$id_usuario.');');
		return $query->result_array();
	}
	
	public function listarComunasUsu($id_usuario, $id_region)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarComunasUsu`('.$id_usuario.', '.$id_region.');');
		return $query->result_array();
	}

	public function listarTipoDocumentosPagosDevengado($id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarTipoDocumentosPagosDevengado`('.$id_usuario.');');
		return $query->result_array();
	}

	public function listarPagosDevengados($id_institucion, $id_hospital, $tipo_documento, $id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarPagosDevengados`('.$id_institucion.', '.$id_hospital.', '.$tipo_documento.', '.$id_usuario.');');
		return $query->result_array();
	}
}	