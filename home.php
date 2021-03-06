<?php
include 'methods.php';

comment();
like();
 ?>
<html>
<head>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
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

    <!-- Modal-->
    <div id="uploadModal" class="modal" role="dialog">
    <div class="modal-dialog" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">File Upload Form</h4>
      </div>
      <div class="modal-body">

        <!-- Form -->
        <form method='post' id="uploadForm" action='' enctype="multipart/form-data">
          Select file : <input type='file' name='file' id='file' class='form-control' ><br>
          <input type='submit' class='btn btn-info' value='Upload' id='upload'>
        </form>

        <!-- Preview-->
        <div id='preview'></div>
      </div>
    </div>
  </div>
</div>

  <div class="header">
  <h1 class="inline title">SHOUTout</h1>


<!----Santana-->

  <!--- CURRENTLY LOGGED IN AS --->
  <div class="inline loggedInAs">
    <div class="loggedinrow">
      <div class="loggedincolumn">
        <div class="profileImage">
          <!--- PROFIE GOES HERE --->
          <img src="assets/profpic.png">
        </div>
      </div>

   <!--Upload File-->
    <button type="button" class="btn btn-info" id="modalbutton" data-toggle="modal" data-target="#uploadModal">Upload file</button>
     
     
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
    <!--- character counter--Santana--->

    <form action="" method="post">
      <span class="charcounter"><input id="postInput" class="postInput inline" name="post_input" placeholder="Start typing..."></span>
      <h6 class="pull-right" id="counter">(320 characters remaining)</h6>
      <input class="inline postSubmit btn1" name="post_submit" value="Shout!" type="submit">

    </form>
    <br>
    <?php
    create_post();
    ?>
    <!--- POST VIEW --->
    <?php
      
      
    //----connecting upload with user------  
    //  $post_row = fetch_post();
    //  foreach($post_row as $s_post){
    //    $id = $s_post['id'];
    //    $likes = $s_post['likes'];
    //    $pic = $s_post['profile_pic'];
          

    ?>
      <div class="postCard" data-id="<?php echo $id; ?>">
        <div class="row">
          <div class="postcolumn">
<!--     <img style="float:left; margin-left:5%;" src="assets/<?php echo($pic) ?>.png">-->
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


        <!---Like, Comment, Delete---Santana--->

        <div class="btn-toolbar">
        <div class="btn-group">
        <form id='like_form' method='post'>
          <!-- a hidden input field to get a post variable representing our incrementing post id -->
        <input type="hidden" name="postId" value="<?php echo $id; ?>">
        <button class="addLike btn btn-default btn-sm" type="submit" id="like_submit" name="like_submit"><i class="icon-white icon-thumbs-up"></i> <?php echo($likes); ?></button>
        </form>
        <div class="btn-group">
          <?php
          $classname = "";
          if($_SESSION['user_id'] == $s_post['author_id'] || $_SESSION['role'] == 66){

              $classname = "trashcan";
              }
            ?>
            <form id="delete_form" method="post">
              <input type="hidden" name="postId" value="<?php echo $id; ?>">
              <button type="submit" style="display:none;" name="delete_button" id="delete_button" class="btn btn-inverse disabled <?php echo($classname) ?>"><i class="icon-white icon-trash"></i></button>
            </form>

        </div>
        <?php like(); ?>
        <?php delete(); ?>
        <button class="showComment btn btn-default btn-sm"><i class="icon-white icon-edit"></i></button>


      </div>
      </div>
    </div>
    <?php
      }
     ?>

  </div>

  <div class="column" id="contact_view">

  <!---search bar Santana--->
     <form action="" method="GET">
        <input id="search" type="text" name="search" placeholder="Search Users">
        <input id="submit" type="submit" value="Search">
     </form>


     <?php
          if (isset($_GET['search']))
          {
             $pdo = PDO();
              $search = '%'.$_GET['search'].'%';
              $statement = $pdo->prepare("SELECT * FROM `users` where `employee_id` like ? or `user_name` like ? ORDER BY `employee_id` ASC");
              $statement->execute([$search,$search]);
              $results = $statement->fetchAll();

              foreach ($results as $user)
              {
                  ?>

                 <!-------->



                  <!-- contact card ----->
                  <div class="contactCard">
                    <div class="cardrow">
                      <div class="cardcolumn">
                        <div class="">
                          <!--- PROFIE GOES HERE --->
                          <img class="profilePic" src="uploads/">      
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
              }

      ?>


    <?php
      /*
      $row = fetch_user();
      foreach($row as $user){
    ?>


      <!-- contact card (inactive)----->
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
      */
     ?>
  </div>

  <!--- comment div --->

  <div class="column comments_view" id="comments_view" style="display:none;">

    <!-- THESE FIELDS WORK FOR COMMENT ENTRY - Riley
    //can be cut and pasted in a modal or in the right hand VIEW
    //left the classes empty so you can style
    -->

    <div id="create_comment" style="display:none;">
      <form method="post">
      <input type="hidden" name="postId" value="<?php echo $id; ?>">
      <input name="comment_input" placeholder="Comment here"></input>
      <button name="comment_send" type="submit" value="comment">Comment</button>
      </form>
    </div>


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


</body>
</html>
