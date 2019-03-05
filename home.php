<?php
session_start('app_session');
include 'methods.php';
include 'google/google_auth.php';
 ?>
<html>
<head>
<title>ShoutOut Social</title>
<style>
<?php include('styles.css'); ?>
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="jquery-3.3.1.min.js"></script>

</head>
<body>

<div class="header">
  <h1 class="inline title">SHOUTout</h1>

  <button class="show_gauth" id="show_gauth">Gear</button>

  <!--- CURRENTLY LOGGED IN AS --->
  <div class="inline loggedInAs">
    <div class="loggedinrow">
      <div class="loggedincolumn">
        <div class="profileImage">
          <!--- PROFIE GOES HERE --->
          <img src="assets/profpic.png">
        </div>
      </div>

      <?php if($_SESSION['department'] == 'Research&Development'){
        $code = 'green';
      }else if($_SESSION['department'] == 'Sales&Marketing'){
        $code = 'blue';
      }else{
        $code = 'red';
      } ?>
      <div class="loggedincolumn">
        <div class="colorBar" style="border-left:5px solid <?php echo($code); ?>">
          <p><?php echo('@'.$_SESSION['username'].'('.$_SESSION['employee_id'].')')?></p>
          <p><?php echo($_SESSION['department'])?></p>
          <p><?php echo('Likes: '.$_SESSION['likes'])?></p>
          <p><?php echo('Comments: '.$_SESSION['comments'])?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">

  <div class="column" >
    <!--- CREATE POST --->
    <form action="" method="post">
      <input class="postInput inline" name="post_input" placeholder="Start typing...">
      <input class="inline postSubmit btn btn-lg" name="post_submit" value="Shout!" type="submit">
    </form>
    <?php
    create_post();
    ?>
    <!--- POST VIEW --->
    <?php
      $post_row = fetch_post();
      foreach($post_row as $s_post){
        $id = $s_post['id'];
        $likes = $s_post['likes'];
    ?>
      <div class="postCard">
        <div class="row">
          <div class="postcolumn">
            <img style="float:left; margin-left:5%;" src="assets/profpic.png">
          </div>
          <div class="postcolumn">
            <div class="postUserInfo">
              <p><?php echo('@'.$s_post['user_name'].'('.$s_post['employee_id'].')'); ?><p>
                <p><?php echo($s_post['post_time']); ?><p>
                </div>
          </div>
        </div>
        <div class="postBody">
          <p><?php echo($s_post['body']); ?><p>
        </div>
        <button class="inline btn">Likes: <?php echo($likes); ?></button>
        <button id="showComment" class="inline btn">Comment</button>
      </div>
    <?php
      }
     ?>

  </div>

  <div class="column" id="contact_view">

    <?php
      $row = fetch_user();
      foreach($row as $user){
    ?>
      <!-- contact card ----->
      <div class="contactCard">
        <div class="cardrow">
          <div class="cardcolumn">
            <div class="">
              <!--- PROFIE GOES HERE --->
              <img class="profilePic" src="assets/profpic.png">
            </div>
          </div>
          <div class="cardcolumn">
            <p><?php echo('Likes: '.$user['likes'])?></p>
            <p><?php echo('Comments: '.$user['comments'])?></p>
          </div>
          <?php if($user['department'] == 'Research&Development'){
            $code = 'green';
          }else if($user['department'] == 'Sales&Marketing'){
            $code = 'blue';
          }else{
            $code = 'red';
          } ?>
          <div class="cardcolumn">
            <div class="colorBar" style="border-left:5px solid <?php echo($code); ?>">
              <p><?php echo('@'.$user['user_name'])?></p>
              <p><?php echo($user['department'])?></p>
            </div>
          </div>
        </div>
      </div>
    <?php
      }
     ?>
  </div>

  <!--- comment div --->
  <div class="column comments_view" id="comments_view" style="display:none;">
    <div class="postCard">
      <div class="row">
        <div class="postcolumn">
          <img style="float:left; margin-left:5%;" src="assets/profpic.png">
        </div>
        <div class="postcolumn">
          <div class="postUserInfo">
            <p><?php echo('@'.$s_post['user_name'].'('.$s_post['employee_id'].')'); ?><p>
              <p><?php echo($s_post['post_time']); ?><p>
              </div>
        </div>
      </div>
      <div class="postBody">
        <p>Its like -14 degrees...  <p>
      </div>
      <button class="inline btn">Likes: 14</button>
    </div>
  </div>

  <div id="gauth_start" class="gauth_start" style="display:none;">
    <div class="gauth_container">
      <h1>get started with gauth</h1>
    </div>
  </div>

</div>

<script>
  $(document).ready(function(){
    console.log("ready");
    $("#showComment").click(function(){
      console.log("click");
      $("#comments_view").slideDown();
      $("#contact_view").hide();
      $("#gauth_start").hide();
    });

    $("#show_gauth").click(function(){
      $("#gauth_start").slideDown();
      $("#comments_view").hide();
      $("#contact_view").hide();
    });
});
</script>

</body>
</html>
