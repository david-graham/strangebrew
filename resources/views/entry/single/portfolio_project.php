<article <?php Hybrid\Attr\display( 'entry' ) ?>>

	<header class="entry__header">

		<?php Strangebrew\display_featured_image( [ 'size' => 'strangebrew-thumbnail' ] ); ?>

		<?php Hybrid\Post\display_title() ?>

		<div class="entry__summary">
			<?php ( has_excerpt() ) ? the_excerpt() : NULL; ?>
		</div>
		
		<?php
			$meta = '';
			$meta .= ccp_get_project_client(     array( 'wrap' => '<li %s><span class="project-key">' . __( 'Client', 'strangebrew' ) . '</span> %s</li>' ) );
			$meta .= ccp_get_project_location(   array( 'wrap' => '<li %s><span class="project-key">' . __( 'Location', 'strangebrew' ) . '</span> %s</li>' ) );
			$meta .= ccp_get_project_start_date( array( 'wrap' => '<li %s><span class="project-key">' . __( 'Started', 'strangebrew' ) . '</span> %s</li>' ) );
			$meta .= ccp_get_project_end_date(   array( 'wrap' => '<li %s><span class="project-key">' . __( 'Completed', 'strangebrew' ) . '</span> %s</li>' ) );
		?>

		<?php if ( $meta ) : ?>
			<ul class="project-meta"><?php echo wp_kses_post( $meta ); ?></ul>
		<?php endif; ?>

		<?php ccp_project_link( array( 'text' => __( 'View Project', 'strangebrew' ), 'before' => '<div class="project-link-wrap">', 'after' => '</div>' ) ); ?>

	</header>
	
	<div class="entry__content">
		<?php the_content() ?>
		<?php Hybrid\View\display( 'nav/pagination', 'post' ) ?>
	</div>

</article>
