<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    Ilya test
    test2
    -------------------------------------------- ОДИНОЧНЫЕ КОМАНДЫ ХЕДЕРА----------------------------------------------------------------------------------

    <meta name="viewport" content="width=device-width"> для мобыльных

    тайтл - <title><?php echo (get_post_meta($post->ID, 'title', true)); ?></title>
    IE - <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    дескрипшн - <meta name="description" content="<?php echo (get_post_meta($post->ID, 'description', true)); ?>"/>

    ключевые слова - <meta name="keywords" content="<?php echo (get_post_meta($post->ID, 'keywords', true)); ?>"/>

    вид кодировки - <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>

    сслка на явая скрипт - <script type="text/javascript" src="<?php bloginfo('template_url');?>/js/...." />

    ссылка на цсс - <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

    ссылка на фавикон - <link rel="shortcut icon" href="<?php bloginfo('template_url');?>/favicon.ico"/>
    <link href="<?php bloginfo('template_url');?>/favicon.ico" rel="icon" type="image/x-icon" />

</head>

<body>
----------------------------------------------------обавление через function.php------------------------------------------------------------------
function vsp_scripts()
{
wp_enqueue_style('vsp-style', get_stylesheet_uri());
wp_enqueue_style('vsp-bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
wp_enqueue_style('vsp-fonts', get_template_directory_uri() . '/css/fonts.css');
wp_enqueue_style('vsp-main', get_template_directory_uri() . '/css/main.css');
wp_enqueue_style('vsp-media', get_template_directory_uri() . '/css/media.css');

wp_enqueue_script('vsp-navigation',get_template_directory_uri().'/js/navigation.js',array('jquery'));
wp_enqueue_script('vsp-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array('jquery'));
wp_enqueue_script('vsp-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'));
wp_enqueue_script('vsp-maim', get_template_directory_uri() . '/js/main.js', array('jquery'));



?>
<!--[if lt IE 9]> <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->

<link rel="apple-touch-icon" sizes="144x144" href="<?= get_template_directory_uri(); ?>/img/ico/144x144.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?= get_template_directory_uri(); ?>/img/ico/114x114.png" />
<link rel="apple-touch-icon" sizes="72x72" href="<?= get_template_directory_uri(); ?>/img/ico/72x72.png" />
<link rel="apple-touch-icon" href="<?= get_template_directory_uri(); ?>/img/ico/57x57.png" />
<link rel="shortcut icon" type="image/png" href="<?= get_template_directory_uri(); ?>/img/ico/favicon.ico" />

<?php
if ( is_singular() && comments_open() && get_option('thread_comments') )
{
    wp_enqueue_script('comment-reply');
}
}

add_action('wp_enqueue_scripts', 'vsp_scripts');
----------------------------------------------ОДИНОЧНЫЕ КОМАНДЫ-----------------------------------------------------------
команда подключить хедер - <?php
require('./wp-blog-header.php');
require_once('header.php');
?>
--------------config------------
/* If editor in admin isn't working /

define( 'CONCATENATE_SCRIPTS', false );
---------------------------------
вывод произвольного поля <?php echo (get_post_meta($post->ID, 'title', true)); ?>

вывод облака тегов см синтаксис: http://wpworld.ru/wordpress-vyvod-oblaka-metok-tag-cloud/
<?php wp_head(); ?>
команда вставляется в футер для поддержки яваскриптов <?php wp_footer(); ?>

команда подключить садбар - <?php require('sidebar.php'); ?>

команда выдать футер - <?php require('footer.php'); ?>

сслка на изображение - <img src="<?php bloginfo('template_url');?>/img/ 
add_theme_support( 'post-thumbnails' );
вывод миниатюры записи <?php the_post_thumbnail(array( 380,630 )); ?>    <a href="<?php the_permalink(); ?>" class="thumbnail"><?php the_post_thumbnail(); ?></a>
the_post_thumbnail();                  // без параметров, миниатюра
the_post_thumbnail('thumbnail');       // Миниатюра (по умолчанию 150px x 150px)
the_post_thumbnail('medium');          // Средний размер (по умолчанию 300px x 300px)
the_post_thumbnail('large');           // Большой размер (по умолчанию 640px x 640px)
the_post_thumbnail('full');            // Полный размер (оригинальный размер изображения)
the_post_thumbnail( array(100,100) );  // Другие размеры
<?php the_post_thumbnail( array( 270,201 ), $default_attr = array(
    'class' => "img_inner fleft",
    'alt' => trim(strip_tags( $wp_postmeta->_wp_attachment_image_alt )),
) ); ?>
вывод миниатюры записи со ссылкой на исходник изображения <?php
if ( has_post_thumbnail()) {
    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
    echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" >';
    the_post_thumbnail('thumbnail');
    echo '</a>';
}
?>
команда выдать заголовок - <?php the_title(); ?>

команда выдатать контента - <?php the_content(); ?>

команда вовод анотации- <?php the_excerpt(); ?>
function do_excerpt($string, $word_limit) {
$words = explode(' ', $string, ($word_limit + 1));
if (count($words) > $word_limit)
array_pop($words);
echo implode(' ', $words).' ...';
}
<?php do_excerpt(get_the_excerpt(), 50); ?>
команда вывода категорий к посту <?php _e('Категории&#58;'); ?> <?php the_category(', ') ?>

следующая / предидущая страница <?php posts_nav_link(); ?>

вывод команд из плагинов <?php echo do_shortcode('[contact-form-7 id="4" title="Lending!!!!!!"]'); ?>

--------------------------------------------------- ЦИКЛЫ --------------------------------------------------------
цикл вывода главной страници -
<?php if (is_home()) {
    global $wpdb;
    $p = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_name = 'o-kompanii'");
    if ($p) {
        foreach ( $p as $post ) {
            $ID = $post->ID;
            $post = get_post($ID);
            setup_postdata($post);
        }
    }
    ?>

    <?php the_title(); ?>

    <?php the_content() ?>
<?php } ?>
---------------------------------------get info from widget or db data---------------------------------------------------------
<?php
$user_count = $wpdb->get_var("SELECT option_value FROM wp_options WHERE option_id = '146'");
$unserialized = unserialize($user_count);

$adress1 = $unserialized[2]['adress'];
$phone1 = $unserialized[2]['phone'];
$email1 = $unserialized[2]['email'];

?>
<?php
$text_widgets = get_option( 'widget_adress' );
$adress = $text_widgets[2]['adress'];
$phone = $text_widgets[2]['phone'];
$email = $text_widgets[2]['email'];
?>
-----------------------------------------------------посты--------------------------------------------------------------------
query_posts(‘cat=-3′) - Не показывать категорию id которой равно 3;
query_posts(‘cat=-1,-2,-3′) - Не показывать категории, id которых равны 1, 2 и 3;
query_posts(‘cat=2,6,17′) - Вывести категории с id равным 2, 6 и 17;
query_posts(‘category_name=WordPress’) - Вывести категорию с названием "WordPress";
query_posts(‘name=Hello World’) - Вывести один пост с названием "Hello World";
query_posts(‘p=5′) - Вывести один пост, id которого равно 5;
query_posts(‘page_id=7′) - Вывести страницу id которой равно 7;
query_posts(‘pagename=about’) - Вывести страницу с названием "about";
query_posts(‘cat=18&showposts=5′) - Вывести 5 постов из категории с id=18;
query_posts(‘cat=3&orderby=date&order=ASC’) - Вывести посты из категории id которой равно 3, сортировать по дате в хронологическом порядке(DESC - в обратном порядке);
query_posts(‘posts_per_page=10′) - Вывести 10 постов на страницу (при значении -1 выводит все посты);
query_posts(‘cat=3&year=2008′) - Вывести посты из категории с id=3 за 2008 год;
query_posts(‘orderby=rand&showposts=3&cat=3′) - выводин рандомно, т.е. случайно 3 записи из 3 категории;
query_posts(‘orderby=rand&showposts=3′) - выводит случайно 3 записи из всех категорий;
query_posts(‘meta_key=cars&meta_value=volvo’) - выводит список постов с произвольным полем "cars" и значением этого поля volvo.
---------------------------------------------------------------------------------------------------------------------------
вывести имя категории   <?php echo get_cat_name(1); ?>
--------------------------------------------------------
цикл вывода главной страници, WP_Query (также подходит для вывода двух статических страниц одновременно) -
<?php
$query1 = new WP_Query('page_id=8');
while($query1->have_posts()){ $query1->the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <?php the_content() ?>
<?php } ?>


<?php wp_reset_postdata(); ?>
--------------------------------вывод анонса поста----------------------------------------------------------------------------
-------этот код мы прописываем в файле functions.php,:----
<?php function do_excerpt($string, $word_limit) {
    $words = explode(' ', $string, ($word_limit + 1));
    if (count($words) > $word_limit)
        array_pop($words);
    echo implode(' ', $words).' ...';
}
?>

-----а следующий ставим в нашем коде сайдбара:-----
<?php do_excerpt(get_the_excerpt(), 18); ?>
--------------------------------------------------------------if page--------------------------------------------------------------------------
<?php
if(is_page(42)){

    Show something only for page 42

} else {

    Show something for all other pages

}
?>
-------------------------------------------------------------стандартный цикл луп -----------------------------------------------------------------
стандартный цикл луп - <?php if(have_posts()) : ?>
    <?php while(have_posts())  : the_post(); ?>
        ------
        заголовок поста в ссылке - <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>

        <?php the_content(); ?>
    <?php endwhile; ?>
<?php else : ?>

    <p><?php _e('Новости компании пока не опубликованы...'); ?></p>

<?php endif; ?>
---------------------------------------------------------------------------------------------------------------------
вывод на статической странице -
<?php if (have_posts()) : the_post() ?>
    <?php the_title(); ?>
    <?php the_content() ?>
<?php endif ?>
---------------------------------------------------------------------------------------------------------------------
цикл  query_posts -
<?php query_posts('cat=8&posts_per_page=3'); ?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        <?php the_content(); ?>
    <?php endwhile; ?>
<?php endif; ?>
--------------------------------------------show every third post of category---------------------------------------------
<?php
$y = 0;
$offset = 0;
while ($y <= $n) {
    $first_query = new WP_Query ( array( 'post_type' => 'partners', 'posts_per_page' => 1, 'offset' => $offset ));
    $offset = $offset + 3;
    while($first_query->have_posts()){ $first_query->the_post(); ?>
        <div class="page-partner">
            <div class="page-partners-logo">
                <?php the_post_thumbnail(); ?>
            </div>
            <div class="page-partners-info">
                <div class="page-partnres-title"><?php the_title(); ?></div>
                <a href="#" class="page-partners-link"><?php echo get_field('link'); ?></a>
                <div class="page-partners-text">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php $y++; } ?>
---------------------------------------------query all post with similar custom field-------------------------------------
<?php
$pages = array(
    'post_type' => 'page',
    'meta_key' => 'tag',
    'meta_value' => get_field('tag'),
    'order' => 'asc'
);
$queryObject = new WP_Query($pages);
?>

<?php if ( $queryObject->have_posts() )
    while ($queryObject->have_posts() ) : $queryObject->the_post(); ?>
        <?php the_title(); ?><br />
        <!-- Loop or custom code goes here -->
    <?php endwhile; ?>
--------------------------------------------------------------------
<?php query_posts('cat=8&posts_per_page=3'); ?>
<?php if (have_posts()) : ?>
    <?php
    $a = 0;
    $maksactive[0]="active";
    ?>
    <?php while (have_posts()) : the_post(); ?>
        <div class="item <?php echo $maksactive[$a] ?>">
            <h3><?php echo get_cat_name(8); ?></h3>
            <div>
                <figure class="pull-left">
                    <a href="<?php the_permalink(); ?>" class="thumbnail"><?php the_post_thumbnail(); ?></a>
                </figure>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h4><?php the_title(); ?></h4></a>
                <?php the_excerpt(); ?>
            </div>
        </div>
        <?php $a++ ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_query(); ?>
-----------------------------------------------вывод категории------------------------------------------------------------------

<?php
$args = array('cat' =>'3', 'showposts' =>'5');
$posts = get_posts($args);
foreach( $posts as $post ){
    setup_postdata($post);
    ?>
    <li><a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></li>
<?php
}
wp_reset_postdata();
?>
-----------------------------------------------------вывод записей в 2 колонки---------------------------------------------------------------

<?php $col = 0; ?>
<?php if(have_posts()) : ?>
    <?php while(have_posts())  : the_post(); ?>
        присвоение уникального id для каждой записи-<div class="..." id="post-<?php the_ID(); ?>">
            <h2><a href="#" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <?php the_content() ?>
            <?php $col++;
            if ($col == 1) echo "<div style=\"width: 10px; float:left; \">&nbsp;</div>";
            if ($col == 2) {
                echo "<div style=\"clear: left; padding-top: 0px;  height: 0;\"></div>";
                $col=0;
            }
            ?>
        </div>
    <?php endwhile; ?>

<?php else : ?>
--------------------------------------------------------вывод определенной рубрики с количеством записей на странице-------------------------------------------------------------


<?php
global $post;
$args = array( 'posts_per_page' => 2, 'category' => 1 );
$myposts = get_posts( $args );
foreach( $myposts as $post ) :	setup_postdata($post); ?>
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php the_content() ?>
<?php endforeach; ?>
---------------------------------------------добавление количества просмотров в постах-------------------------------
--function.php--
<?php
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
?>
---single.php---
<?php wpb_set_post_views(get_the_ID()); ?>
--------------------------------------------------------------ppost type-----------------------------------------------
<?php
/**
 * tury Custom Type
 */

add_action( 'init', 'create_tury_post_type' );

function create_tury_post_type() {
    $args = array(
        'description' => 'Tury Post Type',
        'show_ui' => true,
        'menu_position' => 4,
        'exclude_from_search' => false,
        'labels' => array(
            'name'=> 'Туры',
            'singular_name' => 'tury',
            'add_new' => 'Добавить новый тур',
            'add_new_item' => 'Add New tury',
            'edit' => 'Edit tury',
            'edit_item' => 'Edit tury',
            'new-item' => 'New tury',
            'view' => 'View tury',
            'view_item' => 'View tury',
            'search_items' => 'Search tury',
            'not_found' => 'No tury Found',
            'not_found_in_trash' => 'No tury Found in Trash',
            'parent' => 'Parent tury'
        ),
        'public' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'rewrite'  => array('slug' => 'tury/%tury_kategoriat%','with_front' => false),
        'supports' => array('title', 'editor', 'thumbnail'),
    );
    register_post_type( 'tury' , $args );
}

add_action('init', 'register_tury_taxonomy');

function register_tury_taxonomy() {
    register_taxonomy('tury_kategoriat',
        'tury',
        array (
            'labels' => array (
                'name'              => _x( 'tury Categories', 'taxonomy general name' ),
                'singular_name'     => _x( 'tury Category', 'taxonomy singular name' ),
                'search_items'      => __( 'Search Category' ),
                'all_items'         => __( 'All Category' ),
                'parent_item'       => __( 'Parent Category' ),
                'parent_item_colon' => __( 'Parent Category:' ),
                'edit_item'         => __( 'Edit Category' ),
                'update_item'       => __( 'Update Category' ),
                'add_new_item'      => __( 'Add New Category' ),
                'new_item_name'     => __( 'New Category Name' ),
                'menu_name'         => __( 'Категории туров' ),
            ),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'  =>  array('slug' => 'tury' ),
            'has_archive'   => true,
            'show_in_menu'      => true
        )
    );
}
add_filter('post_link', 'tury_permalink', 1, 3);
add_filter('post_type_link', 'tury_permalink', 1, 3);

function tury_permalink($permalink, $post_id, $leavename) {
    if (strpos($permalink, '%tury_kategoriat%') === FALSE) return $permalink;
    $post = get_post($post_id);
    if (!$post) return $permalink;
    $terms = wp_get_object_terms($post->ID, 'tury_kategoriat');
    if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0]))
        $taxonomy_slug = $terms[0]->slug;
    else $taxonomy_slug = 'no-tury_kategoriat';
    return str_replace('%tury_kategoriat%', $taxonomy_slug, $permalink);
}


