<article <?php Hybrid\Attr\display( 'entry' ) ?>>

	<header class="entry__header">
		<?php Hybrid\Post\display_title() ?>
	</header>

	<?php Hybrid\Media\display( [ 'type' => 'audio' ] ) ?>

	<div class="entry__content">
		<?php the_content() ?>
		<?php Hybrid\View\display( 'nav/pagination', 'post' ) ?>
	</div>

	<div class="media-meta media-meta--audio">

		<h3 class="media-meta__title"><?php esc_html_e( 'Audio Info', 'strangebrew' ) ?></h3>

		<ul class="media-meta__items">
			<?php Hybrid\Media\display_meta( 'length_formatted', [ 'tag' => 'li', 'label' => __( 'Run Time', 'strangebrew' )     ] ) ?>
			<?php Hybrid\Media\display_meta( 'artist',           [ 'tag' => 'li', 'label' => __( 'Artist', 'strangebrew' )       ] ) ?>
			<?php Hybrid\Media\display_meta( 'album',            [ 'tag' => 'li', 'label' => __( 'Album', 'strangebrew' )        ] ) ?>
			<?php Hybrid\Media\display_meta( 'track_number',     [ 'tag' => 'li', 'label' => __( 'Track Number', 'strangebrew' ) ] ) ?>
			<?php Hybrid\Media\display_meta( 'year',             [ 'tag' => 'li', 'label' => __( 'Year', 'strangebrew' )         ] ) ?>
			<?php Hybrid\Media\display_meta( 'genre',            [ 'tag' => 'li', 'label' => __( 'Genre', 'strangebrew' )        ] ) ?>
			<?php Hybrid\Media\display_meta( 'file_name',        [ 'tag' => 'li', 'label' => __( 'Name', 'strangebrew' )         ] ) ?>
			<?php Hybrid\Media\display_meta( 'mime_type',        [ 'tag' => 'li', 'label' => __( 'Mime Type', 'strangebrew' )    ] ) ?>
			<?php Hybrid\Media\display_meta( 'file_type',        [ 'tag' => 'li', 'label' => __( 'Type', 'strangebrew' )         ] ) ?>
			<?php Hybrid\Media\display_meta( 'file_size',        [ 'tag' => 'li', 'label' => __( 'Size', 'strangebrew' )         ] ) ?>
		</ul>

	</div>

</article>
