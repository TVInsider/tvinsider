<?php
	global $_count;
	$_flag = false;
	$_thumbnail = 't_314x228';
	
	$_paged = get_query_var('vpaged');
	if(!$_paged && isset($_GET['vpaged'])) $_paged = $_GET['vpaged'];
	if(!$_paged) $_paged = 1;
	
	$_inc = ++$_count + (($_paged - 1) * get_option('posts_per_page'));
	if(!($_inc % 5)) {
		$_flag = true;
		$_thumbnail = 't_314x228';
	}
?>
<li>
	<?php $field = get_field_object('_sticker', get_the_ID()); $value = get_field('_sticker', get_the_ID()); $sticker = $field['choices'][ $value ]; ?>
	<article <?php post_class('article'); ?> id="post-<?php the_ID(); ?>">
		<?php if ( MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'promo-small') ) { ?>
			<div class="img-holder"><a href="<?php the_permalink() ?>"><?php MultiPostThumbnails::the_post_thumbnail(get_post_type(),'promo-small', get_the_ID(), $_thumbnail);?></div>
    	<?php } elseif(has_post_thumbnail()) { ?>
			<div class="img-holder"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail($_thumbnail);  ?></a></div>
    	<?php }; ?>
		<strong class="title"><?php if($sticker): ?><div class="label <?php echo $value; ?>"><?php echo $sticker; ?></div><?php endif; ?></strong>
		<div class="text-holder">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php $subhead = get_field('short_headline', $item->ID); if($subhead) {echo $subhead;} else {echo get_the_title($item->ID);}?></a></h2>
			<div class="meta">
				<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="author"><?php echo get_author_name(get_the_author_ID()); ?></a>
				<time class="date" datetime="<?php the_time('Y-m-d') ?>T<?php the_time('g:i') ?>"> <?php the_time('F j, Y g:i a') ?></time>
			</div>
		</div>
	</article>
</li>