// Extra taxonomy meta fields
//add_action('admin_head', 'media_upload_scripts');
function media_upload_enqueue_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
}
add_action('admin_print_scripts', 'media_upload_enqueue_scripts');
function media_upload_enqueue_styles() {
    wp_enqueue_style('thickbox');
}
add_action('admin_print_styles', 'media_upload_enqueue_styles');
function tury_kategoriat_add_meta_field() {
    ?>
    <div class="form-field">
        <label for="term_meta[tury_kategoriat_logo]">Logo</label>
        <input type="text" class="custom_media_url" name="term_meta[tury_kategoriat_logo]" id="tury_kategoriat_logo" value="">
        <button id="tury_kategoriat_logo_upload" class="custom_media_button" name="tury_kategoriat_logo_upload">Upload logo</button>
    </div>
<?php
}
add_action('tury_kategoriat_add_form_fields', 'tury_kategoriat_add_meta_field', 10, 2);
function tury_kategoriat_edit_meta_field($term) {
    $t_id = $term->term_id;
    $term_meta = get_option("taxonomy_$t_id"); ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[tury_kategoriat_logo]">Logo</label></th>
        <td>
            <input type="text" name="term_meta[tury_kategoriat_logo]" class="custom_media_url" id="tury_kategoriat_logo" value="<?php echo esc_attr($term_meta['tury_kategoriat_logo']) ? esc_attr( $term_meta['tury_kategoriat_logo']) : ''; ?>">
            <button id="tury_kategoriat_logo_upload" class="custom_media_button" name="tury_kategoriat_logo_upload">Upload logo</button>
        </td>
    </tr>
<?php
}
add_action('tury_kategoriat_edit_form_fields', 'tury_kategoriat_edit_meta_field', 10, 2 );
function save_tury_kategoriat_custom_meta($term_id) {
    if (isset($_POST['term_meta'])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach($cat_keys as $key ) {
            if(isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        update_option( "taxonomy_$t_id", $term_meta );
    }
}
add_action('edited_tury_kategoriat', 'save_tury_kategoriat_custom_meta', 10, 2);
add_action('create_tury_kategoriat', 'save_tury_kategoriat_custom_meta', 10, 2);

function images_enqueue()
{
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    // moved the js to an external file, you may want to change the path
    wp_enqueue_script('hrw', get_bloginfo('template_directory').'/widgets/js/widget-upload.js', null, null, true);
}
add_action('admin_enqueue_scripts', 'images_enqueue');
?>
----img and description from category---
page.php:
<?php $myterm = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' )); ?>
<img src="<?php $img = get_option("taxonomy_$myterm->term_id"); echo $img[tury_kategoriat_logo] ?> ">

<div class="category-thumb"><p><?php echo $myterm->description ?></p></div>
----------------------------costum_field:------------------------------
<?php
/***********************************/
/* Meta box 'Plans and referenssit post type' */
/**********************************/

function add_referenssit_meta_box() {

    add_meta_box (
        'referenssit_meta_box',
        'Content titles',
        'show_referenssit_meta_box',
        'referenssit',
        'normal',
        'high'
    );

}

add_action('add_meta_boxes', 'add_referenssit_meta_box');

// Field Array
$prefix = 'custom_';
global $Clinic_skills_array,$Clinic_languages_array,$Clinic_position_array;
$Clinic_skills_array = array('Anestesia ja tehohoito','Ihosairaudet / Dermatologia','Tuki- ja liikuntaelinsairaudet / Ortopedia','Diagnostinen kuvantaminen','Fysiatriset hoidot','Hammashoidot','Sydänsairaudet / Kardiologia','Ortopedinen kirurgia','Pehmytosakirurgia','Yleiskirurgia','Kissalääketiede','Lisääntyminen','Hermosairaudet / Neurologia','Silmäsairaudet / Oftalmologia','Syöpäsairaudet / Onkologia','Sisätaudit','Yleislääketiede','Eksoottisten eläinten lääketiede','Hevosten akuuttihoito','Hevosten','ammashoito','Hevosten kirurgia','Hevosten ortopedinen kirurgia','Hevosten diagnostinen kuvantaminen','Hevosten ortopedia','Hevosten sisätaudit');
$Clinic_languages_array = array('Suomi','Svenska','English','Deutsch','Russki','Eesti','Polski','Español','Français','Italiano','Norsk','Nederlands');
$referenssit_meta_fields = array(
    array(
        'label'=> 'Position',
        'name'=> 'position',
        'id'    => $prefix.'position',
        'type'  => 'radio',
        'options' => $Clinic_position_array,
    ),
    array(
        'label'=> 'PEREHTYNEISYYS',
        'name'=> 'skills',
        'id'    => $prefix.'skills',
        'type'  => 'multicheckbox',
        'options' => $Clinic_skills_array,
    ),
    array(
        'label'=> 'Comment',
        'id'    => $prefix.'comment',
        'type'  => 'textarea'
    ),
    array(
        'label'=> 'Name and Surname',
        'id'    => $prefix.'name',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Position and company',
        'id'    => $prefix.'position',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Youtube video embeded code',
        'id'    => $prefix.'video',
        'type'  => 'text'
    ),
);

// The Callback
function show_referenssit_meta_box() {
    global $referenssit_meta_fields, $post;
// Use nonce for verification
    echo '<input type="hidden" name="custom_meta_box_nonce1" value="'.wp_create_nonce(basename(__FILE__)).'" />';

// Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($referenssit_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
        <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
        <td>';
        switch($field['type']) {
            // case items will go here
            case 'text':
                echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" style="width: 100%; height: 40px;" />
            <br /><span class="description">'.$field['desc'].'</span>';
                break;
            case 'textarea':
                echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" style="width: 100% !important; max-width: 100%; height: 80px;" />'.$meta.'</textarea>
            <br /><span class="description">'.$field['desc'].'</span>';
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'multicheckbox':
                $meta == "" ? $meta = array() : '';
                foreach ( $field['options'] as $value => $name ) {
                    // Append `[]` to the name to get multiple values
                    // Use in_array() to check whether the current option should be checked
                    echo '<input type="checkbox" name="', $field['id'], '[]" id="', $field['id'], '" value="', $value, '"', in_array( $value, $meta ) ? ' checked="checked"' : '', ' /> ', $name, '<br/>';
                }
                break;
            case 'radio':
                $meta == "" ? $meta = array('0,0') : '';
                foreach ( $field['options'] as $value => $name ) {
                    // Append `[]` to the name to get multiple values
                    // Use in_array() to check whether the current option should be checked
                    echo '<input type="radio" name="', $field['id'], '[]" id="', $field['id'], '" value="', $value, '"', in_array( $value, $meta ) ? ' checked="checked"' : '', ' /> ', $name, '<br/>';
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
            case 'upload':
                echo '<p class="image-upload"><img src="'.$meta.'" name="'.$field['id'].'" style="max-width: 300px; max-height: 200px;" class="custom_media_url" /><input type="text" class="custom_media_url hidden" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" style="width: 100%; height: 40px;" /><br />
        <input type="button" class="button button-primary custom_media_button" name="'. $field['id'] .'" value="Upload Image" style="margin-top:5px;" /></p>';
                break;
            case 'editor':
                wp_editor( htmlspecialchars_decode($meta), $field['id'] );
                break;
            case 'separate':
                echo '<hr />';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_referenssit_meta($post_id) {
    global $referenssit_meta_fields;

// verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce1'], basename(__FILE__)))
        return $post_id;
// check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
// check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // loop through fields and save the data
    foreach ($referenssit_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_referenssit_meta');
?>
-------page.php------
<?php echo get_post_meta(get_the_ID(), "custom_position", true); ?>
--------dinymic metafield with select--------
<?php
function jqueryUI_enqueue(){
    // moved the js to an external file, you may want to change the path
    wp_enqueue_script('jqueryUI', get_bloginfo('template_directory').'/php-modules/meta-box/js/jquery-ui.min.js', null, null, true);
}
add_action('admin_enqueue_scripts', 'jqueryUI_enqueue');

function product_id_shortcode_enqueue()
{
    // moved the js to an external file, you may want to change the path
    wp_enqueue_script('my_custom_script', get_bloginfo('template_directory').'/php-modules/meta-box/js/product-id-sc.js', null, null, true);
}
add_action('admin_enqueue_scripts', 'product_id_shortcode_enqueue');
/**
 * Product thumb slider
 */

add_action( 'add_meta_boxes', 'thumb_slider1_add_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'thumb_slider1_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function thumb_slider1_add_custom_box()
{
    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
    $template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
    // check for a template type
    if ($template_file == 'template-commercial.php') {
        add_meta_box(
            'thumb_slider1_fields',
            'Thumbnail slider',
            'thumb_slider1_fields_box',
            'page');
    }
}

/* Prints the box content */
function thumb_slider1_fields_box() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'sliderMeta_noncename' );
    ?>
    <div id="meta_inner2" class="slides-wrap">
    <?php

    //get the saved meta as an array
    $slider = get_post_meta($post->ID,'thumb_slider1',true);
    $c = 0;
    if(is_array($slider)){
        foreach( $slider as $slide ) {
            if ( isset( $slide['img'] ) || isset($slide['selectIN'] ) || isset($slide['select'] ) || isset($slide['number'])) {
                echo '<div class="dragNdrop" style="position: relative; margin-bottom: 40px;">
            Image:<br /><input type="text" class="custom_media_url" name="thumb_slider1['.$c.'][img]" value="'.$slide['img'].'" style="display:none;" />
            <img src="'.$slide['img'].'" class="custom_media_url" name="thumb_slider1['.$c.'][img]" style="width: auto; height: 300px;"  /><br />
            Image size:<input type="text" class="custom_select_value" name="thumb_slider1['.$c.'][selectIN]" style="display:none;" value="'.$slide['selectIN'].'"/>
            <select class="custom_select" name="thumb_slider1['.$c.'][select]">
            <option '; if ($slide['selectIN'] == "img-horiz-big") { echo 'selected="selected"'; }; echo ' value="img-horiz-big">Horizontal Big</option>
            <option '; if ($slide['selectIN'] == "img-horiz-small") { echo 'selected="selected"'; };  echo ' value="img-horiz-small">Horizontal Small</option>
            <option '; if ($slide['selectIN'] == "img-vert-big") { echo 'selected="selected"'; };  echo ' value="img-vert-big">Vertical Big</option>
            </select><br />
            <input type="button" class="button remove button-primary" value="Remove image" style="margin-left:220px; position: absolute; bottom: 3px;" /></div>';
                $c += 1;
            }
        }
    }

    ?>
    <span id="here"></span>
    <button class="add button button-primary"><?php _e('Add image'); ?></button>
    <script>
        var $ =jQuery.noConflict();
        $(document).ready(function() {
            var count = <?php echo $c; ?>;
            function SelectChange() {
                $('.custom_select').change(function() {
                    var selected_val = $(this).find(':selected').val();
                    $(this).parent().find('.custom_select_value').val(selected_val);
                });
            }
            SelectChange();
            $(".add").click(function() {
                count += 1;

                $('#here').append('' +
                '<div class="dragNdrop" style="position: relative; margin-bottom: 10px;">' +
                'Image:<br /><input type="text" class="custom_media_url" name="thumb_slider1['+count+'][img]" style="display:none;" /><img class="custom_media_url" name="thumb_slider1['+count+'][img]" style="width: auto; height: 300px;"  /><input type="button" class="button button-primary custom_media_button" value="Upload" style="margin-top:5px;" /><br />' +
                '<input type="text" class="custom_media_url" name="thumb_slider1['+count+'][number]" value="'+(count-1)+'" style="display: none;" /><br />' +
                '<input type="text" class="custom_select_value" name="thumb_slider1['+count+'][selectIN]" style="display:none;" value=""/>'+
                '<select class="custom_select" name="thumb_slider1['+count+'][select]"><option value="img-horiz-big">Horizontal Big</option><option value="img-horiz-small">Horizontal Small</option><option value="img-vert-big">Vertical Big</option></select>' +
                '<input type="button" class="button remove button-primary" value="Remove image" style="margin-left:20px; position: absolute; bottom: 3px;" /><div/>' );
                $(".custom_media_button").click(function() {
                    console.log('clicked');
                    var link = $(this).parent().find('.custom_media_url');
                    window.send_to_editor = function(html) {
                        imgurl = $('img',html).attr('src');
                        hrefurl = $(html).attr('href');
                        if(link.get(0).tagName == 'IMG'){
                            link.attr('src', imgurl);
                        } else {
                            link.val(imgurl ? imgurl : hrefurl);
                        }
                        if(link.get(1).tagName == 'IMG'){
                            link.attr('src', imgurl);
                        } else {
                            link.val(imgurl ? imgurl : hrefurl);
                        }
                        tb_remove();
                    };

                    tb_show('', 'media-upload.php?type=image&TB_iframe=true');

                    return false;
                });
                SelectChange();
                return false;
            });
            $(".remove").click(function() {
                $(this).parent().remove();
            });
        });
    </script>
    </div><?php

}

/* When the post is saved, saves our custom data */
function thumb_slider1_save_postdata( $post_id ) {
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['sliderMeta_noncename'] ) )
        return;

    if ( !wp_verify_nonce( $_POST['sliderMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    // OK, we're authenticated: we need to find and save the data

    $slider = $_POST['thumb_slider1'];

    update_post_meta($post_id,'thumb_slider1',$slider);
}
?>
----printf simple dynamic---
<?php
add_action( 'add_meta_boxes', 'palvelut_add_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'palvelut_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function palvelut_add_custom_box() {

    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
    $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
    // check for a template type
    if ($template_file == 'template-palvelut.php') {
        add_meta_box(
            'palvelut_fields',
            'Services',
            'palvelut_fields_box',
            'page');
    }
}

/* Prints the box content */
function palvelut_fields_box() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'palvelutMeta_noncename' );
    ?>
    <div id="meta_inner">
    <?php

    //get the saved meta as an array
    $services = get_post_meta($post->ID,'services',true);

//    if (!$services) {
//        global $wpdb;
//        $unserialized = $wpdb->get_var("SELECT meta_value FROM r4j47_postmeta WHERE post_id = '$post->ID' AND meta_key = 'services'");
//        $serv = unserialize($unserialized);
//        var_dump($unserialized);
//        var_dump(unserialize($unserialized));
//    }
    $c = 0;
    if(is_array($services)){
        foreach( $services as $news ) {
            if ( isset( $news['img'] ) || isset( $news['title'] ) || isset( $news['text'] ) || isset( $news['link'] ) ) {
                printf( '<div style="position: relative">
            Image:<br /><input type="text" class="custom_media_url" name="services[%1$s][img]" value="%2$s" style="display:none;" />
            <img src="%2$s" class="custom_media_url" name="services[%1$s][img]" style="width: 100%; height: auto;"  /><input type="button" class="button button-primary custom_media_button" value="Upload" style="margin-top:5px;" /><br />
            Title:<br /><input type="text" name="services[%1$s][title]" value="%3$s" style="width: 400px; height: 40px;"/><br />
            Text:<br /> <textarea name="services[%1$s][text]" style="width: 400px; height: 100px;">%4$s</textarea><br />
            Link:<br /><input type="text" name="services[%1$s][link]" value="%5$s" style="width: 400px; height: 40px;"/><br />
            <input type="button" class="button remove button-primary" value="Remove service" style="margin-left:430px; position: absolute; bottom: 3px;" /></div>', $c, $news['img'], $news['title'], $news['text'], $news['link'], __( 'Remove slide' ) );
                $c++;
            }
        }
    }

    ?>
    <span id="here"></span>
    <button class="add button button-primary"><?php _e('Add service'); ?></button>
    <script>
        var $ =jQuery.noConflict();
        $(document).ready(function() {
            var count = <?php echo $c; ?>;
            $(".add").click(function() {
                count++;

                $('#here').append('' +
                '<div style="position: relative; margin-bottom: 10px;">' +
                'Image:<br /><input type="text" class="custom_media_url" name="services['+count+'][img]" style="display:none;" /><input type="button" class="button button-primary custom_media_button" value="Upload" style="margin-top:5px;" /><br />' +
                'Title:<br /> <input type="text" name="services['+count+'][title]" value="" style="width: 400px; height: 40px;"/><br /> ' +
                'Text:<br /> <textarea name="services['+count+'][text]" value="" style="width: 400px; height: 100px;"></textarea><br />' +
                'Link:<br /> <input type="text" name="services['+count+'][link]" value="" style="width: 400px; height: 40px;"/><br />' +
                '<input type="button" class="button remove button-primary" value="Remove service" style="margin-left:430px; position: absolute; bottom: 3px;" /><div/>' );
                $(".custom_media_button").click(function() {
                    var link = $(this).parent().find('.custom_media_url');
                    window.send_to_editor = function(html) {
                        imgurl = $('img',html).attr('src');
                        hrefurl = $(html).attr('href');
                        if(link.get(0).tagName == 'IMG'){
                            link.attr('src', imgurl);
                        } else {
                            link.val(imgurl ? imgurl : hrefurl);
                        }
                        tb_remove();
                    };
                    tb_show('', 'media-upload.php?type=image&TB_iframe=true');
                    return false;
                });
                return false;
            });
            $(".remove").click(function() {
                $(this).parent().remove();
            });
        });
    </script>
    </div><?php

}

/* When the post is saved, saves our custom data */
function palvelut_save_postdata( $post_id ) {
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['palvelutMeta_noncename'] ) )
        return;

    if ( !wp_verify_nonce( $_POST['palvelutMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    // OK, we're authenticated: we need to find and save the data

    $services = $_POST['services'];

    update_post_meta($post_id,'services',$services);
}
?>
---dynamic output in page.php---
<?php $slideArray = get_post_meta(get_the_ID(), "service_price", true);
if ($slideArray) {
    array_unshift($slideArray, 'removed');
    unset($slideArray[0]);
    for ($i = 1; $i <= count($slideArray); $i++) { ?>
        <p><?php echo $slideArray[$i]['label']; ?> <b><?php echo $slideArray[$i]['price']; ?></b></p>
    <?php }
}
?>
---------------------dynamic in dynamic metafield---------------
<?php
add_action( 'add_meta_boxes', 'add_clinics_price_post_type_meta_box' );
/* Do something with the data entered */
add_action( 'save_post', 'clinics_price_save_postdata' );

function add_clinics_price_post_type_meta_box() {
    add_meta_box(
        'clinics_post_price_type',
        'Clinic price',
        'clinics_price_fields_box',
        'clinics',
        'normal',
        'high'
    );
}

/* Prints the box content */
function clinics_price_fields_box()
{
    global $post;
    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'priceMeta_noncename');
    ?>
    <div id="meta_inner4" class="slides-wrap">
    <?php

    //get the saved meta as an array
    $service = get_post_meta($post->ID, 'clinics_service', true);
    $price = get_post_meta($post->ID, 'clinics_price', true);
    if ($price) {
        array_unshift($price, 'removed');
        unset($price[0]);
    }
    $count = get_post_meta($post->ID, 'clinics_count', true);
    if ($count) {
        array_unshift($count, "0");
    }
//    unset($count[0]);
    $s = 0;
    $p = 0;
    if (is_array($service)) {
        foreach ($service as $slide) {
            if (isset($slide['service'])) {
                echo '<div class="dragNdrop" style="position: relative; margin-bottom: 40px;" data-num="'.$s.'">
            <label style="display: inline-block; float: left; margin: 0 10px;">Palvelu esim Terveydenhoito: </label><br />
            <input type="text" name="clinics_service[' . $s . '][service]" value="' . $slide['service'] . '" style="display: inline-block; float: left; margin: 0 10px;" /><br />
            <div class="innerblock" style="position: relative; display: inline-block;width: 100%;margin: 20px 15px 40px;">';
                $p= 0;
                for($i=$count[$s]['count'];$i<($count[$s]['count']+$count[$s+1]['count']);$i++) {
                    echo '<div class="newRow" data-row="' . $p . '">Palvelu,esim rokotus: <input type="text" name="clinics_price[' . $s . '_' . $p . '][name]" value="' . $price[$s . '_' . $p]['name'] . '" style="display: inline-block; margin: 10px;" />   ';
                    echo '   Hinta: <input type="text" name="clinics_price[' . $s . '_' . $p . '][price]" value="' . $price[$s . '_' . $p]['price'] . '" style="display: inline-block; margin: 10px;" />   ';
                    echo '   Lisämääre esim. Lääkkeet: <input type="text" name="clinics_price[' . $s . '_' . $p . '][options]" value="' . $price[$s . '_' . $p]['options'] . '" style="display: inline-block; margin: 10px;" /><br />
                    <div class="button-primary removeRow" style="display: inline-block; margin: 10px;">Remove row</div>
                    </div>';
                    $p++;
                }
                echo '<div class="addrow button-primary" style="position: absolute; bottom: -40px; left: 0;">add row</div>
<input type="text" class="hidden" name="clinics_count[' . $s . '][count]" value="'.$count[$s+1]['count'].'" style="display: none;" />
            </div>
            <input type="button" class="button remove4 button-primary" value="Remove services" style="margin-left:270px; position: absolute; bottom: 3px;" /></div>';
                $s++;
            }
        }
    }
    ?>
    <span id="here4"></span>
    <div class="add4 button button-primary"><?php _e('Add services'); ?></div>
    <script>
        var $ = jQuery.noConflict();
        $(document).ready(function () {
            var countService = <?php echo $s; ?>;
            $('.add4').click(function(){
                countService += 1;
                var num = $(this).parent().find('.dragNdrop').size();
                $('#here4').append('' +
                '<div class="dragNdrop" style="position: relative; margin-bottom: 30px;" data-num="'+ num +'">' +
                '<label style="display: inline-block; float: left; margin: 0 10px;">Palvelu esim Terveydenhoito: </label><br />' +
                '<input type="text" name="clinics_service[' + countService + '][service]" value="" style="display: inline-block; float: left; margin: 0 10px;" /><br />' +
                '<div class="innerblock" style="position: relative; display: inline-block;width: 100%;margin: 20px 15px 40px";>' +
                '<div class="addrow button-primary" style="position: absolute; bottom: -40px; left: 0;">add row</div>' +
                '<input type="text" class="hidden" name="clinics_count[' + countService + '][count]" value="0" style="display: none;" />' +
                '</div>' +
                '<input type="button" class="button remove4 button-primary" value="Remove services" style="margin-left:270px; position: absolute; bottom: 3px;" /><div/>');
                return false;
            });
            $('#meta_inner4').on("click",".addrow",function(){
                var numServ = $(this).parent().parent().attr("data-num");
                var num = $(this).parent().find('.newRow').size();
                $(this).parent().find('.hidden').val(num+1);
                $(this).before(''+
                '<div class="newRow" data-row="' + num + '">Palvelu,esim rokotus: <input type="text" name="clinics_price['+ numServ + '_' + num +'][name]" value="" style="display: inline-block; margin: 10px;" />   ' +
                '   Hinta: <input type="text" name="clinics_price['+ numServ + '_' + num +'][price]" value="" style="display: inline-block; margin: 10px;" />   ' +
                '   Lisämääre esim. Lääkkeet: <input type="text" name="clinics_price['+ numServ + '_' + num +'][options]" value="" style="display: inline-block; margin: 10px;" /><br />'+
                '<div class="button-primary removeRow" style="display: inline-block; margin: 10px;">Remove row</div></div>');
                return false;
            });
            $('#meta_inner4').on("click",".removeRow",function(){
                var thisRow = $(this).parent().attr("data-row");
                $(this).parent().parent().find('.newRow').each(function(){
                    var row = $(this).attr("data-row");
                    if (thisRow<row) {
                        $(this).find('input:not(.hidden)').each(function(){
                            var name = $(this).attr("name");
                            var nameArray = name.split("[");
                            var serv = nameArray[1].split("_");
                            serv[1] = serv[1].slice(0,-1)-1;
                            var newName = nameArray[0] + '[' + serv[0] + '_' + serv[1] + '][' + nameArray[2];
                            $(this).attr("name",newName);
                        });
                        $(this).attr("data-row",(row-1));
                    }
                });
                var count = $(this).parent().parent().find('.newRow').size() - 1;
                $(this).parent().parent().find('.hidden').val(count);
                $(this).parent().remove();
            });
            $('#meta_inner4').on("click",".remove4",function(){
                var num = $(this).parent().attr("data-num");
                $('.dragNdrop').each(function(){
                    var count = $(this).attr("data-num");
                    if (count>num) {
                        $(this).find('.innerblock input:not(.hidden)').each(function(){
                            var name = $(this).attr("name");
                            var nameArray = name.split("[");
                            var serv = nameArray[1].split("_");
                            serv[0] = serv[0]-1;
                            var newName = nameArray[0] + '[' + serv[0] + '_' + serv[1] + '[' + nameArray[2];
                            $(this).attr("name",newName);
                        });
                        var countNew = count - 1;
                        $(this).attr("data-num",countNew);
                    }
                });
                $(this).parent().remove();
            });
        });
    </script>
    </div><?php
}
/* When the post is saved, saves our custom data */
function clinics_price_save_postdata( $post_id ) {
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['priceMeta_noncename'] ) )
        return;
    if ( !wp_verify_nonce( $_POST['priceMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;
    // OK, we're authenticated: we need to find and save the data
    $service = $_POST['clinics_service'];
    $price = $_POST['clinics_price'];
    $count = $_POST['clinics_count'];
    update_post_meta($post_id,'clinics_service',$service);
    update_post_meta($post_id,'clinics_price',$price);
    update_post_meta($post_id,'clinics_count',$count);
}
?>
--page.php:---
<?php
$service = get_post_meta($post->ID, 'clinics_service', true);
$price = get_post_meta($post->ID, 'clinics_price', true);
if ($price) {
    array_unshift($price, 'removed');
    unset($price[0]);
}
$count = get_post_meta($post->ID, 'clinics_count', true);
if ($count) {
    array_unshift($count, "0");
}
$s = 0;
$p = 0;
?>
<div class="price-list">
    <?php
    if (is_array($service)) {
        foreach ($service as $slide) {
            if (isset($slide['service'])) {
                echo '<div class="service">
                                            <h4>' . $slide['service'] . '</h4>';
                $p= 0;
                for($i=$count[$s]['count'];$i<($count[$s]['count']+$count[$s+1]['count']);$i++) {
                    echo '<div class="prices row"><div class="col-md-9 name"><p>' . $price[$s . '_' . $p]['name'] . '</p></div>';
                    echo '<div class="col-md-3 price"><p>' . $price[$s . '_' . $p]['price'] . ' €</p>';
                    if ($price[$s . '_' . $p]['options']) {echo '<span class="options">' . $price[$s . '_' . $p]['options'] . '</span>'; }
                    echo '</div>
                                            </div>';
                    $p++;
                }
                echo '</div>';
                $s++;
            }
        }
    }
    ?>
</div>
--------------------widgets----------------------------
<?php
function slider_enqueue()
{
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    // moved the js to an external file, you may want to change the path
    wp_enqueue_script('hrw', get_bloginfo('template_directory').'/widgets/js/widget-upload.js', null, null, true);
}
add_action('admin_enqueue_scripts', 'slider_enqueue');
class Info_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'info',
            'sensitiveliliia: Information Widget',
            array( 'description' => 'Information Widget' )
        );
    }

    public function widget( $args, $instance )
    {

        extract( $args );

        $phone = apply_filters( 'phone', $instance['phone'] );
        $phone1 = apply_filters( 'phone1', $instance['phone1'] );
        $address = apply_filters( 'address', $instance['address'] );
        $fb_link = apply_filters( 'fb_link', $instance['fb_link'] );
        $vk_link = apply_filters( 'vk_link', $instance['vk_link'] );
        $image = apply_filters( 'image', $instance['image'] );
        $copyright = apply_filters( 'copyright', $instance['copyright'] );

        echo $before_widget;
        echo $phone, $phone1, $address, $vk_link, $fb_link, $email, $copyright;
        echo $after_widget;
    }

    public function update( $new_instance, $old_instance )
    {
        $instance = array();

        $instance['address'] = $new_instance['address'];
        $instance['phone'] = strip_tags( $new_instance['phone'] );
        $instance['phone1'] = strip_tags( $new_instance['phone1'] );
        $instance['fb_link'] = strip_tags( $new_instance['fb_link'] );
        $instance['vk_link'] = strip_tags( $new_instance['vk_link'] );
        $instance['image'] = $new_instance['image'];
        $instance['copyright'] = strip_tags( $new_instance['copyright'] );

        do_action( 'wp_editor_widget_update', $new_instance, $instance );
        return apply_filters( 'wp_editor_widget_update_instance', $instance, $new_instance );
    }

    public function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, array( 'address' => '' ,'phone' => '','phone1' => '','vk_link' => '','fb_link' => '','image' => '', 'copyright' => '' ) );

        $address = $instance['address'];
        $phone = strip_tags($instance['phone']);
        $phone1 = strip_tags($instance['phone1']);
        $fb_link = strip_tags($instance['fb_link']);
        $vk_link = strip_tags($instance['vk_link']);
        $image = strip_tags($instance['image']);
        $copyright = $instance['copyright'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address:' ); ?></label>
            <textarea class="widefat" type="text" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>"><?php echo $address; ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'phone:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo esc_attr($phone); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'phone1' ); ?>"><?php _e( 'second phone:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'phone1' ); ?>" name="<?php echo $this->get_field_name( 'phone1' ); ?>" type="text" value="<?php echo esc_attr($phone1); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'fb_link' ); ?>"><?php _e( 'Facebook link:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'fb_link' ); ?>" name="<?php echo $this->get_field_name( 'fb_link' ); ?>" type="text" value="<?php echo esc_attr($fb_link); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'vk_link' ); ?>"><?php _e( 'Vkontakte link:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'vk_link' ); ?>" name="<?php echo $this->get_field_name( 'vk_link' ); ?>" type="text" value="<?php echo esc_attr($vk_link); ?>"/>
        </p>
        <div class="image-upload" style="padding: 0 10px 5px; border: 1px solid #e2e2e2;">
            <label for="<?php echo $this->get_field_id( 'image' ); ?>" style="display: block;"><?php _e( 'Sidebar Image:' ); ?></label>
            <img src="<?php echo $image; ?>" style="max-width: 100%; max-height: 100px; display: block; margin: 10px auto;" />
            <input class="widefat custom_media_url" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" value="<?php echo $image; ?>"/>
            <input type="button" class="button button-primary custom_media_button select-img" name="<?php echo $this->get_field_name('image'); ?>" value="Upload Image" style="margin-top:5px;" />
        </div>
        <input type="hidden" id="<?php echo $this->get_field_id('copyright'); ?>" name="<?php echo $this->get_field_name( 'copyright' ); ?>" value="<?php echo esc_attr($copyright); ?>">
        <p>
            <label for="<?php echo $this->get_field_id( 'copyright' ); ?>"><?php _e( 'copyright:' ); ?></label>
            <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'copyright' ); ?>');" class="button"><?php _e( 'Edit content', 'wp-editor-widget' ) ?></a>
        </p>

    <?php
    }
}
?>
--------------------------------------------post type foreach in foreach-------------------------------------------------
<?php
$post_type = 'member';
// Get all the taxonomies for this post type
$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type ) );
foreach( $taxonomies as $taxonomy ) :
// Gets every "category" (term) in this taxonomy to get the respective posts
$terms = get_terms( $taxonomy );
foreach( $terms as $term ) :
?>
<div class="line-block-staff">
<h3><?php echo $term->name ?></h3>
<?php
$posts = new WP_Query( "taxonomy=$taxonomy&term=$term->slug&posts_per_page=-1" );
if( $posts->have_posts() ): while( $posts->have_posts() ) : $posts->the_post();
    $name = get_post_meta(get_the_ID(), "name", true);
    $job_title = get_post_meta(get_the_ID(), "job_title", true);
    $phone_number = get_post_meta(get_the_ID(), "phone_number", true);
    ?>
    <div class="staff">
        <?php if(!empty($name)): ?>
            <p class="name"><?php echo $name; ?></p>
        <?php endif; ?>
        <?php if(!empty($job_title)): ?>
            <p class="position"><?php echo $job_title; ?></p>
        <?php endif; ?>
        <?php if(!empty($phone_number)): ?>
            Puhelin: <?php echo $phone_number; ?>
        <?php endif; ?>
    </div>
