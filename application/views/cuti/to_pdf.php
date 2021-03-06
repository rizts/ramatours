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
    		<h3>Report Cuti</h3>
    	</center>
      	<table width="50%" align="center">
      		<?php
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
		<table align="center">
	      <thead>
            <tr>
	          	<th rowspan="2">Name</th>
	          	<th rowspan="2">Branch</th>
	          	<th rowspan="2">Departement</th>
	          	<th rowspan="2">Title</th>
                <th rowspan="2" width="10%">Requested date</th>
                <th colspan="2">Date</th>
                <th colspan="3">Approval</th>
            </tr>
            <tr>
                <th width="10%">From</th>
                <th width="10%">To</th>
                <th width="10%">Status</th>
                <th width="10%">Reason</th>
                <th width="10%">By</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cuti->result() as $row) {
	            $staff = get_staff_detail($row->staff_id);
	            $approve_by = get_user_detail($row->approveby_staff_id);
	            $detail = getDetail($row->id);
	            $comment = "No Comment";
	            if(count($detail)){
	              $comment = $detail->comment;  
	            }
            ?>
                <tr>
		            <td><?php echo $row->staff_name; ?></td>
		            <td><?php echo $row->staff_cabang; ?></td>
		            <td><?php echo $row->staff_departement; ?></td>
		            <td><?php echo $row->staff_jabatan; ?></td>
                    <td><?php echo date_format(new DateTime($row->date_request),'j M Y'); ?></td>
                    <td><?php echo date_format(new DateTime($row->date_start),'j M Y'); ?></td>
                    <td><?php echo date_format(new DateTime($row->date_end),'j M Y'); ?></td>
                    <td><?php echo $row->status; ?></td>
                    <td><?php echo $comment; ?></td>
                    <td><?php echo $approve_by ? $approve_by->username:"-"; ?></td>
                </tr>
            <?php
			}
			?>
	      </tbody>
	    </table>
	</body>
</html>