<?php
/***********
 * ServiceTrade API Integration 
 * 
 *    Login Page
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

if ( isset( $_SESSION['API_CURRENT_AUTH'] ) && $_SESSION['API_CURRENT_AUTH'] )
{
  header("location:/");
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
  if ( isset($_POST['username']) && isset($_POST['password']) )
  {
    require_once './funcs.php'; // Provides "perform_login" function
    if ( perform_login( $_POST['username'], $_POST['password'] ) )
    {
      header("location:/");
      exit;
    }
  }
}


  $vars['CSS_LINKS'] = array( 'login' );

  require_once './_templates/_header.php';
?>

<div class="container">
  <div class="well col-sm-6 col-sm-offset-3">
    <form class="form-signin" action="<?php echo htmlentities( $_SERVER['PHP_SELF'] ); ?>" method="POST" >
      <h2 class="form-signin-heading">Please sign in</h2>
      <label for="input_username" class="sr-only">Email address</label>
      <input name="username" type="text" id="input_username" class="form-control" placeholder="Username" required autofocus>
      <label for="input_password" class="sr-only">Password</label>
      <input name="password" type="password" id="input_password" class="form-control" placeholder="Password" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
  </div>
</div>

<?php
  require_once './_templates/_footer.php';
?>