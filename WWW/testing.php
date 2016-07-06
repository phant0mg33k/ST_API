<?php


require_once './php/ST_API.php'; // Require our library

SECURITY_ENSURE_AUTHENTICATED();

// Page Display Variables.
$PAGE['TITLE'] = 'Home Page';
$PAGE['CSS'] = array('bootstrap');
$PAGE['JS'] = array('jquery', 'bootstrap');

require_once './partials/_header.php';

$TimeClock = new TimeClock();
$TimeClock->get_open_clock_events();

?>

<div class="container">
	<?php var_dump( $TimeClock->RESPONSE ); ?>
</div>

<?php require_once './partials/_footer.php'; ?>