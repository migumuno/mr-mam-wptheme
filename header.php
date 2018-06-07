<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mr._Mam
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-120032934-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-120032934-1');
	</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<section id="header" class="container-fluid">
		<div class="row container">
			<div class="col-xs-6 header__logo">
				<a href="/">< Mr. Mam ></a>
			</div>
			<div class="col-xs-6 header__menu">
				<span class="hidden-md hidden-lg">☰ Menú</span>
				<nav class="hidden-xs hidden-sm">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					) );
					?>
				</nav>
			</div>
		</div>
		<script>
			const headerMenuIcon = document.querySelector('.header__menu span');
			const headerMenuNav = document.querySelector('.header__menu nav');
			const headerMenu = document.querySelectorAll('#header nav ul > li a');
			
			// Se encarga de desplegar y replegar el menú
			headerMenuIcon.addEventListener( 'click', (e) => {
				if( headerMenuNav.style.display === 'none' ){
					headerMenuNav.style.display = 'block';
				} else {
					headerMenuNav.style.display = 'none';
				}
			} );

			headerMenu.forEach(element => {
				element.addEventListener('click', e => {
					headerMenuNav.style.display = 'none';
				});
			});
		</script>
	</section>

	<section id="content" class="container-fluid">
