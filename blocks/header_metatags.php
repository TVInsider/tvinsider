	<meta name="google-site-verification" content="it2r-MRipevefeCYWkPlW540pNwHDj9JpbST3-LAA-o" />
	<meta property="og:site_name" content="TV Insider" />
	
    <?php $url = $_SERVER['REQUEST_URI']; if (is_front_page()) { ?>
	<meta name="title" content="TV Insider" />
	<meta name="description" content="TV Insider is a celebration of the very best in television. We're a guide to what's worth watching — an all-access pass into your favorite shows." />
	<meta property="og:description" content="TV Insider is a celebration of the very best in television. We're a guide to what's worth watching — an all-access pass into your favorite shows">
	<meta property="og:url" content="<?php the_permalink(); ?>" />
	<meta property="og:title" content="TV Insider" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/TVi_Logo.jpg" />
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@tvinsider">
	<meta name="twitter:creator" content="@tvinsider">
	<meta name="twitter:title" content="TV Insider">
	<meta name="twitter:description" content="TV Insider is a celebration of the very best in television. We're a guide to what's worth watching — an all-access pass into your favorite shows">
	<meta name="twitter:image" content="<?php echo get_template_directory_uri(); ?>/images/TVi_Logo.jpg">
	<script>(function() {
	var _fbq = window._fbq || (window._fbq = []);
	if (!_fbq.loaded) { var fbds = document.createElement('script'); fbds.async = true; fbds.src = '//connect.facebook.net/en_US/fbds.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(fbds, s); _fbq.loaded = true; }
	_fbq.push(['addPixelId', '123781791287708']);
	})();
	window._fbq = window._fbq || [];
	window._fbq.push(['track', 'PixelInitialized', {}]);
	</script>
	<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=123781791287708&amp;ev=PixelInitialized" /></noscript>
	
	<?php } elseif (strpos($url,'/news')) { ?>
	<meta name="title" content="<?php single_cat_title('', true); ?> - TV Insider" />
	<meta name="description" content="TV Insider is a celebration of the very best in television. We're a guide to what's worth watching — an all-access pass into your favorite shows." />
	<meta property="og:description" content="TV Insider is a celebration of the very best in television. We're a guide to what's worth watching — an all-access pass into your favorite shows">
	<meta property="og:url" content="<?php echo get_site_url(); ?>/news/">
	<meta property="og:title" content="TV Insider - News" />
	<meta property="og:type" content="article:tag" />
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/TVi_Logo.jpg" />
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@tvinsider">
	<meta name="twitter:creator" content="@tvinsider">
	<meta name="twitter:title" content="TV Insider">
	<meta name="twitter:description" content="TV Insider is a celebration of the very best in television. We're a guide to what's worth watching — an all-access pass into your favorite shows">
	<meta name="twitter:image" content="<?php echo get_template_directory_uri(); ?>/images/TVi_Logo.jpg">
	
	<?php } elseif (is_author()) { ?>
	<?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); $this_author = get_the_author_meta('display_name',$curauth->ID);?>
	<meta name="title" content="<?php echo $this_author; ?>'s Articles" />
	<meta name="description" content="This is an archive of <?php echo $this_author; ?>'s articles on TV Insider." />
	<meta property="og:description" content="This is an archive of <?php echo $this_author; ?>'s articles on TV Insider." />
	<meta property="og:url" content="<?php echo get_author_posts_url(get_the_author_meta('ID',$curauth->ID));?>">
	<meta property="og:title" content="<?php echo $this_author; ?>'s Articles" />
	<meta property="og:type" content="profile" />
	<meta property="og:image" content="<?php echo get_wp_user_avatar_src($curauth->ID, 150); ?>" />
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@tvinsider">
	<meta name="twitter:creator" content="@tvinsider">
	<meta name="twitter:title" content="<?php echo $this_author; ?>'s Articles">
	<meta name="twitter:description" content="This is an archive of <?php echo $this_author; ?>'s articles on TV Insider.">
	<meta name="twitter:image" content="<?php echo get_wp_user_avatar_src($curauth->ID, 150); ?>">
	
	<?php } else { ?>
	<meta name="title" content="<?php the_title(); ?>" />
	<meta name="description" content="<?php $ex = get_field("facebook_description"); if($ex) {echo $ex;} else{ $ex = wp_strip_all_tags(get_the_excerpt()); if ($ex != "") {echo $ex;} else{ $ex = wp_strip_all_tags(substr($post->post_content, 0, 300))."..."; echo $ex; } }?>" />
	<meta property="og:description" content="<?php echo $ex; ?>" />
	<meta property="og:url" content="<?php the_permalink(); ?>">
	<meta property="og:title" content="<?php $ttl = str_replace("\"", "'", wp_strip_all_tags(get_the_title())); $ttl = str_replace(" | TV Insider", "", $ttl); echo $ttl; ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:image" content="<?php $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 't_812x522'); echo $thumbnail[0]; ?>" />
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@tvinsider">
	<meta name="twitter:creator" content="@tvinsider">
	<meta name="twitter:title" content="<?php echo $ttl; ?>">
	<meta name="twitter:description" content="<?php echo $ex; ?>">
	<meta name="twitter:image" content="<?php echo $thumbnail[0]; ?>">
	<?php } ?> 
