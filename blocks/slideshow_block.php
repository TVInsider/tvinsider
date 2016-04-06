<?php if( have_rows('slideshow') ): ?>
<div class="main-slideshow">
	<div class="mask">
		<div id="slideset" class="slideset">
		<?php while( have_rows('slideshow') ): the_row(); 
			$image = get_sub_field('slideshow-image');
			$image_slide = $image['sizes']['t_727x530'];
			$content = get_sub_field('slideshow-caption');
			?>
			<div class="slide">
				<div class="slide-frame">
					<ul class="social-networks" style="position: absolute; top: 10px; z-index: 9999; left: -10px;">
						<!-- //instagram.com/developer/endpoints/media/ -->
						<li><a href="http://www.facebook.com/sharer.php?u=<?php echo $image_slide; ?>" onclick="return share('fb')" class="icon-facebook st_facebook_custom"></a></li>
						<li><a href="http://www.facebook.com/sharer.php?u=<?php echo $image_slide; ?>" class="icon-twitter st_twitter_custom"></a></li>
						<li><a href="https://www.pinterest.com/pin/create/button/?url=http://www.tvinsider.com/comiccon/&media=<?php echo $image_slide; ?>&description=<?php echo $content; ?>" data-pin-do="buttonPin" data-pin-config="above"></a></li>
					</ul>
					<div class="img-holder">
						<img width="727" src="<?php echo $image_slide; ?>" alt="<?php echo $image['alt']; ?>">
					</div>
					<div class="text">
						<p class="wp-credit-text"><?php echo $image['description']; ?></p>
						<p class="wp-caption-text"><?php echo get_attachment_link($image['id']); ?> | <?php echo "http://www.tvinsider.com/?attachment_id=".$image['id']; ?></p>
						<p class="wp-caption-text"><?php echo $content; ?></p>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		</div>
	</div>
	<a class="btn-prev" href="#">&lt;</a>
	<a class="btn-next" href="#">&gt;</a>
	<div class="pagination">
		<!-- pagination generated here -->
	</div>
</div>
<?php endif; ?>

