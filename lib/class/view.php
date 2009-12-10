<?php
	defined( 'PHP_EXT' ) || exit();

	class ExceptionView extends Exception {}

	class View
	{
		private $p_lib = 'lib/',
				$p_pages = 'pages/',
				$file_by_def = 'index',
				$to_end = false;
		private static $instance;
		public	$page = NULL,
				$page_ = NULL,
				$vars;
		public function parse($str)
		{
			return str_replace( addBracket( array_keys( $view->vars ) ), array_values( $this->vars ), $str );
		}
		public function vars()
		{
			$args = func_get_args();
			switch( count( $args ) )
			{
				case 0:
					return $this->vars;
					break;
				case 1:
					return $this->vars[func_get_arg( 0 )];
					break;
				default:
					$this->vars[func_get_arg( 0 )] = func_get_arg( 1 );
			}
		}
		private function __construct()
		{
			require_once $this->p_lib . 'haut' . PHP_EXT;
			$page = isset( $_GET['page'] )?str_replace( array( '/', '\\', '..', ), '', $_GET['page'] ):$this->file_by_def;
			$this->page = ucfirst( strtolower( $page ) );
			$this->page_ = $this->p_pages . $page . PHP_EXT;
			$this->vars = array(
					'page' => $this->page,
					'page_' => $this->page_,
				);
		}
		private function __clone() {}
		public function end()
		{
			if( !$this->to_end )
			{ }
			else
			{
				$this->to_end = false;
				exit( '' );
				require_once $this->p_lib . 'bas' . PHP_EXT;
			}
		}
		public function __destruct()
		{
			return $this->end();
		}
		public function head()
		{
			require_once $this->p_lib . 'haut' . PHP_EXT;
		}
		public function page($file_by_def = NULL)
		{
			if( $file_by_def != NULL )
			{
				$this->file_by_def = $file_by_def;
			}
			echo '
			<div id="corps">';
			if( !file_exists( $this->page_ ) )
			{
				$this->page = $file_by_def;
			}
//			require_once 
			require_once $this->page_;
			echo '
			</div>';
		}
		public function fullPage()
		{
			$this->head();
			$this->page();
			$this->to_end = true;
			$this->end();
		}
		public static function getInstance()
		{
			if( !self::$instance instanceof self )
			{
				self::$instance = new self();
			}
			return self::$instance;
		}
	}

	function var($var)
	{
		return View::$vars[$var];
	}