<?php
function get_staff_detail($id){
  $ci = &get_instance();
  $ci->load->model("Staff", "staff");
  return $ci->staff->get_staff_detail($id)->row();
}

function get_user_detail($id){
  $ci = &get_instance();
  $ci->load->model("User", "user");
  return $ci->user->get_user_detail($id)->row();
}

function get_component_a($id){
  $ci = &get_instance();
  $result = $ci->db->get_where("salary_components_a", array("staff_id"=>$id));
  return $result;
}

function get_component_b($id){
  $ci = &get_instance();
  $result = $ci->db->get_where("salary_components_b", array("staff_id"=>$id));
  return $result;
}

function get_families($id){
  $ci = &get_instance();
  $result = $ci->db->get_where("families", array("staff_fam_staff_id"=>$id));
  return $result;
}

function get_medics($id){
  $ci = &get_instance();
  $result = $ci->db->get_where("medical_histories", array("staff_id"=>$id));
  return $result;
}

function get_works($id){
  $ci = &get_instance();
  $result = $ci->db->get_where("work_histories", array("staff_id"=>$id));
  return $result;
}

function get_edu($id){
  $ci = &get_instance();
  $result = $ci->db->get_where("educations", array("staff_id"=>$id));
  return $result;
}

function get_components($id){
  $ci = &get_instance();
  $result = $ci->db->get_where("components", array("comp_id"=>$id))->row();
  return $result;
}