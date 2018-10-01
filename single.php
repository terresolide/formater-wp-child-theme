<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package aeris
 */

get_header(); 

$format = get_post_format();
$categories = get_the_terms( $post->ID, 'category');  

while ( have_posts() ) : the_post();

	get_template_part( 'template-parts/header-content', 'page' );
?>

	<div id="content-area" class="wrapper sidebar">
		<main id="main" class="site-main" role="main">
		
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									
				<header>
			        <?php theme_aeris_show_categories($categories);?>
				</header>			
			
			<?php			
			if (get_the_post_thumbnail()) {
		    ?>
		        <figure>
		        <?php if(!has_tag(array('video', 'vidéo'))){
		        	 the_post_thumbnail( 'single-article' );
		        }?>
		        </figure>
  
			<?php 
			}
			?>
				<section class="wrapper-content">
					<?php 
					the_content();
					?>
		        </section>

				<footer>
					<span class="icon-user"></span><?php the_author();?>
					<span class="icon-clock"></span><?php the_time( get_option( 'date_format' ) );?>
					<?php 
					// if ( get_edit_post_link() ) : 
					// 	edit_post_link(
					// 		sprintf(
					// 			/* translators: %s: Name of current post */
					// 			esc_html__( 'Edit %s', 'theme-aeris' ),
					// 			the_title( '<span class="screen-reader-text">"', '"</span>', false )
					// 		),
					// 		'<span class="edit-link">',
					// 		'</span>'
					// 	);
					// endif; 

					the_post_navigation();

					?>
				</footer><!-- .entry-meta -->
			</article>
			<?php			

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>

		</main><!-- #main -->
		
		<?php 
		get_sidebar();
		?>
	</div><!-- #primary -->
<?php
endwhile; // End of the loop.

// get_sidebar();
get_footer();