<?php

endwhile; endif;
echo '</div>';
endforeach;
endforeach;
?>
---------------------------------------------------------post from taxonomy exclude some categories-----------------------------------------
<?php query_posts( array(
    'post_type'	=>'ajankohtaista',
    'posts_per_page' => 3,
    'order' => 'DESC',
    'tax_query'	=> array(
        array(
            'taxonomy'	=> 'ajankohtaista-kategoriat',
            'field'		=> 'slug',
            'terms'		=> array( 'koulutukset','tapahtumat' ),
            'operator'	=> 'NOT IN',
        ),
    )
) ); ?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <div class="slider-vertical-item">
            <h5 class="h5"><?php the_terms( $post->ID, 'ajankohtaista-kategoriat', ' ', ', ', ' '); ?></h5>
            <a href="<?php the_permalink(); ?>"><h4 class="h4"><?php the_title(); ?></h4></a>
            <div class="blog-date">
                <?php the_time('j.m.Y, '); ?>sisään <span class="green"><?php the_terms( $post->ID, 'ajankohtaista-kategoriat', ' ', ', ', ' '); ?></span> kirjoittajalta <a href="<?php bloginfo('url'); ?>/author/<?php echo get_the_author_meta('user_login'); ?>/"><span class="green"><?php echo get_the_author_meta('display_name'); ?></span></a>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
