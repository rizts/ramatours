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
    		<h3>Report Sisa Cuti</h3>
    	</center>
		<table width="100%" align="center">
	      <thead>
	        <tr>
	          <th>Branch</th>
	          <th>Departement</th>
	          <th>Name</th>
	          <th>Title</th>
	          <th>Sisa Cuti</th>
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
	            <td><?php echo $row->saldo_cuti; ?></td>
	          </tr>
	      <?php
		  }
		  ?>
	      </tbody>
	    </table>
	</body>
</html>