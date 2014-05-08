<?php 
/* 
 * This file contains code that is responsible for adding the custom fields on the post edit page. (admin area)
 *
 */

add_action("admin_head-post-new.php","phylomon_add_admin_style");
add_action("admin_head-post.php","phylomon_add_admin_style");

// style for the custom fields META BOXES 
function phylomon_add_admin_style()
{
    echo "<link rel='stylesheet' id='phylomon-acmin'  href='".get_bloginfo("template_url")."/css/admin.css' type='text/css' media='all' />";
    return true;
}
/* Custom META BOX */

/*Use the admin_menu action to define the custom boxes */
add_action('admin_menu', 'phylomon_add_custom_box');

/* Use the save_post action to do something with the data entered */
add_action('save_post', 'phylomon_save_postdata'); 

/** 
 * Adds a custom section to the "advanced" Post and Page edit screens 
 **/
function phylomon_add_custom_box() {

  if( function_exists( 'add_meta_box' )) {
    add_meta_box( 'phylomon_sectionid', __( 'Card Meta Info', 'phylomon_textdomain' ), 'phylomon_inner_custom_box', 'post', 'advanced' );          
    
   } else {
    add_action('dbx_post_advanced', 'phylomon_old_custom_box' );
    add_action('dbx_page_advanced', 'phylomon_old_custom_box' );
  }
}



