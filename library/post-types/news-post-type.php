<?php
function new_post_type() { 
	// creating (registering) the custom type 
	register_post_type( 'new', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'News', 'bunchtheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'News', 'bunchtheme' ), /* This is the individual type */
			'all_items' => __( 'News', 'bunchtheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bunchtheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New News', 'bunchtheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bunchtheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit News', 'bunchtheme' ), /* Edit Display Title */
			'new_item' => __( 'New News', 'bunchtheme' ), /* New Display Title */
			'view_item' => __( 'View News', 'bunchtheme' ), /* View Display Title */
			'search_items' => __( 'Search News', 'bunchtheme' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bunchtheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bunchtheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the News post type', 'bunchtheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'news', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'faqs', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'thumbnail')
	 	) /* end of options */
	); /* end of register post type */
	
	
} 

// adding the function to the Wordpress init
add_action( 'init', 'news_post_type');


// now let's add custom categories (these act like categories)
register_taxonomy( 'news_category', 
	array('news'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
	array('hierarchical' => true,     /* if this is true, it acts like categories */
		'labels' => array(
			'name' => __( 'News Categories', 'bunchtheme' ), /* name of the custom taxonomy */
			'singular_name' => __( 'News Category', 'bunchtheme' ), /* single taxonomy name */
			'search_items' =>  __( 'Search News Categories', 'bunchtheme' ), /* search title for taxomony */
			'all_items' => __( 'All News Categories', 'bunchtheme' ), /* all title for taxonomies */
			'parent_item' => __( 'Parent News Category', 'bunchtheme' ), /* parent title for taxonomy */
			'parent_item_colon' => __( 'Parent News Category:', 'bunchtheme' ), /* parent taxonomy title */
			'edit_item' => __( 'Edit News Category', 'bunchtheme' ), /* edit custom taxonomy title */
			'update_item' => __( 'Update News Category', 'bunchtheme' ), /* update title for taxonomy */
			'add_new_item' => __( 'Add New News Category', 'bunchtheme' ), /* add new title for taxonomy */
			'new_item_name' => __( 'New News Category Name', 'bunchtheme' ) /* name title for taxonomy */
		),
		'show_admin_column' => true, 
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'news_category' ),
	)
);
	

?>
