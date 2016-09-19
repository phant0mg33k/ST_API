<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Template Partial for the Bottom of the site
 *  Provides basic structure for building out additional pages.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/
?>


  <script src="/js/jquery.js"></script>
  <script src="/js/bootstrap.js"></script>
  <script src="/js/bootstrap-notify.js"></script>
<?php if ( isset($PAGE['JS']) && is_array($PAGE['JS']) )
  echo make_js_links( $PAGE['JS'] );
?>

</body>
</html>