-----------------------------------------------------------------member staff-----------------------------------------------------------------
<?php
function create_post_type()
{
    $post_types = array(
        'member' => 'Member',
    );

    foreach ( $post_types as $type => $name )
        register_post_type( $type,
            array(
                'labels' => array(
                    'name' => __( $name ),
                    'singular_name' => __( $name )
                ),
                'public' => true,
                'has_archive' => false,
                'hierarchical' => false,
                'rewrite' => array('slug' => 'member'),
                'supports' => array('title', 'editor', 'thumbnail')
            )
        );
}
add_action( 'init', 'create_post_type' );
function member_postype_init() {
// create a new taxonomy
// Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => 'Member Groups',
        'singular_name' => 'Member Groups',
        'search_items' => 'Search Member Groups',
        'popular_items' => 'Popular Member Groups',
        'all_items' => 'All Member Groups',
        'parent_item' => 'Parent Member Groups',
        'parent_item_colon' => 'Parent Member Groups:',
        'edit_item' => 'Edit Member Groups',
        'update_item' => 'Update Member Groups',
        'add_new_item' => 'Add New Member Groups',
        'new_item_name' => 'New Member Groups'
    );


    $args = array(
        'hierarchical' =>true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'rewrite' => array('slug' => 'groups'),
        'public'=>true
    );



    register_taxonomy( 'member_category', array( 'member',$args));


}
add_action( 'init', 'member_postype_init' );

add_action('init', 'register_member_taxonomy');
function register_member_taxonomy() {
    register_taxonomy('member_category',
        'member',
        array (
            'labels' => array (
                'name' => 'Member Groups',
                'singular_name' => 'Member Groups',
                'search_items' => 'Search Member Groups',
                'popular_items' => 'Popular Member Groups',
                'all_items' => 'All Member Groups',
                'parent_item' => 'Parent Member Groups',
                'parent_item_colon' => 'Parent Member Groups:',
                'edit_item' => 'Edit Member Groups',
                'update_item' => 'Update Member Groups',
                'add_new_item' => 'Add New Member Groups',
                'new_item_name' => 'New Member Groups',
            ),
            'hierarchical' =>true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'rewrite' => array('slug' => 'groups'),
            'public'=>true
        )
    );
}
?>
-------------------------------------------if need create tag.php and search.php for post type--------------------
<form role="search" method="get" class="search-form" action="<?php bloginfo('home'); ?>">
    <label>
        <input type="search" class="search-field" placeholder="Haku…" value="" name="s" title="Search for:">
        <input name="post_type" type="hidden" value="normal-search" />
    </label>
    <input type="submit" class="search-submit" value="Search">
</form>
add in functon.php:
<?php
/*tag*/
function filter_tag($query) {
    if ($query->is_tag) {
        $query->set('post_type', array('post', 'blog'));
    };
    return $query;
};
add_filter('pre_get_posts', 'filter_tag');
/*search*/
function filter_search($query) {
    if ($query->is_search) {
        $query->set('post_type', array('post', 'blog'));
    };
    return $query;
};
add_filter('pre_get_posts', 'filter_search');
//
function mySearchFilter($query) {
    $type = $_GET['post_type'];
    if ($query->is_search) {
        if ($type == 'blog') {
            $query->set('post_type', array('blogi'));
        }
    };
    return $query;
};

add_filter('pre_get_posts','mySearchFilter');
?>
------------------------------------------------------------------add meta field to post in some category------------------------------------
function.php:
<?php
/* meta field */
function wpse_85236_add_photo_field(){

    global $post;
    $photoquery = new WP_Query('posts_per_page=-1');
    while ( $photoquery->have_posts() ) : $photoquery->the_post();
        if ( in_category( 'vote' )) {
            add_post_meta($post->ID, 'votes_count', '0', true);
        }
    endwhile;
}
add_action( 'init', 'wpse_85236_add_photo_field' );
/* end meta field */
?>
-----------------------------------------------------------------------add meta field post type--------------------------------------
function.php:
if u need upload image add js with upload
<?php

/***********************************/
/* Meta box 'Plans and pricing page' */
/**********************************/

function add_pricing_meta_box() {

    add_meta_box(
        'pricing_meta_box',
        'Content titles',
        'show_pricing_meta_box',
        'pricing',
        'normal',
        'high'
    );

}

add_action('add_meta_boxes', 'add_pricing_meta_box');
?>
-----------------------------------------------------------------------add meta field in template--------------------------------------
<?php
function add_coaches_meta_box() {

    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
    $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
// check for a template type
    if ($template_file == 'template-coaches.php') {
        add_meta_box(
            'coaches_meta_box',
            'Content titles',
            'show_coaches_meta_box',
            'page',
            'normal',
            'high'
        );
    }

}

add_action('add_meta_boxes', 'add_coaches_meta_box');
?>
----------------------------------------------------------------шапка шаблона страници----------------------------------------------------------


<?php
/*
Template Name: Gallery
*/
?>


шапка шаблона поста
/* установить плагин "Single Post Template"*/

<?php
/*
Single Post Template: svadebnie
Description: This part is optional, but helpful for describing the Post Template
*/
?>
-------------------------------------------------------------------------------------------------------------------------
что бы все картинки открывались как медиафайл(в белом окне на весь размер), то нужно создать image.php с таким кодом:
<?php
while ( have_posts() ) {
    the_post();
    $metadata = wp_get_attachment_metadata();
    wp_redirect(home_url('/').'wp-content/uploads/'.$metadata['file']);
}
?>
------------------------------------------------sidebar-------------------------------------------------------------------------
Как вывести динамический сайдбар в Wordpress?
<?php if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'name' => 'Left Sidebar',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
}
А потом уже в теме его вызвать:

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Left Sidebar') ) : ?>
    /* СЮДА все то, что должно выводиться если сайдбар не существует */
<?php endif; ?>
-----------------------------------------------------sidebar2--------------------------------------------------------------
<?php
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function ukr_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'ukr' ),
        'id'            => 'sidebar-1',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Sidebar form 2'),
        'id'            => 'sidebar-2',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Sidebar form 3'),
        'id'            => 'sidebar-3',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
    ) );

    /* Phone number in header */
    register_sidebar(array(
        'name'=>'Counter_Lvov',
        'before_widget' => '',
        'after_widget'  => '',
    ));


}
add_action( 'widgets_init', 'ukr_widgets_init' );
?>


call in the theme

<?php  dynamic_sidebar( 'Phone_in_header' ); ?>
----------------------------------------------------get widgets fields---------------------------------------------------
<?php
//a:2:{i:2;a:3:{s:14:"adressFacebook";s:1:"#";s:13:"adressYoutube";s:1:"#";s:14:"adressLinkedin";s:1:"#";}s:12:"_multiwidget";i:1;}
$text_widgets = get_option( 'widget_socy' );
$fb = $text_widgets[2]['adressFacebook'];
$yt = $text_widgets[2]['adressYoutube'];
$ln = $text_widgets[2]['adressLinkedin'];
?>
<?php
$user_count = $wpdb->get_var("SELECT option_value FROM wp_options WHERE option_id = '146'");
$unserialized = unserialize($user_count);

$adress1 = $unserialized[2]['adress'];
$phone1 = $unserialized[2]['phone'];
$email1 = $unserialized[2]['email'];

?>
--------------------------------------------------children----------------------------------------------------------------
<?php
if ( $post->post_parent )
    $children = wp_list_pages("title_li=&child_of=" . $post->post_parent . "&echo=0");
else
    $children = wp_list_pages("title_li=&child_of=" . $post->ID . "&echo=0");
