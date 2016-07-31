<?php

?>

  <div class="container">
    <form class="form-signin" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
      <h2 class="">Login</h2>
      <input class="form-control" type="text" name="username" required autofocus />
      <input class="form-control" type="password" name="password" required />
      <button class="btn btn-lg btn-primary btn-block">Sign In</button>
    </form><!--/.form-signin -->
  </div><!--/.container-->