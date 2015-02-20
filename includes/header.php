<div id="diapo">
	<?php
		$doc=simplexml_load_file('includes/header.xml');
		$i=1;
		$n=0;
		foreach($doc->image as $image){
			
			
			echo '<div id="img'.$i.'" style="background-image:url(\''.$image['link'].'\')"></div>';
			echo '<script>
					$(\'#img\'+'.$i.').hide();
				</script>';
			
			$i++;
			$n++;
		}
	
	
	echo'
		<script>
			  $(function() {
				var i=1;
				
				affiche();
				function affiche() {
					
					
					$(\'#img\'+i).fadeOut(\'slow\');
					if(i=='.$n.'){
						i=0;
					}
					i++;
					$(\'#img\'+i).fadeIn(\'slow\');
				};
				setInterval(affiche, 2000);
			  });
		</script>'
	?>

</div>
<div id="bandeau">
		
</div>