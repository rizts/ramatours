<?php
class Cuti extends CI_Controller{
  private $limit = 10;
  function __construct(){
    parent::__construct();
    $this->load->model("Cuti_model", "cuti");
    $this->load->helper("staff");
    $this->load->helper("cuti");
  }
  
  function index(){
    switch ($this->input->get('c')) {
      case "1":
          $data['col'] = "staff_id";
          break;
      case "2":
          $data['col'] = "date_request";
          break;
      case "3":
          $data['col'] = "date_start";
          break;
      case "4":
          $data['col'] = "date_end";
          break;
      default:
          $data['col'] = "staff_id";
    }

    if ($this->input->get('d') == "1") {
        $data['dir'] = "DESC";
    } else {
        $data['dir'] = "ASC";
    }
    $total_rows = $this->cuti->get_all()->num_rows();
    $data['title'] = "Izin";
    $data['btn_add'] = anchor('cuti/add', 'Add New', array('class' => 'btn btn-primary'));
    $data['btn_home'] = anchor(base_url(), 'Home', array('class' => 'btn'));

    $uri_segment = 3;
    $offset = $this->uri->segment($uri_segment);
    $data['cuti'] = $this->cuti->get_all();

    $config['base_url'] = site_url("cuti/index");
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $this->limit;
    $config['uri_segment'] = $uri_segment;
    $this->pagination->initialize($config);
    $data['pagination'] = $this->pagination->create_links();
    
    // update status purpose
    $data["status"] = array(
      "pending"=>"Pending",
      "approve"=>"Approve",
      "decline"=>"Decline"
    );
    
    $data["comment"] = array("name"=>"comment", "id"=>"comment");
    
    $this->load->view("cuti/index", $data);
  }
  
  private function _newData(){
    $data["form_action"] = "cuti/create";
    $data["id"] = null;
    $data["staff_id"] = null;
    $data["approve_staff_id"] = null;
    $data["status_selected"] = null;
    $data["comment"] = null;
    $data["staff_name"] = array("name"=>"staff_name", "id"=>"staff");
    $data["approveby_staff_id"] = getApproval("Cuti");
    $data["date_request"] = array("name"=>"date_request", "class"=>"datepicker");
    $data["date_start"] = array("name"=>"date_start", "class"=>"datepicker");
    $data["date_end"] = array("name"=>"date_end", "class"=>"datepicker");
    $data["status"] = array("pending"=>"Pending", "approve"=>"Approve", "decline"=>"Decline");
    return $data;
  }
  
  private function _editData($id){
    $cuti = $this->cuti->get($id)->row();
    $staff = get_staff_detail($cuti->staff_id);
    $detail = $this->cuti->getDetail($cuti->id)->row();
    $data["form_action"] = "cuti/update";
    $data["id"] = $cuti->id;
    $data["staff_id"] = $cuti->staff_id;
    $data["staff_name"] = array("name"=>"staff_name", "id"=>"staff", "value"=>$staff->staff_name);
    $data["approveby_staff_id"] = getApproval("Cuti");
    $data["approve_staff_id"] = $cuti->approveby_staff_id;
    $data["date_request"] = array("name"=>"date_request", "class"=>"datepicker", "value"=>$cuti->date_request);
    $data["date_start"] = array("name"=>"date_start", "class"=>"datepicker", "value"=>$cuti->date_start);
    $data["date_end"] = array("name"=>"date_end", "class"=>"datepicker", "value"=>$cuti->date_end);
    $data["status"] = array("pending"=>"Pending", "approve"=>"Approve", "decline"=>"Decline");
    $data["status_selected"] = $cuti->status;
    $data["comment"] = $detail->comment;
    return $data;
  }
  
  function add(){
    $data = $this->_newData();
    $this->load->view("cuti/form", $data);
  }
  
  function edit($id){
    $data = $this->_editData($id);
    $this->load->view("cuti/form", $data);
  }
  
  function update_status(){
    $this->cuti->update_status();
    redirect("cuti/index");
  }
  
  function create(){
    $this->form_validation->set_rules(array(
      array("field"=>"staff_name", "label"=>"Staff name", "rules"=>"required"),
      array("field"=>"approveby_staff_id", "label"=>"Approve by", "rules"=>"required")
    ));
    if($this->form_validation->run()===false){
      $data = $this->_newData();
      $this->load->view("cuti/form", $data);
    }else{
      $this->cuti->add();
      redirect("cuti/index");
    }
  }
  
  function update(){
    $this->form_validation->set_rules(array(
      array("field"=>"staff_name", "label"=>"Staff name", "rules"=>"required"),
      array("field"=>"approveby_staff_id", "label"=>"Approve by", "rules"=>"required")
    ));
    if($this->form_validation->run()===false){
      $data = $this->_editData();
      $this->load->view("cuti/form", $data);
    }else{
      $this->cuti->update();
      redirect("cuti/index");
    }
  }
  
  function delete($id){
    $this->db->delete("cuti", array("id"=>$id));
    $this->db->delete("cuti_detail", array("cuti_id"=>$id));
    redirect("cuti/index");
  }
  
  function report(){
    switch ($this->input->get('c')) {
      case "1":
          $data['col'] = "staff_id";
          break;
      case "2":
          $data['col'] = "date_request";
          break;
      case "3":
          $data['col'] = "date_start";
          break;
      case "4":
          $data['col'] = "date_end";
          break;
      default:
          $data['col'] = "staff_id";
    }

    if ($this->input->get('d') == "1") {
        $data['dir'] = "DESC";
    } else {
        $data['dir'] = "ASC";
    }
    $total_rows = $this->cuti->get_all()->num_rows();
    $data['title'] = "Izin";
    $data['btn_add'] = anchor('cuti/add', 'Add New', array('class' => 'btn btn-primary'));
    $data['btn_home'] = anchor(base_url(), 'Home', array('class' => 'btn'));

    $uri_segment = 3;
    $offset = $this->uri->segment($uri_segment);
    $data['cuti'] = $this->cuti->list_where($this->input->get('search_by'),$this->input->get('q'));
    
    // update status purpose
    $data["status"] = array(
      "pending"=>"Pending",
      "approve"=>"Approve",
      "decline"=>"Decline"
    );

	if ($this->input->get('to') == 'pdf') {
		$this->load->library('html2pdf');

		$this->html2pdf->filename = 'cuti_report.pdf';
    	$this->html2pdf->paper('a4', 'landscape');
    	$this->html2pdf->html($this->load->view("cuti/to_pdf", $data, true));
	    
    	$this->html2pdf->create();
	} else {
	    $config['base_url'] = site_url("cuti/index");
	    $config['total_rows'] = $total_rows;
	    $config['per_page'] = $this->limit;
	    $config['uri_segment'] = $uri_segment;
	    $this->pagination->initialize($config);
	    $data['pagination'] = $this->pagination->create_links();
    
    	$data["comment"] = array("name"=>"comment", "id"=>"comment");
    
    	$this->load->view("cuti/report", $data);
    }
  }
}
