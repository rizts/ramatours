<?php
class Module_model extends CI_Model{
  function get_all(){
    return $this->db->get("module");  
  }
  
  function get_by($field, $val){
    return $this->db->get_where("module", array($field=>$val))->row();  
  }
  
  // return inserted id or if exists return module id
  function add($module){
    $ret = 0;
    if($this->_check_if_exists($module) == false){
      $this->db->insert("module", array(
        "name"=>$module
      )); 
      $ret = $this->db->insert_id();
    }else{
      $mod = $this->get_by("name", $module);
      $ret = $mod->id;
    }
    return $ret;
  }
  
  function update($module_name, $module_id){
    $this->db->update("module", array("name"=>$module_name), array("id"=>$module_id));
  }
  
  private function _check_if_exists($module){
    $ret = false;
    $result = $this->db->get_where("module", array("name"=>$module));
    if($result->num_rows() > 0) $ret = true;
    return $ret;  
  }
}