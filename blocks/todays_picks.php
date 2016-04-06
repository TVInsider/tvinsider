<?php
	$cur_package = null;
	if($_packages = get_field('_watching_packages')) {
		$cur_date = date('m/d/y g:i a', strtotime(date('m/d/y g:i a')) - 60 * 60 * 4);
		foreach($_packages as $_package) {
			if(floor(strtotime($cur_date) - strtotime($_package['_watching_published'])) > 0) {
				$cur_package = $_package;
				break;
			}
		}
	}
	if(!empty($cur_package) && !empty($cur_package['_watching_stories'])): ?>
	<section class="today-area">
		<?php if($_title = get_field('_watching_title')): ?>
		<h1><?php echo $_title; ?></h1>
		<?php endif; ?>
		<ul class="show-list">
			<?php foreach($cur_package['_watching_stories'] as $item): ?>
			<li>
				<article class="show">
					<?php if(has_post_thumbnail($item->ID)): ?>
					<div class="img-holder">
						<a href="<?php echo get_permalink($item->ID); ?>">
							<?php 
								if (MultiPostThumbnails::has_post_thumbnail(get_post_type($item->ID),'promo-small', $item->ID)) { 
									MultiPostThumbnails::the_post_thumbnail(get_post_type($item->ID),'promo-small', $item->ID, 't_330x240');
								} else { 
									echo get_the_post_thumbnail($item->ID, 't_330x240');
								}; 
							?>
						</a>
					</div>
					<?php endif; ?>
					<div class="text">
						<h2><a href="<?php echo get_permalink($item->ID); ?>"><?php $subhead = get_field('short_headline', $item->ID); if($subhead) {echo $subhead;} else {echo get_the_title($item->ID);}?></a></h2>
						<?php if($item->post_excerpt) echo apply_filters('the_excerpt', $item->post_excerpt); ?>
					</div>
					<div class="editor">
						<a href="<?php echo get_author_posts_url($item->post_author); ?>" class="name"><?php echo get_author_name($item->post_author); ?></a>
						<a href="<?php echo get_author_posts_url($item->post_author); ?>" class="photo"><?php echo get_avatar($item->post_author, 150); ?></a>
					</div>
				</article>
			</li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php endif;
?>