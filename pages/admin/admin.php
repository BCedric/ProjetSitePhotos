<html>
<head>
<title>projet</title>
<link rel="icon" href="../../includes/images/icon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<LINK rel="stylesheet" type="text/css" href="../../includes/menu.css">
<LINK rel="stylesheet" type="text/css" href="../../includes/header.css">
<LINK rel="stylesheet" type="text/css" href="../../includes/body.css">
<LINK rel="stylesheet" type="text/css" href="../../includes/section.css">
<LINK rel="stylesheet" type="text/css" href="admin.css">





</head>
<body>
<!-- Save for Web Slices (projet.psd) -->
<div id="content">
	<div id="projet-01">
		<img  alt="" />
	</div>
	<header>
		<?php include("../../includes/header.php");?>
	</header>
	
	
	<section>
		<div>
		<?php
			include("ouvertureBD.php");
			if(!isset($_POST['faire']) && !isset($_GET['faire']) ){
				
					
				echo '<form method="post" action="admin.php?page=admin&amp;faire=ajouter">
					<p>
						<label for="quoi">Ajouter</label><br/>
						<select name="quoi" id="quoi">
							<option value="photo">une photo</option>
							<option value="galerie">une galerie</option>
							<option value="album">un album</option>
							<option value="bandeau">une image à l\'en-tête</option>
						</select><br/>
						<input type="submit" value="Ok" />
					</p>
				</form>';
			
				echo '<form method="post" action="admin.php?page=admin&amp;faire=supprimer">
					<p>
						<label for="quoi">Supprimer</label><br/>
						<select name="quoi" id="quoi">
							<option value="photo">une photo</option>
							<option value="galerie">une galerie</option>
							<option value="album">un album</option>
							<option value="bandeau">une image de l\'en-tête</option>
						</select><br/>
						<input type="submit" value="Ok" />
					</p>
				</form>';
			}
			if(isset($_POST['faire'])){
				$faire=$_POST['faire'];
				include ("$faire/$faire.php");
			}
			if(isset($_POST['quoi']) || isset($_GET['quoi'])){			
				try{
					$bdd = new PDO('mysql:host=localhost;dbname=site', 'root', '');
				}
				catch (Exception $e){
					die('Erreur : ' . $e->getMessage());
				}
				$faire=$_GET['faire'];
				if(isset($_POST['quoi'])){
					$quoi=$_POST['quoi'];
				}
				else{
					$quoi=$_GET['quoi'];
				}
				include ("$faire/$quoi.php");
				
			}
		?>
		</div>
	</section>
		
	<nav>
		<?php include("../../includes/menu.php");?>
	</nav>
		
	</div>
	<div id="projet-13">
		
	</div>
</div>
<!-- End Save for Web Slices -->
</body>
</html>