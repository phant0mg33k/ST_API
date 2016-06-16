<?php
/***********
 * ServiceTrade API Integration 
 * 
 *    Index Page
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglass Brandstetter
 *
 ***********/

if ( session_status() == PHP_SESSION_NONE )
{
  session_start();
}

if ( !isset($_SESSION['API_CURRENT_AUTH']) || !$_SESSION['API_CURRENT_AUTH'] )
{
  header("location:/login.php");
  exit;
}

require_once './_templates/_header.php';

?>

<div class="container-fluid">



</div>

<?php
  require_once './_templates/_footer.php';
?>