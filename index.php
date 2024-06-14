<?php

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
	}
}

get_sidebar();
get_footer();