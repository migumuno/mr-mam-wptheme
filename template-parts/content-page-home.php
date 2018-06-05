<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mr._Mam
 */

?>

<script>
	function init() {
		const work = document.getElementById('work');
		const header = document.getElementById('header');
		const headerH1 = document.querySelector('#header h1');
		const headerMenuIcon = document.querySelector('.header__menu span');
		const headerMenuNav = document.querySelector('.header__menu nav');
		const headerMenu = document.querySelectorAll('#header nav ul > li a');
		const welcome = document.getElementById('welcome');
		const welcomeBackground = document.getElementById('welcome-background');

		// Se encarga de controlar el scroll para que cuando entre en la capa de trabajo cambie el color de los elementos
		// del menú.
		window.addEventListener( 'scroll', (e) => {
			// Negro
			if( window.pageYOffset >= work.offsetTop && window.pageYOffset <= ( work.offsetTop + work.offsetHeight ) ) {
				headerH1.style.color = '#fff';
				headerMenuIcon.style.color = '#fff';
				headerMenu.forEach( item => {
					item.style.color = '#fff';
				} );
				header.style.backgroundColor = 'rgba(51,51,51,0.7)';
				header.style.borderBottom = '0';
			// Claro
			} else {
				headerH1.style.color = '#333333';
				headerMenuIcon.style.color = '#333333';
				headerMenu.forEach( item => {
					item.style.color = '#333333';
				} );
				header.style.backgroundColor = 'rgba(255,255,255,0.7)';
				header.style.borderBottom = '1px solid #efefef';
			}
		} );
		
		// Se encarga de desplegar y replegar el menú
		headerMenuIcon.addEventListener( 'click', (e) => {
			if( headerMenuNav.style.display === 'none' ){
				headerMenuNav.style.display = 'block';
			} else {
				headerMenuNav.style.display = 'none';
			}
		} );

		// Añado animación a los clicks del menu
		headerMenu.forEach(element => {
			element.addEventListener('click', e => {
				console.log('click');
				e.preventDefault();
				let elementHref = element.hash;
				console.log(elementHref);
				let elementDestiny = document.querySelector(elementHref);

				jQuery('html, body').animate( {scrollTop: elementDestiny.offsetTop}, 600 );
			});
		});

		welcomeBackground.style.height = welcome.offsetHeight + 'px';
	}

	jQuery(document).ready(() => {
		init();
	})
</script>

