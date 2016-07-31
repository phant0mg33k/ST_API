<?php

/*
 *      Organization:
 *        dfreshnet
 *    Authors:
 *        Matthew Jones
 *        Robin Brandt
 *        Douglas Brandstetter
 *
 *    Copyright 2016
 */

// Define the root to load all subsequent library files from.
define('__ROOT__', dirname(__FILE__));
// Define the template root to load all template partials from.
define('__T_ROOT__', dirname(dirname(__FILE__)).'/partials/');

// API Variables - Contains entries for $GLOBALS
require_once __ROOT__.'/APIVARS.php';
// API Functions - Contains helper functions to reduce most pages length. ( Aux PHP Functions )
require_once __ROOT__.'/funcs.php';


/* Data Objects */
// Base Class used to send POST and GET requests -- ABSTRACT
require_once __ROOT__.'/dataobjects/HttpRequest.php';
// Extend HttpRequest.
require_once __ROOT__.'/dataobjects/GetRequest.php';
require_once __ROOT__.'/dataobjects/PostRequest.php';
require_once __ROOT__.'/dataobjects/PutRequest.php';
require_once __ROOT__.'/dataobjects/DeleteRequest.php';

/* Executors */
// Login Class
require_once __ROOT__.'/executors/Login.php';
// Logout Class
require_once __ROOT__.'/executors/Logout.php';

// Job Handler Class
require_once __ROOT__.'/executors/Jobs.php';

// Appointment Handler Class
require_once __ROOT__.'/executors/Appointments.php';

// Asset Handler Class
require_once __ROOT__.'/executors/Assets.php';

// Timeclock Handler Class
require_once __ROOT__.'/executors/TimeClock.php';

/* Control Flow : Take any necessary actions before completing the loading of the library. */
// Start the session so no pages that require the library need to start the session.
if ( session_status() == PHP_SESSION_NONE )
  session_start();

?>