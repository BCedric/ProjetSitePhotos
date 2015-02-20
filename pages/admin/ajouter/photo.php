<?php

	if(isset($_POST['quoi'])){
		$bdd=ouverture();
		$galerie = $bdd->query('SELECT nom FROM galeries');
						
			echo '<form method="post" action="admin.php?page=admin&amp;faire='.$_GET['faire'].'&amp;quoi='.$_POST['quoi'].'" enctype="multipart/form-data">
					<p>
						<label for="ou">Où ça ?</label><br/>
						<select name="ou" id="ou">';
							while ($donnees = $galerie->fetch()){
								echo '<option value="'.$donnees['nom'].'">'.$donnees['nom'].'</option>';
							}
							echo '</select><br/>
								
								<label for="avatar">Fichier(2Mo Max)</label><br/>
								<input type="file" name="avatar"><br/>
								<input type="submit" value="Ok" >
					</p>
			</form>';
			
			
		$galerie->closeCursor();
	}
	
	
	if(isset($_FILES['avatar'])){ 	
		$extensions = array('.png', '.gif', '.jpg', '.jpeg','.JPG', '.JPEG');

		$extension = strrchr($_FILES['avatar']['name'], '.');
		$dossier = 'upload/';
		$fichier = basename($_FILES['avatar']['name']);
		$taille_maxi = 10000000;
		$taille = filesize($_FILES['avatar']['tmp_name']);
		$fichier = strtr($fichier,
		 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
		 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
		$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
		
		
		if($taille>$taille_maxi){
		 $erreur = 'Le fichier est trop gros...';
		}
		
		if(!in_array($extension, $extensions)){
			$erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
		}
		
		if(isset($erreur)){
			echo $erreur;
		}
		else{
			$bdd=ouverture();
					/*
					$req=$bdd->prepare('INSERT INTO galeries VALUES(:Nom, :Album, :Nb_photos)');
					$req->execute(array(
								'Nom'=>$_POST['titre'],
								'Album'=>$_POST['ou'],
								'Nb_photos'=>$_POST['nbphotos']
							));
					$req->closeCursor(); 
					
					*/
					
			$req=$bdd->prepare('SELECT Album FROM galeries WHERE LOWER(Nom)=LOWER(:Nom)') or die(print_r($bdd->errorInfo()));
			$req->execute(array('Nom'=>$_POST['ou']));							
			while ($donnees = $req->fetch()){
				
				//echo  var_dump($_FILES);
				//echo is_writable("../../albums/".$donnees['Album']."/".$_POST['ou']."/images");
				if(move_uploaded_file($_FILES['avatar']['tmp_name'], "../../albums/".$donnees['Album']."/".$_POST['ou']."/images/".$_FILES['avatar']['name'])) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
				{
				
						//Ajout BDD
						$req=$bdd->prepare('INSERT INTO photos VALUES(:Nom, :Album, :Galerie, NOW())');
						$req->execute(array(
							'Nom'=>$_FILES['avatar']['name'],
							'Album'=>$donnees['Album'],
							'Galerie'=>$_POST['ou']
						));
						
						//Ajout fichier XML de la galerie
						$document = simplexml_load_file("../../albums/".$donnees['Album']."/".$_POST['ou']."/gallery.xml"); 
						$document->addChild("image");
						foreach($document->image as $image){
						}
						$image->addAttribute("imageURL","images/".$_FILES['avatar']['name'] );
						$image->addAttribute("thumbURL","images/".$_FILES['avatar']['name'] );
						$image->addAttribute("linkURL","images/".$_FILES['avatar']['name'] );
						$image->addAttribute("linkTarget","_blank");
						$image->addChild("caption");
						file_put_contents("../../albums/".$donnees['Album']."/".$_POST['ou']."/gallery.xml", $document->asxml());
						
						//Ajout dans le fichier XML de la galerie "photos"
						$document=simplexml_load_file("../../albums/photos/gallery.xml");
						$document->addChild("image");
						foreach($document->image as $image){
						}
						$image->addAttribute("imageURL","../".$donnees['Album']."/".$_POST['ou']."/images/".$_FILES['avatar']['name'] );
						$image->addAttribute("thumbURL","../".$donnees['Album']."/".$_POST['ou']."/images/".$_FILES['avatar']['name'] );
						$image->addAttribute("linkURL","../".$donnees['Album']."/".$_POST['ou']."/images/".$_FILES['avatar']['name'] );
						$image->addAttribute("linkTarget","_blank");
						$image->addChild("caption");
						file_put_contents("../../albums/photos/gallery.xml", $document->asxml());
						
						// nb_photos + 1 dans la BDD
						$photo=$bdd->prepare('SELECT Nb_photos FROM galeries WHERE Nom=:nom') or die(print_r($bdd->errorInfo()));
						$photo->execute(array('nom'=>$_POST['ou'])) 	;
						while($nombre=$photo->fetch()){
							$nb=$nombre['Nb_photos'];
						}
						$photo=$bdd->prepare('UPDATE galeries SET Nb_photos=:nb WHERE nom=:nom') or die(print_r($bdd->errorInfo()));
						$photo->execute(array('nb'=>($nb+1),
											'nom'=>$_POST['ou']));
						
						
						echo 'Upload effectué avec succès !';
				}
					
				 
			
			
				else //Sinon (la fonction renvoie FALSE).
				{
					echo 'Echec de l\'upload !';
				}
			}
			$req->closeCursor();
		}
	}
	
	if(isset($_GET['quoi'])){
				
	}
?>