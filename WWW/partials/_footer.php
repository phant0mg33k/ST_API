<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Template Partial for the Bottom of the site
 * Provides basic structure for building out additional pages.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglass Brandstetter
 *
 ***********/

// Include each string in the array $PAGE['JS'] as a <script> resources.
if ( isset($PAGE['JS']) && is_array($PAGE['JS']) ) foreach ( $PAGE['JS'] as $JS ) : ?>
  <script src='/js/<?php echo $JS; ?>.js'></script>
<?php endforeach; ?>

</body>
</html>