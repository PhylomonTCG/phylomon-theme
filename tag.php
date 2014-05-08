<?php get_header() ?>

	<div id="container">
		<div id="content" class="cards">

			<h2 class="page-title"><?php _e( 'Tag:', 'sandbox' ) ?> <span><?php single_tag_title() ?></span></h2>
                     
            <div class="tag-description">
				<?php echo term_description( '', get_query_var( 'tag' ) ); ?>
			</div><!-- .tag-description -->
            
            <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>

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