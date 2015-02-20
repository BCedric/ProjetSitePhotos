<?php

if(isset($_POST['quoi'])){
	
	$bdd=ouverture();
	
	$galerie = $bdd->query('SELECT Nom FROM galeries');
	echo '<form method="post" action="admin.php?page=admin&amp;faire='.$_GET['faire'].'&amp;quoi='.$_POST['quoi'].'">
			<label for="ou">A quelle galerie appartient la photo ?</label><br/>
			<select name="ou" id="ou">';
							while ($donnees = $galerie->fetch()){
								echo '<option value="'.$donnees['Nom'].'">'.$donnees['Nom'].'</option>';
							}
					echo '<input type="submit" value="Ok" />';
	$galerie->closeCursor();
					
}

if(isset($_GET['quoi']) && isset($_POST['ou'])){

	$bdd=ouverture();
	
	$photos = $bdd->prepare('SELECT nom from photos WHERE galerie =:Galerie');
	$photos->execute(array('Galerie'=>$_POST['ou']));
	echo '<form method="post" action="admin.php?page=admin&amp;faire='.$_GET['faire'].'&amp;quoi='.$_GET['quoi'].'&amp;ou='.$_POST['ou'].'">
			<label for="photo">Quelle photo voulez vous supprimer ?</label><br/>
			<select name="photo" id="ou">';
							while ($donnees = $photos->fetch()){
								echo '<option value="'.$donnees['nom'].'">'.$donnees['nom'].'</option>';
							}
					echo '<input type="submit" value="Ok" />';
	$photos->closeCursor();
}

if(isset($_GET['quoi']) && isset($_GET['ou'])){
	$bdd=ouverture();
	
	//Recherche de l'album qui contient la galerie dans laquelle figure la photo
	$album=$bdd->prepare('SELECT Album from galeries WHERE Nom =:nom');
	$album->execute(array('nom'=>$_GET['ou']));
	while($donnee=$album->fetch()){
		$dossier=$donnee['Album'];
	}
	var_dump($album->fetch());
	//Suppression dans le fichier XML de la galerie
	$galerie=simplexml_load_file("../../albums/".$dossier."/".$_GET['ou']."/gallery.xml");
	$i = 0;
	foreach($galerie->image as $image){
		if($image['imageURL']=='images/'.$_POST['photo']){
			unset($galerie->image[$i]);
			break;
		}
		$i++;
	
	}
	file_put_contents("../../albums/".$dossier."/".$_GET['ou']."/gallery.xml", $galerie->asxml());
	
	//Suppression dans le fichier XML de la galerie "photos"
	$galerie=simplexml_load_file("../../albums/photos/gallery.xml");
	$i = 0;
	foreach($galerie->image as $image){
		if($image['imageURL']=='../'.$dossier.'/'.$_GET['ou'].'/images/'.$_POST['photo']){
			unset($galerie->image[$i]);
			break;
		}
		$i++;
	
	}
	file_put_contents("../../albums/photos/gallery.xml", $galerie->asxml());
	
	//Suppression dans la BDD
	$photo=$bdd->prepare('DELETE FROM photos WHERE nom = :nom');
	$photo->execute(array('nom'=>$_POST['photo']));
	unlink("../../albums/".$dossier."/".$_GET['ou']."/images/".$_POST['photo']);
	
	// nb_photos -1 dans la BDD
	$photo=$bdd->prepare('SELECT Nb_photos FROM galeries WHERE Nom=:nom') or die(print_r($bdd->errorInfo()));
	$photo->execute(array('nom'=>$_GET['ou'])) 	;
	while($donnee=$photo->fetch()){
		$nb=$donnee['Nb_photos'];
	}
	$photo=$bdd->prepare('UPDATE galeries SET Nb_photos=:nb WHERE nom=:nom') or die(print_r($bdd->errorInfo()));
	$photo->execute(array('nb'=>($nb-1),
						'nom'=>$_GET['ou']));
	
	echo 'Suppression effectuée';
	
	
	
}

?>

