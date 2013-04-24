<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Staffs extends CI_Controller {

    private $limit = 10;

    public function __construct() {
        parent::__construct();
        $this->load->library('breadcrumb');
        $this->load->model('Staff');
        $this->load->model('Branch');
        $this->load->model('Department');
        $this->load->model('Title');
        $this->load->model('Marital');
        $this->load->model('Employee_Status');
        $this->load->model('Tax_Employee');
        $this->load->model('Family');
        $this->load->model('Medical');
        $this->load->model('Salary_Component_A');
        $this->load->model('Salary_Component_B');
        $this->load->model('Work');
        $this->load->model('Education');
        $this->load->helper("staff");
        $this->session->userdata('logged_in') == true ? '' : redirect('users/sign_in');
    }

    public function index($offset = 0) {
        $staff_list = new Staff();
        switch ($this->input->get('c')) {
            case "1":
                $data['col'] = "staff_nik";
                break;
            case "2":
                $data['col'] = "staff_name";
                break;
            case "3":
                $data['col'] = "staff_address";
                break;
            case "4":
                $data['col'] = "staff_email";
                break;
            case "5":
                $data['col'] = "staff_phone_home";
                break;
            case "6":
                $data['col'] = "staff_phone_hp";
                break;
            case "7":
                $data['col'] = "staff_cabang";
                break;
            case "8":
                $data['col'] = "staff_departement";
                break;
            case "9":
                $data['col'] = "staff_jabatan";
                break;
            case "10":
                $data['col'] = "staff_id";
                break;
            default:
                $data['col'] = "staff_id";
        }

        if ($this->input->get('d') == "1") {
            $data['dir'] = "DESC";
        } else {
            $data['dir'] = "ASC";
        }

        $total_rows = $staff_list->count();
        $data['title'] = "Staffs";
        $data['btn_add'] = anchor('staffs/add', 'Add New', array('class' => 'btn btn-primary'));
        $data['btn_home'] = anchor(base_url(), 'Back', array('class' => 'btn'));

        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        $staff_list->order_by($data['col'], $data['dir']);
        $data['staff_list'] = $staff_list
                        ->get($this->limit, $offset)->all;

        $config['base_url'] = site_url("staffs/index");
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('staffs/index', $data);
    }

    function add() {
        $data['title'] = 'Add New Staff';
        $data['form_action'] = site_url('staffs/save');
        $data['link_back'] = anchor('staffs/', 'Back', array('class' => 'btn btn-danger'));

        $data['id'] = '';
        $data['staff_nik'] = array('name' => 'staff_nik');
        $data['staff_kode_absen'] = array('name' => 'staff_kode_absen');
        $data['staff_name'] = array('name' => 'staff_name');
        $data['staff_address'] = array('name' => 'staff_address', 'rows' => '2');
        $data['staff_email'] = array('name' => 'staff_email');
        $data['staff_email_alternatif'] = array('name' => 'staff_email_alternatif');
        $data['staff_phone_home'] = array('name' => 'staff_phone_home');
        $data['staff_phone_hp'] = array('name' => 'staff_phone_hp');

// Status Pajak Karyawan
        $tax_employee = new Tax_Employee();
        $list_tax = $tax_employee->list_drop();
        $tax_selected = '';
        $data['staff_status_pajak'] = form_dropdown('staff_status_pajak', $list_tax, $tax_selected);

// Status Nikah
        $marital = new Marital();
        $list_ms = $marital->list_drop();
        $ms_selected = '';
        $data['staff_status_nikah'] = form_dropdown('staff_status_nikah', $list_ms, $ms_selected);

// Status Karyawan
        $employee_status = new Employee_Status();
        $list_em = $employee_status->list_drop();
        $em_selected = '';
        $data['staff_status_karyawan'] = form_dropdown('staff_status_karyawan', $list_em, $em_selected);

// Branch
        $branch = new Branch();
        $list_branch = $branch->list_drop();
        $branch_selected = '';
        $data['staff_cabang'] = form_dropdown('staff_cabang', $list_branch, $branch_selected);

// Departement
        $dept = new Department();
        $list_dpt = $dept->list_drop();
        $dpt_selected = '';
        $data['staff_departement'] = form_dropdown('staff_departement', $list_dpt, $dpt_selected);

//Jabatan
        $title = new Title();
        $list_jbt = $title->list_drop();
        $jbt_selected = '';
        $data['staff_jabatan'] = form_dropdown('staff_jabatan', $list_jbt, $jbt_selected);


        $data['staff_photo'] = array('name' => 'staff_photo');
        $data['staff_birthdate'] = array('name' => 'staff_birthdate', 'id' => 'staff_birthdate', "placeholder"=>"Date");
        $data['staff_birthplace'] = array('name' => 'staff_birthplace', "placeholder"=>"Place");

        $options_sex = array(
            'laki-laki' => 'Laki - Laki',
            'perempuan' => 'Perempuan'
        );
        $sex_selected = 'laki-laki';
        $data['staff_sex'] = form_dropdown('staff_sex', $options_sex, $sex_selected, 'id="staff_sex"');
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Save', 'class' => 'btn btn-primary');
        
        $data["component_a"] = false;
        $data["component_b"] = false;
        $data["family"] = false;
        
        $data["no_passport"] = array("name"=>"no_passport");
        $data["passport_expired"] = array("name"=>"passport_expired", "class"=>"datepicker");
        
        $data["no_kitas"] = array("name"=>"no_kitas");
        $data["kitas_expired"] = array("name"=>"kitas_expired", "class"=>"datepicker");
        
        $data["saldo_cuti"] = array("name"=>"saldo_cuti");
        
        $data["mulai_kerja"] = array("name"=>"mulai_kerja", "class"=>"datepicker");
        $data["no_contract"] = array("name"=>"no_contract");
        $data["contract_from"] = array("name"=>"contract_from", "class"=>"datepicker");
        $data["contract_to"] = array("name"=>"contract_to", "class"=>"datepicker");
        
        $data["date_out"] = array("name"=>"date_out", "class"=>"datepicker");
        $data["out_note"] = array("name"=>"out_note");

        $this->load->view('staffs/frm_staff', $data);
    }

    function edit($id) {
        $staff = new Staff();
        $rs = $staff->where('staff_id', $id)->get();
        $data['id'] = $rs->staff_id;
        $data['staff_nik'] = array('name' => 'staff_nik', 'value' => $rs->staff_nik);
        $data['staff_kode_absen'] = array('name' => 'staff_kode_absen', 'value' => $rs->staff_kode_absen);
        $data['staff_name'] = array('name' => 'staff_name', 'value' => $rs->staff_name);
        $data['staff_address'] = array('name' => 'staff_address', 'rows' => '2', 'value' => $rs->staff_address);
        $data['staff_email'] = array('name' => 'staff_email', 'value' => $rs->staff_email);
        $data['staff_email_alternatif'] = array('name' => 'staff_email_alternatif', 'value' => $rs->staff_email_alternatif);
        $data['staff_phone_home'] = array('name' => 'staff_phone_home', 'value' => $rs->staff_phone_home);
        $data['staff_phone_hp'] = array('name' => 'staff_phone_hp', 'value' => $rs->staff_phone_hp);

// Status Pajak Karyawan
        $tax_employee = new Tax_Employee();
        $list_spk = $tax_employee->list_drop();
        $spk_selected = $staff->staff_status_pajak;
        $data['staff_status_pajak'] = form_dropdown('staff_status_pajak',
                        $list_spk,
                        $spk_selected);

// Status Nikah
        $marital = new Marital();
        $list_sn = $marital->list_drop();
        $sn_selected = $staff->staff_status_nikah;
        $data['staff_status_nikah'] = form_dropdown('staff_status_nikah',
                        $list_sn,
                        $sn_selected);

// Status Karyawan
        $employee_status = new Employee_Status();
        $list_sk = $employee_status->list_drop();
        $sk_selected = $staff->staff_status_karyawan;
        $data['staff_status_karyawan'] = form_dropdown('staff_status_karyawan',
                        $list_sk,
                        $sk_selected);

// Branch
        $branch = new Branch();
        $list_branch = $branch->list_drop();
        $branch_selected = $staff->staff_cabang;
        $data['staff_cabang'] = form_dropdown('staff_cabang',
                        $list_branch,
                        $branch_selected);

// Departement
        $dept = new Department();
        $list_dpt = $dept->list_drop();
        $dpt_selected = $staff->staff_departement;
        $data['staff_departement'] = form_dropdown('staff_departement',
                        $list_dpt,
                        $dpt_selected);

//Jabatan
        $title = new Title();
        $list_jbt = $title->list_drop();
        $jbt_selected = $staff->staff_jabatan;
        $data['staff_jabatan'] = form_dropdown('staff_jabatan',
                        $list_jbt,
                        $jbt_selected);


        $data['staff_photo'] = array('name' => 'staff_photo', 'value' => $staff->staff_photo);
        $data['staff_birthdate'] = array('name' => 'staff_birthdate', 'id' => 'staff_birthdate', 'value' => $staff->staff_birthdate);
        $data['staff_birthplace'] = array('name' => 'staff_birthplace', 'value' => $staff->staff_birthplace);

        $options_sex = array(
            'laki-laki' => 'Laki - Laki',
            'perempuan' => 'Perempuan'
        );
        $sex_selected = $staff->staff_sex;
        $data['staff_sex'] = form_dropdown('staff_sex', $options_sex, $sex_selected);
        $data['staff_password'] = array('name' => 'staff_password');
        $data['btn_save'] = array('name' => 'btn_save', 'value' => 'Update', 'class' => 'btn btn-primary');

        $data['title'] = 'Update Staff';
        $data['message'] = '';
        $data['form_action'] = site_url('staffs/update');
        $data['link_back'] = anchor('staffs/', 'Back', array('class' => 'btn btn-danger'));
        
        $data["no_passport"] = array("name"=>"no_passport", "value"=>$staff->no_passport);
        $data["passport_expired"] = array("name"=>"passport_expired", "class"=>"datepicker", "value"=>$staff->passport_expired);
        
        $data["no_kitas"] = array("name"=>"no_kitas", "value"=>$staff->no_kitas);
        $data["kitas_expired"] = array("name"=>"kitas_expired", "class"=>"datepicker", "value"=>$staff->kitas_expired);
        
        $data["saldo_cuti"] = array("name"=>"saldo_cuti", "value"=>$staff->saldo_cuti);
        
        $data["mulai_kerja"] = array("name"=>"mulai_kerja", "class"=>"datepicker", "value"=>$staff->mulai_kerja);
        $data["no_contract"] = array("name"=>"no_contract", "value"=>$staff->no_contract);
        $data["contract_from"] = array("name"=>"contract_from", "class"=>"datepicker", "value"=>$staff->contract_from);
        $data["contract_to"] = array("name"=>"contract_to", "class"=>"datepicker", "value"=>$staff->contract_to);
        
        $data["date_out"] = array("name"=>"date_out", "class"=>"datepicker", "value"=>$staff->date_out);
        $data["out_note"] = array("name"=>"out_note", "value"=>$staff->out_note);
        $data["pph_by_company"] = $staff->pph_by_company;

        $this->load->view('staffs/frm_staff', $data);
    }

    function save() {
        $staff = new Staff();
        $staff->staff_nik = $this->input->post('staff_nik');
        $staff->staff_kode_absen = $this->input->post('staff_kode_absen');
        $staff->staff_name = $this->input->post('staff_name');
        $staff->staff_address = $this->input->post('staff_address');
        $staff->staff_email = $this->input->post('staff_email');
        $staff->staff_email_alternatif = $this->input->post('staff_email_alternatif');
        $staff->staff_phone_home = $this->input->post('staff_phone_home');
        $staff->staff_phone_hp = $this->input->post('staff_phone_hp');
        $staff->staff_status_pajak = $this->input->post('staff_status_pajak');
        $staff->staff_status_nikah = $this->input->post('staff_status_nikah');
        $staff->staff_status_karyawan = $this->input->post('staff_status_karyawan');
        $staff->staff_cabang = $this->input->post('staff_cabang');
        $staff->staff_departement = $this->input->post('staff_departement');
        $staff->staff_jabatan = $this->input->post('staff_jabatan');
        //$staff->staff_photo = $this->input->post('staff_photo');
        $staff->staff_birthdate = $this->input->post('staff_birthdate');
        $staff->staff_birthplace = $this->input->post('staff_birthplace');
        $staff->staff_sex = $this->input->post('staff_sex');
        $staff->staff_password = md5('qwerty');
        $staff->pph_by_company = $this->input->post("pph_by_company") == "on" ? 'y':'n';
        $staff->saldo_cuti = $this->input->post("saldo_cuti");
        $staff->no_passport = $this->input->post("no_passport");
        $staff->passport_expired = $this->input->post("passport_expired");
        $staff->no_kitas = $this->input->post("no_kitas");
        $staff->kitas_expired = $this->input->post("kitas_expired");
        $staff->mulai_kerja = $this->input->post("mulai_kerja");
        $staff->contract_from = $this->input->post("contract_from");
        $staff->contract_to = $this->input->post("contract_to");
        $staff->date_out = $this->input->post("date_out");
        $staff->out_note = $this->input->post("out_note");
        // upload photo
        $config['upload_path'] = 'assets/upload';
        $config['allowed_types'] = 'gif|jpg|png|bmp';
        $this->load->library("upload", $config);
        if ($this->upload->do_upload("photo")) {
            $data = $this->upload->data();
            $staff->staff_photo = $data["file_name"];
        } else {
            //$this->staff_photo = "";
            print_r($this->upload->display_errors());
        }

        if ($staff->save()) {
            $staff_id = $this->db->insert_id();
            $this->session->set_flashdata('message', 'Staff successfully created!');
            // family data
            // save routine for family
            $family = new Family();
            $this->_saveFamily($family, $staff_id);
            
            // medic data
            // save routine for medical history
            $medic = new Medical();
            $this->_saveMedic($medic, $staff_id);
            
            // work data
            $work = new Work();
            $this->_saveWork($work, $staff_id);
            
            // edu data
            $education = new Education();
            $this->_saveEdu($education, $staff_id);
            
            // component A data
            $comp_a = new Salary_Component_A();
            $this->_saveCompA($comp_a, $staff_id);
            
            // component B data
            $comp_b = new Salary_Component_B();
            $this->_saveCompB($comp_b, $staff_id);
            
            //redirect('staffs/');
        } else {
// Failed
            $staff->error_message('custom', 'Field required');
            $msg = $staff->error->custom;
            $this->session->set_flashdata('message', $msg);
            redirect('staffs/add');
        }
    }

    function update() {
        $staff = new Staff();
        // upload photo
        $config['upload_path'] = 'assets/upload';
        $config['allowed_types'] = 'gif|jpg|png|bmp';
        $this->load->library("upload", $config);
        $data = false;
        if ($this->upload->do_upload("photo")) {
            $data = $this->upload->data();
        }
        $staff_id = $this->input->post('id');
        $staff->where('staff_id', $staff_id)
                ->update(array(
                    'staff_nik' => $this->input->post('staff_nik'),
                    'staff_kode_absen' => $this->input->post('staff_kode_absen'),
                    'staff_name' => $this->input->post('staff_name'),
                    'staff_address' => $this->input->post('staff_address'),
                    'staff_email' => $this->input->post('staff_email'),
                    'staff_email_alternatif' => $this->input->post('staff_email_alternatif'),
                    'staff_phone_home' => $this->input->post('staff_phone_home'),
                    'staff_phone_hp' => $this->input->post('staff_phone_hp'),
                    'staff_status_pajak' => $this->input->post('staff_status_pajak'),
                    'staff_status_nikah' => $this->input->post('staff_status_nikah'),
                    'staff_status_karyawan' => $this->input->post('staff_status_karyawan'),
                    'staff_cabang' => $this->input->post('staff_cabang'),
                    'staff_departement' => $this->input->post('staff_departement'),
                    'staff_jabatan' => $this->input->post('staff_jabatan'),
                    'staff_birthdate' => $this->input->post('staff_birthdate'),
                    'staff_birthplace' => $this->input->post('staff_birthplace'),
                    'staff_sex' => $this->input->post('staff_sex'),
                    'staff_password' => md5($this->input->post('staff_password')),
                    'saldo_cuti'=>$this->input->post("saldo_cuti"),
                    'no_passport'=>$this->input->post("no_passport"),
                    'passport_expired'=>$this->input->post("passport_expired"),
                    'no_kitas'=>$this->input->post("no_kitas"),
                    'kitas_expired'=>$this->input->post("kitas_expired"),
                    'mulai_kerja'=>$this->input->post("mulai_kerja"),
                    'contract_from'=>$this->input->post("contract_from"),
                    'contract_to'=>$this->input->post("contract_to"),
                    'date_out'=>$this->input->post("date_out"),
                    'out_note'=>$this->input->post("out_note")
                    
                        )
        );
        
        if($data != false){ // no need to change the photo if "You did not select a file to upload."
          $staff->where("staff_id", $staff_id)->update(array('staff_photo' => $data["file_name"]));       
        }
        
        // save routine for family
        $family = new Family();
        $this->_saveFamily($family, $staff_id);
        
        // save routine for medical history
        $medic = new Medical();
        $this->_saveMedic($medic, $staff_id);
        
        // work data
        $work = new Work();
        $this->_saveWork($work, $staff_id);
        
        // edu data
        $education = new Education();
        $this->_saveEdu($education, $staff_id);
        
        // component A data
        $comp_a = new Salary_Component_A();
        $this->_saveCompA($comp_a, $staff_id);
        
        // component B data
        $comp_b = new Salary_Component_B();
        $this->_saveCompB($comp_b, $staff_id);
        
        $this->session->set_flashdata('message', 'Staff Update successfuly.');
        redirect('staffs/');
    }

    function delete($id) {
        $staff = new Staff();
        $staff->_delete($id);
        redirect('staffs/');
    }

    public function go_upload() {
        $config['upload_path'] = './assets/public/';
        $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        /* Load the upload library */
        $this->load->library('upload', $config);

        /* Create the config for image library */
        /* (pretty self-explanatory) */
        $configThumb = array();
        $configThumb['image_library'] = 'gd2';
        $configThumb['source_image'] = '';
        $configThumb['create_thumb'] = TRUE;
        $configThumb['maintain_ratio'] = TRUE;
        /* Set the height and width or thumbs */
        /* Do not worry - CI is pretty smart in resizing */
        /* It will create the largest thumb that can fit in those dimensions */
        /* Thumbs will be saved in same upload dir but with a _thumb suffix */
        /* e.g. 'image.jpg' thumb would be called 'image_thumb.jpg' */
        $configThumb['width'] = 140;
        $configThumb['height'] = 210;
        /* Load the image library */
        $this->load->library('image_lib');

        /* We have 5 files to upload
         * If you want more - change the 6 below as needed
         */
        $upload = $this->upload->do_upload('userfile');
        /* File failed to upload - continue */
        if ($upload === FALSE)
            continue;
        /* Get the data about the file */
        $data = $this->upload->data();

        $uploadedFiles = $data;
        /* If the file is an image - create a thumbnail */
        if ($data['is_image'] == 1) {
            $configThumb['source_image'] = $data['full_path'];
            $this->image_lib->initialize($configThumb);
            $this->image_lib->resize();
        }

        /* And display the form again */
//        $this->load->view('upload_form');
    }

    function hut_reminders() {
        $staff = new Staff();
        $staff->get();
        $hut = array();
        $year = date('Y-');
        foreach ($staff as $row) {
            $month_day = date('m-d', strtotime($row->staff_birthdate));
            $staff_birthday = $year . $month_day;
            $hut[] = array('id' => floatval($row->staff_id),
                'title' => $row->staff_name,
                'start' => $staff_birthday,
                'url' => site_url('staffs/show/' . $row->staff_id));
        }
        echo json_encode(($hut));
    }
    
    function hut_staffs_and_families(){
        $hut = array();
        $year = date('Y-');

        $query = $this->db->query(" SELECT staff_birthdate AS TGL, staff_name AS NAMA FROM staffs
                                    UNION SELECT staff_fam_birthdate AS TGL, staff_fam_name AS NAMA FROM families");
        foreach($query->result() as $row){
            $month_day = date('m-d', strtotime($row->TGL));
            $staff_birthday = $year . $month_day;
            $hut[] = array('title' => $row->NAMA,
                'start' => $staff_birthday,
                );   
        }
        echo json_encode(($hut));
    }

    function to_excel() {
        $this->load->view('staffs/to_excel');
    }
    
    private function _saveFamily($family, $staff_id){
      $families = $this->input->post("families");
      if(is_array($families)){
        foreach ($families as $f) {
          list($name, $birthdate, $birthplace, $sex, $relation, $id) = explode(";", $f);
          if($id =="undefined" || $id == ""){
            $family->staff_fam_staff_id = $staff_id;
            $family->staff_fam_name = $name;
            $family->staff_fam_birthdate = $birthdate;
            $family->staff_fam_birthplace = $birthplace;
            $family->staff_fam_sex = $sex;
            $family->staff_fam_relation = $relation;
            $family->save();
          }
        }
      }
    }
    
    private function _saveMedic($medic, $staff_id){
      $medics = $this->input->post("medics");
      if(is_array($medics)){
        foreach ($medics as $m) {
          list($date, $description, $id) = explode(";", $m);
          if($id =="undefined" || $id == ""){
            $medic->staff_id = $staff_id;
            $medic->medic_date = $date;
            $medic->medic_description = $description;
            $medic->save();
          }
        }
      }
    }
    
    private function _saveWork($work, $staff_id){
      $works = $this->input->post("works");
      if(is_array($works)){
        foreach($works as $w){
          list($date, $description, $id, $flag) = explode(";", $w);
          if($id =="undefined" || $id == ""){
            $work->staff_id = $staff_id;
            $work->history_date = $date;
            $work->history_description = $description;
            $work->save();
          }
        }
      }
    }
    
    private function _saveEdu($edu, $staff_id){
      $edus = $this->input->post("edu");
      if(is_array($edus)){
        foreach($edus as $e){
          list($date, $gelar, $name, $id)  = explode(";", $e);
          if($id =="undefined" || $id == ""){
            $edu->staff_id = $staff_id;
            $edu->edu_year = $date;
            $edu->edu_gelar = $gelar;
            $edu->edu_name = $name;
            $edu->save();
          }
        }
      }  
    }
    
    private function _saveCompA($comp, $staff_id){
      $comps = $this->input->post("comp_a");
      if(is_array($comps)){
        foreach($comps as $c){
          list($comp_id, $daily, $amount, $id) = explode(";", $c);
          if($id =="undefined" || $id == ""){
            $comp->staff_id = $staff_id;
            $comp->gaji_component_id = $comp_id;
            $comp->gaji_daily_value = $daily;
            $comp->gaji_amount_value = $amount;
            $comp->save();
          }
        }
      }
    }
    
    private function _saveCompB($comp, $staff_id){
      $comps = $this->input->post("comp_b");
      if(is_array($comps)){
        foreach($comps as $c){
          list($comp_id, $daily, $amount, $id) = explode(";", $c);
          if($id =="undefined" || $id == ""){
            $comp->staff_id = $staff_id;
            $comp->gaji_component_id = $comp_id;
            $comp->gaji_daily_value = $daily;
            $comp->gaji_amount_value = $amount;
            $comp->save();
          }
        }
      }
    }
    
    /*UPDATE DATA*/
    function update_family(){
      $id = $this->input->post("id");
      $name = $this->input->post("name");
      $birthdate = $this->input->post("birthdate");
      $birthplace = $this->input->post("birthplace");
      $sex = str_replace(" ", "", strtolower($this->input->post("sex")));
      $relation = $this->input->post("relation");
      $family = new Family();
      $family->where("staff_fam_id", $id)->update(array(
        "staff_fam_name"=>$name,
        "staff_fam_birthdate"=>$birthdate,
        "staff_fam_birthplace"=>$birthplace,
        "staff_fam_sex"=>$sex,
        "staff_fam_relation"=>$relation      
      ));
    }
    
    function update_medic(){
       $id = $this->input->post("id");
       $date = $this->input->post("date");
       $description = $this->input->post("description");
       $medic = new Medical();
       $medic->where("medic_id", $id)->update(array(
         "medic_date"=>$date,
         "medic_description"=>$description
       ));
    }
    
    function update_work(){
       $id = $this->input->post("id");
       $date = $this->input->post("date");
       $description = $this->input->post("description");
       $work = new Work();
       $work->where("history_id", $id)->update(array(
         "history_date"=>$date,
         "history_description"=>$description
       ));
    }
    
    function update_edu(){
       $id = $this->input->post("id");
       $date = $this->input->post("date");
       $gelar = $this->input->post("gelar");
       $name = $this->input->post("name");
       $edu = new Education();
       $edu->where("edu_id", $id)->update(array(
         "edu_year"=>$date,
         "edu_gelar"=>$gelar,
         "edu_name"=>$name
       ));
    }
    
    function update_component_a(){
       $id = $this->input->post("id");
       $comp_id = $this->input->post("comp_id");
       $daily = $this->input->post("daily");
       $amount = $this->input->post("amount");
       $comp_a = new Salary_Component_A();
       $comp_a->where("gaji_id", $id)->update(array(
         "gaji_component_id"=>$comp_id,
         "gaji_daily_value"=>$daily,
         "gaji_amount_value"=>$amount
       ));
       print_r($_POST);
    }
    
    function update_component_b(){
       $id = $this->input->post("id");
       $comp_id = $this->input->post("comp_id");
       $daily = $this->input->post("daily");
       $amount = $this->input->post("amount");
       $comp_b = new Salary_Component_B();
       $comp_b->where("gaji_id", $id)->update(array(
         "gaji_component_id"=>$comp_id,
         "gaji_daily_value"=>$daily,
         "gaji_amount_value"=>$amount
       ));
    }

    public function report_list($offset = 0) {
        $staff_list = new Staff();
        switch ($this->input->get('c')) {
            case "1":
                $data['col'] = "staff_nik";
                break;
            case "2":
                $data['col'] = "staff_name";
                break;
            case "3":
                $data['col'] = "staff_address";
                break;
            case "4":
                $data['col'] = "staff_email";
                break;
            case "5":
                $data['col'] = "staff_phone_home";
                break;
            case "6":
                $data['col'] = "staff_phone_hp";
                break;
            case "7":
                $data['col'] = "staff_cabang";
                break;
            case "8":
                $data['col'] = "staff_departement";
                break;
            case "9":
                $data['col'] = "staff_jabatan";
                break;
            case "10":
                $data['col'] = "staff_id";
                break;
            case "11":
                $data['col'] = "staff_sex";
                break;
            case "12":
                $data['col'] = "staff_birthdate";
                break;
            case "13":
                $data['col'] = "mulai_kerja";
                break;
            case "14":
                $data['col'] = "staff_status_nikah";
                break;
            case "15":
                $data['col'] = "staff_status_karyawan";
                break;
            default:
                $data['col'] = "staff_id";
        }

        if ($this->input->get('d') == "1") {
            $data['dir'] = "DESC";
        } else {
            $data['dir'] = "ASC";
        }

        $total_rows = $staff_list->count();
        $data['title'] = "Staffs";
        $data['btn_add'] = anchor('staffs/add', 'Add New', array('class' => 'btn btn-primary'));
        $data['btn_home'] = anchor(base_url(), 'Back', array('class' => 'btn'));

        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

		if ($this->input->get("staff_cabang") != "") {
			$staff_list->like('staff_cabang',$this->input->get("staff_cabang"));
		}

		if ($this->input->get("staff_departement") != "") {
			$staff_list->like('staff_departement',$this->input->get("staff_departement"));
		}

		if ($this->input->get("staff_jabatan") != "") {
			$staff_list->like('staff_jabatan',$this->input->get("staff_jabatan"));
		}

		if ($this->input->get("staff_birthdate") != "") {
			$birthdate = str_replace(date('Y-'),"",$this->input->get("staff_birthdate"));
			$staff_list->where("DATE_FORMAT(staff_birthdate,'%m-%d')",$birthdate);
		}

		if ($this->input->get("staff_name") != "") {
			$staff_list->like('staff_name',$this->input->get("staff_name"));
		}

        $staff_list->order_by($data['col'], $data['dir']);
        $data['staff_list'] = $staff_list
                        ->get($this->limit, $offset)->all;

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

			$this->html2pdf->filename = 'staff_list_report.pdf';
	    	$this->html2pdf->paper('a4', 'landscape');
	    	$this->html2pdf->html($this->load->view('staffs/list_to_pdf', $data, true));
	    
	    	$this->html2pdf->create();
    	} else if ($this->input->get('to') == 'xls') {
    		$param['file_name'] = 'staff_list_report.xls';
    		$param['content_sheet'] = $this->load->view('staffs/list_to_pdf', $data, true);
    		$this->load->view('to_excel',$param);
		} else {
	        $config['base_url'] = site_url("staffs/index");
	        $config['total_rows'] = $total_rows;
	        $config['per_page'] = $this->limit;
	        $config['uri_segment'] = $uri_segment;
	        $this->pagination->initialize($config);
	        $data['pagination'] = $this->pagination->create_links();

        	$this->load->view('staffs/report_list', $data);
        }
    }

    public function report_cuti($offset = 0) {
        $staff_list = new Staff();
        switch ($this->input->get('c')) {
            case "1":
                $data['col'] = "staff_nik";
                break;
            case "2":
                $data['col'] = "staff_name";
                break;
            case "3":
                $data['col'] = "staff_address";
                break;
            case "4":
                $data['col'] = "staff_email";
                break;
            case "5":
                $data['col'] = "staff_phone_home";
                break;
            case "6":
                $data['col'] = "staff_phone_hp";
                break;
            case "7":
                $data['col'] = "staff_cabang";
                break;
            case "8":
                $data['col'] = "staff_departement";
                break;
            case "9":
                $data['col'] = "staff_jabatan";
                break;
            case "10":
                $data['col'] = "staff_id";
                break;
            case "11":
                $data['col'] = "saldo_cuti";
                break;
            default:
                $data['col'] = "staff_id";
        }

        if ($this->input->get('d') == "1") {
            $data['dir'] = "DESC";
        } else {
            $data['dir'] = "ASC";
        }

        $total_rows = $staff_list->count();

        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

		if ($this->input->get("staff_cabang") != "") {
			$staff_list->like('staff_cabang',$this->input->get("staff_cabang"));
		}

		if ($this->input->get("staff_departement") != "") {
			$staff_list->like('staff_departement',$this->input->get("staff_departement"));
		}

		if ($this->input->get("staff_jabatan") != "") {
			$staff_list->like('staff_jabatan',$this->input->get("staff_jabatan"));
		}

		if ($this->input->get("staff_name") != "") {
			$staff_list->like('staff_name',$this->input->get("staff_name"));
		}

        $staff_list->order_by($data['col'], $data['dir']);
        $data['staff_list'] = $staff_list
                        ->get($this->limit, $offset)->all;

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

			$this->html2pdf->filename = 'sisa_cuti_staff_report.pdf';
	    	$this->html2pdf->paper('a4', 'landscape');
	    	$this->html2pdf->html($this->load->view('staffs/cuti_to_pdf', $data, true));
	    
	    	$this->html2pdf->create();
		} else {
	        $config['base_url'] = site_url("staffs/index");
	        $config['total_rows'] = $total_rows;
	        $config['per_page'] = $this->limit;
	        $config['uri_segment'] = $uri_segment;
	        $this->pagination->initialize($config);
	        $data['pagination'] = $this->pagination->create_links();

        	$this->load->view('staffs/report_cuti', $data);
        }
    }

}