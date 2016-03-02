<?php
/***********************************/
/* Meta box 'Plans and staff page' */
/**********************************/

function add_staff_meta_box() {
    add_meta_box(
        'staff_meta_box',
        'Content titles',
        'show_staff_meta_box',
        'staff',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'add_staff_meta_box');

// Field Array
$prefix = 'custom_';
$allclinics = array();
$first_query = new WP_Query ( array( 'post_type' => 'clinics', 'posts_per_page' => -1,'post_parent' => 0, ));
while($first_query->have_posts()){ $first_query->the_post();
    $allclinics[get_the_ID()] = get_the_title();
}
wp_reset_postdata();
//var_dump($allclinics);
$staff_meta_fields = array(
    array(
        'label'=> 'Position',
        'id'    => $prefix.'position',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Clinics',
        'name'=> 'clinics',
        'id'    => $prefix.'clinics',
        'type'  => 'multicheckbox',
        'options' => $allclinics,
    ),
);

// The Callback
function show_staff_meta_box() {
    global $staff_meta_fields, $post;
// Use nonce for verification
    echo '<input type="hidden" name="custom_meta_box_nonce1" value="'.wp_create_nonce(basename(__FILE__)).'" />';

// Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($staff_meta_fields as $field) {
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
            case 'multicheckbox':
                $meta == "" ? $meta = array() : '';
                foreach ( $field['options'] as $value => $name ) {
                    // Append `[]` to the name to get multiple values
                    // Use in_array() to check whether the current option should be checked
                    echo '<input type="checkbox" name="', $field['id'], '[]" id="', $field['id'], '" value="', $value, '"', in_array( $value, $meta ) ? ' checked="checked"' : '', ' /> ', $name, '<br/>';
                }
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_staff_meta($post_id) {
    global $staff_meta_fields;

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
    foreach ($staff_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_staff_meta');
/**
 * skills
 */
add_action( 'add_meta_boxes', 'add_staffs_skills_post_type_meta_box' );
/* Do something with the data entered */
add_action( 'save_post', 'staffs_skills_save_postdata' );

function add_staffs_skills_post_type_meta_box() {
    add_meta_box(
        'staffs_post_skills_type',
        'Staff skills',
        'staffs_skills_fields_box',
        'staff',
        'normal',
        'high'
    );
}

/* Prints the box content */
function staffs_skills_fields_box()
{
    global $post;
    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'skillsMeta_noncename');
    ?>
    <div id="meta_inner2" class="slides-wrap">
    <?php

    //get the saved meta as an array
    $skills = get_post_meta($post->ID, 'staffs_skills', true);
    $c = 0;
    if (is_array($skills)) {
        foreach ($skills as $slide) {
            if (isset($slide['skills'])) {
                echo '<div class="dragNdrop" style="position: relative; margin-bottom: 40px;">
            <input type="text" name="staffs_skills[' . $c . '][skills]" value="' . $slide['skills'] . '" style="display: inline-block; float: left; margin: 0 10px;" />
            <input type="button" class="button remove button-primary" value="Remove skill" style=""  /></div>';
                $c++;
            }
        }
    }
    ?>
    <span id="here"></span>
    <button class="add button button-primary"><?php _e('Add skill'); ?></button>
    <script>
        var $ = jQuery.noConflict();
        $(document).ready(function () {
            var count = <?php echo $c; ?>;
            $(".add").click(function () {
                count += 1;
                $('#here').append(
                    '<div class="dragNdrop" style="position: relative; margin-bottom: 30px;">' +

                    '<input type="text" name="staffs_skills[' + count + '][skills]" value="" style="display: inline-block; float: left; margin: 0 10px;" />' +
                    '<input type="button" class="button remove button-primary" value="Remove skill" style="" /><div/>');
                return false;
            });
            $(".remove").click(function () {
                $(this).parent().remove();
            });
        });
    </script>
    </div><?php
}
/* When the post is saved, saves our custom data */
function staffs_skills_save_postdata( $post_id ) {
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['skillsMeta_noncename'] ) )
        return;
    if ( !wp_verify_nonce( $_POST['skillsMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;
    // OK, we're authenticated: we need to find and save the data
    $skills = $_POST['staffs_skills'];
    update_post_meta($post_id,'staffs_skills',$skills);
}
/**
 * language
 */
add_action( 'add_meta_boxes', 'add_staffs_languages_post_type_meta_box' );
/* Do something with the data entered */
add_action( 'save_post', 'staffs_languages_save_postdata' );

function add_staffs_languages_post_type_meta_box() {
    add_meta_box(
        'staffs_post_languages_type',
        'Staff languages',
        'staffs_languages_fields_box',
        'staff',
        'normal',
        'high'
    );
}

/* Prints the box content */
function staffs_languages_fields_box()
{
    global $post;
    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'languagesMeta_noncename');
    ?>
    <div id="meta_inner2" class="slides-wrap">
    <?php

    //get the saved meta as an array
    $languages = get_post_meta($post->ID, 'staffs_languages', true);
    $c = 0;
    if (is_array($languages)) {
        foreach ($languages as $slide) {
            if (isset($slide['languages'])) {
                echo '<div class="dragNdrop" style="position: relative; margin-bottom: 40px;">

            <input type="text" name="staffs_languages[' . $c . '][languages]" value="' . $slide['languages'] . '" style="display: inline-block; float: left; margin: 0 10px;" />
            <input type="button" class="button remove1 button-primary" value="Remove language" style=""  /></div>';
                $c++;
            }
        }
    }
    ?>
    <span id="here1"></span>
    <button class="add1 button button-primary"><?php _e('Add language'); ?></button>
    <script>
        var $ = jQuery.noConflict();
        $(document).ready(function () {
            var count = <?php echo $c; ?>;
            $(".add1").click(function () {
                count += 1;
                $('#here1').append(
                    '<div class="dragNdrop" style="position: relative; margin-bottom: 30px;">' +

                    '<input type="text" name="staffs_languages[' + count + '][languages]" value="" style="display: inline-block; float: left; margin: 0 10px;" />' +
                    '<input type="button" class="button remove1 button-primary" value="Remove language" style="" /><div/>');
                return false;
            });
            $(".remove1").click(function () {
                $(this).parent().remove();
            });
        });
    </script>
    </div><?php
}
/* When the post is saved, saves our custom data */
function staffs_languages_save_postdata( $post_id ) {
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['languagesMeta_noncename'] ) )
        return;
    if ( !wp_verify_nonce( $_POST['languagesMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;
    // OK, we're authenticated: we need to find and save the data
    $languages = $_POST['staffs_languages'];
    update_post_meta($post_id,'staffs_languages',$languages);
}
/**
 * pets
 */
add_action( 'add_meta_boxes', 'add_staffs_pets_post_type_meta_box' );
/* Do something with the data entered */
add_action( 'save_post', 'staffs_pets_save_postdata' );

function add_staffs_pets_post_type_meta_box() {
    add_meta_box(
        'staffs_post_pets_type',
        'Staff pets',
        'staffs_pets_fields_box',
        'staff',
        'normal',
        'high'
    );
}

/* Prints the box content */
function staffs_pets_fields_box()
{
    global $post;
    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'petsMeta_noncename');
    ?>
    <div id="meta_inner2" class="slides-wrap">
    <?php

    //get the saved meta as an array
    $pets = get_post_meta($post->ID, 'staffs_pets', true);
    $c = 0;
    if (is_array($pets)) {
        foreach ($pets as $slide) {
            if (isset($slide['pets'])) {
                echo '<div class="dragNdrop" style="position: relative; margin-bottom: 40px;">

            <input type="text" name="staffs_pets[' . $c . '][pets]" value="' . $slide['pets'] . '" style="display: inline-block; float: left; margin: 0 10px;" />
            <input type="button" class="button remove2 button-primary" value="Remove pet" style=""  /></div>';
                $c++;
            }
        }
    }
    ?>
    <span id="here2"></span>
    <button class="add2 button button-primary"><?php _e('Add pet'); ?></button>
    <script>
        var $ = jQuery.noConflict();
        $(document).ready(function () {
            var count = <?php echo $c; ?>;
            $(".add2").click(function () {
                count += 1;
                $('#here2').append(
                    '<div class="dragNdrop" style="position: relative; margin-bottom: 30px;">' +

                    '<input type="text" name="staffs_pets[' + count + '][pets]" value="" style="display: inline-block; float: left; margin: 0 10px;" />' +
                    '<input type="button" class="button remove2 button-primary" value="Remove pet" style="" /><div/>');
                return false;
            });
            $(".remove2").click(function () {
                $(this).parent().remove();
            });
        });
    </script>
    </div><?php
}
/* When the post is saved, saves our custom data */
function staffs_pets_save_postdata( $post_id ) {
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['petsMeta_noncename'] ) )
        return;
    if ( !wp_verify_nonce( $_POST['petsMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;
    // OK, we're authenticated: we need to find and save the data
    $pets = $_POST['staffs_pets'];
    update_post_meta($post_id,'staffs_pets',$pets);
}
?>