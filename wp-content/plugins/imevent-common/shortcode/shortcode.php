<?php
if(defined('TEXT_DOMAIN_SHORTCODE') == false) define('TEXT_DOMAIN_SHORTCODE', 'imevent');

/* Create Schedule Shortcode */
add_shortcode('schedule', 'shortcode_schedule');
function shortcode_schedule($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(
      'array_slug'  => '',  
      'schedule_order_by' => 'id',
      'schedule_order'  => 'ASC',
      'schedule_count' => '100',
      'schedule_display_thumbnail' => '1',
      'schedule_display_thumbnail_border_gray' => '1', 
      'schedule_display_time' => '1', 
      'schedule_display_button_cricle' => '1', 
      'schedule_display_author' => '1', 
      'schedule_display_author_job' => '1', 
      'schedule_display_desc' => '1', 
      'schedule_display_link_title' => '1',
      'schedule_count_word' => '30', 
      'schedule_icon_time' => 'fa-clock-o', 
      'schedule_icon_microphone' => 'fa-microphone',
      'class'       => ''
    ), $atts);

    $filter_orderby = $atts['schedule_order_by'];
    $filter_order = $atts['schedule_order'];
    $schedule_count_each_tab = $atts['schedule_count'];
    $schedule_display_thumbnail = $atts['schedule_display_thumbnail'];
    $schedule_display_time = $atts['schedule_display_time'];    
    $schedule_display_button_cricle = $atts['schedule_display_button_cricle'];
    $schedule_display_author = $atts['schedule_display_author'];
    $schedule_display_author_job = $atts['schedule_display_author_job'];    
    $schedule_display_desc = $atts['schedule_display_desc'];
    $schedule_count_word = $atts['schedule_count_word'];
    $schedule_icon_time = $atts['schedule_icon_time'];
    $schedule_icon_microphone = $atts['schedule_icon_microphone'];
    $schedule_display_link_title = $atts['schedule_display_link_title'];
    $schedule_display_thumbnail_border_gray = $atts['schedule_display_thumbnail_border_gray']? 'show':'no';

    $html = '';

    $html .= '<div class="schedule-wrapper clear '.$atts['class'].'" >';

    /* Display navigation tab lv1 */
    $html .= '<div class="schedule-tabs lv1">
                        <ul id="tabs-lv1"  class="nav nav-justified">';
    $array_slug_new = explode(',', $atts['array_slug']);
    foreach ($array_slug_new as $key => $value) {
      $category_lv1 = get_term_by('slug', $value, 'categories');

      $class_active_lv1 = '';
      if($key == 0) { $class_active_lv1 = 'class="active"'; };
      $html .= '<li '.$class_active_lv1.'><a href="#tab-'.$category_lv1->slug.'" data-toggle="tab"><strong>'.$category_lv1->name.'</strong> <br/>'.$category_lv1->description.'</a></li>';
    }
   
    $html .= '</ul></div>'; 
    /* /Display navigation tab lv1 */

    $html .= '<div class="tab-content lv1">';
    /* Display content for tab lv1 */
      
        foreach ($array_slug_new as $key1 => $value1) {
          $class_active_lv2 = '';
          if($key1 == 0) { $class_active_lv2 = 'in active'; };

          $category_lv1 = get_term_by('slug', $value1, 'categories');      
          $array_term_childrens = get_term_children( $category_lv1->term_id, 'categories' );

             $html .= '<div id="tab-'.trim($value1).'" class="tab-pane  '.$class_active_lv2.'">';
                      $html .= '<div class="schedule-tabs lv2">
                                  <ul id="tabs-lv2'.$key1.'"  class="nav nav-justified">';
            /* Display navigation tab lv2 */ 
              foreach ($array_term_childrens as $key2=> $value2) {
                  $category_lv2 = get_term_by('term_id', $value2, 'categories');

                  $class_active_lv2_ac = '';
                if($key2 == 0) { $class_active_lv2_ac = 'class="active"'; };
                                  $html .= '<li '.$class_active_lv2_ac.'><a href="#tab-lv2-'.$category_lv2->slug.'" data-toggle="tab">'.$category_lv2->name.'</a></li>';
              }

              $html .= '</ul></div>';

                /* Display content for tab lv1 and lv2 */
                $html .= '<div class="tab-content lv2">';

                  /* Has sub-cateogry */
                  if($array_term_childrens != NULL){
                    foreach ($array_term_childrens as $key3=> $value3) {                    
                        $term_lv2 = get_term_by('term_id', $value3, 'categories');
                        if( $filter_orderby == '_cmb_schedule_order_by' ){
                          $args = array(
                            'post_type' => 'schedule', 
                            'categories'=>$term_lv2->slug,
                            'orderby'=> 'meta_value_num',
                            'meta_key' => $filter_orderby,
                            'order'=> $filter_order, 
                            'posts_per_page'=> $schedule_count_each_tab, 
                            'post_status' => 'publish'
                          );
                        }else{
                          $args = array(
                            'post_type' => 'schedule', 
                            'categories'=>$term_lv2->slug, 
                            'orderby'=> $filter_orderby, 
                            'order'=> $filter_order, 
                            'posts_per_page'=> $schedule_count_each_tab, 
                            'post_status' => 'publish'
                          );
                        }

                          

                          $schedule = new WP_QUery($args);

                          $class_term_lv2 = '';
                          if($key3 == 0) { $class_term_lv2 = 'in active'; };

                          $html .= '<div id="tab-lv2-'.$term_lv2->slug.'" class="tab-pane  '.$class_term_lv2.'">
                                      <div class="timeline">';
                                        
                                        if($schedule->have_posts()):
                                          while($schedule->have_posts()): $schedule->the_post();

                                            $is_post = get_the_id();
                                            $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id());

                                            $schedule_timetext = get_post_meta($is_post, "_cmb_schedule_timetext", true);
                                            $schedule_author = get_post_meta($is_post, "_cmb_schedule_author", true);
                                            $schedule_author_job = get_post_meta($is_post, "_cmb_schedule_author_job", true);
                                            $schedule_link_speaker = get_post_meta($is_post, "_cmb_schedule_link_speaker", true);
                                            $schedule_mail_address = get_post_meta($is_post, "_cmb_schedule_mail_address", true);
                                            $schedule_facebook_address = get_post_meta($is_post, "_cmb_schedule_facebook_address", true);
                                            $schedule_twitter_address = get_post_meta($is_post, "_cmb_schedule_twitter_address", true);
                                            $schedule_linkedin_address = get_post_meta($is_post, "_cmb_schedule_linkedin_address", true);
                                            $schedule_pinterest_address = get_post_meta($is_post, "_cmb_schedule_pinterest_address", true);
                                            $schedule_googleplus_address = get_post_meta($is_post, "_cmb_schedule_googleplus_address", true);
                                            $schedule_tumblr_address = get_post_meta($is_post, "_cmb_schedule_tumblr_address", true);
                                            $schedule_instagram_address = get_post_meta($is_post, "_cmb_schedule_instagram_address", true);
                                            $schedule_vk_address = get_post_meta($is_post, "_cmb_schedule_vk_address", true);
                                            $schedule_flickr_address = get_post_meta($is_post, "_cmb_schedule_flickr_address", true);
                                            $schedule_mySpace_address = get_post_meta($is_post, "_cmb_schedule_mySpace_address", true);
                                            $schedule_youtube_address = get_post_meta($is_post, "_cmb_schedule_youtube_address", true);

                                              $html .= '
                                                <article class="post-wrap">
                                                    <div class="media">';
                                                        if($schedule_display_thumbnail && $thumbnail_url){

                                                          $html .= '<div class="'.$schedule_display_thumbnail_border_gray.' post-media pull-left">';
                                                              if($schedule_link_speaker){
                                                                $html .= '<a href="'.$schedule_link_speaker.'">';
                                                              }
                                                              
                                                              $html .= '<img src="'.$thumbnail_url.'" alt="'.$schedule_author.'" class="media-object" />';

                                                              if($schedule_link_speaker){
                                                                $html .= '</a>';
                                                              }
                                                          $html .= '</div>';
                                                          
                                                        }
                                                        
                                                        $html .= '<div class="media-body">
                                                            <div class="post-header">
                                                                <div class="post-meta">';
                                                                    if($schedule_display_time){
                                                                      $html .= '<span class="post-date"><i class="fa '.$schedule_icon_time.'"></i> '.$schedule_timetext.'</span>';
                                                                    }
                                                                    if($schedule_display_button_cricle){
                                                                      $html .= '
                                                                      <div class="share_social">
                                                                        <a href="#" class="pull-right">
                                                                            <span class="fa-stack fa-lg">
                                                                                <i class="fa fa-stack-2x fa-circle-thin"></i>
                                                                                <i class="fa fa-stack-1x fa-share-alt"></i>
                                                                            </span>
                                                                        </a>';
                                                                        $html .= '<div class="share_schedule">';
                                                                        $html .= '<a target="_blank" href="https://twitter.com/intent/tweet?text='.urlencode( get_the_title() ).'&amp;url='.urlencode( get_permalink() ).'"><i class="fa fa-twitter"></i></a>

                                                                                  <a target="_blank" href="http://www.facebook.com/sharer.php?u='.get_the_permalink().'"><i class="fa fa-facebook"></i></a>

                                                                               
                                                                                  <a target="_blank" href="https://plus.google.com/share?url='.get_permalink().'"><i class="fa fa-google-plus"></i></a>';

                                                                        $html .= '</div>';
                                                                      $html .= '</div>';
                                                                    }
                                                                $html .= '</div>';


                                                                if($schedule_display_link_title){
                                                                  $html .= '<h2 class="post-title"><a href="'.get_permalink().'">'.get_the_title( ).'</a></h2>';  
                                                                }else{
                                                                  $html .= '<h2 class="post-title">'.get_the_title( ).'</h2>';
                                                                }
                                                                

                                                            $html .= '</div>';
                                                            if($schedule_display_desc){
                                                              $html .='
                                                              <div class="post-body">
                                                                  <div class="post-excerpt">
                                                                      '.custom_excerpt($schedule_count_word).'
                                                                  </div>
                                                              </div>';
                                                            }
                                                            $html .='
                                                            <div class="post-footer">
                                                                <span class="post-readmore">';
                                                                    if($schedule_display_author){
                                                                      if($schedule_author != ''){
                                                                        $html .= '<i class="fa '.$schedule_icon_microphone.'"></i> <strong>'.$schedule_author.'</strong> / ';
                                                                      }
                                                                      if($schedule_display_author_job){
                                                                        $html .= $schedule_author_job.'&nbsp;&nbsp;';    
                                                                      }
                                                                    }                                                                  

                                                                    if($schedule_mail_address){
                                                                        $html .= '<a target="_blank" href="mailto:'.$schedule_mail_address.'" ><i class="fa fa-envelope">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_facebook_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_facebook_address.'" ><i class="fa fa-facebook">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_twitter_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_twitter_address.'" ><i class="fa fa-twitter">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_linkedin_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_linkedin_address.'" ><i class="fa fa-linkedin">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_pinterest_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_pinterest_address.'" ><i class="fa fa-pinterest">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_googleplus_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_googleplus_address.'" ><i class="fa fa-google-plus">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_tumblr_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_tumblr_address.'" ><i class="fa fa-tumblr">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_instagram_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_instagram_address.'" ><i class="fa fa-instagram">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_vk_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_vk_address.'" ><i class="fa fa-vk">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_flickr_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_flickr_address.'" ><i class="fa fa-flickr">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_mySpace_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_mySpace_address.'" ><i class="fa fa-users">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_youtube_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_youtube_address.'" ><i class="fa fa-youtube">&nbsp;</i></a>';
                                                                    }

                                                                $html .= '</span>
                                                            </div>
                                                        </div>                                                      
                                                    </div>
                                                </article>';
                                          endwhile;
                                        endif;
                                         wp_reset_postdata();
                          $html .= '</div></div>';
                    }
                  }else{ /* Display with parent category */
                          


                         if( $filter_orderby == '_cmb_schedule_order_by' ){

                             $args = array('post_type' => 'schedule', 
                                      'categories'=>$value1, 
                                      'orderby'=> 'meta_value_num',
                                      'meta_key' => $filter_orderby,
                                      'order'=> $filter_order,
                                      'posts_per_page'=> $schedule_count_each_tab
                                    );
                          }else{
                            $args = array('post_type' => 'schedule', 
                                      'categories'=>$value1, 
                                      'orderby'=> $filter_orderby, 
                                      'order'=> $filter_order,
                                      'posts_per_page'=> $schedule_count_each_tab
                                    );
                          } 

                          $schedule = new WP_QUery($args);

                          $class_term_lv2 = 'in active';
                          

                          $html .= '<div id="tab-lv2-'.$value1.'" class="tab-pane  '.$class_term_lv2.'">
                                      <div class="timeline">';
                                        
                                        if($schedule->have_posts()):
                                          while($schedule->have_posts()): $schedule->the_post();

                                            $is_post = get_the_id();
                                            $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id());

                                            $schedule_timetext = get_post_meta($is_post, "_cmb_schedule_timetext", true);
                                            $schedule_author = get_post_meta($is_post, "_cmb_schedule_author", true);
                                            $schedule_author_job = get_post_meta($is_post, "_cmb_schedule_author_job", true);
                                            $schedule_link_speaker = get_post_meta($is_post, "_cmb_schedule_link_speaker", true);
                                            $schedule_mail_address = get_post_meta($is_post, "_cmb_schedule_mail_address", true);
                                            $schedule_facebook_address = get_post_meta($is_post, "_cmb_schedule_facebook_address", true);
                                            $schedule_twitter_address = get_post_meta($is_post, "_cmb_schedule_twitter_address", true);
                                            $schedule_linkedin_address = get_post_meta($is_post, "_cmb_schedule_linkedin_address", true);
                                            $schedule_pinterest_address = get_post_meta($is_post, "_cmb_schedule_pinterest_address", true);
                                            $schedule_googleplus_address = get_post_meta($is_post, "_cmb_schedule_googleplus_address", true);
                                            $schedule_tumblr_address = get_post_meta($is_post, "_cmb_schedule_tumblr_address", true);
                                            $schedule_instagram_address = get_post_meta($is_post, "_cmb_schedule_instagram_address", true);
                                            $schedule_vk_address = get_post_meta($is_post, "_cmb_schedule_vk_address", true);
                                            $schedule_flickr_address = get_post_meta($is_post, "_cmb_schedule_flickr_address", true);
                                            $schedule_mySpace_address = get_post_meta($is_post, "_cmb_schedule_mySpace_address", true);
                                            $schedule_youtube_address = get_post_meta($is_post, "_cmb_schedule_youtube_address", true);

                                              $html .= '
                                                <article class="post-wrap">
                                                    <div class="media">';
                                                        if($schedule_display_thumbnail && $thumbnail_url){

                                                          $html .= '<div class="'.$schedule_display_thumbnail_border_gray.' post-media pull-left">';
                                                              if($schedule_link_speaker){
                                                                $html .= '<a href="'.$schedule_link_speaker.'">';
                                                              }
                                                                  $html .= '<img src="'.$thumbnail_url.'" alt="'.$schedule_author.'" class="media-object" />';

                                                              if($schedule_link_speaker){
                                                                $html .= '</a>';
                                                              }
                                                          $html .= '</div>';
                                                          
                                                        }
                                                        
                                                        $html .= '<div class="media-body">
                                                            <div class="post-header">
                                                                <div class="post-meta">';
                                                                    if($schedule_display_time){
                                                                      $html .= '<span class="post-date"><i class="fa '.$schedule_icon_time.'"></i> '.$schedule_timetext.'</span>';
                                                                    }
                                                                    if($schedule_display_button_cricle){
                                                                      $html .= '
                                                                      <div class="share_social">
                                                                        <a href="#" class="pull-right">
                                                                            <span class="fa-stack fa-lg">
                                                                                <i class="fa fa-stack-2x fa-circle-thin"></i>
                                                                                <i class="fa fa-stack-1x fa-share-alt"></i>
                                                                            </span>
                                                                        </a>';
                                                                        $html .= '<div class="share_schedule">';
                                                                        $html .= '<a target="_blank" href="https://twitter.com/intent/tweet?text='.urlencode( get_the_title() ).'&amp;url='.urlencode( get_permalink() ).'"><i class="fa fa-twitter"></i></a>
                                                                                  <a target="_blank" href="https://www.facebook.com/dialog/feed?app_id=1078691688896583&amp;display=popup&amp;caption='.urlencode( get_the_title() ).'&amp;link='.get_permalink().'&amp;redirect_uri=https://facebook.com"><i class="fa fa-facebook"></i></a>
                                                                                  <a target="_blank" href="https://plus.google.com/share?url='.get_permalink().'"><i class="fa fa-google-plus"></i></a>';

                                                                        $html .= '</div>';
                                                                      $html .= '</div>';
                                                                    }
                                                                $html .= '</div>';
                                                                if($schedule_display_link_title){
                                                                  $html .= '<h2 class="post-title"><a href="'.get_permalink().'">'.get_the_title( ).'</a></h2>';  
                                                                }else{
                                                                  $html .= '<h2 class="post-title">'.get_the_title( ).'</h2>';
                                                                }
                                                            $html .= '</div>';
                                                            if($schedule_display_desc){
                                                              $html .='
                                                              <div class="post-body">
                                                                  <div class="post-excerpt">
                                                                      '.custom_excerpt($schedule_count_word).'
                                                                  </div>
                                                              </div>';
                                                            }
                                                            $html .='
                                                            <div class="post-footer">
                                                                <span class="post-readmore">';
                                                                    if($schedule_display_author){
                                                                      if($schedule_author != ''){
                                                                        $html .= '<i class="fa '.$schedule_icon_microphone.'"></i> <strong>'.$schedule_author.'</strong> / ';
                                                                      }
                                                                      if($schedule_display_author_job){
                                                                        $html .= $schedule_author_job.'&nbsp;&nbsp;';    
                                                                      }
                                                                    }                                                                  

                                                                    if($schedule_mail_address){
                                                                        $html .= '<a target="_blank" href="mailto:'.$schedule_mail_address.'" ><i class="fa fa-envelope">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_facebook_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_facebook_address.'" ><i class="fa fa-facebook">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_twitter_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_twitter_address.'" ><i class="fa fa-twitter">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_linkedin_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_linkedin_address.'" ><i class="fa fa-linkedin">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_pinterest_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_pinterest_address.'" ><i class="fa fa-pinterest">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_googleplus_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_googleplus_address.'" ><i class="fa fa-google-plus">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_tumblr_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_tumblr_address.'" ><i class="fa fa-tumblr">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_instagram_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_instagram_address.'" ><i class="fa fa-instagram">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_vk_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_vk_address.'" ><i class="fa fa-vk">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_flickr_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_flickr_address.'" ><i class="fa fa-flickr">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_mySpace_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_mySpace_address.'" ><i class="fa fa-users">&nbsp;</i></a>';
                                                                    }
                                                                    if($schedule_youtube_address){
                                                                        $html .= '<a target="_blank" href="'.$schedule_youtube_address.'" ><i class="fa fa-youtube">&nbsp;</i></a>';
                                                                    }

                                                                $html .= '</span>
                                                            </div>
                                                        </div>                                                      
                                                    </div>
                                                </article>';
                                          endwhile;
                                        endif;
                                         wp_reset_postdata();
                          $html .= '</div></div>';
                    
                  }

                  
                $html .= '</div>';
                /* /Display content for tab lv1 and lv2 */
              
            /* /Display navigation tab lv2 */         
          $html .= '</div>'; 
        }
      
    /* /Display content for tab lv1 */
    $html .= '</div>';




    
    $html .= "</div>";
    
    return $html;
}
/* Create Schedule Shortcode */


