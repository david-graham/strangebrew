<article <?php Hybrid\Attr\display( 'entry' ) ?>>

	<?php the_post_thumbnail( 'strangebrew-medium', [ 'class' => 'entry__image' ] ) ?>

	<header class="entry__header">
		<?php Hybrid\Post\display_title() ?>
	</header>

</article>
