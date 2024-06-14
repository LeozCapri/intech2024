<?php
/*
Template Name: Login
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
            <span class="category" style="color:white;">Does't Have An Account?</span>
                <h2 style="color:white;">Be a part of Us</h2>
                <p style="color:white;">We encourage all Faculty of Creative Multimedia and Computing to be a part of US. Stay Updated and
                    Keep Up</p>
            </div>
                <div class="buttons">
                    <br>
                    <div class="main-button">
                        <a href="/registration">Register Now</a>
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

<div class="contact-us section" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-6  align-self-center">
                <div class="section-heading">
                    <h6>Login</h6>
                    <h2>Suara Mahasiswa Pemangkin Universiti</h2>
                    <p>Welcome to INTECH, the driving force behind our university community. Dive into our platform, where your voice matters most. Explore, engage, and share our platform with your peers to amplify the student voice.</p>
                    <!-- <div class="special-offer">
                        <span class="offer">off<br><em>50%</em></span>
                        <h6>Valide: <em>24 April 2036</em></h6>
                        <h4>Special Offer <em>50%</em> OFF!</h4>
                        <a href="#"><i class="fa fa-angle-right"></i></a>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-us-content">
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
                                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"
                                        class="forgot-password-link" style="padding-left:10px;color:white;">Forgot Password?</a>
                                </fieldset>
                            </div>
                        </div>
                    </form>
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