<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div id="welcome-background" class="hidden-xs hidden-sm hidden-md"></div>
	<section id="welcome" class="aire">
		<div class="row welcome-wrapper container">
			<div class="col-md-6 welcome-wrapper__image">
				<img src="<?=get_stylesheet_directory_uri()?>/img/logo.jpg" alt="logo Mr. Mam diseño y programación">
			</div>
			<div class="col-md-6 welcome-wrapper__text">
				<p>Hola, Soy Miguel Ángel Muñoz Viejo.</p>
				<p>Contrátame para construir una web alucinante. Echa un ojo sobre quién soy, leete alguno de mis artículos o ponte en contacto conmigo y nos tomamos un café.</p>
				<ul>
					<li class="welcome-icons_list"><a href="mailto:hey@mistermam.com"><i class="fas fa-envelope"></i></a></li>
					<li class="welcome-icons_list"><a href="tel:+34696984784"><i class="fas fa-phone"></i></a></li>
					<li class="welcome-icons_list"><a href="https://www.linkedin.com/in/miguelangelmunozviejo/"><i class="fab fa-linkedin-in"></i></a></li>
					<li class="welcome-icons_list"><a href="https://twitter.com/mrmam_code"><i class="fab fa-twitter"></i></a></li>
					<li class="welcome-icons_list"><a href="<?=get_stylesheet_directory_uri()?>/docs/cv.pdf" download><i class="fas fa-file-alt"></i></a></li>
				</ul>
			</div>
		</div>
	</section>

	<section id="who_i_am" class="aire">
		<div class="row who_i_am-wrapper container">
			<div class="col-md-6 who_i_am-wrapper__text">
				<h2>Quién soy</h2>
				<h3>Full Stack Developer</h3>
				<p>He sido socio fundador de Devialia Solutions y cofundador de Raíz Grupo Digital, formado como ingeniero informático por la UCM y especialista en tecnologías web. He desarrollado y dirigido proyectos de todos los tamaños para clientes de múltiples sectores y he trabajado con multitud de tecnologías, lo que el proyecto requiera.</p>
			</div>
			<div class="col-md-6 who_i_am-wrapper__image">
				<img src="<?=get_stylesheet_directory_uri()?>/img/yo2.jpg" alt="foto de Mr. Mam Miguel Ángel Muñoz Viejo">
			</div>
		</div>
	</section>

	<section id="work" class="aire">
		<div class="row work-wrapper container">
			<div class="work-wrapper__text aire">
				<h2>Trabajo</h2>
				<p>Soy full stack developer, lo que significa que tengo conocimientos tanto de la parte de back-end como de la parte de front-end. Defensor absoluto del código libre e intentando compartir cada día más cosas con el resto del mundo.</p>
				<p>He sido director de desarrollo durante varios años en diversas empresas y he dirigido y ejecutado multitud de proyectos de diferentes tipos y con diferentes tecnologías. Tras la carrera, inicié mi camino desarrollando para web con PHP y en el camino me enamoré de WordPress (al principio más odio que amor ;)). En el front-end HTML5, CSS3 y JavaScript son mi día a día y me fascina toda la tecnología que está saliendo entorno a este último (NodeJS, React, AngularJS…).</p>
			</div>
			<div class="work-wrapper__skills aire">
				<h3>Habilidades</h3>
				<div class="col-md-6 row aire">
					<div class="col-sm-4">
						<p>Back-end</p>
					</div>
					<div class="col-sm-8">
						<ul>
							<li class="work-wrapper__skills-list__item">PHP</li>
							<li class="work-wrapper__skills-list__item">NodeJS</li>
							<li class="work-wrapper__skills-list__item">MySQL</li>
							<li class="work-wrapper__skills-list__item">MongoDB</li>
							<li class="work-wrapper__skills-list__item">Linux</li>
							<li class="work-wrapper__skills-list__item"><span>L</span> Express</li>
							<li class="work-wrapper__skills-list__item"><span>L</span> WordPress</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6 row aire">
					<div class="col-sm-4">
						<p>Front-end</p>
					</div>
					<div class="col-sm-8">
						<ul>
							<li class="work-wrapper__skills-list__item">JavaScript</li>
							<li class="work-wrapper__skills-list__item">HTML5</li>
							<li class="work-wrapper__skills-list__item">CSS3</li>
							<li class="work-wrapper__skills-list__item">Responsive</li>
							<li class="work-wrapper__skills-list__item"><span>L</span> jQuery</li>
							<li class="work-wrapper__skills-list__item"><span>L</span> Bootstrap</li>
							<li class="work-wrapper__skills-list__item"><span>L</span> Foundation</li>
							<li class="work-wrapper__skills-list__item"><span>A</span> Google Maps</li>
							<li class="work-wrapper__skills-list__item"><span>A</span> Facebook</li>
							<li class="work-wrapper__skills-list__item"><span>A</span> Linkedin</li>
						</ul>
					</div>
				</div>
				<small><span>L</span>: Librerías, <span>A</span>: API</small>
			</div>
		</div>
	</section>

	<section id="customers" class="aire">
		<div class="row customers-wrapper container">
			<h2>Algunos clientes</h2>
			<div class="col-xs-12 aire">
				<div id="lista_clientes" class="customers-wrapper__list"></div>
				<script>
					function getCustomers() {
						const lista_clientes = document.getElementById('lista_clientes');
						const customers_json = "<?=get_stylesheet_directory_uri() . '/json/customers.json'?>";
						var request = new XMLHttpRequest();
						
						request.open( 'GET', customers_json );
						request.responseType = 'json';
						request.send();
						request.onload = () => {
							const customers = request.response;
							customers.forEach(client => {
								lista_clientes.innerHTML += '<div class="work-wrapper__customers-list__item"><img src="<?=get_stylesheet_directory_uri()?>/img/clientes/' + client.img + '" alt="' + client.name + '"></div>';
							});
							jQuery('#lista_clientes').slick({
								dots: false,
								infinite: true,
								speed: 300,
								slidesToShow: 4,
								slidesToScroll: 1,
								autoplay: true,
								autoplaySpeed: 1000,
								responsive: [
									{
									breakpoint: 1024,
									settings: {
										slidesToShow: 3,
										slidesToScroll: 3
									}
									},
									{
									breakpoint: 600,
									settings: {
										slidesToShow: 2,
										slidesToScroll: 2
									}
									},
									{
									breakpoint: 480,
									settings: {
										slidesToShow: 1,
										slidesToScroll: 1
									}
									}
								]
							});
						}
					}
					
					getCustomers();
				</script>
			</div>
		</div>
	</section>

	<section id="about" class="aire">
		<div class="row about-wrapper container">
			<h2>Sobre mi</h2>
			<h3>Emprendedor & Friki</h3>
			<p>Emprendedor de nacimiento y friki de la vida, me puedo pasar horas e incluso días pegado a un ordenador (muchas Euskal y Campus party y fast coding) aprendiendo nuevas cosas o desarrollando nuevos proyectos. Mi frikismo no solo se queda en lo profesional, mi casa está llena de drones, robot limpiador, Raspberry, domótica… me vuelve loco la tecnología. Soy una persona <a href="">multipotencial</a> pero encontré mi pasión en la programación ya que me permite emprender muchos de los proyectos que me planteo.
Si me preguntas por mis hobbies, me encontrarás en alguna pista de pádel, un campo de golfo o pegando tiros en un campo de airsoft (me encantan la estrategia y el compañerismo).</p>
		</div>
	</section>

	<section id="blog" class="aire">

	</section>
</section><!-- #post-<?php the_ID(); ?> -->
