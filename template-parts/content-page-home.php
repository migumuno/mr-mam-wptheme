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
		<div class="row welcome-wrapper container">
			<div class="col-md-6 welcome-wrapper__image">
				<img src="<?=get_stylesheet_directory_uri()?>/img/logo.jpg" alt="logo Mr. Mam diseño y programación">
			</div>
			<div class="col-md-6 welcome-wrapper__text">
				<p>Hola, Soy Miguel Ángel Muñoz Viejo.</p>
				<p>Contrátame para construir una web alucinante. Echa un ojo a mi trabajo, leete alguno de mis artículos o ponte en contacto conmigo ( <a href="mailto:hey@mistermam.com">hey@mistermam.com</a> | <a href="tel:+34696984784">+34 696 984 784</a> ) y nos tomamos un café.</p>
			</div>
		</div>
	</section>

	<section id="who_i_am" class="aire">
		<div class="row who_i_am-wrapper container">
			<div class="col-md-6 who_i_am-wrapper__text">
				<h2>Quién soy</h2>
				<h3>Full Stack Developer</h3>
				<p>Socio fundador de Devialia Solutions cofundador de Raíz Grupo Digital, formado como ingeniero informático por la UCM y especialista en tecnologías web. He desarrollado y dirigido proyectos de todos los tamaños para clientes de múltiples sectores y he trabajado con multitud de tecnologías, lo que el proyecto requiera. Dirijo el departamento técnico y los proyectos de desarrollo tanto de Devialia como de Raíz y soy del pensamiento de que para dirigir hay que saber y, para enseñar, todavía más.</p>
			</div>
			<div class="col-md-6 who_i_am-wrapper__image">
				<img src="<?=get_stylesheet_directory_uri()?>/img/yo.jpeg" alt="foto de Mr. Mam Miguel Ángel Muñoz Viejo">
			</div>
		</div>
	</section>

	<section id="work" class="aire">
		<div class="row work-wrapper container">
			<h2>Trabajo</h2>
			<div class="col-xs-12 work-wrapper__skills">
				<h3>Habilidades</h3>
				<div class="col-md-4">
					<p>Back-end</p>
					<ul>
						<li class="work-wrapper__skills-list__item">JavaScript</li>
						<li class="work-wrapper__skills-list__item">HTML5</li>
						<li class="work-wrapper__skills-list__item">CSS3</li>
					</ul>
				</div>
				<div class="col-md-4">
					<p>Front-end</p>
					<ul>
						<li class="work-wrapper__skills-list__item">JavaScript</li>
						<li class="work-wrapper__skills-list__item">HTML5</li>
						<li class="work-wrapper__skills-list__item">CSS3</li>
					</ul>
				</div>
				<div class="col-md-4">
					<p>Back-end</p>
					<ul>
						<li class="work-wrapper__skills-list__item">JavaScript</li>
						<li class="work-wrapper__skills-list__item">HTML5</li>
						<li class="work-wrapper__skills-list__item">CSS3</li>
					</ul>
				</div>
			</div>
			<div class="col-xs-12 work-wrapper__clients">
				<h3>Algunos clientes</h3>
				<ul id="lista_clientes" class="work-wrapper__clients-list">
					<script>
						function getClients() {
							const lista_clientes = document.getElementById('lista_clientes');
							const clients_json = "<?=get_stylesheet_directory_uri() . '/json/clients.json'?>";
							var request = new XMLHttpRequest();
							
							request.open( 'GET', clients_json );
							request.responseType = 'json';
							request.send();
							request.onload = () => {
								const clients = request.response;
								clients.forEach(client => {
									lista_clientes.innerHTML += '<li class="work-wrapper__clients-list__item"><img src="<?=get_stylesheet_directory_uri()?>/img/clientes/' + client.img + '" alt="' + client.name + '"></li>';
								});
							}
						}
						
						getClients();
					</script>
				</ul>
			</div>
		</div>
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
