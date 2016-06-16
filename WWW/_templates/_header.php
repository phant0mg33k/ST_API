<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Template Partial for the Top of the site
 * Provides basic structure for building out additional pages.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglass Brandstetter
 *
 ***********/

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Service Trade API Prototype</title>

  <link rel="stylesheet" href="./css/style.css">
<?php
  if ( isset($vars['CSS_LINKS']) )
  {
    foreach ( $vars['CSS_LINKS'] as $CSS_LINK )
    {
      echo '<link rel="stylesheet" href="./css/'.$CSS_LINK.'.css">';  
    }
  }
?>

  <script type="text/javascript" src="./js/jquery.js"></script>
  <script type="text/javascript" src="./js/bootstrap.js"></script>

</head>
<body>