/* Create Speaker Shortcode */
add_shortcode('speaker', 'shortcode_speaker');
function shortcode_speaker($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(
      'slug'  => '',
      'style' => 'rhex',
      'column'  => 'col-md-3 col-sm-6',
      'speaker_order_by' => 'id',
      'speaker_order' => 'ASC',
      'speakers_item_count' => '30',
      'speakers_display_job' => '1',
      'speakers_display_intro_description' => '1',
      'speakers_speaker_link' => '1',
      'speakers_remove_zoom_thumbnail' => '1',
      'speakers_desc_count' => '12',
      'speakers_remove_background_thumbnail' => '1',
      'class' => ''
    ), $atts);

    $speaker_order_by = $atts['speaker_order_by'];
    $speaker_order = $atts['speaker_order'];
    $posts_per_page = $atts['speakers_item_count'];
    $speakers_display_job = $atts['speakers_display_job'];
    $speakers_display_intro_description = $atts['speakers_display_intro_description'];
    $speakers_speaker_link = $atts['speakers_speaker_link'];
    $speakers_remove_zoom_thumbnail =  $atts['speakers_remove_zoom_thumbnail'] ? 'media' : '';
    $speakers_remove_background_thumbnail = $atts['speakers_remove_background_thumbnail'];
    
    $html = '';
    $html .= '<div class="row thumbnails speaker clear '.$atts['class'].'">';

    if( $speaker_order_by == '_cmb_speaker_order_by'){
      $args = array(
              'post_type' => 'speaker',
              'group'=>$atts['slug'],
              'orderby'=> 'meta_value_num', 
              'meta_key'=> $speaker_order_by,
              'order'=> $speaker_order,
              'posts_per_page'=>$posts_per_page,
              'post_status' => 'publish'
            );
    }else{
      $args = array(
              'post_type' => 'speaker',
              'group'=>$atts['slug'],
              'orderby'=> $speaker_order_by,
              'order'=> $speaker_order,
              'posts_per_page'=>$posts_per_page,
              'post_status' => 'publish'
            );
    }
    
    $speaker = new WP_QUery($args);

    $i=0;
    $k=0;

    if($speaker->have_posts()):
      while($speaker->have_posts()): $speaker->the_post();

            $id_post = get_the_id();
            // $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id());            
            $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium');

            $speaker_job = get_post_meta($id_post, "_cmb_speaker_job", true);
            
            $speakers_layout = $atts['column'];

            $speaker_mail_address = get_post_meta($id_post, "_cmb_speaker_mail_address", true);
            $speaker_facebook_address = get_post_meta($id_post, "_cmb_speaker_facebook_address", true);
            $speaker_twitter_address = get_post_meta($id_post, "_cmb_speaker_twitter_address", true);
            $speaker_linkedin_address = get_post_meta($id_post, "_cmb_speaker_linkedin_address", true);
            $speaker_pinterest_address = get_post_meta($id_post, "_cmb_speaker_pinterest_address", true);
            $speaker_googleplus_address = get_post_meta($id_post, "_cmb_speaker_googleplus_address", true);
            $speaker_tumblr_address = get_post_meta($id_post, "_cmb_speaker_tumblr_address", true);
            $speaker_instagram_address = get_post_meta($id_post, "_cmb_speaker_instagram_address", true);
            $speaker_vk_address = get_post_meta($id_post, "_cmb_speaker_vk_address", true);
            $speaker_flickr_address = get_post_meta($id_post, "_cmb_speaker_flickr_address", true);
            $speaker_mySpace_address = get_post_meta($id_post, "_cmb_speaker_mySpace_address", true);
            $speaker_youtube_address = get_post_meta($id_post, "_cmb_speaker_youtube_address", true);
            $speakers_layout_5 = '';    
            if($speakers_layout == 'col-md-2 col-sm-6 col-5' && ($i==0 || $i == 5)){
                    $speakers_layout_5 = 'col-lg-offset-1 col-md-offset-1';
            }
            if($i==5) $i=0; $i++;

            switch ($k) {
              case 1:
                $cols = "col-md-12 col-sm-12";
                break;
              case 2:
                $cols = "col-md-6 col-sm-6";
                break;
              case 3:
                $cols = "col-md-4 col-sm-4";
                break;
              case 4:
                $cols = "col-md-3 col-sm-6";
                break;
              case 5:
                $cols = "col-md-2 col-sm-6 col-5";
                break;
              case 6:
                $cols = "col-md-2 col-sm-6";
                break;          
              
              default:
                $cols = "col-md-3 col-sm-6";
                break;
            }

            if($cols == $speakers_layout){
              $html .= '<div class="clearfix"></div>';
              $k = 0;
            }
            $k++;

            $html .= '
              <div class="'.$speakers_layout.' '.$speakers_layout_5.'" data-animation="fadeInUp" data-animation-delay="100">';
                  if($atts['style'] == 'wohex'){
                    $html .= '<div class="thumbnail no-border no-padding no-radius square text-center">';  
                  }else if($atts['style'] == 'crcle'){
                    $html .= '<div class="thumbnail no-border no-padding text-center">';  
                  }else{
                    $html .= '<div class="thumbnail no-border no-padding  text-center">';  
                  }
                  
                      if($atts['style'] == 'rhex'){
                        $html .='<div class="hex"><div class="hex-deg"><div class="hex-deg"><div class="hex-deg"><div class="hex-inner">';
                      }else if($atts['style'] == 'crcle'){
                        $html .= '<div class="circle"><div class="circle-inner">';
                      }

                                  $html .='<div class="'.$speakers_remove_zoom_thumbnail.'">
                                      <img src="'.$thumbnail_url[0].'" alt="" class="img-responsive">';
                                      if($speakers_remove_background_thumbnail){
                                      $html .= '<div class="caption hovered">
                                                    <div class="caption-wrapper div-table">
                                                        <div class="caption-inner div-cell">
                                                            <p class="caption-buttons"><a href="'.get_permalink().'" class="btn caption-link"><i class="fa fa-link"></i></a></p>
                                                        </div>
                                                    </div>
                                                </div>';
                                      }
                                  $html .='</div>';

                      if($atts['style'] == 'rhex'){
                        $html .= '</div></div></div></div></div>';
                      }else if($atts['style'] == 'crcle'){
                        $html .= '</div></div>';
                      }

                      $html .='<div class="caption before-media">
                          <h3 class="caption-title">';
                          if($speakers_speaker_link){
                            $html .= '<a href="'.get_permalink().'">'.get_the_title().'</a>';
                          }else{
                            $html .= get_the_title();
                          }                          
                          $html .= '</h3>';
                          if($speakers_display_job){
                            $html .= '<p class="caption-category">'.$speaker_job.'</p>';
                          }

                          $html .='
                      </div>
                      <div class="caption">';
                          if($speakers_display_intro_description){
                            $html .= '<p>'.custom_excerpt($atts['speakers_desc_count']).'</p>';
                          }
                          if($atts['style'] == 'wohex'){
                            $html .= '<ul class="social-line social-wohex list-inline text-center">';
                          }else if($atts['style'] == 'crcle'){
                            $html .= '<ul class="social-line social-circle list-inline text-center">';
                          }else{
                            $html .= '<ul class="social-line list-inline text-center">';
                          }

                             if($speaker_mail_address){
                                        $html .= '<li><a target="_blank" href="mailto:'.$speaker_mail_address.'" class="facebook"><i class="fa fa-envelope"></i></a></li>';
                                    }
                                    if($speaker_facebook_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_facebook_address.'" class="twitter"><i class="fa fa-facebook"></i></a></li>';
                                    }
                                    if($speaker_twitter_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_twitter_address.'" class="google"><i class="fa fa-twitter"></i></a></li>';
                                    }
                                    if($speaker_linkedin_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_linkedin_address.'" class="linkedin"><i class="fa fa-linkedin"></i></a></li>';
                                    }
                                    if($speaker_pinterest_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_pinterest_address.'" class="instagram"><i class="fa fa-pinterest"></i></a></li>';
                                    }
                                    if($speaker_googleplus_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_googleplus_address.'" class="instagram"><i class="fa fa-google-plus"></i></a></li>';
                                    }
                                    if($speaker_tumblr_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_tumblr_address.'" class=""><i class="fa fa-tumblr"></i></a></li>';
                                    }
                                    if($speaker_instagram_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_instagram_address.'" class=""><i class="fa fa-instagram"></i></a></li>';
                                    }
                                    if($speaker_vk_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_vk_address.'" class=""><i class="fa fa-vk"></i></a></li>';
                                    }
                                    if($speaker_flickr_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_flickr_address.'" class=""><i class="fa fa-flickr"></i></a></li>';
                                    }
                                    if($speaker_mySpace_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_mySpace_address.'" class=""><i class="fa fa-users"></i></a></li>';
                                    }
                                    if($speaker_youtube_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_youtube_address.'" class=""><i class="fa fa-youtube"></i></a></li>';
                                    }


                          $html .= '</ul>
                      </div>
                  </div>
              </div>
            ';

      endwhile;
    endif;
     wp_reset_postdata();
    $html .= '</div>';
    return $html;
}
/* /Create Speaker Shortcode */