if ( $children )
{
    ?>
    <ul class="hidden-xs hidden-sm">
        <?php echo $children; ?>
    </ul>
<?php } ?>
--------------
<?php
$args = array(
    'depth'        => 0
,'show_date'    => ''
,'date_format'  => get_option('date_format')
,'child_of'     => 0
,'exclude'      => ''
,'exclude_tree'   => ''
,'include'      => ''
,'title_li'     => __('Pages')
,'echo'         => 1
,'authors'      => ''
,'sort_column'  => 'menu_order, post_title'
,'sort_order'  => 'ASC'
,'link_before'  => ''
,'link_after'   => ''
,'meta_key'   => ''
,'meta_value'   => ''
,'number'   => ''
,'offset'   => ''
,'walker'   => ''
);

wp_list_pages( $args );
?>
// Return (Array)

An array containing all the Pages matching the request, or false on failure. The returned array is an array of "page" objects. Each page object is a map containing 24 keys:
ID: page/post ID (int)
post_author: author ID (string)
post_date: time-date string (YYYY-MM-DD HH:MM:SS), e.g., "2012-10-15 01:02:59"
post_date_gmt: time-date string
post_content: HTML (string)
post_title
post_excerpt: HTML (string)
post_status: (publish|inherit|pending|private|future|draft|trash)
comment_status: closed/open
ping_status: (closed|open)
post_password
post_name: slug for page/post
to_ping
pinged
post_modified: time-date string
post_modified_gmt: time-date string
post_content_filtered
post_parent: parent ID (int)
guid: URL
menu_order: (int)
post_type: (page|post|attachment)
post_mime_type
comment_count: number of comments (string)
filter
//
--------------------------------children2----------------------------------
<?php
$postID = $post->ID;
$ancestors = get_ancestors( $postID, 'page' );
$args = array(
    'post_parent' => 0,
    'post_type' => 'any',
    'numberposts' => -1,
    'post_status' => 'any',
    'post_parent' => $postID,
);

$childrens = get_children($args, $output);
if ( $childrens )
{ ?>
    <ul class="list-unstyled service-list">
        <?php foreach ( $childrens as $children )
        {
            echo '<li><a class="orange-bg" href="'. get_page_link($ancestors[0]) . $children->post_name . '/">';
            echo $children->post_title;
            echo '</a></li>';
        } ?>
    </ul>
<?php } ?>
------------------------
<?php
$postID = $post->ID;
$ancestors = get_ancestors( $postID, 'page' );
if ($ancestors[0] == '') {
    $args = array(
        'post_type' => 'any',
        'numberposts' => -1,
        'order' => 'ASC',
        'post_status' => 'any',
        'post_parent' => $postID,
    );
} else {
    $args = array(
        'post_type' => 'page',
        'numberposts' => -1,
        'order' => 'ASC',
        'post_status' => 'any',
        'post_parent' => $ancestors[0]
    );
}

$childrens = get_children($args, $output);
if ( $childrens )
{ ?>

    <ul class="list-unstyled service-list">
        <?php foreach ( $childrens as $children )
        {
            echo '<li><a class="orange-bg" href="'. get_page_link($ancestors[0]) . $children->post_name . '/">';
            echo $children->post_title;
            echo '</a></li>';
        } ?>
    </ul>
<?php } ?>
--------------------------------------category.php------------------------------------------------------
<div class="grid_12">
    <h3 class="head2"><?php printf(__ (' %s '), single_cat_title("", false))?></h3>
</div>
<div class="clear"></div>
<div class="grid_8">
    <div class="block2">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="grid_6">
                    <?php the_post_thumbnail( array( 270,201 ), $default_attr = array(
                        'class' => "img_inner fleft",
                        'alt' => trim(strip_tags( $wp_postmeta->_wp_attachment_image_alt )),
                    ) ); ?>
                    <div class="extra_wrapper">
                        <div class="text1">
                            <a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a>
                        </div>
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>
----------------------------------------------------------вывод на статической странице ---------------------------------------------------------------
<?php if (have_posts()) : the_post() ?>
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
<?php else: ?>
    <p><?php _e('Извините, ничего не найдено...') ?></p>
<?php endif ?>
-----------------------------------------------------CSS-WP---------------------------------------------------------------
@charset "utf-8";
/*
Theme Name: RVG-marketing
Theme URI: http://raskrutka-v-google.com.ua/
Description: http://raskrutka-v-google.com.ua/
Version: 1.0
Author: 2M
Author URI: http://raskrutka-v-google.com.ua/
*/

-----------------------------------------------------menu-WP---------------------------------------------------------------

переважно так:
1. Реєструю меню (щоб було доступне з адмінки)
//Меню
register_nav_menus(array(
'top' => 'Верхнее меню'
,'bottom' => 'Нижнее меню'
));
function my_wp_nav_menu_args($args=''){
$args['container'] = '';
return $args;
}
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

2. Створюю меню в адмінці
3. В потрібне місце додаю наступний код:
<?php
wp_nav_menu( array(
        'menu'              => 'TOP',
        'theme_location'    => 'Right',
        'container_class'   => 'menu',
        'menu_class'        => '',
        'menu_id'           => 'main-menu' )
);
?>
//
<?php
$args = array(
    'theme_location'  => '',
    'menu'            => '',
    'container'       => 'div',
    'container_class' => '',
    'container_id'    => '',
    'menu_class'      => 'menu',
    'menu_id'         => '',
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'depth'           => 0
);
?>
<?php wp_nav_menu( $args ); ?>
menu - назва меню
container_class - дів в який береться меню
menu_class і menu_id - клас і ІД основного ул елемента меню
-------------------------------------вывод подпунктов меню радительской страницы------------------------------
<?php //add right-bar
$postID = $post->ID;
$ancestors = get_ancestors( $postID, 'page' );
if ($ancestors[0] == '') {//if it parrent
    $args = array(
        'post_type' => 'any',
        'numberposts' => -1,
        'order' => 'ASC',
        'post_status' => 'any',
        'post_parent' => $postID,
    );
} else {//if it children
    $args = array(
        'post_type' => 'page',
        'numberposts' => -1,
        'order' => 'ASC',
        'post_status' => 'any',
        'post_parent' => $ancestors[0]
    );
}

$childrens = get_children($args, $output);
if ( $childrens )
{ ?>

    <ul class="list-unstyled service-list">
        <?php foreach ( $childrens as $children )
        {
            echo '<li><a class="orange-bg" href="'. get_page_link($ancestors[0]) . $children->post_name . '/">';
            echo $children->post_title;
            echo '</a></li>';
        } ?>
    </ul>
<?php } ?>
-----------
<?php $pages = get_pages( array( 'child_of' => 1 ) ); ?>
<ul>
    <?php foreach ( $pages as $page ) : ?>
        <li>
            <?php echo get_the_post_thumbnail( $page->ID, 'thumbnail' ); ?>
            <h1><?php echo $page->post_title; ?></h1>
            <?php echo $page->post_content; ?>
        </li>
    <?php endforeach; ?>
</ul>
-------------------------------------------------------navigation---------------------------------
function.php:
-----------
<?php
function navigation() {
    global $wp_query, $wp_rewrite;
    $pages = '';
    $max = $wp_query->max_num_pages;
    if (!$current = get_query_var('paged')) $current = 1;
    $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
    $a['total'] = $max;
    $a['current'] = $current;
    $total = 0; //1 - выводить текст "Страница N из N", 0 - не выводить
    $a['mid_size'] = 1; //сколько ссылок показывать слева и справа от текущей
    $a['end_size'] = 1; //сколько ссылок показывать в начале и в конце
    $a['prev_text'] = '&laquo;'; //текст ссылки "Предыдущая страница"
    $a['next_text'] = '&raquo;'; //текст ссылки "Следующая страница"
    if ($max > 1) echo '<div>';
    if ($total = 1 && $max > 1) $pages = '<span>Страница ' . $current . ' из ' . $max . '</span>'."\r\n";
    echo $pages . paginate_links($a);
    if ($max > 1) echo '</div>';
}
?>
------------
page.php:
------------
<?php
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }
query_posts('posts_per_page=5&cat=7&paged=' . $paged);
?> <!-- выводит 5 постов из 7 категории  -->
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <div class="box2">
            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <?php the_content(); ?>
        </div>

    <?php endwhile; ?>
<?php endif; ?>
<div class="navig"><?php navigation(); ?></div>
----------------------------------------------------------devide content in two part--with help more----------------------------------
-------page.php-------
<?php global $post; ?>
<?php $content = split_content(); ?>
<?php echo array_shift($content) ?>
<?php echo implode($content) ?>
-------function.php-------
<?php
// split content at the more tag and return an array
function split_content() {
    global $more;
    $more = true;
    $content = preg_split('/<span id="more-\d+"><\/span>/i', get_the_content('more'));
    for($c = 0, $csize = count($content); $c < $csize; $c++) {
        $content[$c] = apply_filters('the_content', $content[$c]);
    }
    return $content;
}
function split_sign($post,$field) {
    global $more_sign;
    $more_sign = true;
    $content = preg_split('/<span id="more-\d+"><\/span>/i', get_post_meta($post->ID, $field, true));
    for($c = 0, $csize = count($content); $c < $csize; $c++) {
        $content[$c] = apply_filters(get_post_meta($post->ID, $field, true), $content[$c]);
    }
    return $content;
}
?>
----------------------------------------------------------вернуться назад-----------------------------------------------------
//вернуться назад по истории браузера
<a href="#" style="float:left;" onClick="history.back();return false;">Вернуться назад</a>
//вернуться назад на страницу родителя в вордпрессе
<?php
$this_page = get_post($id);
$parent_id = $this_page->post_parent;
if ($parent_id) {
    $parent = get_page($parent_id);
    echo '<a href="'.get_permalink($parent->ID).'" class="add-back" title="">Takaisin</a>';
}
?>
----------------------------------------------------------локализация сайта----------------------------------------------------
плагин qTranslate
----вставить значки с языками---------
<?php qtrans_generateLanguageSelectCode($type='both');	?>
------------------------------------------------------коментарии вк и фейсбук---------------------------------------------------------
<!------------------------------------------------Код комментов ВК----------------------------------------->

<!--Этот скрипт добавить в хидер -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>

<script type="text/javascript">
    VK.init({apiId: 4149333, onlyWidgets: true});
</script>

<!-- Этот код добавить в место для комментариев -->
<div id="vk_comments"></div>
<script type="text/javascript">
    VK.Widgets.Comments("vk_comments", {limit: 5, width: "350", attach: "*"});
</script>

<!-------------------------------------------Код комментов Фейсбук------------------------------------------>

<!--Этот скрипт добавить в в теге body-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Этот код добавить в место для комментариев -->
<div class="fb-comments" data-href="http://site2b.com.ua/" data-width="350" data-numposts="5" data-colorscheme="light"></div>
<--------------------------------------like fb, tw, in, g+-------------------------------->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/fi_FI/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div class="sm facebook"><div class="fb-like" data-href="http://forever-syyskampanja.info/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></div>
------
<div class="sm twitter">
    <a href="https://twitter.com/share" class="twitter-share-button" data-via="twitterapi" data-lang="fi"></a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
----
<div class="sm linkedin">
    <script src="//platform.linkedin.com/in.js" type="text/javascript">
        lang: fi_FI
    </script>
    <script type="IN/Share" data-counter="right"></script>

</div>
----
<div class="sm google">
    <div class="g-plusone" data-size="medium"></div>
</div>

------------------------------------------------------rustolat------------------------------------------------
в постоянные ссылки вставить: /%postname%.html

и установить плагин "RusToLat"
--------------------------------------------------------nextgallery-------------------------------------------
[nggallery id=2]
<!--------------------------------------------------бутстрап всплывающее окно с формой------------------------------------------->
<div class="col-sm-8 info">
    <figure class="pull-right">
        <a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"><img src="http://www.stgnlion.com/vsp/www/wp-content/themes/vsp/images/katso-video.jpg" alt="" class="img-responsive"></a>
    </figure>
    <h3>Katso video</h3>
    <p>Miksi asiakaspalvelu kannattaa ulkoistaa? Haastattelussa asiakaspalvelujohtaja Petra Mengelt, Euroloan Consumer Finance.</p>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <iframe width="100%" height="300" src="//www.youtube.com/embed/uIzVOXbHEuo" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------всплывающее окно с формой------------------------------------------------------>
1)загрузить плагин contactForm 7
2)загрузить жс-ник "scriptsCF7.js" *плагины\contactForm7*
3)jquery
----------------текст скрипта который нужно использовать-------------------
<script>
    $(function(){
        $('.popup_t').click(function(){
            var body_height = parseInt($('body').height()),
                body_width = parseInt($('body').width()),
                popup = $('.popup_bg').next('.popup'),
                popup_height = parseInt($(popup).height());
            $('.popup_bg').addClass('active');
            $(popup).addClass('active');
        });
        $(this).keydown(function(eventObject){
            if (eventObject.which == 27){
                $('.popup_bg').removeClass('active');
                $('.popup').removeClass('active');
            }
        });
        $('.popup_bg').click(function(){
            $(this).removeClass('active');
            $(this).next('.popup.active').removeClass('active');
        });
        $('.closen').click(function(){
            $('.popup_bg').removeClass('active');
            $('.popup').removeClass('active');
        });
    });
</script>

-----------------текст скрипта-----------------------
---------css--------------
<style>
    /*popup*/
    .popup_bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        visibility: hidden;
        z-index: 99;
    }
    .popup_bg.active, .popup.active {
        visibility: visible !important;
        z-index: 99999999999999 !important;
    }
    .popup.sl_form {
        position: fixed;
        top: 20%;
        left: -999px;
        right: -999px;
        margin: auto;
        visibility: hidden;
        z-index: 99;
        width: 437px;
    }
</style>

--------------css--------------
3) вставить код в нужное место:
<!-------------->
<script language="javascript" type="text/javascript" src="<?php bloginfo('template_url');?>/js/scriptsCF7.js"></script>

<span class="popup_t" data-name="f1">закажите звонок</span>

<div class="popup_bg"></div>
<div class="popup sl_form f1">
    <?php echo do_shortcode('[contact-form-7 id="320" title="Форма для контакта 1"]'); ?>
</div>
-----bootstrap----------
<!-- Small modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>
-----------------------placeholder-------------------
placeholder "Ваш номер телефона"
-----------------------------------------------scrol with ankor------------------------------------------------
<script type="text/javascript">
    $(document).ready(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            var target = $(this.hash);
            if (target.length == 0) target = $('a[name="' + this.hash.substr(1) + '"]');
            if (target.length == 0) target = $('html');
            $('html, body').animate({ scrollTop: target.offset().top }, 500);
            return false;
        });
    });
