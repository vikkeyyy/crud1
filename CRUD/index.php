<?php
include 'function.php';
$records = getRecords();
//print_r($records);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CRUD</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  	function editClick(id){
  		//console.log("work");
  		$('#reset').attr('style',"display:block;float: left;");
  		$('#form_submit').attr('value',"Update");
  		document.getElementById('formHead').innerHTML = "Update Form";
  		$.ajax({
  			method:"POST",
  			url:"function.php?url=getClickRecords",
  			data:{id:id},
  			success:function(data){
  				//console.log(data);
  				datas = JSON.parse(data);
  				//console.log(datas);
  				$('#id').val(datas.register_id);
  				$('#name').val(datas.name);
  				$('#email').val(datas.email);
  				$('#mobile').val(datas.mobile);
  				$('#birthday').val(datas.birthday);
  				$('#editFile').val(datas.file);
  			}
  		})
  	}

  	function myFunction() {
  		
  		document.getElementById("myForm").reset();
  		$('#form_submit').attr('value',"Submit");
  		$('#reset').attr('style',"display:none;");
  		document.getElementById('formHead').innerHTML = "Register Form";

	}
	function Validate(event) {
        var regex = new RegExp("^[0-9-()+! @#$%&*?]");
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }
  </script>
</head>
<body>

<div class="container">
	<div class="col-md-4"></div>
	<div class="col-md-8"></div>
	  <h2 id="formHead">Register Form</h2>

	  <?php if(isset($_SESSION['result'])){ ?>

	  	<script type="text/javascript">
	  		$(document).ready(function(){
	  		 	$("#form_result").fadeIn();
	  		 	$("#form_result").fadeOut(3000);
	  		});
	  	</script>

	  <center><h2 id="form_result"><?php echo $_SESSION['result']; ?></h2></center>

	<?php unset($_SESSION['result']); } ?>

	  <form action="function.php?url=saveRecords" method="POST" enctype="multipart/form-data" id="myForm" name="myForm">
	  	<input type="hidden" name="id" value="" id="id">
	    <div class="form-group">
	      <label for="name">Name:</label>
	      <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" required="" autocomplete="OFF">
	    </div>
	    <div class="form-group">
	      <label for="email">Email:</label>
	      <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required="" autocomplete="OFF">
	    </div>
	     <div class="form-group">
	      <label for="mobile">Mobile:</label>
	      <input type="text" class="form-control" id="mobile" placeholder="Enter mobile" name="mobile" onkeypress="return Validate(event);" required="" autocomplete="OFF">
	    </div>
	    <div class="form-group">
	      <label for="mobile">Birthday:</label>
	      <input type="date" class="form-control" id="birthday" name="birthday" required="" autocomplete="OFF">
	    </div>
	     
		 <div class="form-group">
	      <label for="file">File:</label>
	      <input type="file" class="form-control" id="file" name="file">
	      <input type="hidden" name="edit_file" id="editFile">
	    </div>
	     <input type="submit" name="submit" id="form_submit" value="Submit" class="btn btn-default">

	     </form>
	     <br>
	    <button style="display: none;" type="button" id="reset" class="btn btn-default" onclick="myFunction()">Reset</button> 
	 <div class="col-md-4"></div>
</div>
<div class="container">
  <h2>Show Employee Details</h2>           
  <table class="table table-bordered">
    <thead>

      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>birthday</th>
        <th>File</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>

    	<?php
    	if(empty($records)){
    	?>
    	<tr><td colspan="7">No records founds</td></tr>

    	<?php
    	}else{
    	 for($i=0;$i<count($records['register_id']);$i++) {    		
    	 ?>
      <tr>
        <td><?php echo $records['name'][$i]; ?></td>
        <td><?php echo $records['email'][$i]; ?></td>
        <td><?php echo $records['mobile'][$i]; ?></td>
        <td><?php echo $records['birthday'][$i]; ?></td>
        <td> <img src="upload/<?php echo $records['file'][$i]; ?>" alt="<?php echo $records['file'][$i]; ?>" width="50" height="50"></td>
        <td>
        	<a class="btn btn-info btn-lg" onclick="editClick(<?php echo $records['register_id'][$i]; ?>);">
          		<span class="glyphicon glyphicon-pencil"></span>  
        	</a>
    	</td>
        <td>
        	<a href="function.php?url=deleteRecord&id=<?php echo $records['register_id'][$i]; ?>" class="btn btn-info btn-lg">
          		<span class="glyphicon glyphicon-trash"></span>  
        	</a>
        </td>
      </tr>
      <?php } } ?>
    </tbody>
  </table>
</div>
</body>
</html>
