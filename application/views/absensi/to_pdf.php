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
    		<h3>Report Absensi</h3>
    	</center>
    	<br />
		<table align="center">
		    <thead>
                <tr>
                    <th width="10%">Kode Absen</th>
                    <th width="30%">Staff</th>
                    <th>Branch</th>
                    <th>Title</th>
                    <th width="20%">Date</th>
                    <th width="10%">Jumlah masuk</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($absensi->result() as $row) {
            ?>
                <tr>
                    <td><?php echo $row->staff_kode_absen; ?></td>
                    <td><?php echo $row->staff_name; ?></td>
                    <td><?php echo $row->staff_cabang; ?></td>
                    <td><?php echo $row->staff_jabatan; ?></td>
                    <td><?php echo date_format(new DateTime($row->date),'j M Y'); ?></td>
                    <td><span class="float-right"><?php echo $row->hari_masuk; ?></span></td>
                </tr>
            <?php
			}
			?>
			</tbody>
		</table>
	</body>
</html>