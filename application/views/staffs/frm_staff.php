<?php get_header(); ?>
<script src="<?php echo base_url(); ?>assets/js/jquery.formatCurrency-1.4.0.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.formatCurrency.all.js" type="text/javascript"></script>
<?php echo load_js(array(
  "staff.php?url=".urlencode(site_url())
)); ?>

<?php
  print_r($id); 
  // load them all
  $component_a = get_component_a($id);
  $component_b = get_component_b($id);
  $family = get_families($id);
  $medic = get_medics($id); 
  $work = get_works($id);
  $education = get_edu($id);
  // components A
  $comp_a_data = '';
  if($component_a){
    foreach($component_a->result() as $gaji){
      $component = get_components($gaji->gaji_component_id);
      $comp_a_data .= '["'.$component->comp_name.'", "'.$component->comp_type.'", "'.$gaji->gaji_daily_value.'", "'.number_format($gaji->gaji_amount_value, 2, ".", ",").'", "'.$gaji->gaji_id.'", "'.$gaji->gaji_component_id.'"],';
    }
    $comp_a_data = substr($comp_a_data, 0, (strlen($comp_a_data)-1));
  }
  
  
  // components B
  $comp_b_data = '';
  if($component_b){
    foreach($component_b->result() as $gaji){
      $component = get_components($gaji->gaji_component_id);
      $comp_b_data .= '["'.$component->comp_name.'", "'.$component->comp_type.'", "'.$gaji->gaji_daily_value.'", "'.number_format($gaji->gaji_amount_value, 2, ".", ",").'", "'.$gaji->gaji_id.'", "'.$gaji->gaji_component_id.'"],';
    }
    $comp_b_data = substr($comp_b_data, 0, (strlen($comp_b_data)-1));
  }
  
  
  // family 
  $families = '';
  if($family){
    foreach($family->result() as $f){
      $families .= '["'.$f->staff_fam_name.'", "'.$f->staff_fam_birthdate.'", "'.$f->staff_fam_birthplace.'", "'.$f->staff_fam_sex.'", "'.$f->staff_fam_relation.'", "'.$f->staff_fam_id.'"],';
    }
    $families = substr($families, 0, (strlen($families)-1));
  }
  
  // Medic 
  $medics = '';
  if($medic){
    foreach($medic->result() as $m){
      $medics .= '["'.$m->medic_date.'", "'.$m->medic_description.'", "'.$m->medic_id.'"],';
    }
    $medics = substr($medics, 0, (strlen($medics)-1));
  }
  
  // Work
  $works = ''; 
  if($work){
    foreach($work->result() as $w){
      $works .= '["'.$w->history_date.'", "'.$w->history_description.'", "'.$w->history_id.'"],';
    }
    $works = substr($works, 0, (strlen($works)-1));
  }  
  
  // education
  $educations = '';
  if($education){
    foreach($education->result() as $e){
      $educations .= '["'.$e->edu_year.'", "'.$e->edu_gelar.'", "'.$e->edu_name.'", "'.$e->edu_id.'"],';
    }
    $educations = substr($educations, 0, (strlen($educations)-1));
  }  
  
 ?>
<script type="text/javascript">
  var comp_a_data = [<?php echo $comp_a_data; ?>];
  var comp_b_data = [<?php echo $comp_b_data; ?>];
  var family = [<?php echo $families; ?>];
  var medic = [<?php echo $medics; ?>];
  var work = [<?php echo $works; ?>];
  var edu = [<?php echo $educations; ?>];
  $(document).ready(function(){
    $("#salary_component_a").handsontable("loadData", comp_a_data);
    $("#salary_component_b").handsontable("loadData", comp_b_data);
    $("#family_table").handsontable("loadData", family);
    $("#medic_table").handsontable("loadData", medic);
    $("#works_table").handsontable("loadData", work);
    $("#edu_table").handsontable("loadData", edu);
    $("#status_pph").iphoneStyle({
      onChange: function(e, checked){
        if(checked){
          $(e).attr("checked", "checked");        
        }else{
          $(e).removeAttr("checked");
        }      
      }  
    });
  });
