<?php
/**
 * This class used to print flash messages. 
 * 
 * @author Andrey Denisov elgato.andrey@gmail.com
 */

class FlashMessagesWriter {
	
	private $flashmesages; 
	
	private $msgClass = 'php-flash-messages';
	private $msgWrapper = "<div class='%s %s'><a href='#' class='closeMessage'></a>\n%s</div>\n";
	private $msgBefore = '<p>';
	private $msgAfter = "</p>\n";	
	
	private $msgTypeToCSSClassMap = array(		
		FlashMessages::INFO    => 'info',
		FlashMessages::WARNING => 'warning',
		FlashMessages::SUCCESS => 'success',
		FlashMessages::ERROR   => 'error',
	);
	
	public function __construct(FlashMessages $flashmesages)
	{
		$this->flashmesages = $flashmesages;
	}
	
	public function display($type=null, $print=true) {
		$messages = '';
		$data = '';
		
		if (!$this->flashmesages->hasMessages($type)) return false;
		
		$msgArray = $this->flashmesages->getMessages($type);
		
		if ($type == null)
		{
			foreach($msgArray as $block_type => $messages)
			{
				$data .= $this->wrapMessage($messages, $block_type);
			}	
		}	
		else
		{
			$data = $this->wrapMessage($msgArray, $type);
		}	
		// Clear  viewed messages
		$this->flashmesages->clear($type);	

		
		// Print everything to the screen or return the data
		if( $print ) { 
			echo $data;
			return true;
		} else { 
			return $data; 
		}		
	}
	
	private function wrapMessage($msgArray, $type)
	{
		$messages = "";
		
		foreach($msgArray as $msg) {
			$messages .= $this->msgBefore . $msg . $this->msgAfter;	
		}
		
		$cssClass = '';		
		if (isset($this->msgTypeToCSSClassMap[$type])) $cssClass = $this->msgTypeToCSSClassMap[$type];		
		$output = sprintf($this->msgWrapper, $this->msgClass, $cssClass, $messages);		
		
		return $output;
	}		
	
}


