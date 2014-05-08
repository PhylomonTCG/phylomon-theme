<?php

add_action("template_redirect",array("phylomon_card_api", 'init') );

/**
 * phylomon_card_api class.
 */
class phylomon_card_api{
	
	/**
	 * init function.
	 * 
	 * @access public
	 * @return void
	 */
	function init(){
		
		if( !isset($_GET['api']) )
			return;
			
			
			$data = self::router();
			
			switch($_GET['api']){
				
				case 'xml':
					if( class_exists('SimpleXMLElement') ):
					$xml = new SimpleXMLElement("<?xml version=\"1.0\"?><cards></cards>"); 
					foreach( $data as $card ):
						$subnode = $xml->addChild("card");
						//var_dump($card);
						self::array_to_xml( $card, $subnode );
					endforeach;
					echo $xml->asXML();
					else:
						echo "Simple XML Element Not supported";
					endif;
					
				break;
				
				case 'json':
				default:
					header('Content-Type: application/json');
					if(isset($_GET['callback']) && is_string($_GET['callback'])):
						echo $_GET['callback'].'('.json_encode($data).');';
					else:
					
					echo ''.json_encode($data);
					endif;
				break;
			}
			die();
	}
	
	/**
	 * router function.
	 * 
	 * @access public
	 * @return void
	 */
	function router(){
		global $post;
		
		
		if( is_front_page() || is_page('cards') || is_page('diy-cards') ): // homepage
			$page = '';
			if(isset($_GET['page']) && is_numeric( $_GET['page']) )
				$page = '&paged='.$_GET['page'];
				
			$category = 'cards';
			if(isset($_GET['diy']) || is_page('diy-cards'))
				$category = 'diy-cards';
			
			$num = 20;
			
			if(isset($_GET['num']) && is_numeric( $_GET['num']) ):
				$num = $_GET['num'];
				if( $num > 2000)
				$num = 200;
			endif;
				
				
			$query = 'category_name='.$category.'&posts_per_page='.$num.'&post_status=publish'.$page;
			$data = self::get_cards( $query );
		
		elseif( is_single() ): // single post
			
			$data[0] = self::get_card_array( $post );
			
		elseif( is_page('') ):
			$data[0] = self::get_card_array( $post );
				
		endif;
		return $data;

	}
	
	/**
	 * get_cards function.
	 * 
	 * @access public
	 * @param mixed $query
	 * @return void
	 */
	function get_cards(	$query ) {
		global $post;
		$the_query = new WP_Query( $query );
		
					
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$data[] = self::get_card_array( $post );
		endwhile; 
		
		wp_reset_postdata();
		return $data;
	}
	
