<?php
// TODO: view post button on contact card
// TODO: search users functionality
// TODO: admin can edit posts

// TODO: essage for incorrect LOGIN
// TODO: functionality to block user from directly accessing HOME if not logged in

//manually sets error reporting on in ini get_included_files
//remove for production!
error_reporting(E_ALL);
ini_set('display_errors','On');
session_name('app_session');
session_start();
$timezone = "America/Vancouver";
date_default_timezone_set($timezone);

//DATA ACCESS
function PDO(){
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
  return $pdo;
}


//LOGIN
function login(){
  $pdo = PDO();
  if(isset($_POST["l_submit"])){

    $employee_id = $_POST['employee_id'];
    $pass = $_POST['password'];

    $P_options = ['cost' => 12];
    $hash = password_hash($pass,PASSWORD_BCRYPT,$P_options);
    $login_statement = $pdo->prepare('SELECT * FROM `users` WHERE `employee_id` = ?');

    if($login_statement->execute([$employee_id])){
    	$row = $login_statement->fetch();

    	if($row){
    		if(password_verify($pass,$row['password'])){
          $username = $row['user_name'];
          $user_id = $row['id'];
          $department = $row['department'];
          $likes = $row['likes'];
          $posts = $row['posts'];
          $comments = $row['comments'];

          $_SESSION['user_id'] = $user_id;
          $_SESSION['employee_id'] = $employee_id;
          $_SESSION['username'] = $username;
          $_SESSION['department'] = $department;
          $_SESSION['likes'] = $likes;
          $_SESSION['posts'] = $posts;
          $_SESSION['comments'] = $comments;
    				if(password_needs_rehash($row['password'], PASSWORD_BCRYPT, $P_options)){
    					$login_statement = $pdo->prepare('UPDATE `users` SET `password` = ? WHERE `username` = ?');
    					$login_statement->execute([$hash,$user]);
    			    }
          header('Location: home.php');
    		}else{
          echo "bad login.";
        }
    	}
    }
  }
}

//CREATING DATE TIME OBJECT
function db_timestamp(){
  return date('Y-m-d H:i:s', time());
}

//REGISTER
function register(){
  $pdo = PDO();
  if (isset($_POST["r_submit"])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $e_id = $_POST['employee_id'];

    $P_options = ['cost' => 12];
    $hash = password_hash($pass,PASSWORD_BCRYPT,$P_options);

    $register_statement = $pdo->prepare('INSERT INTO `users` (user_name, password, employee_id, role) VALUES (?, ?, ?, 1)');
    $result = $register_statement->execute([$user, $hash, $e_id]);
    print('user added.');
} else {

}

}

//`employee_id`, `user_name`, `likes`, `comments`, `posts`

//CREATING A CONTACT CARD
function fetch_user(){
  $pdo = PDO();
  $fetch_user_statement = $pdo->prepare('SELECT * FROM `users`');
  $user_result = $fetch_user_statement->execute();
  $row = $fetch_user_statement->fetchall();
  return $row;
}

//CREATING & FETCHING POSTS
function create_post(){

  // TODO add a try catch for error handling
  if(isset($_POST['post_submit'])){

    $date_stamp = db_timestamp();

    $body = $_POST['post_input'];
    $author = $_SESSION['user_id'];

    $pdo = PDO();

    $create_post_statement = $pdo->prepare('INSERT INTO `posts` (author_id, body, post_time) VALUES (?, ?, ?)');
    $create_post_result = $create_post_statement->execute([$author, $body, $date_stamp]);
  }
}
//query to get lots of posts with info
//select posts.*,users.employee_id from posts left join users on posts.author_id = users.id where SUBSTRING(users.employee_id,1,1) = "M";
function fetch_post(){
  $pdo = PDO();
    $fetch_post_statement = $pdo->prepare('SELECT `posts`.*, `users`.`employee_id`, `users`.`user_name` FROM `posts` LEFT JOIN `users` ON `posts`.`author_id` = `users`.`id` ORDER BY `post_time` DESC;');
  $post_result = $fetch_post_statement->execute();
  $post_row = $fetch_post_statement->fetchall();
  return $post_row;
}

function like(){
  if(isset($_POST['like_submit'])){
    $author = $_SESSION['user_id'];
    $upost_id = $_POST['postId'];

    $pdo = PDO();
    $add_like_statement = $pdo->prepare('INSERT INTO `likes` (post, employee) VALUES (?,?)');
    $add_like_statement->execute([$upost_id, $author]);

  }

}
