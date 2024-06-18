<?php
/*
Template Name: Add News 
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
                    <h6>Add News</h6>
                    <h2>Suara Mahasiswa Pemangkin Universiti</h2>
                    <p>Welcome to INTECH, the driving force behind our university community. Dive into our platform, where your voice matters most. Explore, engage, and share our platform with your peers to amplify the student voice.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-us-content">
                    <form id="add-news-form" method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <fieldset>
                                    <label for="news-title">News Title:</label>
                                    <input type="text" id="news-title" name="news_title" class="input-field" placeholder="News Title" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <label for="news-content">News Content:</label>
                                    <textarea id="news-content" name="news_content" class="input-field" placeholder="News Content" required></textarea>
                                    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
                                    <script>
                                        tinymce.init({
                                            selector: '#news-content',
                                            height: 300,
                                            menubar: false,
                                            plugins: [
                                                'advlist autolink lists link image charmap print preview anchor',
                                                'earchreplace visualblocks code fullscreen',
                                                'insertdatetime media table paste code help wordcount'
                                            ],
                                            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
                                        });
                                    </script>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <label for="news-subcategory">Subcategory:</label>
                                    <select id="news-subcategory"name="news_subcategory" class="input-field">
                                        <option value="">Select a subcategory</option>
                                        <?php
                                        $news_category = get_category_by_slug( 'news' );
                                        $subcategories = get_categories( array(
                                            'parent' => $news_category->term_id,
                                            'hide_empty' => false,
                                        ) );

                                        foreach ( $subcategories as $subcategory ) {?>
                                            <option value="<?php echo $subcategory->term_id;?>"><?php echo $subcategory->name;?></option>
                                        <?php }?>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <label for="new-subcategory">Or add a new subcategory:</label>
                                    <input type="text" id="new-subcategory" name="new_subcategory" class="input-field" placeholder="New Subcategory">
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <button type="submit" id="add-news-submit" class="orange-button">Add News</button>
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