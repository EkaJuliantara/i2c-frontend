$(document).ready(function() {
  $('.flexslider').flexslider({
    animation: "slide"
  });

  $(".flexslider").hover(function(){
    $(".flexslider").flexslider("pause");
  },function(){
    $(".flexslider").flexslider("play");
  });

  $(window).scroll(function(){
    var shrinkOn=$("#header").height(),paddingAdd=$("#header").height();
    if($(window).scrollTop()>shrinkOn+12)
    {
      $("#menu").css({'position':'fixed'});
      $("#theme").css({'margin-top':paddingAdd+'px'});
      $("#form-header").css({'margin-top':paddingAdd+'px'});
    }
    else
    {
      $("#menu").css({'position':'static'});
      $("#theme").css({'margin-top':'0px'});
      $("#form-header").css({'margin-top':'0px'});
    }
  });

  $("#ide-bisnis").click(function(){
    $("div#ide-bisnis").css({'display':'block'});
  });
  $("#atma-trailer").click(function(){
    $("div#atma-trailer").css({'display':'block'});
  });
  $("#registration-form").click(function(){
    $("div#registration-form").css({'display':'block'});
  });

  $( "body" ).keydown(function(e) {
      if(e.which == 27)
      {
        $(".pop-up").css({'display':'none'});
      }
  });

  $(".fancy-img").fancybox({
    'transitionIn' : 'elastic',
    'transitionOut' : 'elastic',
    'speedIn' : 600,
    'speedOut' : 200,
    'overlayShow' : false
  });


  window.sr = ScrollReveal().reveal('#theme .container,#about .container,#category .container,#rule .container,#winner .container,#timeline,#registration .container,#footer .container,.section-title,.content-title,#form',{ reset: true });

  $('a[href^="#"]').on('click',function (e) {
	    e.preventDefault();
	    var target = this.hash,
	    $target = $(target);
      var scrollAmount = $target.offset().top - $("#header").height() + 16;
      if(target == "#timeline")
      {
        scrollAmount-=64;
      }
	    $('html, body').stop().animate({
	        scrollTop: scrollAmount
	    }, 900);
	});

  $("#dropdown").on('click',function(){
    $("ul.dropdown-list").slideToggle();
  });


  /*
  $("input:radio").change(function(){
    if($("input.radio-category[value='Ide Bisnis']").is(':checked')){
      $(".atma-trailer-member").css({'display':'none'});
      $(".ide-bisnis-member").css({'display':'block'});
    }
    if($("input.radio-category[value='Atma Trailer']").is(':checked')){
      $(".atma-trailer-member").css({'display':'block'});
      $(".ide-bisnis-member").css({'display':'none'});
    }
  });

  var count = [1,1];
  $("button.add-member").click(function(){
    if($("input.radio-category[value='Ide Bisnis']").is(':checked')){
      if(count[0] < 5){
        var row = "<tr><td><input type='text' name='npm' value=''></td><td><input type='text' name='name' value=''></td><td><input type='text' name='phone' value=''></td><td><button type='button' name='button' class='delete-member'>Hapus</button></td></tr>";
        $(".ide-bisnis-member").append(row);
        count[0]++;
      }
    }
    if($("input.radio-category[value='Atma Trailer']").is(':checked')){
      if(count[1] < 5){
        var row = "<tr><td><input type='text' name='npm' value=''></td><td><input type='text' name='name' value=''></td><td><input type='text' name='phone' value=''></td><td><button type='button' name='button' class='delete-member'>Hapus</button></td></tr>";
        $(".atma-trailer-member").append(row);
        count[1]++;
      }
    }
  });

  $(document).on('click','button.delete-member',function(){
    if($("input.radio-category[value='Ide Bisnis']").is(':checked')){
      if(count[0] > 1){
        $(this).closest('tr').remove();
        count[0]--;
      }
    }
    if($("input.radio-category[value='Atma Trailer']").is(':checked')){
      if(count[1] > 1){
        $(this).closest('tr').remove();
        count[1]--;
      }
    }
  });
  */
});
