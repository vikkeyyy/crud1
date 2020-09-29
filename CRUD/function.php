<?php
include 'config.php';
if(isset($_GET['url'])){
	$_GET['url']();
}

function saveRecords(){
	global $con;
	$name 		= mysqli_real_escape_string($con,$_POST['name']);
	$email 		= mysqli_real_escape_string($con,$_POST['email']);
	$mobile 	= mysqli_real_escape_string($con,$_POST['mobile']);
	$birthday 	= mysqli_real_escape_string($con,$_POST['birthday']);
	$id 		= mysqli_real_escape_string($con,$_POST['id']);

	$file_path = "upload/";  
	$file_path = $file_path.basename( $_FILES['file']['name']);   
	$file_name = $_FILES['file']['name'];	  
	move_uploaded_file($_FILES['file']['tmp_name'], $file_path); 
	if($file_name==''){
		$file_name = mysqli_real_escape_string($con,$_POST['edit_file']);
	}
	$sql="";
	$sql="name='$name',email='$email',mobile='$mobile',birthday='$birthday',file='$file_name'";

	if($id==''){
		$sql="INSERT INTO register SET $sql";
		$msg = "Register";
	}else{
		$sql="UPDATE register SET $sql WHERE register_id=$id";
		$msg = "Update";
	}
	//echo $sql;
	if(mysqli_query($con,$sql)){
		$_SESSION["result"] = "$msg Successfully";
		
	}else{
		$_SESSION["result"] = "$msg Failed";
		
	}
	header('location:index.php');
	//echo $session['result'];
	
}

function getRecords(){
	$arrData = array();
	global $con;
	$sql="SELECT * FROM `register` WHERE `status` = 1";
	$result = mysqli_query($con,$sql);
	if(mysqli_num_rows($result)>0){
		$i=0;
		while($row = mysqli_fetch_array($result)){
			$arrData['register_id'][$i]  	= $row['register_id'];
			$arrData['name'][$i] 			= $row['name'];
			$arrData['email'][$i] 			= $row['email'];
			$arrData['mobile'][$i] 			= $row['mobile'];
			$arrData['birthday'][$i] 		= $row['birthday'];
			$arrData['file'][$i] 			= $row['file'];
			$i++;
		}
	}
	return $arrData;

}

function getClickRecords(){
	//echo $_POST['id'];
	global $con;
	$arrData = array();	
	$sql="SELECT * FROM `register` WHERE `status` = 1 AND register_id='$_POST[id]'";
	$result = mysqli_query($con,$sql);
	if(mysqli_num_rows($result)>0){
		while($row = mysqli_fetch_array($result)){
			$arrData['register_id']  	= $row['register_id'];
			$arrData['name'] 			= $row['name'];
			$arrData['email']			= $row['email'];
			$arrData['mobile'] 			= $row['mobile'];
			$arrData['birthday'] 		= $row['birthday'];
			$arrData['file'] 			= $row['file'];
		}
	}
	echo json_encode($arrData);
}
function deleteRecord(){
	global $con;
	$sql="UPDATE register SET status=0 WHERE register_id='$_GET[id]'";
	if(mysqli_query($con,$sql)){
		$_SESSION["result"] = "Delete Successfully";
		
	}else{
		$_SESSION["result"] = "Delete Failed";
		
	}
	header('location:index.php');
}

?>