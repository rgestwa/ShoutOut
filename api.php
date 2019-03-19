<?php
include 'methods.php';

//this comes from database

// $post1comments = [
//
//   ['author' => 'marvin', 'comment' => 'a comment'],
//   ['author' => 'marvin', 'comment' => 'another still'],
//   ['author' => 'marvin', 'comment' => 'another comment']
// ];
//
// $post2comments = [
//
//   ['author' => 'marvin', 'comment' => 'a comment'],
//   ['author' => 'marvin', 'comment' => 'another still'],
//   ['author' => 'marvin', 'comment' => 'another comment']
// ];
//
// $comments[1] = $post1comments;
// $comments[2] = $post2comments;

$action = isset($_GET['action']) ? $_GET['action'] : null;

$json = ['status' => 'failed'];

switch($action){
  case 'get_comments':
  if(!isset($_GET['post_id'])){
    $json['error'] = "need a post id";
  }else{
    $post_id = (int)$_GET['post_id'];
    $json['status'] = 'success';
    $json['comments'] = [];
    $pdo = PDO();
    $statement = $pdo->prepare('SELECT `comments`.*,`users`.`employee_id`,`users`.`user_name` FROM `comments` LEFT JOIN `users` on `comments`.`author` = `users`.`id`  WHERE `associated_post` = ?');
    $statement->execute([$post_id]);
    $json['comments'] = $statement->fetchAll();
    }

  break;

  default:
  $json['error'] = 'Action "'.$action.'" does not exist';
  break;
}

header('Content-type: application/json');
die(json_encode($json));
?>
