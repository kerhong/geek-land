<?php
	class String
	{
		private $content = '';

		public function __construct($content)
		{
			$this->content = $content;
		}
		private function __change($str, $change = false)
		{
			if($change)
			{
				$this->content = $str;
			}
		}
		public function replace($from, $to, $change = false)
		{
			$str = str_replace( $from, $to, $this );
			$this->__change( $str, $change );
			return $str;
		}
		public function	camelCase($change = false)
		{
			$str = str_replace( ' ', '_', ucwords( $this->replace( '_', ' ' ) ) );
			$this->__change( $str, $change );
			return $str;
		}
		public function __toString()
		{
			return $this->content;
		}
		public function explode($delimiter = '_', $change = false)
		{
			$str = explode( $delimiter, $this );
			$this->__change( $str, $change );
			return $str;
		}
		public function toLower($change = false)
		{
			$str = strtolower( $this );
			$this->__change( $str, $change );
			return $str;
		}
		public function toUpper($change = false)
		{
			$str = strtoupper( $this );
			$this->__change( $str, $change );
			return $str;
		}
		public function ucwords($change = false)
		{
			$str = ucwords( $this );
			$this->__change( $str, $change );
			return $str;
		}
		public function pregReplace($pattern, $replacement, $limit = NULL, &$count = NULL, $change)
		{
			$str = preg_replace( $pattern, $replacement, $this, ( ( $limit == NULL )?-1:$limit ), $count );
			$this->__change( $str, $change );
			return $str;
		}
		public function htmlentities($quote_style = ENT_COMPAT, $charset = NULL, $double_encode = true, $change = false)
		{
			$str = htmlentities( $this, $quote_style, $charset, $double_encode );
			$this->__change( $str, $change );
			return $str;
		}
	}

$a = new String('ιθ');
echo $a->htmlentities();