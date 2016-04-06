<?php

// Custom Text Widget without <div>
class Custom_Widget_Text extends WP_Widget {

	function Custom_Widget_Text() {
		$widget_ops = array(
				'classname'   => 'widget_text',
				'description' => __( 'Arbitrary text or HTML', 'tvinsider' ),
				);
		$control_ops = array(
				'width'  => 400,
				'height' => 350,
				);
		$this->WP_Widget( 'text', __( 'Text', 'tvinsider' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title	= apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base );
		$text	= apply_filters( 'widget_text', $instance['text'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}
		echo $instance['filter'] ? wpautop($text) : $text;
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset( $new_instance['filter'] );

		//replace site-url by shortcodes
		$instance['text'] = str_replace( get_template_directory_uri(), '[template-url]', $instance['text'] );
		$instance['text'] = str_replace( home_url(), '[site-url]', $instance['text'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title    = strip_tags( $instance['title'] );
		$text     = esc_textarea( $instance['text'] );
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tvinsider' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id( 'filter' ); ?>" name="<?php echo $this->get_field_name( 'filter' ); ?>" type="checkbox" <?php checked( isset( $instance['filter'] ) ? $instance['filter'] : 0 ); ?> />&nbsp;<label for="<?php echo $this->get_field_id( 'filter' ); ?>"><?php _e( 'Automatically add paragraphs', 'tvinsider' ); ?></label></p>
<?php
	}
}

add_action( 'widgets_init', create_function( '', 'unregister_widget( "WP_Widget_Text" ); return register_widget( "Custom_Widget_Text" );' ) );


class wtw_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
		'wtw_widget', 
		__('Where To Watch', 'where_to_watch_widget'), 
		array( 'description' => __( 'For displaying where to watch', 'where_to_watch_widget' ), ) 
		);
	}
	public function widget( $args, $instance ) {
		$the_shows = get_the_terms(get_the_id(), 'show'); if (($the_shows) & is_single()) { ?>
			<div class="chanel-info">
			<h2><?php _e('Where to Watch', 'tvinsider'); ?></h2>
			<?php foreach( $the_shows as $term ) { ?>
				<strong><?php echo $term->name; ?></strong>
				<?php 
					$rows = get_field('where_to_watch', 'show_'.$term->term_id);
					if($rows) {
						foreach($rows as $row) {
							echo '<a target="_blank" href="'.$row['link'].'" class="btn">'.$row['network'].'</a>';
						}
					};
				?>
			<?php }; ?> 
			</div>
		<?php };
	}
			
} 
function wpb_load_widget() {
	register_widget( 'wtw_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );


//Custom widget Recent Posts From Specific Category
class Widget_Recent_Posts_From_Category extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname' => 'widget_recent_entries_from_category',
			'description' => __( 'The most recent posts from specific category on your site', 'tvinsider' ),
		);
		parent::__construct( 'recent-posts-from-category', __( 'Recent Posts From Specific Category', 'tvinsider' ), $widget_ops );
		$this->alt_option_name = 'widget_recent_entries_from_category';
		
		add_action( 'save_post',    array( &$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
	}

	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_recent_posts_from_category', 'widget' );
		
		if ( !is_array( $cache ) )
			$cache = array();
		
		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}
		
		ob_start();
		extract( $args );
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Latest News', 'tvinsider' ) : $instance['title'], $instance, $this->id_base );
		if ( ! $number = absint( $instance['number'] ) )
			$number = 7;
		
		$_latest_news = get_field('_latest_news');
		$_excluded = array();
		foreach($_latest_news as $_items) {
			$_excluded[] = $_items->ID;
		}
		$r = new WP_Query( array(
				'post_type' 		  => array('post', 'gallery'),
				'posts_per_page'      => 5,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'cat'                 => $instance['cat'],
				'post__not_in'        => $_excluded
			)
		);
		if ( $r->have_posts() ) :
		?>
		<?php echo $before_widget; ?>
		<?php echo '<div class="latest-news">'; ?>
		<?php if ( $title ) echo $before_title .'<a href="'. get_permalink(get_option('page_for_posts')) .'">'. $title .'</a>'. $after_title; ?>
			<?php if($_latest_news): ?>
				<?php $v = 0; foreach($_latest_news as $_item): ?>
				<?php if(($v == 0) && (get_post_status($_item->ID) == 'publish')): ?>
				<article class="article single">
					<a href="<?php echo get_permalink($_item->ID);  ?>">
						<?php if(has_post_thumbnail($_item->ID)): ?>
						<div class="img-holder">
							<?php 
								if (MultiPostThumbnails::has_post_thumbnail(get_post_type($_item->ID),'promo-small', $_item->ID)) { 
									MultiPostThumbnails::the_post_thumbnail(get_post_type($_item->ID),'promo-small', $_item->ID, 't_314x228');
								} else { 
									echo get_the_post_thumbnail($_item->ID, 't_314x228');
								}; 
							?>
						</div>
						<?php endif; ?>
						<div class="text">
							<strong><?php echo get_the_title($_item->ID); ?></strong>
							<div class="meta">
								<span class="author"><?php echo get_author_name($_item->post_author); ?></span>
								<time class="date" datetime="<?php echo get_the_time('Y-m-d', $_item->ID) ?>T<?php echo get_the_time('g:i', $_item->ID) ?>"><?php echo get_the_time('F j, Y g:ia', $_item->ID) ?></time>
							</div>
						</div>
					</a>
				</article>
				<?php else : ?>
				<?php if(get_post_status($_item->ID) == 'publish'): ?>
				<ul>
				<li>
					<article class="article">
						<strong class="title"><a href="<?php echo get_permalink($_item->ID); ?>"><?php echo get_the_title($_item->ID); ?></a></strong>
						<div class="meta">
							<a href="<?php echo get_author_posts_url($_item->post_author); ?>" class="author"><?php echo get_author_name($_item->post_author); ?></a>
							<time class="date" datetime="<?php echo get_the_time('Y-m-d', $_item->ID) ?>T<?php echo get_the_time('g:i', $_item->ID) ?>"><?php echo get_the_time('F j, Y g:ia', $_item->ID) ?></time>
						</div>
					</article>
				</li>
				</ul>
				<?php else : ?>
				<?php $v--; endif; ?>
				<?php endif; ?>
				<?php $v++; endforeach; ?>
			<?php endif; ?>
			<ul>
				<?php  while ( $r->have_posts() ) : $r->the_post(); ?>
				<?php if($v < 5): ?>

				<?php if($v == 0): ?>
				<article class="article single">
					<a href="<?php echo get_permalink(); ?>">
						<?php if(has_post_thumbnail()): ?>
						<div class="img-holder">
							<?php 
								if (MultiPostThumbnails::has_post_thumbnail(get_post_type(get_the_ID()),'promo-small', get_the_ID())) { 
									MultiPostThumbnails::the_post_thumbnail(get_post_type(get_the_ID()),'promo-small', get_the_ID(), 't_314x228');
								} else { 
									echo get_the_post_thumbnail(get_the_ID(), 't_314x228');
								}; 
							?>
						</div>
						<?php endif; ?>
						<div class="text">
							<strong><?php echo get_the_title(); ?></strong>
							<div class="meta">
								<span class="author"><?php echo get_author_name(); ?></span>
								<time class="date" datetime="<?php echo get_the_time('Y-m-d') ?>T<?php echo get_the_time('g:i') ?>"><?php echo get_the_time('F j, Y g:ia') ?></time>
							</div>
						</div>
					</a>
				</article>
				<?php else : ?>
				<?php $sticker = get_field('_sticker', get_the_ID()); ?>
				<li>
					<article class="article">
						<strong class="title"><?php if($sticker): ?><div class="label <?php echo $sticker; ?>"><?php echo $sticker; ?></div><?php endif; ?><a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></strong>
						<div class="meta">
							<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="author"><?php echo get_author_name(get_the_author_ID()); ?></a>
							<time class="date" datetime="<?php the_time('Y-m-d') ?>T<?php the_time('g:i') ?>"><?php the_time('F j, Y g:ia') ?></time>
						</div>
					</article>
				</li>
				<?php endif; ?>
				<?php $v++; endif; ?>
				<?php endwhile; ?>
			</ul>
		</div>
		<div class="btn-holder">
			<a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn-more"><?php _e('see more', 'tvinsider'); ?></a>
		</div>
		<?php echo $after_widget; ?>
		<?php
		wp_reset_postdata();
		
		endif;
		
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_recent_posts_from_category', $cache, 'widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance           = $old_instance;
		$instance['title']  = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['cat']    = (int) $new_instance['cat'];
		$this->flush_widget_cache();
		
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_recent_entries_from_category'] ) )
			delete_option( 'widget_recent_entries_from_category' );
		
		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_recent_posts_from_category', 'widget' );
	}

