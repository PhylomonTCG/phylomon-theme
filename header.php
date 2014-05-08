<?php @include_once '/www/htdocs/www_phylogame/wp-content/themes/phylomon-theme/varss.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />
	
	<link rel="stylesheet"  type="text/css" media="print" href="<?php bloginfo('stylesheet_directory'); ?>/print.css" />

	<?php wp_head() // For plugins ?>
    
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
		
</head>

<body class="<?php sandbox_body_class() ?>">

<div id="wrapper" class="hfeed">

	<div id="header">
<a href="/"><img src="/wp-content/uploads/2010/04/header1.gif" alt="" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?>" width="574" height="63" class="alignnone size-full wp-image-422" border="0" /></a>
		<!-- <h1 id="blog-title"><span><a href="<?php bloginfo('home') ?>/" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?>" rel="home"><?php bloginfo('name') ?></a></span></h1> -->
		<div id="blog-description"><?php bloginfo('description') ?></div>
	</div><!--  #header -->

	<div id="access">
		<div class="skip-link"><a href="#content" title="<?php _e( 'Skip to content', 'sandbox' ) ?>"><?php _e( 'Skip to content', 'sandbox' ) ?></a></div>
		<?php sandbox_globalnav() ?>
		
		<div id="card-searchform-shell">
						<form id="card-searchform"  class="card-search" method="get" action="<?php bloginfo('url'); ?>">
                            <input id="card-autosearch" name="s" type="text" class="text" value="" size="10" tabindex="1" />
							<input type="submit" class="button" value="Search" tabindex="2" />
							<input type="hidden" name="cat" value="3" />
                        </form>
					</div>
	</div><!-- #access -->