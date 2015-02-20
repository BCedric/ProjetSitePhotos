
<?php
	
	$galerie=simplexml_load_file("albums/photos/gallery.xml");
	$i=0;
	foreach($galerie->image as $image){
		$tab[$i]=$image;
		$i++;
	}
	
	shuffle($tab);
	$file=new simpleXMLElement("<simpleviewergallery useFlickr=\"false\" resizeOnImport=\"true\" cropToFit=\"false\" backgroundColor=\"000000\" thumbPosition=\"BOTTOM\" galleryStyle=\"MODERN\" thumbRows=\"1\" thumbColumns=\"5\" showOpenButton=\"false\"></simpleviewergallery>");
	
	for($i=$i-1; $i>=0; $i--){
	
		
		$newIm=$file->addChild('image');
		$newIm->addAttribute("imageURL",$tab[$i]['imageURL']);
		$newIm->addAttribute("thumbURL", $tab[$i]['thumbURL']);
		$newIm->addAttribute("linkURL", $tab[$i]['linkURL']);
		$newIm->addChild('caption');
		
	}
	
	file_put_contents("albums/photos/gallery.xml", $file->asxml());
	echo '<object data="albums/photos/index.html" type="text/html"></object>'
	
?>