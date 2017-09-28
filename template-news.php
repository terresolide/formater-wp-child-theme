<?php
/**
 * Template Name: ForM@Ter news
 *
 * 
 */

get_header(); ?>

<div id="breadcrumbs">
<div class="wrapper">
		<?php if (function_exists('the_breadcrumb')) the_breadcrumb(); ?>
		<h1 rel="bookmark">
			News
		</h1>
	</div>
</div>


<!-- archive -->
	<div id="content-area" class="wrapper archives">
		<main id="main" class="site-main" role="main">

			<section role="listNews" class="posts">
				
			<?php
			global $post;
			$argsListPost = array(
					'posts_per_page'   => get_option('posts_per_page'),
					'offset'           => 0,
					'category'         => '',
					'category_name'    => '',
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
					get_template_part( 'template-parts/content', get_post_format() );
					?>
					</div>
					<?php
				endforeach;
               
                ?>
			
			</section>
			<?php 
				the_posts_navigation();
				?>
		
		
		</main><!-- #main -->
		<?php 
		// get_sidebar();
		?>
	</div><!-- #content-area -->
<?php
get_footer();
?>

