<?php get_header() ?>
	<div id="container">
		<div id="content">	

<?php 

	/* Exculde Cards and DIY-Cards from the blog */
	$cards_id = get_category_by_slug('cards')->term_id;					// Get the id for the card category
	$diy_cards_id = get_category_by_slug('diy-cards')->term_id;			// Get the id for the diy-cards category
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;		// Get the current page we are on
	$new_query_string = array(
    'category__not_in' => array($cards_id,$diy_cards_id),  				// Category ID's to exclude
	'posts_per_page' => 3, 												// Posts per page to display
	'paged' => $paged													// Make it work with pagination
	);
	$query_string = array_merge( $wp_query->query, $new_query_string ); // Combine it with the current query string
    query_posts($query_string); 										// Put it all together for grabbing the posts

	
    query_posts($query_string); // Requested variables
	while ( have_posts() ) : the_post();
	?>
			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
				<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'sandbox'), the_title_attribute('echo=0') ) ?>" rel="bookmark"><?php the_title() ?></a></h2>
				<?php sandbox_titlemeta(); ?>
				<div class="entry-content">
					<?php the_content( __( 'Read More <span class="meta-nav">&raquo;</span>', 'sandbox' ) ) ?>
					<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'sandbox' ) . '&after=</div>') ?>
				</div>
				<?php sandbox_postmeta(); ?>
			</div><!-- .post -->
			<?php wp_link_pages(); ?>
			
<?php comments_template()?>
<?php endwhile; ?>

<?php //wp_reset_query(); ?>
			
		<?php wp_link_pages( $args ); ?> 
		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php 
/* Custom pagenavi becaue we are exculding Cards and DIY-Cards from the blog */
$my_query = new WP_Query( $new_query_string );
wp_pagenavi( array( 'query' => $my_query) ); // Use PageNavi 
wp_reset_query();
?>
<?php get_footer() ?>