/* Create Faq Shortcode */
add_shortcode('faq', 'shortcode_faq');
function shortcode_faq($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(
      'slug'  => '',
      'faq_order_by' => 'id',
      'faq_order' => 'ASC',
      'faq_item_count' => '100',
      'style' => 'style1',
      'class' => '',
    ), $atts);

    $faq_order_by = $atts['faq_order_by'];
    $faq_order = $atts['faq_order'];
    $posts_per_page = $atts['faq_item_count'];

    

    if($faq_order_by == '_cmb_faq_order_by'){
      $args = array(
      'post_type' => 'faq', 
      'faqgroup'=>$atts['slug'], 
      'orderby'=> 'meta_value_num', 
      'meta_key'=> $faq_order_by, 
      'order'=> $faq_order, 
      'posts_per_page'=>$posts_per_page, 
      'post_status' => 'publish'
    );
    }else{
      $args = array(
      'post_type' => 'faq', 
      'faqgroup'=>$atts['slug'], 
      'orderby'=> $faq_order_by, 
      'order'=> $faq_order, 
      'posts_per_page'=>$posts_per_page, 
      'post_status' => 'publish'
    );  
    }

    $rand = rand();
    

    $faqs = new WP_QUery($args);

    $html = '';
    $html .= '<div class="row faq  '.$atts['class'].'" data-animation="fadeInUp" data-animation-delay="100">';

    if($faqs->have_posts()):
      $k = 0; 
      $html .= '<div class="col-sm-6 col-md-6 pull-left"><ul id="tabs-faq"  class="'.$atts['style'].' nav">';
      while($faqs->have_posts()): $faqs->the_post();
        $class_act = '';
        if($k == 0) $class_act = 'class="active"'; $k++;
        $html .= '<li '.$class_act.'><a href="#tab-'.get_the_id().$rand.'" data-toggle="tab"><i class="fa fa-angle-right"></i> <span class="faq-inner">'.get_the_title().'</span></a></li>';
      endwhile;
      $html .= '</ul></div>';
    endif;

    $d = 0; 

    if($faqs->have_posts()):
      $html .= '<div class="col-sm-6 col-md-6 pull-right"><div class="tab-content">';
      while($faqs->have_posts()): $faqs->the_post();
        $class_ac = '';
        if($d==0) $class_ac = 'in active'; $d++;
        $html .= '<div id="tab-'.get_the_id().$rand.'" class="tab-pane fade '.$class_ac.'"><div>';
          $html .= get_the_content();
        $html .= '</div></div>';
      endwhile;
      $html .= '</div></div>';
    endif;
     wp_reset_postdata();
    $html .= '</div>';
    return $html;
}
/* /Create Faq Shortcode */


/* Create Slideshow Shortcode */
add_shortcode('slideshow', 'shortcode_slideshow');
function shortcode_slideshow($atts, $content = null) {
    global $theme_option;
    $atts = shortcode_atts(
    array(
      'slug_group'  => '',
      'slideshow_order_by' => 'id',
      'slideshow_order' => 'ASC',
      'slideshow_item_count' => '10',
      'auto_slider' => 'true',
      'duration'    => '3000',
      'navigation'  => 'true',
      'loop'        => 'true',
      'height_desk' => '768px',
      'height_ipad' => '768px',
      'height_mobile' => '800px',
      'class'       => '',
    ), $atts);

    $slide_order_by = $atts['slideshow_order_by'];
    $slide_order = $atts['slideshow_order'];
    $posts_per_page = $atts['slideshow_item_count'];
    
    $timezone = $theme_option['slideshow_timezone'] ? $theme_option['slideshow_timezone'] : 0;
    $display_format = $theme_option['display_format'];

    $years = $theme_option['years'];
    $months = $theme_option['months'];
    $weeks = $theme_option['weeks'];
    $days = $theme_option['days'];
    $hours = $theme_option['hours'];
    $minutes = $theme_option['minutes'];
    $seconds = $theme_option['seconds'];
    $year = $theme_option['year'];
    $month = $theme_option['month'];
    $week = $theme_option['week'];
    $day = $theme_option['day'];
    $hour = $theme_option['hour'];
    $minute = $theme_option['minute'];
    $second = $theme_option['second'];


    $end_date_d =  $end_date_m = $end_date_y = '';

    if($slide_order_by == '_cmb_slideshow_order'){
      $args = array(
              'post_type'=>'slideshow',
              'slidegroup'=>$atts['slug_group'],
              'orderby'=> 'meta_value_num',
              'meta_key' => $slide_order_by,
              'order'=> $slide_order,
              'posts_per_page' => $posts_per_page,
              'post_status' => 'publish'
            );  
    }else{
      $args = array(
              'post_type'=>'slideshow',
              'slidegroup'=>$atts['slug_group'],
              'orderby'=> $slide_order_by,
              'order'=> $slide_order,
              'posts_per_page' => $posts_per_page,
              'post_status' => 'publish'
            );
    }
    
    $slideshow = new WP_QUery($args);

    if(count($slideshow->posts) <= 1){
      $atts['loop'] = 'false';
      $atts['navigation'] = 'false';
    }

    $html = '';
    $html .= '<div id="main-slider" data-height_desk="'.$atts['height_desk'].'" data-height_ipad="'.$atts['height_ipad'].'" data-height_mobile="'.$atts['height_mobile'].'" data-loop="'.$atts['loop'].'" data-auto_slider="'.$atts['auto_slider'].'" data-duration="'.$atts['duration'].'" data-navigation="'.$atts['navigation'].'"  class="owl-carousel owl-theme '.$atts['class'].'">';
    
    $i = 0;
    if($slideshow->have_posts()):
      while($slideshow->have_posts()): $slideshow->the_post();
          
          $id_post = get_the_id();

          $template = get_post_meta($id_post, "_cmb_template", true);
          $link_regis = get_post_meta($id_post, "_cmb_register_link", true);
          $youtube_link = get_post_meta($id_post, "_cmb_youtube_link", true);
          

          $title1 = get_post_meta($id_post, "_cmb_title1", true);
          $title2 = get_post_meta($id_post, "_cmb_title2", true);

          
          
          $slideshow_tem1_register_button = get_post_meta($id_post, "_cmb_slideshow_tem1_register_button", true) ? get_post_meta($id_post, "_cmb_slideshow_tem1_register_button", true) : '';  
          $slideshow_tem2_watchvideo_button = get_post_meta($id_post, "_cmb_slideshow_tem2_watchvideo_button", true) ? get_post_meta($id_post, "_cmb_slideshow_tem2_watchvideo_button", true) : '';
          $slideshow_tem2_register_button = get_post_meta($id_post, "_cmb_slideshow_tem2_register_button", true) ? get_post_meta($id_post, "_cmb_slideshow_tem2_register_button", true) : '';
         
         

          $html .= '<div class="item page text-center slide'.$i.'">
                    <div class="caption">
                        
                            <div class="div-table">
                                <div class="div-cell">';

          /* Style 1 */
          if($template == 'slide1'){

            if(get_post_meta($id_post, "_cmb_end_date", true)){
              $end_date_d = date('d',get_post_meta($id_post, "_cmb_end_date", true));
              $end_date_m = date('m',get_post_meta($id_post, "_cmb_end_date", true));
              $end_date_y = date('Y',get_post_meta($id_post, "_cmb_end_date", true));
              $end_date_h = date('H',get_post_meta($id_post, "_cmb_end_date", true));
              $end_date_i = date('i',get_post_meta($id_post, "_cmb_end_date", true));
            }

            $html .= $title1 ? '<h2 class="caption-title" data-animation="fadeInDown" data-animation-delay="100"><span>'.$title1.'</span></h2>' : '';
            $html .= $title2 ? '<h3 class="caption-subtitle" data-animation="fadeInUp" data-animation-delay="300">'.$title2.'</h3>':'';
            
            if($end_date_d){
              $html .= '<div class="countdown-wrapper">
                            <div class="defaultCountdown clearfix" 
                                       data-years='.$years.' data-months='.$months.' data-weeks="'.$weeks.'" data-days="'.$days.'" data-hours="'.$hours.'" data-minutes="'.$minutes.'" data-seconds="'.$seconds.'" 
                                       data-year='.$year.' data-month='.$month.' data-week="'.$week.'" data-day="'.$day.'" data-hour="'.$hour.'" data-minute="'.$minute.'" data-second="'.$second.'" 
                                       data-end_date_y = "'.$end_date_y.'" data-end_date_m="'.$end_date_m.'" data-end_date_d="'.$end_date_d.'" 
                                       data-end_date_h = "'.$end_date_h.'" data-end_date_i = "'.$end_date_i.'" 
                                       data-timezone = "'.$timezone.'" data-display_format="'.$display_format.'"
                            ></div>
                        </div>';
              
            }

            $html .= get_the_content();

            if($link_regis!= '' && $slideshow_tem1_register_button!= ''){
              $html .= '<p class="caption-text">
                            <a class="btn btn-theme btn-theme-xl scroll-to" href="'.$link_regis.'" data-animation="flipInY" data-animation-delay="600"> '.$slideshow_tem1_register_button.' <i class="fa fa-arrow-circle-right"></i></a>
                        </p>';
            }

          /* Style 2 */    
          } else if($template == 'slide2'){

            
            $html .= $title1 ? '<h2 class="caption-title" data-animation="fadeInDown" data-animation-delay="100"><span>'.$title1.'</span></h2>':'';
            $html .= $title2 ? '<h3 class="caption-subtitle" data-animation="fadeInUp" data-animation-delay="300">'.$title2.'</h3>':'';
          
            $html .= get_the_content();

            $html .='<p class="caption-text">';

            $html .= ($link_regis != '' && $slideshow_tem2_register_button != '') ? '<a class="btn btn-theme btn-theme-xl scroll-to" href="'.$link_regis.'" data-animation="flipInY" data-animation-delay="600">'.$slideshow_tem2_register_button.'&nbsp;<i class="fa fa-arrow-circle-right"></i></a>':'';
            
            $html .= ($youtube_link != '' && $slideshow_tem2_watchvideo_button != '') ? '<a class="btn btn-theme btn-theme-xl btn-theme-transparent-white" href="'.$youtube_link.'" data-gal="prettyPhoto" data-animation="flipInY" data-animation-delay="900">'.$slideshow_tem2_watchvideo_button.'</a>':'';

            $html .= '</p>';
          /* Style 3 */          
          }else if($template == 'slide3'){
            $html .= '
              <div class="row">
                  <div class="col-md-6 col-lg-4">';
                     $html .= do_shortcode(get_the_content());
                  $html .= '</div>
                  <div class="col-md-6 col-lg-8">';
                      if($title1 || $title2){
                      $html .= '<div class="text-holder">';
                          $html .= $title1 ? '<h2 class="caption-title">'.$title1.'</h2>':'';
                          $html .= $title2 ? '<h3 class="caption-subtitle">'.$title2.'</h3>':'';
                        $html .= '</div>';
                      }
                  $html .= '</div>
              </div>
            ';

          /* Style 4 */  
          }else if($template == 'slide4'){

              $html .= $title1 ? '<h2 class="caption-title"><span>'.$title1.'</span></h2>':'';
              $html .= $title2 ? '<h3 class="caption-subtitle">'.$title2.'</h3>':'';
              $html .= get_the_content();

              $html .= ($youtube_link != '') ? '<p class="caption-text">
                            <a class="btn btn-play" href="'.$youtube_link.'" data-gal="prettyPhoto"><i class="fa fa-play"></i></a>
                        </p>':'';
          }

          $i++;
          $html .= '</div></div></div></div>';

      endwhile;
    endif;
     wp_reset_postdata();
    $html .= '</div>';

    
    return $html;
}
/* /Create Slideshow Shortcode */


