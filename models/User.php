<?php

/**
 * User
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class User extends BaseUser
{
	public function setUp()
	{
	#Relations
		$this->hasMany( T_NEWS, array(
				'local' => 'id',
				'foregin' => 'user_id',
			) );
	#Behaviors
		$this->actAs( 'Timestampable', array(
				'created' => array( 'name' => 'date_insc' ),
				'updated' => array( 'disabled' => true ),
			) );
		$this->actAs( 'SoftDelete' );
	}
	public function preInsert($event)
	{
		$invoker = $event->getInvoker();
		$this->pass = md5( $invoker->pass );
		$this->pseudo = htmlentities( $invoker->pseudo, ENT_QUOTES );
	}
}