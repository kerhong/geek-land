<?php
//Ici je vais mettre toutes les fonctions qui reviennent souvent sur le site.
define('LOGINMYSQL', '64018_site');
define('PASSMYSQL','jesuislesite');
define('ADDRESSEMYSQL','hosting.zymic.com');
connectionmysql();
function connectionmysql() {
	if (!isset($connection)) {
		global $connection;
		$connection = mysql_connect(ADDRESSEMYSQL, LOGINMYSQL, PASSMYSQL);
		mysql_select_db('geek-land_zxq_membres', $connection) or die(mysql_error());
	}
}
?>