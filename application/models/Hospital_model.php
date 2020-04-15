<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hospital_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function listarHospitalesUsu($id_usuario, $id_institucion)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarHospitalesUsu`('.$id_usuario.', '.$id_institucion.');');
		return $query->result_array();
	}

	public function listarHospitalesUsuPagos($id_usuario, $id_institucion)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarHospitalesUsuPagos`('.$id_usuario.', '.$id_institucion.');');
		return $query->result_array();
	}

	public function listarHospitalesUsuPagosTesoreria($id_usuario, $id_institucion)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarHospitalesUsuPagosTesoreria`('.$id_usuario.', '.$id_institucion.');');
		return $query->result_array();
	}

	public function listarHospitalesUsuPagosDevengados($id_usuario, $id_institucion)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarHospitalesUsuPagosDevengados`('.$id_usuario.', '.$id_institucion.');');
		return $query->result_array();
	}

	public function listarHospitalesUsuAPS($id_usuario, $id_institucion)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarHospitalesUsuAPS`('.$id_usuario.', '.$id_institucion.');');
		return $query->result_array();
	}

	public function listarHospitalesUsuStock($id_usuario, $id_institucion)
	{
		$query = $this->db->query('CALL `institucionminsal`.`listarHospitalesUsuStock`('.$id_usuario.', '.$id_institucion.');');
		return $query->result_array();
	}


}