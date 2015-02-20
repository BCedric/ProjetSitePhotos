<?php
	if(isset($_POST['quoi'])){
		$bdd=ouverture();
		$galerie = $bdd->query('SELECT nom FROM albums');
						
			echo '<form method="post" action="admin.php?page=admin&amp;faire='.$_GET['faire'].'&amp;quoi='.$_POST['quoi'].'">
					<p>
						<label for="ou">Où ça ?</label><br/>
						<select name="ou" id="ou">';
							while ($donnees = $galerie->fetch()){
								echo '<option value="'.$donnees['nom'].'">'.$donnees['nom'].'</option>';
							}
							echo '</select><br/>
								<label for="titre">Titre de la galerie</label><br/>
								<input type="text" name="titre" /><br/>
								<input type="submit" value="Ok" />
					</p>
			</form>';
		$galerie->closeCursor();
	}
	
	if(isset($_GET['quoi']) && !isset($_GET['nom'])){
				
				
				mkdir("../../albums/".$_POST['ou']."/".$_POST['titre'], 0700);
				
				echo '<form method="post" action="admin.php?page=admin&amp;faire='.$_GET['faire'].'&amp;quoi='.$_GET['quoi'].'&amp;nom='.$_POST['titre'].'&amp;album='.$_POST['ou'].'">
					Valider après l\'upload de la galerie<input type="submit" value="Ok" />';
				
	}
	
	if(isset($_GET['nom'])){
		$bdd=ouverture();
		
		//Ajout des photos à la BDD et au fichier XML de la galerie "photos"
		$pointeur=opendir('../../albums/'.$_GET['album'].'/'.$_GET['nom'].'/images');
		$i=0;
		while ($entree = readdir($pointeur)) {
			
			if ($entree != "." && $entree != "..") {
				$i=$i+1;
				
				//Ajout à la BDD
				$req=$bdd->prepare('INSERT INTO photos VALUES(:Nom, :Album, :Galerie, NOW())');
				$req->execute(array(
							'Nom'=>$entree,
							'Album'=>$_GET['album'],
							'Galerie'=>$_GET['nom']
						));
						
				//Ajout au fichier XML
				$document=simplexml_load_file("../../albums/photos/gallery.xml");
				$document->addChild("image");
				foreach($document->image as $image){
				}
				$image->addAttribute("imageURL","../".$_GET['album']."/".$_GET['nom']."/images/".$entree );
				$image->addAttribute("thumbURL","../".$_GET['album']."/".$_GET['nom']."/images/".$entree );
				$image->addAttribute("linkURL","../".$_GET['album']."/".$_GET['nom']."/images/".$entree );
				$image->addAttribute("linkTarget","_blank");
				$image->addChild("caption");
				file_put_contents("../../albums/photos/gallery.xml", $document->asxml());
			}
			
		}
		
		//Ajout de la galerie à la BDD
		$req=$bdd->prepare('INSERT INTO galeries VALUES(:Nom, :Album, :Nb_photos)');
		$req->execute(array(
					'Nom'=>$_GET['nom'],
					'Album'=>$_GET['album'],
					'Nb_photos'=>$i
				));
		echo 'Upload effectué avec succès !';
		$req->closeCursor();
	}
		
	
?>