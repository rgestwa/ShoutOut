  $(document).ready(function(){

    console.log("ready");



    // $("#showComment").click(function(){
    //
    //   console.log("click");
    //
    //   $("#comments_view").slideDown();
    //   console.log();
    //   $("#contact_view").hide();
    //   $("#gauth_start").hide();
    //   });
    //
    //   $("#show_gauth").click(function(){
    //     $("#gauth_start").slideDown();
    //     $("#comments_view").hide();
    //     $("#contact_view").hide();
    //   });

      var $posts = $('.posts .postCard');

      var $comment_template = $('#comments_view .postCard.template').clone();

      $posts.each(function()
        {
        var $this = $(this);
        var post_id = parseInt($this.data('id'));
        var $comment_button = $('.showComment',$this);
        var $like_button = $('.addLike', $this);

        $comment_button.on('click',function()
          {
          console.log('clicked on comment button for post id '+post_id);
          $.ajax({
            url:"api.php?action=get_comments&post_id=" + post_id,
            dataType: 'json',
            success: function(response){
              console.log(response);
              $('#contact_view').hide();
              var $comments_view = $('#comments_view');
              $comments_view.html('');
              $comments_view.slideDown();
              for (var i = 0 ; i < response.comments.length ; ++i)
                {
                var current = response.comments[i];
                console.log(current);
                var $comment = $comment_template.clone();
                $('.username',$comment).text('@'+current.user_name);
                $('.postBody p',$comment).text(current.body);
                $('.postTime', $comment).text(current.time);
                $comments_view.append($comment);
                }
              //$('.comments_view .postBody').html(comment);

            },
            error: function(response){
              console.log(response);
            }
            });
          });


        });
});
