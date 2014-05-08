<?php

/* Custom Taxonomies */
add_action( 'init', 'phylomon_taxonomies', 0 );
function phylomon_taxonomies() {
	register_taxonomy( 'classification', 'post', array( 'hierarchical' => false, 'label' => 'Classification', 'query_var' => true, 'rewrite' => array( 'slug' => 'classification' )  ) );
	register_taxonomy( 'diy-classification', 'post', array( 'hierarchical' => false, 'label' => 'DIY Classification', 'query_var' => true, 'rewrite' => array( 'slug' => 'diy-classification' )  ) );
	register_taxonomy( 'card-meta-tags', 'post', array( 'hierarchical' => false, 'label' => 'Card Meta Tags', 'query_var' => true, 'rewrite' => array( 'slug' => 'card-meta-tags' )  ) );
}
