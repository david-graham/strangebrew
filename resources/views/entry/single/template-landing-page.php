<article <?php Hybrid\Attr\display( 'entry' ) ?>>

	<header class="entry__header alignfull">
		<div class="overlay"></div>
		<?php the_custom_header_markup() ?>
		<?php Strangebrew\display_content_before_more() ?>
	</header>

	<div class="entry__content">
		<?php the_content() ?>
		<?php Hybrid\View\display( 'nav/pagination', 'post' ) ?>
	</div>

</article>
