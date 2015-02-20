<!DOCTYPE html>

<html>
<head>
<title>projet</title>



<?php 
		if(isset($_GET['page'])){
			
				
				include("includes/icon.php");
				echo '
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<LINK rel="stylesheet" type="text/css" href="includes/menu.css">
				<LINK rel="stylesheet" type="text/css" href="includes/header.css">
				<LINK rel="stylesheet" type="text/css" href="includes/body.css">
				<LINK rel="stylesheet" type="text/css" href="includes/section.css">
				<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
				<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
				<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>';
			switch($_GET['page']){
			
				case "accueil":
					echo '<LINK rel="stylesheet" type="text/css" href="projet.css">';
				break;
				case "photos":
					echo '<LINK rel="stylesheet" type="text/css" href="photos.css">';
				break;
				case "albums";
					if(!isset($_GET['galerie'])){
					
						echo '<LINK rel="stylesheet" type="text/css" href="albums.css">';
					}
					else{
						echo '<LINK rel="stylesheet" type="text/css" href="galerie.css">';
						
					}
				break;
				case "telechargements";
					echo '<LINK rel="stylesheet" type="text/css" href="projet.css">';
				break;
				case "contact";
					echo '<LINK rel="stylesheet" type="text/css" href="contact.css">';
				break;
				case "admin":
					echo '<LINK rel="stylesheet" type="text/css" href="projet.css">';
				break;
			}




			echo '
			</head>
			<body>

			<!-- Save for Web Slices (projet.psd) -->
			<div id="content">
				<div id="projet-01">
					<img  alt="" />
				</div>
				<header>';
					include("includes/header.php");
				echo '</header>
				
				
				<section>';
					
					
					$page=$_GET['page'];
						if(isset($page) && preg_match("/^[a-z0-9]+$/i",$page)){
							if(!isset($_GET['galerie'])){
								if($page=="photos" ||$page=="contact"){
									include ("pages/$page.php");
								}
								else{
									include ("pages/$page.html");
								}
							}
							else{
								$galerie=$_GET['galerie'];				
								include ("pages/albumsgalerie.php");
								
							}
						}
					
					
				echo '</section>
					
				<nav>';
					include("includes/menu.php");
				echo '</nav>
					
				</div>
				<div id="projet-13">
					
				</div>
			</div>
			<!-- End Save for Web Slices -->
			</body>
			</html>';
		}
		else{
			include ("pages/accueilSite.html");
		}
			

?>
