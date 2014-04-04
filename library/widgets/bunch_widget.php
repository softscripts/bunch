<?php add_action( 'widgets_init', 'bunch_widget' );
function bunch_widget() {
	register_widget( 'bunch_widget' );
}
/* Handler class for all widget params */
class bunch_widget extends WP_Widget {
	/* Widget setup. */
	function bunch_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'bunch_widget', 'description' => __('A widget for showing text .', 'bunchtheme') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bunch_widget_details' );
		/* Create the widget. */
		$this->WP_Widget( 'videos-details', __('Bench Text widget'), $widget_ops, $control_ops );
	}
	/** Widget display template */
	function widget( $args, $instance ) {
		extract( $args );
		/* Get widget settings */
                
		$title = $instance['title'];
		$content = $instance['content'];
		echo $before_widget;

		if($title) { echo $before_title.$title.$after_title; }
?>
		
	<div class="widget_content">
		<?php echo apply_filters('the_content',$content); ?>
	</div>

   <?php
		$after_widget;
		}

	/* Update widget settings. */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Create widget settings instances. */
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['content'] = strip_tags($new_instance['content']);
		
		return $instance;
	}

	/* Admin panel form  */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance ); ?>

	
<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title: '); ?></label><br />
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php if ( isset($instance['title']) ) echo $instance['title']; ?>" />
		</p> 

	
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('Content: '); ?></label><br />
			<textarea id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>"><?php if ( isset($instance['content']) ) echo $instance['content']; ?></textarea>
		</p> 

	<?php
	}
}
?>
