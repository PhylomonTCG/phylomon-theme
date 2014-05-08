<?php
/** 
 * 
 *******/

$phylomon_version = 1;

/** 
 * Requre the include files
 *******/
require_once("inc/sandbox.php");
require_once("inc/custom-fields.php");
require_once("inc/shortcodes.php");
require_once("inc/taxonomies.php");  
require_once("inc/api.php");
require_once("img/card-image/image.php");





/** 
 * Make the ajax happen 
 **/
if ( defined( 'DOING_AJAX' ) ) {
	if ( is_user_logged_in() )
		add_action('wp_ajax_search_cards', 'search_cards_ajax');
	else
		add_action('wp_ajax_nopriv_search_cards', 'search_cards_ajax');
}

/**
 * search_cards_ajax function.
 * 
 * @access public
 * @return void
 */
function search_cards_ajax()
{
	$term = esc_attr($_GET['term']);
	$posts = query_posts("s=$term&category_name=cards&post_status=publish");
	
	foreach($posts as $post):
		
		$card['graphic']			= get_post_meta($post->ID, "_phylomon_graphic", 			true);
		if($card['graphic']):				
			$img = $card['graphic'];
		endif;
		//if($post->post_status == "published"):
		$output .= '{ 
		"id": "'.$post->ID.'", 
		"img": "'.$img.'", 
		"value": "'.$post->post_title.'" },';
		//endif;		
		unset($img);
		
	endforeach;
	echo  "[". substr($output,0,-1) . "]";
	die();
}


// change the amount of time the rss is cashed for.... 
add_filter('wp_feed_cache_transient_lifetime','phylomon_rss_cashe');
function phylomon_rss_cashe($limit)
{
	return 100;
}


add_action('init', 'phylomon_add_js'); /* adds the javascript to the theme */
function phylomon_add_js() {
	// deregister 
	if(!is_admin()):
	//wp_deregister_script('jquery');
	//wp_deregister_script('jquery-ui-core');
    //wp_enqueue_script('jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js',false,1);
    wp_enqueue_script('custom-ui',get_bloginfo('template_url').'/js/jquery-ui-custom.min.js',1);
    wp_enqueue_script('flip',get_bloginfo('template_url').'/js/jquery.flip.min.js',1);
    wp_enqueue_script('phylomon-main',get_bloginfo('template_url').'/js/main.js',1);
	wp_localize_script( 'phylomon-main', 'PhylomonSettings', array(
	  	'ajaxurl' => admin_url('admin-ajax.php'),
		));
	else:
	wp_enqueue_script('phylomon_admin',get_bloginfo('template_url').'/js/phylomon-admin.js',false,1);
	
	endif;
}    

$phylomon_page_on_front_url = 	get_page( get_option('page_on_front'));
$phylomon_siteurl		= get_option('siteurl');
add_filter("clean_url","phylomon_clean_url");
/**
 * phylomon_clean_url function.
 * 
 * this function helps with the front page and redirecting the cards page into a link to point to the proper place
 * @access public
 * @param mixed $url
 * @return void
 */
function phylomon_clean_url( $url )
{
	global $phylomon_siteurl, $phylomon_page_on_front_url;

	if( curPageURL() ==  $phylomon_siteurl."/")
	{
		if( is_numeric( strrpos( parse_url($url,PHP_URL_PATH) ,"/page/") ) )
		{ 
		$new_url = $phylomon_siteurl."/".$phylomon_page_on_front_url->post_name;
		
		return str_replace($phylomon_siteurl, $new_url, $url);
		}
		
	}
	//
	
	return $url;	
}



/**
 * card function. Generate card 
 * 
 * @access public
 * @param mixed $post
 * @param int $count. (default: 0)
 * @param string $container. (default: "li")
 * @return void
 */
