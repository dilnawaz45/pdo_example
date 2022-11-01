<?php
include "connection.php";

/*** Insert new Data ***/
if(isset($_POST['save']) && $_POST['save'] == "Save"){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$course = $_POST['course'];
	/*** MYSQL: prepare function works like mysqli_query without values.  ***/
	$exe = $con->prepare("INSERT INTO `students`(`id`, `name`, `email`, `course`, `status`) VALUES (:id, :name, :email, :course, :status)");

	/*** execute() used to data binding with prepare query ***/
	$sts = $exe->execute([
		":id"=>null,
		":name"=>$name,
		":email"=>$email,
		":course"=>$course,
		":status"=>1,
	]);

	if($sts){
		echo "<script>alert('Data Saved Successfully!'); window.location.href='insert.php';</script>";
	}
	else{
		echo "<script>alert('Failed to saved data!');</script>";
	}
}

/*** Update Data ***/
if(isset($_POST['update']) && $_POST['update'] == "Update"){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$course = $_POST['course'];
	$id = $_POST['id'];
	/*** MYSQL: prepare function works like mysqli_query without values.  ***/
	$exe = $con->prepare("UPDATE `students` SET `name`=:name,`email`=:email,`course`=:course WHERE `id`=:id");

	/*** execute() used to data binding with prepare query ***/
	$sts = $exe->execute([
		":name"=>$name,
		":email"=>$email,
		":course"=>$course,
		":id"=>$id
	]);

	if($sts){
		echo "<script>alert('Data Update Successfully!'); window.location.href='index.php';</script>";
	}
	else{
		echo "<script>alert('Failed to update data!');</script>";
	}
}

$name = $email = $course = "";
/*** Fetch Single Data ***/
if(isset($_GET['id']) && isset($_GET['token']) && $_GET['token'] == md5('-'.$_GET['id'])){
	$id = $_GET['id'];
	$exe = $con->prepare("SELECT * FROM `students` WHERE `id`=:id");
	$exe->execute([":id" => $id]);
	$row = $exe->fetch();
	$name = $row['name'];
	$email = $row['email'];
	$course = $row['course'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
	<title>Insert Data</title>
</head>
<body>
	<br/><br/>
	<div class="container">
		<a href="index.php" class="btn btn-primary">Go back Home</a>
		<form action="" method="post">
			<div class="col-md-6 offset-3">
				<div class="form-group">
					<input type="text" name="name" class="form-control" placeholder="Student Name" value="<?=$name;?>">
				</div>
				<div class="form-group">
					<input type="email" name="email" class="form-control" placeholder="Student Email" value="<?=$email;?>">
				</div>
				<div class="form-group">
					<input type="text" name="course" class="form-control" placeholder="Student Course" value="<?=$course;?>">
				</div>
				<div class="form-group">
				<?php
				if(isset($id)){
					echo '<input type="hidden" name="id" value="'.$id.'"/>
					<input type="submit" name="update" class="btn btn-info" value="Update">';
				}
				else{
					echo '<input type="submit" name="save" class="btn btn-success" value="Save">';
				}
				?>
				</div>
			</div>
		</form>
	</div>
</body>
</html>

<?php $con=null; ?>