/* Prints the inner fields for the custom post/page section */
function phylomon_inner_custom_box() {
    global $post;
    if($post->ID):
        // Latin Name
        $phylomon_latin_name              = get_post_meta($post->ID, "_phylomon_latin_name",            true);
        
        // Graphic
        $phylomon_graphic_artist          = get_post_meta($post->ID, "_phylomon_graphic_artist",       true);
        $phylomon_graphic_artist_url      = get_post_meta($post->ID, "_phylomon_graphic_artist_url",   true);
        $phylomon_graphic                 = get_post_meta($post->ID, "_phylomon_graphic",              true);
        
        // Photo
        $phylomon_photo_artist            = get_post_meta($post->ID, "_phylomon_photo_artist",         true);
        $phylomon_photo_artist_url        = get_post_meta($post->ID, "_phylomon_photo_artist_url",     true);
        $phylomon_photo                   = get_post_meta($post->ID, "_phylomon_photo",                true);
        
        
        $phylomon_size                    = get_post_meta($post->ID, "_phylomon_size",                 true);
        $phylomon_food                    = get_post_meta($post->ID, "_phylomon_food",                 true);
        $phylomon_hierarchy               = get_post_meta($post->ID, "_phylomon_hierarchy",            true);
        
        // Habitat 
        $phylomon_habitat1                = get_post_meta($post->ID, "_phylomon_habitat1",             true);
        $phylomon_habitat2                = get_post_meta($post->ID, "_phylomon_habitat2",             true);
        $phylomon_habitat3                = get_post_meta($post->ID, "_phylomon_habitat3",             true);
        
        // Card Color 
        $phylomon_card_color              = get_post_meta($post->ID, "_phylomon_card_color",           true);
        
        // Temperature
        $phylomon_temperatue             = maybe_unserialize(get_post_meta($post->ID, "_phylomon_temperature",true));
       
        
        // Card Content 
        $phylomon_card_content			 = get_post_meta($post->ID, "_phylomon_card_content",          true);
     	
     	
     	// Classification 
     	$phylomon_classification_order	 = get_post_meta($post->ID, "_phylomon_classification_order",  true);
     	
     	$phylomon_classification_order_array = explode(",",$phylomon_classification_order);
     	
		$terms = get_the_terms( $post->ID, 'classification' );
   		
   		   	
   	  	$classification_terms = array();
                if(is_array($terms)):
   	  	foreach ($terms as $term):
   	  		$classification_terms[] = $term->name;
   	  	endforeach;
   	  	endif;
   	  	$classification_in_terms = array_diff  (  $phylomon_classification_order_array ,$classification_terms);
		$classification_in_order = array_diff  (  $classification_terms, $phylomon_classification_order_array );

    else:
    endif;
    
  
	
  	echo '<input type="hidden" name="phylomon_noncename" id="phylomon_noncename" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    
  // The actual fields for data entry
  ?>
   <p>
   <strong><label for="phylomon_latin_name"><?php echo  __("Latin Name:", 'phylomon_textdomain' );?> </label></strong> <br />
   <input type="text" name="phylomon_latin_name" value="<?php echo $phylomon_latin_name; ?> " size="25"  />
   </p>
  <div class="phylomon_container  odd">
  <h4><?php echo __("Graphic", 'phylomon_textdomain' ) ;?></h4>
  <p class="half">
      <label for="phylomon_graphic_artist"> <?php echo __("Artist Name:", 'phylomon_textdomain' ) ;?></label> <br />
      <input type="text" name="phylomon_graphic_artist" value="<?php echo $phylomon_graphic_artist; ?>" size="25"  />
  </p>
  <p class="half last">
      <label for="phylomon_graphic_artist_url"> <?php echo __("Artist Url:", 'phylomon_textdomain' ) ;?></label> <br />
      <input type="text" name="phylomon_graphic_artist_url" value="<?php echo $phylomon_graphic_artist_url; ?>" size="30"  />
  </p>
  <p class="clear">
  <label for="phylomon_graphic"> <?php echo __("Graphic Url:", 'phylomon_textdomain' ) ;?></label> <br />
  <input type="text" name="phylomon_graphic" value="<?php echo $phylomon_graphic; ?>" size="60"  />
  </p>
  </div>
  
  <div class="phylomon_container ">
  <h4><?php echo __("Photo", 'phylomon_textdomain' ) ;?></h4>
  <p class="half">
      <label for="phylomon_photo_artist"> <?php echo __("Artist Name:", 'phylomon_textdomain' ) ;?></label> <br />
      <input type="text" name="phylomon_photo_artist" value="<?php echo $phylomon_photo_artist; ?>" size="25"  />
  </p>
  <p class="half last">
      <label for="phylomon_photo_artist_url"> <?php echo __("Artist Url:", 'phylomon_textdomain' ) ;?></label> <br />
      <input type="text" name="phylomon_photo_artist_url" value="<?php echo $phylomon_photo_artist_url; ?>" size="30"  />
  </p>
  <p class="clear">
  <label for="phylomon_photo"> <?php echo __("Graphic Url:", 'phylomon_textdomain' ) ;?></label> <br />
  <input type="text" name="phylomon_photo" value="<?php echo $phylomon_photo; ?>" size="60"  />
  </p>
  </div>
  
  
  <div class="phylomon_container ">
  <h4><?php echo __("External Links", 'phylomon_textdomain' ) ;?></h4>
  <p class="clear">
  <label for="phylomon_wiki"> <?php echo __("Wikipedia Url:", 'phylomon_wiki' ) ;?></label> <br />
  <input type="text" name="phylomon_wiki" value="<?php echo $phylomon_wiki; ?>" size="60"  />
  </p>
  <p class="clear">
  <label for="phylomon_eol"> <?php echo __("Encyclopedia of Life (EOL) Url:", 'phylomon_textdomain' ) ;?></label> <br />
  <input type="text" name="phylomon_eol" value="<?php echo $phylomon_eol; ?>" size="60"  /> 
  </p>
  </div>
  
  
  <div class="phylomon_container odd">
  <h4><label for="phylomon_classification_order"><?php echo __("Classification Order", 'phylomon_textdomain' ) ;?></label></h4>
  
  <p>
   	  <input type="text" id="phylomon_classification_order" name="phylomon_classification_order" value="<?php if(is_array($phylomon_classification_order_array)) { echo implode(", ",$phylomon_classification_order_array); } ?>" size="50" />
   	  <span>(Seperate terms using commas)<br /></span>
   	  <div class="classification">Classification is not ordered yet: <span id="classification_in_order"><?php  if(is_array($classification_in_order) && !empty($classification_in_order)) { echo implode(", ",$classification_in_order );  ?></span> <a href="#" class="add" id="classification_in_order_action">add them to the Classification List</a><?php } ?></div>
   	     	  
   	  
   	  <div class="classification">Classification not specified yet: <span id="classification_in_terms"><?php if(is_array($classification_in_terms) && !empty($classification_in_terms)) { echo implode(", ",$classification_in_terms ); ?></span> <a href="#" class="add" id="classification_in_terms_action">add them to the Classification Taxonomy</a><?php } ?></div>
  </p>
  </div>

  
  
  
  
  
  <div class="phylomon_container ">
  <h4><?php echo __("Food Chain Hierarchy", 'phylomon_textdomain' ) ;?></h4>
  <p class="half">
      <label for="phylomon_food"> <?php echo __("Diet:", 'phylomon_textdomain' ) ;?></label> <br />
      <select id="phylomon_food" name="phylomon_food">
      	  <option <?php if($phylomon_food == "null") { echo "selected='selected' "; } ?> value="null" >Not Applicable</option>
          <option <?php if($phylomon_food == "photosynthetic") { echo "selected='selected' ";} ?> value="photosynthetic">Photosynthetic - yellow</option>
          <option <?php if($phylomon_food == "carbon-macromolecules") { echo "selected='selected' ";} ?>  value="carbon-macromolecules">Carbon Macromolecules - black</option>
          <option <?php if($phylomon_food == "herbivore") { echo "selected='selected' ";} ?>  value="herbivore">Herbivore - green</option>
          <option <?php if($phylomon_food == "omnivore") { echo "selected='selected' ";} ?>  value="omnivore">Omnivore - brown</option>
          <option <?php if($phylomon_food == "carnivore") { echo "selected='selected' ";} ?>  value="carnivore">Carnivore - red</option>
      </select>
      
  </p>
  <p class="half last">
      <label for="phylomon_hierarchy"> <?php echo __("Hierarchy:", 'phylomon_textdomain' ) ;?></label> <br />
      <select id="phylomon_hierarchy" name="phylomon_hierarchy">
      <option <?php if($phylomon_hierarchy == "null") { echo "selected='selected' "; } ?> value="null" >Not Applicable</option>
      <?php $i = 1;
        while ($i <= 9) : ?>
            <option <?php if($phylomon_hierarchy == $i) { echo "selected='selected' ";} ?>  ><?php         echo $i++;   ?></option>
    <?php endwhile; ?>
      </select>
  </p>
  </div>
  
  
  
  
  
  
  <div class="phylomon_container odd">
  <h4><?php echo __("Size", 'phylomon_textdomain' ) ;?></h4>
  
  <p >
      <label for="phylomon_size"> <?php echo __("Size:", 'phylomon_textdomain' ) ;?></label> <br />
      <select id="phylomon_size" name="phylomon_size">
      	<option <?php if($phylomon_size == "null") { echo "selected='selected' "; } ?> value="null" >Not Applicable</option>
      <?php $i = 1;
        while ($i <= 9) : ?>
            <option <?php if($phylomon_size == $i) { echo "selected='selected' ";} ?>  ><?php         echo $i++;   ?></option>
    <?php endwhile; ?>
      </select>
  </p>
  </div>
  
  
  
  
  
  <div class="phylomon_container">
  <h4><?php echo __("Habitat Landscape", 'phylomon_textdomain' ) ;?></h4>
  
  <p>
      <label for="phylomon_habitat1"> <?php echo __("Habitat:", 'phylomon_textdomain' ) ;?></label> <br />
      <select id="phylomon_habitat1" name="phylomon_habitat1">    
          <option <?php if($phylomon_habitat1 == "desert") { echo "selected='selected' ";} ?> value="desert">Desert</option>
          <option <?php if($phylomon_habitat1 == "forest") { echo "selected='selected' ";} ?>  value="forest">Forest</option>
          <option <?php if($phylomon_habitat1 == "fresh-water") { echo "selected='selected' ";} ?>  value="fresh-water">Fresh Water</option>
          <option <?php if($phylomon_habitat1 == "grasslands") { echo "selected='selected' ";} ?>  value="grasslands">Grasslands</option>
          <option <?php if($phylomon_habitat1 == "ocean") { echo "selected='selected' ";} ?>  value="ocean">Ocean</option>
          <option <?php if($phylomon_habitat1 == "tundra") { echo "selected='selected' ";} ?> value="tundra">Tundra</option>
          <option <?php if($phylomon_habitat1 == "urban") { echo "selected='selected' ";} ?>  value="urban">Urban</option>
      </select>
      
      
      <select id="phylomon_habitat2" name="phylomon_habitat2">
          <option <?php if($phylomon_habitat2 == "none") { echo "selected='selected' ";} ?> value="none">None</option>    
          <option <?php if($phylomon_habitat2 == "desert") { echo "selected='selected' ";} ?> value="desert">Desert</option>
          <option <?php if($phylomon_habitat2 == "forest") { echo "selected='selected' ";} ?>  value="forest">Forest</option>
          <option <?php if($phylomon_habitat2 == "fresh-water") { echo "selected='selected' ";} ?>  value="fresh-water">Fresh Water</option>
          <option <?php if($phylomon_habitat2 == "grasslands") { echo "selected='selected' ";} ?>  value="grasslands">Grasslands</option>
          <option <?php if($phylomon_habitat2 == "ocean") { echo "selected='selected' ";} ?>  value="ocean">Ocean</option>
          <option <?php if($phylomon_habitat2 == "tundra") { echo "selected='selected' ";} ?> value="tundra">Tundra</option>
          <option <?php if($phylomon_habitat2 == "urban") { echo "selected='selected' ";} ?>  value="urban">Urban</option>
      </select>
      
      <select id="phylomon_habitat3" name="phylomon_habitat3">
          <option <?php if($phylomon_habitat3 == "none") { echo "selected='selected' ";} ?> value="none">None</option>    
          <option <?php if($phylomon_habitat3 == "desert") { echo "selected='selected' ";} ?> value="desert">Desert</option>
          <option <?php if($phylomon_habitat3 == "forest") { echo "selected='selected' ";} ?>  value="forest">Forest</option>
          <option <?php if($phylomon_habitat3 == "fresh-water") { echo "selected='selected' ";} ?>  value="fresh-water">Fresh Water</option>
          <option <?php if($phylomon_habitat3 == "grasslands") { echo "selected='selected' ";} ?>  value="grasslands">Grasslands</option>
          <option <?php if($phylomon_habitat3 == "ocean") { echo "selected='selected' ";} ?>  value="ocean">Ocean</option>
          <option <?php if($phylomon_habitat3 == "tundra") { echo "selected='selected' ";} ?> value="tundra">Tundra</option>
          <option <?php if($phylomon_habitat3 == "urban") { echo "selected='selected' ";} ?>  value="urban">Urban</option>
      </select>
  </p>
  
   
 
  </div>
  
  <div class="phylomon_container odd">
  <h4><label for="phylomon_card_color"> <?php echo __("Card Color:", 'phylomon_textdomain' ) ;?></label></h4>
  <p>
       <input type="text" name="phylomon_card_color" value="<?php echo $phylomon_card_color; ?>" size="10"  /> <span style="background:<?php echo $phylomon_card_color; ?>; width:20px; height:20px; display:block; position:relative; left:105px; top:-22px;"> </span>
  </p>
  
  </div>
  
 <div class="phylomon_container">
  <h4><label for="phylomon_temperature"> <?php echo __("Temperature:", 'phylomon_textdomain' ) ;?></label></h4>
  
  <p>
               
          <label for="phylomon_temperature_cold">
          	<input <?php if(is_array($phylomon_temperatue) && in_array("Cold",$phylomon_temperatue )){?> checked="checked" <?php } ?> id="phylomon_temperature_cold" type="checkbox" name="phylomon_temperature[]" value="Cold" /> Cold</label>
          <label for="phylomon_temperature_cool">
          	<input <?php if(is_array($phylomon_temperatue) && in_array("Cool",$phylomon_temperatue)){?> checked="checked" <?php } ?> id="phylomon_temperature_cool" type="checkbox" name="phylomon_temperature[]" value="Cool" /> Cool</label>
          <label for="phylomon_temperature_warm">
          	<input <?php if(is_array($phylomon_temperatue) && in_array("Warm",$phylomon_temperatue)){?> checked="checked" <?php } ?> id="phylomon_temperature_warm" type="checkbox" name="phylomon_temperature[]" value="Warm" /> Warm</label>
          <label for="phylomon_temperature_hot">
          	<input <?php if(is_array($phylomon_temperatue) && in_array("Hot",$phylomon_temperatue)){?> checked="checked" <?php } ?> id="phylomon_temperature_hot" type="checkbox" name="phylomon_temperature[]" value="Hot" /> Hot</label>
    
  </p>
  </div>
  
   <div class="phylomon_container odd">
   <h4><label for="phylomon_card_content"> <?php echo __("Card Text:", 'phylomon_textdomain' ) ;?></label></h4>
  
  <p>
               
          <textarea name="phylomon_card_content" id="phylomon_card_content" ><?php echo $phylomon_card_content; ?></textarea>
    
  </p>
  </div>
  <?php 
  
}

