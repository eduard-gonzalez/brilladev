<?php
/**
 * Template for displaying own courses in courses tab of user profile page.
 * Edit by Nhamdv
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.10
 */

defined( 'ABSPATH' ) || exit();

if ( ! isset( $user ) || ! isset( $course_ids ) || ! isset( $current_page ) || ! isset( $num_pages ) ) {
	return;
}
?>

<?php if ( $current_page === 1 ) : ?>
<div class="lp_profile_course_progress">
	<div class="lp_profile_course_progress__item lp_profile_course_progress__header">
		<div></div>
		<div><?php esc_html_e( 'Name', 'learnpress' ); ?></div>
		<!-- User Progress -->
		<div><?php esc_html_e( 'Progreso', 'learnpress' ); ?></div>

		<div><?php esc_html_e( 'Result', 'learnpress' ); ?></div>
<!-- 		<div><?php // esc_html_e( 'Expiration time', 'learnpress' ); ?></div>
 -->		<div><?php esc_html_e( 'End time', 'learnpress' ); ?></div>
	</div>
	<?php endif; ?>

	<?php
	global $post;

foreach ($course_ids as $id) {
    $course = learn_press_get_course($id);

    if (! $course) {
        continue;
    }

    $post = get_post($id);
    setup_postdata($post);

    $course_data   = $user->get_course_data($id);
    $course_result = $course_data->get_result();
    ?>
		<div class="lp_profile_course_progress__item">
			<div>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php echo wp_kses_post($course->get_image('course_thumbnail')); ?>
				</a>
			</div>
			<div><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
			<div><?php echo esc_html($course_result['pass']); ?> de <?php echo esc_html($course_result['count_items']); ?> completados</div>
			<div><?php echo esc_html($course_result['result']); ?>%</div>
			<div><?php echo ! empty( $course_data->get_end_time() ) ? $course_data->get_end_time() : '-'; ?></div>
		</div>
		<?php
	}

	wp_reset_postdata();
	?>

	<?php if ( $current_page === 1 ) : ?>
</div>
<?php endif; ?>

<?php if ( $num_pages > 1 && $current_page < $num_pages && $current_page === 1 ) : ?>
	<div class="lp_profile_course_progress__nav">
		<button data-paged="<?php echo absint( $current_page + 1 ); ?>"
				data-number="<?php echo absint( $num_pages ); ?>"><?php esc_html_e( 'View more', 'learnpress' ); ?></button>
	</div>
<?php endif; 

/* ADD a custom LINK TO ANOTHER PAGE */
?>
<a href="https://brilla.org.pe/aula-virtual" class="lp-button button" >Ver m&aacute;s cursos</a>
