<div class="sidebar">
    <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Widgets')); //widget sẽ hiển thị khi theo tác kéo thả trong dashboard ?>
    <div class="sbox">
        <h3 class="stitle">Top Nhạc Rap</h3>
        <ul class="tabs">
            <li class="active"><a href="#week">Tuần</a></li>
            <li><a href="#month">Tháng</a></li>
            <li><a href="#year">Năm</a></li>
        </ul>
        <?php 
            $week = date('W');
            $month = date('m');
            $year = date('Y');
            //lấy ngày tháng năm hiện tại
            $base_arg = array(
                    "post_type" => "song",
                    "post_status" => "publish",
                    "posts_per_page" => 10,
                    "meta_key" => "view",
                    "orderby" => "meta_value_num",
                    "order" => "DESC" 
                );
        ?>
        <ul class="slst" id="week">
            <?php 
                query_posts(array_merge($base_arg, array("year"=>$year,"w"=>$week)));
                while(have_posts()) : the_post(); 
                ?>
                <li>
                    <div class="info-music">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <p class="singers"><?php the_terms(get_the_ID(), "singer", "", ", "); ?></p>
                    </div>
                    <div class="sview">
                        <?php 
                            $view = get_post_meta(get_the_ID(), "view", true);
                            if($view) echo $view; else echo 0;
                        ?>
                    </div>
                </li>
                <?php
                endwhile;
                wp_reset_query();
            ?>
        </ul><!--week-->
        <ul class="slst" id="month">
            <?php 
                query_posts(array_merge($base_arg, array("year"=>$year,"monthnum"=>$month)));
                while(have_posts()) : the_post(); 
                ?>
                <li>
                    <div class="info-music">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <p class="singers"><?php the_terms(get_the_ID(), "singer", "", ", "); ?></p>
                    </div>
                    <div class="sview">
                        <?php 
                            $view = get_post_meta(get_the_ID(), "view", true);
                            if($view) echo $view; else echo 0;
                        ?>
                    </div>
                </li>
                <?php
                endwhile;
                wp_reset_query();
            ?>
        </ul><!--month-->
        <ul class="slst" id="year">
            <?php 
                query_posts(array_merge($base_arg, array("year"=>$year)));
                while(have_posts()) : the_post(); 
                ?>
                <li>
                    <div class="info-music">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <p class="singers"><?php the_terms(get_the_ID(), "singer", "", ", "); ?></p>
                    </div>
                    <div class="sview">
                        <?php 
                            $view = get_post_meta(get_the_ID(), "view", true);
                            if($view) echo $view; else echo 0;
                        ?>
                    </div>
                </li>
                <?php
                endwhile;
                wp_reset_query();
            ?>
        </ul><!--month-->
        <script type="text/javascript">
        jQuery(document).ready(function($){
            $('.tabs li a').click(function(){
                $('.slst').css({'display' : 'none'});
                $($(this).attr('href')).fadeIn();
                $('.tabs li').removeClass('active');
                $(this).parent().addClass('active');
                return false;
            });
        });
        </script>
    </div>
</div><!--end sidebar-->