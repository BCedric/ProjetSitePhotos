<div id="galerie">
	<?php
		if(isset($_GET['photos'])){
			echo '<object data="albums/'.$_GET['galerie'].'/'.$_GET['photos'].'/index.html" type="text/html"></object>';
		}	
	
	?>
</div>

<div id="switch">
	<ul>
	<?php
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=site', 'root', '');
		}
		catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
		}
		
		$req=$bdd->prepare('SELECT Nom FROM galeries WHERE  LOWER(Album)=LOWER(:Album)')or die(print_r($bdd->errorInfo()));
		$req->execute(array('Album'=>$_GET['galerie']));
		while ($donnees = $req->fetch()){
			
			echo '<li>
				
				<a href="index.php?page='.$_GET['page'].'&amp;galerie='.$_GET['galerie'].'&amp;photos='.$donnees['Nom'].'">'.$donnees['Nom'].'</a>
				
			</li>';
		}
		$req->CloseCursor()
	?>
	</ul>
</div>