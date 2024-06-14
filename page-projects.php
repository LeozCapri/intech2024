<?php
/*
Template Name: Projects
*/
get_header();
?>

<body class="d-flex flex-column h-100">
    <?php
    $query = new WP_Query(
        array(
            'post_type' => 'post',
            'category_name' => 'projects',
            'posts_per_page' => -1, // Display all posts
            'post_status' => 'publish',
            'order' => 'DESC',
            'paged' => $paged
        )
    );

    ?>
    <section class="py-5" id="projects">
        <div class="container px-5 mb-5">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">Projects</span></h1>
            </div>
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-11 col-xl-9 col-xxl-8">
                    <?php
                    $max_projects = 3; // Maximum number of projects to display initially
                    $project_count = 0;

                    if ($query->have_posts()) {
                        while ($query->have_posts() && $project_count < $max_projects) {
                            $query->the_post();

                            // Get ACF fields
                            $title = get_field('title');
                            $description = get_field('description');
                            $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $projectlink = get_field('project_link');

                            // Limit description to 10 words followed by "..."
                            $words = explode(" ", $description);
                            $limitedWords = array_slice($words, 0, 10);
                            $limitedDescription = implode(" ", $limitedWords) . '...';

                            // Get post permalink
                            $permalink = get_permalink();
                            ?>

                            <!-- Project Card -->
                            <div id="project" href="<?php echo $permalink; ?>"
                                class="card overflow-hidden shadow rounded-4 border-0 mb-5">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column-reverse flex-md-row align-items-center">
                                        <div class="p-5">
                                            <h2 class="fw-bolder">
                                                <a href="<?php echo $permalink; ?>">
                                                    <?php echo $title; ?>
                                                </a>
                                            </h2>
                                            <p class="description" style="text-align: justify;">
                                                <?php echo $limitedDescription; ?>
                                            </p>
                                            <!-- Read More Button -->
                                            <div>
                                                <a href="<?php echo esc_url(get_permalink($id)); ?>"
                                                    class="btn btn-primary px-4 py-3 read-more-btn">Read More</a>
                                                <?php if (!empty($projectlink)): ?>
                                                    <a class="bi bi-box-arrow-in-up-right" href="<?php echo $projectlink; ?>"
                                                        target="_blank" rel="noopener noreferrer"></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if ($featured_image_url): ?>
                                            <a href="<?php echo $permalink; ?>" class="d-flex flex-column flex-md-row-reverse">
                                                <img class="img-fluid mb-3 mb-md-0 ms-md-3 project-image"
                                                    src="<?php echo $featured_image_url; ?>" alt="<?php echo $title; ?>" />
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $project_count++;
                        }
                    } else {
                        ?>
                        <p>No project found.</p>

                        <?php
                    }

                    wp_reset_postdata();
                    ?>
                </div>

            </div>
        </div>
    </section>
    <?php get_template_part('template-parts/home', 'action'); ?>

</body><!-- #primary -->

<?php
//get_sidebar();
get_footer();

?>

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