</script>
<div class="body">
  <div class="content">
    <?php echo $this->session->flashdata('message'); ?>
    <?php echo form_open_multipart($form_action) . form_hidden('id', $id); ?>
    <div class="page-header">
      <div class="icon">
        <span class="ico-coins"></span>
      </div>
      <h1>Staffs
      <small>Manage staffs</small>
      </h1>
    </div>
    <br class="cl" />
    <div class="one_third">
      <h3>Photo</h3>
      <div class="form-signin">
        <img src="<?php echo strlen($staff_photo['value']) ? assets_url('upload/' . $staff_photo['value']) : assets_url('images/User-icon.png'); ?>" alt="" id="preview" />
      </div>
      <div class="input-append file">
        <input type="file" name="photo" onchange="readURL(this)" style="display:none;" />
        <input type="text" style="width:243px"/>
        <a href="#" class="btn">Browse</a>
      </div>
    </div>
    <div class="one_third">
      <h3>Basic information</h3>
      <table width="100%">
        <tr>
          <td width="20%">NIK</td>
          <td><div class="span1"><?php echo form_input($staff_nik); ?></div></td>
        </tr>
        <tr>
          <td>Kode Absen</td>
          <td><div class="span1"><?php echo form_input($staff_kode_absen); ?></div></td>
        </tr>
        <tr>
          <td>Name</td>
          <td><div class="span2"><?php echo form_input($staff_name); ?></div></td>
        </tr>
        <tr>
          <td>Birthdate</td>
          <td>
          <div style="float: left; width: 110px;"><?php echo form_input($staff_birthplace); ?></div>
          <div style="float: left; margin-right: 5px;spadding-top: 20px;font-size: 14px;">, </div>
          <div style="float: left; width: 110px;"><?php echo form_input($staff_birthdate); ?></div>
          <br class="cl" />
          </td>
        </tr>
        <tr>
          <td valign="top">Address</td>
          <td><?php echo form_textarea($staff_address); ?></td>
        </tr>
        <tr>
          <td>Email</td>
          <td><div class="span2"><?php echo form_input($staff_email); ?></div></td>
        </tr>
        <tr>
          <td>Email Alternatif</td>
          <td><div class="span2"><?php echo form_input($staff_email_alternatif); ?></div></td>
        </tr>
        <tr>
          <td>Phone</td>
          <td><div class="span2"><?php echo form_input($staff_phone_home); ?></div></td>
        </tr>
        <tr>
          <td>Mobile</td>
          <td><div class="span2"><?php echo form_input($staff_phone_hp); ?></div></td>
        </tr>
        <tr>
          <td>Gender</td>
          <td><div class="span2"><?php echo $staff_sex; ?></div></td>
        </tr>
        <tr>
        	<td><b>Passport</b></td>
        	<td>
            <table>
            	<tr>
                <td width="30%">No</td>
            		<td><?php echo form_input($no_passport); ?></td>
            	</tr>
            	<tr>
            		<td>Expired</td>
            		<td><?php echo form_input($passport_expired); ?></td>
            	</tr>
            </table>        	
        	</td>
        </tr>
        <tr>
        	<td><b>KITAS</b></td>
        	<td>
            <table>
            	<tr>
            		<td width="30%">No</td>
            		<td><?php echo form_input($no_passport); ?></td>
            	</tr>
            	<tr>
            		<td>Expired</td>
            		<td><?php echo form_input($passport_expired); ?></td>
            	</tr>
            </table>        	
        	</td>
        </tr>
      </table>
    </div>
    <div class="one_third lastcolumn">
      <h3>Status</h3>
      <table>
        <tr>
          <td>Cabang</td>
          <td><?php echo $staff_cabang; ?></td>
        </tr>
        <tr>
          <td>Departement</td>
          <td><?php echo $staff_departement; ?></td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td><?php echo $staff_jabatan; ?></td>
        </tr>
        <tr>
          <td width="40%">Status Pajak</td>
          <td><?php echo $staff_status_pajak; ?></td>
        </tr>
        <tr>
          <td>Status Nikah</td>
          <td><?php echo $staff_status_nikah; ?></td>
        </tr>
        <tr>
          <td>Status Karyawan</td>
          <td><?php echo $staff_status_karyawan; ?></td>
        </tr>
        <tr>
        	<td>Saldo cuti</td>
        	<td><div class="span1">
            <?php echo form_input($saldo_cuti); ?>        	
        	</div></td>
        </tr>
        <tr>
        	<td>PPh by company</td>
        	<td>
        	 <input type="checkbox" name="status_pph" id="status_pph"<?php echo $pph_by_company == 'y' ? ' checked':''; ?> />
        	</td>
        </tr>
        <tr>
        	<td>Mulai kerja</td>
        	<td><div class="span2"><?php echo form_input($mulai_kerja); ?></div></td>
        </tr>
        <tr>
        	<td>No Contract</td>
        	<td><div class="span2"><?php echo form_input($no_contract); ?></div></td>
        </tr>
        <tr>
        	<td>Contract from</td>
        	<td><div class="span2"><?php echo form_input($contract_from); ?></div></td>
        </tr>
        <tr>
        	<td>Contract to</td>
        	<td><div class="span2"><?php echo form_input($contract_to); ?></div></td>
        </tr>
        <tr>
        	<td>Tgl Keluar</td>
        	<td><div class="span2"><?php echo form_input($date_out); ?></div></td>
        </tr>
        <tr>
        	<td>Alasan keluar</td>
        	<td><div class="span2"><?php echo form_textarea($out_note); ?></div></td>
        </tr>
      </table>
    </div>
    <div class="spacer2"></div>
    <!-- tabs -->
    <h3>Histories & Families</h3>
    <ul class="nav nav-tabs">
      <li class="active"><a href="#family" data-toggle="tab">Family</a></li>
      <li><a href="#health" data-toggle="tab">Health</a></li>
      <li><a href="#works" data-toggle="tab">Work</a></li>
      <li><a href="#educations" data-toggle="tab">Education</a></li>
    </ul>
    <div class="tab-content" style="overflow: visible">
      <div class="tab-pane active" id="family">
        <div id="family_table"></div>
      </div>
      <div class="tab-pane" id="health">
        <div id="medic_table"></div>
      </div>
      <div class="tab-pane" id="works">
        <div id="works_table"></div>
      </div>
      <div class="tab-pane" id="educations">
        <div id="edu_table"></div>
      </div>
    </div>
    <!-- tabs salary -->
    <h3>Salaries</h3>
    <ul class="nav nav-tabs">
      <li class="active"><a href="#salary_components" data-toggle="tab">Salary Component</a></li>
      <li><a href="#salary_history" data-toggle="tab">Salary History</a></li>
    </ul>
    <div class="tab-content" style="overflow: visible">
      <div class="tab-pane active" id="salary_components">
        <div class="one_half">
          <h5>Component A</h5>
          <div id="salary_component_a"></div>
        </div>
        <div class="one_half lastcolumn">
          <h5>Component B</h5>
          <div id="salary_component_b"></div>
        </div>
      </div>
      <div class="tab-pane" id="salary_history">
        <h5>Salary histories</h5>
        <table class="table fpTable table-hover">
        	<thead>
        		<tr>
        			<th width="15%">Periode</th>
        			<th width="20%">Total A</th>
        			<th width="15%">Total B</th>
        			<th width="20%">Subtotal</th>
        			<th width="15%">PPh</th>
        			<th width="15%">Nett</th>
        		</tr>
        	</thead>
        </table>
      </div>
    </div>
    <br class="cl" />
    <div class="spacer2"></div>
    <div id="families_hidden"></div>
    <div id="medics_hidden"></div>
    <div id="works_hidden"></div>
    <div id="edu_hidden"></div>
    <div id="salary_comp_a"></div>
    <div id="salary_comp_b"></div>
    <?php echo form_submit($btn_save); ?> <?php echo $link_back; ?>
    <?php echo form_close() ?>
  </div>
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
</div>
<?php get_footer(); ?>
