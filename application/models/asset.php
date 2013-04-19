<?php

class Asset extends DataMapper {

    var $table = "assets";
    var $has_many = array("asset_detail");
    var $validation = array(
        'asset_name' => array(
            'label' => 'Asset Name',
            'rules' => array('required')
        ),
        'asset_status' => array(
            'label' => 'Asset Status',
            'rules' => array('required')
        )
    );

    function __construct() {
        parent::__construct();
    }

    function _delete($id) {
        $this->db->where('asset_id', $id);
        $this->db->delete($this->table);
    }

}

?>