<?php
include 'methods.php';
login();
?>
<!DOCTYPE html>
<html>
	<head>
	<!--- LINK TO BOOTSTRAP --->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!--- LINK TO JQUERY, POPPER.JS AND BOOTSTRAP JS --->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<!--- LINK TO OUR CSS STYLES --->
  <style>

  .header{
    position: static;
    background-image: linear-gradient(#dc3545,#dc354582);
    height: 15vh;
    z-index: 1;
  }
  /* Create two equal columns that floats next to each other */
  .column {
    float: left;
    width: 50%;
    padding: 10%;
    height: 100%; /* Should be removed. Only for demonstration */
  }

  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }

  .pad{
    margin:10px;
    z-index: 100;
  }

  #myVideo {
  position: fixed;
  bottom: 0;
  min-width: 100%;
  min-height: 100%;
  z-index: -100;
  opacity: 0.5;
  filter: blur(4px);
}

.content {
  bottom:0;
  top:0;

  background: rgba(0, 0, 0, 0.5);
  color: white;
  height: 100%;
  width: 100%;
  padding: 20px;
  z-index: -1;
   position: absolute;

}

.leftdiv{
  position: relative;
  background-image: linear-gradient(to right, #212121,#212121f2,#212121f1,#2121217a,#21212100);
  height: 120vh;
  top:-20px;
  left:-10px;
}

.inputHolder{
  background-image: linear-gradient(to right, #212121,#21212100);
border-left: 7px solid #dc3545;
padding:10%;
border-radius: 5px;
width:100%;
margin-top: 100px

}

input[type=text]:focus {
  border: 3px solid #dc3545;
  box-shadow: none;
}

input[type=password]:focus {
  border: 3px solid #dc3545;
  box-shadow: none;
}


  </style>

	</head>
<body>
  <video autoplay muted loop id="myVideo">
  <source src="assets/stockvid.mp4" type="video/mp4">
  Your browser does not support HTML5 video.
   </video>
   <div class="header">
   </div>

	<!--- THE SIGNUP FORM --->
<div class="content">
<div class="row">
<div class='text-center column leftdiv'>
  <div class="inputHolder">
<div id='contain-greet'>
<h1 id='greeting'>Hey there!</h1>
<p>Sign up and start shouting out to your coworkers</p>
</div>

<!--- ADD IN A FUNCTION TO
      ADD DISPLAY NAME THROUGH GUI

 --->
<form id='signup' method="post">
<input class='form-control pad' name='username' type='text' placeholder="Displayname">
<input class='form-control pad' name='password' type='password' placeholder="Password">
<input class='form-control pad' name='employee_id' type='text' placeholder="Employee ID">
<select class="form-control pad" name='department' placeholder='Department'>
  <option value="Research&Develoment">Research & Develoment</option>
  <option value="Sales&Marketing">Sales & Marketing</option>
  <option value="Administration">Administration</option>
</select>
<input class='btn btn-lg btn-outline-danger btn-block pad' name='r_submit' type='submit'>
</form>
<?php
register();
 ?>
 </div>
</div>


	<!--- THE LOGIN FORM --->
<div class='text-center column'>
  <div class="inputHolder">
<h1>SHOUTout</h1>
<h5>For ConnectXYZ</h5>
<form id='login' method='post'>
<input class='form-control pad' name='employee_id' type='text' placeholder="Employee Id">
<input class='form-control pad' name='password' type='password' placeholder="Password">
<input class='btn btn-lg btn-outline-danger btn-block pad' name='l_submit' type='submit'>
</form>
</div>

</div>
</div>
</div>

</body>
</html>
