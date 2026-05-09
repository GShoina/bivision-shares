<?php

/*Template Name: Home*/


get_header();

session_start();


?>


    <div class="cards">
        <div class="container">
            <div class="row">


                <?php
                if ( is_user_logged_in() ) {

                    ?>
                    <div class="toggler_login">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5 login_bar m-auto shadow">
                                    <i class="fa fa-times float-right closer_toggle" aria-hidden="true"></i>
                                    <form id="add-new" class="w-100 ajax_method">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12 col-md-10 py-2 m-auto">
                                                    <div class="row p-2">
                                                        <h6 class="mb-2">გასაგრძელებლად გთხოვთ გაიაროთ ავტორიზაცია</h6>
                                                        <span class="m-auto text-danger font-weight-bold"><?php if(isset($message)){echo $message;} ?></span>
                                                        <input type="email" class="col-12 col-xl-12 m-1" placeholder="ელ. ფოსტა" required name="contact_email">
                                                        <input type="password" class="col-12 col-xl-12 m-1" placeholder="პაროლი" required name="password">
                                                        <input type="hidden" value="1" required name="login_ajax">
                                                        <input type="hidden" required name="redirection" class="red">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <button type="button" class="submit w-100 mt-1">ავტორიზაცია</button>
                                                            </div>
                                                        </div>
                                                        <div class="reg_btn"><a href="<?php echo get_home_url().'/register-me/?registration=1'; ?>">რეგისტრაცია</a></div>
                                                        <div class="reg_btn b"><a href="<?php echo get_home_url().'/register-me/?forgot=1'; ?>">პაროლის აღდგენა</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="overer">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-11 m-auto">
                                    <i class="fa fa-times float-right closer" aria-hidden="true"></i>
                                    <div class="card__item shadow">
                                        <div class="card__item--image">
                                            <img src="#" class="w-100">
                                        </div>
                                        <div class="card__item--title">
                                            <h3>
                                                ერთიანი ეროვნული გამოცდების შედეგები
                                            </h3>
                                            <div class="p"></div>
                                            <div class="row inner_m-auto text-center toggle_1">
                                                <?php if($_SESSION['user'] != 1){?>
                                                    <a href="#" class="login"><button class="header__cta--btn">ანალიტიკური დეშბორდი</button></a>
                                                    <!--                                                    <a href="--><?php //echo get_home_url().'/register-me/?registration=1'; ?><!--"><div>რეგისტრაცია</div></a>-->
                                                <?php }else{ ?>
                                                    <a href="#" class="linker"><button class="header__cta--btn m-auto">Comming Soon</button></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php

                    query_posts( array('post_type'=>'cards','order' => 'DESC', 'posts_per_page' => -1 ) );

                    $i = 0;
                    if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php
                        $comming = get_post_meta( get_the_ID(), 'iframe_url', true );
                        $img_detailed = get_post_meta( get_the_ID(), 'img_detailed', true );
                        $title_detailed = get_post_meta( get_the_ID(), 'title_detailed', true );
                        $text_detailed = get_post_meta( get_the_ID(), 'text_detailed', true );
                        ?>
                        <div class="col-md-3 viewer">
                            <div class="card__item">
                                <div class="card__item--image">
                                    <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                                </div>
                                <div class="card__item--title">
                                    <h3>
                                        <?php the_title(); ?>
                                    </h3>
                                </div>
                            </div>
                            <div class="data_title d-none"><?php echo $title_detailed; ?></div>
                            <div class="data_image d-none"><?php echo $img_detailed; ?></div>
                            <div class="data_text d-none"><?php echo the_content(); ?></div>
                            <div class="data_url d-none"><?php if(!isset($comming) OR empty($comming)){echo"Comming Soon";}else{the_permalink();}?></div>
                        </div>
                        <?php $i++; endwhile; endif;
                    wp_reset_query();
                }else{
                    query_posts( array('post_type'=>'cards','order' => 'DESC', 'posts_per_page' => -1, 'post__not_in' => array(213)  ) );

                    $i=0; if ( have_posts() ) : while(have_posts()) : the_post(); ?>
                        <div class="col-md-3">
                            <div class="card__item">
                                <div class="card__item--image">
                                    <a href="<?php the_permalink();?>"><img src="<?php the_post_thumbnail_url();?>" alt="<?php the_title();?>"></a>
                                </div>
                                <div class="card__item--title">
                                    <h3>
                                        <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <?php $i++; endwhile; endif; wp_reset_query();
                }
                ?>
            </div>
        </div>
    </div>



<?php get_footer();?>