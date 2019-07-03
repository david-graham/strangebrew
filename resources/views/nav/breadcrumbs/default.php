<?php global $post; ?>

<?php if ( is_page() && ! $post->post_parent ) {
	return;
} ?>

<?php Hybrid\Breadcrumbs\Trail::display(
	array(
		'container'     => 'nav',
		'show_on_front' => false,
		'show_browse'   => false
	) 
);
