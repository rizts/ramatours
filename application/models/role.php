<?php

class Role extends DataMapper {

    var $table = "user_roles";
    var $validation = array(
        'role_name' => array(
            'label' => 'Role Name',
            'rules' => array('required')
        )
    );
    
    function get_approval_permission($module){
      $result = $this->db->get("users");
      $user_list = array();
      if($result->num_rows() > 0){
        foreach($result->result() as $user){
          $role_id = $user->role_id;
          $roles = $this->db->get_where("user_roled", array("roled_approval"=>"1", "roled_module"=>$module));
          if($roles->num_rows() > 0){
            $user_list[$user->id] = $user->username;
          }
        }
      }
      return $user_list;
    }
    
    function _get($id){
      return $this->db->get_where("user_roles", array("role_id"=>$id))->row();
    }

    function __construct() {
        parent::__construct();
    }

    function _delete($id) {
        $this->db->where('role_id', $id);
        $this->db->delete($this->table);
    }

    function list_drop() {
        $role = new Role();
        $role->get();
        foreach ($role as $row) {
            $data[''] = '[ User Role ]';
            $data[$row->role_id] = $row->role_name;
        }
        return $data;
    }

}

?>
