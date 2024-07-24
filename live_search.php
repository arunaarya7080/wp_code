<!-- live search ajax -->
 <!-- html start -->
 <div class="about-inner img1 margin-top1 warranty-inner tutorial-video-banner" style="background:#eee;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-10 col-sm-12 col-12 mx-auto text-center">
                <h1>TUTORIAL VIDEOS</h1>
                 <div class="position-relative">
                    <div class="input-group mt-4">
                            <input type="text" placeholder="Search" id="your_search" class="form-control border-end-0 border rounded-pill" onkeyup="my_fetch()" />
                           <span class="input-group-append"><i class="fa fa-search"></i>
                        </span>
                    </div>
                    <div class="search_result" id="search_result"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- search js -->
<script type="text/javascript">
    function my_fetch() {
        var keyword = jQuery('#your_search').val().trim(); // Trim leading and trailing whitespace
        // Check if the first character is a black space
        if (keyword.charAt(0) === '\u0020') {
            keyword = keyword.substring(1); // Remove the first character
         }
        if (keyword !== '') {
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                data: {
                    action: 'my_data_fetch',
                    keyword: keyword
                },
                success: function(data) {
                    jQuery('#search_result').html(data);
                }
            });
        } else {
            jQuery('#search_result').html('');
        }
    }
</script>
<!--function.php #code search code   -->
<?php 
function my_data_fetch() {
    
    if($_POST['keyword']){
    $args = array(
        'post_type'      =>  array('tutorial-video'),
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        's'              => esc_attr($_POST['keyword']),
    );
    }
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) {
            echo '<ul>';
            while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <li><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
            <?php endwhile;
            echo '</ul>';
            wp_reset_postdata();
    } else {
         echo '<ul><li><a> Not found. </a></ul></li>';
    }
    wp_die();
    
}
add_action('wp_ajax_my_data_fetch', 'my_data_fetch');
add_action('wp_ajax_nopriv_my_data_fetch', 'my_data_fetch');
?>
