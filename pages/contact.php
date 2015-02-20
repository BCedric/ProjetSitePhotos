<?php

$captcha=rand(0,10000);
if(!isset($_POST['pseudo'])){
	echo'
	<div>
		<form method="post" action="index.php?page=contact">
			<label for="pseudo" >Pseudo</label>
			<input type="text" name="pseudo" required/><br/>
			<a>Message</a>
			<Textarea name="msg" ROWS=20 COLS=100 required></Textarea><br/>
			<label for="captcha" >Recopier le nombre suivant : '.$captcha.'</label>
			<input type="text" name="captcha" required/><br/>
			<input type="submit" value="Envoyer" />
		</form>
	</div>';
}

if(isset($_POST['pseudo'])){
	



}

?>