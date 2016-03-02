<?php
/*
Template Name: Staffs page
*/
get_header();
?>
    <main id="main" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <section class="content-block row row-eq-height">
                <div class="left-part col-lg-12 col-md-12 col-sm-12 col-xs-12 vets-filter-page">
                    <div class="text-editor section">
                        <?php the_content(); ?>
                    </div>
                    <div class="vets-filter section">
                    <?php
                    $categories = get_terms('staff-kategoriat');
                    foreach( $categories as $category ): ?>
                        <h3 class="h3"><?php echo $category->name; ?></h3>
                        <?php
                        //select posts in this category (term), and of a specified content type (post type)
                        $args = array(
                            'post_type' => 'staff',
                            'taxonomy' => $category->taxonomy,
                            'term' => $category->slug,
                            'post_parent' => 0,
                            'numberposts' => -1,
                        );
                        $query = new WP_Query( $args );
                        while ( $query->have_posts() ) {
                            $query->the_post();
                            ?>
                            <div class="vets-item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <picture class="thumb">
                                            <?php the_post_thumbnail(); ?>
                                        </picture>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="">
                                            <h3 class="h3"><?php the_title(); ?></h3>
                                            <p class="position"><?php echo get_post_meta($post->ID, "custom_position", true); ?></p>
                                        </div>
                                        <div class="text-editor">
                                            <?php the_content(); ?>
                                        </div>
                                        <div class="row">
                                            <?php $skillsArray = get_post_meta(get_the_ID(), "staffs_skills", true);
                                            if ($skillsArray) {
                                                echo '<div class="col-md-3"><strong>Perehtyneisyys</strong><ul>';
                                                array_unshift($skillsArray, 'removed');
                                                unset($skillsArray[0]);
                                                for ($i = 1; $i <= count($skillsArray); $i++) { ?>
                                                    <li>
                                                        <?php echo $skillsArray[$i]['skills']; ?>
                                                    </li>
                                                <?php }
                                                echo '</ul></div>';
                                            } ?>
                                            <?php $languagesArray = get_post_meta(get_the_ID(), "staffs_languages", true);
                                            if ($languagesArray) {
                                                echo '<div class="col-md-2"><strong>Kielitaito</strong><ul>';
                                                array_unshift($languagesArray, 'removed');
                                                unset($languagesArray[0]);
                                                for ($i = 1; $i <= count($languagesArray); $i++) { ?>
                                                    <li>
                                                        <?php echo $languagesArray[$i]['languages']; ?>
                                                    </li>
                                                <?php }
                                                echo '</ul></div>';
                                            } ?>
                                            <?php $petsArray = get_post_meta(get_the_ID(), "staffs_pets", true);
                                            if ($petsArray) {
                                                echo '<div class="col-md-4 pull-right"><strong>Omat eläimet</strong><ul class="pets">';
                                                array_unshift($petsArray, 'removed');
                                                unset($petsArray[0]);
                                                for ($i = 1; $i <= count($petsArray); $i++) { ?>
                                                    <li class="dog">
                                                        <?php echo $petsArray[$i]['pets']; ?>
                                                    </li>
                                                <?php }
                                                echo '</ul></div>';
                                            } ?>
                                            <!--Show all post that I checked in admin-->
                                            <?php
                                            $clinicsArray = get_post_meta(get_the_ID(), "custom_clinics", true);
                                            if ($clinicsArray) {
                                                $args1 = array(
                                                    'post_type' => 'clinics',
                                                    'posts_per_page' => -1,
                                                    'post_parent' => 0,
                                                    'post__in' => $clinicsArray,
                                                );
                                                $clinics_query = new WP_Query ($args1);
                                                    echo '<div class="col-md-3"><strong>Sijainti</strong><ul>';
                                                    while ($clinics_query->have_posts()) {
                                                        $clinics_query->the_post(); ?>
                                                        <li>
                                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                        </li>
                                                    <?php }
                                                    echo '</ul></div>';
//                                                wp_reset_postdata();
                                            }
                                            ?>
                                            <!--END Show all post that I checked in admin-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endforeach; ?>
                    <?php wp_reset_query(); ?>
                    </div>
                </div>
            </section>
        </div>
    </main>
<?php get_footer('page'); ?>