<article <?php post_class('single-post'); ?> id="post-<?php the_ID(); ?>">
	<div class="headline">
		<h1><?php the_title(); ?></h1>
		<div class="meta">
			<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>" class="author"><?php echo get_author_name(get_the_author_ID()); ?></a>
			<time class="date" datetime="<?php the_time('Y-m-d') ?>T<?php the_time('g:i') ?>"> <?php the_time('F j, Y g:i a') ?></time>
			<?php $sponsor = get_field('sponsor_name', get_the_ID()); ?><?php if($sponsor): ?> <span class="sponsor"> | presented by <a href="<?php echo get_field('sponsor_link', get_the_ID()); ?>"><?php echo $sponsor; ?></a></span><?php endif; ?>
		</div>
	</div>
	
	<?php $video = get_field('video_top_art'); ?>
		<?php if($video): ?>
			<?php if (strpos($video,'youtube') !== false) : ?>
				<?php echo apply_filters('the_content', $video); ?>
			<?php elseif (strpos($video,'vemba') !== false) : ?>
				<?php echo htmlspecialchars_decode($video); ?>
			<?php elseif (strpos($video,'waywire') !== false) : ?>
				<script src='//decor.waywire.com/javascript/waywire_ref.js'></script>
				<iframe src="<?php echo htmlspecialchars_decode($video); ?>" frameborder="0" width="730" height="410" allowfullscreen></iframe>
			<?php else : ?>
			<div class="video-wrapper"><script type="text/javascript" src="http://content.jwplatform.com/players/<?php echo $video ?>-gdaXI0eR.js"></script></div>
			<?php endif; ?>
		<?php elseif (has_post_thumbnail()): ?>
			<div class="img-holder">
				<?php the_post_thumbnail('t_812x522'); ?>
				<?php
					$_sticker_field = get_field_object('_sticker');
					$_sticker_value = get_field('_sticker');
					$_sticker_label = $_sticker_field['choices'][$_sticker_value];
					if($_sticker_label): ?>
					<span class="single-label <?php echo $_sticker_value; ?>"><span><?php echo $_sticker_label; ?></span></span>
					<?php endif;
				?>
			</div>
			<em class="photo-credits"><?php $description = get_post(get_post_thumbnail_id(get_the_ID())); echo $description->post_content; ?></em>
		<?php endif; ?>
	<div class="soc-box">
		<ul class="social-networks">
			<li><a href="#" onclick="return soc('fb')" class="icon-facebook st_facebook_custom"></a></li>
			<li><a href="#" onclick="return soc('tw')" class="icon-twitter st_twitter_custom"></a></li>
			<li><a href="#" onclick="return soc('go')" class="icon-google st_googleplus_custom"></a></li>
			<li><a href="#" onclick="return soc('em')" class="icon-email st_email_custom"></a></li>
		</ul>
	</div>
	<div class="description">
		<?php htmlspecialchars_decode(the_content()); ?>
		<div class="soc-box">
			<ul class="social-networks">
				<li><a href="#" onclick="return soc('fb')" class="icon-facebook st_facebook_custom"></a></li>
				<li><a href="#" onclick="return soc('tw')" class="icon-twitter st_twitter_custom"></a></li>
				<li><a href="#" onclick="return soc('go')" class="icon-google st_googleplus_custom"></a></li>
				<li><a href="#" onclick="return soc('em')" class="icon-email st_email_custom"></a></li>
			</ul>
		</div>
	</div>
</article>
<?php  $url = $_SERVER['REQUEST_URI']; if (strpos($url,'ask-matt-quantico-gotham-big-bang')) { ?>
<div style="margin-top:20px">
	<script type="text/javascript" src="http://videos-by.vemba.io/v2/placements/623.js"></script>
</div>
<?php } ?> 	

<div id="disqus_thread"></div>
<script>
var disqus_config = function () {
this.page.url = '<?php echo get_permalink(); ?>'; 
this.page.identifier = '<?php the_ID(); ?>'; 
};
(function() { 
var d = document, s = d.createElement('script');
s.src = '//tvinsider.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
			

<?php if(function_exists('related_posts')) related_posts(); ?>


<?php if($_another_posts = get_field('_another_posts')): ?>
<div class="alike-box">
	<h2><?php _e('Also from the web', 'tvinsider'); ?></h2>
	<ul>
		<?php foreach($_another_posts as $_post): ?>
		<li>
			<?php if($_post['_image']): ?>
			<div class="img-holder">
				<?php if($_post['_url']): ?><a target="_blank" href="<?php echo $_post['_url']; ?>"><?php endif; ?>
				<img src="<?php echo $_post['_image']['sizes']['t_203x169']; ?>" height="169" width="203" alt="<?php echo $_post['_image']['title']; ?>">
				<?php if($_post['_url']): ?></a><?php endif; ?>
			</div>
			<?php endif; ?>
			<?php if($_post['_title']): ?>
				<h3>
					<?php if($_post['_url']): ?><a target="_blank" href="<?php echo $_post['_url']; ?>"><?php endif; ?>
					<?php echo apply_filters('the_title', $_post['_title']); ?>
					<?php if($_post['_url']): ?></a><?php endif; ?>
				</h3>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
<div id="_CI_widget_33627"></div>
<script type='text/javascript'>
(function() {
var script = document.createElement('script');
script.type = 'text/javascript';
script.src = 'http://widget.crowdignite.com/widgets/33627?v=2&_ci_wid=_CI_widget_33627';
script.async = true;
document.getElementsByTagName('head')[0].appendChild(script);
})();
</script>
<style>
#_ci_widget_div_33627:before {color:#000;content:'Also From The Web';display:block;font-family:Arial,sans-serif;font-size:16px;font-weight:400;line-height:1em;text-decoration:none;text-transform:none;font-family: 'Raleway';font-size: 30.0px;font-weight: bold;text-decoration: none;color: #383838;border-width: 0;border-style: none;padding: 0 0 6px 0;}
#_ci_widget_div_33627 {display:inline-block;height:auto;line-height:.8em;width:100%;}
#_ci_widget_div_33627 ul {-webkit-margin-after:0;-webkit-margin-before:0;-webkit-padding-start:0;display:inline-block;list-style-type:none;margin:0;padding:0;width:100%;}
#_ci_widget_div_33627 ul li {float:left;line-height:.8em;list-style-type:none;margin-left:;vertical-align:top;width: 31.33%;height: inherit;margin: 0 0 2% 2%;}
#_ci_widget_div_33627 ul li:first-child {}
#_ci_widget_div_33627 ul li > a img {display:block;height: inherit;width:100%;}
#_ci_widget_div_33627 .ci_text {display:block;height: 72px;margin-top: 10px;}
#_ci_widget_div_33627 .ci_text > a {color:#000;font-family:Arial;font-size:13px;font-weight:400;line-height:1.2em;text-decoration:none;font-family: playfair_displayregular;font-size: 18px;font-family: "Droid Serif", Georgia, serif;max-height: 66.0px;color: #383838;font-family: 'Raleway';font-size: 16.0px;line-height: 22.0px;font-weight: bold;}
#_ci_widget_div_33627 .ci_text > a:hover {text-decoration: underline;}
</style>