/* Create Slideshow two Shortcode */
add_shortcode('slideshow_two', 'shortcode_slideshow_two');
function shortcode_slideshow_two($atts, $content = null) {
    global $theme_option;
    $atts = shortcode_atts(
    array(
      'slug_group'  => '',
      'slideshow_order_by' => 'id',
      'slideshow_order' => 'ASC',
      'slideshow_item_count' => '10',
      'auto_slider' => 'true',
      'duration'    => '3000',
      'navigation'  => 'true',
      'loop'        => 'true',
      'height_desk' => '768px',
      'height_ipad' => '768px',
      'height_mobile' => '800px',
      'class'       => '',
    ), $atts);

    $slide_order_by = $atts['slideshow_order_by'];
    $slide_order = $atts['slideshow_order'];
    $posts_per_page = $atts['slideshow_item_count'];
    
    $timezone = $theme_option['slideshow_timezone'] ? $theme_option['slideshow_timezone'] : 0;
    $display_format = $theme_option['display_format'];

    $years = $theme_option['years'];
    $months = $theme_option['months'];
    $weeks = $theme_option['weeks'];
    $days = $theme_option['days'];
    $hours = $theme_option['hours'];
    $minutes = $theme_option['minutes'];
    $seconds = $theme_option['seconds'];
    $year = $theme_option['year'];
    $month = $theme_option['month'];
    $week = $theme_option['week'];
    $day = $theme_option['day'];
    $hour = $theme_option['hour'];
    $minute = $theme_option['minute'];
    $second = $theme_option['second'];


    $end_date_d =  $end_date_m = $end_date_y = '';

    if($slide_order_by == '_cmb_slideshow_order'){
      $args = array(
              'post_type'=>'slideshow',
              'slidegroup'=>$atts['slug_group'],
              'orderby'=> 'meta_value_num',
              'meta_key' => $slide_order_by,
              'order'=> $slide_order,
              'posts_per_page' => $posts_per_page,
              'post_status' => 'publish'
            );  
    }else{
      $args = array(
              'post_type'=>'slideshow',
              'slidegroup'=>$atts['slug_group'],
              'orderby'=> $slide_order_by,
              'order'=> $slide_order,
              'posts_per_page' => $posts_per_page,
              'post_status' => 'publish'
            );
    }
    
    $slideshow = new WP_QUery($args);

    if(count($slideshow->posts) <= 1){
      $atts['loop'] = 'false';
      $atts['navigation'] = 'false';
    }

    $html = '';
    $html .= '<div id="main-slider" data-height_desk="'.$atts['height_desk'].'" data-height_ipad="'.$atts['height_ipad'].'" data-height_mobile="'.$atts['height_mobile'].'" data-loop="'.$atts['loop'].'" data-auto_slider="'.$atts['auto_slider'].'" data-duration="'.$atts['duration'].'" data-navigation="'.$atts['navigation'].'"  class="owl-carousel owl-theme multi-bg '.$atts['class'].'">';
    
    $i = 0;
    if($slideshow->have_posts()):
      while($slideshow->have_posts()): $slideshow->the_post();
          
          $id_post = get_the_id();

          $template = get_post_meta($id_post, "_cmb_template", true);
          $link_regis = get_post_meta($id_post, "_cmb_register_link", true);
          $youtube_link = get_post_meta($id_post, "_cmb_youtube_link", true);
          

          $title1 = get_post_meta($id_post, "_cmb_title1", true);
          $title2 = get_post_meta($id_post, "_cmb_title2", true);

          
          
          $slideshow_tem1_register_button = get_post_meta($id_post, "_cmb_slideshow_tem1_register_button", true) ? get_post_meta($id_post, "_cmb_slideshow_tem1_register_button", true) : '';  
          $slideshow_tem2_watchvideo_button = get_post_meta($id_post, "_cmb_slideshow_tem2_watchvideo_button", true) ? get_post_meta($id_post, "_cmb_slideshow_tem2_watchvideo_button", true) : '';
          $slideshow_tem2_register_button = get_post_meta($id_post, "_cmb_slideshow_tem2_register_button", true) ? get_post_meta($id_post, "_cmb_slideshow_tem2_register_button", true) : '';
         
         $bg_slide = get_the_post_thumbnail_url( $id_post, 'full' );

          $html .= '<div class="item page text-center slide'.$i.'" style="background: url('.$bg_slide.') no-repeat" >
                    <div class="caption">
                        
                            <div class="div-table">
                                <div class="div-cell"><div class="container">';
          /* Style 1 */
          if($template == 'slide1'){

            if(get_post_meta($id_post, "_cmb_end_date", true)){
              $end_date_d = date('d',get_post_meta($id_post, "_cmb_end_date", true));
              $end_date_m = date('m',get_post_meta($id_post, "_cmb_end_date", true));
              $end_date_y = date('Y',get_post_meta($id_post, "_cmb_end_date", true));
              $end_date_h = date('H',get_post_meta($id_post, "_cmb_end_date", true));
              $end_date_i = date('i',get_post_meta($id_post, "_cmb_end_date", true));
            }

            $html .= $title1 ? '<h2 class="caption-title" data-animation="fadeInDown" data-animation-delay="100"><span>'.$title1.'</span></h2>' : '';
            $html .= $title2 ? '<h3 class="caption-subtitle" data-animation="fadeInUp" data-animation-delay="300">'.$title2.'</h3>':'';
            
            if($end_date_d){
              $html .= '<div class="countdown-wrapper">
                            <div class="defaultCountdown clearfix" 
                                       data-years='.$years.' data-months='.$months.' data-weeks="'.$weeks.'" data-days="'.$days.'" data-hours="'.$hours.'" data-minutes="'.$minutes.'" data-seconds="'.$seconds.'" 
                                       data-year='.$year.' data-month='.$month.' data-week="'.$week.'" data-day="'.$day.'" data-hour="'.$hour.'" data-minute="'.$minute.'" data-second="'.$second.'" 
                                       data-end_date_y = "'.$end_date_y.'" data-end_date_m="'.$end_date_m.'" data-end_date_d="'.$end_date_d.'" 
                                       data-end_date_h = "'.$end_date_h.'" data-end_date_i = "'.$end_date_i.'" 
                                       data-timezone = "'.$timezone.'" data-display_format="'.$display_format.'"
                            ></div>
                        </div>';
              
            }

            $html .= get_the_content();

            if($link_regis!= '' && $slideshow_tem1_register_button!= ''){
              $html .= '<p class="caption-text">
                            <a class="btn btn-theme btn-theme-xl scroll-to" href="'.$link_regis.'" data-animation="flipInY" data-animation-delay="600"> '.$slideshow_tem1_register_button.' <i class="fa fa-arrow-circle-right"></i></a>
                        </p>';
            }

          /* Style 2 */    
          } else if($template == 'slide2'){

            
            $html .= $title1 ? '<h2 class="caption-title" data-animation="fadeInDown" data-animation-delay="100"><span>'.$title1.'</span></h2>':'';
            $html .= $title2 ? '<h3 class="caption-subtitle" data-animation="fadeInUp" data-animation-delay="300">'.$title2.'</h3>':'';
          
            $html .= get_the_content();

            $html .='<p class="caption-text">';

            $html .= ($link_regis != '' && $slideshow_tem2_register_button != '') ? '<a class="btn btn-theme btn-theme-xl scroll-to" href="'.$link_regis.'" data-animation="flipInY" data-animation-delay="600">'.$slideshow_tem2_register_button.'&nbsp;<i class="fa fa-arrow-circle-right"></i></a>':'';
            
            $html .= ($youtube_link != '' && $slideshow_tem2_watchvideo_button != '') ? '<a class="btn btn-theme btn-theme-xl btn-theme-transparent-white" href="'.$youtube_link.'" data-gal="prettyPhoto" data-animation="flipInY" data-animation-delay="900">'.$slideshow_tem2_watchvideo_button.'</a>':'';

            $html .= '</p>';
          /* Style 3 */          
          }else if($template == 'slide3'){
            $html .= '
              <div class="row">
                  <div class="col-md-6 col-lg-4">';
                     $html .= do_shortcode(get_the_content());
                  $html .= '</div>
                  <div class="col-md-6 col-lg-8">';
                      if($title1 || $title2){
                      $html .= '<div class="text-holder">';
                          $html .= $title1 ? '<h2 class="caption-title">'.$title1.'</h2>':'';
                          $html .= $title2 ? '<h3 class="caption-subtitle">'.$title2.'</h3>':'';
                        $html .= '</div>';
                      }
                  $html .= '</div>
              </div>
            ';

          /* Style 4 */  
          }else if($template == 'slide4'){

              $html .= $title1 ? '<h2 class="caption-title"><span>'.$title1.'</span></h2>':'';
              $html .= $title2 ? '<h3 class="caption-subtitle">'.$title2.'</h3>':'';
              $html .= get_the_content();

              $html .= ($youtube_link != '') ? '<p class="caption-text">
                            <a class="btn btn-play" href="'.$youtube_link.'" data-gal="prettyPhoto"><i class="fa fa-play"></i></a>
                        </p>':'';
          }

          $i++;
          $html .= '</div></div></div></div></div>';

      endwhile;
    endif;
     wp_reset_postdata();
    $html .= '</div>';

    
    return $html;
}
/* /Create Slideshow Two Shortcode */


/* Create Adress Shortcode */
add_shortcode('address', 'address_shortcode');
function address_shortcode($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(      
      'date'  => '',
      'location'  => '',
      'remaining' => '',
      'speakers'  => '',
      'class' => '',
    ), $atts);

    $html = '
      <div class="event-description '.$atts['class'].'">        
        <div class="event-background">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="media">
                                    <span class="pull-left">
                                        <i class="fa fa-calendar fa-2x"></i>
                                    </span>
                            <div class="media-body">
                                <h4 class="media-heading">'.__('Date', TEXT_DOMAIN_SHORTCODE).'</h4>
                                <span>'.$atts['date'].'</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="media">
                                    <span class="pull-left">
                                        <i class="fa fa-map-marker fa-2x"></i>
                                    </span>
                            <div class="media-body">
                                <h4 class="media-heading">'.__('Location', TEXT_DOMAIN_SHORTCODE).'</h4>
                                <span>'.$atts['location'].'</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2">
                        <div class="media">
                                    <span class="pull-left">
                                        <i class="fa fa-group fa-2x media-object"></i>
                                    </span>
                            <div class="media-body">
                                <h4 class="media-heading">'.__('Remaining', TEXT_DOMAIN_SHORTCODE).'</h4>
                                <span>'.$atts['remaining'].'</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="media">
                                    <span class="pull-left">
                                        <i class="fa fa-microphone fa-2x"></i>
                                    </span>
                            <div class="media-body">
                                <h4 class="media-heading">'.__('Speakers', TEXT_DOMAIN_SHORTCODE).'</h4>
                                <span>'.$atts['speakers'].'</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
    ';

    return $html;
}

/* /Create Adress Shortcode */


/* address_parent shortcode */
add_shortcode('address_parent', 'address_parent_shortcode');
function address_parent_shortcode($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(
      'class' => '',
      'background_color'  => '#0d1d31'
    ), $atts);

    $html = '
      <div class="event-description '.$atts['class'].'">        
        <div class="event-background" style="background-color:'.$atts['background_color'].'">
            <div class="container-fluid">
                <div class="row">
                    '.do_shortcode($content).'
                </div>
            </div>        
        </div>
    </div>
    ';

    return $html;
}

/* /address_parent shortcode */


/* address_item shortcode */
add_shortcode('address_item', 'address_item_shortcode');
function address_item_shortcode($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(
      'font_awesome'  => '',
      'title'          => '',
      'icon_direct'   => 'pull-left',
      'date'          => '',
      'column_width'  => '3',
      'class'         => '',
    ), $atts);

    $html = '
            <div class="col-md-'.$atts['column_width'].'">
              <div class="media '.$atts['class'].'">
                          <span class="'.$atts['icon_direct'].'">
                              <i class="fa '.$atts['font_awesome'].' fa-2x"></i>
                          </span>
                  <div class="media-body">
                      <h4 class="media-heading">'.$atts['title'].'</h4>
                      <span>'.$atts['date'].'</span>
                  </div>
              </div>
            </div>
    ';

    return $html;
}

/* /address_item shortcode */


/* Create Heading Shortcode */
add_shortcode('heading', 'heading_shortcode');
function heading_shortcode($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(      
      'title'  => '',      
      'subtitle'  => '',
      'fontclass' => '',
      'delay' => '',
      'icon_style'  => 'rhex',
      'class' => '',
    ), $atts);

    $html = '';
    $html .= '
      <h3 class="section-title '.$atts['class'].'">';
          $html .=  ( $atts['fontclass'] != '' ) ? '<span data-animation="flipInY" data-animation-delay="'.$atts['delay'].'" class="icon-inner"><span class="fa-stack"><i class="fa '.$atts['icon_style'].' fa-stack-2x"></i><i class="fa '.$atts['fontclass'].' fa-stack-1x"></i></span></span>' : '';
          $html .= '<span data-animation="fadeInRight" data-animation-delay="500" class="title-inner">'.$atts['title'].' <small> '.$atts['subtitle'].'</small></span>';
      $html .= '</h3>
    ';
    return $html;

}

/* Create heading_normal Shortcode */
add_shortcode('heading_normal', 'heading_normal');
function heading_normal($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(      
      'title'  => '',      
      'subtitle'  => '',
      'fontclass1' => '',
      'fontclass2' => '',
      'delay' => '',
      'class' => '',
    ), $atts);

    $html = '';
    $html .= '
      <h3 class="section-title '.$atts['class'].' normal">
          <span data-animation="flipInY" data-animation-delay="'.$atts['delay'].'" class="icon-inner"><span class="fa-stack"><i class="fa '.$atts['fontclass1'].' fa-stack-2x"></i><i class="fa '.$atts['fontclass2'].' fa-stack-1x"></i></span></span>
          <span data-animation="fadeInRight" data-animation-delay="500" class="title-inner">'.$atts['title'].' <small> '.$atts['subtitle'].'</small></span>
      </h3>
    ';
    return $html;

}

/* /Create Heading Shortcode */

/* Create thumbnail image */
add_shortcode('thumbnail', 'thumbnail_shortcode');
function thumbnail_shortcode($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(      
      'thumbnail'  => '',
      'alt' => '',
      'pathimage'  => '',
      'pathvideo'  => '',
      'class' => '',
    ), $atts);

    $thumbnail = wp_get_attachment_image_src($atts['thumbnail'], 'full');
    $pathimage = wp_get_attachment_image_src($atts['pathimage'], 'full');
    $pathvideo = $atts['pathvideo'];
    $path = '#';
    if($pathimage){
      $path = $pathimage['0'];
    }elseif($pathvideo){
      $path = $pathvideo;
    }

    $html = '
      <div class="thumbnail no-border no-padding '.$atts['class'].'" data-animation="fadeInLeft" data-animation-delay="100">
          <div class="media">
              <img src="'.$thumbnail['0'].'" alt="'.$atts['alt'].'" class="img-responsive">
              <div class="caption hovered">
                  <div class="caption-wrapper div-table">
                      <div class="caption-inner div-cell">
                          <p class="caption-buttons"><a href="'.$path.'" class="btn caption-zoom" data-gal="prettyPhoto"><i class="fa fa-search"></i></a></p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    ';

    return $html;
}
/* /Create thumbnail image */

/* Create button */
add_shortcode('button', 'button_shortcode');
function button_shortcode($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(      
      'title' => '',
      'link'  => '',      
      'target'  => 'blank',
      'showicon'  => 'left',
      'fontawesome'=>'',
      'margin'     => '' ,
      'class' => '',
    ), $atts);
    $html = '';

    $title = $atts['title'];
    $link = $atts['link'];    
    $scrollto = '';
    $target = '';

    if($atts['target'] == 'blank'){
      $target = "target='_blank'";
    }elseif($atts['target'] == 'inline'){
      $target = "";
    }else if($atts['target'] == 'scrollto'){
      $target = "";
      $scrollto = 'scroll-to';
    }    
    
    
    if($atts['showicon'] == 'left'){
      $html .= '<a href="'.$atts['link'].'" '.$target.' style="margin: '.$atts['margin'].'" class="btn btn-theme animated flipInY visible  '.$scrollto .$atts['class'].'" data-animation="flipInY" data-animation-delay="200"><i class="fa '.$atts["fontawesome"].'"></i> '.$title.'</a>';
    }if($atts['showicon'] == 'right'){
      $html .= '<a href="'.$atts['link'].'" '.$target.' style="margin: '.$atts['margin'].'" class="btn btn-theme animated flipInY visible  '.$scrollto .$atts['class'].'" data-animation="flipInY" data-animation-delay="200">'.$title.' <i class="fa '.$atts["fontawesome"].'"></i></a>';
    }if($atts['showicon'] == 'none'){
      $html .= '<a href="'.$atts['link'].'" '.$target.' style="margin: '.$atts['margin'].'" class="btn btn-theme animated flipInY visible  '.$scrollto .$atts['class'].'" data-animation="flipInY" data-animation-delay="200">'.$title.'</a>';
    }
    

    return $html;

}
/* /Create button  */

