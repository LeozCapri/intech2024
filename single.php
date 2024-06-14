<?php get_header();

// Fetch the images from the post
$post_id = get_the_ID();
$images = get_attached_media('image', $post_id);
$image_urls = array();
foreach ($images as $image) {
    $image_urls[] = wp_get_attachment_url($image->ID);
}
?>
<div class="main-banner" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-carousel owl-banner">
                    <?php
                    // Retrieve current image URLs
                    $multiple_featured_images = get_post_meta(get_the_ID(), 'multiple_featured_images', true);

                    // Loop through each image URL and create a carousel item
                    if (!empty($multiple_featured_images)) {
                        foreach ($multiple_featured_images as $index => $image_url) {
                            ?>
                            <div class="item" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                                <div class="header-text">
                                    <div class="category-container">
                                        <?php
                                        $categories = wp_get_post_categories(get_the_ID());
                                        foreach ($categories as $category_id) {
                                            $category = get_term($category_id);
                                            if ($category) {
                                                echo '<div class="category-wrapper">';
                                                echo '<span class="category">';
                                                echo esc_html($category->name);
                                                echo '</span>';
                                                echo '</div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <h2><?php the_title(); ?></h2>
                                    <p class="meta">
                                        <?php the_time('F j, Y'); ?> |
                                        <?php
                                        $author_id = get_post_field('post_author', get_the_ID());
                                        $author_name = get_the_author_meta('display_name', $author_id);
                                        echo 'by ' . $author_name; ?> 
                                    </p>
                                    <!-- rest of the code -->
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // Fallback to using the page's featured image if no multiple featured images are set
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        if (empty($thumbnail_url)) {
                            $thumbnail_url = get_template_directory_uri() . '/assets/images/course-04.jpg';
                        }
                        ?>
                        ?>
                        <div class="item" style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');">
                            <div class="header-text">
                                <div class="category-container">
                                    <?php
                                    $categories = wp_get_post_categories(get_the_ID());
                                    foreach ($categories as $category_id) {
                                        $category = get_term($category_id);
                                        if ($category) {
                                            echo '<div class="category-wrapper">';
                                            echo '<span class="category">';
                                            echo esc_html($category->name);
                                            echo '</span>';
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                                </div>
                                <h2><?php the_title(); ?></h2>
                                <p class="meta">
                                    <?php the_time('F j, Y'); ?> |
                                    <?php
                                    $author_id = get_post_field('post_author', get_the_ID());
                                    $author_name = get_the_author_meta('display_name', $author_id);
                                    echo 'by ' . $author_name; ?> |
                                </p>
                                <!-- rest of the code -->
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contact-us section" id="blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 align-self-center">
            </div>
            <div class="col-lg-12">
                <div class="contact-us-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <fieldset>
                                <?php the_content(); ?>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <p class="meta">
                                    <?php the_time('F j, Y'); ?> |
                                    <?php
                                    $author_id = get_post_field('post_author', get_the_ID());
                                    $author_name = get_the_author_meta('display_name', $author_id);
                                    echo 'by ' . $author_name; ?> |
                                </p>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            items: 1, // Number of items to display
            loop: true, // Loop through items
            nav: true, // Show navigation
            dots: true, // Show dots navigation
            autoplay: true, // Enable autoplay
            autoplayTimeout: 5000, // Autoplay interval in milliseconds
            autoplayHoverPause: true // Pause on hover
        });
    });
</script>



<?php get_footer(); ?>

<style>
    .main-banner .item {
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        border-radius: 25px;
        padding: 50px 50px;
        margin-left: 130px;
    }

    #blog .contact-us-content p {
        color: #FFFFFF;
        text-align: justify;
    }

    #blog .meta {
        color: #FFFFFF;
        text-align: justify;
    }
</style>