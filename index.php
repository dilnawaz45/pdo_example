<?php
include "connection.php";

if(isset($_GET['id']) && isset($_GET['token']) && $_GET['token'] == md5('=>'.$_GET['id'])){
	$exe = $con->prepare("DELETE FROM `students` WHERE `id`=:id");
	$sts = $exe->execute([":id" => $_GET['id']]);
	if($sts){
		echo "<script>alert('Student Deleted Successfully!'); window.location.href='index.php';</script>";
	}
	else{
		echo "<script>alert('Something went wrong, please try again...!'); window.location.href='index.php';</script>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>List All || PDO </title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
</head>
<body>
	<h3 class="text-center">PDO Example</h3>
	<a href="insert.php" class="btn btn-primary float-right">Add New Student</a>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>S. No</th>
				<th>Student Name</th>
				<th>Email ID</th>
				<th>Course</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$qr = $con->query("SELECT * FROM ".DB_NAME.".`students` WHERE status=1 ORDER BY `name`");
		$i=1;
		$rows = $qr->fetchAll(PDO::FETCH_ASSOC);
		foreach($rows as $row){

			echo '<tr>
				<td>'.$i.'</td>
				<td>'.$row['name'].'</td>
				<td>'.$row['email'].'</td>
				<td>'.$row['course'].'</td>
				<td>
					<a href="insert.php?id='.$row['id'].'&token='.md5('-'.$row['id']).'" class="btn btn-success btn-sm">Edit</a>
					<a href="index.php?id='.$row['id'].'&token='.md5('=>'.$row['id']).'" onClick="return confirm(\'Do you want to Delete this Student?\')" class="btn btn-danger btn-sm">Delete</a>
				</td>
			</tr>';
			$i++;
		}
		?>
		</tbody>
	</table>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</html>