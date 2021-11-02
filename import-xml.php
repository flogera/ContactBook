<?php
//import.php
sleep(3);
$output = '';

if(isset($_FILES['file']['name']) &&  $_FILES['file']['name'] != '')
{
 $valid_extension = array('xml');
 $file_data = explode('.', $_FILES['file']['name']);
 $file_extension = end($file_data);
 if(in_array($file_extension, $valid_extension))
 {
  $data = simplexml_load_file($_FILES['file']['tmp_name']);
  $connect = new PDO('mysql:host=localhost;dbname=exercise','root', '');
  $query = "
  INSERT INTO contact 
   (FirstName, LastName, Address, Email, Phone) 
   VALUES(:name, :surname, :address, :email, :phone);
  ";  
  $statement = $connect->prepare($query);
  for($i = 0; $i < count($data); $i++)
  {
   $statement->execute(
    array(
     ':name'   => $data->contact[$i]->name,
     ':surname'  => $data->contact[$i]->surname,
     ':address'  => $data->contact[$i]->address,
     ':email' => $data->contact[$i]->email,
     ':phone'   => $data->contact[$i]->phone
    )
   );

  }
  $result = $statement->fetchAll();
  if(isset($result))
  {
   $output = '<div class="alert alert-success">Import Data Done</div>';
  }
 }
 else
 {
  $output = '<div class="alert alert-warning">Invalid File</div>';
 }
}
else
{
 $output = '<div class="alert alert-warning">Please Select XML File</div>';
}

echo $output;

?>
