<?php
//--------------------------------------------------------------------------------------------------
// Session-Based Flash Messages v1.0
// (c) 2011 Mike Everhart | MikeEverhart.net
//--------------------------------------------------------------------------------------------------
//
// Description:
//	Stores messages in Session data to be easily retrieved later on.
// This class includes four different types of messages:
//  - Success
//  - Error
//  - Warning
//  - Information
// 
//See README for basic usage instructions, or see samples/index.php for more advanced samples
//
//--------------------------------------------------------------------------------------------------
// Changelog
//--------------------------------------------------------------------------------------------------
// 
//	2011-05-15 - v1.0 - Initial Version
//
//--------------------------------------------------------------------------------------------------

require_once dirname(__FILE__) . '/flashmessageswriter.php';

class FlashMessages {
	
	//-----------------------------------------------------------------------------------------------
	// Class Variables
	//-----------------------------------------------------------------------------------------------		
	
	const INFO    = 2;
	const WARNING = 3;
	const SUCCESS = 4;
	const ERROR   = 5;
	
	private $valid_types = array(	
		self::INFO,
		self::WARNING,
		self::SUCCESS,
		self::ERROR
	);
	
	private $writer;
	
	//-----------------------------------------------------------------------------------------------
	// __construct()
	//-----------------------------------------------------------------------------------------------
	public function __construct() {	
		
		// Create the session array if it doesnt already exist
		if( !array_key_exists('flash_messages', $_SESSION) ) $_SESSION['flash_messages'] = array();
		
		$this->writer = new FlashMessagesWriter($this);
	}
	
	//-----------------------------------------------------------------------------------------------
	// add()
	// adds a new message to the session data
	//-----------------------------------------------------------------------------------------------
	public function add($type, $message) {
		
		if( !isset($_SESSION['flash_messages']) ) throw new Exception('$_SESSION[\'flash_messages\'] is not set');
		
		if( !isset($type) ) throw new Exception("'Type' is not set");
		
		if ( empty($message)) throw new Exception('message is empty');
		
		// Make sure it's a valid message type
		if( !in_array($type, $this->valid_types) )	throw new Exception('"' . $type . '" is not a valid message type!' );
		
		// If the session array doesn't exist, create it
		if( !array_key_exists( $type, $_SESSION['flash_messages'] ) ) $_SESSION['flash_messages'][$type] = array();
		
		$_SESSION['flash_messages'][$type][] = $message;
		
		return true;
		
	}
	
	//-----------------------------------------------------------------------------------------------
	// display()
	// print queued messages to the screen
	//-----------------------------------------------------------------------------------------------
	public function display($type=null, $print=true) {
		return $this->writer->display($type, $print);
	}
	
	
	//-----------------------------------------------------------------------------------------------
	// hasErrors()
	// Checks to see if there are any queued error messages
	//-----------------------------------------------------------------------------------------------
	public function hasErrors()
	{
		if (empty($_SESSION['flash_messages'][self::ERROR]))
			return false;
		else
			return true;
	}

	//-----------------------------------------------------------------------------------------------
	// hasMessages()
	// Checks to see if there are queued messages of any kind
	//-----------------------------------------------------------------------------------------------
	public function hasMessages($type = null)
	{		
		if (!is_null($type))
		{		
			if (!empty($_SESSION['flash_messages'][$type]))
				return true;
		} else
		{
			
			foreach ($this->valid_types as $type)
			{
				if (!empty($_SESSION['flash_messages']))
					return true;
			}
		}
		return false;
	}
	
	public function getMessages($type = null)
	{		
		if (!$this->hasMessages($type)) return array();
		
		if (is_null($type))
		{
			return $_SESSION['flash_messages'];
		}			
		else
		{			
			return $_SESSION['flash_messages'][$type];
		}	
	}		
	
	
	//-----------------------------------------------------------------------------------------------
	// clear()
	// deletes all the queued messages in the session data
	//-----------------------------------------------------------------------------------------------
	public function clear($type=null) { 
		if( is_null($type) ) {
			$_SESSION['flash_messages'] = array(); 
		} else {
			$_SESSION['flash_messages'][$type] = array();
		}
		return true;
	}
	

}