function card( $post,$count=0,$container="li" )
{
	global $phylomon_version;
	$card['latin_name'] 	= get_post_meta($post->ID, "_phylomon_latin_name", 	true);
	
	// graphic 
	$card['graphic_artist']		= get_post_meta($post->ID, "_phylomon_graphic_artist", 		true);
	$card['graphic_artist_url']	= get_post_meta($post->ID, "_phylomon_graphic_artist_url", 	true);
	$card['graphic']			= get_post_meta($post->ID, "_phylomon_graphic", 			true);
		
	// Photo
	$card['photo_artist']		= get_post_meta($post->ID, "_phylomon_photo_artist", 		true);
	$card['photo_artist_url']	= get_post_meta($post->ID, "_phylomon_photo_artist_url", 	true);
	$card['photo']				= get_post_meta($post->ID, "_phylomon_photo", 				true);
	
	$card['card_color']			= get_post_meta($post->ID, "_phylomon_card_color", 				true);		
	
	
	// Food and Hierarchy
	$card['hierarchy']			= get_post_meta($post->ID, "_phylomon_hierarchy", 			true);
	$card['food']				= get_post_meta($post->ID, "_phylomon_food", 				true);
	
	// Size
	$card['size']				= get_post_meta($post->ID, "_phylomon_size", 				true);
	
	// Temperature
	$card['temperature']		= maybe_unserialize(get_post_meta($post->ID, "_phylomon_temperature", 		true));
	
	
	//if(!empty(maybe_unserialize($card['temperature']))):
	if(is_array(maybe_unserialize($card['temperature'])))
		$card['temperature']  = implode(", ",maybe_unserialize($card['temperature']));
	//endif;
		
	// Habitat 
    $card['habitat1']           = get_post_meta($post->ID, "_phylomon_habitat1",             true);
    $card['habitat2']           = get_post_meta($post->ID, "_phylomon_habitat2",             true);
    $card['habitat3']           = get_post_meta($post->ID, "_phylomon_habitat3",             true);
    
    
  	// wiki 
	$phylomon_wiki	 = get_post_meta($post->ID, "_phylomon_wiki",             true);
	// EOL
	$phylomon_eol	 = get_post_meta($post->ID, "_phylomon_eol",             true);
    
    // Background image  
	if($card['habitat1']  != "none")
	    $image[] = $card['habitat1'] ;
    
    if($card['habitat2']  != "none")
    	$image[] = $card["habitat2"];
    	
    if($card['habitat3']  != "none")
    	$image[] = $card["habitat3"];
    
    
    // check to see if the card background image exits otherwise create the image incase of exporting and importing content
	if(!file_exists(TEMPLATEPATH."/img/generated-card-images/bg-".substr($card['card_color'],1)."-".implode("-",$image)."-".$phylomon_version.".png"));
		create_image($width=250,$height=392,$card['card_color'], $image ,$phylomon_version);
        
    // Card Color 
    $card['card_color']         = get_post_meta($post->ID, "_phylomon_card_color",             true);
        
	// Card Content 
	$card['card_content']         = get_post_meta($post->ID, "_phylomon_card_content",         true);
	
	
	
	
	// Classification Taxonomy 
	$phylomon_classification_order		= get_post_meta($post->ID, "_phylomon_classification_order",             true);
     	
    $phylomon_classification_order_array = explode(",",$phylomon_classification_order);
     	
	$terms = get_the_terms( $post_id, 'classification' );
	
	
	// DIY Classification Taxonomy 
	$phylomon_diy_classification_order		= get_post_meta($post->ID, "_phylomon_diy_classification_order",             true);
     	
    $phylomon_diy_classification_order_array = explode(",",$phylomon_diy_classification_order);
     	
	$diy_terms = get_the_terms( $post_id, 'diy-classification' );
		
	
	?>
	<?php if($container == "li"): ?>
	<li class="card-container <?php  if(!$third = $count%3) {echo " third";}  ?>">
	<?php else: ?>
	<div class="card-container">
	
	<?php endif; ?>
    <div class="card count " id="card-<?php echo $post->ID; ?>" >
    		<img src="<?php bloginfo('template_url'); ?>/img/generated-card-images/<?php echo "bg-".substr($card['card_color'],1)."-".implode("-",$image)."-".$phylomon_version.".png";?>" class="card-background" alt="card-name-<?php echo $post->ID; ?>" />		
    		<h2 class="card-name <?php  class_size(strlen($post->post_title)); ?>" id="card-name-<?php echo $post->ID; ?>" ><a href="<?php the_permalink(); ?>" id="card-link-<?php echo $post->ID; ?>"><?php  the_title(); ?></a></h2>
    		<span class="latin-name"><?php echo $card['latin_name']; ?></span>
    		
    		<div class="num-values">
    		<?php if($card['size'] != "null") { ?> 
    		<img src="<?php bloginfo('stylesheet_directory'); ?>/img/num/<?php echo $card['size']; ?>.png" alt="<?php echo $card['size']; ?>" />
    		<?php } if($card['food'] != "null" || $card['hierarchy'] != "null") { ?> 
    		<img src="<?php bloginfo('stylesheet_directory'); ?>/img/num/<?php echo $card['food'].$card['hierarchy']; ?>.png" alt="<?php echo $card['food'].$card['hierarchy']; ?>" />
    		<?php } ?>
    		</div>
    		<div class="card-image">
    			
    			<?php if($card['graphic']): ?> <!-- GRAPHIC -->
    			<div class="graphic"><img src="<?php echo $card['graphic']; ?>" alt="Card Graphic" /></div>
    			<?php else: ?>
    			<div class="graphic empty">
    			<strong>Sorry, there is no graphic available.  If you have one, please submit <a href="http://www.flickr.com/groups/phylomon/">here</a>.</strong>
    			</div>
    			<?php endif; ?>
    			
    			<?php if($card['photo']): ?> <!-- PHOTO -->
    			<div class="photo"><img src="<?php echo $card["photo"]; ?>" /></div>
    			<?php else: ?>
    			<div class="photo empty">
    			<strong>Sorry, there is no photo available.  If you have one, please submit <a href="http://www.flickr.com/groups/1293102@N24/">here</a>.</strong>
    			</div>
    			<?php endif; ?>		
    		</div>
    						
    		<div class="card-classification">
    			
    			<?php display_classification($phylomon_classification_order_array,$terms) ?>    
    			<?php display_classification($phylomon_diy_classification_order_array,$diy_terms,"diy-classification") ?> 	
    		</div>
    		<div class="creative-commons">
    			<a href="http://creativecommons.org/licenses/by-nc-nd/2.0/deed.en_CA" target="_blank"><img src="<?php bloginfo('template_url'); ?>/img/creative-commons.png" alt="Creative Commons Attribution-Noncommercial-No Derivatives Works 2.0" /></a>
    		</div>
    		<div class="card-text">
    			<?php echo nl2br($card['card_content']); ?>
    		</div>
    		
    		<div class="card-temperature">
    			<?php echo $card['temperature']; ?>
    		</div>			
    		<div class="card-credit">    		
    			<?php if($card['graphic_artist']):?>
    			<div class="graphic"> <!-- GRAPHIC -->
    				<span>Image by <em><?php echo $card['graphic_artist']; ?></em></span> 
    				<a href="<?php echo $card['graphic_artist_url']; ?>"><?php $url =  parse_url($card['graphic_artist_url']); echo $url['host'].$url['path']; ?></a>
    			</div>
    		<?php endif;
    			  if($card['photo_artist']): ?>
    			<div class="photo"> <!-- PHOTO -->
    				<span><?php echo $card['photo_artist']; ?></span> 
    				<a href="<?php echo $card['photo_artist_url']; ?>"><?php $url =  parse_url($card['photo_artist_url']); echo $url['host'].$url['path']; ?></a>
    			</div>
    		<?php endif; ?>
    		</div>
    	
    <?php if($container == "li"): ?>
      
    	<div id="card-flip-content-<?php echo $post->ID; ?>" class="card-flip-content" >
    		<?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>" title="go to <?php the_title_attribute(); ?>">read more</a>
    	</div>
      </div><!-- end of card content -->
    	<ul class="card-action" id="card-action-<?php echo $post->ID; ?>">
    		<li><a id="card-permalink-<?php the_ID(); ?>" href="<?php the_permalink(); ?>" class="permalink" title="<?php the_title_attribute(); ?>">Permalink</a></li>
    		<?php if($phylomon_wiki): ?>
    		<li><a href="<?php echo $phylomon_wiki; ?>" class="permalink" title="Wikipedia entry on <?php the_title_attribute(); ?>">Wiki</a></li>
    		<?php endif; if($phylomon_eol): ?>
    		<li><a href="<?php echo $phylomon_eol; ?>" class="permalink" title="Encyclopedia of Life entry on <?php the_title_attribute(); ?>">EOL</a></li>
    		<?php endif; ?>
    </ul>
     </li><!-- end of card container -->
    <?php else: ?>
    	<div id="card-flip-content-<?php echo $post->ID; ?>" class="card-flip-content" >
    		<?php the_excerpt(); ?>
    	</div>
    	</<?php echo $container; ?>>
    	
    	<ul class="card-action" id="card-action-<?php echo $post->ID; ?>">
    		<li><a id="card-permalink-<?php the_ID(); ?>" href="<?php the_permalink(); ?>" class="permalink" title="<?php the_title(); ?>">Permalink</a></li>
    		<?php if($phylomon_wiki): ?>
    		<li><a href="<?php echo $phylomon_wiki; ?>" class="permalink" title="Wikipedia entry on <?php the_title_attribute(); ?>">Wiki</a></li>
    		<?php endif; if($phylomon_eol): ?>
    		<li><a href="<?php echo $phylomon_eol; ?>" class="permalink" title="Encyclopedia of Life entry on <?php the_title_attribute(); ?>">EOL</a></li>
    		<?php endif; ?>
    	</ul>
    </div>
    <div class="card-photo">
    	
    	<div class="card-image ">
    
    	<?php if($card['photo']): ?> <!-- PHOTO -->
    		<div class="photo-page"><img src="<?php echo $card["photo"]; ?>" /></div>
    		<?php else: ?>
    		<div class="photo-page empty">
    		<strong>Sorry, there is no photo available.  If you have one, please submit <a href="http://www.flickr.com/groups/1293102@N24/">here</a>.</strong>
    		</div>
    	<?php endif; ?>	
    	</div>
    	<?php if($card['photo_artist']): ?>
    			<div class="photo-page"> <!-- PHOTO -->
    				<a href="<?php echo $card['photo_artist_url']; ?>"><?php echo $card['photo_artist']; ?> <!-- <br /><?php $url =  parse_url($card['photo_artist_url']); echo $url['host'].$url['path']; ?>--></a>

    			</div>
    	<?php endif; ?>
    	<div class="creative-commons">
    			<a href="http://creativecommons.org/licenses/by-nc-nd/2.0/deed.en_CA" target="_blank"><img src="<?php bloginfo('template_url'); ?>/img/creative-commons.png" alt="Creative Commons Attribution-Noncommercial-No Derivatives Works 2.0" /></a>
    	</div>
    </div>
    <div class="card-entry-content">
    <?php
     // container == div. single card page
    the_content();
    ?>
    </div>    
    <?php
	endif;
}

