<?php
class Absensi_model extends CI_Model{
  function get_all(){
    return $this->db->get("absensi");
  }
  
  function get($id){
    return $this->db->get_where("absensi", array("id"=>$id));
  }

  function list_where($key = null, $value = null, $limit = 10, $offset = 0){
  	$this->db->join('staffs','staffs.staff_id=absensi.staff_id');  	
  	$this->db->join('branches','branches.branch_name=staffs.staff_cabang');  	

	if ((isset($key) && isset($value)) && (($key != '0' || $key != '') && $value != '')) {
		$this->db->like($key,$value);
	}

	$this->db->limit($limit,$offset);

    return $this->db->get("absensi");
  }
  
  function add(){
    $staff_id = $this->input->post("staff_id");
    $date = $this->input->post("date");
    $hari_masuk = $this->input->post("hari_masuk");
    $this->db->insert("absensi", array(
      "staff_id"=>$staff_id,
      "date"=>$date,
      "hari_masuk"=>$hari_masuk
    ));
  }
  
  function add_csv($data){
    $staff = $this->db->get_where("staffs", array("staff_kode_absen"=>$data["kode_absen"]));
    if($staff->num_rows() > 0){
      $staff = $staff->row();
      $staff_id = $staff->staff_id;
      $date = date("c");
      $hari_masuk = $data["hari_masuk"];
      $this->db->insert("absensi", array(
        "staff_id"=>$staff_id,
        "date"=>$date,
        "hari_masuk"=>$hari_masuk
      ));
    }
  }
  
  function update(){
    $id = $this->input->post("id");
    $staff_id = $this->input->post("staff_id");
    $date = $this->input->post("date");
    $hari_masuk = $this->input->post("hari_masuk");
    $this->db->update("absensi", array(
      "staff_id"=>$staff_id,
      "date"=>$date,
      "hari_masuk"=>$hari_masuk
    ), array("id"=>$id));
  }
  
  function get_staff($by, $staff_name){
    return $this->db->like($by, $staff_name)->get("staffs");
  }
  
}
