<?php
/* 
 * This file contains the shortcodes that are specific to this theme
 *
 */

add_shortcode('cards-cart', 'phylomon_cards_cart');
add_shortcode('flickr-cards', 'phylomon_shortcode_flickr_cards');
 
/**
 * phylomon_cards_cart function.
 * 
 * @access public
 * @param mixed $atts
 * @param mixed $content. (default: null)
 * @return void
 */ 
function phylomon_cards_cart($atts) {
    ob_start();
	extract(shortcode_atts(array(
        'user' => 'ubcleap',
        ), $atts));
       
   	?>
    <div id="phylomon-cards-cart">
   	<h2 ><a href="<?php bloginfo('url'); ?>/cards/?selected">Selected Cards</a></h2>
   	<ul id="phylomon-cards-cart-list">
   	<?php 
   	
   	if( isset( $_COOKIE['phylomon_cards'] ) && $_COOKIE['phylomon_cards'] )
   	{
   		
   	
	// Get the selected Cards and DIY-Cards
   	$cards = get_posts("include=".$_COOKIE['phylomon_cards'].'&category_name=cards');
	$diy_cards = get_posts("include=".$_COOKIE['phylomon_cards'].'&category_name=diy-cards');
	$cards = array_merge($cards,$diy_cards);
   		
   	foreach($cards as $post):
   	setup_postdata($post);
	
	?>
   		<li id="card-in-cart-<?php echo $post->ID; ?>">
   		<a href="<?php echo  get_permalink($post->ID); ?>" id="card-name-<?php echo $post->ID; ?>"><?php echo get_the_title($post->ID); ?></a>
   		</li>
   	<?php 
   	endforeach; 
   	$hide_no_cards = "style='display:none'";
   	} 
   	?>
    <li>&nbsp;</li>
   	</ul>
   	<p id="no-cards" <?php echo $hide_no_cards; ?>>
   	No cards have been selected<br /><br />
   	Start by checking off the cards that you want.
   	</p>
   	<noscript><em>Please <a href="https://www.google.com/adsense/support/bin/answer.py?answer=12654" target="_blank">enable Javascript</a> to be able select individual cards for printing</em></noscript>
   	<span id="remove-cards"><a href="#">remove all the cards </a></span>

   	</div>
   	<div id="toggle-photo-graphic">
					<a href="#photo" id="toggle-photo-graphic-trigger" class="show-graphic">Photo set</a>
					<a href="#print" id="print" onclick="window.print();return false;">Print</a>

	</div>
<br /><script type="text/javascript">
// Popup window code
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=800,width=800,left=10,top=10,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}
</script>
<font color="white">.</font><a href="JavaScript:newPopup('/printHOWTO.html');">(printing HOWTO)</a>

   	<?php
    
    return ob_get_clean();
}

/**
 * phylomon_shortcode_flickr_cards function.
 * 
 * short code for dispalying the flickr group images 
 * @access public
 * @param mixed $atts
 * @param mixed $content. (default: null)
 * @return void
 */
function phylomon_shortcode_flickr_cards($atts, $content = null) {
	ob_start();
	
	
	extract(shortcode_atts(array(
		'url' 		=> null,
		'num' 	=> 5,
		'type'		=> null,
		'feed'		=> null,
		'title'		=> null
		), $atts ));
	if(isset($url)):
		$url = html_entity_decode($url);
		
		// let's try to do some caching 
		
		
  		
    	// The cache data doesn't exist or it's expired.
    	// Do whatever we need to populate $mydata from the
    	// database normally... 

    	$feed_object = fetch_feed( $feed );
    	
    	if( is_wp_error($feed_object) )
		{
			return; // fail silently 
		}
			
						
		// Figure out how many total items there are, but limit it to 5. 
		$maxitems = $feed_object->get_item_quantity($num); 
	
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $feed_object->get_items(0,$maxitems); 
		
		switch($type) {
		
		case "cards":
			?>
			<div class="cards flickr-cards">
			<?php if($title) {?><h3><?php echo $title; ?></h3> <?php } ?>
			<?php if($url) {?><a class="more" href="<?php echo $url; ?>" title="see more of the same" >more</a> <?php } ?>
			<ul class="card-queue">
			<?php
			foreach($rss_items as $item):
			?>
				<li class="card-in-queue">
    				<?php $card_title = explode(",",$item->get_title()); ?>
    			<h2 class="card-name"><?php echo $card_title[0]; ?></h2>
    			<span class="latin-name"><?php echo $card_title[1]; ?></span>
        		<a href='<?php echo $item->get_permalink(); ?>' title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>'>
        		<?php 
        		// get the first image from the desciption 
  				$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $item->get_description(), $matches);
  				$first_img = $matches [1] [0];
				?><img src="<?php echo $first_img; ?>" alt="<?php echo $item->get_title(); ?>" class="card-image" /></a>
			</li>

			<?php
	
			endforeach;
			?>
			</ul></div>
			<?php
		
		break;
		default:
		?><div class="flickr-cards">
		<?php if($title) {?><h3><?php echo $title; ?></h3> <?php } ?>
			<?php if($url) {?><a class="more" href="<?php echo $url; ?>" title="see more of the same" >more</a> <?php } ?>
		<ul class="latest-images">
    	<?php if ($maxitems == 0) : echo '<li>No items.</li>';
    	else:
    		// Loop through each feed item and display each item as a hyperlink.
    		foreach ( $rss_items as $item ) : ?>
    		<li><a href="<?php echo $item->get_permalink(); ?>" title="<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>" >
        	<?php 
        	// get the first image from the desciption 
  			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $item->get_description(), $matches);
  			$first_img = $matches [1] [0];

  			if(empty($first_img)){ //Defines a default image
    			$first_img = "/images/default.jpg";
  			}
  			?>
  			<img src="<?php echo $first_img; ?>" alt="<?php echo $item->get_title(); ?>" />
  			</a>    
    		</li>
    		<?php endforeach; 
    	endif;
    	?>
		</ul></div>
		<?php
		break;
		}
		
		
	endif;
			
	return ob_get_clean();
}

 