/* Create buttonpopup */
add_shortcode('buttonpopup', 'buttonpopup_shortcode');
function buttonpopup_shortcode($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(      
      'title' => '',
      'imagepath'  => '',
      'videopath'  => '',
      'margin'     => '' ,
      'class' => '',
    ), $atts);
    $html = '';
    $path = '';
    if($atts['imagepath']){
        $path = $atts['imagepath'];
    }elseif($atts['videopath']){
        $path = $atts['videopath'];
    }
    $html .= '<a href="'.$path.'" style="margin: '.$atts['margin'].'" data-gal="prettyPhoto" class="btn btn-theme animated flipInY visible  ' .$atts['class'].'" data-animation="flipInY" data-animation-delay="200">'.$atts['title'].'</a>';

    return $html;
}
/* /Create buttonpopup */


/* Create makedonation */
add_shortcode('makedonation', 'makedonation_shortcode');
function makedonation_shortcode($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(      
      'title' => '',
      'paypalemail'  => '',
      'amount'  => '',
      'currency_code'     => '' ,
      'class' => '',
    ), $atts);
    $html = '';

    $html .= '
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="'.$atts['class'].'">

          <!-- Identify your business so that you can collect the payments. -->
          <input type="hidden" name="business" value="'.$atts['paypalemail'].'">

          <!-- Specify a Donate button. -->
          <input type="hidden" name="cmd" value="_donations">
          <!-- Specify details about the contribution -->
          <input type="hidden" name="item_name" value="Donate">
          <input type="hidden" name="item_number" value="">
          <input type="hidden" name="amount" value="'.$atts['amount'].'">
          <input type="hidden" name="currency_code" value="'.$atts['currency_code'].'">
          <!-- Display the payment button. -->
          <button name="submit" class="btn btn-theme">'.$atts['title'].'</button>
          <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif">
      </form>
    ';

    return $html;
}


/* /Create makedonation */


/* Create sponsors */
add_shortcode('sponsors', 'sponsors_shortcode');
function sponsors_shortcode($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'auto'      => 'true',
      'show_nav'  => 'true',
      'itemslide' => '5',
      'loop'      => 'true',
      'autoplaytimeout' => '3000',
      'animation' => 'fadeInUp',
      'animation_delay' => '300',
      'class'     => '',
    ), $atts);
    

    $html = '
      <div class="partners-carousel '.$atts['class'].'"  data-animation="'.$atts['animation'].'" data-animation-delay="'.$atts['animation_delay'].'">
          <div class="owl-carousel" data-auto="'.$atts['auto'].'" data-show_nav="'.$atts['show_nav'].'" data-loop="'.$atts['loop'].'" data-itemslide="'.$atts['itemslide'].'" data-autoplaytimeout="'.$atts['autoplaytimeout'].'">'.do_shortcode($content).'</div>
      </div>
    ';

    return $html;
    
}

add_shortcode('item_sponsors', 'item_sponsors_shortcode');
function item_sponsors_shortcode($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'thumbnail' => '',
      'link'  => '',
      'target' => '_blank',
      'alt'   => '',
    ), $atts);
    $html = '';
    $thumbnail = '';

    if(wp_get_attachment_image_src($atts['thumbnail'], 'full')){
        $obj_thumbnail = wp_get_attachment_image_src($atts['thumbnail'], 'full');
        $thumbnail = $obj_thumbnail['0'];
    }else if($atts['thumbnail']!= ''){
        $thumbnail = $atts['thumbnail'];
    }
    if($atts['link'] != ''){
       $html .='<div><a href="'.$atts['link'].'" target="'.$atts['target'].'"><img src="'.$thumbnail.'" alt="'.$atts['alt'].'"/></a></div>'; 
    }else{
      $html .='<div><img src="'.$thumbnail.'" alt="'.$atts['alt'].'"/></div>';
    }
    

    return $html;
}
/* /Create item sponsor */


/* Create testimonial */
add_shortcode('testimonial', 'testimonial_shortcode');
function testimonial_shortcode($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'timeout' => '3000',
      'auto'    => 'true',
      'loop'    => 'true',
      'class'   => ''
    ), $atts);
    $atts['timeout'] = $atts['timeout']?$atts['timeout']:'3000';
    $atts['auto'] = $atts['auto']?$atts['auto']:'true';
    $atts['loop'] = $atts['loop']?$atts['loop']:'true';
    $html = '
      <div  class="owl-carousel testimonials '.$atts['class'].'" data-loop="'.$atts['loop'].'" data-auto="'.$atts['auto'].'" data-timeout="'.$atts['timeout'].'" data-animation="fadeInUp" data-animation-delay="100">'.do_shortcode( $content ).'
      </div>
    ';

    return $html;
    
}

add_shortcode('item_testimonial', 'item_testimonial_shortcode');
function item_testimonial_shortcode($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'thumbnail' => '',
      'alt'   => '',
      'author' => '',
      'style'     => 'rhex',
    ), $atts);

    $html = '';
    $thumbnail = '';

    if(wp_get_attachment_image_src($atts['thumbnail'], 'full')){
        $obj_thumbnail = wp_get_attachment_image_src($atts['thumbnail'], 'full');
        $thumbnail = $obj_thumbnail['0'];
    }else if($atts['thumbnail']!= ''){
        $thumbnail = $atts['thumbnail'];
    }

    $html .='
      <div class="media testimonial">
        <div class="media-object pull-right" data-animation="flipInY" data-animation-delay="300">';
          if( $thumbnail != '' ){
            if($atts['style'] == 'wohex'){
              $html .='<div class="wohexagon testimonial-avatar">
                          <div class="wohexagon-inner">
                            <img class="img-responsive" src="'.$thumbnail.'" alt="'.$atts['alt'].'"/>
                          </div>
                      </div>';
            }else if($atts['style'] == 'crcle'){
                $html .='<div class="testimonial-avatar">
                  <img class="img-responsive img-circle" src="'.$thumbnail.'" alt="'.$atts['alt'].'"/>
                </div>
                ';
            }else{
              $html .= '<div class="hex testimonial-avatar">
                  <div class="hex-deg">
                      <div class="hex-deg">
                          <div class="hex-deg">
                              <div class="hex-inner">
                                <img class="img-responsive" src="'.$thumbnail.'" alt="'.$atts['alt'].'"/>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>';  
            }
          }  

        $html .='</div>
        <div class="media-body">';
            $html .= ( $content != '' ) ? '<p>'.do_shortcode( $content ).'</p>' : '';
            $html .= ( $atts['author'] ) ? '<h4 class="media-heading"> '.__('by', TEXT_DOMAIN_SHORTCODE).' '.$atts['author'].'</h4>':'';
        $html .= '</div>
    </div>
    ';

    return $html;
}
/* /Create item testimonial */

/* Create pricing */
add_shortcode('pricing', 'pricing_shortcode');
function pricing_shortcode($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'name' => '',
      'pricing_style' => 'ca',
      'value'   => '',
      'currency' => '',
      'feature' => 'nofeature',
      'name_button'  => '',
      'link_button' =>'',
      'extra_link' => 'true',
      'target' => '_self',
      'class'     => '',
    ), $atts);
    $html = '';
    $html .= '
      <div class="price-table '.$atts['class'].' '.$atts['feature'].'" data-animation="fadeInUp" data-animation-delay="100">
          <div class="price-table-header">
              <div class="price-label">
                  <h2 class="price-label-title">'.$atts['name'].'</h2>
              </div>
              <div class="price-value">';

               if($atts['pricing_style'] == 'ac'){
                  $html .= '<span class="price-number">'.$atts['value'].'</span><span class="price-unit">'.$atts['currency'].'</span><span class="price-per"></span>';
               }else{
                  $html .= '<span class="price-unit">'.$atts['currency'].'</span><span class="price-number">'.$atts['value'].'</span><span class="price-per"></span>';
               }
                  

              $html .= '</div>
          </div>
          <div class="price-table-rows"><p>'.do_shortcode( $content ).'</p>';
            if($atts['extra_link'] == 'true'){
                $html .= '<div class="price-table-row-bottom">
                  <a class="btn btn-theme " target="'.$atts['target'].'" href="'.$atts['link_button'].'">'.$atts['name_button'].'</a>
              </div>';
            }else{
              $html .= '<div class="price-table-row-bottom">
                  <a class="btn btn-theme scroll-to" href="'.$atts['link_button'].'">'.$atts['name_button'].'</a>
              </div>';
            }

          $html .= '</div>
      </div>
    ';

    return $html;

} 
/* /Create pricing */


/* Create latestblog */
add_shortcode('latestblog', 'latestblog_shortcode');
function latestblog_shortcode($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'category'=>'',
      'count' => '3',
      'showdate'  => 'true',
      'showcomment' => 'true',
      'showdescription' => 'true',
      'showreadmore'  => 'true',
    ), $atts);

  if ($atts['category']=='') {
    $args=array('post_type' => 'post', 'posts_per_page' => $atts['count'], 'post_status' => 'publish');
  }else{
    $args=array('post_type' => 'post', 'cat'=>$atts['category'],'posts_per_page' => $atts['count'], 'post_status' => 'publish');
  }
      
  $blog = new WP_Query($args);
  $k = 0;  
ob_start(); ?>
<?php while($blog->have_posts()) : $blog->the_post(); ?>
  <?php if($k == 3){ ?>
    <div class="clearfix"></div>
  <?php $k =0 ;} $k++;?>
  <div class="col-md-4" style="margin-bottom: 30px;">
    <article class="post-wrap" data-animation="fadeInUp" data-animation-delay="100">
        <div class="post-media">

            <?php if(has_post_format('video')){ ?>                
                <div class="js-video">
                    <?php echo wp_oembed_get(get_post_meta(get_the_id(), "_cmb_embed_media", true)); ?>
                </div>

            <?php } elseif(has_post_format('audio')){ ?>                
                <div class="js-video">
                    <?php echo wp_oembed_get(get_post_meta(get_the_id(), "_cmb_embed_media", true)); ?>
                </div>

            <?php }else{ ?>

                <?php $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'thumbnail_350x175'); ?>
                <?php if($thumbnail_url){ ?>                    
                    <img  src="<?php  echo $thumbnail_url[0]; ?>"  alt="" class="img-responsive">
                <?php } ?>

            <?php } ?>
        </div>

        <div class="post-header">
            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title( ); ?></a></h2>
            <div class="post-meta">
                <?php if($atts['showdate'] == 'true'){ ?>
                <span class="post-date">
                    <?php _e('Posted on', TEXT_DOMAIN_SHORTCODE); ?>
                    
                    <span class="day"> <?php the_time( get_option( 'date_format' ));?></span>
                    
                </span>
                <?php } ?>
                <?php if($atts['showcomment'] == 'true'){ ?>
                  <span class="pull-right">
                      <i class="fa fa-comment"></i>                       
                          <?php comments_popup_link(__(' 0', TEXT_DOMAIN_SHORTCODE), __(' 1', TEXT_DOMAIN_SHORTCODE), ' %'.__('', TEXT_DOMAIN_SHORTCODE)); ?>                      
                  </span>
                <?php } ?>
            </div>
        </div>
        <?php if($atts['showdescription'] == 'true'){ ?>
          <div class="post-body">
              <div class="post-excerpt">
                  <?php the_excerpt(); /* Category */ ?>                  
              </div>
          </div>
        <?php } ?>
       
        <?php if($atts['showreadmore'] == 'true'){ ?>
          <div class="post-footer">
              <span class="post-readmore">
                  <a href="<?php the_permalink(); ?>" class="btn btn-theme btn-theme-transparent"><?php  _e('Read more', TEXT_DOMAIN_SHORTCODE); ?></a>
              </span>
          </div>
        <?php } ?>
       
    </article>
  </div>
<?php endwhile; ?>
<?php
   wp_reset_postdata();
    return ob_get_clean();
}
/* /Create latest blog */

/* Create location */
add_shortcode('location', 'pricing_location');
function pricing_location($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'defineid'  => 'map-canvas',
      'latitude'  => '40.9807648',
      'longitude' => '28.9866516',
      'zoom'      => '12',
      'heading' => '',
      'fontclass'=>'',
      'fontclass2'=>'',
      'button_name'   => '',
      'button_font_class' => '',
      'button_link' => '',
      'target_link' => '_self',
      'marker_title' => '',
      'style_icon'  => 'rhex',
      'class'  => '',
    ), $atts);
    $html = '';

    $valen_class = ($atts['style_icon'] == 'valentine') ? $atts['fontclass2']: '';

    $html .= '
      <div class="container full-width gmap-background">
        <div class="container '.$atts['class'].'">
            <div class="on-gmap color">';
                $html .= $atts['heading'] ? '<h3 class="section-title">
                    <span data-animation="flipInY" data-animation-delay="100" class="icon-inner"><span class="fa-stack"><i class="fa '.$valen_class.' '.$atts['style_icon'].' fa-stack-2x"></i><i class="fa '.$atts['fontclass'].' fa-stack-1x"></i></span></span>
                    <span data-animation="fadeInRight" data-animation-delay="100" class="title-inner">'.$atts['heading'].'</span>
                </h3>':'';

                $html .= '<p>'.do_shortcode( $content ).'</p>';

                $html .= ($atts['button_name']) ? '<a target="'.$atts['target_link'].'" href="'.$atts['button_link'].'" class="btn btn-theme"
                   data-animation="flipInY" data-animation-delay="300">'.$atts['button_name'].' <i class="fa '.$atts['button_font_class'].'"></i></a>':'';

            $html .= '</div>
        </div>
        
        <div class="google-map" data-zoom="'.$atts['zoom'].'" data-latitude="'.$atts['latitude'].'" data-longitude="'.$atts['longitude'].'" data-defineid="'.$atts['defineid'].'" data-marker_title="'.$atts['marker_title'].'">
            <div id="'.trim($atts['defineid']).'"></div>
        </div>
      </div>
    ';

    return $html;

}
/* /Create location */



