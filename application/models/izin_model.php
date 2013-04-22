<?php
class Izin_model extends CI_Model{
  function get_all(){
    return $this->db->get("izin");
  }
  
  function get($id){
    return $this->db->get_where("izin", array("izin_id"=>$id));
  }

  function list_where($key = null, $value = null, $limit = 10, $offset = 0){
  	$this->db->join('staffs','staffs.staff_id=izin.izin_staff_id');  	
  	$this->db->join('branches','branches.branch_name=staffs.staff_cabang');  	

	if ((isset($key) && isset($value)) && (($key != '0' || $key != '') && $value != '')) {
		$this->db->like($key,$value);
	}

	$this->db->limit($limit,$offset);

    return $this->db->get("izin");
  }
  
  function add(){
    $izin_staff_id = $this->input->post("staff_id");
    $izin_date = $this->input->post("izin_date");
    $izin_jumlah_hari = $this->input->post("izin_jumlah_hari");
    $izin_note = $this->input->post("izin_note");
    if(strlen($izin_staff_id) > 0){
      $this->db->insert("izin", array(
        "izin_staff_id"=>$izin_staff_id,
        "izin_date"=>$izin_date,
        "izin_jumlah_hari"=>$izin_jumlah_hari,
        "izin_note"=>$izin_note
      ));
    }
  }
  
  function update(){
    $id = $this->input->post("id");
    $izin_staff_id = $this->input->post("staff_id");
    $izin_date = $this->input->post("izin_date");
    $izin_jumlah_hari = $this->input->post("izin_jumlah_hari");
    $izin_note = $this->input->post("izin_note");
    if(strlen($izin_staff_id) > 0){
      $this->db->update("izin", array(
        "izin_staff_id"=>$izin_staff_id,
        "izin_date"=>$izin_date,
        "izin_jumlah_hari"=>$izin_jumlah_hari,
        "izin_note"=>$izin_note
      ), array("izin_id"=>$id));
    }
  }
}
