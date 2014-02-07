<?php
define ("TO_NAME", "David Allen");
define ("TO_EMAIL", "trooper898@gmail.com");
define ("EMAIL_SUBJECT", "David R Allen Contact");

$success = false;

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
echo "name:" . $name . validateName($name);
echo "email:" . $email .validateEmail($email);
echo "message:" .$message . validateMessage($message);

if( validateName($name) && validateEmail($email) && validateMessage($message)){

	$to = TO_NAME . " <" . TO_EMAIL . ">";
    	$headers = "From: " . $name . " <" . $email . ">";
	$success = mail($to, EMAIL_SUBJECT, $message, $headers);
	echo "Email Sent Successfully!";

}

if( isset($_GET["ajax"])){
	echo $success ? "success" : "error";
}else{
?>
	<h1>Success!</h1>
<?php
}
	function validateName($name){
		//if it's NOT valid
		if(strlen($name) < 4)
			return false;
		//if it's valid
		else
			return true;
	}
	function validateEmail($email){
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
		return preg_match($regex, $email);
	}
	function validateMessage($message){
		//if it's NOT valid
		if(strlen($message) < 1)
			return false;
		//if it's valid
		else
			return true;
	}
?>

