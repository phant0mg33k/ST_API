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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--/ Required For Bootstrap -->
  <title><?php echo ( isset($PAGE['TITLE']) ) ? 'Asset Inspector :: ' . htmlentities($PAGE['TITLE']): 'Asset Inspector :: Template Header'; ?></title>

  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

<?php
/* Stylesheet inclusion.
 * Expects an array of strings which it assumes to be names of .css files inside the /css/ folder.
 */
if ( isset($PAGE['CSS']) && is_array($PAGE['CSS']) )
  foreach ( $PAGE['CSS'] as $CSS_FILE ) : ?>
  <link rel="stylesheet" href="/css/<?php echo $CSS_FILE; ?>.css">
<?php endforeach; ?>

</head>
<body>
