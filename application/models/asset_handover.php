<?php

class Asset_Handover extends DataMapper {

    var $table = "asset_handover";
    var $has_one = array("asset");
    var $validation = array(
        'trasset_asset_id' => array(
            'label' => 'Asset ID',
            'rules' => array('required')
        ),
        'trasset_date_time' => array(
            'label' => 'Date Transaction',
            'rules' => array('required')
        ),
        'trasset_status' => array(
            'label' => 'Status Asset',
            'rules' => array('required')
        /*),
        'trasset_doc_no' => array(
            'label' => 'Document Number',
            'rules' => array('required')*/
        ),
        'trasset_staff_id_from' => array(
            'label' => 'Staff ID From',
            'rules' => array('required')
        ),
        'trasset_staff_id_to' => array(
            'label' => 'Staff ID To',
            'rules' => array('required')
        ),
        'trasset_note' => array(
            'label' => 'Description',
            'rules' => array('required')
        )
    );

    function __construct() {
        parent::__construct();
    }

    function _delete($id) {
        $this->db->where('trasset_id', $id);
        $this->db->delete($this->table);
    }

}

?>