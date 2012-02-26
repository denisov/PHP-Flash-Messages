<?php
/**
 * Session-Based Flash Messages
 * Stores messages in Session data to be easily retrieved later on.
 * 
 * @author Andrey Denisov
 * 
 * Based on 2011 Mike Everhart | MikeEverhart.net
 * https://github.com/plasticbrain/PHP-Flash-Messages
 * 
 * This class includes four different types of messages:
 *  - Success
 *  - Error
 *  - Warning
 *  - Information
 * 
 * See README for basic usage instructions, or see samples/index.php for more advanced samples
 * 
 */


require_once dirname(__FILE__) . '/flashmessageswriter.php';

class FlashMessages {
	
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

	public function __construct() {	
		
		// Create the session array if it doesnt already exist
		if( !array_key_exists('flash_messages', $_SESSION) ) $_SESSION['flash_messages'] = array();
		
		// Delegate output functions to external class 
		$this->writer = new FlashMessagesWriter($this);
	}
	
	/**
	 * Adds a new message to the session data
	 * @param int $type type of message: FlashMessages::INFO,  FlashMessages::WARNING, etc
	 * @param string $message Text for the flash message
	 */
	public function add($type, $message) {
		
		if( !isset($_SESSION['flash_messages']) ) throw new Exception('$_SESSION[\'flash_messages\'] is not set');
		
		if( !isset($type) ) throw new Exception("'Type' is not set");
		
		if ( empty($message)) throw new Exception('message is empty');
		
		// Make sure it's a valid message type
		if( !in_array($type, $this->valid_types) )	throw new Exception('"' . $type . '" is not a valid message type!' );
		
		// If the session array for the message type doesn't exist, create it
		if( !array_key_exists( $type, $_SESSION['flash_messages'] ) ) $_SESSION['flash_messages'][$type] = array();
		
		$_SESSION['flash_messages'][$type][] = $message;
		
		return true;		
	}
	
	
	/**
	 * print flash messages
	 * @param int $type type of message: FlashMessages::INFO,  FlashMessages::WARNING, etc. If NULL given then all types of messages are used
	 * @param bool $print  When this parameter is set to TRUE, it will print the messages. Otherwise, it will return messages.
	 * @return type 
	 */
	public function display($type = null, $print = true) {
		return $this->writer->display($type, $print);
	}
	
	
	/**
	 * Checks to see if there are any queued error messages
	 * @return bool
	 */
	public function hasErrors()
	{
		if (empty($_SESSION['flash_messages'][self::ERROR]))
			return false;
		else
			return true;
	}

	
	/**
	 * Checks to see if there are queued messages
	 * @param int $type type of message: FlashMessages::INFO,  FlashMessages::WARNING, etc. If NULL given then all types of messages are used
	 */
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
	
	/*
	 * Returns messages of certain type.
	 * @param int $type type of message: FlashMessages::INFO,  FlashMessages::WARNING, etc. If NULL given then all types of messages are used
	 */
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
		
	/**
	 * Deletes all the queued messages in the session data
	 * @param int $type type of message: FlashMessages::INFO,  FlashMessages::WARNING, etc. If NULL given then all types of messages are used
	 * @return boolean 
	 */
	public function clear($type=null) { 
		if( is_null($type) ) {
			$_SESSION['flash_messages'] = array(); 
		} else {
			$_SESSION['flash_messages'][$type] = array();
		}
		return true;
	}
	

}
