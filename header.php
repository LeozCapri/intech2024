<?php
// Get the current user info
$current_user = wp_get_current_user();
$user_roles = $current_user->roles;

// Determine the user's role
$user_role = 'public'; // Default to public if not logged in
if (in_array('student', $user_roles)) {
    $user_role = 'student';
} elseif (in_array('administrator', $user_roles)) {
    $user_role = 'admin';
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php wp_title(); ?>
    </title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <?php wp_head(); ?>
    <!-- Favicon-->

    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>\dist\assets\leozcapri.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>Scholar - Online School HTML5 Template</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo get_template_directory_uri(); ?>\vendor\bootstrap\css\bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>\assets\css\fontawesome.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>\assets\css\templatemo-scholar.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>\assets\css\owl.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>\assets\css\animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>\node_modules/sweetalert2/dist/sweetalert2.min.css">



</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <!-- <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div> -->
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="<?php echo home_url(); ?>" class="logo">
                            <h1><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.uisint-01.png"
                                    alt="Logo"></h1>
                        </a>
                        <!-- ***** Logo End ***** -->

                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="<?php echo home_url(); ?>">Home</a>
                            </li>
                            <?php if (current_user_can('administrator')): ?>
                                <li class="scroll-to-section">
                                    <a href="<?php echo site_url('/news'); ?>">News</a>
                                    <ul class="submenu">
                                        <li><a href="/manage-news">Manage</a></li>
                                        <li><a href="#news2">News 2</a></li>
                                    </ul>
                                </li>
                                <li class="scroll-to-section">
                                    <a href="<?php echo site_url('/programs'); ?>">Program</a>
                                    <ul class="submenu">
                                        <li><a href="/manage-programs">Manage</a></li>
                                        <li><a href="#program2">Program 2</a></li>
                                    </ul>
                                </li>
                                <li class="scroll-to-section"><a href="#about">About Us</a></li>
                                <li class="scroll-to-section">
                                    <a href="#profile">Profile</a>
                                    <ul class="submenu">
                                        <li><a href="#program1">Profile</a></li>
                                        <?php if (is_user_logged_in()): ?>
                                            <li class="scroll-to-section">
                                                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>">Logout</a>
                                            </li>
                                        <?php else: ?>
                                            <li class="scroll-to-section">
                                                <a href="<?php echo esc_url(wp_login_url()); ?>">Login</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php elseif (current_user_can('subscriber')): ?>
                                <li class="scroll-to-section"><a href="<?php echo site_url('/news'); ?>">News</a></li>
                                <li class="scroll-to-section"><a href="#about">About Us</a></li>
                                <li class="scroll-to-section"><a href="<?php echo site_url('/login'); ?>">Register/Login</a>
                                </li>
                            <?php else: ?>
                                <li class="scroll-to-section"><a href="<?php echo site_url('/news'); ?>">News</a></li>
                                <li class="scroll-to-section"><a href="#about">About Us</a></li>
                                <li class="scroll-to-section"><a href="<?php echo site_url('/login'); ?>">Register/Login</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->