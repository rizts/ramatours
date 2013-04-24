<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assets_Handover extends CI_Controller {

    private $limit = 10;
    var $asset_id;
    var $uri_segment;
    var $detail_id;

    function __construct() {
        parent::__construct();
        $this->load->model('Asset');
        $this->load->model('Asset_Detail');
        $this->sess_username = $this->session->userdata('username');
        $this->sess_role_id = $this->session->userdata('sess_role_id');
        $this->sess_staff_id = $this->session->userdata('sess_staff_id');
        $this->session->userdata('logged_in') == true ? '' : redirect('users/sign_in');
    }

    public function index($offset = 0) {
        $asset_list = new Asset();
        $data['staff'] = new Staff();

        switch ($this->input->get('c')) {
            case "1":
                $data['col'] = "asset_name";
                break;
            case "2":
                $data['col'] = "asset_status";
                break;
            case "3":
                $data['col'] = "staff_id";
                break;
            case "4":
                $data['col'] = "date";
                break;
            case "5":
                $data['col'] = "asset_id";
                break;
            default:
                $data['col'] = "asset_id";
        }

        if ($this->input->get('d') == "1") {
            $data['dir'] = "DESC";
        } else {
            $data['dir'] = "ASC";
        }

        $total_rows = $asset_list->count();
        $data['title'] = "Assets";
        $data['btn_home'] = anchor(base_url(), 'Home', array('class' => 'btn'));

        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        $asset_list->order_by($data['col'], $data['dir']);
        $data['asset_list'] = $asset_list->get($this->limit, $offset)->all;

        $config['base_url'] = site_url("assets/index");
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('assets_handover/index', $data);
    }

    public function detail($offset = 0) {
        $asset_handover = new Asset_Handover();
        $data['staff'] = new Staff();

        $this->asset_id = $this->uri->segment(2);
        $this->uri_segment = $this->uri->segment(5);
        $this->detail_id = $this->uri->segment(5);

  	$data['asset_id'] = $this->asset_id;
		$data['detail_id'] = $this->detail_id;

        switch ($this->input->get('c')) {
            case "1":
                $data['col'] = "trasset_date_time";
                break;
            case "2":
                $data['col'] = "trasset_staff_id_from";
                break;
            case "3":
                $data['col'] = "trasset_doc_no";
                break;
            case "4":
                $data['col'] = "trasset_status";
                break;
            case "5":
                $data['col'] = "trasset_doc_no";
                break;
            case "6":
                $data['col'] = "trasset_id";
                break;
            default:
                $data['col'] = "trasset_id";
        }

        if ($this->input->get('d') == "1") {
            $data['dir'] = "DESC";
        } else {
            $data['dir'] = "ASC";
        }

        $asset_handover->where('trasset_asset_id', $this->asset_id)->order_by($data['col'], $data['dir']);

        $total_rows = $asset_handover->count();
        $data['asset_id'] = $this->asset_id;
        $data['title'] = "Assets Handover";
        $data['btn_add'] = anchor('assets/' . $this->asset_id . '/handover/add', 'Add New', array('class' => 'btn btn-primary'));
        $data['btn_home'] = anchor('assets/', 'Home', array('class' => 'btn'));

        $offset = $this->uri->segment($this->uri_segment);

        $data['assets_handover'] = $asset_handover
                        ->where('trasset_asset_id', $this->asset_id)
                        ->order_by($data['col'], $data['dir'])
                        ->get($this->limit, $offset)->all;

        $config['base_url'] = site_url('assets/' . $this->asset_id . '/handover/detail');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $this->uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('assets_handover/detail', $data);
    }

    function add() {
        $this->asset_id = $this->uri->segment(2);
        $this->uri_segment = $this->uri->segment(5);
        $this->detail_id = $this->uri->segment(5);

        $data['asset_id'] = $this->asset_id;
	  	$data['detail_id'] = $this->detail_id;

        $data['title'] = 'Add New Asset Handover';
        $data['form_action'] = site_url('assets/' . $this->asset_id . '/handover/save');
        $data['link_back'] = anchor('assets/' . $this->asset_id . '/handover/detail', 'Back', array('class' => 'btn'));

        $data['id'] = '';
        $data['date'] = array('name' => 'trasset_date_time', 'id' => 'trasset_date_time');

        // Staffs
        $staff = new Staff();
        $list_staff = $staff->list_drop();
        $staff_selected = '';
        $data['staff_id_from'] = form_dropdown('trasset_staff_id_from', $list_staff, $staff_selected);
        $data['staff_id_to'] = form_dropdown('trasset_staff_id_to', $list_staff, $staff_selected);

        $data['trasset_note'] = array('name' => 'trasset_note', 'rows' => '6');
        $options_status = array(
            'Penyerahan' => 'Penyerahan',
            'Pengembalian' => 'Pengembalian'
        );
        $status_selected = '1';
        $data['trasset_status'] = form_dropdown('trasset_status', $options_status, $status_selected);
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');

        $this->load->view('assets_handover/frm_assets_handover', $data);
    }

    function edit() {
        $this->asset_id = $this->uri->segment(2);
        $this->uri_segment = $this->uri->segment(5);
        $this->detail_id = $this->uri->segment(5);

        $data['asset_id'] = $this->asset_id;
	  	$data['detail_id'] = $this->detail_id;

        $asset_handover = new Asset_Handover();

        $rs = $asset_handover->where('trasset_id', $this->detail_id)->get();
        $data['id'] = $rs->trasset_id;
        $data['date'] = array('name' => 'trasset_date_time', 'id' => 'trasset_date_time', 'value' => $rs->trasset_date_time);
        $options_status = array(
            'Penyerahan' => 'Penyerahan',
            'Pengembalian' => 'Pengembalian'
        );
        $status_selected = $rs->trasset_status;
        $data['trasset_status'] = form_dropdown('trasset_status', $options_status, $status_selected);

        // Staffs
        $staff = new Staff();
        $list_staff = $staff->list_drop();
        $staff_from_selected = $rs->trasset_staff_id_from;
        $staff_to_selected = $rs->trasset_staff_id_to;
        $data['staff_id_from'] = form_dropdown('trasset_staff_id_from', $list_staff, $staff_from_selected);
        $data['staff_id_to'] = form_dropdown('trasset_staff_id_to', $list_staff, $staff_to_selected);

        $data['trasset_note'] = array('name' => 'trasset_note', 'value' => $rs->trasset_note);
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Update', 'class' => 'btn btn-primary');

        $data['title'] = 'Update';
        $data['form_action'] = site_url('assets/' . $this->asset_id . '/handover/update');
        $data['link_back'] = anchor('assets/' . $this->asset_id . '/handover/detail', 'Back', array('class' => 'btn'));

        $this->load->view('assets_handover/frm_assets_handover', $data);
    }

    function save() {
        $this->asset_id = $this->uri->segment(2);
        $this->uri_segment = $this->uri->segment(5);
        $this->detail_id = $this->uri->segment(5);

	  	$data['asset_id'] = $this->asset_id;
	  	$data['detail_id'] = $this->detail_id;

        $asset_handover = new Asset_Handover();
        $asset_handover->trasset_asset_id = $this->asset_id;
        $asset_handover->trasset_status = $this->input->post('trasset_status');
        $asset_handover->trasset_staff_id_from = $this->input->post('trasset_staff_id_from');
        $asset_handover->trasset_staff_id_to = $this->input->post('trasset_staff_id_to');
        $asset_handover->trasset_date_time = $this->input->post('trasset_date_time');
        $asset_handover->trasset_note = $this->input->post('trasset_note');
        if ($asset_handover->save()) {
        	$asset = new Asset();
	    	$asset = new Asset();
	    	$asset->where('asset_id',$this->asset_id)->update(array('staff_id'=>$this->input->post('trasset_staff_id_to'),'date'=>$this->input->post('trasset_date_time')));

            $this->session->set_flashdata('message', 'Asset handover successfully created!');
            redirect('assets/' . $this->asset_id . '/handover/detail');
        } else {
            // Failed
            $asset_handover->error_message('custom', 'Field required');
            $msg = $asset_handover->error->custom;
            $this->session->set_flashdata('message', $msg);
            redirect('assets/' . $this->asset_id . '/handover/add');
        }
    }

    function update() {
        $this->asset_id = $this->uri->segment(2);
        $this->uri_segment = $this->uri->segment(5);
        $this->detail_id = $this->uri->segment(5);

        $asset_handover = new Asset_Handover();
        if ($asset_handover->where('trasset_id', $this->input->post('id'))
                ->update(array(
                    'trasset_date_time' => $this->input->post('trasset_date_time'),
                    'trasset_staff_id_from' => $this->input->post('trasset_staff_id_from'),
                    'trasset_staff_id_to' => $this->input->post('trasset_staff_id_to'),
                    'trasset_note' => $this->input->post('trasset_note'),
                    'trasset_status' => $this->input->post('trasset_status')
                        )
        )) {
	    	$asset = new Asset();
	    	$asset->where('asset_id',$this->asset_id)->update(array('staff_id'=>$this->input->post('trasset_staff_id_to'),'date'=>$this->input->post('trasset_date_time')));

	        $this->session->set_flashdata('message', 'Asset detail Update successfuly.');
	        redirect('assets/' . $this->asset_id . '/handover/detail');
        }
    }

    function delete() {
        $this->asset_id = $this->uri->segment(2);
        $this->uri_segment = $this->uri->segment(5);
        $this->detail_id = $this->uri->segment(5);

        $asset_handover = new Asset_Handover();
        $id = $this->detail_id;
        $asset_handover->_delete($id);

        $this->session->set_flashdata('message', 'Asset handover successfully deleted!');
        redirect('assets/' . $this->asset_id . '/handover/detail');
    }

    function report() {
        $this->asset_id = $this->uri->segment(2);
        $this->uri_segment = $this->uri->segment(5);
        $this->detail_id = $this->uri->segment(5);

        $asset = new Asset();
        $rs = $asset->where('asset_id', $this->asset_id)->get();
        $data['id'] = $rs->asset_id;
        $data['asset_name'] = $rs->asset_name;
        $data['asset_code'] = $rs->asset_code;
        $data['asset_status'] = $rs->asset_status == '1'? 'Enable':'Disable';

        $date = new DateTime($rs->date);
        $data['date_handover'] = ($rs->date == '0000-00-00' || $rs->date == '0000-00-00 00:00:00')? '':$date->format('d-m-Y');
        $data['description'] = $rs->discription;

        // Staffs
        $staff = new Staff();
        $used_by = $staff->where('staff_id',$rs->staff_id)->get();
        $data['staff_name'] = $used_by->staff_name;

        $data['date'] = array('name' => 'date', 'id' => 'date', 'value' => $rs->date);

        $asset_handover = new Asset_Handover();
        $data['staff'] = new Staff();

        $this->asset_id = $this->uri->segment(2);
        $this->uri_segment = $this->uri->segment(5);
        $this->detail_id = $this->uri->segment(5);

		$data['asset_id'] = $this->asset_id;
		$data['detail_id'] = $this->detail_id;

        $asset_handover->where('trasset_asset_id', $this->asset_id)->order_by('trasset_id', 'ASC');

        $total_rows = $asset_handover->count();
        $data['asset_id'] = $this->asset_id;
        $data['title'] = "Assets Handover";
        $data['btn_home'] = anchor('assets/', 'Home', array('class' => 'btn'));

        $offset = $this->uri->segment($this->uri_segment);

        $data['assets_handover'] = $asset_handover
                        ->where('trasset_asset_id', $this->asset_id)
                        ->order_by('trasset_id', 'ASC')
                        ->get($this->limit, $offset)->all;

		if ($this->input->get('to') == 'pdf') {
			$data['id'] = $rs->asset_id;
	        $data['asset_name'] = $rs->asset_name;
	        $data['asset_code'] = $rs->asset_code;
	        $data['asset_status'] = $rs->asset_status == '1'? 'Enable':'Disable';

	        $date = new DateTime($rs->date);
	        $data['date_handover'] = ($rs->date == '0000-00-00' || $rs->date == '0000-00-00 00:00:00')? '':$date->format('d-m-Y');
	        $data['description'] = $rs->discription;

			$this->load->library('html2pdf');

			$this->html2pdf->filename = 'detail_asset_handover_report.pdf';
	    	$this->html2pdf->paper('a4', 'landscape');
	    	$this->html2pdf->html($this->load->view('assets_handover/to_pdf', $data, true));
	    
	    	$this->html2pdf->create();
		} else if ($this->input->get('to') == 'xls') {
			$data['id'] = $rs->asset_id;
	        $data['asset_name'] = $rs->asset_name;
	        $data['asset_code'] = $rs->asset_code;
	        $data['asset_status'] = $rs->asset_status == '1'? 'Enable':'Disable';

	        $date = new DateTime($rs->date);
	        $data['date_handover'] = ($rs->date == '0000-00-00' || $rs->date == '0000-00-00 00:00:00')? '':$date->format('d-m-Y');
	        $data['description'] = $rs->discription;

			$param['file_name'] = 'detail_asset_handover_report.xls';
    		$param['content_sheet'] = $this->load->view('assets_handover/to_pdf', $data, true);
    		$this->load->view('to_excel',$param);
		} else {
	        $config['base_url'] = site_url('assets/' . $this->asset_id . '/handover/detail');
	        $config['total_rows'] = $total_rows;
	        $config['per_page'] = $this->limit;
	        $config['uri_segment'] = $this->uri_segment;
	        $this->pagination->initialize($config);
	        $data['pagination'] = $this->pagination->create_links();

	        $this->load->view('assets_handover/report', $data);
        }
    }

    function filter_access($module, $field, $page) {
        $user = new User();
        $status_access = $user->get_access($this->sess_role_id, $module, $field);

        if ($status_access == false) {
            $msg = '<div class="alert alert-error">You do not have access to this page, please contact administrator</div>';
            $this->session->set_flashdata('message', $msg);
            redirect($page);
        }
    }

}
