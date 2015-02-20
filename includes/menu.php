		
		
		<ul id="menu">
			<li id="rectangle">
			<li  id="accueil"><a href="index.php?page=accueil">Accueil</a></li>
			<li  id="photos"><a href="index.php?page=photos">Photos</a></li>
			<li  id="albums">
				<a href="index.php?page=albums">Albums</a>
				<ul class="menuderoulant">
					<li id="rectangle2">
					<li id="concerts"><a href="index.php?page=albums&amp;galerie=concerts">Concerts</a></li>
					<li id="jonglerie"><a href="index.php?page=albums&amp;galerie=jonglerie">Jonglerie</a></li>
					<li id="nature"><a href="index.php?page=albums&amp;galerie=nature">Nature</a></li>
					<li id="villes"><a href="index.php?page=albums&amp;galerie=villes">Villes</a></li>
					<li id="divers"><a href="index.php?page=albums&amp;galerie=divers">Divers</a></li>
				</ul>
			</li>
			<li  id="telechargements"><a href="index.php?page=telechargements">Téléchargement</a></li>
			<li  id="contact"><a href="index.php?page=contact">Contact</a></li>
		</ul>
		
		
		<script src="includes/nav.js"></script>
			
				
		<script>
			var a=$.browser.msie;
			if($.browser.msie){
				alert("coucou");
			}
			else if($.browser.mozilla){
				navMozilla();
			}
			
			else if($.browser.webkit){
				navChrome();
			}
			
		</script>
		
		<div id="projet-12">
			<a href="pages/admin/admin.php" class="admin"></a>
		</div>
