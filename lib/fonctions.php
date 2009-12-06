<?php
defined( 'PHP_EXT' ) || exit();

require_once 'lib/class_bdd' . PHP_EXT;

bdd::init();

//Répète un certain nombre de fois la balise <br />
function doBR($i = 1)
{
	return str_repeat( '<br />', $i );
}
//Tranforme un array() en attribut HTML
function toHTMLAttr( $attr, $for_CSS = false )
{
	if( !is_array( $attr ) )
	{
		var_dump( $attr );
	}
	$formattedElem = '';
	foreach( $attr as $key => $value )
	{
		if( $value != NULL )
		{
			$formattedElem .= ' ' . $key . ( !$for_CSS ? '="' : ': ' ) . $value . ( !$for_CSS ? '"' : ";\n" );
		}
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
		if( !isset( $data['maxlength'] ) )
		{
			$data['maxlength'] = $data['size'];
		}
		$str = '<form' . toHTMLAttr( $data ) . '>';
		$this->data = $data;
		$this->instance = $this;
	}
	public function __destruct()
	{
		$this->close();
	}
	public function close()
	{
		echo '</form>';
	}
	public function input($data = array(), $type_ = NULL, $label = NULL, $opt = NULL )
	{
		if( $type_ == NULL )
		{
			$type_ = 'text';
		}
		$type_ = ucfirst( $type );
		if( !class_exists( $type . 'Input', false ) )
		{
			throw New InputException( 'This input type does not exists' );
		}
		$className = $type . 'Input';
		$new_input = $this->input[]
		$new_input = new $className( $data, $this->instance );
		$new_input->attr( 'type', $type_ );
		$new_input->load( $opt );
		if( $label != NULL )
		{
			$new_input->label( $label );
		}
		return $new_input;
	}
}

class Input
{
	private $attr,
		$form,
		$label;

	public function load() {}
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
		if( !isset( $data['name'] ) )
		{
			throw new InputException( 'The name of the input must be specified' );
		}
		if( $data == NULL)
		{
			$data = array();
		}
		if( isset( $data['type'] ) )
		{
			unset( $data['type'] );
		}
		if( isset( $data['_take_from'] ) )
		{
			$data['_take_from'] = strtoupper( $data['_take_from'] );
			if( ( $data['_take_from'] == 'GET' || $data['_take_from'] == 'POST' ) &&  isset( $_{$data['_take_from']}[$data['name']] ) )
			{
				$data['value'] = $_{$data['_take_from']}[$data['name']];
			}
			unset( $data['_take_from'] );
		}
		$this->attr = $data;
	}
	public function __toString()
	{
		$data = '<label' .toHTMLAttr( array( 'for' => $this->attr['name'] ) ) . '>
		' . $this->label . '
		</label><input';
		if( !isset( $this->attr['id'] ) )
		{
			$this->attr['id'] = $this->attr['name'];
		}
		$data .= toHTMLAttr( $this->attr );
		return $data . ' />' . "\n";
	}
	public function close()
	{
		$this->form->__destruct();
	}
	public function attr()
	{
		switch( func_num_args() )
		{
			//On veut tout récupérer
			case 0:
				return $this->attr;
				break;
			//On veut récupérer une clef
			case 1:
				return $this->attr[func_get_arg( 0 )];
				break;
			default:
				$this->attr[func_get_arg( 0 )] = func_get_arg( 1 );
		}
	}
	public function label()
	{
		switch( func_num_args() )
		{
			//On veut tout récupérer
			case 0:
				return $this->label;
				break;
			//On veut récupérer une clef
			case 1:
				$this->label = func_get_arg( 1 );
		}
	}
}

class TextInput extends Input
{
}

class SelectInput
{
}

class PasswordInput extends Input
{
	public function load()
	{
		if( !isset( $this->attr['value'] ) )
		{
			$this->attr['value'] = '*******';
		}
	}
}

class SubmitInput extends Input
{
	public function load( $opt )
	{
		$this->attr['value'] = 'Envoyer';
		if( isset( $opt['autoClose'] ) && $opt['autoClose'] )
		{
			$form->close();
		}
	}
}