/* Register Form Shortcode */
add_shortcode('registerform', 'registerform_shortcode');
function registerform_shortcode($atts, $content = null) {
  global $theme_option;
  $atts = shortcode_atts(
    array(
      'id'        => '',
      'class'     => '',
      'template'  => 'template-1',
      'buttontext'  => ''
    ), $atts);

    $unique = uniqid();

    $buttontext = ($atts['buttontext']!= '') ? $atts['buttontext'] : __('Register Now', TEXT_DOMAIN_SHORTCODE);

    if(is_front_page () ){
      $form_action = 'index.php';  
    }else{
      $form_action = home_url('/');
    }

    $html = '';
    if($atts['template'] == 'template-1'){
      $html .= '<form data-uni="'.$atts['id'].$unique.'" id="'.$atts['id'].'" name="registration-form" class="registration-form '.$atts['class'].'" action="'.$form_action.'" method="post">';
      $html .= '<div class="col-md-12 event_loading hide text-center"><img class="img-responsive" src="'.get_template_directory_uri()."/assets/img/preloader.gif".'" alt="'.__('registing', TEXT_DOMAIN_SHORTCODE).'"></div>';
      $html .= '<div class="row"><div class="col-sm-12 form-alert"></div>';
    }else if($atts['template'] == 'template-2'){
      $html .='<div class="form-background">';
     $html .= '<form data-uni="'.$atts['id'].$unique.'" id="'.$atts['id'].'" name="registration-form" class="registration-form alt '.$atts['class'].'" action="'.$form_action.'" method="post">';
     $html .= '<div class="row"><div class="col-sm-12 form-alert"></div>';
     $html .= '<div class="col-md-12 event_loading hide text-center"><img class="img-responsive" src="'.get_template_directory_uri()."/assets/img/preloader.gif".'" alt="'.__('registing', TEXT_DOMAIN_SHORTCODE).'"></div>';
    }

    $json_register_fields = json_decode($theme_option['json_register_fields']);
    $animate_form = $theme_option['animate_form'];
    $paypal_active = $theme_option['paypal_active'];
    $register_environment = $theme_option['register_environment'];
    $register_currency_code_paypal = $theme_option['register_currency_code_paypal'];
    $register_email_paypal = $theme_option['register_email_paypal'];
    $register_price_paypal = $theme_option['register_price_paypal'];
    $register_thanks_page  = $theme_option['register_thanks_page']?$theme_option['register_thanks_page']:home_url();
    $register_cancel_page = $theme_option['register_cancel_page']?$theme_option['register_cancel_page']:home_url();
    $register_title_paypal = $theme_option['register_title_paypal'];    
    $register_success_msg = $theme_option['register_success_msg'];

    $register_emailclient = isset($theme_option['register_emailclient']) ? $theme_option['register_emailclient']: 'email';
    
    $register_notify_paypal_page = home_url().'/wp-content/plugins/imevent-common/paypal/notify_paypal.php';
    $i=rand();
  if($json_register_fields){
    foreach ($json_register_fields as $key => $value) {


        $require_class = '';
        $require = '';

        $price_paypal_class = '';

        if(isset($value->require)){
          $require = $value->require;
        }


        if($require == 'true'){
        $require_class = 'require';
        }

        if($key == $register_price_paypal){
        $price_paypal_class = 'unique_price_paypal';
        }

        if($atts['template'] == 'template-1'){
        $html .= '<div class="'.$value->class.' form-group">';  
        }else if($atts['template'] == 'template-2'){
        $html .= '<div class="col-md-12 form-group">';  
        }
        

        if($animate_form){ $html .= '<div data-animation="fadeInUp" data-animation-delay="200">'; }

        // Display TextField field
        if($value->type=='textfield'){
        $html .= '<input  type="text" class="get_data form-control  field'.$key.' input-text '.$require_class.' '.$price_paypal_class.'" data-toggle="tooltip" data-placeholder="'.$value->label.'" data-place="'.$key.'"
            title="'.$value->label.'" value="'.$value->value.'" placeholder="'.$value->label.'" />';
        }

        // Display Email Field
        if($value->type=='email'){
          if($key == $register_emailclient){
            $html .= '<input  data-placeholder="'.$value->label.'"  data-place="'.$key.'" type="text" class="get_data form-control imevent_register_emailclient  field'.$key.' input-email '.$require_class.' '.$price_paypal_class.'" data-toggle="tooltip" 
            title="'.$key.'" value="'.$value->value.'"  placeholder="'.$value->label.'"/>';  
          }else{
            $html .= '<input  data-placeholder="'.$value->label.'"  data-place="'.$key.'" type="text" class="get_data form-control  field'.$key.' input-email '.$require_class.' '.$price_paypal_class.'" data-toggle="tooltip" 
              title="'.$key.'" value="'.$value->value.'"  placeholder="'.$value->label.'"/>';
          }
          
        }


        // Display Url Field
        if($value->type=='url'){
        $html .= '<input  data-placeholder="'.$value->label.'"   data-place="'.$key.'" type="text" class="get_data form-control  field'.$key.' input-url '.$require_class.' '.$price_paypal_class.'" data-toggle="tooltip" 
            title="'.$key.'" value="'.$value->value.'"  placeholder="'.$value->label.'"/>';
        }


        // Display number Field
        if($value->type=='number'){
        $html .= '<input  data-placeholder="'.$value->label.'"   data-place="'.$key.'" type="text" class="get_data form-control  field'.$key.' input-number '.$require_class.' '.$price_paypal_class.'" data-toggle="tooltip" 
            title="'.$key.'" value="'.$value->value.'"  placeholder="'.$value->label.'"/>';
        }

        // Display date Field
        if($value->type=='date'){            
        $html .= '<input   data-placeholder="'.$value->label.'"  data-place="'.$key.'"  data-format="'.$value->format.'" type="text" data-idunique="'.$key.$unique.'" id="'.$key.$unique.'" placeholder="'.$value->label.'" data-toggle="tooltip" title="'.$value->label.'" class="get_data form-control  field'.$key.' input-date '.$require_class.' '.$price_paypal_class.'" />';
         
        }
        

        // Display textarea Field
        if($value->type=='textarea'){
        $html .= '<textarea   data-placeholder="'.$value->label.'"  data-place="'.$key.'"  class="get_data form-control  field'.$key.' input-textarea '.$require_class.' '.$price_paypal_class.'" placeholder="'.$value->label.'" rows="'.$value->rows.'" cols="'.$value->cols.'" data-toggle="tooltip" title="'.$value->label.'">'.$value->value.'</textarea>';
        }

        // Display Dropdown Field
        if($value->type=='dropdown'){
        $html .= '<select  title="'.$value->label.'"  data-placeholder="'.$value->label.'"  data-place="'.$key.'" class="get_data form-control dropdown_style field'.$key.' selectpicker input-price '.$require_class.' '.$price_paypal_class.'" data-live-search="true" data-width="100%" data-toggle="tooltip">
              <option  selected="selected" value="">'.$value->label.'</option>';                        
              foreach ($value->value as $key_opt => $value_opt) {
                $html .= '<option  value="'.$value_opt.'">'.$key_opt.'</option>';
              }
              
            $html .= '</select>';
        }

        // Display checkbox field
         if($value->type=='checkbox'){
          $html .= '<label>'.$value->label.'</label><br/>';
          foreach ($value->value as $key_check => $value_check) {
          $html .= '<input  class="get_data   field'.$key.' '.$price_paypal_class.'"  type="checkbox" name="'.$key.'" value="'.$value_check.'"> '.$key_check.'<br>';
          }
        }

        // Display radio field
        if($value->type=='radio'){
          $html .= '<label>'.$value->label.'</label><br/>';
          foreach ($value->value as $key_rad => $value_rad) {
          $checked = '';
          if($value_rad == $value->value_default){
            $checked = 'checked';
          }
          $html .= '<input  '.$checked.' class="get_data   field'.$key.' '.$price_paypal_class.'"  data-placeholder="'.$value->label.'"  data-place="'.$key.'" type="radio" name="'.$key.'" value="'.$value_rad.'"> '.$key_rad.'<br>';                
          }
        }
        $i++;
        // Display message field
        if($value->type=='message'){
          $html .= $value->value;
        }

        $html .= '</div>';
        if($animate_form){ $html .= '</div>';}

    } // endforeach
  } // endif
    if($atts['template'] == 'template-1'){
      $html .= '<div class="col-md-12"></div><div class="col-md-offset-4 col-md-4 overflowed register_pay_button">';
    }else if($atts['template'] == 'template-2'){
      $html .= '<div class="col-md-12 overflowed register_pay_button register_tempalte_2">';
    }
    $html .='
                  <div class="text-center margin-top">';
                  if($animate_form){
                    $html .= '<button data-idform="'.$atts['id'].'" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-theme-xl submit-button" 
                      type="submit"> '.$buttontext.' <i class="fa fa-arrow-circle-right"></i></button>';
                  }else{
                    $html .= '<button data-idform="'.$atts['id'].'" class="btn btn-theme btn-theme-xl submit-button" 
                      type="submit"> '.$buttontext.' <i class="fa fa-arrow-circle-right"></i></button>';
                  }
                      
                  $html .= '</div>
              </div>';

    $html .= '</div>';

    $html .= '    
          <input type="hidden" class="input-paypal_active" name="paypal_active" value="'.$paypal_active.'">
          <input type="hidden" class="input-register_environment" value="'.$register_environment.'">
          <input type="hidden" class="input-paypal" value="'.$register_email_paypal.'">
          <input type="hidden" class="input-currency_code" value="'.$register_currency_code_paypal.'">
          <input type="hidden" class="input-return_url" value="'.$register_thanks_page.'">
          <input type="hidden" class="input-cancel_url" value="'.$register_cancel_page.'">
          <input type="hidden" class="input-register_title_paypal" value="'.$register_title_paypal.'">          
          <input type="hidden" class="register_notify_paypal_page" value="'.$register_notify_paypal_page.'">
          <input type="hidden" class="custom" name="custom"  value="'.uniqid().'">
          <input type="hidden" class="register_success_msg" value="'.$register_success_msg.'">          
          ';

    if($atts['template'] == 'template-1'){
      $html .= '</form>';
    } else if($atts['template'] == 'template-2'){
      $html .= '</form></div>';
    }     
    

    return $html;
}
/* /Register Form Shortcode */

/* iframe eventbrite */
add_shortcode('imevent_iframe_eventbrite', 'imevent_iframe_eventbrite');
function imevent_iframe_eventbrite($atts, $content = null) {

  $atts = shortcode_atts(
      array(
        'id' => '',
        'class' => '',
    ), $atts);

    $html = '';

    $html .= '
        <div class="iframe_eventbrite '.$atts['class'].'">
          <iframe src="//eventbrite.com/tickets-external?eid='.$atts['id'].'&amp;ref=etckt" height="314" width="100%" frameborder="0" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>
        </div>
    ';

    return $html;

}
/* /iframe eventbrite */


/* Banner */
add_shortcode('imevent_banner', 'imevent_banner');
function imevent_banner($atts, $content = null) {

  $atts = shortcode_atts(
      array(
        'title' => '',
        'subtitle' => '',
        'end_date_y'  => '',
        'end_date_m' => '',
        'end_date_d'  => '',
        'end_date_h'  => '',
        'end_date_i'  => '',
        'timezone' => '0',
        'display_format' => 'dHMS',
        'years' => 'years',
        'months' => 'months',
        'weeks' => 'weeks',
        'days' => 'days',
        'hours' => 'hours',
        'minutes' => 'minutes',
        'seconds' => 'seconds',
        'year' => 'year',
        'month' => 'month',
        'week' => 'week',
        'day' => 'day',
        'hour' => 'hour',
        'minute' => 'minute',
        'second' => 'second',
        'register_text' => '',
        'register_link' => '',
        'class' => '',
    ), $atts);

    

    $years = $atts['years'];
    $months = $atts['months'];
    $weeks = $atts['weeks'];
    $days = $atts['days'];
    $hours = $atts['hours'];
    $minutes = $atts['minutes'];
    $seconds = $atts['seconds'];
    $year = $atts['year'];
    $month = $atts['month'];
    $week = $atts['week'];
    $day = $atts['day'];
    $hour = $atts['hour'];
    $minute = $atts['minute'];
    $second = $atts['second'];

    $html = '';
    $html .= '
      <div class="banner-wrap relative-div upper-text">
          <span class="mask-overlay"></span>
          <div class="banner-details relative-div white-color text-center">
              <div class="container theme-container">
                  <h2 class="secondery-font">'.$atts['title'].'</h2>
                  <div class="title-wrap">
                      <h3 class="section-title"> <span> '.$atts['subtitle'].' </span> </h3>
                  </div>
                  <div class="countdown-wrapper space-bottom-45">
                      <div class="defaultCountdown clearfix" 
                             data-years='.$years.' data-months='.$months.' data-weeks="'.$weeks.'" data-days="'.$days.'" data-hours="'.$hours.'" data-minutes="'.$minutes.'" data-seconds="'.$seconds.'" 
                             data-year='.$year.' data-month='.$month.' data-week="'.$week.'" data-day="'.$day.'" data-hour="'.$hour.'" data-minute="'.$minute.'" data-second="'.$second.'" 
                             data-end_date_y = "'.$atts['end_date_y'].'" data-end_date_m="'.$atts['end_date_m'].'" data-end_date_d="'.$atts['end_date_d'].'" 
                             data-end_date_h = "'.$atts['end_date_h'].'" data-end_date_i = "'.$atts['end_date_i'].'" 
                             data-timezone = "'.$atts['timezone'].'" data-display_format="'.$atts['display_format'].'" >
                      </div>
                  </div>
                  <a class="theme-btn-big btn   goto-register-new" href="'.$atts['register_link'].'">'.$atts['register_text'].'</a>
              </div>
          </div>
      </div>
    ';

    return $html;

}
/* /Banner */



/* Latest event */
add_shortcode('imevent_latest_event', 'imevent_latest_event');
function imevent_latest_event($atts, $content = null) {

  $atts = shortcode_atts(
      array(
        'title' => '',
        'class' => '',
    ), $atts);

    

    $html = '';
    $html .= '
      <div class="theme-container latest-container '.$atts['class'].'">
          <h2 class="vertical-text theme-color-bg white-color wow zoomIn" data-wow-delay="0.6s"> '.$atts['title'].' </h2>
          <div class="latest-event">
              '.do_shortcode($content).'
          </div>
      </div>
    ';

    return $html;

}
/* /Latest event */

/* Latest event item */
add_shortcode('imevent_latest_event_item', 'imevent_latest_event_item');
function imevent_latest_event_item($atts, $content = null) {

  $atts = shortcode_atts(
      array(
        'icon' => '',
        'title' => '',
        'subtitle' => '',
        'column' => 'col-sm-6', 
        'class' => '',
    ), $atts);

    $html = '';
    $html .= '<div class="'.$atts['column'].' feature-box '.$atts['class'].'">
                  <div class="feature-icon wow zoomIn" data-wow-delay="0.6s">
                      <i class="fa '.$atts['icon'].'  theme-color"></i>
                  </div>
                  <div class="feature-info secondery-font wow fadeInRight" data-wow-delay="0.6s">
                      <a href="#" class="theme-color"> <b> '.$atts['title'].' </b> </a>
                      <h5>'.$atts['subtitle'].'</h5>
                  </div>
              </div>';

    return $html;

}
/* /Latest event item */


