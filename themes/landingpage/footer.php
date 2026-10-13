<?php
/**
 * Rodapé do tema LandingPage.
 *
 * @package LandingPage
 */
?>
<footer class="site-footer bg-dark text-white py-4 mt-5">
	<div class="container text-center">
		<p class="mb-0">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. Todos os direitos reservados.</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
