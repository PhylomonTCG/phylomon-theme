
<?php
/*
 taxonomy stuff here 
 
*/
?>
<?php get_header() ?>

	<div id="container">
		<div id="content">
			<h2 class="page-title"><span><?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->taxonomy .":</span> ".$term->name; ?></h2>
			
			<div class="taxonomy-description">
				<?php echo term_description( '', get_query_var( 'taxonomy' ) ); ?>
			</div><!-- .taxonomy-description -->
			
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
	
			<!-- <h2 class="page-title"><?php _e( 'Category Archives:', 'sandbox' ) ?> <span><?php single_cat_title() ?></span></h2>
			<?php $categorydesc = category_description(); if ( !empty($categorydesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>
			-->
			<ul class="cards">
			
			<?php if(isset($_GET['selected']))
				$posts = get_posts("include=".$_COOKIE['phylomon_cards'].'&category_name=cards');
				$count = 0;
				$card = array();
			 while ( have_posts() ) : the_post();
				card($post,$count);
				
				$count++;
				 
					
			endwhile; ?>
			</ul>
			
			<?php include(TEMPLATEPATH .'/card-list-bottom-nav.php'); ?>

		</div><!-- #content -->
	</div><!-- #container -->
	
<?php get_sidebar() ?>
<?php get_footer() ?>