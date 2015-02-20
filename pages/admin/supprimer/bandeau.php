<?php
	if(isset($_POST['quoi']) && !isset($_POST['photo'])){
		$doc=new DOMDocument();
		$doc->load("../../includes/header.xml");
		$images=$doc->getElementsByTagName("image");
		
		
		echo '<form method="post" action="admin.php?page=admin&amp;faire='.$_GET['faire'].'&amp;quoi='.$_POST['quoi'].'" enctype="multipart/form-data">
					<p>
						<label for="photo">Quelle photo voulez vous supprimer de l\'en-tête?</label><br/>
						<select name="photo" id="photo">';
						foreach($images as $image){
							$str=$image->getAttribute("link").'<br/>';
							$finstr=strrchr(substr($str,0,strlen($str)-2),"/");
							$str=substr($finstr,1);
							echo '<option value="'.$str.'">'.$str.'</option>';
						}
						echo '</select><br/>
								
								
						<input type="submit" value="Ok" >
					</p>
			</form>';
	}

	if(isset($_GET['quoi']) && isset($_POST['photo'])){
			echo $_POST['photo'];
			
			$doc=new DOMDocument();
			$doc->load("../../includes/header.xml");
			$images=$doc->getElementsByTagName("image");
			foreach($images as $image){
							$str=$image->getAttribute("link").'<br/>';
							$finstr=strrchr(substr($str,0,strlen($str)-2),"/");
							$str=substr($finstr,1);
							echo "coucou";
							if( strcmp($str, $_POST['photo'])==0){
								$header=$doc->getElementsByTagName("header");
								//var_dump($header->item(0));
								$header->item(0)->removeChild($image);
								$doc->save("../../includes/header.xml");
								break;
							}
							
			}
	
	}
?>