</script>
<!--------------------------------------------------scrollToTop------------------------------------------------------------------------>
в код добавить:
<a href="#" class="scrollup">Scroll</a>
в шапку добавить жс:
<script type="text/javascript">
    $(document).ready(function () {

        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        });

        $('.scrollup').click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            return false;
        });

    });
</script>
------css------
.scrollup {
width: 40px;
height: 40px;
position: fixed;
bottom: 50px;
right: 100px;
display: none;
text-indent: -9999px;
background: url('icon_top.png') no-repeat;
background-color: #000;
}
<-------------------------------------------------------------spoiler show-hidden-------------------------------------------------------------->
<p>какой-то который не скрывается  ---- Hormiturvamies on keskittynyt savu-ja ilmahormien käyttöiän ja- turvallisuuden parantamiseen. Teemme veloituksettomia tarkastuskäyntejä toiminta-alueillamme ja raportoimme asiakkaille piipun kunnosta ja mahdollisista korjaustoimenpiteistä.</p>



<div class="spoiler" style="display:none;">
    <p>текст под спойлером ---- Palvelemme valtakunnallisesti yrityksiä monelta eri toimialalta ja asiakkaanamme on useita tunnettuja ja oman alansa johtavia yrityksiä Suomessa.</p>
</div>
<button id="show-more-btn">Lue lisää </button>
JS:
<script>
    $('#show-more-btn').click(function(){
        var link = $(this);
        $('.spoiler').slideToggle('slow', function() {
            if ($(this).is(":visible")) {
                link.text('Sulje');
            } else {
                link.text('Lue lisää');
            }
        });
    });
</script>
<!------------------------------------------------------------------hover---------------------------------------------------------------------->
<script>
    $(document).ready(function(){
        $("#pol1").hover(function(){
            $('#polb1').show();
        },function(){
            $('#polb1').hide();
        });
        $("#pol2").hover(function(){
            $('#polb2').show();
        },function(){
            $('#polb2').hide();
        });
        $("#pol3").hover(function(){
            $('#polb3').show();
        },function(){
            $('#polb3').hide();
            $('.un').css('z-index','-1');
        });
    });
</script>
-------------------------------------------------------------------редирект-------------------------------------------------------------------------------
<script type="text/javascript">
    $(document).ready(function(){
        var a = location.pathname;
        var b = "/sobstvennyj-sovremennyj-avtopark.html";
        if ( a == b ){
            document.location.href = "/category/sotrudniki";
        }
    });
</script>
<!----------------------------------------------------скрипт для времени суток------------------------------------------------------->
<script type="text/javascript">
    $(document).ready(function() {
        var day = new Date();
        var h = day.getHours();
        var vih = day.getUTCDay();

        if (vih>=1 && vih<=5) {
            if (h>=6 && h<=20) {
                $('#akcihome').text('Акция!');
//		$('#s19').text('');
                $('#poluchhome').text('Получите скидку сейчас!');
                $('#pformhome').text('Получите скидку 38%. Предложение ограничено!');
                $('#p2formhome').text('Осталось 3 дня');
            } else   if (h<=6 || h>=20) {
                $('#akcihome').text('Ночная скидка 38%');
                $('#s19').text('');
                $('#poluchhome').text('Получите ночную скидку');
                $('#pformhome').text('Для фиксации Вашей скидки 38%');
                $('#p2formhome').text('Заполните форму сейчас');
            }
        } else if (vih==0 || vih==6) {
            $('#akcihome').text('Скидка выходного дня 38%');
            $('#s19').text('');
            $('#poluchhome').text('Получите Вашу скидку!');
            $('#pformhome').text('Для фиксации Вашей скидки 38%');
            $('#p2formhome').text('Заполните форму сейчас');
        }
    });
</script>
<!------------------------------------------------------затемнение картинок------------------------------------------>
.grayscale {
-webkit-filter: grayscale(100%);
-moz-filter: grayscale(100%);
-ms-filter: grayscale(100%);
-o-filter: grayscale(100%);
filter: grayscale(100%);
filter: url(grayscale.svg#greyscale); /* Firefox 4+ */
filter: gray; /* IE 6-9 */
}
Внимание! Возможно, Вы уже увидели строчку с

filter:  url(grayscale.svg#greyscale);
В ней мы подключаем файл для того, чтобы обесцвечивание работало и в Firefox.

Достаточно просто создать файл grayscale.svg и добавить в него следующее:

<svg version="1.1" xmlns="http://www.w3.org/2000/svg">
    <filter id="greyscale">
        <feColorMatrix type="matrix" values="0.3333 0.3333 0.3333 0 0
 0.3333 0.3333 0.3333 0 0
 0.3333 0.3333 0.3333 0 0
 0  0  0  1 0"/>
    </filter>
</svg>


Теперь его убираем обесцвечивание, то есть делаем элементом снова цветным. Например, при наведении курсора на элемент:

Код CSS

.grayscale:hover {
-webkit-filter: grayscale(0%);
-moz-filter: grayscale(0%);
-ms-filter: grayscale(0%);
-o-filter: grayscale(0%);
filter: none;
}
-----------------------------------инпут пропадает текст при нажатии---------------------------------------
<input type="text" name="email" class="required email" value="Введите Ваш е-мейл" onfocus="this.value=''" onblur="if (this.value==''){this.value='Введите Ваш е-мейл'}">
------------------------------------------------------sticky menu-------------------------------------------------------
<script>
    $(document).ready(function() {
        jQuery(document).ready(function($) {
            jQuery(window).scroll(function() {
                var h = jQuery(window).scrollTop();
                if (  jQuery(window).scrollTop() > 180 )
                {
                    $('#sticky_menu').fadeIn('fast');
                }
                else
                {
                    $('#sticky_menu').hide(); //alert (1);
                }
            });
        });
    });
</script>
---------------------------------------------------------------------breadcrumps (хлебніе крошки)--------------------------------------------------
<?php dimox_breadcrumbs(); ?>
------

<?
function dimox_breadcrumbs(){
    /* === OPTIONS === */
    $text['home']     = 'Etusivu'; // text for the 'Home' link
    $text['category'] = 'Archive by Category "%s"'; // text for a category page
    $text['tax'] 	  = 'Archive for "%s"'; // text for a taxonomy page
    $text['search']   = 'Search Results for "%s" Query'; // text for a search results page
    $text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
    $text['author']   = 'Articles Posted by %s'; // text for an author page
    $text['404']      = 'Error 404'; // text for the 404 page

    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter   = '  /  '; // delimiter between crumbs
    $before      = '<span class="current">'; // tag before the current crumb
    $after       = '</span>'; // tag after the current crumb
    /* === END OF OPTIONS === */

    global $post;
    $homeLink = get_bloginfo('url') . '/';
    $linkBefore = '<span typeof="v:Breadcrumb">';
    $linkAfter = '</span>';
    $linkAttr = ' rel="v:url" property="v:title"';
    $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

    if (is_home() || is_front_page()) {

        if ($showOnHome == 1) echo '<div id="breadcrumbs" class="breadcrumb"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

    } else {

        echo '<div id="breadcrumbs" class="breadcrumb"" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;


        if ( is_category() ) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
            }
            echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

        } elseif( is_tax() ){
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
            }
            echo $before . sprintf($text['tax'], single_cat_title('', false)) . $after;

        }elseif ( is_search() ) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;

        } elseif ( is_day() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;

        } elseif ( is_month() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;

        } elseif ( is_year() ) {
            echo $before . get_the_time('Y') . $after;

        } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo $cats;
                if ($showCurrent == 1) echo $before . get_the_title() . $after;
            }

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;

        } elseif ( is_attachment() ) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $delimiter);
            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
            echo $cats;
            printf($link, get_permalink($parent), $parent->post_title);
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_page() && !$post->post_parent ) {
            if ($showCurrent == 1) echo $before . get_the_title() . $after;

        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs)-1) echo $delimiter;
            }
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_tag() ) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;

        } elseif ( is_404() ) {
            echo $before . $text['404'] . $after;
        }

        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
            echo __('Page') . ' ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }

        echo '</div>';

    }
} // end dimox_breadcrumbs()
?>
---------------------------------------------------------------------carousel item(bootstrap)----------------------------------
<h1>PALVELUKSESSANNE</h1>

<h2>Arja Raukola Oy on henkilöstöpalvelualalla lähes kolmekymmentä vuotta toiminut suomalainen perheyritys. Olemme erikoistuneet toimihenkilöiden suorarekrytointiin ja henkilöstövuokraukseen.</h2>
<div class="container">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="..." alt="...">
                <div class="carousel-caption">
                    ...
                </div>
            </div>
            <div class="item">
                <img src="..." alt="...">
                <div class="carousel-caption">
                    ...
                </div>
            </div>
            ...
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

</div><!-- /CONTAINER -->
<p>Kumppaninamme säästät aikaasi, kohdennat taloudelliset resurssisi tarkemmin, pystyt keskittymään ydinliiketoimintaasi ja saat käyttöösi ammattilaisen kannanoton lisähenkilöstön rekrytointiin. Haluamme palvella juuri sinun yritystäsi ja tarpeitasi.</p>

<p><a href="[url_base]/ihmiset/" class="btn btn-medium">Lue lisää</a></p>

----------------------------------------------------add profile of author-------------------------------------
<?
----function.php--------
[10:26:00] Andriy Davis: /*===================================================================================
* Add Author Links
* =================================================================================*/


function add_to_author_profile( $contactmethods ) {

    $contactmethods['twitter_profile'] = 'Twitter Profile URL';
    $contactmethods['linkedin_profile'] = 'Linkedin Profile URL';
    $contactmethods['googlePlus_profile'] = 'GooglePlus Profile URL';

    return $contactmethods;
}
add_filter( 'user_contactmethods', 'add_to_author_profile', 10, 1);

/ Adding Image Upload Fields /
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user )
{
    ?>

    <h3>Profile Images</h3>

    <style type="text/css">
        .fh-profile-upload-options th,
        .fh-profile-upload-options td,
        .fh-profile-upload-options input {
            vertical-align: top;
        }

        .user-preview-image {
            display: block;
            height: auto;
            width: 300px;
        }

    </style>

    <table class="form-table fh-profile-upload-options">
        <tr>
            <th>
                <label for="image">Main Profile Image</label>
            </th>

            <td>
                <img class="user-preview-image" src="<?php echo esc_attr( get_the_author_meta( 'image', $user->ID ) ); ?>">

                <input type="text" name="image" id="image" value="<?php echo esc_attr( get_the_author_meta( 'image', $user->ID ) ); ?>" class="regular-text" />
                <input type='button' class="button-primary" value="Upload Image" id="uploadimage"/><br />

                <span class="description">Please upload an image for your profile.</span>
            </td>
        </tr>
    </table>

    <script type="text/javascript">
        (function( $ ) {
            $( '#uploadimage' ).on( 'click', function() {
                tb_show('test', 'media-upload.php?type=image&TB_iframe=1');

                window.send_to_editor = function( html )
                {
                    imgurl = $( 'img',html ).attr( 'src' );
                    $( '#image' ).val(imgurl);
                    tb_remove();
                }

                return false;
            });

        })(jQuery);
    </script>

<?php
}

add_action( 'admin_enqueue_scripts', 'enqueue_admin' );

function enqueue_admin()
{
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_style('thickbox');

    wp_enqueue_script('media-upload');
}

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
    {
        return false;
    }

    update_user_meta( $user_id, 'image', $_POST[ 'image' ] );
}
?>
--------------initialization in page.php----------------------------
<div class="thumb">
    <img src="<?php echo get_the_author_meta('image') ?>" />
</div>
<h4><?php echo get_the_author_meta('display_name'); ?></h4>
<div class="desc">
    <?php echo get_the_author_meta('description'); ?>
</div>
<a href="#" class="other">View all articles</a>
<ul class="social-links">
    <li>
        <a href="<?php echo get_the_author_meta('linkedin_profile'); ?>" class="tw" target="_blank"></a>
    </li>
    <li>
        <a href="<?php echo get_the_author_meta('linkedin_profile'); ?>" class="goo" target="_blank"></a>
    </li>
    <li>
        <a href="<?php echo get_the_author_meta('twitter_profile'); ?>" class="li" target="_blank"></a>
    </li>
</ul>
</div>
----------------------------------------------------------------add php into JS--------------------------------------------------------------
<script type="text/javascript">
    $(document).ready(function() {
        getItems();
        var video = <?php echo json_encode($video); ?>;
    });
</script>
--------------------------------plugin open in new window-------------------------------------------
Open external links in a new window
-----------------------------------------------------------------phone validation-------------------------------------------------------
<script type="text/javascript">
    $('.phone').find('input').keydown(function(event) {
        // Разрешаем: backspace, delete, tab и escape
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 32 || event.keyCode == 107 || event.keyCode == 187 ||
                // Разрешаем: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
                // Разрешаем: home, end, влево, вправо
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // Ничего не делаем
            return;
        }
        else {
            // Обеждаемся, что это цифра, и останавливаем событие keypress
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
                $(this).css('border','1px solid red');
                console.log("red");
            } else {
                $(this).css('border','1px solid #A9A9A9');
            }
        }
    });
</script>
------------------------------------------------close modal video-------------------------------------------------------
<script type="text/javascript">
    $('.video').each(function(){
        $(this).find('.close').click(function(){
                var video = $(this).parent().parent().find('iframe').attr('src');
                $(this).parent().parent().find('iframe').attr('src','');
                $(this).parent().parent().find('iframe').attr('src',video);
            }
        );
        $(this).find('.modal').click(function(){
                var video = $(this).find('iframe').attr('src');
                $(this).find('iframe').attr('src','');
                $(this).find('iframe').attr('src',video);
            }
        );
    });
</script>
------------------------------advanced custom fields--------------------------------
------taxonomies-----
<?php
$my_tax = get_field('faq');
if( $my_tax ):
    foreach( $my_tax as $my_tax ):
        $cat = $my_tax->slug;
    endforeach;
