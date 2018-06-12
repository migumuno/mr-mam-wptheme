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
<script>
    jQuery(document).ready(($) => {
        getTeams("<?=get_stylesheet_directory_uri()?>", getMatches);

        try {
            let todayPosition = $('.matches__date--'+ moment().format('DD') + moment().format('MM')).offset().top - 100;
            $('.today-matches').click(() => {
                $('html, body').animate({
                    scrollTop: todayPosition
                }, 'slow');
            });
        } catch (error) {
            $('.today-matches').click(() => {
                alert('Parece que hoy no hay partidos :(');
            });
        }
    });
</script>