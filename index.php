<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mr._Mam
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) :
			

			if ( is_home() && ! is_front_page() ) :
				?>
				<header class="page-header">
					<h1 class="page-title"><?php single_post_title(); ?></h1>
					<?php
					$terms = mr_mam_get_terms();
					echo '<ul class="blog-categories">';
						foreach ($terms as $term) {
							echo '<li class="blog-categories__item"><a href="'.get_term_link( $term ).'">'.$term->name.'</a></li>';
						}
					echo '</ul>';
					?>
				</header><!-- .page-header -->
				<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				echo '<div class="mr-mam-blog-posts__post col-xs-12 col-sm-6 col-md-4 col-lg-3">
					'.get_the_post_thumbnail().'
					<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>
				</div>';

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
