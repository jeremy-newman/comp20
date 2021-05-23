<?php include('functions.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>C&C Calendar Sign Up</title>
<style>

body {
  background-image: url('background1.jpg');
  background-attachment: fixed;
  background-size: 100%;
  position: relative;
  background-position: center;
  font-family: Optima;
  /* position: fixed; */
}

div.lef{
  /* width: 70%; */
	outline-color: #242224;
	/* font-size: 48px; */
  text-align: center;
	/* color: #242224; */
	font-weight: bolder;
	padding-top: 30px;
	/* padding-bottom: px; */
	/* padding-left: 5%; */
	/* margin-bottom: 10px; */
  color: #332622;
	Style:normal;
 	weight:700;
 	font-Size:56px;
 	line-Height:54px;
}


.row{
	position: relative;
	height: 100%;
	/* margin-top: 10px; */
	padding-bottom: 0px;
}
.signup-form {
    width: 340px;
    margin: 50px auto;
    margin-top: 30px;
  	font-size: 15px;

}
.signup-form form {
    margin-bottom: 15px;
    background: #f7f7f7;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    padding: 30px;
    /* margin-top: 30px; */
    background-color: #F0F8FF;
}
.signup-form h2 {
    margin: 0 0 15px;
    background-color: #F0F8FF;
    text-align: center;
    font-size: 24px;
}
.form-control{
    min-height: 38px;
    border-width: .1px;
    position: relative;
  	font-size: 18px;
  	/* margin-left: 20px; */
    padding: 10px 20px;
    text-align: left;
  	/* background-color: #533D61; */
  	color: #533D61;
    text-decoration: none;
    outline: none;
    border-color: #000;
    /* -internal-light-dark(#233C63, #233C63); */
    /* display: inline-block; */
  	/* box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3); */
    margin-bottom: 5px;
}


.btn {
    font-size: 15px;
    font-weight: bold;
    position: relative;
  	font-size: 18px;
  	/* margin-left: 20px; */
    padding: 10px 20px;
    text-align: center;
  	background-color: rgba(0, 0, 0, 0);
    border-radius: 0px;
  	color: #533D61;
    text-decoration: none;
    display: inline-block;
  	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    font-family: Optima;
    margin-top: 10px;
    border-color: rgba(0,0,0,0);
}

.btn:hover {
  background-color: #533D61;
  color: #F0F8FF;
}

.text-center {
  text-align: center;
	/* width: 90%; */
	margin-left: auto;
	margin-right: auto;
}

#signIn{
  font-family: Optima;
}

input.form-control{
  font-family: Optima;
  text-align: left;
	margin-left: auto;
	margin-right: auto;
}

div.form-group {
  text-align: center;
	/* width: 90%; */
	margin-left: auto;
	margin-right: auto;
}

a:link, a:visited {
	position: relative;
	font-size: 18px;
	/* margin-left: 20px; */
  padding: 10px 20px;
  text-align: center;
	/* background-color: #533D61; */
	color: #533D61;
  text-decoration: none;
  display: inline-block;
  /* background-color: #233C63; */
	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	font-family: Optima;
}

a:hover, a:active {
  background-color: #533D61;
  color: #F0F8FF;
}


span#already{
padding-left: 6%;
padding-right: 6px;
  /* font-weight: bolder; */
  /* margin-right: auto;
  width: 100%; */
}

hr{
  background-color: #233C63;
}


</style>
</head>
<body>
  <div class="lef" >
  Calm & Collected Calendar
  </div>

<!-- <div id="plsCenter" > -->
<div class="signup-form">
    <form method="post" action="sign_up.php">
		<h2>Sign Up</h2>
		<p>Fill in this form to create an account!</p>
		<hr>
        <div class="form-group">
			<div class="row">
				<div class="col"><input type="text" class="form-control" name="username" placeholder="Username" ></div>
			</div>
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
		<div class="form-group">
			<?php echo display_error(); ?>
            <input type="submit" class="btn btn-primary btn-lg" value="Sign Up" name="register_btn"/>
        </div>
    </form>
	<div class="hint-text"> <span id="already" > Already have an account? </span> <a href="sign_in.php">Login here</a></div>
</div>
<!-- </div> -->
</body>
</html>
