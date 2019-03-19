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
      $posts.each(function()
        {
        var $this = $(this);
        var post_id = parseInt($this.data('id'));
        var $comment_button = $('.showComment',$this);

        $comment_button.on('click',function()
          {
          console.log('clicked on comment button for post id '+post_id);
          $.ajax({
            url:"api.php?action=get_comments&post_id=" + post_id,
            dataType: 'json',
            success: function(response){
              console.log(response);
            },
            error: function(response){
              console.log(response);
            }
            });
          });


        });
});
