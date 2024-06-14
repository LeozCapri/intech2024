<?php
/*
Template Name: Registration
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

<div class="contact-us section" id="register">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 align-self-center">
                <div class="section-heading">
                    <h6>Register</h6>
                    <h2>Join Our Community</h2>
                    <h3>"Suara Mahasiswa Pemangkin Universiti"</h3>
                    <p>Fill out the form below to create an account and become a part of our university community.</p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="contact-us-content">
                    <form id="registration-form" action="" method="post" onsubmit="return validateForm()">
                        <div class="row">
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Username</a>
                                    <input type="text" name="username" id="username" class="input-field"
                                        placeholder="Please enter your matric no" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Email</a>
                                    <input type="email" name="email" id="email" class="input-field"
                                        placeholder="Please use your organization email address" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Password</a>
                                    <input type="password" name="password" id="password" class="input-field"
                                        placeholder="Password" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Confirm Password</a>
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        class="input-field" placeholder="Confirm Password" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Identification Card No</a>
                                    <input type="text" name="ic_no" id="ic_no" class="input-field" placeholder="IC No"
                                        required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Birth of data MM/DD/YYYY</a>
                                    <input type="date" name="birth_date" id="birth_date" class="input-field"
                                        placeholder="Birth Date" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Faculty</a>
                                    <select name="faculty" id="faculty" class="input-field" required>
                                        select name="faculty" id="faculty" class="regular-text">
                                        <option value="">Select Faculty</option>
                                        <option value="FAKULTI PENGURUSAN DAN MUAMALAH">FAKULTI PENGURUSAN DAN MUAMALAH
                                        </option>
                                        <option value="FAKULTI PENGAJIAN PERADABAN ISLAM">FAKULTI PENGAJIAN PERADABAN
                                            ISLAM</option>
                                        <option value="FAKULTI MULTIMEDIA KREATIF DAN KOMPUTERAN">FAKULTI MULTIMEDIA
                                            KREATIF DAN KOMPUTERAN
                                        </option>
                                        <option value="FAKULTI PENDIDIKAN">FAKULTI PENDIDIKAN</option>
                                        <option value="FAKULTI SYARIAH DAN UNDANG-UNDANG">FAKULTI SYARIAH DAN
                                            UNDANG-UNDANG</option>
                                        <option value="FAKULTI SAINS SOSIAL">FAKULTI SAINS SOSIAL</option>
                                        <option value="INSTITUT KAJIAN HADIS & AKIDAH">INSTITUT KAJIAN HADIS & AKIDAH
                                        </option>
                                        <option value="PUSAT MATRIKULASI">PUSAT MATRIKULASI</option>
                                    </select>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Course (Please select faculty first)</a>
                                    <select name="course" id="course" class="input-field" required>
                                        <option value="">Select Course</option>
                                        <!-- Courses will be populated based on faculty selection -->
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <!-- Replace "YOUR_SITE_KEY" with your reCAPTCHA site key -->
                                    <!-- <div class="g-recaptcha" data-sitekey="6LdAK_QpAAAAABuc9oaYwsfmNj0i-HmvjRDPCB77"></div> -->
                                    <button type="submit" id="register-submit" class="orange-button">Register</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>

                    <?php if (isset($registration_error)): ?>
                        <p style="color:red;"><?php echo $registration_error; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    #registration-form {
        margin-top: 20px;
    }

    #registration-form fieldset a {
        color: white;
    }

    .input-field {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #register-submit {
        background-color: #f26722;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        margin: 0 auto;
        display: block;
    }



    #register-submit:hover {
        background-color: #e3550a;
    }
</style>


<?php

get_footer();