<?php
//index.php
?>

<!DOCTYPE HTML>  

<html>
<head>
  <title>Contact Book</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$nameErr = $surnameErr = $addressErr = $emailErr = $phoneErr = "";
$name = $surname = $address = $email = $phone = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $valid = true;

  if (empty($_POST["name"])) {
    $nameErr = "Required";
    $valid = false; //false
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["surname"])) {
    $surnameErr = "Required";
    $valid = false;
  } else {
    $surname = test_input($_POST["surname"]);
    // check if surname only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$surname)) {
      $surnameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST["address"])) {
    $address = "";
  } else {
    $address = test_input($_POST["address"]);
    // check if address contains only letters numbers and whitespace
    if (!preg_match("/^[^0-9a-zA-Z]*$/",$address)) {
      $addressErr = "Only letters numbers and white space allowed";
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Required";
    $valid = false;
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["phone"])) {
    $phone = "";
  } else {
    $phone = test_input($_POST["phone"]);
    // check if phone contains only numbers
    if (!preg_match('/^[0-9]+$/', $phone)) {
      $phoneErr = "Only numbers allowed";
    }
  }
  if($valid){ 
       include  'insert.php';
       // echo '<META HTTP-EQUIV="Refresh" Content="0; URL=insert.php">'; 
       exit;       
  } 


}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div class="container">

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-11 text-center">
          <h1 class="title">A small web-based contact book</h1>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h1 class="panel-title">Contact Book</h1>
            </div>

            <div class="elem-group">
            <label for="name"> First Name: </label>
            <input type="text" id="name" name="name" placeholder="firstname" pattern=[A-Z\sa-z]{3,20} value="<?php echo $name;?>">
            <span class="error">* <?php echo $nameErr;?></span>
            </div>

            <div class="elem-group">
            <label for="surname"> Surname: </label>
            <input type="text" id="surname" name="surname" placeholder="surname" pattern=[A-Z\sa-z]{3,20} value="<?php echo $surname;?>">
            <span class="error">* <?php echo $surnameErr;?></span>
            </div>

            <div class="elem-group">
            <label for="address">Address: </label>
            <input type="text" id="address" name="address" placeholder="street & house number" pattern=[A-Z\sa-z]{0,1,2,3,4,5,6,7,8,9} value="<?php echo $address;?>">
            <span class="error"><?php echo $addressErr;?></span>
            </div>

            <div class="elem-group">
            <label for="email"> E-mail: </label>
            <input type="email" id="email" name="email" placeholder="example@email.com" value="<?php echo $email;?>">
            <span class="error">* <?php echo $emailErr;?></span>
            </div>

            <div class="elem-group">
            <label for="name">Telephone: </label>
            <input type="text-center" id="phone" name="phone" placeholder="phone number" pattern={0,1,2,3,4,5,6,7,8,9} value="<?php echo $phone;?>">
            <span class="error"><?php echo $phoneErr;?></span>
            </div> 
            <span class="error">* Required Field</span><br/>

            <p><input type="submit" name="submit" value="Submit"></p><br/>
            </form>
            <div class="col-md-9" style="margin:0 auto; float:none;width: 15%">
              <span id="message"></span>
              <form method="post" id="import_form" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Select XML File</label>
                  <input type="file" name="file" id="file" />
                </div>
                <div class="form-group">
                  <input type="submit" name="submit" id="submit" class="btn btn-info" value="Import" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </body>
  </html>
<script>
$(document).ready(function(){
 $('#import_form').on('submit', function(event){
  event.preventDefault();

  $.ajax({
   url:"import-xml.php",
   method:"POST",
   data: new FormData(this),
   contentType:false,
   cache:false,
   processData:false,
   beforeSend:function(){
    $('#submit').attr('disabled','disabled'),
    $('#submit').val('Importing...');
   },
   success:function(data)
   {
    $('#message').html(data);
    $('#import_form')[0].reset();
    $('#submit').attr('disabled', false);
    $('#submit').val('Import');
   }
  })

  setInterval(function(){
   $('#message').html('');
  }, 5000);

 });
});
</script>