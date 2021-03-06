<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('get_total_component_a')) {

    function get_total_component_a($staff_id,$period) {
    	$total = 0;
    	$ci = &get_instance();
    	$ci->db->select('components.comp_id,components.comp_type,absensi.date,absensi.hari_masuk,salary_components_a.staff_id,salary_components_a.gaji_daily_value,salary_components_a.gaji_amount_value');
    	$ci->db->join('components','components.comp_id=salary_components_a.gaji_component_id');
    	$ci->db->join('absensi','absensi.staff_id=salary_components_a.staff_id');
    	$ci->db->where('salary_components_a.staff_id',$staff_id);
    	$ci->db->where("DATE_FORMAT(absensi.date,'%Y-%m')",$period);
  		$comp_a = $ci->db->get("salary_components_a");
		foreach($comp_a->result() as $sal_a) {
			$comp = 0;
			if ($sal_a->comp_type == 'Daily') {
				$comp = $sal_a->hari_masuk*$sal_a->gaji_daily_value;
			} else if ($sal_a->comp_type == 'Monthly') {
				$comp = $sal_a->gaji_amount_value;
			}
			$total += $comp;
		}
		return $total;
    }
}

if (!function_exists('get_total_component_b')) {

    function get_total_component_b($staff_id,$period) {
    	$total = 0;
    	$ci = &get_instance();
    	$ci->db->select('components.comp_id,components.comp_type,absensi.date,absensi.hari_masuk,salary_components_b.staff_id,salary_components_b.gaji_daily_value,salary_components_b.gaji_amount_value');
    	$ci->db->join('components','components.comp_id=salary_components_b.gaji_component_id');
    	$ci->db->join('absensi','absensi.staff_id=salary_components_b.staff_id');
    	$ci->db->where('salary_components_b.staff_id',$staff_id);
    	$ci->db->where("DATE_FORMAT(absensi.date,'%Y-%m')",$period);
  		$comp_b = $ci->db->get("salary_components_b");
		foreach($comp_b->result() as $sal_b) {
			$comp = 0;
			if ($sal_b->comp_type == 'Daily') {
				$comp = $sal_b->hari_masuk*$sal_b->gaji_daily_value;
			} else if ($sal_b->comp_type == 'Monthly') {
				$comp = $sal_b->gaji_amount_value;
			}
			$total += $comp;
		}
		return $total;
    }
}

if (!function_exists('get_total_monthly_tax')) {

    function get_total_monthly_tax($staff_id) {
		//tax const
		$wp 			= 24300000;
		$tj_percent     = floatval("0.05");
		$tj_max 		= 6000000;
		$net1 			= 50000000;
		$net2 			= 250000000;
		$net3 			= 500000000;
		$pph_percent1 	= floatval("0.05");
		$pph_percent2 	= floatval("0.15");
		$pph_percent3 	= floatval("0.25");
		$pph_percent4 	= floatval("0.3");

    	$total = 0;
    	$ci = &get_instance();
    	$ci->db->join('taxes_employees','staffs.staff_status_pajak=taxes_employees.sp_status');
    	$ci->db->join('salary_components_a','salary_components_a.staff_id=staffs.staff_id');
    	$ci->db->join('components','components.comp_id=salary_components_a.gaji_component_id');
    	$ci->db->where('staffs.staff_id',$staff_id);
    	$ci->db->where('components.comp_type','Monthly');
  		$staff_tax = $ci->db->get("staffs")->row();

		$ptkp = $wp + (count($staff_tax) > 0? $staff_tax->sp_ptkp:0);

		$gj = (count($staff_tax) > 0? $staff_tax->gaji_amount_value*12:0);
		$tj = $gj * $tj_percent;

		if ($tj > $tj_max) $tj = $tj_max;

		$net = $gj - $tj - $ptkp;

		if ($net <= $net1) $pph = $net * $pph_percent1;
		else if ($net > $net1 && $net <= $net2) $pph = $net * $pph_percent2;
		else if ($net > $net2 && $net <= $net3) $pph = $net * $pph_percent3;
		else if ($net > $net3) $pph = $net * $pph_percent4;

		return $pph/12;
    }
}