/* Heading item */
add_shortcode('imevent_heading', 'imevent_heading');
function imevent_heading($atts, $content = null) {

  $atts = shortcode_atts(
      array(
        'line' => 'yes',
        'class' => '',
    ), $atts);

    $html = '';
    $html .= '<div class="title-wrap space-bottom-50 '.$atts['class'].'">
                  <h2 class="section-heading wow fadeInDown"  data-wow-delay="0.3s"> '.$content.' </h2>';
                  $html .= ($atts['line'] == 'yes') ? '<p class="title-devider wow fadeInUp"  data-wow-delay="0.8s"> <span class="line-1 wow fadeInUp"  data-wow-delay="0.8s">  </span> <span class="line-2 wow fadeInUp"  data-wow-delay="0.6">  </span> <span class="line-3 wow fadeInUp"  data-wow-delay="0.4s">  </span></p>':'';
              $html .= '</div>';
    return $html;
}
/* /Heading item */

/* Heading item */
add_shortcode('imevent_about', 'imevent_about');
function imevent_about($atts, $content = null) {

  $atts = shortcode_atts(
      array(
        'img' =>'',
        'content' => '',
        'text_button' => '',
        'link_button' => '',
        'class' => '',
    ), $atts);

    $html = '';
    $img = wp_get_attachment_image_src($atts['img'], 'full');

    $html .= '<div class="jevent-wrap '.$atts['class'].'">
                <div class="jevent-media wow fadeInDown"  data-wow-delay="0.8s">
                    <img src="'.$img['0'].'" class="img-responsive" />
                </div>
                <div class="jevent-content">
                    '.$content.'
                    <p><a href="'.$atts['link_button'].'" class="theme-btn btn goto-register-new"  data-wow-delay="0.8s">'.$atts['text_button'].'</a></p>
                </div>
              </div>';
    return $html;
}
/* /Heading item */



/* Create Schedule2 Shortcode */
add_shortcode('imevent_schedule2', 'imevent_schedule2');
function imevent_schedule2($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(
      'array_slug'  => '',  
      'schedule_order_by' => 'id',
      'schedule_order'  => 'ASC',
      'schedule_count' => '100',
      'schedule_display_thumbnail' => '1',
      'schedule_display_time' => '1',
      'schedule_display_author' => '1',
      'schedule_display_desc' => '1',
      'schedule_display_address' => '1',
      'schedule_count_word' => '30',
      'speaker_text' => 'speaker',
      'class'       => ''
    ), $atts);

    $filter_orderby = $atts['schedule_order_by'];
    $filter_order = $atts['schedule_order'];
    $schedule_count_each_tab = $atts['schedule_count'];


    $schedule_display_thumbnail = $atts['schedule_display_thumbnail'];
    $schedule_display_time = $atts['schedule_display_time'];
    $schedule_display_author = $atts['schedule_display_author'];
    $schedule_display_desc = $atts['schedule_display_desc'];
    $schedule_count_word = $atts['schedule_count_word'];
    $schedule_display_address = $atts['schedule_display_address'];
    


    $html = '';

    /* Wrap schedule */
    $html .= '<div class="event-schedule-wrap wow fadeInDown '.$atts['class'].'">';

    /* Display navigation tab lv1 */
    $html .= '<ul class="nav-tabs secondery-font schedule-tabs" role="tablist" data-wow-delay="0.3s">';
    $array_slug_new = explode(',', $atts['array_slug']);
    foreach ($array_slug_new as $key => $value) {
      $category_lv1 = get_term_by('slug', $value, 'categories');

      $class_active_lv1 = '';
      if($key == 0) { $class_active_lv1 = 'active'; };
      $html .='<li class="'.$class_active_lv1.'" role="presentation" >
                  <a aria-expanded="true" href="#tab-'.$category_lv1->slug.'" role="tab" data-toggle="tab" >
                      <span class="number"><b> ';
                      ++$key;
                      $html .= ($key < 10) ? '0'.$key : $key;
                      $html .= ' </b></span>
                      <span class="day"><b> '.$category_lv1->name.' </b>'.$category_lv1->description.' </span>
                  </a>
              </li>';
    }
    $html .= '</ul>'; 
    /* /Display navigation tab lv1 */

    

    /* Schedule Content */
    $html .= '<div class="tab-content">';

      foreach ($array_slug_new as $key => $value) {
        $category_lv1_c = get_term_by('slug', $value, 'categories');
        $class_active_lv1_c = ($key == 0) ? ' active in ' : '';
      
        $html .= '<div role="tabpanel" class="tab-pane fade '.$class_active_lv1_c.'" id="tab-'.$category_lv1_c->slug.'">
                    <ul class="schedule-list no-margin">';

                        /* Display content of tab */
                        if( $filter_orderby == '_cmb_schedule_order_by' ){
                          
                            $args = array(
                              'post_type' => 'schedule', 
                              'categories'=>$category_lv1_c->slug, 
                              'orderby'=> 'meta_value_num',
                              'meta_key' => $filter_orderby,
                              'order'=> $filter_order, 
                              'posts_per_page'=> $schedule_count_each_tab, 
                              'post_status' => 'publish'
                            );
                          
                        }else{
                           $args = array(
                            'post_type' => 'schedule', 
                            'categories'=>$category_lv1_c->slug, 
                            'orderby'=> $filter_orderby, 
                            'order'=> $filter_order, 
                            'posts_per_page'=> $schedule_count_each_tab, 
                            'post_status' => 'publish'
                          );
                        }


                       
                        $schedule = new WP_QUery($args);
                        
                        if($schedule->have_posts()):
                          while($schedule->have_posts()): $schedule->the_post();

                            $id_post = get_the_id();
                            $cat = get_the_terms($id_post, 'categories');
                            $cate = '';

                            if( count($cat) > 1  ){
                              $cate = $cat['1']->name;  
                            }else{
                              $cate = ''; 
                            }
                            
                            $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id());
                            $schedule_timetext = get_post_meta($id_post, "_cmb_schedule_timetext", true);
                            $schedule_author = get_post_meta($id_post, "_cmb_schedule_author", true);
                            $schedule_author_job = get_post_meta($id_post, "_cmb_schedule_author_job", true);
                            $schedule_link_speaker = get_post_meta($id_post, "_cmb_schedule_link_speaker", true);

                            $html .= '<li>
                                          <a class="jevent-title-1 toggle" href="'.get_permalink().'">'.get_the_title( ).'</a>
                                          <div class="schedule-details">';

                                              $html .= $schedule_display_thumbnail ? '<div class="schedule-handler">
                                                            <img src="'.$thumbnail_url.'" alt="'.get_the_title( ).'" class="img-responsive" />
                                                        </div>' : '';

                                              $html .= '<div class="schedule-box">
                                                  <h6 class="secondery-font">';
                                                    $html .= $schedule_display_time ? '<span class="black-color">'.$schedule_timetext.' </span>' : '';
                                                    $html .= $schedule_display_address ? '<span class="cate"> '.$cate.' </span>' : '';

                                                  $html .= '</h6>';

                                                  $html .= $schedule_display_desc ? custom_excerpt($schedule_count_word) : '';
                                                  
                                                  $html .= $schedule_display_author ? '<p class="secondery-font speaker"><span class="black-color">'.$atts['speaker_text'].'</span> <span class="theme-color"> '.$schedule_author_job.'</span> </p>' : '';
                                              $html .= '</div>
                                          </div>
                                      </li>';

                          endwhile; 
                        endif;
                        /* /Display content of tab */

                    $html .= '</ul>
                </div>';
      } /* end foreach */

      $html .= '</div>';/* /Schedule content */
    

    
    $html .= "</div>"; /* /Wrap schedule */
    
    return $html;
}
/* Create Schedule2 Shortcode */


/* Create testimonial2 */
add_shortcode('imevent_testimonial2', 'imevent_testimonial2');
function imevent_testimonial2($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'timeout' => '3000',
      'auto'    => 'true',
      'loop'    => 'true',
      'class'   => ''
    ), $atts);
    $atts['timeout'] = $atts['timeout']?$atts['timeout']:'3000';
    $atts['auto'] = $atts['auto']?$atts['auto']:'true';
    $atts['loop'] = $atts['loop']?$atts['loop']:'true';
    $html = '
      <div class="testimonials-wrap">
        <div class="testimonials-slider '.$atts['class'].'" data-loop="'.$atts['loop'].'" data-auto="'.$atts['auto'].'" data-timeout="'.$atts['timeout'].'">
        '.do_shortcode( $content ).'
        </div>
        <div class="testimonials-links">                
            <span class="prev slider-btn wow fadeInLeft"  data-wow-delay="1.6s"   data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </span>
            <span class="next slider-btn wow fadeInRight"  data-wow-delay="1.8s"  data-slide="next">
                <i class="fa fa-angle-right"></i>
            </span>
        </div>
      </div>
    ';

    return $html;
}

add_shortcode('imevent_item_testimonial2', 'imevent_item_testimonial2');
function imevent_item_testimonial2($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'desc' => '',
      'thumbnail' => '',
      'alt'   => '',
      'author' => '',
      'author_job' => ''
    ), $atts);

    $html = '';
    $thumbnail = '';

    if(wp_get_attachment_image_src($atts['thumbnail'], 'full')){
        $obj_thumbnail = wp_get_attachment_image_src($atts['thumbnail'], 'full');
        $thumbnail = $obj_thumbnail['0'];
    }else if($atts['thumbnail']!= ''){
        $thumbnail = $atts['thumbnail'];
    }

    
    $html .='<div class="item">
              <div class="testimonials-content text-center  col-sm-10 col-sm-offset-1">
                <p class="black-color wow fadeInDown"  data-wow-delay="0.8s"> <i> ”'.$atts['desc'].'” </i> </p>
                <div class="testimonials-img wow zoomIn"  data-wow-delay="0.8s">
                    <img src="'.$thumbnail.'" alt="'.$atts['alt'].'"/>
                    <h4 > <b> <span class="black-color"> '.$atts['author'].', </span> <span class="job"> '.$atts['author_job'].' </span> </b> </h4>
                </div>
              </div>
            </div>';
    return $html;
}
/* /Create item testimonial */




/* Create Speaker Shortcode */
add_shortcode('imevent_speaker2', 'imevent_speaker2');
function imevent_speaker2($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(
      'slug'  => '',
      'column'  => 'col-md-3 col-sm-6',
      'speaker_order_by' => 'id',
      'speaker_order' => 'ASC',
      'speakers_item_count' => '30',
      'speakers_display_job' => '1',
      'speakers_display_intro_description' => '1',
      'speakers_speaker_link' => '1',
      'class' => ''
    ), $atts);

    $speakers_layout = $atts['column'];
    $speaker_order_by = $atts['speaker_order_by'];
    $speaker_order = $atts['speaker_order'];
    $posts_per_page = $atts['speakers_item_count'];
    $speakers_display_job = $atts['speakers_display_job'];
    $speakers_speaker_link = $atts['speakers_speaker_link'];


    $html = '';
    $html .= '<div class="row thumbnails speaker clear '.$atts['class'].'">';

    if( $speaker_order_by == '_cmb_speaker_order_by' ){
      $args = array(
        'post_type' => 'speaker', 
        'group'=>$atts['slug'], 
        'orderby' => 'meta_value_num',
        'meta_key'=> $speaker_order_by, 
        'order'=> $speaker_order, 
        'posts_per_page'=>$posts_per_page, 
        'post_status' => 'publish'
      );
    }else{
      $args = array(
        'post_type' => 'speaker', 
        'group'=>$atts['slug'], 
        'orderby'=> $speaker_order_by, 
        'order'=> $speaker_order, 
        'posts_per_page'=>$posts_per_page, 
        'post_status' => 'publish'
      );  
    }
    
    
    $speaker = new WP_QUery($args);
     $i=0;
     $k = 0;
    if($speaker->have_posts()):
      while($speaker->have_posts()): $speaker->the_post();

            $id_post = get_the_id();
            $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium');

            $speaker_job = get_post_meta($id_post, "_cmb_speaker_job", true);
            $speaker_mail_address = get_post_meta($id_post, "_cmb_speaker_mail_address", true);
            $speaker_facebook_address = get_post_meta($id_post, "_cmb_speaker_facebook_address", true);
            $speaker_twitter_address = get_post_meta($id_post, "_cmb_speaker_twitter_address", true);
            $speaker_linkedin_address = get_post_meta($id_post, "_cmb_speaker_linkedin_address", true);
            $speaker_pinterest_address = get_post_meta($id_post, "_cmb_speaker_pinterest_address", true);
            $speaker_googleplus_address = get_post_meta($id_post, "_cmb_speaker_googleplus_address", true);
            $speaker_tumblr_address = get_post_meta($id_post, "_cmb_speaker_tumblr_address", true);
            $speaker_instagram_address = get_post_meta($id_post, "_cmb_speaker_instagram_address", true);
            $speaker_vk_address = get_post_meta($id_post, "_cmb_speaker_vk_address", true);
            $speaker_flickr_address = get_post_meta($id_post, "_cmb_speaker_flickr_address", true);
            $speaker_mySpace_address = get_post_meta($id_post, "_cmb_speaker_mySpace_address", true);
            $speaker_youtube_address = get_post_meta($id_post, "_cmb_speaker_youtube_address", true);
            $speakers_layout_5 = '';    
            if($speakers_layout == 'col-md-2 col-sm-6 col-5' && ($i==0 || $i == 5)){
                    $speakers_layout_5 = 'col-lg-offset-1 col-md-offset-1';
            }
            if($i==5) $i=0; $i++;

            switch ($k) {
              case 1:
                $cols = "col-md-12 col-sm-12";
                break;
              case 2:
                $cols = "col-md-6 col-sm-6";
                break;
              case 3:
                $cols = "col-md-4 col-sm-4";
                break;
              case 4:
                $cols = "col-md-3 col-sm-6";
                break;
              case 5:
                $cols = "col-md-2 col-sm-6 col-5";
                break;
              case 6:
                $cols = "col-md-2 col-sm-6";
                break;          
              
              default:
                $cols = "col-md-3 col-sm-6";
                break;
            }

            if($cols == $speakers_layout){
              $html .= '<div class="clearfix"></div>';
              $k = 0;
            }
            $k++;

            $html .= '<div class="'.$speakers_layout.' '.$speakers_layout_5.' space-bottom-50 speakers-wrap">
                          <div class="speakers-media wow fadeInDown"  data-wow-delay="0.6s">
                              <img src="'.$thumbnail_url[0].'" alt="'.get_the_title().'">
                              <div class="social-overlay">
                                  <ul>';
                                    if($speaker_mail_address){
                                        $html .= '<li><a target="_blank" href="mailto:'.$speaker_mail_address.'" ><span class="fa fa-envelope"></span></a></li>';
                                    }
                                    if($speaker_facebook_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_facebook_address.'" ><span class="fa fa-facebook"></span></a></li>';
                                    }
                                    if($speaker_twitter_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_twitter_address.'" ><span class="fa fa-twitter"></span></a></li>';
                                    }
                                    if($speaker_linkedin_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_linkedin_address.'" ><span class="fa fa-linkedin"></span></a></li>';
                                    }
                                    if($speaker_pinterest_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_pinterest_address.'" ><span class="fa fa-pinterest"></span></a></li>';
                                    }
                                    if($speaker_googleplus_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_googleplus_address.'" ><span class="fa fa-google-plus"></span></a></li>';
                                    }
                                    if($speaker_tumblr_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_tumblr_address.'" ><span class="fa fa-tumblr"></span></a></li>';
                                    }
                                    if($speaker_instagram_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_instagram_address.'" ><span class="fa fa-instagram"></span></a></li>';
                                    }
                                    if($speaker_vk_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_vk_address.'" class=""><span class="fa fa-vk"></span></a></li>';
                                    }
                                    if($speaker_flickr_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_flickr_address.'" class=""><span class="fa fa-flickr"></span></a></li>';
                                    }
                                    if($speaker_mySpace_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_mySpace_address.'" class=""><span class="fa fa-users"></span></a></li>';
                                    }
                                    if($speaker_youtube_address){
                                        $html .= '<li><a target="_blank" href="'.$speaker_youtube_address.'" class=""><span class="fa fa-youtube"></span></a></li>';
                                    }

                                  $html .= '</ul>
                              </div>
                          </div>
                          <div class="speakers-name secondery-font text-center wow fadeInUp"  data-wow-delay="0.6s">';
                              if($speakers_speaker_link){
                                $html .= '<a class="name" href="'.get_permalink().'">'.get_the_title().'</a>';
                              }else{
                                $html .= get_the_title();
                              }
                              
                              if($speakers_display_job){
                                $html .= '<h6 class="designation  gray-color">'.$speaker_job.'</h6>';  
                              }
                              

                          $html .= '</div>
                      </div>';

      endwhile;
    endif;
     wp_reset_postdata();
    $html .= '</div>';
    return $html;
}
/* /Create Speaker2  */




