<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producto_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function listarProductos()
	{
		$query = $this->db->query("call `institucionminsal`.`listarProductos`;");
		return $query->result_array();
	}

	public function eliminarProducto($idProducto, $idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`eliminarProducto`(".$idProducto.", ".$idUsuario.");");
		return $query->result_array();
	}

	public function agregarProducto($idProducto, $codigo, $nombre, $descripcion, $unidadMedida, $idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`agregarProducto`(".$idProducto.", '".$codigo."', '".$nombre."', '".$descripcion."', '".$unidadMedida."', ".$idUsuario.");");

		return $query->result_array();
	}

	public function obtenerProducto($idProducto)
	{
		$query = $this->db->query("call `institucionminsal`.`obtenerProducto`(".$idProducto.");");

		return $query->result_array();
	}

	public function agregarStockProducto($idStock, $stock, $descripcion, $numOrden, $idProducto, $idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`agregarStockProducto`(".$idStock.", ".$stock.", '".$descripcion."', '".$numOrden."', ".$idProducto.", ".$idUsuario.");");
		return $query->result_array();
	}

	public function listarStockProductos($idDistribucion)
	{
		$query = $this->db->query("call `institucionminsal`.`listarStockProductos`(".$idDistribucion.");");
		return $query->result_array();
	}

	public function listarIngresosStock($idProducto)
	{
		$query = $this->db->query("call `institucionminsal`.`listarIngresosStock`(".$idProducto.");");
		return $query->result_array();
	}

	public function listarProductosDisponibles()
	{
		$query = $this->db->query("call `institucionminsal`.`listarProductosDisponibles`;");
		return $query->result_array();
	}

	public function agregarDistribucion($idDistribucion, $idInstitucion, $stock, $numOrden, $tipoDoc, $observacion, $idProducto, $idUsuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`agregarDistribucion`(".$idDistribucion.", ".$idInstitucion.", ".$stock.", ".($numOrden == "null" ? $numOrden : ("'".$numOrden."'")).", ".($tipoDoc == "null" ? $tipoDoc : ("'".$tipoDoc."'")).", ".($observacion == "null" ? $observacion : ("'".$observacion."'")).",".$idProducto.", ".$idUsuario.");");
		return $query->result_array();
	}

	public function listarDistribucion($idProducto, $idUsuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarDistribucion`(".$idProducto.", ".$idUsuario.");");
		return $query->result_array();
	}

	public function listarDistribucionInstitucion($idProducto, $idInstitucion, $idUsuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`listarDistribucionInstitucion`(".$idProducto.", ".$idInstitucion.", ".$idUsuario.");");
		return $query->result_array();
	}

	public function agregarDistribucionInstitucion($idDistribucionInstitucion, $idInstitucion, $idHospital, $stock, $idProducto, $idUsuario)
	{
		$query = $this->db->query("CALL `institucionminsal`.`agregarDistribucionInstitucion`(".$idDistribucionInstitucion.", ".$idInstitucion.", ".$idHospital.", ".$stock.", ".$idProducto.", ".$idUsuario.");");
		return $query->result_array();
	}

	public function obtenerProductoInstitucion($idProducto, $idInstitucion)
	{
		$query = $this->db->query("call `institucionminsal`.`obtenerProductoInstitucion`(".$idProducto.", ".$idInstitucion.");");

		return $query->result_array();
	}

	public function listarIngresosStockInstitucion($idProducto, $idInstitucion, $idUsuario)
	{
		$query = $this->db->query("call `institucionminsal`.`listarIngresosStockInstitucion`(".$idProducto.", ".$idInstitucion.", ".$idUsuario.");");
		return $query->result_array();
	}
	


}	