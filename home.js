  $(document).ready(function(){

    console.log("ready");



     // $("#showComment").click(function(){
     //
     //  console.log("click");
     //
     //
     //  console.log();
      // $("#contact_view").hide();
      // $("#gauth_start").hide();
      //});
    //
    //   $("#show_gauth").click(function(){
    //     $("#gauth_start").slideDown();
    //     $("#comments_view").hide();
    //     $("#contact_view").hide();
    //   });



//made by riley
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


      console.log('middle');



      //this is the start of character counting ---Santana
      (function($) {
    /**
	 * attaches a character counter to each textarea element in the jQuery object
	 * usage: $("#myTextArea").charCounter(max, settings);
	 */

	$.fn.charCounter = function (max, settings) {
		max = max || 100;
		settings = $.extend({
			container: "<span></span>",
			classname: "charcounter",
			format: "(%1 characters remaining)",
			pulse: true,
			delay: 0
		}, settings);
		var p, timeout;

		function count(el, container) {
			el = $(el);
			if (el.val().length > max) {
			    el.val(el.val().substring(0, max));
			    if (settings.pulse && !p) {
			    	pulse(container, true);
			    };
			};
			if (settings.delay > 0) {
				if (timeout) {
					window.clearTimeout(timeout);
				}
				timeout = window.setTimeout(function () {
					container.html(settings.format.replace(/%1/, (max - el.val().length)));
				}, settings.delay);
			} else {
				container.html(settings.format.replace(/%1/, (max - el.val().length)));
			}
		};

		function pulse(el, again) {
			if (p) {
				window.clearTimeout(p);
				p = null;
			};
			el.animate({ opacity: 0.1 }, 100, function () {
				$(this).animate({ opacity: 1.0 }, 100);
			});
			if (again) {
				p = window.setTimeout(function () { pulse(el) }, 200);
			};
		};

		return this.each(function () {
			var container;
			if (!settings.container.match(/^<.+>$/)) {
				// use existing element to hold counter message
				container = $(settings.container);
			} else {
				// append element to hold counter message (clean up old element first)
				$(this).next("." + settings.classname).remove();
				container = $(settings.container)
								.insertAfter(this)
								.addClass(settings.classname);
			}
			$(this)
				.unbind(".charCounter")
				.bind("keydown.charCounter", function () { count(this, container); })
				.bind("keypress.charCounter", function () { count(this, container); })
				.bind("keyup.charCounter", function () { count(this, container); })
				.bind("focus.charCounter", function () { count(this, container); })
				.bind("mouseover.charCounter", function () { count(this, container); })
				.bind("mouseout.charCounter", function () { count(this, container); })
				.bind("paste.charCounter", function () {
					var me = this;
					setTimeout(function () { count(me, container); }, 10);
				});
			if (this.addEventListener) {
				this.addEventListener('input', function () { count(this, container); }, false);
			};
			count(this, container);
		});
	};



    })(jQuery);

    $("#postInput").charCounter(320,{container:'#counter'});
<<<<<<< HEAD


      $('#uploadForm').on('submit',function(){

        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file',files);

        // AJAX request
        $.ajax({
          url: 'uploads.php',
          type: 'post',
          data: fd,
          contentType: false,
          processData: false,
          success: function(response){
            if(response != 0){
              // Show image preview
              $('#preview').append("<img src='"+response+"' width='100' height='100' style='display: inline-block;'>");
            }else{
              alert('file not uploaded');
            }
          }
        });
        return false;
      });


});

=======
    console.log('hello');
>>>>>>> c6efe3aa72fc76e227033f9fb9b36c10691a3562

});
