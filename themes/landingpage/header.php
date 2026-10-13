<?php
/**
 * Cabeçalho do tema LandingPage.
 *
 * @package LandingPage
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Nessa landing page nao usamos o header, por isso comentamos -->

<!-- <header class="site-header">
	<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
		<div class="container">
			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php bloginfo( 'name' ); ?>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNav"
				aria-controls="primaryNav" aria-expanded="false" aria-label="Alternar navegação">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="primaryNav">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'main-menu',
						'container'      => false,
						'menu_class'     => 'navbar-nav ms-auto',
						'fallback_cb'    => false,
					)
				);
				?>
			</div>
		</div>
	</nav>
</header> -->
