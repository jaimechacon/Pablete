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
}	