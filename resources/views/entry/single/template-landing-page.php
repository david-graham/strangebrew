<article <?php Hybrid\Attr\display( 'entry' ) ?>>

	<header class="entry__header alignfull">
		<div class="overlay"></div>
		<?php if ( is_front_page() ) { 
				the_custom_header_markup(); 
			} else if ( has_post_thumbnail() ) { ?>
			<div id="wp-custom-header" class="wp-custom-header">
				<img src="<?php the_post_thumbnail_url( 'strangebrew-large' ); ?>">
			</div>
		<?php } ?>
		<?php Strangebrew\display_content_before_more() ?>
	</header>

	<div class="entry__content">
		<?php the_content() ?>
		<?php Hybrid\View\display( 'nav/pagination', 'post' ) ?>
	</div>

</article>
