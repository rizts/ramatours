<?php
class Cuti_model extends CI_Model{
  function get_all(){
    return $this->db->get("cuti");
  }
  
  function get($id){
    return $this->db->get_where("cuti", array("id"=>$id));      
  }

  function list_where($key = null, $value = null, $limit = 10, $offset = 0){
  	$this->db->join('staffs','staffs.staff_id=cuti.staff_id');  	
  	$this->db->join('branches','branches.branch_name=staffs.staff_cabang');  	

	if ((isset($key) && isset($value)) && (($key != '0' || $key != '') && $value != '')) {
		$this->db->like($key,$value);
	}

	$this->db->limit($limit,$offset);

    return $this->db->get("cuti");
  }
  
  function add(){
    $staff_id = $this->input->post("staff_id");
    $date_request = $this->input->post("date_request");
    $date_start = $this->input->post("date_start");
    $date_end = $this->input->post("date_end");
    $status = $this->input->post("status");
    $comment = $this->input->post("comment");
    $approve_by = $this->input->post("approveby_staff_id");
    if($staff_id){
      $this->db->insert("cuti", array(
        "staff_id"=>$staff_id,
        "approveby_staff_id"=>$approve_by,
        "date_request"=>$date_request,
        "date_start"=>$date_start,
        "date_end"=>$date_end,
        "status"=>$status
      ));
      $cuti_id = $this->db->insert_id();
      if($status != "pending"){
        $date = date("c");
        $this->db->insert("cuti_detail", array(
          "cuti_id"=>$cuti_id,
          "comment_date"=>$date,
          "comment"=>$comment
        ));
      }
    }
  }
  
  function update(){
    $id = $this->input->post("id");
    $staff_id = $this->input->post("staff_id");
    $date_request = $this->input->post("date_request");
    $date_start = $this->input->post("date_start");
    $date_end = $this->input->post("date_end");
    $status = $this->input->post("status");
    $comment = $this->input->post("comment");
    $approve_by = $this->input->post("approveby_staff_id");
    if($staff_id){
      $this->db->update("cuti", array(
        "staff_id"=>$staff_id,
        "approveby_staff_id"=>$approve_by,
        "date_request"=>$date_request,
        "date_start"=>$date_start,
        "date_end"=>$date_end,
        "status"=>$status
      ), array("id"=>$id));
      //$cuti_id = $this->db->insert_id();
      $date = date("c");
      $this->db->update("cuti_detail", array(
        "comment_date"=>$date,
        "comment"=>$comment
      ), array("cuti_id"=>$id));
    }
  }
  
  function update_status(){
      $id = $this->input->post("cuti_id");
      $date = date("c");
      $status = $this->input->post("status");
      $comment = $this->input->post("comment");
      $this->db->update("cuti", array(
        "status"=>$status
      ), array("id"=>$id));
      
      if($this->db->get_where("cuti_detail", array("cuti_id"=>$id))->num_rows() > 0){
        $this->db->update("cuti_detail", array(
          "comment_date"=>$date,
          "comment"=>$comment
        ), array("cuti_id"=>$id));      
      }else{
         $this->db->insert("cuti_detail", array(
          "cuti_id"=>$id,
          "comment_date"=>$date,
          "comment"=>$comment
        ));       
      }
      
  }
  
  function getDetail($id){
    $detail = $this->db->get_where("cuti_detail", array("cuti_id"=>$id));
    return $detail;
  }
}
