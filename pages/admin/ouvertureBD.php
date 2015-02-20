<?php
	function ouverture(){
	
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=site', 'root', '');
		}
		catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
		}

		return $bdd;
	}


?>