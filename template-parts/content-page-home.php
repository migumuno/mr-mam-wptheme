<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mr._Mam
 */

?>

<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<section id="welcome" class="aire">
		<div class="row welcome-wrapper">
			<div class="col-md-6 welcome-wrapper__image">
				<img src="<?=get_stylesheet_directory_uri()?>/img/logo.jpg" alt="logo Mr. Mam diseño y programación">
			</div>
			<div class="col-md-6 welcome-wrapper__text">
				<p>Hola, Soy Miguel Ángel Muñoz Viejo</p>
			</div>
		</div>
	</section>

	<section id="who_i_am" class="aire">

	</section>

	<section id="work" class="aire">

	</section>

	<section id="about" class="aire">

	</section>

	<section id="blog" class="aire">

	</section>

	<div class="entry-content">
		<?php
		the_content();
		?>
	</div><!-- .entry-content -->
</section><!-- #post-<?php the_ID(); ?> -->
