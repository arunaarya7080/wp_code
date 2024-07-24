<?php
// WP Pagination (Post) #function.php code
function pagination_bar($custom_pagination_query)
{
    $total_pages = $custom_pagination_query->max_num_pages;
    $big = 999; // Need an unlikely integer
    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));
        $paginate_links = paginate_links(array(
            "base" => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            "format" => '?paged=%#%',
            "current" => $current_page,
            "total" => $total_pages,
            "type" => "array",
            'prev_text' => __('«'),
            'next_text' => __('»'),
        ));
        echo '<ul class="pagination-1">';
        foreach ($paginate_links as $link) {
            echo '<li class="pagination-item">' . $link . '</li>';
        }
        echo '</ul>';
    }
}
?>
<!--  -->
<!-- /*pagination style */ -->

<style>
    .pagination-1-bx .pagination-1,
    .cvf-universal-pagination-1 .pagination-1 {
        margin: 0;
    }

    .pagination-1 {
        padding: 10px 0;
        display: flex;
    }

    .pagination-1 li {
        display: block;
    }

    .pagination-1 li a {
        display: block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
    }

    .pagination-1>li>span {
        display: block;
        width: 40px;
        height: 40px;
        line-height: 30px;
        text-align: center;
    }

    .pagination-1>li:first-child>a,
    .pagination-1>li:first-child>span {
        border-bottom-left-radius: 0;
        border-top-left-radius: 0;
        margin-left: 0;
    }

    .pagination-1>li:last-child>a,
    .pagination-1>li:last-child>span {
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
    }

    .pagination-1>li>a,
    .pagination-1>li>span {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-right: 0px;
        color: #000;
        font-weight: 600;
        font-size: 16px;
    }

    .pagination-1>li:last-child>a,
    .pagination-1>li:last-child>span {
        border-right: 1px solid #e0e0e0;
    }

    .pagination-1>li>a:hover,
    .pagination-1>li>span:hover,
    .pagination-1>li>a:focus,
    .pagination-1>li>span:focus {
        background-color: #000;
        border-color: transparent;
        color: #fff;
    }

    .pagination-1>.active>a,
    .pagination-1>.active>span,
    .pagination-1>.active>a:hover,
    .pagination-1>.active>span:hover,
    .pagination-1>.active>a:focus,
    .pagination-1>.active>span:focus {
        background-color: #000;
        border-color: transparent;
    }

    .pagination-1>.previous>a,
    .pagination-1>.next>a {
        font-size: 12px;
    }

    .pagination-1>li>.current {
        background-color: #000;
        border-color: transparent;
        color: #fff;
        display: block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
    }
</style>

<!-- SECTION CONTENT START blog -->
<div class="section-full">

    <!-- Blog CONTENT START -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="news-listing ">
                    <?php
                    $searchdata = '';
                    if (isset($_POST["your_post"])) {
                        $searchdata = $_POST["your_post"];
                        //echo  $searchdata;
                    }
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array(
                        "post_type" => "post",
                        "posts_per_page" => 3,
                        "paged" => $paged,
                        's' => $searchdata,
                    );
                    $query = new WP_Query($args);
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                    ?>
                            <div class="blog-post blog-lg date-style-3 block-shadow">
                                <div class="mt-post-media mt-img-effect">
                                    <a href="<?php the_permalink(); ?>"><img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_permalink(); ?>"></a>
                                </div>
                                <div class="mt-post-info p-a30 p-m30 bg-white">
                                    <div class="mt-post-title ">
                                        <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    </div>
                                    <div class="mt-post-meta ">
                                        <ul>
                                            <li class="post-date"> <i class="fa fa-calendar site-text-primary"></i><strong><?php echo get_the_date('d'); ?></strong> <span> <?php echo get_the_date('M Y'); ?></span> </li>
                                            <li class="post-author"><i class="fa fa-user site-text-primary"></i><a>By <span>GNS</span></a> </li>

                                        </ul>
                                    </div>
                                    <div class="mt-post-text">
                                        <p><?php echo wp_trim_words(get_the_content(), 50); ?></p>
                                    </div>
                                    <div class="clearfix">
                                        <div class="mt-post-readmore pull-left">
                                            <a href="<?php the_permalink(); ?>" title="READ MORE" rel="bookmark" class="site-button-link">Read More<i class="fa fa-angle-right arrow-animation"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        };
                        wp_reset_postdata();
                    } else {
                        echo '<div class="blog-post blog-lg date-style-3 block-shadow"> <p class="pt-3 ps-3">Post not found</p></div>';
                    }
                    ?>
                </div>
                <!--pagination-->
                <div class="blog-pagination">
                    <?php pagination_bar($query) ?>
                </div>

            </div>
            <!-- SIDE BAR START -->
            <div class="col-lg-4 col-md-12">

                <aside class="side-bar">

                    <!-- SEARCH -->
                    <div class="widget bg-white ">
                        <h4 class="widget-title ">Search</h4>
                        <div class="search-bx">
                            <form method="post">
                                <div class="input-group">
                                    <input name="your_post" type="text" class="form-control bg-gray" placeholder="Search...">
                                    <span class="input-group-btn bg-gray">
                                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="widget bg-white  widget_tag_cloud">
                        <h4 class="widget-title">Category</h4>
                        <div class="tagcloud">
                            <?php
                            $args_cat = array(
                                "post_type" => "post",
                                'post_status' => 'publish',
                                'taxonomy' => 'category',
                                'hide_empty' => 0,
                            );
                            $cats = get_terms($args_cat);
                            ?>
                            <?php foreach ($cats as $cat_data) { ?>
                                <a href="<?php echo get_term_link($cat_data); ?>"><?php echo $cat_data->name; ?></a>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- RECENT POSTS -->
                    <div class="widget bg-white  recent-posts-entry">
                        <h4 class="widget-title  ">Recent Posts</h4>
                        <div class="section-content">
                            <div class="widget-post-bx">
                                <?php
                                $args = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => 4,
                                );
                                $loop = new WP_Query($args);
                                if ($loop->have_posts()) {
                                    while ($loop->have_posts()) : $loop->the_post();
                                ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="widget-post clearfix">
                                                <div class="mt-post-media">
                                                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
                                                </div>
                                                <div class="mt-post-info">
                                                    <div class="mt-post-meta">
                                                        <ul>
                                                            <li class="post-author"><?php echo get_the_date('d M Y'); ?></li>

                                                        </ul>
                                                    </div>
                                                    <div class="mt-post-header">
                                                        <h6 class="post-title"><?php the_title(); ?>.</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                <?php
                                    endwhile;
                                    wp_reset_postdata();
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </aside>

            </div>
            <!-- SIDE BAR END -->
        </div>
    </div>
    <!-- GALLERY CONTENT END -->

</div>
<!-- SECTION CONTENT END  -->