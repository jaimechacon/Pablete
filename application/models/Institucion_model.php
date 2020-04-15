<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Institucion_model extends CI_Model
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

	public function listarInstitucionesUsuPagos($id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarInstitucionesUsuPagos`('.$id_usuario.');');
		return $query->result_array();
	}

	public function listarInstitucionesUsuPagosDevengado($id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarInstitucionesUsuPagosDevengado`('.$id_usuario.');');
		return $query->result_array();
	}

	public function listarInstitucionesUsuAPS($id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarInstitucionesUsuAPS`('.$id_usuario.');');
		return $query->result_array();
	}

	public function listarHospitalesUsuStock($id_usuario)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarHospitalesUsuStock`('.$id_usuario.');');
		return $query->result_array();
	}
	

}