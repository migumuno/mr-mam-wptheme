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
                <li class="header--actions__matches"><button class="show-matches">Ver partidos</button></li>
                <li class="header--actions__today"><button class="today-matches">Qué echan hoy?</button></li>
                <li class="header--actions__groups"><button class="show-groups">Ver grupos</button></li>
            </ul>
            <p><img src="<?=get_stylesheet_directory_uri() . '/img/avatar.png'?>" alt="Mr. Mam" width="200px"></p>
            <div class="header--filter">
                <ul class="header--teams"></ul>
                <button class="show-matches">Ver todos</button>
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
<div class="loader"><img src="<?=get_stylesheet_directory_uri() . '/img/loader4.gif'?>" alt="Mr. Mam loader"></div>

<script>
    jQuery(document).ready(($) => {
        const path = "<?=get_stylesheet_directory_uri()?>";

        $('.scrollToTop').click(() => {
            $('html, body').animate({
                scrollTop: $('header').offset().top - 100
            }, 'slow');
        });

        init_mundial(path)
            .then( (resolve, reject) => {
                // Init mundial
                start_mundial(path);
                
                // Print matches and move to today date
                $('.today-matches').click(() => {
                    printMatches(path).then( (resolve, reject) => {
                        try {
                            let todayPosition = $('.matches__date--'+ moment().format('DD') + moment().format('MM'));
                            if( todayPosition[0] !== undefined ) {
                                $('html, body').animate({
                                    scrollTop: todayPosition.offset().top - 100
                                }, 'slow');
                                $('.header--filter').css({'display': 'block'});
                            } else {
                                throw "Parece que hoy no hay partidos :(";
                            }
                        } catch (error) {
                            alert(error);
                        }
                    } ).catch(err => {
                        console.log(err);
                    });
                });

                // Print groups
                $('button.show-groups').click(() => {
                    printGroups(path).then( (resolve, reject) => {
                        $('html, body').animate({
                            scrollTop: $('#groups').offset().top - 300
                        }, 'slow');
                        $('.header--filter').css({'display': 'none'});
                    } ).catch(err => {
                        console.log(err);
                    });
                });

                // Print matches only
                $('button.show-matches').click(() => {
                    printMatches(path).then( (resolve, reject) => {
                        $('html, body').animate({
                            scrollTop: $('#groups').offset().top
                        }, 'slow');
                        $('.header--filter').css({'display': 'block'});
                    } ).catch(err => {
                        console.log(err);
                    });
                });

                // Filter matches
                $('ul.header--teams li').click(function() {
                    printFilteredMatches(path, { 'key': 'nombre', 'value': $(this).data('country') })
                        .then( (resolve, reject) => {
                            $('html, body').animate({
                                scrollTop: $('#matches').offset().top - 100
                            }, 'slow');
                        } ).catch(err => {
                            console.log(err);
                        });
                });
            } )
            .catch( err => {
                console.log(err);
            } );
    });
</script>