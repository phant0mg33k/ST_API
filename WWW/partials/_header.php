<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Template Partial for the Top of the site
 *  Provides basic structure for building out additional pages.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--/ Required For Bootstrap -->
  <title><?php echo ( isset($PAGE['TITLE']) ) ? 'Asset Inspector :: ' . htmlentities($PAGE['TITLE']): 'Asset Inspector :: Template Header'; ?></title>

  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

  <link rel="stylesheet" href="/css/bootstrap.css">
<?php
/* Stylesheet inclusion.
 * Expects an array of strings which it assumes to be names of .css files inside the /css/ folder. */
if ( isset($PAGE['CSS']) && is_array($PAGE['CSS']) )
  echo make_css_links( $PAGE['CSS'] );
?>

</head>
<body>
