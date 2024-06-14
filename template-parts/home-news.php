<?php
// $query = new WP_Query(
//     array(
//         'post_type' => 'post',
//         'category_name' => 'projects',
//         'posts_per_page' => -1, // Display all posts
//         'post_status' => 'publish',
//         'order' => 'DESC',
//         'paged' => $paged
//     )
// );

?>

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
                                <span class="categories">
                                    <span class="category">
                                        <?php
                                        $categories = get_the_category();
                                        $category_names = array_map(function ($category) {
                                            return $category->name;
                                        }, $categories);
                                        echo implode(', ', $category_names);
                                        ?>
                                    </span>
                                </span>
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
    /* Projects Styling */
    .card {
        max-width: $max-card-width;
        /* Use the defined variable */
    }

    #project .bi.bi-box-arrow-in-up-right {
        font-size: 30px;
        margin-left: 30px;
    }

    @media screen and (max-width: 767px) {

        #project .description,
        #project .bi.bi-box-arrow-in-up-right,
        #project .read-more-btn {
            display: none;
        }
    }

    @media (max-width: 579px) {
        #project .card-body .d-flex {
            flex-direction: column;
        }

        #project .card-body .p-5 {
            padding-top: 20px;
            /* Adjust as needed */
        }

        #project .card-body .img-fluid {
            margin-bottom: 20px;
            /* Adjust as needed */
        }

        #project .card-body .ms-md-3 {
            margin-left: 0;
            /* Remove left margin for image */
        }
    }

    #project .card {
        max-width: 800px;
        /* Adjust as needed */
        margin: 0 auto;
        /* Center the card */
    }

    #project .project-image {
        max-width: 400px;
        /* Adjust as needed */
        flex-shrink: 0;
        /* Prevent image from shrinking */
    }

    a {
        text-decoration: none;
        color: inherit;
        /* Use the parent element's color */
    }

    #project a:hover {
        color: var(--bs-link-color);
        text-decoration: none;
    }
</style>