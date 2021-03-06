<?php
/*
 DIY-Category Cards Template 
*/
?>
<?php get_header() ?>

	<div id="container">
		<div id="content">
			
		
	
			<h2 class="page-title"><?php single_cat_title() ?></h2>
			
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }  ?>
			<ul class="cards">
			
			<?php if(isset($_GET['selected']))
				$posts = get_posts("include=".$_COOKIE['phylomon_cards'].'&category_name=diy-cards');
				$count = 0;
				$card = array();
			 while ( have_posts() ) : the_post();
				card($post,$count);
				
				$count++;
				 
					
			endwhile; ?>
			</ul>
			
            <div class="no-print">
				<p>
        			<b>QUICK CARD LINKS:</b> <a href="/diy-classification/event/">Event</a> | <a href="/diy-classification/mammalia/">Mammal</a> | <a href="/diy-classification/plantae/">Plant</a> | <a href="/diy-classification/aves/">Bird</a> | <a href="/diy-classification/cephalopoda/">Cephalopod</a> | <a href="/diy-classification/reptilia/">Reptile</a> | <a href="/diy-classification/actinopterygii/">Fish</a> | <a href="/classification/insecta/">Insect</a> | <a href="/diy-classification/arachnida/">Spider</a> | <a href="/diy-classification/fungi/">Fungi</a> | <a href="/tag/microbe/">Microbe</a> | <a href="/diy-classification/starter/">Starters</a> | <a href="/diy-classification/habitat/">Habitat</a><br /><br /> 
 				</p>
            </div>
            <?php include(TEMPLATEPATH .'/card-list-bottom-nav.php'); ?>
            

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>