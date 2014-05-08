<?php get_header() ?>

	<div id="container">
		<div id="content">

			<h2 class="page-title"><?php _e( 'Category Archives:', 'sandbox' ) ?> <span><?php single_cat_title() ?></span></h2>
			<?php $categorydesc = category_description(); if ( !empty($categorydesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>


			

<?php if(in_category("cards")): 
	$count = 0; 
	if(function_exists('wp_pagenavi')) { wp_pagenavi(); } 
	?>
	<ul class="cards">
	<?php 
	endif; 

while ( have_posts() ) : the_post() ?>
			<?php if(in_category("cards")): 
			card($post,$count);
			$count++;
			else: ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
				<h3 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf( __( 'Permalink to %s', 'sandbox' ), the_title_attribute('echo=0') ) ?>" rel="bookmark"><?php the_title() ?></a></h3>
				<?php sandbox_titlemeta(); ?>
				<div class="entry-content">
<?php the_excerpt(__( 'Read More <span class="meta-nav">&raquo;</span>', 'sandbox' )) ?>

				</div>
				<?php sandbox_postmeta(); ?>
				
				
			</div><!-- .post -->
			<?php endif; ?>
<?php endwhile; ?>
<?php if(in_category("cards")): ?>
	</ul>
<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>