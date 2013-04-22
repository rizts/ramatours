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
    		<h3>Asset List</h3>
    	</center>
    	<br />
		<table align="center">
            <thead>
                <tr>
                    <th width="25%">Staff</th>
                    <th>Branch</th>
                    <th>Title</th>
                    <th width="15%">Date</th>
                    <th width="10%">Jumlah hari</th>
                    <th width="40%">Note</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($izin->result() as $row) {
            $staff = get_staff_detail($row->izin_staff_id);
            ?>
                <tr>
                    <td><?php echo $staff->staff_name; ?></td>
                    <td><?php echo $row->staff_cabang; ?></td>
                    <td><?php echo $row->staff_jabatan; ?></td>
                    <td><?php echo date_format(new DateTime($row->izin_date),'j M Y'); ?></td>
                    <td><?php echo $row->izin_jumlah_hari; ?></td>
                    <td><?php echo $row->izin_note; ?></td>
                </tr>
            <?php
			}
			?>
            </tbody>
        </table>
	</body>
</html>