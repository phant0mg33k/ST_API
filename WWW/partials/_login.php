<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Template Partial for the login page.
 *  Provides a username and password box inside of a signin form.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/
?>

  <div class="container">
    <form class="form-signin" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
      <h2 class="">Login</h2>
      <input class="form-control" placeholder="Username" type="text" name="username" required autofocus />
      <input class="form-control" placeholder="Password" type="password" name="password" required />
      <button class="btn btn-primary btn-block">Sign In</button>
    </form><!--/.form-signin -->
  </div><!--/.container-->