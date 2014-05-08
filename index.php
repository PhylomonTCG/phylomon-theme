<?php get_header() ?>

	<div id="container">
		<div id="content">	

<?php while ( have_posts() ) : the_post() ?>

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
			
<?php comments_template() ?>

<?php endwhile; ?>

			
		<?php wp_link_pages( $args ); ?> 
		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>