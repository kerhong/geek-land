<?php
/*
** fichier		lib/class/class_bdd.php
** description		class de gestion de la base de donnée
** auteur		Nami-Doc :: 19/07/08
** mise à jour		Nami-Doc :: 04/07/09 :: 0.0.1
*/
/*
** propriétés:
** 	$data
** méthodes:
** 	close
** 	init
** 	fetch
** 	query
** 	secure
*/

defined( 'PHP_EXT' ) || exit();

//Tables
define( 'T_COORD', 'coordonees' );

class Bdd_Exception extends Exception {}

abstract class Bdd
{
	// contient les informations sur la connexion courante
	public static $data = array();
					//$driver;

	private $tables = array(
			'coord'		=> 'coordonees',
		);

	/*
	** déconnection de la base de donnée
	** -----
	** void
	** -----
	** return	:: true en cas de succès sinon false
	*/
	public static function close()
	{
		//return $this->driver->close() or trigger_error( $this->driver->error() )
		return mysql_close( self::$data['link'] )
			or trigger_error( mysql_error(), E_USER_ERROR );
	}

	/*
	** renvoie une ligne du résultat mysql sous la forme demandée
	** -----
	** $return	:: forme du retour (array, assoc, field, lengths, object, row)
	** $sql		:: la ressource issue de l'appel de la méthode query()
	** [...]	:: dépend de la fonction appelée (voir plus bas)
	** -----
	** return	:: le résultat de la requête
	*/
	public static function fetch()
	{
		$return = func_get_arg( 0 );
		$sql = func_get_arg( 1 );
		if ( !$sql )
		{
			return false;
		}

		$fct_list = array(
			'array', 
			'assoc',
			'field',
			'lengths',
			'object',
			'row'
		);
		if ( !in_array( $return, $fct_list ) )
		{
			$return = 'array';
		}

		// retourne une ligne de résultat mysql sous la forme d'un tableau associatif (MYSQL_ASSOC), d'un tableau indexé (MYSQL_NUM), ou les deux (MYSQL_BOTH)
		if ( $return == 'array' )
		{
			$result_type = ( func_num_args() >= 3 ) ? func_get_arg( 2 ) : MYSQL_BOTH;

			//$this->driver->fetch_array()
			return mysql_fetch_array( $sql, $result_type );
		}
		// lit une ligne de résultat mysql dans un tableau associatif
		else if ( $return == 'assoc' )
		{
			//$this->driver->fetch_assoc()
			return mysql_fetch_assoc( $sql );
		}
		// retourne les données enregistrées dans une colonne mysql sous forme d'objet
		else if ( $return == 'field' )
		{
			// la position numérique du champ
			// cf. http://fr3.php.net/manual/fr/function.mysql-fetch-field.php
			$field_offset = ( func_num_args() >= 3 ) ? func_get_arg( 2 ) : 0;

			//$this->driver->fetch_field()
			return mysql_fetch_field( $sql, $field_offset );
		}
		// retourne la taille de chaque colonne d'une ligne de résultat mysql
		else if ( $return == 'lengths' )
		{
			//$this->driver->fetch_lengths()
			return mysql_fetch_lengths( $sql );
		}
		// retourne une ligne de résultat mysql sous la forme d'un objet
		else if ( $return == 'object' )
		{
			// le nom de la class à instancier
			$class_name = ( func_num_args() >= 3 ) ? func_get_arg( 2 ) : 'stdClass';

			// un tableau contenant les paramètres à passer au contructeur de la class $class_name
			$params = ( func_num_args() >= 4 ) ? func_get_arg( 3 ) : false;

			if ( $params )
			{
			//$this->driver->fetch_object()
				return mysql_fetch_object( $sql, $class_name, $params );
			}
			else
			{
			//$this->driver->fetch_object()
				return mysql_fetch_object( $sql, $class_name );
			}
		}
		// retourne une ligne de résultat mysql sous la forme d'un tableau
		else if ( $return == 'row' )
		{
			//$this->driver->fetch_row()
			return mysql_fetch_row( $sql );
		}
	}

