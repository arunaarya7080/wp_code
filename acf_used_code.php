<!-- Carousel img Category acf data fatch   -->
<?php
$args_cat = array(
    "post_type" => "product",
    'taxonomy' => 'service',
    'hide_empty' => 0,
);
$cats = get_terms($args_cat);
?>
<!-- fetch per category data -->
<?php foreach ($cats as $cat_data) { ?>
    <?php // 
    $taxonomy = 'service';
    $term_id = $cat_data->term_id;
    $image = get_field('cat_img', $taxonomy . '_' . $term_id);
    $cat_content = get_field('cat_content', $taxonomy . '_' . $term_id);
    ?>

    <img src="<?php echo $image; ?>" alt="<?php echo $cat_data->name; ?>" />

<?php } ?>

<!-- // loop code reapter acf code -->
<?php
$i = 0;
if (have_rows('slider_loop')) :
    while (have_rows('slider_loop')) :
        the_row();
        $i++;
?>
        <img src="<?php the_sub_field('img'); ?>" alt="<?php the_sub_field('name'); ?>">
<?php endwhile;
endif;
?>

<!-- // loop code nested reapter acf code -->
<?php
if (have_rows('locations')) : ?>
    <div class="locations">
        <?php while (have_rows('locations')) : the_row(); ?>
            <div class="location">
                <h3><?php the_sub_field('title'); ?></h3>
                <p><?php the_sub_field('description'); ?></p>
                <?php if (have_rows('staff_members')) : ?>
                    <ul class="staff-members">
                        <?php while (have_rows('staff_members')) : the_row();
                            $image = get_sub_field('image');
                        ?>
                            <li>
                                <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                                <h4><?php the_sub_field('name'); ?></h4>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>