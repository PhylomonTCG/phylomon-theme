<div class="no-print">
	<p>
        <?php 
			// Direct the classification Quick Card Links to the right classification. 
			// classification or diy-classification
			$uri = explode('/' , $_SERVER['REQUEST_URI']);
			$classification = $uri[1];
			$uri = 'classification';			
			if ($classification == 'diy-classification'){
				$uri = 'diy-classification';	
			}
			 
		?>
        <b>QUICK CARD LINKS:</b> <a href="/<?php echo $uri ?>/event/">Event</a> | <a href="/<?php echo $uri ?>/mammalia/">Mammal</a> | <a href="/<?php echo $uri ?>/plantae/">Plant</a> | <a href="/<?php echo $uri ?>/aves/">Bird</a> | <a href="/<?php echo $uri ?>/cephalopoda/">Cephalopod</a> | <a href="/<?php echo $uri ?>/reptilia/">Reptile</a> | <a href="/<?php echo $uri ?>/actinopterygii/">Fish</a> | <a href="/<?php echo $uri ?>/insecta/">Insect</a> | <a href="/<?php echo $uri ?>/arachnida/">Spider</a> | <a href="/<?php echo $uri ?>/fungi/">Fungi</a> | <a href="/tag/microbe/">Microbe</a> | <a href="/<?php echo $uri ?>/starter/">Starters</a> | <a href="/<?php echo $uri ?>/habitat/">Habitat</a><br /><br />        
        <b>CARD ATTRIBUTES DESCRIPTION</b><br />
        Top Left: <a href="/glossary/#commonname">COMMON NAME</a>, <a href="/glossary/#latinname">LATIN NAME</a><br />
        Top Right: <a href="/glossary/#scale">SCALE#</a>, <a href="/glossary/#foodchain">FOODCHAIN#</a>, <a href="/glossary/#diet">DIET</a> (<font style="BACKGROUND-COLOR: yellow">photosynthetic</font> | molecular carbon | <font color="green">herbivore</font> | <font color="brown">omnivore</font> | <font color="red">carnivore</font>)<br />Middle: <a href="/glossary/#classification">CLASSIFICATION</a> (Kingdom, Phyla/Division, Class)<br />
        Middle Text: (currently blank) <a href="/glossary/#special">SPECIAL ABILITIES</a><br />
        Bottom Graphic: <a href="/glossary/#terrain">TERRAIN</a> (desert | freshwater | forest | grassland | ocean | tundra | urban)<br />
        Bottom Left: <a href="/glossary/#artistname">ARTIST NAME</a>, <a href="/glossary/#artisturl">ARTIST URL</a><br />
        Bottom Right: <a href="/glossary/#climate">CLIMATE</a> (cold | cool | warm | hot)<br /><br />
        <b>LEAVE A COMMENT ON A CARD!</b><br />
        Click on the Permalink and post a related link worth checking out, or better yet, tell us a story about the creature.  Also, do leave a comment if you have suggestions for text (data) on the card.<br /><br /><font size="-5">Wordpress <a href="/phylomon.zip">Phylomon Theme 0.5</a> by <a href="http://olt.ubc.ca/about/people/learning-technology-and-infrastructure/">OLT UBC</a> (<a href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Attribution-Noncommercial-Share Alike 3.0 Creative Commons License</a>)</font><br /><br />
	    <span style="float: right;"><font size="-5">(p.s. If you're looking for the DNA alignment game, click <a href="http://phylo.cs.mcgill.ca/eng/index.html">here</a>)</font></span>
    </p>
</div>
	