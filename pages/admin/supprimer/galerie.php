<?php 
	function clearDir($dossier) {
	$ouverture=@opendir($dossier);
	if (!$ouverture) return;
	while($fichier=readdir($ouverture)) {
		if ($fichier == '.' || $fichier == '..') continue;
			if (is_dir($dossier."/".$fichier)) {
				$r=clearDir($dossier."/".$fichier);
				if (!$r) return false;
			}
			else {
				$r=@unlink($dossier."/".$fichier);
				if (!$r) return false;
			}
	}
closedir($ouverture);
$r=@rmdir($dossier);
if (!$r) return false;
	return true;
}
?>

<?php
	if(isset($_POST['quoi'])){
		$bdd=ouverture();
		$galerie = $bdd->query('SELECT Nom FROM galeries');
						
			echo '<form method="post" action="admin.php?page=admin&amp;faire='.$_GET['faire'].'&amp;quoi='.$_POST['quoi'].'">
					<p>
						<label for="ou">Quelle galerie supprimer ?</label><br/>
						<select name="ou" id="ou">';
							while ($donnees = $galerie->fetch()){
								echo '<option value="'.$donnees['Nom'].'">'.$donnees['Nom'].'</option>';
							}
					echo '<input type="submit" value="Ok" />
					</p>
			</form>';
		$galerie->closeCursor();
	}
	
	if(isset($_GET['quoi'])){
				
				$bdd=ouverture();
				
				$ou=$_POST['ou'];
				//Suppression de la galerie de la BDD
				$req=$bdd->prepare('SELECT Album FROM galeries WHERE Nom=:Nom')or die(print_r($bdd->errorInfo()));
				$req->execute(array('Nom'=>$ou));
				
				
				
		
				//suppression du dossier et des photos dans le fichier XML de la galerie "photos
				while ($donnees = $req->fetch()){
					$pointeur=opendir('../../albums/'.$donnees['Album'].'/'.$ou.'/images');
					while ($entree = readdir($pointeur)) {
						$galerie=simplexml_load_file("../../albums/photos/gallery.xml");
						$i = 0;
						foreach($galerie->image as $image){
							if($image['imageURL']=='../'.$donnees['Album'].'/'.$ou.'/images/'.$entree){
								unset($galerie->image[$i]);
								break;
							}
							$i++;
						}
						file_put_contents("../../albums/photos/gallery.xml", $galerie->asxml());
					}
					clearDir("../../albums/".$donnees['Album']."/".$ou);
				}
				//Suppression des photos de la BDD
				$req=$bdd->prepare('DELETE FROM galeries WHERE Nom=:Nom');
				$req->execute(array('Nom'=>$ou));
				$req=$bdd->prepare('DELETE FROM photos WHERE galerie=:Nom');
				$req->execute(array('Nom'=>$ou));
				$req->closeCursor();
				echo "Suppression effectuée !";			
	}
?>

