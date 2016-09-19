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
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 well">
        <h2 class="title">Login</h2>
        <form class="form-signin" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
          <input class="form-control" placeholder="Username" type="text" name="username" required autofocus />
          <input class="form-control" placeholder="Password" type="password" name="password" required />
          <button class="btn btn-primary btn-block">Sign In</button>
        </form><!--/.form-signin -->
      </div><!--/.col-->
    </div><!--/.row-->
  </div><!--/.container-->