endif;
//                    var_dump($my_tax);
?>
-----------------------------------------------------------------------popular post in wp--------------------------------------------------
------function.php-----
<?php
//add view date to post
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function wpb_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;
    }
    wpb_set_post_views($post_id);
}
add_action( 'wp_head', 'wpb_track_post_views');
?>
------in single.php------
put in loop of your posts
<?php wpb_set_post_views(get_the_ID()); ?>
-------post wp-admin----
----------------------------------------------------------ajax download content------------------------------------------------
<script type="text/javascript">
    $(document).ready(function(){

        /* AJAX from blog page to main page blog feed */

        $.ajax({
            type: 'POST',
            url: 'http://stgnlion.com/mtr_14/blog/',
            dataType: 'html',
            success: function(response){
                $('.blogpart').html($($.parseHTML(response)).find(".blogpost"));
//$('.blogpart').prepend('<div class="h2">Ajankohtaista</div>');
//$('.main .inner.block.sixth > .content .facebook-part > .feed.blog-feed').removeClass('active');
                $('.main .inner.block.sixth > .content .facebook-part > .feed.blog-feed .archivelist').each(function(){
                    $(this).find('.title').html($(this).find('.title').html().replace(/<!--([\s\S]*?)-->/mig, '$1'));
                    $(this).find('.title .archivedatepost').remove();
                    $(this).find('.title').contents().filter(function(){
                        return this.nodeType === 3;
                    }).remove();
                });
                console.log('success ajax blog page');
            },
//error: function(xhr, ajaxOptions, thrownError){
//    console.log('blog ajax error');
//    $('.main .inner.block.sixth > .content .facebook-part > .feed.blog-feed').removeClass('active');
//}
        });

    });
</script>
-----------------------------------------------------------media-----------------------------------------------------------------
<style type="text/css">
    @media screen and (max-width:480px) {
        @-ms-viewport{
            width:480px;
        }
        @viewport {
            width: 480px;
        }
        @-o-viewport {
            width: 480px;
        }

    }
</style>
----------------------------------------------------------paralax-------------------------------------------------------------
<div data-type="background" data-speed="10"></div>
<script>
    $('[data-type="background"]').each(function(){

        var $bgobj = $(this); // assigning the object

        $(window).scroll(function() {
            var yPos = -( ($window.scrollTop() - $bgobj.offset().top) / $bgobj.data('speed'));
            var coords = '50% '+ yPos + 'px';

            $bgobj.css({ backgroundPosition: coords });
        });

    });
</script>
----------------------------------------------------my multi horizontal slider----------------------------------
---html---
<div id="carousel1" class="slider-wrap">
    <div class="slider-cut">
        <div class="slider-inner" data-active="0">
            <div class="slider-item">
                <h3 class="h3">Tule tutustumaan Peili-valmennustyökaluihin</h3>
                <div class="date">05.20.2015, 9.00-11.30</div>
            </div>
            <div class="slider-item">
                <h3 class="h3">Tule tutustumaan Peili-valmennustyökaluihin</h3>
                <div class="date">05.20.2015, 9.00-11.30</div>
            </div>
            <div class="slider-item">
                <h3 class="h3">Tule tutustumaan Peili-valmennustyökaluihin</h3>
                <div class="date">05.20.2015, 9.00-11.30</div>
            </div>
        </div>
    </div>
    <div class="slider-arrows">
        <a href="#" data-target="#carousel1" class="left"></a>
        <a href="#" data-target="#carousel1" class="right"></a>
    </div>
    <div class="slider-indicators">
        <a href="#" class="slider-square active" data-target="#carousel1" data-control="0"></a>
        <a href="#" class="slider-square" data-target="#carousel1" data-control="1"></a>
        <a href="#" class="slider-square" data-target="#carousel1" data-control="2"></a>
    </div>
</div>
---css---
<style>
    /*slider*/
    .slider-wrap {
        padding: 0 80px;
        position: relative;
        width: 100%;
    }
    .slider-wrap .slider-cut {
        overflow: hidden;
        position: relative;
        width: 100%;
    }
    .slider-wrap .slider-item {
        float: left;
        position: relative;
        -webkit-transition: .6s ease-in-out left;
        -o-transition: .6s ease-in-out left;
        transition: .6s ease-in-out left;
        -moz-transition: .6s ease-in-out left;
    }

    .slider-wrap .slider-inner {
        -webkit-transition: .6s ease-in-out left;
        -o-transition: .6s ease-in-out left;
        transition: .6s ease-in-out left;
        -moz-transition: .6s ease-in-out left;
        min-height: 70px;
        position: relative;
        left: 0px;
    }
    .slider-wrap .slider-arrows a {
        width: 33px;
        height: 60px;
        display: block;
        background: url(img/sprite.png) -472px -66px no-repeat;
        position: absolute;
        top: 0px;
    }

    .slider-wrap .slider-arrows a.left {
        left: 25px;
        transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -webkit-transform: rotate(180deg);
        -o-transform: rotate(180deg);
    }

    .slider-wrap .slider-arrows a.right {
        right: 25px;
    }

    .slider-wrap .slider-indicators {
        display: table;
        margin: 20px auto;
        position: relative;
    }

    .slider-wrap .slider-indicators .slider-square {
        width: 10px;
        height: 10px;
        display: block;
        float: left;
        margin: 0 6px;
        border-radius: 10px;
        background-color: #CADEA3;
        -webkit-transition: .8s;
        -moz-transition: .8s;
        -o-transition: .8s;
        transition: .8s;
    }
    .slider-wrap .slider-indicators .slider-square:hover {
        background-color: white;
    }
    .slider-wrap .slider-indicators .slider-square.active {
        background: #FFFFFF;
    }
    /*end slider*/
</style>
---sass---
<style>
    .slider-wrap {
        padding: 0 80px;
        position: relative;
        width: 100%;
    .slider-cut {
        overflow: hidden;
        position: relative;
        width: 100%;
    }
    .slider-item {
        float: left;
        position: relative;
    @include crossBrowser(transition, .6s ease-in-out left);
    }
    .slider-inner {
    @include crossBrowser(transition, .6s ease-in-out left);
        min-height: 70px;
        position: relative;
        left: 0px;
    }
    .slider-arrows a {
        width: 33px;
        height: 60px;
        display: block;
        background: url(img/sprite.png) -472px -66px no-repeat;
        position: absolute;
        top: 0px;
    &.left {
         left: 25px;
     @include crossBrowser(transform, rotate(180deg));
     }
    &.right {
         right: 25px;
     }
    }
    .slider-indicators {
        display: table;
        margin: 20px auto;
        position: relative;
    .slider-square {
        width: 10px;
        height: 10px;
        display: block;
        float: left;
        margin: 0 6px;
        border-radius: 10px;
        background-color: #CADEA3;
    @include crossBrowser(transition, .8s);
    &:hover {
         background-color: white;
     }
    &.active {
         background: #FFFFFF;
     }
    }
    }
    }
</style>
---js---
<script>
    if ($('.slider-wrap')[0]) {
        $('.slider-wrap .slider-cut').each(function(){
            myThis = $(this);
            var slider_col = myThis.find('.slider-inner > .slider-item').length;
            var sl_width = myThis.css('width');
            if (myThis.parent().is('.carousel')) {
                var slider_width = (parseInt(sl_width.replace(/px/,""))/3)+"px";
                var slider_inner_width = (parseInt(slider_width.replace(/px/,""))*slider_col)+50+"px";
            } else {
                var slider_width = (parseInt(sl_width.replace(/px/,"")))+"px";
                var slider_inner_width = (parseInt(slider_width.replace(/px/,""))*slider_col)+"px";
            }

            $(this).find('.slider-inner').css('width',slider_inner_width);
            $(this).find('.slider-item').css('width',slider_width);
        });
        /***indicators*/
        $('.slider-wrap .slider-indicators a').click(function(e){
            e.preventDefault();
            var slider_id = $(this).data('target');
            var slider_indicator = $(this).data('control');
            $(slider_id+' .slider-inner').attr('data-active',slider_indicator);
            var slider_inner_left = (parseInt($(slider_id+' .slider-cut').css('width').replace(/px/,""))*(-slider_indicator))+"px";
            $(slider_id+' .slider-inner').css('left',slider_inner_left);
            $(slider_id+' .slider-indicators a').removeClass('active');
            $(this).addClass('active');
        });
        /**arrows*/
        $('.slider-wrap .slider-arrows a.left').click(function(e){
            e.preventDefault();
            var slider_id = $(this).data('target');
            var slider_col = $(slider_id+' .slider-inner > .slider-item').length;
            var slider = $(slider_id+' .slider-inner').attr('data-active');
            var slider1 = slider -'1';
            if ($(this).is('.carousel')) {
                var slider_inner_left = (parseInt($(slider_id+' .slider-cut').css('width').replace(/px/,""))*(-(slider_col-3))/3)+"px";
                var slider_col_data = slider_col - 3;
            } else {
                var slider_inner_left = (parseInt($(slider_id+' .slider-cut').css('width').replace(/px/,""))*(-(slider_col-1)))+"px";
                var slider_col_data = slider_col - 1;
            }
            var slider_next_left = (parseInt($(slider_id+' .slider-inner').css('left').replace(/px/,"")) + parseInt($(slider_id+' .slider-item').css('width').replace(/px/,"")))+"px";
            var a = 'a';
            if (slider<=0) {
                $(slider_id+' .slider-inner').css('left',slider_inner_left);
                $(slider_id+' .slider-inner').attr('data-active',slider_col_data);
                $(slider_id+' .slider-indicators a').removeClass('active');
                $(slider_id+' .slider-indicators').find(a+'[data-control="'+ slider_col_data +'"]').addClass('active');
            } else {
                $(slider_id+' .slider-inner').css('left',slider_next_left);
                $(slider_id+' .slider-inner').attr('data-active',slider1);
                $(slider_id+' .slider-indicators a').removeClass('active');
                $(slider_id+' .slider-indicators').find(a+'[data-control="'+ slider1 +'"]').addClass('active');
            }
        });
        $('.slider-wrap .slider-arrows a.right').click(function(e){
            e.preventDefault();
            var slider_id = $(this).data('target');
            var slider_col = $(slider_id+' .slider-inner > .slider-item').length;
            var slider = $(slider_id+' .slider-inner').attr('data-active');

            if ($(this).is('.carousel')) {
                var slider_col_data = slider_col - 3;
                var slider_next_right = (parseInt($(slider_id+' .slider-inner').css('left').replace(/px/,"")) - parseInt($(slider_id+' .slider-item').css('width').replace(/px/,"")))+"px";

            } else {
                var slider_col_data = slider_col - 1;
                var slider_next_right = (parseInt($(slider_id+' .slider-inner').css('left').replace(/px/,"")) - parseInt($(slider_id+' .slider-item').css('width').replace(/px/,"")))+"px";
            }
            var a = 'a';
            if (slider>=slider_col_data) {
                $(slider_id+' .slider-inner').css('left','0');
                $(slider_id+' .slider-inner').attr('data-active',0);
                $(slider_id+' .slider-indicators a').removeClass('active');
                $(slider_id+' .slider-indicators').find(a+'[data-control="0"]').addClass('active');
            } else {
                slider++;
                $(slider_id+' .slider-inner').css('left',slider_next_right);
                $(slider_id+' .slider-inner').attr('data-active',slider);
                $(slider_id+' .slider-indicators a').removeClass('active');
                $(slider_id+' .slider-indicators').find(a+'[data-control="'+ slider +'"]').addClass('active');
            }
        });
    }
    setInterval( function() {
        if ($('#carousel1')[0]) {
            if($('#carousel1').is(':hover')) {
            }   else {
                $('#carousel1 .slider-arrows a.right').click();
            }
        }
    } , 3000);
</script>
------------------------------------------------Carousel---------------------------------------------
html:
<div id="carousel_container">
    <div class="left arrow"></div>
    <div id="carousel_inner">
        <ul id="carousel_ul" data-current="0">
            <li>
                <div class="img hidden">
                    <img src="image/slide1.jpg" />
                </div>
                <div class="content">
                    <h3 class="h3 h-border">Toni Tapeten<br />
                        Lorem ipsum dolor sit amet,<br />
                        consectetur adipiscing elit.</h3>
                    <div class="white-info">
                        <p>Aenean quis ante vitae arcu aliquam sodales.<br />
                            Sed a maximus velit, ac posuere dolor.<br />
                            Morbi id volutpat purus, quis sodales augue.<br />Etiam egestas porta ornare.</p>
                        <a href="#" class="more-btn">See more</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="img hidden">
                    <img src="image/slide2.jpg" />
                </div>
                <div class="content">
                    <h3 class="h3 h-border">Toni Tapeten<br />
                        Lorem ipsum dolor sit amet,<br />
                        consectetur adipiscing elit.</h3>
                    <div class="white-info">
                        <p>Aenean quis ante vitae arcu aliquam sodales.<br />
                            Sed a maximus velit, ac posuere dolor.<br />
                            Morbi id volutpat purus, quis sodales augue.<br />
                            Etiam egestas porta ornare.</p>
                        <a href="#" class="more-btn">See more</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="img hidden">
                    <img src="image/slide3.jpg" />
                </div>
                <div class="content">
                    <h3 class="h3 h-border">Toni Tapeten<br />
                        Lorem ipsum dolor sit amet,<br />
                        consectetur adipiscing elit.</h3>
                    <div class="white-info">
                        <p>Aenean quis ante vitae arcu aliquam sodales.<br />
                            Sed a maximus velit, ac posuere dolor.<br />
                            Morbi id volutpat purus, quis sodales augue.<br />
                            Etiam egestas porta ornare.</p>
                        <a href="#" class="more-btn">See more</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="img hidden">
                    <img src="image/slide2.jpg" />
                </div>
                <div class="content">
                    <h3 class="h3 h-border">Toni Tapeten<br />
                        Lorem ipsum dolor sit amet,<br />
                        consectetur adipiscing elit.</h3>
                    <div class="white-info">
                        <p>Aenean quis ante vitae arcu aliquam sodales.<br />
                            Sed a maximus velit, ac posuere dolor.<br />
                            Morbi id volutpat purus, quis sodales augue.<br />
                            Etiam egestas porta ornare.</p>
                        <a href="#" class="more-btn">See more</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="img hidden">
                    <img src="image/slide3.jpg" />
                </div>
                <div class="content">
                    <h3 class="h3 h-border">Toni Tapeten<br />
                        Lorem ipsum dolor sit amet,<br />
                        consectetur adipiscing elit.</h3>
                    <div class="white-info">
                        <p>Aenean quis ante vitae arcu aliquam sodales.<br />
                            Sed a maximus velit, ac posuere dolor.<br />
                            Morbi id volutpat purus, quis sodales augue.<br />
                            Etiam egestas porta ornare.</p>
                        <a href="#" class="more-btn">See more</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="right arrow"></div>
