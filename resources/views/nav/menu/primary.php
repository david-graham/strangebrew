<?php if ( has_nav_menu( $data->location ) ) : ?>

	<nav <?php Hybrid\Attr\display( 'menu', $data->location ) ?>>

		<h3 class="menu__title">
			<?php printf(
				'<button class="menu__button">%s<span class="screen-reader-text">%s</span></button>',
				'<i class="menu__icon fa fa-bars" aria-hidden="true"></i>',
				Hybrid\Menu\render_name( $data->location ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			); ?>
		</h3>

		<?php wp_nav_menu( [
			'theme_location' => $data->location,
			'container'      => '',
			'menu_id'        => '',
			'menu_class'     => 'menu__items',
			'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
			'link_before'	 => '<span>',
			'link_after'	 => '</span>',
			'item_spacing'   => 'discard',
			'depth'			 => 2
		] ) ?>

	</nav>

<?php endif ?>
