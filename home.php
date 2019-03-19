<?php
include 'methods.php';
include 'google/google_auth.php';

 ?>
<html>
<head>
<meta property="og:title" content="SHOUTOut" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://localhost:8888/mockproject/home.php" />
<meta property="og:image" content="http://ia.media-imdb.com/images/rock.jpg" />
<meta property="og:description" content="a description" />

<title>ShoutOut Social</title>
<style>
<?php include('styles.css'); ?>
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="jquery-3.3.1.min.js"></script>
<script src="home.js" type="text/javascript"></script>
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

  <div class="column posts" >
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
      <div class="postCard" data-id="<?php echo $id; ?>">
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
        <form id='like_form' method='post'>
          <!-- a hidden input field to get a post variable representing our incrementing post id -->
          <input type="hidden" name="postId" value="<?php echo $id; ?>">
        <button class="addLike inline btn" type="like_submit" name="like_submit">Likes: <?php echo($likes); ?></button>
        </form>
        <?php like(); ?>
        <button class="showComment inline btn">Comment</button>
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
    <div class="postCard template">
      <div class="row">
        <div class="postcolumn">
          <img style="float:left; margin-left:5%;" src="assets/profpic.png">
        </div>
        <div class="postcolumn">
          <div class="postUserInfo">
            <p class="username"></p>
              <p class="postTime"></p>
              </div>
        </div>
      </div>
      <div class="postBody">
        <p></p>
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


</body>
</html>
