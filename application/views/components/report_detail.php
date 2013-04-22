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
      <h1>Salary
      <small>Detail Salary Report</small>
      </h1>
    </div>
    <br class="cl" />
    <div class="head blue">
      <?php echo header_btn_group_report("components/report_detail/");?>
    </div>
    <div id="search_bar" class="widget-header">
      <?php search_form(array(""=>"By","staff_name"=>"Nama","branch_name"=>"Branch")); ?>
    </div>
    <table class="table fpTable table-hover">
      <thead>
        <tr>
          <th rowspan="2">Cabang</th>
          <th rowspan="2">Staff</th>
          <th rowspan="2">Title</th>
          <th colspan="3">Daftar Absensi</th>
          <th rowspan="2">Total A</th>
          <th rowspan="2">Total B</th>
          <th rowspan="2">Grand</th>
          <th colspan="2">PPh</th>
          <th rowspan="2">Net</th>
        </tr>
        <tr>
          <th>Absen</th>
          <th>Cuti</th>
          <th>Izin</th>
          <th>Perusahaan</th>
          <th>Pribadi</th>
        </tr>
      </thead>
      <?php
      $branch = '';
      foreach ($staff_branch->result() as $row) {
      ?>
          <tr>
            <td><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
            <td><?php echo $row->staff_name; ?></td>
            <td><?php echo $row->staff_jabatan; ?></td>
            <td><?php echo $row->hari_masuk; ?></td>
            <td><?php echo floor((strtotime($row->date_end)-strtotime($row->date_start))/(60*60*24)); ?></td>
            <td><?php echo $row->izin_jumlah_hari; ?></td>
            <td><?php $total_a = get_total_component_a($row->staff_id,date('Y-m-d')); echo number_format($total_a,0,',','.'); ?></td>
            <td><?php $total_b = get_total_component_b($row->staff_id,date('Y-m-d')); echo number_format($total_b,0,',','.'); ?></td>
            <td><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
            <td><?php echo $row->pph_by_company == 'y'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
            <td><?php echo $row->pph_by_company == 'n'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
            <td><?php echo $row->pph_by_company == 'y'? number_format($grand,0,',','.'):number_format(($grand-get_total_monthly_tax($row->staff_id)),0,',','.'); ?></td>
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