/**
 * class_size function.
 * helper function for resizing the text of the card name
 * @access public
 * @param mixed $num
 * @return void
 */
function class_size($num)
{
	if( $num > 20 && $num <= 22)
		echo " smaller-13 ";
	elseif($num > 22 && $num <= 24 )
		echo " smaller-12 ";
	elseif($num > 24 && $num <= 28)
		echo " smaller-11 ";
	elseif( $num > 28)
		echo " smaller";

}

/**
 * display_classification function.
 * 
 * @access public
 * @param mixed $order // the order the terms are suppoed to be displayed in
 * @param mixed $terms // the terms object 
 * @param string $tax_slug. (default: 'classification') // the slug of the taxonomy you wish to display ie 'diy-classification'
 * @param string $type. (default: 'link')
 * @param string $before. (default: '') // the string to be dispalyed before
 * @param string $sep. (default: ') // the seperateor
 * @param string $after. (default: '') // the after string
 * @return void
 */
function display_classification($order, $terms, $tax_slug = 'classification', $type='link', $before = '', $sep = ',', $after = '')
{
	$classification_terms = array();
	$classification_terms_names = array();
	if(!empty($terms)):
		
	   	foreach ($terms as $term):
	   	
	   		$classification_terms_names[] = $term->name;
	   		$classification_terms[$term->name] = $term;
	   		
	    endforeach;
		
		
		$exclude = array_diff ( $order, $classification_terms_names );
		$include = array_diff ( $classification_terms_names, $order );
		//var_dump($exclude,$include, $order, $classification_terms_names, $terms );
		
		foreach ($order as $term_name):
			if(!in_array($term_name,$exclude)):
			
			
			$link = get_term_link($classification_terms[$term_name] , $tax_slug );
			switch($type){
				case "link":
					$term_links[] = '<a href="'.$link.'" rel="tag">'.$term_name.'</a>';
				break;
				case "array":
					$term_links[] = array($term_name=>$link);
				break;
			
			}
			
			
			endif;
		endforeach;
		
		foreach( $include as $term_name):
			
			$link = get_term_link($classification_terms[$term_name] , $tax_slug );
			switch($type){
				case "link":
					$term_links[] = '<a href="'.$link.'" rel="tag">'.$term_name.'</a>';
				break;
				case "array":
					$term_links[] = array($term_name=>$link);
				break;
			}
			
		
		endforeach;
			switch($type){
				case "link":
					echo $before . join( $sep, $term_links ) . $after;
					return true;
				break;
				case "array":
					return $term_links;
				break;	
			}
	
	endif;
	
	return false;
	

}

/**
 * curPageURL function.
 *  helper function to get the current url because is_front_page is not working that well...
 * @access public
 * @return string
 */
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


