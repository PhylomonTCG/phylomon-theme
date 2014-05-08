<?php
/**
 * create_image function.
 * 
 * @access public
 * @param int $width. (default: 250)
 * @param int $height. (default: 392)
 * @param mixed $color
 * @param array $merge. (default: array())
 * @param int $version. (default: 0)
 * @return void
 */
function  create_image($width=250,$height=392,$color, $merge = array(),$version=0){
		global $phylomon_version;
		
		$color_rgb = rgb2hex2rgb($color);
		
		if( !GD_VERSION || !is_writable(TEMPLATEPATH."/img/generated-card-images/") )
			return false;
		
        $im = @imagecreate($width, $height)or die("Cannot Initialize new GD image stream");
        $background_color = imagecolorallocate($im, $color_rgb[0], $color_rgb[1], $color_rgb[2]); 		
		
        $count = count($merge);
        $i = 0;
        $correction = 0;
        if($count == 3)
        	$correction = 1;
		if($count > 0):
			foreach($merge as $insert):
			
				unset($addition_image);
				// load the image
				$addition_image = imagecreatefrompng(TEMPLATEPATH."/img/card-image/source/$insert-$count.png");
				
				// Select the first pixel of the overlay image (at 0,0) and use
  				// it's color to define the transparent color
				imagecolortransparent($addition_image,imagecolorat($addition_image,0,0));
				
				$img_width  = imagesx( $addition_image );    // width of the image
				$img_height = imagesy( $addition_image );    // height of the image
				// combine the image to the background color image
				imagecopymerge($im, $addition_image, $i*round(250/$count), $height-70, 0, 0, $img_width-$correction,$img_height,30);
		
				imagedestroy($addition_image);
				$i++;
				
			endforeach;
		endif;
		
		imagepng($im,TEMPLATEPATH."/img/generated-card-images/bg-".substr($color,1)."-".implode("-",$merge)."-".$phylomon_version.".png");
        
        imagedestroy($im);		        
}




/**
 * rgb2hex2rgb function.
 * 
 * @access public
 * @param mixed $c
 * @return void
 */
function rgb2hex2rgb($c){
   if(!$c) return false;
   $c = trim($c);
   $out = false;
  if(preg_match("/^[0-9ABCDEFabcdef\#]+$/i", $c)){
      $c = str_replace('#','', $c);
      $l = strlen($c) == 3 ? 1 : (strlen($c) == 6 ? 2 : false);

      if($l){
         unset($out);
         $out[0] = $out['r'] = $out['red'] = hexdec(substr($c, 0,1*$l));
         $out[1] = $out['g'] = $out['green'] = hexdec(substr($c, 1*$l,1*$l));
         $out[2] = $out['b'] = $out['blue'] = hexdec(substr($c, 2*$l,1*$l));
      }else $out = false;
             
   }elseif (preg_match("/^[0-9]+(,| |.)+[0-9]+(,| |.)+[0-9]+$/i", $c)){
      $spr = str_replace(array(',',' ','.'), ':', $c);
      $e = explode(":", $spr);
      if(count($e) != 3) return false;
         $out = '#';
         for($i = 0; $i<3; $i++)
            $e[$i] = dechex(($e[$i] <= 0)?0:(($e[$i] >= 255)?255:$e[$i]));
             
         for($i = 0; $i<3; $i++)
            $out .= ((strlen($e[$i]) < 2)?'0':'').$e[$i];
                 
         $out = strtoupper($out);
   }else $out = false;
         
   return $out;
} 
?>