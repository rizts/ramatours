<?php get_header(); ?>
<?php echo load_js(array("search_date.php")); ?>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('staffs') . "?c=";
    //set column query string value
    switch ($key) {
        case "staff_nik":
            $out .= "1";
            break;
        case "staff_name":
            $out .= "2";
            break;
        case "staff_address":
            $out .= "3";
            break;
        case "staff_email":
            $out .= "4";
            break;
        case "staff_phone_home":
            $out .= "5";
            break;
        case "staff_phone_hp":
            $out .= "6";
            break;
        case "staff_cabang":
            $out .= "7";
            break;
        case "staff_departement":
            $out .= "8";
            break;
        case "staff_jabatan":
            $out .= "9";
            break;
        case "staff_id":
            $out .= "10";
            break;
        default:
            $out .= "0";
    }

    $out .= "&d=";

    //reverse sort if the current column is clicked
    if ($key == $col) {
        switch ($dir) {
            case "ASC":
                $out .= "1";
                break;
            default:
                $out .= "0";
        }
    } else {
        //pass on current sort direction
        switch ($dir) {
            case "ASC":
                $out .= "0";
                break;
            default:
                $out .= "1";
        }
    }

    //complete link
    $out .= "\">$value</a>";

    return $out;
}
?>

<div class="body">
  <div class="content">
    <?php echo $this->session->flashdata('message'); ?>
    <div class="page-header">
      <div class="icon">
        <span class="ico-coins"></span>
      </div>
      <h1>Staff
      <small>Report staff list</small>
      </h1>
    </div>
    <br class="cl" />
    <div class="head blue">
      <?php echo header_btn_group_report("staffs/list_to_pdf/".$this->input->get("search_by")."/".$this->input->get("q"));?>
    </div>
    <div id="search_bar" class="widget-header">
      <?php search_form(array(""=>"By","staff_name"=>"Nama","staff_birthdate"=>"Tgl Lahir")); ?>
    </div>
    <table class="table fpTable table-hover">
      <thead>
        <tr>
          <th><?php echo HeaderLink("Branch", "staff_cabang", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Departement", "staff_departement", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Name", "staff_name", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Title", "staff_jabatan", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Birth Date", "staff_birth_date", $col, $dir); ?></th>
          <?php
          if ($this->input->get("search_by") == "staff_birthdate") {
          ?>
          <th>Yang Ke</th>
          <?php
          }
          ?>
        </tr>
      </thead>
      <?php
      foreach ($staff_list as $row) {
      ?>
          <tr>
            <td><?php echo $row->staff_cabang; ?></td>
            <td><?php echo $row->staff_departement; ?></td>
            <td><?php echo $row->staff_name; ?></td>
            <td><?php echo $row->staff_jabatan; ?></td>
            <td><?php echo $row->staff_birthdate; ?></td>
          	<?php
          	if ($this->input->get("search_by") == "staff_birthdate") {
          	?>
          	<td><?php $birthyear = date('Y', strtotime($row->staff_birthdate)); echo intval(date('Y')-intval($birthyear)); ?></td>
          	<?php
          	}
          	?>
          </tr>
      <?php } ?>
    </table>
    <div class="clearfix"></div>
    <div class="pagination pagination-right">
      <ul>
        <?php echo $pagination; ?>
      </ul>
    </div>
  </div>
</div>

<?php get_footer(); ?>
