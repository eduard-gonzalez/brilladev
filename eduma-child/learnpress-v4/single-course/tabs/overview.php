<?php
/**
 * Template for displaying overview tab of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/tabs/overview.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$course = learn_press_get_course();
if ( ! $course ) {
	return;
}
?>

<div class="course-description" id="learn-press-course-description">

	<?php
	/**
	 * @deprecated
	 */
	do_action( 'learn_press_begin_single_course_description' );

	/**
	 * @since 4.0.0
	 */
	do_action( 'learn-press/before-single-course-description' );

	?>
<?php
global $post;
$course      = learn_press_get_course();
$media_intro = get_post_meta( $post->ID, 'thim_course_media_intro', true );
 ?>

<div class="course-thumbnail">
	<?php
    if ( !empty( $media_intro ) ) {
        ?>
        <div class="media-intro">
            <?php
			if ( wp_oembed_get( $media_intro ) ) {
				echo '<div class="responsive-iframe">' . wp_oembed_get( $media_intro ) . '</div>';
			} else {
				echo str_replace(
					array( "<iframe", "</iframe>" ), array(
					'<div class="responsive-iframe"><iframe',
					"</iframe></div>"
				), do_shortcode( $media_intro )
				);
			}
          ?>
        </div>
        <?php
    }  elseif ( has_post_thumbnail() ) {
        $image_title   = get_the_title( get_post_thumbnail_id() ) ? esc_attr( get_the_title( get_post_thumbnail_id() ) ) : '';
        $image_caption = get_post( get_post_thumbnail_id() ) ? esc_attr( get_post( get_post_thumbnail_id() )->post_excerpt ) : '""';
        $image_link    = wp_get_attachment_url( get_post_thumbnail_id() );
        $image         = get_the_post_thumbnail( $post->ID, 'full', array(
            'title' => $image_title,
            'alt'   => $image_title
        ) );

        echo apply_filters(
            'learn_press_single_course_image_html',
            sprintf( '%s', $image ),
            $post->ID
        );
    }
	?>
</div>


	<div class="thim-course-content">
		<div class="container-title">
			<h3 class="title-custom-single-course">Descripci&oacute;n</h3>
		</div>
		<div class="content-custom-single-course">
			<?php the_content(); ?>
		</div>
	</div>

	<?php
	/**
	 * @since  4.5.6
	 *         thim_course_info
	 */
	do_action( 'thim_course_info_right' );

	/**
	 * @since 4.0.0
	 */
	do_action( 'learn-press/after-single-course-description' );

	/**
	 * @deprecated
	 */
	do_action( 'learn_press_end_single_course_description' );
	?>

</div>
