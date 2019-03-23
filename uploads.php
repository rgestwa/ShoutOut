<?php

/*-upload photo--Santana*/

function PDO(){
  try{
  $host = 'localhost';
  $port = 8889;
  $database = 'ShoutOut';
  $charset = 'utf8mb4';

  $DBusername = 'root';
  $DBpass = 'root';

  $dsn = "mysql:host={$host};port={$port};dbname={$database};charset={$charset}";

  $options =
  [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => FALSE
  ];

  $pdo = new PDO($dsn,$DBusername,$DBpass,$options);


}catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
  return $pdo;
}



// file name
$filename = $_FILES['file']['name'];

// Location
$location = 'uploads/'.$filename;

// file extension
$file_extension = pathinfo($location, PATHINFO_EXTENSION);
$file_extension = strtolower($file_extension);

// Valid image extensions
$image_ext = array("jpg","png","jpeg","gif");

$response = 0;
if(in_array($file_extension,$image_ext)){
  // Upload file
  if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
    $response = $location;
     
      
      /*--targeting the profile picture for each user
      $recipient = $_SESSION['user_id'];//find proper var value for u=id
      
      $pdo = PDO();
      $create_profile_pic_statement = $pdo->prepare('INSERT INTO `users` ');//finish insert stmt
      $create_profile_pic_statement->execute([$recipient]);
      ---*/
  }
}

echo $response;
?>