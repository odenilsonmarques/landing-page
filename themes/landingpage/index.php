<?php
/**
 * Template principal do tema LandingPage.
 *
 * @package LandingPage
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container py-5">
		<div class="row">
			<div class="col-12">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						the_content();
					endwhile;
				else :
					echo '<p>Nenhum conteúdo encontrado.</p>';
				endif;
				?>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
