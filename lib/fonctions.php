<?php
defined( 'PHP_EXT' ) || exit();

require_once 'lib/class_bdd' . PHP_EXT;

bdd::init();

//Répète un certain nombre de fois la balise <br />
function doBR($i = 1)
{
	return str_repeat( '<br />', $i );
}
//Tranforme un array() en attributs HTML/CSS
function toHTMLAttr( $attr, $for_CSS = false )
{
	//Ce n'est pas un array ?
	if( !is_array( $attr ) )
	{
		throw new Exception( __FUNCTION__ . '(' . var_dump( $attr, true ) . ') -> first parameter must be an array' );
	}
	//[STRING]Ce que contiendra le résultat
	$formattedElem = '';
	foreach( $attr as $key => $value )
	{
		//Si la valeur n'est pas vide (ignorage forcé)
		if( $value != NULL )
		{
			$formattedElem .= ' ' . $key . ( !$for_CSS ? '="' : ': ' ) . $value . ( !$for_CSS ? '"' : ";\n" );
		}
	}
	return $formattedElem;
}

//La classe de gestion d'Exception pour les Form | Input
class InputException extends Exception { }

//La classe de formulaire
class Form
{
	/***
	 * $data		::	[ARRAY]		::	Les données du formulaire
	 * $instance	::	[OBJECT]	::	L'instance du formulaire
	 * $input		::	[ARRAY]		::	Les inputs du formulaire
	 * $is_closer	::	[BOOLEAN]	::	Le formulaire est-il clos ?
	 * $outputed	::	[BOOL|INT]	::	Le formulaire à-t-il déjà été passé par __toString() ?
	 * $boundary	::	[STRING]	::	La clef de hashage
	***/
	private $data,
		$instance,
		$input		= array(),
		$is_closed	= false,
		$outputed	= 0,
		$boundary;

	public function __construct($data = array())
	{
		$this->boundary = rand( 0, 99999 );
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
		$this->data = $data;
		$this->instance = $this;
	}
	public function __destruct()
	{
		return $this->close();
	}
	public function close()
	{
		if( !$this->is_closed )
		{
			$this->is_closed = true;
			return '</form>';
		}
	}
	public function input($data = array(), $type_ = NULL, $label = NULL, $opt = NULL )
	{
		if( $type_ == NULL )
		{
			$type_ = 'text';
		}
		$type = ucfirst( $type_ );
		if( !class_exists( $type . 'Input', false ) )
		{
			throw New InputException( 'This input type does not exists' );
		}
		$className = $type . 'Input';
		$new_input = new $className( $data, $this->instance );
		$new_input->attr( 'type', $type_ );
		$new_input->load( $opt );
		if( $label != NULL )
		{
			$new_input->label( $label );
		}
		$this->input[] = $new_input;
		return $new_input;
	}
	public function __toString()
	{
		return $this->__toString_();
	}
	public function __toString_($force = false)
	{
		if( !$force && $this->outputed < 1 )
		{
			++$this->outputed;
			$str = '<form' . toHTMLAttr( $this->data ) . '>';
			foreach( $this->input as $input )
			{
				$str .= $input;
			}
			$str .= $this->close();
			return $str;
		}
	}
}

class Input
{
	private $attr,
		$form,
		$label,
		$outputed = 0;

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
		return $this->__toString_();
	}
	public function __toString_($force = false)
	{
		if( !$force )
		{
			++$this->outputed;
			$data = '';
			if( isset( $this->attr['name'] ) && $this->label != NULL && $this->label != '' )
			{
				$data .= '<label' .toHTMLAttr( array( 'for' => $this->attr['name'] ) ) . '>
				' . $this->label . '
				</label>';
			}
			$data .= '<input';
			if( !isset( $this->attr['id'] ) && isset( $this->attr['name'] ) )
			{
				$this->attr['id'] = $this->attr['name'];
			}
			$data .= toHTMLAttr( $this->attr );
			return $data . ' />' . "\n";
		}
		else
			return '';
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
				$this->label = func_get_arg( 0 );
		}
	}
}

class TextInput extends Input { }
class SelectInput { }
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
	public function load( $opt = array())
	{
		if( !isset( $this->attr['value'] ) )
		{
			$this->attr['value'] = 'Envoyer';
		}
		if( !isset( $this->attr['name'] ) )
		{
			$this->attr['name'] = 'submit';
		}
		if( isset( $opt['autoClose'] ) && $opt['autoClose'] )
		{
			$form->close();
		}
	}
}