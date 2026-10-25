<?php
/**
 * Template da front-page (landing page).
 *
 * @package LandingPage
 */

get_header();
?>

<main>
	<?php get_template_part('parts/content-home-hero') ?>
	<?php get_template_part('parts/content-form')?>
	
</main>

<?php
get_footer();
