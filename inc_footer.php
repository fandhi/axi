<footer id="footer" class="wrapper">
   <div class="section_skew">
      <div class="img_bg">
         <img src="images/material/section_footer.jpg" alt="" data-stellar-ratio=".005" data-stellar-horizontal-offset="10"/>
      </div>
   </div>
   <div class="foo_inside wrapper">
      <div class="footer_social">
         <a class="fb wow pulse animated" data-wow-duration="1500ms" data-wow-iteration="infinite" href="http://<?php echo $url; ?>">Facebook</a>
         <a class="tw wow pulse animated" data-wow-duration="1600ms" data-wow-iteration="infinite" href="http://<?php echo $url; ?>">Twitter</a>
         <a class="lk wow pulse animated" data-wow-duration="1700ms" data-wow-iteration="infinite" href="http://<?php echo $url; ?>">Linkin</a>
      </div>
      <div class="text_center f_11 wow bounceIn animated">Copyright &copy; 2014 AXI. All rights reserved. Design by WEBARQ.</div>
   </div>
</footer>
</section><!-- end container -->
      <script type="text/javascript" src="js/jquery_1.7.2.js"></script>
      <script type="text/javascript" src="js/scroll/jquery_wow.min.js"></script>
      <script type="text/javascript" src="js/jquery_bootstrap.min.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
      <script type="text/javascript" src="js/jquery_cycle.all.min.js"></script>
      <script type="text/javascript" src="js/scroll/jquery_scrollReveal.js"></script>
      <script type="text/javascript">
      window.scrollReveal = new scrollReveal();
      var bs_root = "/axi/";
         new WOW().init();
      </script>
      <!-- the popup script -->
      <script type="text/javascript" src="js/jquery_fancybox.js"></script>
      <script type="text/javascript" src="js/jquery_TimeMax.js"></script>
      <!-- the jScrollPane script -->
      <script type="text/javascript" src="js/jquery_mousewheel.js"></script>
      <script type="text/javascript" src="js/jquery_jscrollpane.min.js"></script>
      
      <script type="text/javascript" src="js/jquery_owl.carousel.min.js"></script>
      <script type="text/javascript" src="js/menu/jquery_bootstrap-collapse.js"></script>
      <!-- scroll animation -->
      <script type="text/javascript" src="js/scroll/jquery_wow.min.js"></script>
      <script type="text/javascript" src="js/scroll/jquery_stellar.min.js"></script>
      <script type="text/javascript" src="js/scroll/jquery_waypoints.min.js"></script>
      <script type="text/javascript" src="js/scroll/jquery_easing.1.3.js"></script>
      <script type="text/javascript" src="js/jquery_function.js"></script>
      <script type="text/javascript" src="js/jquery_alert.js"></script>
      <script type="text/javascript" src="js/jquery_validate.js"></script>
      <script type="text/javascript" src="js/jquery_validate.additional.js"></script>
      
      <script type="text/javascript">
        $(document).ready(function(){
            $('input[type="submit"]').click(function(){$(this).parents('form').submit(); })           
            $('#contactForm').submit(function(e){
                e.preventDefault();
                jProcess('Please do not close your browser ...','Submitting');
                $.ajax({
                    url     : '<?php echo $_SERVER['REQUEST_URI']; ?>',
                    type    : 'POST',
                    data    : $(this).serialize(),
                    success : function(m)
                    {
                        m = $.parseJSON(m);
                        jAlert(m.message,m.status);
                    }
                })
                
                return false;                                
            });
            /**
            $('#contactForm').validate({
                errorPlacement : function() { },
                submitHandler  : function(f){
                    console.log('Success');
                }
            });
            **/ 
        });
      </script>
   </body>
</html>