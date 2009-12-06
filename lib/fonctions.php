<?php
defined( 'PHP_EXT' ) || exit();

require_once 'lib/class_bdd' . PHP_EXT;

bdd::init();

function doBR($i = 1)
{
	return str_repeat( '<br />', $i );
}
function toHTMLAttr( $attr )
{
	if( !is_array( $attr ) )
	{
		var_dump( $attr );
	}
	$formattedElem = '';
	foreach( $attr as $key => $value )
	{
		$formattedElem .= ' ' . $key . '="' . $value . '"';
	}
	return $formattedElem;
}

class InputException extends Exception { }

class Form
{
	private $data,
		$instance,
		$input = array();

	public function __construct($data = array())
	{
		if( !isset( $data['action'] ) )
		{
			$data['action'] = '#';
		}
		if( !isset( $data['method'] ) )
		{
			$data['method'] = 'POST';
		}
		else
		{
			$data['method'] = strtoupper( $data['method'] );
		}
		if( !isset( $data['size'] ) )
		{
			$data['size'] = 15;
		}
		$str = '<form' . toHTMLAttr( $data ) . '>';
		$this->data = $data;
		$this->instance = $this;
	}
	public function __destruct()
	{
		echo '</form>';
	}

	public function input($data = array(), $type = 'text')
	{
		$type = ucfirst( $type );
		if( !class_exists( $type . 'Input', false ) )
		{
			throw New InputException( 'This input type does not exists' );
		}
		$className = $type . 'Input';
		$this->input[] = new $className( $data, $this->instance );
		return $this->input[count( $this->input ) - 1];
	}
}

class Input
{
	private $data,
		$form;

	public function __construct($data = array(), $form = NULL)
	{
		if( !$form instanceof Form )
		{
			throw new InputException( 'This is not a valid form instance' );
		}
		else
		{
			$this->form = $form;
		}
		if( $data == NULL)
		{
			$data = array();
		}
		if( isset( $data['type'] ) )
		{
			unset( $data['type'] );
		}
		$this->attr = $data;
	}
	public function __toString()
	{
		$data = '<input';
		$data .= toHTMLAttr( $this->attr );
		return $data . '>' . "\n";
	}
	public function close()
	{
		$this->form->__destruct();
	}
}

class TextInput extends Input
{
	public function __construct($data = array(), $form)
	{
		parent::__construct( $data, $form );
		$this->attr['type'] = 'text';
	}
}

class PasswordInput extends Input
{
	public function __construct($data = array(), $form)
	{
		parent::__construct( $data, $form );
		$this->attr['type'] = 'password';
		if( !isset( $this->attr['value'] ) )
		{
			$this->attr['value'] = '*******';
		}
	}
}

class SubmitInput extends Input
{
	public function __construct( $data, $form )
	{
		parent::__construct( $data, $form );
		$this->attr['type'] = 'submit';
		$this->attr['value'] = 'Envoyer';
		$this->close();
	}
}
