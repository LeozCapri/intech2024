<?php
/*
Template Name: News
*/
get_header();

?>
<div class="main-banner" id="top">
    <div class="container">
        <div class="row">
            <!-- <div class="col-lg-12">
                <div class="owl-carousel owl-banner">
                    <div class="item item-1"> -->

            <div class="header-text">
                <div class="white-text">
                    <h2 style="color:white;">News</h2>
                </div>
                <div class="buttons">
                    <br>
                    <div class="main-button">
                        <a href="/register">Register Now</a>
                    </div>
                    <br>
                    <div class="icon-button">
                        <a href="#"><i class="fa fa-play"></i>Why you should register</a>
                    </div>
                </div>
            </div>
            <!-- </div>
                </div>
            </div> -->
        </div>
    </div>
</div>

<section class="section courses" id="courses">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h6>Latest News</h6>
                    <h2>Latest News</h2>
                </div>
            </div>
        </div>
        <ul class="event_filter">
            <li>
                <a class="is_active" href="#!" data-filter="*">Show All</a>
            </li>
            <?php
            $child_categories = get_categories(
                array(
                    'parent' => get_category_by_slug('news')->term_id, // Replace 'news' with the slug of your parent category
                    'hide_empty' => false,
                )
            );
            foreach ($child_categories as $child_category) {
                echo '<li><a href="#!" data-filter=".news-' . $child_category->slug . '">' . $child_category->name . '</a></li>';
            }
            ?>
        </ul>
        <div class="row event_box">
            <?php
            $args = array(
                'post_type' => 'post', // Replace with your custom post type name
                'posts_per_page' => -1, // Fetch all posts
                'category_name' => 'news', // Replace with the slug of your parent category
            );
            $news_query = new WP_Query($args);
            if ($news_query->have_posts()) {
                while ($news_query->have_posts()) {
                    $news_query->the_post();
                    $categories = get_the_category();
                    $category_classes = '';
                    foreach ($categories as $category) {
                        if ($category->parent == get_category_by_slug('news')->term_id) {
                            $category_classes .= ' news-' . $category->slug;
                        }
                    }
                    ?>
                    <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6<?php echo $category_classes; ?>">
                        <div class="events_item">
                            <div class="thumb">
                                <a href="<?php the_permalink(); ?>">
                                    <?php
                                    $thumbnail_url = get_the_post_thumbnail_url();
                                    if ($thumbnail_url) {
                                        echo '<img src="' . $thumbnail_url . '" alt="">';
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/assets/images/course-04.jpg" alt="">';
                                    }
                                    ?>
                                </a>
                                <span class="category"><?php echo $categories[0]->name; ?></span>
                                <!--  -->
                            </div>
                            <div class="down-content">
                                <span class="author"><?php the_author(); ?></span>
                                <h4><?php the_title(); ?></h4>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>No news posts found.</p>';
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>

<style>
    #login-form {
        margin-top: 20px;
    }

    .input-field {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #login-submit {
        background-color: #f26722;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    #login-submit:hover {
        background-color: #e3550a;
    }
</style>


<?php

get_footer();