<footer class="app-footer">

			<div class="app-footer__wrap">

				<p class="app-footer__credit">
					<?php esc_html_e( 'Powered by crazy ideas and passion.', 'strangebrew' ) ?>
				</p>

				<?php Hybrid\View\display( 'nav/menu', 'footer', [ 'location' => 'footer' ] ) ?>

			</div>

		</footer>

	</div><!-- .app-below__header -->

</div><!-- .app -->

<?php wp_footer() ?>
</body>
</html>
