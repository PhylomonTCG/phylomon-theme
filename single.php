<?php get_header() ?>

	<div id="container">
		<div id="content">

	<?php the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
			<h2 class="entry-title"><?php the_title() ?> </h2>
			<?php if( in_category('cards') || in_category('diy-cards') ): 
				card($post,0,"div");		
			 else: ?>			
				
				<?php sandbox_titlemeta(); ?>
				<div class="entry-content">
<?php the_content() ?>

<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'sandbox' ) . '&after=</div>') ?>
				</div>
				<?php sandbox_postmeta(); ?>
			
			
			<?php endif; ?>
<?php edit_post_link('edit', '<p>', '</p>'); ?>
			</div><!-- .post -->

<?php comments_template() ?> 

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>