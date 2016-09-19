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
        <form class="navbar-form navbar-left" id="searchBox_Form">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Search" id="searchBox">
          </div>
        </form><!--/.navbar-form -->
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a class="btn btn-block" href="/logout.php" data-toggle="tooltip" data-placement="bottom" title="Log Out">
              <span class="visible-xs"><span class="glyphicon glyphicon-log-out"></span></span>
              <span class="hidden-xs">Logout</span>
            </a>
          </li>
          <li>
            <a class="btn btn-block" href="javascript:refreshAssets();" data-toggle="tooltip" data-placement="bottom" title="Reload List">
              <span class="visible-xs"><span class="glyphicon glyphicon-refresh"></span></span>
              <span class="hidden-xs">Reload List</span>
            </a>
          </li>
        </ul>
      </div>
    </div><!--/.container -->
  </nav><!--/.navbar -->