	/**
	 * get_card_array function.
	 * 
	 * @access public
	 * @param mixed $post_card
	 * @return void
	 */
	function get_card_array( $post_card ) {
		
	
	$card_array['name'] = get_the_title();
	$card_array['card_url'] = get_permalink();
	
	$custom_fields =  get_post_custom($post_card->ID);

	foreach($custom_fields as $key => $custom):
		$custom[0] = trim($custom['0']);
		switch($key)
		{
			
		case '_phylomon_latin_name':
			if(!empty($custom['0']))
				$flag = true;
				
			$card_array['latin_name' ] = $custom['0']; 					// latin name
		break;
		
		case '_phylomon_graphic_artist':
			$card_array['graphic_artist' ] = $custom['0']; 		// graphic_artist               
		break;
		
		case '_phylomon_graphic_artist_url':
			$card_array['graphic_artist_url' ] = $custom['0'];	// graphic_artist_url    
	    break;
		
		case '_phylomon_graphic':
	   		$card_array['graphic' ] = $custom['0'];			// graphic  
	    break;
		
		case '_phylomon_photo_artist':
	    	$card_array['photo_artist' ] = $custom['0'];	// photo_artist       
	    break;
		
		case '_phylomon_photo_artist_url':
	    	$card_array['photo_artist_url' ] = $custom['0']; 	// photo_artist_url
	    break;
		
		case '_phylomon_photo':
	    	$card_array['photo' ] = $custom['0']; 				// photo                
	    break;
		
		case '_phylomon_size':
			$card['size'] = $custom['0'];
	    	$card_array['size' ] = $custom['0'];				// size
	    break;
		
		case '_phylomon_food':
			
			$card['food'] = $custom['0'];
	    	$card_array['food'] = $custom['0']; 				// food                
	    break;
		
		case '_phylomon_hierarchy':
			$card['hierarchy'] = $custom['0'];
	    	$card_array['hierarchy' ] = $custom['0'];			// hierarchy             
	    break;
		
		case '_phylomon_habitat1':
			$card['habitat1'] = $custom['0'];
	    	$card_array['habitat1' ] = $custom['0']; 			// habitat1   
	    break;
		
		case '_phylomon_habitat2':
			$card['habitat2'] = $custom['0'];
	    	$card_array['habitat2' ] = $custom['0']; 			// habitat2            
	    break;
		
		case '_phylomon_habitat3':
			$card['habitat3'] = $custom['0'];
	    	$card_array['habitat3' ] = $custom['0']; 			// habitat3            	
		break;
		
		case '_phylomon_card_color':
			$card['card_color'] = $custom['0'];
			$card_array['card_color' ] = $custom['0']; 			// card_color 
		break;
		
		case '_phylomon_temperature':
			$temp = null;
			
			$temp = maybe_unserialize($custom['0']);
			
			$card_array['temperature'] = $temp;			// temperatue 
	    break;
	    
		case '_phylomon_card_content':  
	    	$card_array['card_content' ] = $custom['0']; 		// card_content     	
	    break;
		
		case '_phylomon_wikipedia_url': 	
	   	 $card_array['wikipedia_url' ] = $custom['0'];				// wikipedia_url 	
	    break;
		
		case '_phylomon_eol_url': 
		    $card_array['eol_url' ] = $custom['0']; 				// eol_url
		break;
				
		case "_phylomon_classification_order":
			$phylomon_classification_order = $custom['0'];   // Classification Taxonomy 
		break;
		
		case "_phylomon_diy_classification_order":
			$phylomon_diy_classification_order = $custom['1'];   // DIY Classification Taxonomy 
		break;
		
		}
	endforeach;
	
		$image[] = $card['habitat1'] ;
    
    	if($card['habitat2']  != "none")
    		$image[] = $card["habitat2"];
    	
    	if($card['habitat3']  != "none")
    		$image[] = $card["habitat3"];
    		
		$card_array['background_image_url' ] = get_bloginfo('template_url')."/img/generated-card-images/bg-".substr($card['card_color'],1)."-".implode("-",$image)."-1".$phylomon_version.".png";			// background_image_url  
		 	
		$card_array['size_image_url' ] = get_bloginfo('stylesheet_directory')."/img/num/". $card['size'].".png";					// size_image_url       
		 
		$card_array['food_hierarchy_image_url' ] = get_bloginfo('stylesheet_directory')."/img/num/". $card['food'].$card['hierarchy'].".png";				// food_hierarchy_image_url
	
	
		$phylomon_classification_order_array = explode(",",$phylomon_classification_order);
     	$terms = get_the_terms( $post_id, 'classification' );
		$terms_in_order = display_classification($phylomon_classification_order_array,$terms,'classification', "array");
		
		$phylomon_diy_classification_order_array = explode(",",$phylomon_diy_classification_order);
     	$diy_terms = get_the_terms( $post_id, 'diy-classification' );
		$diy_terms_in_order = display_classification($phylomon_diy_classification_order_array,$diy_terms,'diy-classification',"array");
		
		$card_array['classification'] = array_merge($terms_in_order,$diy_terms_in_order);
	
	
	return $card_array;
	
	
	}
	
	// function defination to convert array to xml
	
	/**
	 * array_to_xml function.
	 * 
	 * @access public
	 * @param mixed $data
	 * @param mixed &$xml
	 * @return void
	 */
	function array_to_xml($data, &$xml) {
	    foreach($data as $key => $value) {
	        if(is_array($value)) {
	            if(!is_numeric($key)){
	                $subnode = $xml->addChild("$key");
	                self::array_to_xml($value, $subnode);
	            }
	            else{
	                self::array_to_xml($value, $xml);
	            }
	        }
	        else {
	            $xml->addChild("$key","$value");
	        }
	    }
	}
}






/**************************************************************************************
 *  API DOCS
 **************************************************************************************
 
	url api parameters:
	api - can eather be json or xml default is json, has to be present
	num - returns the number of cards maximum is 200 default is 20
	page - page number to get to the page = 2 for second page
	callback - only applicable to json will call the callback function with the json data passed into it.
	diy - set this parameter to get back the diy cards
	if you don't have a callback parameter specified phylomon_cards will be returned;



	Urls you can visit. 
	homepage:
	so http://phyogame.com
	
	cards:
	http://http://phyogame.com/cards
	
	diy-cards:
	http://http://phyogame.com/diy-cards
	
	single card url:
	http://phyogame.com/2013/04/evening-grosbeak
	
	example urls
	http://phyogame.com/?api=json&num=200&page=1&callback=function_name&diy=1
	
	http://phyogame.com/?api=xml&num=20&page=1&diy=1
	
	http://phyogame.com/2013/04/evening-grosbeak/?api=json
	
	
	same example HTML
	
	<script>
	function get_cards(data) {
		alert('The first card is '+data[0].name );
		console.log( data[0] );
	}
	</script>


	<script src="http://local.dev/?api=json&callback=get_cards"></script>
	<!-- <script src="http://local.dev/2013/04/evening-grosbeak/?api=1&callback=get_cards"></script> -->

*/