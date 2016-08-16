<?php
/***********
 * ServiceTrade API Integration 
 * 
 * 
 * Template Partial for the Navbar
 *  Provides the Menu Hambuger and a collapse menu.
 *  searchBox and logout options are also provided.
 *
 *    Authors:
 *             Matthew Jones
 *             Robin Brandt
 *             Douglas Brandstetter
 *
 ***********/
?>

  <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <form class="navbar-form navbar-left" id="searchBox_Form">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search" id="searchBox">
          </div>
        </form><!--/.navbar-form -->
        <ul class="nav navbar-nav navbar-right">
          <li><a class="btn btn-block" href="/logout.php">Logout</a></li>
        </ul>
      </div><!--/#navbar -->
    </div><!--/.container -->
  </nav><!--/.navbar -->