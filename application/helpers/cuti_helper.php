<?php
function getApproval($module){
  $ci = &get_instance();
  $ci->load->model("Role", "role");
  $users = $ci->role->get_approval_permission($module);
  return $users;
}

function getDetail($id){
  $ci = &get_instance();
  $ci->load->model("Cuti_model", "cuti");
  $detail = $ci->cuti->getDetail($id);
  return $detail->row();
}
