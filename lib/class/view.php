<?php
	defined( 'PHP_EXT' ) || exit();

	class ExceptionView extends Exception {}

	class View
	{
		private $p_lib = 'lib/',
				$p_pages = 'pages/',
				$file_by_def = 'index',
				$to_end = false,
				$page = NULL,
				$page_ = NULL,
				$init = false,
				$fullpage = false;
		public static $vars;
		public function helper($key = ':all')
		{
			if( $key == ':all' )
			{
				require_once $this->p_lib . 'helpers/all' . PHP_EXT;
			}
		}
		public function parse($str)
		{
			$from = addBracket( array_keys( $this->vars ) );
			$to = array_values( $this->vars );
			return str_replace( $from, $to, $str );
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
		public function __construct()
		{
			return $this->init();
		}
		private function __toURI($page)
		{
			return $this->p_pages . $page . PHP_EXT;
		}
		private function init()
		{
			if( !$this->init )
			{
				$this->init = true;
				$page = isset( $_GET['page'] )?str_replace( array( '/', '\\', '..', ), '', $_GET['page'] ):$this->file_by_def;
				if( ( substr( $page, 0, 5 ) == 'admin' && !check_auth( $_SESSION, LEVEL_ADMIN ) )
				 || ( substr( $page, 0, 3 ) == 'mod' && !check_auth( $_SESSION, LEVEL_MODERATOR ) )
				 || ( substr( $page, 0, 4 ) == 'auth' && !check_auth( $_SESSION, LEVEL_REDACTOR ) )
				 || ( $page[0] == '_' && $page != '_no_auth' ) )
				{
					$this->no_auth();
				}
				$this->page = ucfirst( strtolower( $page ) );
				$this->page_ = $this->__toURI( $page );
				$this->vars = array(
						'page' => $this->page,
						'page_' => $this->page_,
					);
			}
		}
		private function __clone() {}
		public function end()
		{
			if( $this->to_end )
			{
				$this->to_end = false;
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
		public function no_auth()
		{
			$this->no_auth = true;
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
			if( $this->no_auth )
			{
				$this->page_ = $this->__toURI( '_no_auth' );
			}
			require_once $this->page_;
			echo '
			</div>';
		}
		public function show_no_off()
		{
			$this->no_auth();
			$this->page();
			$this->skip_rest_of_page();
		}
		public function skip_rest_of_page()
		{
			$this->to_end = true;
			$this->__endOfPage();
		}
		public function fullPage()
		{
			if( !$this->fullpage )
			{
				$this->fullpage = true;
				$this->init();
				$this->head();
				$this->page();
				$this->to_end = true;
				$this->__endOfPage()
			}
		}
		private function __endOfPage()
		{
			$this->end();
			exit();
		}
	}