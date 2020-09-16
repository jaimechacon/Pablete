<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perc_model extends CI_Model
{

	/*function __construct(){
        parent::__construct();
        //load our second db and put in $db2
        $this->db2 = $this->load->database('perc', TRUE);
    }

    public function produccion_cost($year_in, $month_in, $entity_id_in)
	{
		$query = $this->db2->query('CALL `perc`.`sp_reporte_det_produccion_cost`('.$year_in.', '.$month_in.', '.$entity_id_in.');');
        return $query->result_array();
    }

    public function getEntities()
	{
		$usuario = $this->db2->get('entities');
		return $usuario->result_array();
	}

	public function produccion_cost_indirect($year_in, $month_in, $entity_id_in)
	{
		$query2 = $this->db2->query('CALL `perc`.`sp_reporte_cost_indirect`('.$year_in.', '.$month_in.', '.$entity_id_in.');');
        return $query2->result_array();
    }*/
}