<div class="app-content">

	<?php Hybrid\View\display( 'nav/breadcrumbs' ) ?>

	<main id="main" class="app-main">

		<?php Hybrid\View\display( 'partials', 'archive-header' ) ?>

			<?php if ( have_posts() ) : ?>

				<div class="archive-posts">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php Hybrid\View\display( 'entry/archive', Hybrid\Post\hierarchy() ) ?>

					<?php endwhile ?>

				</div>

				<?php Hybrid\View\display( 'nav/pagination', 'posts' ) ?>

			<?php endif ?>

	</main>

	<?php Hybrid\View\display( 'sidebar', 'primary', [ 'sidebar' => 'primary' ] ) ?>

</div>
