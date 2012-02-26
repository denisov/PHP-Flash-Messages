<?php 
// A session is required for the messages to work
if( !session_id() ) session_start();

require_once('../FlashMessages.php');
$msg = new FlashMessages();


// Check for the submitted form and process it
if( isset($_POST['btn_submit']) ) {	
	$msg_text = strlen(trim(@$_POST['text'])) > 0 ? strip_tags($_POST['text']) : 'No Message Text Found!';
	$msg->add($_POST['type'][0], $msg_text);

} else {
	$msg->add(FlashMessages::ERROR, 'No error text or type found!');
}	

// Redirect back to the sample page
header('Location: index.php');
exit();
?>