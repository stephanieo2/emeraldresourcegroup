<?php $sq = get_search_query() ? get_search_query() : __('Enter search terms&hellip;', 'emeraldresourcegroup'); ?>
<form method="get" class="search-form" id="searchform" action="<?php echo home_url(); ?>" role="search">
	<fieldset>
		<input type="search" id="s" name="s" placeholder="<?php echo $sq; ?>" />
		<input type="submit" id="searchsubmit" value="Search" />
	</fieldset>
</form>