// Prints the edit form for pre-WordPress 2.5 post/page 
function phylomon_old_custom_box() {

  echo '<div class="dbx-b-ox-wrapper">' . "\n";
  echo '<fieldset id="phylomon_fieldsetid" class="dbx-box">' . "\n";
  echo '<div class="dbx-h-andle-wrapper"><h3 class="dbx-handle">' . 
        __( 'Card Meta Info', 'myplugin_textdomain' ) . "</h3></div>";   
   
  echo '<div class="dbx-c-ontent-wrapper"><div class="dbx-content">';

  // output editing form

  phylomon_inner_custom_box();

  // end wrapper

  echo "</div></div></fieldset></div>\n";
}

// When the post is saved, saves our custom data 
function phylomon_save_postdata( $post_id ) {
  global $phylomon_version;
  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['phylomon_noncename'], plugin_basename(__FILE__) )) {
    return $post_id;
  }

  // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
  // to do anything
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return $post_id;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }

      // OK, we're authenticated: we need to find and save the data

  
    // Do something with $mydata 
    // probably using add_post_meta(), update_post_meta(), or 
    // a custom table (see Further Reading section below)
   
    // latin name 
    update_post_meta($post_id, "_phylomon_latin_name",     			esc_attr($_POST["phylomon_latin_name"]));
   
    // Graphic
    update_post_meta($post_id, "_phylomon_graphic_artist",         	esc_attr($_POST["phylomon_graphic_artist"]));
    update_post_meta($post_id, "_phylomon_graphic_artist_url",     	esc_url($_POST["phylomon_graphic_artist_url"]));
    update_post_meta($post_id, "_phylomon_graphic",             	esc_url($_POST["phylomon_graphic"]));
        
    // Photo
    update_post_meta($post_id, "_phylomon_photo_artist",         	esc_attr($_POST["phylomon_photo_artist"]));
    update_post_meta($post_id, "_phylomon_photo_artist_url",     	esc_url($_POST["phylomon_photo_artist_url"]));
    update_post_meta($post_id, "_phylomon_photo",                 	esc_url($_POST["phylomon_photo"]));
    
    // Food Chain Hierarchy
    update_post_meta($post_id, "_phylomon_food",         			esc_attr($_POST["phylomon_food"]));
    update_post_meta($post_id, "_phylomon_hierarchy",     			esc_attr($_POST["phylomon_hierarchy"]));
    
    // Size 
    update_post_meta($post_id, "_phylomon_size",         			esc_attr($_POST["phylomon_size"]));
    
    // Habitat
    update_post_meta($post_id, "_phylomon_habitat1",     			esc_attr($_POST["phylomon_habitat1"]));
    update_post_meta($post_id, "_phylomon_habitat2",     			esc_attr($_POST["phylomon_habitat2"]));
    update_post_meta($post_id, "_phylomon_habitat3",     			esc_attr($_POST["phylomon_habitat3"]));
    
    // Card Color 
    update_post_meta($post_id, "_phylomon_card_color",     			esc_attr($_POST["phylomon_card_color"]));
    
 
    // Temperature 
    update_post_meta($post_id, "_phylomon_temperature",     		 $_POST["phylomon_temperature"]);
    
    update_post_meta($post_id, "_phylomon_card_content",     	    esc_html($_POST["phylomon_card_content"]));
    
    
    
    // Classification Order
    $phylomon_classification_order = explode(",", trim( esc_attr( $_POST["phylomon_classification_order"] ) ) );
    
  	$phylomon_classification_order_clean = array();
    
    foreach($phylomon_classification_order as $order):
    	$phylomon_classification_order_clean[] = trim($order);
    endforeach;
    // 
    update_post_meta($post_id, "_phylomon_classification_order", implode(",",$phylomon_classification_order_clean));
    
    
    // wiki 
	update_post_meta($post_id, "_phylomon_wiki",     	    esc_url($_POST["phylomon_wiki"]));
	// EOL
	update_post_meta($post_id, "_phylomon_eol",     	    esc_url($_POST["phylomon_eol"]));
    
    // Card Image
    $image[] = esc_attr($_POST["phylomon_habitat1"]);
    // create the background image 
    if($_POST["phylomon_habitat2"] != "none")
    	$image[] = esc_attr($_POST["phylomon_habitat2"]);
    	
    if($_POST["phylomon_habitat3"] != "none")
    	$image[] = esc_attr($_POST["phylomon_habitat3"]);
    
    create_image($width=250,$height=392,esc_attr($_POST["phylomon_card_color"]), $image ,$phylomon_version);
    
   return $mydata;
}
