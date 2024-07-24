<!-- Gallery Dynamic post by category -->
<section class="new-event-sec tablist-img">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                     <?php 
                     $args_cat = array(
                                     "post_type" => "event",
                            		 'taxonomy' => 'eventcategory',
                            		 'hide_empty' => 1,
                                       );
                    $cats = get_terms($args_cat); 
                    ?>
                    <?php $i=0; foreach($cats as $cat_data){  $i++; ?>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link <?php if($i==1){echo'active';} ?>" id="<?php echo $cat_data->slug; ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo $cat_data->slug;?>" type="button" role="tab" aria-controls="news" aria-selected="true"><?php echo $cat_data->name; ?></button>
                      </li>
                     <?php } ?>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    <?php $i=0;
                      foreach($cats as $cat_data){  $i++; ?> 
                     <!-- Single category -->
                           <?php 
                            $query_gallery = new WP_Query(array(
                             "post_type" => "event",
                        	 'posts_per_page' => -1,
                        	 'tax_query' =>array(
                                	 array('taxonomy' => 'eventcategory',
                                	        'field'=> 'term_id',
                                	        'terms'=> $cat_data->term_id)
                                	        ),
                        	     ));
                        	     ?>
                      <div class="tab-pane fade <?php if($i==1){echo'show active';} ?>" id="<?php echo $cat_data->slug;?>" role="tabpanel" aria-labelledby="<?php echo $cat_data->slug;?>-tab">
                          <div class="row">
                          <?php
                            if ( $query_gallery->have_posts() ) :
                            	while ( $query_gallery->have_posts() ) : $query_gallery->the_post(); 	
                                ?>
                		    <div class="col-lg-3 col-md-6 col-sm-12 col-12 d-flex">
                		        <div class="new-event">
                		            <div class="news-event-img">
                		                <?php echo get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'img-fluid')); ?>
                		            </div>
                		            <div class="news-event-content service-item">
                		                <h6><?php the_title(); ?></h6>
                		                <p><i class="fa fa-location"></i> <?php the_field('location'); ?></p>
                		                <?php if(get_field('read_more_link')){ ?>
                		                <a href="<?php the_field('read_more_link'); ?>" target="_blank" class="btn-main mt-4"><i class="fa-solid fa-angle-right bg-dark text-white"></i> Read More</a>
                		                <?php } ?>
                		            </div>
                		        </div>
                		    </div>
						   <?php endwhile;
					    	endif; ?>
                		</div>
                  </div>
                   <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
