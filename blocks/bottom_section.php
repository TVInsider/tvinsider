<?php
	$_advertisment = null;
	if($_advertisments = get_field('_advertisments')) {
		$_advertisment = $_advertisments[rand(0, count($_advertisments)-1)];
	}
	if(!empty($_advertisment) || is_active_sidebar('bottom1-sidebar') || is_active_sidebar('bottom2-sidebar') || is_active_sidebar('bottom3-sidebar')): ?>
	<section class="bottom-section">
		<?php if(!empty($_advertisment)): ?>
		<div class="banner-holder">
			<div class="bottom-banner">
				<div class="holder">
					<!-- ROS_Desktop_Lower_728x90 -->
					<div class='dfp_ad_div' id='div-gpt-ad-1430489157041-8' style='text-align: center;'>
					<script type='text/javascript'>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1430489157041-8'); });
					</script>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php if(is_active_sidebar('bottom1-sidebar') || is_active_sidebar('bottom2-sidebar') || is_active_sidebar('bottom3-sidebar')): ?>
		<div class="frame">
			<div class="three-columns">
				<?php if(is_active_sidebar('bottom1-sidebar')) : ?>
				<div class="col">
					<?php dynamic_sidebar('bottom1-sidebar'); ?>
				</div>
				<?php endif; ?>
				<?php if(is_active_sidebar('bottom2-sidebar')) : ?>
				<div class="col">
					<?php dynamic_sidebar('bottom2-sidebar'); ?>
				</div>
				<?php endif; ?>
				<?php if(is_active_sidebar('bottom3-sidebar')) : ?>
				<div class="col">
					<?php dynamic_sidebar('bottom3-sidebar'); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
	</section>
	<?php endif;
?>