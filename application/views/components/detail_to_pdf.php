<!DOCTYPE html>
<html lang="en">
	<head>
	<style type="text/css">
		table {
			border-width: 0 0 1px 1px;
			border-spacing: 0;
			border-collapse: collapse;
			border-style: solid;
		}
 
		td, th {
			margin: 0;
			padding: 4px;
			border-width: 1px 1px 0 0;
			border-style: solid;
		}
	</style>
	</head>
    <body>
    	<center>
    		<h3>Detail Salary Report</h3>
    	</center>
      	<table width="50%" align="center">
      		<?php
      		if ($this->input->get('period') != "") {
      		?>
  			<tr>
  				<td>Period</td>
 				<td><?php echo bulan($this->input->get('period')); ?></td>
			</tr>
      		<?php
      		}
      		if ($this->input->get('staff_cabang') != "") {
      		?>
  			<tr>
  				<td>Branch</td>
 				<td><?php echo $this->input->get('staff_cabang'); ?></td>
			</tr>
      		<?php
      		}
      		if ($this->input->get('$staff_departement') != "") {
      		?>
  			<tr>
  				<td>Department</td>
 				<td><?php echo $this->input->get('$staff_departement'); ?></td>
			</tr>
      		<?php
      		}
      		if ($this->input->get('staff_jabatan') != "") {
      		?>
  			<tr>
  				<td>Title</td>
 				<td><?php echo $this->input->get('staff_jabatan'); ?></td>
			</tr>
      		<?php
      		}
      		if ($this->input->get('staff_name') != "") {
      		?>
  			<tr>
  				<td>Name</td>
 				<td><?php echo $this->input->get('staff_name'); ?></td>
			</tr>
      		<?php
      		}
      		?>
      	</table>
    	<br />
		<table width="100%" align="center">
	      <thead>
	        <tr>
	          <th rowspan="2">Cabang</th>
	          <th rowspan="2">Staff</th>
	          <th rowspan="2">Department</th>
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
	      <tbody>
	      <?php
	      $branch = '';
	      foreach ($staff_branch->result() as $row) {
	      ?>
	          <tr>
	            <td><?php if ($row->staff_cabang == $branch) { echo '';} else { $branch = $row->staff_cabang; echo $row->staff_cabang;} ?></td>
	            <td><?php echo $row->staff_name; ?></td>
	            <td><?php echo $row->staff_cabang; ?></td>
	            <td><?php echo $row->staff_jabatan; ?></td>
	            <td><?php echo $row->hari_masuk; ?></td>
	            <td><?php echo floor((strtotime($row->date_end)-strtotime($row->date_start))/(60*60*24)); ?></td>
	            <td><?php echo $row->izin_jumlah_hari; ?></td>
	            <td><?php $total_a = get_total_component_a($row->staff_id,$this->input->get('period')); echo number_format($total_a,0,',','.'); ?></td>
	            <td><?php $total_b = get_total_component_b($row->staff_id,$this->input->get('period')); echo number_format($total_b,0,',','.'); ?></td>
	            <td><?php $grand = ($total_a+$total_b); echo $grand; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'n'? number_format(get_total_monthly_tax($row->staff_id),0,',','.'):'-'; ?></td>
	            <td><?php echo $row->pph_by_company == 'y'? number_format($grand,0,',','.'):number_format(($grand-get_total_monthly_tax($row->staff_id)),0,',','.'); ?></td>
	          </tr>
	      <?php } ?>
	      </tbody>
	    </table>
	</body>
</html>