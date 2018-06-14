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
    <header>
        <div class="container">
            <p class="subtitle">Consulta todos los partidos del mundial</p>
            <h1>Partidos del mundial con Mr. Mam</h1>
            <button class="today-matches">Qué echan hoy?</button>
            <p><img src="<?=get_stylesheet_directory_uri() . '/img/avatar.png'?>" alt="Mr. Mam" width="200px"></p>
            <ul class="header--teams"></ul>
            <button class="all-matches" onclick="getTeams('<?=get_stylesheet_directory_uri()?>', getMatches, false);">Ver todos</button>
            <p><small>Info: pincha en las banderas para filtrar. Las cadenas con * están pendientes de confirmar. Horario de la península española.</small></p>
        </div>
    </header>
    <section id="matches" class="aire">
        <div class="matches--wrapper container"></div>
    </section>
</section><!-- #post-<?php the_ID(); ?> -->

<div class="scrollToTop"><i class="fas fa-arrow-circle-up"></i></div>

<script>
    jQuery(document).ready(($) => {
        jQuery('ul.header--teams').click(() => {
            jQuery('html, body').animate({
                scrollTop: jQuery('#matches').offset().top - 100
            }, 'slow');
        });

        jQuery('button.all-matches').click(() => {
            jQuery('html, body').animate({
                scrollTop: jQuery('#matches').offset().top - 100
            }, 'slow');
        });

        jQuery('.scrollToTop').click(() => {
            jQuery('html, body').animate({
                scrollTop: jQuery('header').offset().top - 100
            }, 'slow');
        });

        getTeams("<?=get_stylesheet_directory_uri()?>", getMatches);

        
        $('.today-matches').click(() => {
            try {
                let todayPosition = $('.matches__date--'+ moment().format('DD') + moment().format('MM'));
                if( todayPosition[0] !== undefined ) {
                    $('html, body').animate({
                        scrollTop: todayPosition.offset().top - 100
                    }, 'slow');
                } else {
                    throw "Parece que hoy no hay partidos :(";
                }
            } catch (error) {
                alert(error);
            }
        });
        

        
    });
</script>