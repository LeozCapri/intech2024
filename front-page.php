<?php
/*
Template Name: Homepage
*/
get_header();

?>

 <!-- Banner-->
 <?php get_template_part('template-parts/home', 'banner');  ?>

 <!-- Services-->
 <?php get_template_part('template-parts/home', 'services');  ?>

 <!-- About-->
 <?php get_template_part('template-parts/home', 'about');  ?>

 <!-- News-->
 <?php get_template_part('template-parts/home', 'news');  ?>

 <!-- Data-->
 <?php get_template_part('template-parts/home', 'data');  ?>

 <!-- Team-->
 <?php get_template_part('template-parts/home', 'team');  ?>

 <!-- Testimonial-->
 <?php get_template_part('template-parts/home', 'testimonial');  ?>

 <!-- Events-->
 <?php get_template_part('template-parts/home', 'events');  ?>

 <!-- Contact Us-->
 <?php get_template_part('template-parts/home', 'contactus');  ?>


<?php

get_footer();