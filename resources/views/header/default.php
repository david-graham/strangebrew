<!DOCTYPE html>
<html <?php Hybrid\Attr\display( 'html' ) ?>>

<head>
<?php wp_head() ?>
</head>

<body <?php Hybrid\Attr\display( 'body' ) ?>>

<div class="app">

	<header class="app-header">

		<div class="app-header__wrap">

			<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'strangebrew' ) ?></a>

			<div class="app-header__branding">
				<?php the_custom_logo() ?>
				<?php Strangebrew\display_logo_icon() ?>
				<?php Hybrid\Site\display_title() ?>
				<?php Hybrid\Site\display_description() ?>
			</div>

			<?php Hybrid\View\display( 'nav/menu', 'primary', [ 'location' => 'primary' ] ) ?>

		</div>

	</header>

	<div class="app-below__header">
