<?php $sq = get_search_query() ? get_search_query() : __( 'search goes here', 'tvinsider' ); ?>
<form method="get" class="scan-form" action="<?php echo home_url(); ?>" >
	<fieldset>
		<button type="submit" class="icon-search"></button>
		<input type="search" name="s" placeholder="<?php echo $sq; ?>" value="<?php echo get_search_query(); ?>" />
	</fieldset>
</form>