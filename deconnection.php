<?php
	include('haut.php');
	echo '<script type="text/javascript">window.location=\'/\'</script>';
	session_unset();
	session_destroy();
	include('bas.php');
?>