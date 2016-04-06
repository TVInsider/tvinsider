<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="dns-prefetch" href="//ajax.googleapis.com" />
	<link rel="alternate" type="application/rss+xml" title="TV Insider" href="<?php bloginfo('rss2_url'); ?>" />
	<link href='//fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic%7COswald:400,700%7COpen+Sans:400,400italic,600italic,600,700,700italic%7CRaleway:400,500,600,700' rel='stylesheet' type='text/css'>
	<?php wp_head(); ?>
	<?php get_template_part('blocks/header_metatags'); ?>
	<?php get_template_part('blocks/header_adtags'); ?>
</head>
<script type='text/javascript'>
(function(){
  var spoutjs=document.createElement('script'),firstjs=document.getElementsByTagName('script')[0];
  spoutjs.async=1;
  spoutjs.src='//cdn.spoutable.com/3a536888-9feb-424c-8470-027f5ba3c020/spoutable.js';
  firstjs.parentNode.insertBefore(spoutjs,firstjs)
})();
</script>
<body <?php body_class(); ?>>
<script type='text/javascript'>var _sf_startpt=(new Date()).getTime()</script>
<script>
var MeasureAdblock = (function() {
  var init = function() {
    document.write('<div id="adsense" style="visibility:hidden;">adsense ad</div>');
    var detect = function() {
      setTimeout(function() {
        var detected = 'No';
        var elt = document.getElementById('adsense');
        if( ! elt || elt.innerHTML.length === 0 || elt.clientHeight === 0 ) {
          detected = 'Yes';
        }
        elt.style.display = 'none';
        if(typeof ga === "function") {
          ga('send', 'event', 'AdBlock', detected);
        }
        else if(typeof _gaq != "undefined") {
          _gaq.push(['_trackEvent', 'AdBlock', detected]);
        }
      }, 2000);
    };
    if(window.addEventListener) {
        window.addEventListener('load', detect, false);
    } else {
        window.attachEvent('onload', detect);
    }
  };
  return {
    init: init
  };
})();
MeasureAdblock.init();
</script>


<!-- /173750744/Skin -->
<div id='div-gpt-ad-Skin'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-Skin'); });
</script>
</div>

<!-- /173750744/Interstitial -->
<div id='div-gpt-ad-Interstitial'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-Interstitial'); });
</script>
</div>

<?php  $url = $_SERVER['REQUEST_URI']; if (strpos($url,'/whats-worth-watching') || strpos($url,'ask-matt')  || strpos($url,'author/matt-roush')) { ?>
<script>var instl = true; </script>
<div id="lightbox">
	<div style="top: 199.5px; left: 551.5px; display: none;" id="dialog" class="window">
		<a id="close-box" href="#"><img src="http://www.tvinsider.com/wp-content/themes/tvinsider/images/lightbox-close.png" width="29" height="16" /></a>
		<p><img src="http://tvinsider.com/wp-content/themes/tvinsider/images/whats_worth_watching_small_light.png" width="170" height="124" /></p>
		<h3>In Your Inbox Every Week</h3>
		<p class="tease">Too much to watch? Matt Roush simplifies your options with his picks for the day's best TV.</p>
		<div id="mc_embed_signup">
			<form action="http://tvinsider.us10.list-manage.com/subscribe/post?u=a35d27604ff7f9b1358c4e8d7&amp;id=3576f8ead4" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			    <div id="mc_embed_signup_scroll">
					<div class="mc-field-group">
					    <div style="position: absolute; left: -5000px;"><input type="text" name="b_a35d27604ff7f9b1358c4e8d7_3576f8ead4" tabindex="-1" value=""></div>
						<input type="email" value="" placeholder="email address" name="EMAIL" class="required email" id="mce-EMAIL">
					    <input type="hidden" value="1" name="group[29][1]" id="mce-group[29]-29-0">
					    <input type="hidden" name="SLOC" value="lightbox-promo-www">
						<input type="hidden" name="SURL" value="http://<?php echo $_SERVER[HTTP_HOST]; echo $_SERVER[REQUEST_URI];?>">
						<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
					</div>
			    </div>
			</form>
		</div>
		<p><img src="http://www.tvinsider.com/wp-content/themes/tvinsider/images/logo-small.png" width="183" height="34" /></p>
	</div>
</div>
<div id="mask" style="width: 1478px; font-size: 32pt; color:white; height: 602px; display: none; opacity: 0.8;"></div>
<?php } ?> 	
<div id="wrapper"<?php if(is_singular('binge-guide')) echo ' class="guide-page"'; ?>>
	<header id="header">
		<div class="container">
			<div class="logo"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" width="223" height="43"></a>
			<span>from the editors of <em><a href="http://www.tvguidemagazine.com/">TV Guide Magazine</a></em></span></div>
			<div class="frame">
				<nav id="nav">
					<div class="btn-box">
						<a href="#" class="nav-opener"><span></span></a>
						<a href="#" class="open-search icon-search"></a>
					</div>
					<?php
						if(has_nav_menu('primary'))
							wp_nav_menu(array(
								'theme_location' => 'primary',
								'container' => 'div',
								'container_class' => 'drop-menu',
								'walker' => new Custom_Walker_Nav_Menu,
							));
					?>
				</nav>
				<div class="search-popup">
					<a href="#" class="open-search icon-search"></a>
					<?php get_search_form(); ?>
					<?php if(get_field('_social_networks', 'option')): ?>
					<ul class="social-networks">
						<?php while(has_sub_field('_social_networks', 'option')): ?>
						<li><a target="_blank" href="<?php the_sub_field('_url', 'option'); ?>" class="icon-<?php the_sub_field('_social_network', 'option'); ?>"></a></li>
						<?php endwhile; ?>
					</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</header>
	<main role="main" id="main">
		<?php get_template_part('blocks/ad_top'); ?>
		<?php if(is_page()) : ?>
			<?php if(get_field('_custom_banner')): ?>
				<div id="custom-banner"><img src="<?php echo get_field('_custom_banner'); ?>" /></div>
			<?php endif; ?>
		<?php endif; ?>
		<div class="container">
			<div class="m1">