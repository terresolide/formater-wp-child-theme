<?php
/*
* Template Name: Home poleterre
* 
* @author epointal
* template for incude events in posts list
* copy of template-home.php where add event in selected post :
* 'post_type'        => array('post', 'tribe_events'),
* 
*  and add sidebar
*/


get_header(); 

// Description (slogan)
$description = get_bloginfo( 'description', 'display' );

while ( have_posts() ) : the_post();

// get_template_part( 'template-parts/header-content', 'page' );
?>
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

	<div id="content-area" class="wrapper sidebar">
		<main id="main" class="site-main" role="main">

			<?php
				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			   
			?>
			
			<section role="listNews" class="posts">
               <?php
                /*******  WP_QUERY
                * Liste des derniers articles (actus)
                */

                // $argsListPost = array (
                //     'post_type'             => array( 'post' ),
                //     'post_status'           => array( 'publish' ),
                //     'order'                 => 'DESC'
                // );
				                
                // list_pages($argsListPost, false);
				global $post;
				$argsListPost = array(
					'posts_per_page'   => get_option('posts_per_page') - 3,
					'offset'           => 0,
					'category'         => '',
					'category_name'    => '',
				    'tribe_events_cat'  => '',
					'orderby'          => 'date',
					'order'            => 'DESC',
					'include'          => '',
					'exclude'          => '',
					'meta_key'         => '',
					'meta_value'       => '',
					'post_type'        => array('post', 'tribe_events'),
					'post_mime_type'   => '',
					'post_parent'      => '',
					'author'		   => '',
					'author_name'	   => '',
					'post_status'      => 'publish',
					'suppress_filters' => true 
				);

				if(current_user_can('read_private_posts')){
					$argsListPost['post_status'] = array('publish', 'private');
				}
				$postsList = get_posts ($argsListPost);

				foreach ($postsList as $post) :
				
  				  setup_postdata( $post );

					?>
					<div class="post-container">
					<?php
					if(get_post_type() == "tribe_events"){
					    get_template_part( 'template-parts/content', 'tribe_events' );
					}else{
					   get_template_part( 'template-parts/content', get_post_format() );
					}
					?>
					</div>
					<?php 
				endforeach;
               
                ?>

            </section>
			<?php 
				the_posts_navigation();
				wp_reset_postdata();
			?>
		</main><!-- #main -->
		<?php 
		get_sidebar();
		?>
	</div><!-- #content-area -->

<?php
endwhile; // End of the loop.
// get_sidebar();
get_footer();


