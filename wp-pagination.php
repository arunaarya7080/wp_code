<?php 
// WP Pagination (Post) #function.php code

function pagination_bar($custom_pagination_query = null) {
    global $wp_query;

    // Use the custom query if provided, otherwise fall back to the main query
    $query = $custom_pagination_query ? $custom_pagination_query : $wp_query;

    // Check if the query is a WP_Query instance
    if (!($query instanceof WP_Query)) {
        return;
    }

    $total_pages = $query->max_num_pages;
    $big = 999999999; // Need an unlikely integer for replacement

    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));
        $paginate_links = paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'type' => 'array',
            'prev_text' => __('«'),
            'next_text' => __('»'),
        ));

        if (is_array($paginate_links)) {
            echo '<ul class="blog-pagination">';
            foreach ($paginate_links as $link) {
                echo '<li class="pagination-item">' . $link . '</li>';
            }
            echo '</ul>';
        }
    }
}
?>

<style>
.blog-pagination {
    text-align: center;
    margin: 20px 0;
}

.blog-pagination .pagination {
    list-style: none;
    padding: 0;
    margin: 0;
    display: inline-block;
}

.blog-pagination .pagination-item {
    display: inline;
    margin: 0 5px;
}

.blog-pagination .pagination-item a,
.blog-pagination .pagination-item span {
    color: #333;
    text-decoration: none;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s, color 0.3s;
}

.blog-pagination .pagination-item a:hover,
.blog-pagination .pagination-item span.current {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.blog-pagination .pagination-item a.prev,
.blog-pagination .pagination-item a.next {
    font-weight: bold;
}

.blog-pagination .pagination-item a.prev {
    margin-right: 10px;
}

.blog-pagination .pagination-item a.next {
    margin-left: 10px;
}
</style>

<?php 
// template files (e.g., index.php, archive.php, category.php etc.)
if (have_posts()) :
    while (have_posts()) : the_post();
        // Your loop code
    endwhile;
    
    pagination_bar();
else :
    // No posts found
endif;


// custom template for use pagination
$custom_query = new WP_Query(array(
    'posts_per_page' => 5,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1
));

if ($custom_query->have_posts()) :
    while ($custom_query->have_posts()) : $custom_query->the_post();
        // Your loop code
    endwhile;

    pagination_bar($custom_query);

    wp_reset_postdata();
else :
    // No posts found
endif;
