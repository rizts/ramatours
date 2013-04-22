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
    		<h3>Report Staff List</h3>
    	</center>
      	<?php
      	if ($search_by == "staff_birthdate") {
      	?>
      	<center>
    		<h5>Ulang Tahun : <?php echo date_format(new DateTime($q),'j M Y'); ?></h5>
    	</center>
      	<?php
      	}
      	?>
      	<br />
		<table align="center">
	      <thead>
	        <tr>
	          <th>Branch</th>
	          <th>Departement</th>
	          <th>Name</th>
	          <th>Title</th>
	          <th>Birth Date</th>
	          <?php
	          if ($search_by == "staff_birthdate") {
	          ?>
	          <th>Yang Ke</th>
	          <?php
	          }
	          ?>
	        </tr>
	      </thead>
	      <tbody>
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
	          	if ($search_by == "staff_birthdate") {
	          	?>
	          	<td><?php $birthyear = date('Y', strtotime($row->staff_birthdate)); echo intval(date('Y')-intval($birthyear)); ?></td>
	          	<?php
	          	}
	          	?>
	          </tr>
	      <?php
		  }
		  ?>
	      </tbody>
	    </table>
	</body>
</html>