	function form( $instance ) {
		$title	= isset( $instance['title'] )  ? esc_attr( $instance['title'] ) : '';
		$number	= isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
		$cat	= isset( $instance['cat'] )    ? $instance['cat'] : 0;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tvinsider' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
		<p>
		<label>
		<?php _e( 'Category', 'tvinsider' ); ?>:
		<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat"), 'selected' => $cat ) ); ?>
		</label>
		</p>
		
		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'tvinsider' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		<?php
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "Widget_Recent_Posts_From_Category" );' ) );

//Custom widget Recent Posts From Specific Category (Carousel)
class Widget_Carousel_Recent_Posts_From_Category extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname' => 'widget_recent_entries_from_category watching-box',
			'description' => __( 'The most recent posts from specific category on your site', 'tvinsider' ),
		);
		parent::__construct( 'carousel-recent-posts-from-category', __( 'Recent Posts From Specific Category (Carousel)', 'tvinsider' ), $widget_ops );
		$this->alt_option_name = 'widget_carousel_recent_entries_from_category';
		
		add_action( 'save_post',    array( &$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
	}

	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_carousel_recent_entries_from_category', 'widget' );
		
		if ( !is_array( $cache ) )
			$cache = array();
		
		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}
		
		ob_start();
		extract( $args );
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Latest News', 'tvinsider' ) : $instance['title'], $instance, $this->id_base );
		if ( ! $number = absint( $instance['number'] ) )
			$number = 4;
		
		$r = new WP_Query( array(
				'posts_per_page'      => $number,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'cat'                 => $instance['cat'],
			)
		);
		if ( $r->have_posts() ) : ?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<div class="aside-carousel">
			<div class="mask">
				<div class="slideset">
					<?php  while ( $r->have_posts() ) : $r->the_post(); ?>
					<div class="slide">
						<?php if(has_post_thumbnail()): ?>
						<div class="img-holder">
							<?php if ( MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'promo-small') ) { ?>
								<a href="<?php the_permalink() ?>"><?php MultiPostThumbnails::the_post_thumbnail(get_post_type(),'promo-small', get_the_ID(), 't_314x228');?>
					    	<?php } elseif(has_post_thumbnail()) { ?>
								<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('t_314x228');  ?></a>
					    	<?php }; ?>
						</div>
						<?php endif; ?>
						<div class="text">
							<h3><a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h3>
							<?php the_excerpt(); ?>
							<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="author"><?php echo get_author_name(get_the_author_ID()); ?></a>
							<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="editor"><?php echo get_avatar(get_the_author_ID(), 150); ?></a>
						</div>
					</div>
					<?php endwhile; ?>
				</div>
			</div>
			<div class="pagination">
				<!-- pagination generated here -->
			</div>
		</div>
		<?php echo $after_widget; ?>
		<?php
		wp_reset_postdata();
		
		endif;
		
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_carousel_recent_entries_from_category', $cache, 'widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance           = $old_instance;
		$instance['title']  = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['cat']    = (int) $new_instance['cat'];
		$this->flush_widget_cache();
		
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_carousel_recent_entries_from_category'] ) )
			delete_option( 'widget_carousel_recent_entries_from_category' );
		
		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_carousel_recent_entries_from_category', 'widget' );
	}

	function form( $instance ) {
		$title	= isset( $instance['title'] )  ? esc_attr( $instance['title'] ) : '';
		$number	= isset( $instance['number'] ) ? absint( $instance['number'] ) : 4;
		$cat	= isset( $instance['cat'] )    ? $instance['cat'] : 0;
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tvinsider' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
		<p>
		<label>
		<?php _e( 'Category', 'tvinsider' ); ?>:
		<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat"), 'selected' => $cat ) ); ?>
		</label>
		</p>
		
		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'tvinsider' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		<?php
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "Widget_Carousel_Recent_Posts_From_Category" );' ) );