</div>
js:
<script>
    (function(){
        if ($('#carousel_container')[0]) {
            $('#carousel_ul > li').each(function(){
                var src1 = $(this).find('.img img').attr('src');
                $(this).css('background-image','url('+src1+')');
            });
            var slide_width = $('#carousel_inner').width() * 0.6;
            var slide_margin = $('#carousel_inner').width();
            $('#carousel_ul li').css({'width':slide_width});
            $('#carousel_ul').css('left', -slide_margin);
            $('#carousel_ul li:first').before($('#carousel_ul li:last'));
            $('.arrow.right').click(function () {
                var left_indent = parseInt($('#carousel_ul').css('left')) - slide_width;
                $('#carousel_ul li:nth-of-type(4), #carousel_ul li:nth-of-type(2), #carousel_ul li:nth-of-type(5)').addClass('now');
                //$('#carousel_ul li:nth-of-type(2)').addClass('now');
                setTimeout(function(){
                    $('#carousel_ul:not(:animated)').animate({'left': left_indent}, 400, function () {
                        $('#carousel_ul li:last').after($('#carousel_ul li:first'));
                        $('#carousel_ul').css({'left': -slide_margin});
                        $('#carousel_ul li').removeClass('now');
                    });
                },200);
            });
            $('.arrow.left').click(function () {
                var left_indent = parseInt($('#carousel_ul').css('left')) + slide_width;
                $('#carousel_ul li:nth-of-type(4), #carousel_ul li:nth-of-type(2), #carousel_ul li:nth-of-type(1)').addClass('now');
                setTimeout(function(){
                    $('#carousel_ul:not(:animated)').animate({'left': left_indent}, 500, function () {
                        $('#carousel_ul li:first').before($('#carousel_ul li:last'));
                        $('#carousel_ul').css({'left': -slide_margin});
                        $('#carousel_ul li').removeClass('now');
                    });
                },200);
            });
        }
    })();
</script>
sass:
<style>
    #carousel_container {
    .arrow {
        width: 32px;
        height: 32px;
        display: block;
        border: 1px solid #3d3d3c;
        border-radius: 100%;
        position: absolute;
        top: calc(50% - 16px);
        z-index: 999;
        cursor: pointer;
    &:after {
         content: "";
         width: 10px;
         height: 18px;
         display: block;
         position: absolute;
         background: url(../image/sprite.png) 0px -188px no-repeat;
         top: 6px;
         left: 8px;
     }

    &.left {
         left: 30px;
     }
    &.right {
    &:after {
         transform: rotate(180deg);
         left: 11px;
     }
    right: 30px;
    }
    }
    }
    #carousel_inner {
        float: left;
        width: 100%;
        overflow: hidden;
    }
    #carousel_ul {
        position: relative;
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 9999px;
    li {
        float: left;
        width: 30%;
        padding: 0;
        background-size: cover;
        position: relative;
    @include crossBrowser(transition, .3s);
    &:nth-of-type(2), &:nth-of-type(1) {
                           transform: scale(1) translate3d(15%, 0px, 0px) rotateY(30deg);
                       }
    &:nth-of-type(3) {
         transform: scale(1) translate3d(0%, 0px, 0px) rotateY(0deg);
         z-index: 10;
         box-shadow: 0px 0px 14px 7px rgba(0, 0, 0, 0.14);
     }
    &:nth-of-type(4), &:nth-of-type(5) {
                           transform: scale(1) translate3d(-15%, 0px, 0px) rotateY(-30deg);
                       }
    &.now {
         transform: scale(1) translate3d(0%, 0px, 0px) rotateY(0deg);
         z-index: 10;
     }
    img {
        position: absolute;
        border: 0;
        height: auto;
        width: auto;
        min-width: 100%;
        min-height: 100%;
    }
    .content {
        height: 100vh;
        display: table;
        width: 100%;
        padding: 15px 40px;
    }
    .h3 {
    @include font-combo(bold, (40/18) + em, $roboto , #373737);
        display: table-cell;
        vertical-align: middle;
        width: 60%;
        max-width: 200px;
    }
    }
    }
</style>
--------------------------------------------parse site with JS-------------------------------------------
<script>
    var news_title = [];
    var news_content = [];
    var url='http://query.yahooapis.com/v1/public/yql?q=select * from html where url=\'http://www.cbc.ca/news/world/\' and xpath=\'//div[@id="content"]//li//p\'&format=json&callback=?';
    var url1='http://query.yahooapis.com/v1/public/yql?q=select * from html where url=\'http://www.cbc.ca/news/world/\' and xpath=\'//div[@id="content"]//h2//a\'&format=json&callback=?';
    $.getJSON( url1, function(data) {
        $.each(data.query.results.a, function () {
            if (!this.content) {} else {
                news_title.push(this.content);
            }
        });
        var i = 0;
        $('.col-news .general-news').each(function(){
            $(this).find('.h4').text(news_title[i]);
            console.log(news_title[i],news_content[i]);
            i++;
        });
    });
    $.getJSON( url, function(data) {
        $.each(data.query.results.p, function () {
            if (!this.content) {} else {
                news_content.push(this.content);
            }
        });
        var i = 0;
        $('.col-news .general-news').each(function(){
            $(this).find('p').text(news_content[i]);
            console.log(news_title[i],news_content[i]);
            i++;
        });
    });
</script>
-----------------------------------------------------tabs-------------------------------------------------------
---js---
<script>
    /*news tab*/
    $('.nav-years li a').click(function(e){
        e.preventDefault();
        var year = $(this).attr('data-year');
        var yearid = '#' + year;
        $(this).parent().parent().find('li').removeClass('active');
        $(this).parent().addClass('active');
        $('.news-tabs .newstab').removeClass('active');
        $('.news-tabs').find(yearid).addClass('active');
    });
</script>
---html----
<ul class="nav-years nav">
    <li class=""><a href="#2015" data-year="2015">2015</a></li>
    <li class="active"><a href="#2014" data-year="2014">2014</a></li>
    <li class=""><a href="#2013" data-year="2013">2013</a></li>
</ul>
<div class="help-news news-tabs">

    <div role="newstab" class="newstab" id="2015">
        <h2 class="h2">Ajankohtaista 2015</h2>
        <div class="news item">
            <div class="news-date">
                <span>14</span>
                <span>tammikuu</span>
            </div>
            <div class="news-info">
                <h2 class="h2">Viikkojen 50-2 muutoshistoria julkaistaan 20.01.2015 klo 17.20</h2>
                <div class="news-text">Tehtävä Tyyppi Kuvaus Avainsanat 67630 Etusivu Korjattu etusivun ”Sähköpostien haussa virhe” -widget huomioimaan myös yhteysvirheet. sähköposti, widget, etusivu ...</div>
                <a href="http://www.valueframe.fi/help/news/viikkojen-50-2-muutoshistoria-julkaistaan-20-01-2015-klo-17-20/" class="read-more">tapahtuman tiedot</a>
            </div>
        </div>
    </div>
    <div role="newstab" class="newstab active" id="2014">
        <h2 class="h2">Ajankohtaista 2014</h2>
        <div class="news item">
            <div class="news-date">
                <span>02</span>
                <span>tammikuu</span>
            </div>
            <div class="news-info">
                <h2 class="h2">Viikkojen 49 – 51 muutoshistoria julkaistaan 7.1.2014 klo. 17.20</h2>
                <div class="news-text">Tehtävä Tyyppi Kuvaus Avainsanat 54768, 54766 Integraatiot / Exchange-integraatio Useita muutoksia/parannuksia liittyen Exchange-integraatioon: Parannettu logitusta liittyen synkronoinnin mahdollisiin ...</div>
                <a href="http://www.valueframe.fi/help/news/viikkojen-49-51-muutoshistoria-julkaistaan-7-1-2014-klo-17-20/" class="read-more">tapahtuman tiedot</a>
            </div>
        </div>
    </div>
    <div role="newstab" class="newstab" id="2013">
        <h2 class="h2">Ajankohtaista 2013</h2>
        <div class="news item">
            <div class="news-date">
                <span>09</span>
                <span>tammikuu</span>
            </div>
            <div class="news-info">
                <h2 class="h2">Viikkojen 50/2012 – 01/2013 muutoshistoria julkaistaan 15.1.2013 klo. 17.20</h2>
                <div class="news-text">Tehtävä Tyyppi Kuvaus Avainsanat 44854 Laskutus Korjattu ValueFramen muodostaman laskun PDF-liitteen sarakkeiden leveyttä sekä rivitystä siten, että pidemmät ...</div>
                <a href="http://www.valueframe.fi/help/news/viikkojen-502012-012013-muutoshistoria-julkaistaan-15-1-2013-klo-17-20/" class="read-more">tapahtuman tiedot</a>
            </div>
        </div>
    </div>
</div>
----css----
<style>
    .help-news-content .help-news > .newstab {
        opacity: 0;
        position: absolute;
        -webkit-transition: .3s;
        -moz-transition: .3s;
        -o-transition: .3s;
        transition: .3s;
        right: 200%;
    }
    .help-news-content .help-news > .newstab.active {
        opacity: 1;
        position: relative;
        right: 0px;
    }
</style>
--------------------------------------------------find text, make color red and scroll to this word-------------------------------
<script>
    if ($('.coach-search')[0]) {
        function coachSearch() {
            $('.asterisk').each(function(){
                $(this).contents().unwrap();
            });
            var text = $('.search-field').val();
            console.log(text);
            $('.coach-item-li, .h4, .coach-item-left').each(function() {
                var html = $(this).html().replace(text, "<span class=\"asterisk\">"+text+"</span>");
                $(this).html(html).find(".asterisk").css("color", "red");
            });
            $('html, body').animate({
                scrollTop: $(".asterisk").offset().top-40
            }, 900);
        }
        $('.search-submit').click(function(e){
            coachSearch();
        });
    }
</script>

-------------------------------------------------------------all new lines in tags-------------------------------------------------------------
<?php echo $paragraphedText = '<li class="coach-item-li">'.str_replace(array("\r","\n\n","\n"),array('',"\n","</li>\n<li class=\"coach-item-li\">"),trim(get_post_meta($post->ID, 'custom_coaches', true),"\n\r")).'</li>'; ?>
--------------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------rewrite permalinks--------------------------------------------------------
<?php
add_filter('rewrite_rules_array', 'mmp_rewrite_rules');
function mmp_rewrite_rules($rules) {
    $newRules  = array();
    $newRules['horoskoopit/(.+)/(.+)/(.+)/(.+)/?$'] = 'index.php?horoskoopit=$matches[4]'; // my custom structure will always have the post name as the 5th uri segment
    $newRules['horoskoopit/(.+)/(.+)/(.+)/?$'] = 'index.php?horoskoopit=$matches[3]'; // my custom structure will always have the post name as the 5th uri segment
    $newRules['horoskoopit/(.+)/(.+)/?$'] = 'index.php?horoskoopit=$matches[2]'; // my custom structure will always have the post name as the 5th uri segment
    $newRules['horoskoopit/(.+)/?$']                = 'index.php?horoskoopit-kategoriat=$matches[1]';

    return array_merge($newRules, $rules);
}
function filter_post_type_link($link, $post)
{
    if ($post->post_type != 'horoskoopit')
        return $link;

    if ($cats = get_the_terms($post->ID, 'horoskoopit-kategoriat'))
    {
        $link = str_replace('%horoskoopit-kategoriat%', substr(get_taxonomy_parents(array_pop($cats)->term_id, 'horoskoopit-kategoriat', false, '/', true), 0, -1), $link); // see custom function defined below
    }
    return $link;
}
add_filter('post_type_link', 'filter_post_type_link', 10, 2);
// my own function to do what get_category_parents does for other taxonomies
function get_taxonomy_parents($id, $taxonomy, $link = false, $separator = '/', $nicename = false, $visited = array()) {
    $chain = '';
    $parent = &get_term($id, $taxonomy);

    if (is_wp_error($parent)) {
        return $parent;
    }

    if ($nicename)
        $name = $parent -> slug;
    else
        $name = $parent -> name;

    if ($parent -> parent && ($parent -> parent != $parent -> term_id) && !in_array($parent -> parent, $visited)) {
        $visited[] = $parent -> parent;
        $chain .= get_taxonomy_parents($parent -> parent, $taxonomy, $link, $separator, $nicename, $visited);
    }

    if ($link) {
        // nothing, can't get this working :(
    } else
        $chain .= $name . $separator;
    return $chain;
}
?>
------------------------------------when move site on another server ------------------------
You have to modify the wp-includes/functions.php file, and change the maybe_unserialize() function to this:
<?php
function maybe_unserialize( $original ) {
    if ( is_serialized( $original ) ) {
        $fixed = preg_replace_callback(
            '!(?<=^|;)s:(\d+)(?=:"(.*?)";(?:}|a:|s:|b:|i:|o:|N;))!s',
            'serialize_fix_callback',
            $original );
        return @unserialize( $fixed );
    }
    return $original;
}
function serialize_fix_callback($match) { return 's:' . strlen($match[2]); }
?>
-------------------------------------------make word smaller---------------------------------
<script>
    /**
     * font-size
     */
    (function(){
        function bigWord(){
            $('.bigWord').each(function(){
                var that = $(this);
                var words = that.text().split(" ");
                that.text("");
                for (var y=0;y<words.length;y++) {
                    if (y==words.length-1) {
                        that.append('<span class="eachword">'+words[y]+'</span>');
                    } else {
                        that.append('<span class="eachword">'+words[y]+'</span> ');
                    }
                }
                that.find('.eachword').each(function(){
                    var thatWord = $(this);
                    CheckWord(that,thatWord);
                });
                function CheckWord(bigWord,thatWord) {
                    var i = 0;
                    var wordFont = bigWord.css('font-size').replace(/px/,"");
                    var wordWidth = thatWord.width();
                    var parentWidth = thatWord.parent().parent().width();

                    while (wordWidth > parentWidth) {
                        wordFont--;
                        $(bigWord).css({'font-size':wordFont + 'px','line-height':wordFont + 10 + 'px'});
                        i++;
                        wordWidth = thatWord.width();
                        if (i>40){
                            wordWidth = parentWidth;
                        }
                    }
                }
                var newS = that.find(".eachword").toArray();
                var newString = new Array();
                var string = "";
                for(var z=0;z<newS.length;z++) {
                    newString[z] = newS[z].innerText;
                }
                that.html("");
                for (var y1=0;y1<newString.length;y1++) {
                    if (y1==newString.length-1) {
                        string = string.concat(newString[y1]);
                    } else {
                        string = string.concat(newString[y1]+' ');
                    }
                }
                that.text(string);
            });
        }
        bigWord();
        $(window).resize(function() {
            bigWord();
        });
    })();
</script>