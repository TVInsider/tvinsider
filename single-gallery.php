<?php get_header(); ?>
<?php if(have_posts()) : the_post(); ?>
<div class="twocolumns">
	<div id="content">
		<article class="single-post">
			<div class="headline">
				<h1><?php the_title(); ?></h1>
				<div class="meta">
					<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="author"><?php echo get_author_name(get_the_author_ID()); ?></a>
					<time class="date" datetime="<?php the_time('Y-m-d') ?>T<?php the_time('g:i') ?>"> <?php the_time('F j, Y g:i a') ?></time>
					<?php $sponsor = get_field('sponsor_name', get_the_ID()); ?><?php if($sponsor): ?> <span class="sponsor"> | presented by <a href="<?php echo get_field('sponsor_link', get_the_ID()); ?>"><?php echo $sponsor; ?></a></span><?php endif; ?>
				</div>
			</div>
			<div class="main-slideshow">
				<div class="mask">
					<div id="slideset" class="slideset">
						<?php $images = get_field('gallery'); if( $images ): ?>
						    <?php $x = 0; foreach( $images as $image ): ?>
								<div class="slide">
									<div class="slide-frame">
										<ul class="social-networks" style="position: absolute; top: 10px; z-index: 9999; left: -10px;">
											<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $image['url']; ?>" class="icon-facebook"></a></li>
											<li><a target="_blank" href="http://twitter.com/share?url=<?php the_permalink() ?>&text=<?php echo str_replace('"', '', get_the_title()); ?> @tvinsider" class="icon-twitter"></a></li>
											<li><a target="_blank" href="https://www.pinterest.com/pin/create/button/?url=http://www.tvinsider.com/comiccon/&media=<?php echo $image['url']; ?>&description=<?php echo $image['caption']; ?>" data-pin-do="buttonPin" data-pin-config="above" class="icon-pinterest"></a></li>
											<li><a target="_blank" href="https://www.tumblr.com/widgets/share/tool?shareSource=legacy&canonicalUrl=<?php the_permalink() ?>&url=&posttype=photo&content=<?php echo $image['url']; ?>&caption=<?php echo $image['caption']; ?>&clickthroughUrl=<?php the_permalink() ?>" class="icon-tumblr"></a></li>
										</ul>
										<div class="img-holder">
											<img width="727" src="<?php echo $image['sizes']['t_727x530']; ?>" alt="<?php echo $image['alt']; ?>" />
										</div>
										<div class="text">
											<p class="wp-credit-text"><?php echo $image['description']; ?></p>
											<p class="wp-caption-text"><?php $image_ids = get_field('gallery', false, false); echo get_field('_gallery_caption',$image_ids[$x]); ?></p>
										</div>
									</div>
								</div>
						    <?php $x++; endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
				<a class="btn-prev" href="#">&lt;</a> <a class="btn-next" href="#">&gt;</a>
				<div class="pagination"><!-- pagination generated here --></div>
			</div>
			<div class="description">
				<?php the_content(); ?>
			</div>
		</article>
		<?php if(function_exists('related_posts')): ?>
		<div class="related-box">
			<?php related_posts(); ?>
		</div>
		<?php endif; ?>
		<section class="bottom-section">
			<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
			<!-- /173750744/ROS_Mobile_300x250 -->
			<div id='div-gpt-ad-ros_mobile_300x250'>
			<script type='text/javascript'>googletag.cmd.push(function() { googletag.display('div-gpt-ad-ros_mobile_300x250'); });</script>
		</section>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php endif; ?>
<?php get_footer(); ?>





