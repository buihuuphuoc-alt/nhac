<?php
    function dvd_enqueue_scripts(){
        wp_enqueue_script('jquery');
    }
    add_action('wp_enqueue_scripts', 'dvd_enqueue_scripts');
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Sidebar Widgets',
    		'id'   => 'sidebar-widgets',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h3>',
    		'after_title'   => '</h3>'
    	));
    }

    function dvd_register_nav_menu() {
        register_nav_menus(
            array(
                    'main-menu' => 'Menu'
            )
        );
    }
    add_action("init","dvd_register_nav_menu");
    //================
    
    function dvd_register_song_post_type() {
        $labels = array(
            'name' => 'Bài hát',
            'singular_name' => 'Bài hát',
            'add_new' => 'Thêm mới',
            'add_new_item' => 'Thêm mới bài hát',
            'edit_item' => 'Sửa bài hát',
            'new_item' => 'Bài hát mới',
            'all_items' => 'Danh sách bài hát',
            'view_item' => 'Xem bài hát',
            'search_items' => 'Tìm bài hát',
            'not_found' => 'Không tìm thấy!',
            'not_found_in_trash' => 'Không có bài hát nào trong thùng rác!',
            'menu_name' => 'Bài hát'
        );
        $args = array(
            'labels'             => $labels,
            'public'             => true, 
            'publicly_queryable' => true, 
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'bai-hat' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 3,
            'supports'           => array( 'title', 'thumbnail')
        );
        register_post_type('song', $args);
    }
    add_action('init', 'dvd_register_song_post_type');

    add_action('init', 'dvd_create_song_taxonomies');

    function dvd_create_song_taxonomies() {
        $labels = array(
            'name' => 'Thể loại',
            'singular_name' => 'Thể loại',
            'search_items' => 'Tìm kiếm',
            'all_items' => 'Danh sách thể loại',
            'parent_item' => 'Thể loại cha',
            'parent_item_colon' => 'Thể loại cha:',
            'edit_item' => 'Sửa Thể loại',
            'update_item' => 'Cập nhật',
            'add_new_item' => 'Thêm mới',
            'new_item_name' => 'Thêm Thể loại',
            'menu_name' => 'Thể loại',
            'not_found' => 'Không tìm thấy',
            'add_or_remove_items' => 'Thêm hoặc xóa',
            'popular_items' => 'Thể loại phổ biến',
            'popular_items' => 'Xem thể loại'
        );
        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'the-loai'),
        );
        register_taxonomy('song_category', 'song', $args);

        $labels = array(
            'name' => 'Ca sĩ',
            'singular_name' => 'Ca sĩ',
            'search_items' => 'Tìm kiếm',
            'all_items' => 'Danh sách Ca sĩ',
            'edit_item' => 'Sửa Ca sĩ',
            'update_item' => 'Cập nhật',
            'add_new_item' => 'Thêm mới',
            'new_item_name' => 'Thêm Ca sĩ',
            'menu_name' => 'Ca sĩ',
            'not_found' => 'Không tìm thấy',
            'add_or_remove_items' => 'Thêm hoặc xóa',
            'popular_items' => 'Phổ biến',
            'popular_items' => 'Xem Ca sĩ'
        );
        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'ca-si'),
        );
        register_taxonomy('singer', 'song', $args);
    }

    add_filter('query_vars', 'dvd_insert_song_query_vars');

    function dvd_insert_song_query_vars($vars) {
        array_push($vars, 'link_type'); //đăng ký query var với tên link_type
        return $vars;
    }

    add_action('rewrite_rules_array', 'dvd_song_rewrite_rules');

    function dvd_song_rewrite_rules($rules) {
        $new_rules = array();
        $new_rules['bai-hat/([^/]+)/?([^/]+)?\.html/?'] = 'index.php?song=$matches[1]&link_type=$matches[2]'; //thêm rule mới
        return $new_rules + $rules;
    }

    add_filter('post_type_link', 'custom_song_post_permalink'); 
    function custom_song_post_permalink ($post_link) { //sửa lại đường dẫn của custom post type
        global $post;
        if(!is_object($post)) return $post_link;
        $type = get_post_type($post->ID);
        switch($type){
            case 'song':
                return home_url() . '/bai-hat/' . $post->post_name . '.html';
            default:
                return home_url() . '/' . $type . '/' . $post->post_name . '.html';
        }
    }

    $song_customfields = array( //mảng custom fields
        array(
            "type" => "text",
            "name" => "link-zippyshare",
            "label" => "Link zippy share",
            "size" => 60
        ),
        array(
            "type" => "text",
            "name" => "link-youtube",
            "label" => "Link youtube",
            "size" => 60
        ),
        array(
            "type" => "text",
            "name" => "link-mp3",
            "label" => "Link mp3",
            "size" => 60
        ),
        array(
            "type" => "text",
            "name" => "link-mp4",
            "label" => "Link mp4",
            "size" => 60
        ),
        array(
            "type" => "wp_editor",
            "name" => "lyric",
            "label" => "Lời bài hát"
        )
    );

    add_action("add_meta_boxes", "dvd_add_song_box_meta"); //hook đăng ký meta box

    function dvd_add_song_box_meta() {
        add_meta_box("song_box", "Thông tin thêm", "dvd_show_song_box", "song", "normal", "low"); //hàm thêm meta box 
    }

    function dvd_show_song_box(){ //hiển thị meta box đã đăng ký
        global $song_customfields, $post;
        $song_info = get_post_custom($post->ID);
        echo "<table>";
        foreach($song_customfields as $field){
            switch($field['type']){
                case 'text':
                    ?>
                    <tr>
                        <td><label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label></td>
                        <td><input autocomplete="off" type="text" value="<?php if(isset($song_info[$field['name']])) echo $song_info[$field['name']][0]; ?>" 
                        id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>" size="<?php echo $field['size']; ?>" />
                        </td>
                    </tr>
                    <?php
                    break;
                case 'wp_editor':
                    ?>
                    <tr>
                        <td><label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label></td>
                        <td>
                            <?php 
                                $lyric = isset($song_info[$field['name']]) ? $song_info[$field['name']][0] : ""; 
                                wp_editor($lyric, $field['name'], array("media_buttons" => false));
                            ?>
                        </td>
                    </tr>
                    <?php
                    break;
            }
        }
        echo "</table>";
    }

    function dvd_save_product_custom_post($post_id){
    global $song_customfields;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) //tự động lưu
            return; 
        if (!current_user_can('edit_post', $post_id)) //kiểm tra quyển
            return;
        if(isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == "song"){ //kiểm tra request 
             foreach($song_customfields as $field){
                if(isset($_REQUEST[$field['name']]) && !empty($_REQUEST[$field['name']])){
                    update_post_meta($post_id, $field['name'], $_REQUEST[$field['name']]);
                }else{
                    delete_post_meta( $post_id, $field['name']);
                }
             }
        } 
    }
    add_action("save_post","dvd_save_product_custom_post");

    function dvd_play($link, $type){
        if($type == "zippyshare"){ //link zippy share dùng player của zippy
            if(preg_match("/www([0-9]+).zippyshare.com\/v\/([0-9]+)\/file.html/s",$link,$id)){
                ?>
                <script type="text/javascript">
                    var zippywww="<?php echo $id[1]; ?>";var zippyfile="<?php echo $id[2]; ?>"; var zippytext="#000000";var zippyback="#e8e8e8";var zippyplay="#ff6600";var zippywidth=640; var zippyauto=true; var zippyvol=100; var zippywave = "#000000"; var zippyborder = "#cccccc";
                </script>
                <script type="text/javascript" src="http://api.zippyshare.com/api/embed_new.js"></script>
                <?php
            }
        }else{  // các link còn lại dùng player của jwplayer
            $file = $link;
            if($type == "youtube") //thiết lập link youtube cho phù hợp
            {
                $pattern =
                    '%^
                    (?:https?://)?  
                    (?:www\.)?      
                    (?:             
                      youtu\.be/    
                    | youtube\.com  
                      (?:           
                        /embed/     
                      | /v/         
                      | .*v=       
                      )             
                    )               
                    ([\w-]{10,12})  
                    ($|&).*        
                    $%x'
                ;
                $result = preg_match($pattern, $link, $matches);
                if (false !== $result) {
                    $file = "https://www.youtube.com/watch?v=".$matches[1];
                }
            }
            ?>
            <script src="http://jwpsrv.com/library/6dYsVKQwEeOJmCIACmOLpg.js"></script>
            <div id='jwplayer'></div>

            <script type='text/javascript'>
                jwplayer('jwplayer').setup({
                    file: '<?php echo $file; ?>',
                    width: '100%', 
                    height: '<?php if($type == "youtube" || $type == "mp4") echo "350"; else echo "20"; ?>',
                    autostart: true
                });
            </script>
            <?php
        }
    }

    function dvd_paging() {
        global $wp_query, $paged;
        if($paged == 0) $paged = 1;
        $total = $wp_query->max_num_pages;
        $output = "";
        if ($total >= 2)
            $output .= "<a href='" . get_pagenum_link(1) . "' >Đầu</a>"; 
        if ($paged >= 2)
            $output .= "<a href='" . get_pagenum_link($paged - 1) . "' ><<</a>";
            
        if ($paged - 4 >= 1) {
            for ($i = $paged - 4; $i <= $paged; $i++) {
                if ($paged == $i)
                    $output .= "<span class='current_page'> $i </span>";
                else
                    $output .= "<a href='" . get_pagenum_link($i) . "' >$i </a>";
            }
        }
        else {
            for ($i = 1; $i <= $paged; $i++) {
                if ($paged == $i)
                    $output .= "<span class='current_page'> $i </span>";
                else
                    $output .= "<a href='" . get_pagenum_link($i) . "' >$i </a>";
            }
        }
        if ($paged + 4 <= $total) {
            for ($i = $paged + 1; $i <= $paged + 4; $i++) {
                if ($paged == $i)
                    $output .= "<span class='current_page'> $i </span>";
                else
                    $output .= "<a href='" . get_pagenum_link($i) . "' >$i </a>";
            }
        }else {
            for ($i = $paged + 1; $i <= $total; $i++) {
                if ($paged == $i)
                    $output .= "<span class='current_page'> $i </span>";
                else
                    $output .= "<a href='" . get_pagenum_link($i) . "' >$i </a>";
            }
        }
        if ($paged < $total)
            $output .= "<a href='" . get_pagenum_link($paged + 1) . "'>>></a>";
        if ($total >= 2)
            $output .= "<a href='" . get_pagenum_link($total) . "' >Cuối</a>";
        echo "<div id='pagination'>Trang: " . $output . '</div>';
    }

    /*function filter_where($where = '') {
        $where .= " AND post_date > '" . date('Y-m-d', strtotime('-1 days')) . "'";
        return $where;
      }
    add_filter('posts_where', 'filter_where');*/

    function dvd_search_filter($query) {
        if ($query->is_search && !is_admin() ) {
            $query->set('post_type', array("song"));
        }
        return $query;
    }
    add_filter('pre_get_posts','dvd_search_filter');

?>