	/*
	** lance la connexion à la base de donnée et sélectionne la base adéquate
	** pour les deux paramètres, voir la documentation officielle: http://fr3.php.net/manual/fr/function.mysql-connect.php
	** -----
	** $newLink		:: crée une deuxième connexion
	** $clientFlags		:: paramètres de connexion
	** -----
	** return	:: void
	*/
	public static function init($newLink = false, $clientFlags = false)
	{
		self::$data = array(
			'serveur'		=> 'hosting.zymic.com',
			'utilisateur'	=> '64018_site',
			'motPasse'		=> 'jesuislesite',
			'bdd'			=> 'geek-land_zxq_membres',
			'link'			=> false,
			'bdd_link'		=> false,
			'queryNbr'		=> 0,
		);

		unset($bdd);

			//$this->driver->connect()
		if ( !( self::$data['link'] = mysql_connect( self::$data['serveur'], self::$data['utilisateur'], self::$data['motPasse'], $newLink, $clientFlags ) ) )
		{
			var_dump( self::$data['link'] );
			//$this->driver->error()
			throw new Bdd_Exception(mysql_error(), E_USER_ERROR);

			return false;
		}

			//$this->driver->select_db()
		if ( !( self::$data['bdd_link'] = mysql_select_db( self::$data['bdd'], self::$data['link'] ) ) )
		{
			//$this->driver->error()
			throw new Bdd_Exception(mysql_error(), E_USER_ERROR);
			//$this->driver->close() || .................. || $this->driver->error()
			mysql_close( self::$data['link'] )
				or trigger_error(mysql_error(), E_USER_ERROR);

			return false;
		}

		//$this->driver->set_charset()
		mysql_set_charset( 'utf8', self::$data['link'] ); //On définit l'encodage des valeurs d'échange PHP <=> SQL
	}

	/*
	** Récupère la dernière requête émise avec la connexion courante
	** -----
	** void
	** -----
	** return		:: la requête
	*/
	public static function getLastQuery()
	{
		return self::$data['last_sql'];
	}

	/*
	** envoie la requête au serveur mysql
	** -----
	** $sql		:: la requête SQL à envoyer
	** -----
	** return		:: une ressource ou true en cas de succès, sinon false
	*/
	public static function query( $sql )
	{
		self::$data['last_sql'] = $sql;
			//$this->driver->query()
		if( ( $resultat = mysql_query( $sql, self::$data['link'] ) ) )
		{
			self::$data['queryNbr']++;

			return $resultat;
		}
		else
		{
			//$this->driver->error() || ............................... || $this->driver->errno()
			throw new Bdd_Exception( $sql . ' --- ' . mysql_error(), mysql_errno(), E_USER_ERROR );

			return false;
		}
	}

	/*
	** Securise une variable
	** -----
	** $var		:: La variable à échapper
	** $int		:: La variable devrait être un nombre entier ?
	** -----
	** return		:: La variable sécurisée, prête à être insérée !
	*/
	public static function secure($var, $int = false)
	{
		if ($int)
		{
			return intval( $var );
		}
		else
		{
			//$this->driver->real_escape_string()
			return mysql_real_escape_string( trim( $var ) );
		}
	}

	/*
	** Vérifie l'existence d'un champ dans une table.
	** -----
	** $table		:: La table à examiner
	** $nom		:: Le champ à vérifier.
	** -----
	** return		:: True ou false.
	*/
	public static function verifField( $table, $nom )
	{
		self::init( true );
		if( self::$data['bdd_link'] && self::$data['bdd'] && self::$data['link'] )
		{
			$result = self::query( 'SHOW COLUMNS FROM ' . $table );
			while( $row = self::fetch( 'assoc', $result ) )
			{
				if( $nom == $row['Field'] )
				{
					return true;
				}
			}
		}

		return false;
	}
}