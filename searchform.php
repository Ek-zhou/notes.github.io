<?php
/**
 * The main search template file
 */
?>

<form method="get" id="searchform" class="searchform blog-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="form">
	<button class="btn-search" type="submit" title="Search"><i class="ti-search"></i></button>
	<input type="text" class="form-control" id="s" placeholder="<?php esc_attr_e( 'Search', 'exort' ) ?>">
</form>