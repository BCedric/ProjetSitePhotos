<?php	
	if(isset($_POST['quoi']) && !isset($_POST['photo'])){
			$bdd=ouverture();
			$galerie = $bdd->query('SELECT nom FROM photos');
							
				echo '<form method="post" action="admin.php?page=admin&amp;faire='.$_GET['faire'].'&amp;quoi='.$_POST['quoi'].'" enctype="multipart/form-data">
						<p>
							<label for="photo">Quelle photos ajouter à l\'en-tête ?</label><br/>
							<select name="photo" id="photo">';
								while ($donnees = $galerie->fetch()){
									echo '<option value="'.$donnees['nom'].'">'.$donnees['nom'].'</option>';
								}
								echo '</select><br/>
									<input type="submit" value="Ok" >
						</p>
				</form>';
				
				
			$galerie->closeCursor();
	}
	if(isset($_POST['photo'])){
	
		$bdd=ouverture();
		$req=$bdd->prepare('SELECT * FROM photos WHERE nom=:n');
		$req->execute(array('n'=>$_POST['photo']));
		$res=$req->fetch();
		
		
		
		$doc=new DOMDocument();
		$doc->load("../../includes/header.xml");
		$header=$doc->getElementsByTagName("header");
		$node=$doc->createElement("image");
		$attribut=$doc->createAttribute('link');
		$attribut->value='albums/'.$res['album'].'/'.$res['galerie'].'/images/'.$res['nom'];
		$node->appendChild($attribut);
		$header->item(0)->appendChild($node);
		$doc->save("../../includes/header.xml");
		$doc->normalizeDocument();
		
		$req->CloseCursor();
	
	}
?>