/* Create pricing2 */
add_shortcode('imevent_pricing2', 'imevent_pricing2');
function imevent_pricing2($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'name' => '',
      'pricing_style' => 'ca',
      'value'   => '',
      'currency' => '',
      'feature' => 'nofeature',
      'name_button'  => '',
      'link_button' =>'',
      'extra_link' => 'true',
      'class'     => '',
    ), $atts);
    $html = '';
    $html .= '<div class="pricing-wrap text-center space-30 wow '.$atts['class'].' '.$atts['feature'].'"  data-wow-delay="0.8s">
                  <div class="plans-header secondry-font">
                      <h2 class="jevent-title-2 no-margin"><b> '.$atts['name'].' </b></h2>';
                      if($atts['pricing_style'] == 'ac'){
                          $html .= '<h4 class="price theme-color">'.$atts['value'].''.$atts['currency'].'</h4>';
                       }else{
                          $html .= '<h4 class="price theme-color">'.$atts['currency'].''.$atts['value'].'</h4>';
                       }

                  $html .= '</div>
                  '.do_shortcode( $content ).'
                  <div class="plans-register">';
                      
                      if($atts['extra_link'] == 'true'){
                          $html .= '
                            <a class="theme-btn-2 btn goto-register" href="'.$atts['link_button'].'">'.$atts['name_button'].'</a>
                        ';
                      }else{
                        $html .= '
                            <a class="theme-btn-2 btn goto-register scroll-to" href="'.$atts['link_button'].'">'.$atts['name_button'].'</a>
                        ';
                      }

                  $html .= '</div>
              </div>';

    return $html;

} 
/* /Create pricing */


/* Create woo pricing */
add_shortcode('imevent_woo_pricing', 'imevent_woo_pricing');
function imevent_woo_pricing($atts, $content = null) {

if(!class_exists('Woocommerce')){return _e('Error: Please install woocommerce plugin','touxt');}

$atts = shortcode_atts(
    array(
      'name' => '',
      'pricing_style' => 'ca',
      'value'   => '',
      'currency' => '',
      'feature' => 'nofeature',
      'desc' => '',
      'name_button'  => '',
      'product_id' => '',
      'style' => 'style1',
      'class'     => '',
    ), $atts);
    $html = '';
    if($atts['style'] == 'style1'){

      $html .= '<div class="pricing_woo pricing-wrap text-center space-30 wow '.$atts['class'].' '.$atts['feature'].'"  data-wow-delay="0.8s">
                  <div class="plans-header secondry-font">
                      <h2 class="jevent-title-2 no-margin"><b> '.$atts['name'].' </b></h2>';
                      if($atts['pricing_style'] == 'ac'){
                          $html .= '<h4 class="price theme-color">'.$atts['value'].''.$atts['currency'].'</h4>';
                       }else{
                          $html .= '<h4 class="price theme-color">'.$atts['currency'].''.$atts['value'].'</h4>';
                       }

                  $html .= '</div>
                  '.$content.'
                  <div class="plans-register">';
                      $html .= do_shortcode('[add_to_cart id="'.$atts['product_id'].'"]');
                  $html .= '</div>
              </div>';

    }else{
      $html .= '
            <div class="pricing_woo price-table '.$atts['class'].' '.$atts['feature'].'" data-animation="fadeInUp" data-animation-delay="100">
                <div class="price-table-header">
                    <div class="price-label">
                        <h2 class="price-label-title">'.$atts['name'].'</h2>
                    </div>
                    <div class="price-value">';

                     if($atts['pricing_style'] == 'ac'){
                        $html .= '<span class="price-number">'.$atts['value'].'</span><span class="price-unit">'.$atts['currency'].'</span><span class="price-per"></span>';
                     }else{
                        $html .= '<span class="price-unit">'.$atts['currency'].'</span><span class="price-number">'.$atts['value'].'</span><span class="price-per"></span>';
                     }
                        

                    $html .= '</div>
                </div>
                <div class="price-table-rows"><p>'.$content.'</p>';

                $html .= do_shortcode('[add_to_cart id="'.$atts['product_id'].'"]');
                $html .= '</div>
            </div>
          ';
    }
    
    return $html;

} 
/* /Create woo pricing */



/* Create Faq 2*/
add_shortcode('imevent_faq', 'imevent_faq');
function imevent_faq($atts, $content = null) {
    
    $atts = shortcode_atts(
    array(
      'slug'  => '',
      'faq_order_by' => 'id',
      'faq_order' => 'ASC',
      'faq_item_count' => '100',
      'class' => ''
    ), $atts);

    $faq_order_by = $atts['faq_order_by'];
    $faq_order = $atts['faq_order'];
    $posts_per_page = $atts['faq_item_count'];
       

        if($faq_order_by == '_cmb_faq_order_by'){
          $args = array(
            'post_type' => 'faq', 
            'faqgroup'=>$atts['slug'], 
            'orderby'=> 'meta_value_num', 
            'meta_key'=> $faq_order_by, 
            'order'=> $faq_order, 
            'posts_per_page'=>$posts_per_page, 
            'post_status' => 'publish'
          );
        }else{
          $args = array(
            'post_type' => 'faq', 
            'faqgroup'=>$atts['slug'], 
            'orderby'=> $faq_order_by, 
            'order'=> $faq_order, 
            'posts_per_page'=>$posts_per_page, 
            'post_status' => 'publish'
          );  
        }


        $rand = rand();

        $faqs = new WP_QUery($args);

    $html = '';
    $html .= '<div class="light-bg event-faqs-wrap ">
                    <div class="theme-container">
                      <div class="row-fluid">';

        /* navigation */
        if($faqs->have_posts()):
          $k = 0; 
          $html .= '<div class="col-md-4 col-sm-5"><ul class="nav-tabs secondery-font event-faqs-tabs" role="tablist">';
          while($faqs->have_posts()): $faqs->the_post();
            $class_act = '';
            if($k == 0) $class_act = 'active'; $k++;
            $html .= '<li  role="presentation" class=" '.$class_act.' wow fadeInLeft"  data-wow-delay="1.1s"> 
                          <a aria-expanded="false" href="#tab-'.get_the_id().$rand.'" role="tab" data-toggle="tab" >  '.get_the_title().' </a>
                      </li>';
          endwhile;
          $html .= '</ul></div>';
        endif;


        /* Content */
        $d = 0; 
        if($faqs->have_posts()):

          $html .= '<div class="col-md-8 col-sm-7"><div class="tab-content event-faqs">';
          while($faqs->have_posts()): $faqs->the_post();
            $class_ac = ($d==0) ? 'in active' : ''; $d++;
            $html .= '<div id="tab-'.get_the_id().$rand.'" class="tab-pane fade '.$class_ac.'" role="tabpanel">
                       '.get_the_content().'   
                      </div>';
          endwhile;
          $html .= '</div></div>';

        endif;

         wp_reset_postdata();
    $html .= '</div></div></div>';
    return $html;
}
/* Create Faq 2 */



/* Create latestblog2 */
add_shortcode('imevent_latestblog2', 'imevent_latestblog2');
function imevent_latestblog2($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'category'=>'all',
      'count' => '3',
      'showdate'  => 'true',
      'showdescription' => 'true',
      'showreadmore'  => 'true',
    ), $atts);
  
  $args =array();
  if ($atts['category']=='all') {
    $args=array('post_type' => 'post', 'posts_per_page' => $atts['count'], 'post_status' => 'publish');
  }else{
    $args=array('post_type' => 'post', 'cat'=>$atts['category'],'posts_per_page' => $atts['count'], 'post_status' => 'publish');
  }
      
  $blog = new WP_Query($args);
  $i = 0;  
ob_start(); ?>
<?php while($blog->have_posts()) : $blog->the_post(); ?>
  <?php if($i%2 == 0){ ?>
    <div class="blog-wrap">
        <div class="col-md-3  col-sm-5  wow fadeInLeft"  data-wow-delay="0.8s">
          <div class="blog-media no-padding">
            <?php $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium'); if($thumbnail_url){ ?>
              <img  src="<?php  echo $thumbnail_url[0]; ?>" alt="<?php the_title( ); ?>" class="img-responsive">
            <?php } ?>
          </div>
        </div>
        <div class="col-md-9  col-sm-8 blog-bg wow fadeInRight"  data-wow-delay="1.1s">
            <div class="blog-content">

                <a href="<?php the_permalink(); ?>" class="post-title"><?php the_title( ); ?></a>
                
                <?php if($atts['showdate'] == 'true'){ ?>
                  <ul class="post-meta">
                        <li> <?php _e('Posted on', TEXT_DOMAIN_SHORTCODE); ?>  <?php the_time( get_option( 'date_format' ));?> </li>
                  </ul>
                <?php } ?>

                <?php if($atts['showdescription'] == 'true'){ ?>
                  <?php the_excerpt(); ?> 
                <?php } ?>

                <?php if($atts['showreadmore'] == 'true'){ ?>
                  <a href="<?php the_permalink(); ?>" class="theme-color read-more"><?php esc_html_e('Read more', 'imevent'); ?></a>
                <?php } ?>

            </div>
        </div>
    </div>
  <?php } else{ ?>
    <div class="blog-wrap">
        
        <div class="col-md-9  col-sm-8 blog-bg wow fadeInRight"  data-wow-delay="1.1s">
            <div class="blog-content">

                <a href="<?php the_permalink(); ?>" class="post-title"><?php the_title( ); ?></a>
                
                <?php if($atts['showdate'] == 'true'){ ?>
                  <ul class="post-meta">
                        <li> <?php _e('Posted on', TEXT_DOMAIN_SHORTCODE); ?>  <?php the_time( get_option( 'date_format' ));?> </li>
                  </ul>
                <?php } ?>

                <?php if($atts['showdescription'] == 'true'){ ?>
                  <?php the_excerpt(); ?> 
                <?php } ?>

                <?php if($atts['showreadmore'] == 'true'){ ?>
                  <a href="<?php the_permalink(); ?>" class="theme-color read-more"><?php esc_html_e('Read more', 'imevent'); ?></a>
                <?php } ?>

            </div>
        </div>
        <div class="col-md-3  col-sm-5  wow fadeInLeft"  data-wow-delay="0.8s">
          <div class="blog-media no-padding">
            <?php $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium'); if($thumbnail_url){ ?>
              <img  src="<?php  echo $thumbnail_url[0]; ?>" alt="<?php the_title( ); ?>" class="img-responsive">
            <?php } ?>
          </div>
        </div>
    </div>
  <?php } ?>
  <?php $i++; ?>
 
<?php endwhile; ?>
<?php
   wp_reset_postdata();
    return ob_get_clean();
}
/* /Create latest blog */



/* Create location */
add_shortcode('imevent_map', 'imevent_map');
function imevent_map($atts, $content = null) {
$atts = shortcode_atts(
    array(
      'defineid'  => 'map-canvas',
      'latitude'  => '40.9807648',
      'longitude' => '28.9866516',
      'zoom'      => '12',
      'heading' => '',
      'marker_title' => '',
      'class'  => '',
    ), $atts);
    $html = '';
    $html .= '
      <div class="container-fluid full-width gmap-background map2">
        <div class="row">
          <div class="col-md-4 col-sm-6 address-wrap space-50 wow fadeInLeft '.$atts['class'].'"  data-wow-delay="0.8s">
              <div class="col-md-9 pull-right wow fadeInRight"  data-wow-delay="1.1s">
                  <div class="space-bottom-30">
                      <h2 class="jevent-title-1">    <span class="theme-color"> '.$atts['heading'].' </span> </h2>                           
                  </div>
                  <div class="address address_map">
                      '.do_shortcode($content).'
                  </div>
              </div>
          </div>
          <div class="google-map" data-zoom="'.$atts['zoom'].'" data-latitude="'.$atts['latitude'].'" data-longitude="'.$atts['longitude'].'" data-defineid="'.$atts['defineid'].'" data-marker_title="'.$atts['marker_title'].'">
              <div id="'.trim($atts['defineid']).'"></div>
          </div>
        </div>
      </div>
    ';

    return $html;

}
/* /Create location */

