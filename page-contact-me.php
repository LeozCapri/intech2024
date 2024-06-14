<?php
/*
Template Name: Contact Me
*/
get_header();
?>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <?php get_template_part('template-parts/home', 'header');  ?>
        <section class="py-5" id="projects">
            <div class="container px-5 mb-5">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">Contact Me</span></h1>
                </div>
                <div class="row gx-5 justify-content-center">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry-content">
                            <?php
                            // Display the page content
                            while (have_posts()) {
                                the_post();
                                the_content();
                            }

                            ?>
                        </div><!-- .entry-content -->
                    </article><!-- #post-<?php the_ID(); ?> -->
                </div>
            </div>
        </section>
        
    </main><!-- #main -->
</body><!-- #primary -->

<?php
//get_sidebar();
get_footer();
?>