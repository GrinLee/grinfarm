

$(function(){   
      
  $('.hbgbox').click(function() {
    $('.hbgbox,.headNav,.hbgspace').toggleClass('active');
  });


  $(".subs_email").keydown(function(e) {
    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
        $("#subs-email").submit();
    }
  });

  $("#subs-email").validate( { rules: {
          subsemail: { 
                required: true,
                email: true,
                regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
              }
        },
        messages: { subsemail: { 
                email: "email format error", 
                regex: "regex type error" }
        },
        errorPlacement: function(err, element){
            element.parent().append(err.addClass('errorMessage'));
        }
  });


  let btns=[];
  btns  = document.querySelectorAll('a[href^="javas"]');
  
  let content = "No page"; 
  let el_pop = document.createElement("div");
  el_pop.id = 'pop_unfin';
  el_pop.append(content);
  document.body.appendChild(el_pop);

  const showPopup = (e) => {

      Object.assign(el_pop.style, {
          left: `${ e.clientX + window.scrollX - 20}px`,
          top: `${ e.clientY + window.scrollY - 50}px`,
          display: `block`,
      });
      setTimeout(()=>
          Object.assign(el_pop.style, { display: `none`} ), 500);
  };

  for (let i = 0; i < btns.length; i++) {
      btns[i].addEventListener("click", showPopup);
  }

  
 /* login popup */
  let userpop = ('ontouchstart' in window) ? 'click' : 'mouseover';
               
  $('.headNav ul li #user').on(userpop, function(){   
      const toggleDrop = document.querySelector(".dropAccount");
      toggleDrop.classList.toggle("active"); 
      $('.overlay-acc').addClass('open-acc'); 
  });




  $('.overlay-acc').click(function(e) {
    if (!$('.dropAccount').is(e.target) && $('.dropAccount').has(e.target).length === 0) {
        $('.dropAccount').removeClass('active');
        $('.overlay-acc').removeClass('open-acc');
    }
  });
  
  
                /* main banner slide */
  $('main').each(function() {         
  
      let $bann    = $(this),
          $movable = $(".movable", $bann), 
          $slides  = $(">*", $movable),     // <div class="sl_cont">
          num      = $slides.length,
          one      = 1,
          mov      = one,
          intv     = null;
  
      function play() { intv = setInterval(anima, 5000); }
      function stop() { clearInterval(intv); }
  
      function anima() {
        mov += one;
        if (mov > num-2 || mov < 1) { one *= -1; }
          $movable.css({transform: "translateX(-"+ (mov*100) +"%)"});
      }
      
      $(".prev, .next").on("click", anima);
      $bann.hover(stop, play);
      play();
  
    });
    
    /* banner title */
    $(".sl_cont.c_a").append("<aside><p>about conven-<br>tional farming</p></aside>");
    $(".sl_cont.c_b").append("<aside><p>fresh high<br>quality products</p></aside>");
    $(".sl_cont.c_c").append("<aside><p>from ontario's<br>farms</p></aside>");
    $(".sl_cont_hid").append("<aside><p>about conven-<br>tional farming</p></aside>");


    /* video popup */
    $(".slide").click(function(e){ 

      let v_attr = e.target.firstElementChild.getAttribute('src');
      let popup = $('.popup');
      let v_elm = $('<video autoplay controls loop></video>');
      let source = $('<source type="video/mp4">');
      source.attr({ src: v_attr});
      v_elm.append(source);
      popup.append(v_elm);
      $('.popup, .overlay').addClass('open');
      console.log(v_elm);
      
    });
  
  
    $('.popup-close-btn').click(function() {
      $('.popup, .overlay').removeClass('open');
      $('.popup video').remove();
    });
  
  
    $('.overlay').click(function(e) {
    if (!$('.popup').is(e.target) && $('.popup').has(e.target).length === 0) {
        $('.popup, .overlay').removeClass('open');
        $('.popup video').remove();
    }

  });
 
    /* detail thumbnail */
  var mainImg = document.getElementById("mainImg");
  var smImg = document.getElementsByClassName("small-img");
  
  for (let i = 0; i < smImg.length; i++) {
      smImg[i].addEventListener ("click", function(){
          mainImg.src = smImg[i].src;
      });
  }

});
      