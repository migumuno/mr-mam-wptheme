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
            <ul class="header--actions">
                <li class="header--actions__matches"><button class="show-matches" onclick="getTeams('<?=get_stylesheet_directory_uri()?>', getMatches, false);">Ver partidos</button></li>
                <li class="header--actions__today"><button class="today-matches">Qué echan hoy?</button></li>
                <li class="header--actions__groups"><button class="show-groups" onclick="getTeams('<?=get_stylesheet_directory_uri()?>', getMatches, false, {'show': 'groups'});">Ver grupos</button></li>
            </ul>
            <p><img src="<?=get_stylesheet_directory_uri() . '/img/avatar.png'?>" alt="Mr. Mam" width="200px"></p>
            <div class="header--filter">
                <ul class="header--teams"></ul>
                <button class="all-matches" onclick="getTeams('<?=get_stylesheet_directory_uri()?>', getMatches, false);">Ver todos</button>
                <p><small>Info: pincha en las banderas para filtrar. Las cadenas con * están pendientes de confirmar. Horario de la península española.</small></p>
            </div>
        </div>
    </header>
    <section id="groups">
        <div class="groups--wrapper container"></div>
    </section>
    <section id="matches" class="aire">
        <div class="matches--wrapper container"></div>
    </section>
</section><!-- #post-<?php the_ID(); ?> -->

<div class="scrollToTop"><i class="fas fa-arrow-circle-up"></i></div>

<script>
    jQuery(document).ready(($) => {
        $('ul.header--teams').click(() => {
            $('html, body').animate({
                scrollTop: $('#matches').offset().top - 100
            }, 'slow');
        });

        $('button.all-matches').click(() => {
            $('html, body').animate({
                scrollTop: $('#matches').offset().top - 100
            }, 'slow');
        });

        $('button.show-matches').click(() => {
            $('html, body').animate({
                scrollTop: $('#groups').offset().top - 100
            }, 'slow');
            $('.today-matches').css({'display': 'block'});
            $('.header--filter').css({'display': 'block'});
            
        });

        $('button.show-groups').click(() => {
            $('html, body').animate({
                scrollTop: $('#groups').offset().top - 100
            }, 'slow');
            $('.today-matches').css({'display': 'none'});
            $('.header--filter').css({'display': 'none'});
        });

        $('.scrollToTop').click(() => {
            $('html, body').animate({
                scrollTop: $('header').offset().top - 100
            }, 'slow');
        });

        $('button.all-matches').click(() => {
            $('html, body').animate({
                scrollTop: $('#matches').offset().top - 100
            }, 'slow');
        });

        getTeams("<?=get_stylesheet_directory_uri()?>", getMatches);

        
        $('.today-matches').click(() => {
            getTeams("<?=get_stylesheet_directory_uri()?>", getMatches).then((res) => {
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
        

        
    });
</script>