<?php 
/**
 * @author epointal
 * Custom header for add a walker in menu
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
</head>

<body <?php body_class(); ?> data-color="<?php echo get_theme_mod( 'theme_aeris_main_color' );?>">
<div id="page" class="site"> 
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'theme-aeris' ); ?></a>

	<header id="masterhead" class="site-header" role="banner">
		<?php 
			/***
			* init var header
			*/

			// logo
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$image = wp_get_attachment_image_src( $custom_logo_id , 'full' ); 
           
			// Description (slogan)
			$description = get_bloginfo( 'description', 'display' );

		?>
		<div class="wrapper">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php echo $image[0];?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?> : <?php echo $description;?>">
			</a>
			<div>
				<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Menu principal / Main menu">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'theme-aeris' ); ?></button>
					<?php if (has_nav_menu('menu-1')) 
					{
					    wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' , 'walker' => new Custom_Walker_Nav_Menu() ) ); 
					}?>
				</nav>
				
				<nav id="top-header-menu" role="navigation" aria-label="Menu secondaire / Second menu">

					<?php if (has_nav_menu('header-menu')) 
					{
					    wp_nav_menu( array( 'theme_location' => 'header-menu', 'menu_id' => 'header-menu' ,  'walker' => new Custom_Walker_Nav_Menu() )); 
					}?>
				</nav>
			</div>
			
		</div>
	</header>

<?php
	// Breadcrumbs sans titre

	if ( is_front_page() && is_home() ) { ?>
	<div id="breadcrumbs">
		<?php if (function_exists('the_breadcrumb')) the_breadcrumb(); ?>
	</div>
	
	<div class="site-branding" style="background-image:url(<?php header_image()?>);">
		<div>
		
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php
			if ( $description || is_customize_preview() ) { ?>
			<p class="site-description"><?php echo $description; ?></p>
				<?php
			}
			?>
		</div>
	</div><!-- .site-branding -->
<?php
	}
	?>
	<!-- <div id="content" class="site-content"> -->
