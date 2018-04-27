<?php
get_header(); 



?>        
        
        <?php
            $main_col = 'col-sm-8 col-md-9';
            $sidebar_col = 'col-sm-4 col-md-3';
        ?>

        <!-- Page Blog -->
        <section class="page-section with-sidebar sidebar-right">
            <div class="container">
                <div class="row">

                    <!-- Content -->
                    <section id="content" class="content <?php echo esc_attr($main_col); ?>">

                    	<?php 
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	                        $args = array(    
	                            'paged' => $paged,
	                            'post_type' => 'speaker',
                                'post_status' => 'publish'

	                        );
	                        $a = new WP_Query($args);
			 			?>
			 			<?php  if($a->have_posts()) :
                                while($a->have_posts()) : $a->the_post(); ?>

                                    <article class="post-wrap">
                                        <div class="archive-speakers">

                                            <div class="col-md-3">
                                                <?php $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id()); ?>
                                                <?php if($thumbnail_url){ ?>
                                                    <img  src="<?php  echo esc_url($thumbnail_url); ?>" alt="" class="img-responsive">
                                                <?php } ?>    
                                            </div>
                                            <div class="col-md-9">
                                                <h3 class="title"><a href="<?php echo get_the_permalink(); ?>"> <?php echo get_the_title(); ?></a></h3>
                                                <div class="intro"><?php  the_excerpt();  ?></div>   
                                            </div>
                                            

                                        </div>                
                                    </article>

                                <?php endwhile; ?>
                        <?php else: ?>
                            <h1><?php _e('Nothing Found Here!', TEXT_DOMAIN); ?></h1>
                        <?php endif; ?>

                        <!-- Pagination -->
                        <div class="pagination-wrapper" style="clear:both;">                           

                            <ul class="pagination">
                                <li>
                                    <?php
                                        global $wp_query;

                                        $big = 999999999; // need an unlikely integer
                                        echo paginate_links(array(
                                                     'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                                     'format' => '?paged=%#%',
                                                     'current' => max(1, get_query_var('paged') ),
                                                     'total' => $a->max_num_pages,
                                                     'next_text'    => __('&raquo;', TEXT_DOMAIN),
                                                     'prev_text'    => __('&laquo;', TEXT_DOMAIN),
                                                 ) );
                                    ?>
                                </li>
                            </ul>

                        </div>
                        <!-- /Pagination -->

                    </section>
                    <!-- Content -->



                    
                    <hr class="page-divider transparent visible-xs"/>

                    <aside id="sidebar" class="sidebar <?php echo esc_attr($sidebar_col); ?>">
                        <?php dynamic_sidebar('sidebar-right' ); ?>
                    </aside>
                



                    

                </div>
            </div>
        </section>
        <!-- /Page Blog -->

    
    
<?php get_footer(); ?>