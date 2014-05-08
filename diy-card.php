<?php
/*
Template Name: DIY Card Template 
*/
?>
<?php get_header() ?>

	<div id="container">
		<div id="content" class="cards">

	<?php the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
				<h2 class="page-title"><?php if(isset($_GET['selected'])) {echo "<span>Selected:</span>";} the_title() ?></h2>
				<?php
					$temp_wp_query = $wp_query;
					$wp_query= null;
					$wp_query = new WP_Query();
					
					
					if(isset($_GET['selected'])):
						$cookie = esc_attr($_COOKIE['phylomon_cards']);
						foreach(explode(",",$cookie) as $id ):
							
							if(is_numeric($id))
								$cookie_id[] .= $id;
						endforeach;
												
						if($cookie_id):
							
							$options = array(
							'paged' => $paged,
							'post__in'  => $cookie_id,
							//'category_name' =>  "diy-cards"
							);

							$wp_query->query($options);
						else:
							$wp_query->query('category_name=diy-cards'.'&paged='.$paged);
						endif;
					else:
						$wp_query->query('category_name=diy-cards'.'&paged='.$paged);
					endif;
					$count = 0;
					
					if(function_exists('wp_pagenavi')) { wp_pagenavi(); } 
					?>
					<ul class="cards">
					<?php
					while ($wp_query->have_posts()) : $wp_query->the_post(); 
						 card($post,$count); 
						$count++;	 
					endwhile; ?>
				</ul>
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
			<?php $wp_query = null; $wp_query = $temp_wp_query;?>
			
            <?php include(TEMPLATEPATH .'/card-list-bottom-nav.php'); ?>
            
			</div><!-- .post -->


		</div><!-- #content -->
	
</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>
