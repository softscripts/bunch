<?php
/*
This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/theme.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once( 'library/theme.php' ); // if you remove this, goodscout will break
/*
2. library/post-types/theme-options.php
	- manage theme options (like logo, social links and footer)
*/
require_once( 'library/theme-options.php' ); // you can disable this if you like
/*
3. library/post-types/post-types.php
	- custom post types
	- custom taxonomy (like categories)
	- custom taxonomy (like tags)
*/
require_once( 'library/post-types/post-types.php' ); // you can disable this if you like
/*
4. library/metaboxes/metaboxes.php
	- custom metaboxes for different post types
	- can add different type of fields
*/
require_once( 'library/metaboxes/metaboxes.php' ); // you can disable this if you like
/*
5. library/widgets/widgets.php
	- custom widgets for current theme
	- can add multiple widgets
*/
require_once( 'library/widgets/widgets.php' ); // you can disable this if you like
/*
6. library/admin.php
	- removing some default WordPress dashboard widgets
	- adding custom login css
*/
require_once( 'library/admin.php' ); // this comes turned off by default
/*
7. library/attachments/attachments.php
	- adding support for attachments for different post types
*/
require_once( 'library/attachments/attachments.php' ); // this comes turned on by default
/*
8. library/translation/translation.php
	- adding support for other languages
*/
// require_once( 'library/translation/translation.php' ); // this comes turned off by default

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bunch-thumb-600', 600, 150, true );
add_image_size( 'bunch-thumb-300', 300, 100, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bunch-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bunch-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* DISABLE ADMIN BAR ON FRONT END *************/

show_admin_bar(false); // you can disable this if you like


/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bunch_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bunchtheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bunchtheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bunchtheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bunchtheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bunch_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<?php // custom gravatar call ?>
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
				<?php // end custom gravatar call ?>
				<?php printf(__( '<cite class="fn">%s</cite>', 'bunchtheme' ), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bunchtheme' )); ?> </a></time>
				<?php edit_comment_link(__( '(Edit)', 'bunchtheme' ),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e( 'Your comment is awaiting moderation.', 'bunchtheme' ) ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bunch_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __( 'Search for:', 'bunchtheme' ) . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search the Site...', 'bunchtheme' ) . '" />
	<input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
	</form>';
	return $form;
} // don't remove this bracket!


/************* Get browser name and version ************/ 

function browser() {
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    // you can add different browsers with the same way ..
    if(preg_match('/(chromium)[ \/]([\w.]+)/', $ua))
            $browser = 'chromium';
    elseif(preg_match('/(chrome)[ \/]([\w.]+)/', $ua))
            $browser = 'chrome';
    elseif(preg_match('/(safari)[ \/]([\w.]+)/', $ua))
            $browser = 'safari';
    elseif(preg_match('/(opera)[ \/]([\w.]+)/', $ua))
            $browser = 'opera';
    elseif(preg_match('/(msie)[ \/]([\w.]+)/', $ua))
            $browser = 'msie';
    elseif(preg_match('/(mozilla)[ \/]([\w.]+)/', $ua))
            $browser = 'mozilla';

    preg_match('/('.$browser.')[ \/]([\w]+)/', $ua, $version);

    return array('name'=>$browser,'version'=>$version[2]);
}


?>
