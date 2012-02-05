<?php

require_once dirname(__FILE__) . '/../flashmessages.php';

/**
 * Test class for FlashMessages.
 * Generated by PHPUnit on 2012-02-02 at 20:41:18.
 */
class FlashMessagesTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var FlashMessages
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->object = new FlashMessages;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {
		
	}

	/**
	 * @covers {className}::{origMethodName}
	 * @todo Implement testAdd().	 
	 */
	public function testAdd() {		
		$this->object->add(FlashMessages::ERROR, 'Test error');		
		$this->assertEquals('Test error', $_SESSION['flash_messages'][FlashMessages::ERROR][0]);
		
		$this->object->add(FlashMessages::INFO, 'Test');		
		$this->object->add(FlashMessages::WARNING, 'Test');		
		$this->object->add(FlashMessages::SUCCESS, 'Test');		
		$this->object->add(FlashMessages::ERROR, 'Test');		
		
	}

	public function testAddException() {
		try {
			$this->object->add("eeee", 'Test error');		
		} catch(Exception $e)
		{
			return;			
		}
		$this->fail('An expected exception has not been raised.');
	}
	
	/**
	 * @covers {className}::{origMethodName}
	 * @todo Implement testDisplay().
	 */
	public function testDisplay() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers {className}::{origMethodName}
	 * @todo Implement testHasErrors().
	 */
	public function testHasErrors() {		
		$_SESSION['flash_messages'] = array();
		$this->assertFalse($this->object->hasErrors());
		$this->object->add(FlashMessages::ERROR, 'Test error');
		$this->assertTrue($this->object->hasErrors());
	}

	/**
	 * @covers {className}::{origMethodName}
	 * @todo Implement testHasMessages().
	 */
	public function testHasMessages() {
		$_SESSION['flash_messages'] = array();
		$this->assertFalse($this->object->hasMessages());
		$this->object->add(FlashMessages::ERROR, 'Test error');
		$this->assertTrue($this->object->hasMessages());
		
		$_SESSION['flash_messages'] = array();
		$this->object->add(FlashMessages::INFO, 'Test error');
		$this->assertTrue($this->object->hasMessages(FlashMessages::INFO));
		$this->assertFalse($this->object->hasMessages(FlashMessages::ERROR));		
	}

	/**
	 * @covers {className}::{origMethodName}
	 * @todo Implement testClear().
	 */
	public function testClear() {
		$_SESSION['flash_messages'] = array();
		$this->object->add(FlashMessages::ERROR, 'Test error');
		
		$this->object->clear();
		
		$this->assertTrue(isset($_SESSION['flash_messages']));
		$this->assertEquals(0, count($_SESSION['flash_messages']));
	}

	/**
	 * @covers {className}::{origMethodName}
	 * @todo Implement testClear().
	 */	
	public function testGetMessages() {
		
		$this->object->add(FlashMessages::WARNING, 'A warning message');
		
		$mF = $this->object->getMessages();
		$this->assertEquals('A warning message', $mF[FlashMessages::WARNING][0]);
		
		$mW = $this->object->getMessages(FlashMessages::WARNING);
		$this->assertEquals('A warning message', $mW[0]);
		
	}
	
}

?>
