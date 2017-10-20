<?php
/**
 * Template part for displaying embed page  tribe_event
 * @todo translate file for category !!
 *
 */
$categories = get_the_terms( $post->ID, 'tribe_events_cat');  

?>

<article role="embed-post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header>
        <h3>
           <a href="<?php the_permalink(); ?>">
            <?php the_title();?>
            </a>
        </h3>     
        <?php 
        if (get_the_post_thumbnail()) {
        ?>
        <figure>
        <?php the_post_thumbnail( 'illustration-article' ); ?>
        </figure>
        <?php 
        }
        ?>        

    </header>
    <section>
       <?php if($post->post_content != "") : ?>			
       <div class="post-excerpt">	    		            			            	                                                                                            
			<?php the_excerpt(); ?>
        </div>
		<?php endif; ?>
    </section>
    <footer>
  <?php  if( $categories ): ?>
  <div class="tag">
  <?php foreach( $categories as $categorie ) :
          if ($categorie->slug !== "non-classe") :?>
         <a href="<?=site_url()?>/events/<?=get_locale()== 'fr_FR'? 'categorie':'category'?>/<?=$categorie->slug?>" class="<?=$categorie->slug?>">
			<?=$categorie->name?>                    
         </a>
         <?php endif;?>
  <?php endforeach;?>

  </div>
  <div class="clear"></div>
  <?php endif; ?>
        
		<?php theme_aeris_meta(); ?>
	</footer>
</article>