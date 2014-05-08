<?php get_header() ?>

	<div id="container">
		<div id="content">

<?php the_post() ?>

			<h2 class="page-title author"><?php printf( __( 'Author Archives: <span class="vcard">%s</span>', 'sandbox' ), "<a class='url fn n' href='$authordata->user_url' title='$authordata->display_name' rel='me'>$authordata->display_name</a>" ) ?></h2>
			<?php $authordesc = $authordata->user_description; if ( !empty($authordesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $authordesc . '</div>' ); ?>

			

<?php rewind_posts() ?>

<?php while ( have_posts() ) : the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
				<h3 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf( __( 'Permalink to %s', 'sandbox' ), the_title_attribute('echo=0') ) ?>" rel="bookmark"><?php the_title() ?></a></h3>
				<?php sandbox_titlemeta(); ?>
				<div class="entry-content">
<?php the_excerpt(__( 'Read More <span class="meta-nav">&raquo;</span>', 'sandbox' )) ?>

				</div>
				<?php sandbox_postmeta(); ?>
			</div><!-- .post -->

<?php endwhile ?>

			

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>