//Custom widget Recent Posts From Playlists (Carousel)
class Widget_Carousel_Recent_Posts_From_Playlists extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname' => 'widget_recent_entries_from_category related-playlists',
			'description' => __( 'The most recent posts from playlists on your site', 'tvinsider' ),
		);
		parent::__construct( 'carousel-recent-posts-from-playlists', __( 'Recent Posts From Playlists (Carousel)', 'tvinsider' ), $widget_ops );
		$this->alt_option_name = 'widget_carousel_recent_entries_from_playlists';
		
		add_action( 'save_post',    array( &$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
	}

	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_carousel_recent_entries_from_playlists', 'widget' );
		
		if ( !is_array( $cache ) )
			$cache = array();
		
		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}
		
		ob_start();
		extract( $args );
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Related Playlists', 'tvinsider' ) : $instance['title'], $instance, $this->id_base );
		
		if($_related_playlists = get_field('_related_playlists')) : ?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo '<h2 class="related-playlist-txt">' . $title . '</h2>'; ?>
		<div class="aside-carousel">
			<div class="mask">
				<div class="slideset">
					<?php $i = 0; foreach($_related_playlists as $_post): ?>
					<div class="slide">
						<?php if(has_post_thumbnail($_post->ID)): ?>
						<div class="img-holder">
							<a href="<?php echo get_permalink($_post->ID) ?>"><?php echo get_the_post_thumbnail($_post->ID, 't_314x228'); ?></a>
						</div>
						<?php endif; ?>
						<div class="text">
							<h3><a href="<?php echo get_permalink($_post->ID) ?>"><?php echo get_the_title($_post->ID); ?></a></h3>
							<a href="<?php echo get_author_posts_url($_post->post_author); ?>" class="author"><?php echo get_author_name($_post->post_author); ?></a>
							<?php
								if($_post->post_excerpt) echo apply_filters('the_excerpt', $_post->post_excerpt);
								elseif($_post->post_content) echo apply_filters('the_excerpt', string_limit_words($_post->post_content, 18));
							?>
						</div>
					</div>
					<?php $i++; endforeach; ?>
				</div>
			</div>
			<?php if($i > 1): ?>
			<a class="btn-prev icon-arrow-left" href="#"></a>
			<a class="btn-next icon-arrow-right" href="#"></a>
			<div class="pagination">
				<!-- pagination generated here -->
			</div>
			<?php endif; ?>
		</div>
		<?php echo $after_widget; ?>
		<?php
		wp_reset_postdata();
		
		endif;
		
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_carousel_recent_entries_from_playlists', $cache, 'widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance           = $old_instance;
		$instance['title']  = strip_tags( $new_instance['title'] );
		$this->flush_widget_cache();
		
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_carousel_recent_entries_from_playlists'] ) )
			delete_option( 'widget_carousel_recent_entries_from_playlists' );
		
		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_carousel_recent_entries_from_playlists', 'widget' );
	}

	function form( $instance ) {
		$title	= isset( $instance['title'] )  ? esc_attr( $instance['title'] ) : ''; ?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tvinsider' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
	<?php }
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "Widget_Carousel_Recent_Posts_From_Playlists" );' ) );


