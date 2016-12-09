<?php


if ( ! class_exists('PostType_Taxonomy_Widget') ) :
class PostType_Taxonomy_Widget extends WP_Widget_Recent_Posts {
	
	function __construct() {
		WP_Widget::__construct('post_type_taxonomy_widget',__('PostTypes by Term','mu-plugins'));
	}
	
	function form($instance) {
		// title
		// select Taxonomy
		// select Terms

		parent::form( $instance );

		// select PostType
		$post_type  = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : 'post';
		$post_types = get_post_types(array('public' => true),'objects');
?>
		<p><label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post Type:' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>"><?php
		foreach ( $post_types as $type => $pt_object ) {
			?><option <?php selected($type,$post_type,true); ?> value="<?php echo $type ?>"><?php echo $pt_object->labels->name ?></option><?php
		}
		?></select>
		</p>
<?php 
		
		
		

		$taxonomy  = isset( $instance['taxonomy'] ) ? esc_attr( $instance['taxonomy'] ) : '';
		$taxonomies = get_taxonomies(array(
			'object_type' => array($post_type),
		),'object');
		
?>
		<p><label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Taxonomy:' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>"><?php
		foreach ( $taxonomies as $tax => $tax_object ) {
			?><option <?php selected($type,$taxonomy,true); ?> value="<?php echo $tax ?>"><?php echo $tax_object->labels->name ?></option><?php
		}
		?></select>
		</p>
<?php 
		
		if ( ! empty( $taxonomy ) && taxonomy_exists($taxonomy) ) {
			$tax_object = get_taxonomy($taxonomy);
			$term = isset( $instance['term'] ) ? intval( $instance['term'] ) : '';
			$terms = get_terms(array($taxonomy),array('orderby'=>'name','hide_empty'=>false));

?>
			<p><label for="<?php echo $this->get_field_id( 'term' ); ?>"><?php $tax_object->labels->singular_name; ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'term' ); ?>" name="<?php echo $this->get_field_name( 'term' ); ?>"><?php
			foreach ( $terms as $term_object ) {
				?><option <?php selected($term,$term_object->term_id,true); ?> value="<?php echo $term_object->term_id ?>"><?php echo $term_object->name ?></option><?php
			}
			?></select>
			</p>

<?php 
			
		}

		
		$show_archive_link = isset( $instance['show_archive_link'] ) ? boolval( $instance['show_archive_link'] ) : true;

?>
			<p><input class="checkbox" type="checkbox"<?php checked( $show_archive_link ); ?> id="<?php echo $this->get_field_id( 'show_archive_link' ); ?>" name="<?php echo $this->get_field_name( 'show_archive_link' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_archive_link' ); ?>"><?php _e( 'Show Archive Link' ); ?></label></p>
<?php

	}
	
	function _query_posts_args( $args ) {
		
		$args['post_type'] = $this->current_instance['post_type'];
		$args['tax_query'] = array(
			array(
				'taxonomy'	=> $this->current_instance['taxonomy'],
				'field'		=> 'term_id',
				'terms'		=> $this->current_instance['term'],
			),
		);
		
		return $args;
	}
	function _widget_title( $title ) {
		return $title;
		return sprintf( '<a href="%s">%s</a>', $link, $title );
	}
	function widget($args,$instance) {
		$this->args = $args;
		$this->current_instance = $instance;
		
		if ( $instance['show_archive_link'] ) {
			$link = get_post_type_term_link($instance['post_type'], intval($instance['term']), $instance['taxonomy'] );
			$args['before_title'] .= sprintf( '<a href="%s">', $link );
			$args['after_title'] = '</a>' . $args['after_title'];
		}
		
		
		add_filter('widget_posts_args',array(&$this,'_query_posts_args'));
		$ret = parent::widget($args,$instance);
		remove_filter('widget_posts_args',array(&$this,'_query_posts_args'));

		return $ret;
	}
	function update( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );

		$post_types = get_post_types(array('public' => true),'names');
		if ( in_array($new_instance['post_type'], $post_types) )
			$instance['post_type'] = $new_instance['post_type'];
		if ( taxonomy_exists($new_instance['taxonomy'] ) )
			$instance['taxonomy'] = $new_instance['taxonomy'];
		if ( get_term($new_instance['term'],$new_instance['taxonomy'] ) )
			$instance['term'] = $new_instance['term'];
		$instance['show_archive_link'] = boolval($new_instance['show_archive_link']);
		return $instance;
	}
	
}

endif;