<?php
/*
Template Name: 404
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
                    <span class="category" style="color:white;">Salam Alaikum</span>
                    <h2 style="color:white;">Already have an account?</h2>
                    <p style="color:white;">If you already have an account, please login below.</p>
                </div>
                <div class="buttons">
                    <br>
                    <div class="main-button">
                        <a href="/login">Login</a>
                    </div>
                    <br>
                    <div class="icon-button">
                        <a href="#"><i class="fa fa-play"></i>Why you should Sign Up</a>
                    </div>
                </div>
            </div>
            <!-- </div>
                </div>
            </div> -->
        </div>
    </div>
</div>

<div class="contact-us section" id="error-404">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 align-self-center">
                <div class="section-heading">
                    <h6>Error 404</h6>
                    <h2>Page Not Found</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="contact-us-content">
                    <?php
                    $current_url = $_SERVER['REQUEST_URI'];
                    $page_exists = get_page_by_path($current_url);
                    $page_permissions = ''; // define the page permissions variable
                    
                    if (!$page_exists) { ?>
                        <p style="color:white;text-align:center;">The URL <code><?php echo $current_url; ?></code> does not exist.</p>
                    <?php } else { ?>
                        <?php if (!current_user_can($page_permissions)) { ?>
                            <p>You do not have the necessary permissions to access this page.</p>
                            <?php if (!is_user_logged_in()) { ?>
                                <p>Please login to access this page.</p>
                                <form id="login-form" action="<?php echo esc_url(wp_login_url()); ?>" method="post">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset>
                                                <input type="text" name="log" id="user_login" class="input-field"
                                                    placeholder="Username" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12">
                                            <fieldset>
                                                <input type="password" name="pwd" id="user_pass" class="input-field"
                                                    placeholder="Password" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12">
                                            <fieldset>
                                                <button type="submit" id="login-submit" class="orange-button">Login</button>
                                                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="forgot-password-link"
                                                    style="padding-left:10px;color:white;">Forgot Password?</a>
                                            </fieldset>
                                        </div>
                                    </div>
                                </form>
                            <?php } ?>
                        <?php } else { ?>
                            <p>The page <code><?php echo $current_url; ?></code> is not reachable.</p>
                            <?php if (!is_user_logged_in()) { ?>
                                <p>Please login to access this page.</p>
                                <form id="login-form" action="<?php echo esc_url(wp_login_url()); ?>" method="post">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset>
                                                <input type="text" name="log" id="user_login" class="input-field"
                                                    placeholder="Username" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12">
                                            <fieldset>
                                                <input type="password" name="pwd" id="user_pass" class="input-field"
                                                    placeholder="Password" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12">
                                            <fieldset>
                                                <button type="submit" id="login-submit" class="orange-button">Login</button>
                                                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="forgot-password-link"
                                                    style="padding-left:10px;color:white;">Forgot Password?</a>
                                            </fieldset>
                                        </div>
                                    </div>
                                </form>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


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