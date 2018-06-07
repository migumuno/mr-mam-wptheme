<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mr._Mam
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
					$terms = mr_mam_get_terms();
					echo '<ul class="blog-categories">';
						foreach ($terms as $term) {
							echo '<li class="blog-categories__item"><a href="'.get_term_link( $term ).'">'.$term->name.'</a></li>';
						}
					echo '</ul>';

					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<?php
				/* Start the Loop */
				echo '<div class="row posts-loop aire">';
				while ( have_posts() ) :
					the_post();

					echo '<div class="mr-mam-blog-posts__post col-xs-12 col-sm-6 col-md-4 col-lg-3">
						'.get_the_post_thumbnail().'
						<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>
					</div>';

				endwhile;
				echo '</div>';

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
