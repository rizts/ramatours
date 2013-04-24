<?php
class Izin extends CI_Controller{
  private $limit = 10;
  function __construct(){
    parent::__construct();
    $this->load->model("Izin_model", "izin");
    $this->load->helper("staff");
  }
  
  function index(){
    switch ($this->input->get('c')) {
      case "1":
          $data['col'] = "izin_staff_id";
          break;
      case "2":
          $data['col'] = "izin_date";
          break;
      case "3":
          $data['col'] = "izin_jumlah_hari";
          break;
      default:
          $data['col'] = "izin_staff_id";
    }

    if ($this->input->get('d') == "1") {
        $data['dir'] = "DESC";
    } else {
        $data['dir'] = "ASC";
    }
    $total_rows = $this->izin->get_all()->num_rows();
    $data['title'] = "Izin";
    $data['btn_add'] = anchor('izin/add', 'Add New', array('class' => 'btn btn-primary'));
    $data['btn_home'] = anchor(base_url(), 'Home', array('class' => 'btn'));

    $uri_segment = 3;
    $offset = $this->uri->segment($uri_segment);
    $data['izin'] = $this->izin->get_all();

    $config['base_url'] = site_url("izin/index");
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $this->limit;
    $config['uri_segment'] = $uri_segment;
    $this->pagination->initialize($config);
    $data['pagination'] = $this->pagination->create_links();
    
    $this->load->view("izin/index", $data);
  }
  
  function add(){
    $data["izin_staff"] = array("id"=>"staff", "name"=>"izin_staff");
    $data["izin_date"] = array("name"=>"izin_date", "class"=>"datepicker");
    $data["izin_jumlah_hari"] = array("name"=>"izin_jumlah_hari");
    $data["izin_note"] = array("name"=>"izin_note", "id"=>"izin_note");
    $data["form_action"] = "izin/create";
    $data["id"] = null;
    $data["izin_staff_id"] = null;
    $this->load->view("izin/form", $data);
  }
  
  function edit(){
    $data["id"] = $this->uri->segment(3);
    $izin = $this->izin->get($data["id"])->row();
    $staff = get_staff_detail($izin->izin_staff_id);
    $data["izin_staff"] = array("id"=>"staff", "name"=>"izin_staff", "value"=>$staff->staff_name);
    $data["izin_date"] = array("name"=>"izin_date", "class"=>"datepicker", "value"=>$izin->izin_date);
    $data["izin_jumlah_hari"] = array("name"=>"izin_jumlah_hari", "value"=>$izin->izin_jumlah_hari);
    $data["izin_note"] = array("name"=>"izin_note", "id"=>"izin_note", "value"=>$izin->izin_note);
    $data["izin_staff_id"] = $izin->izin_staff_id;
    $data["form_action"] = "izin/update";
    $this->load->view("izin/form", $data);
  }
  
  function create(){
    $this->form_validation->set_rules(array(
      array("field"=>"izin_staff", "label"=>"Staff Name", "rules"=>"required"),
      array("field"=>"izin_date", "label"=>"Tanggal izin", "rules"=>"required"),
      array("field"=>"izin_jumlah_hari", "label"=>"Jumlah hari izin", "rules"=>"required")
    ));
    if($this->form_validation->run()===false){
      echo "false";
    }else{
      $this->izin->add();
    }
    redirect("izin/index");
  }
  
  function update(){
    $this->form_validation->set_rules(array(
      array("field"=>"izin_staff", "label"=>"Staff Name", "rules"=>"required"),
      array("field"=>"izin_date", "label"=>"Tanggal izin", "rules"=>"required"),
      array("field"=>"izin_jumlah_hari", "label"=>"Jumlah hari izin", "rules"=>"required")
    ));
    if($this->form_validation->run()===false){
      echo "false";
    }else{
      $this->izin->update();
    }
    redirect("izin/index");
  }
  
  function delete(){
    $id = $this->uri->segment(3);
    $this->db->delete("izin", array("izin_id"=>$id));
    redirect("izin/index");
  }
  
  function report(){
    switch ($this->input->get('c')) {
      case "1":
          $data['col'] = "izin_staff_id";
          break;
      case "2":
          $data['col'] = "izin_date";
          break;
      case "3":
          $data['col'] = "izin_jumlah_hari";
          break;
      default:
          $data['col'] = "izin_staff_id";
    }

    if ($this->input->get('d') == "1") {
        $data['dir'] = "DESC";
    } else {
        $data['dir'] = "ASC";
    }
    $total_rows = $this->izin->get_all()->num_rows();
    $data['title'] = "Izin";
    $data['btn_add'] = anchor('izin/add', 'Add New', array('class' => 'btn btn-primary'));
    $data['btn_home'] = anchor(base_url(), 'Home', array('class' => 'btn'));

    $uri_segment = 3;
    $offset = $this->uri->segment($uri_segment);

	$where = array();
	if ($this->input->get("staff_cabang") != "") {
		$where['staff_cabang'] = $this->input->get("staff_cabang");
	}

	if ($this->input->get("staff_departement") != "") {
		$where['staff_departement'] = $this->input->get("staff_departement");
	}

	if ($this->input->get("staff_jabatan") != "") {
		$where['staff_jabatan'] = $this->input->get("staff_jabatan");
	}

	if ($this->input->get("staff_name") != "") {
		$where['staff_name'] = $this->input->get("staff_name");
	}

    $data['izin'] = $this->izin->list_where($where);

	// Branch
    $branch = new Branch();
    $list_branch = $branch->list_drop();
    $branch_selected = $this->input->get('staff_cabang');
    $data['staff_cabang'] = form_dropdown('staff_cabang',
                    $list_branch,
                    $branch_selected);

	// Departement
    $dept = new Department();
    $list_dpt = $dept->list_drop();
    $dpt_selected = $this->input->get('staff_departement');
    $data['staff_departement'] = form_dropdown('staff_departement',
                    $list_dpt,
                    $dpt_selected);

	//Jabatan
    $title = new Title();
    $list_jbt = $title->list_drop();
    $jbt_selected = $this->input->get('staff_jabatan');
    $data['staff_jabatan'] = form_dropdown('staff_jabatan',
                    $list_jbt,
                    $jbt_selected);

	$data['staff_name'] = array('name' => 'staff_name', 'value' => $this->input->get('staff_name'));

	if ($this->input->get('to') == 'pdf') {
		$this->load->library('html2pdf');

		$this->html2pdf->filename = 'izin_report.pdf';
	   	$this->html2pdf->paper('a4', 'landscape');
	   	$this->html2pdf->html($this->load->view("izin/to_pdf", $data, true));
	    
	   	$this->html2pdf->create();
	} else if ($this->input->get('to') == 'xls') {
		$param['file_name'] = 'izin_report.xls';
		$param['content_sheet'] = $this->load->view('izin/to_pdf', $data, true);
		$this->load->view('to_excel',$param);
	} else {
	    $config['base_url'] = site_url("izin/index");
	    $config['total_rows'] = $total_rows;
	    $config['per_page'] = $this->limit;
	    $config['uri_segment'] = $uri_segment;
	    $this->pagination->initialize($config);
	    $data['pagination'] = $this->pagination->create_links();
    
    	$this->load->view("izin/report", $data);
    }
  }
  
}