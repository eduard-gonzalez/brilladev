<?php
/**
 * Template for displaying curriculum tab of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/tabs/curriculum.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.1
 */

defined( 'ABSPATH' ) || exit();

$course = LP_Global::course();
$user   = learn_press_get_current_user();

if ( ! $course || ! $user ) {
	return;
}

$can_view_content_course = $user->can_view_content_course( $course->get_id() );
?>

<div class="course-curriculum" id="learn-press-course-curriculum">
	<div class="curriculum-scrollable">
	<h1>lasda</h1>
		<?php do_action( 'learn-press/before-single-course-curriculum' ); ?>

		<?php
		$curriculum  = $course->get_curriculum();
		$user_course = $user->get_course_data( get_the_ID() );
		$user        = learn_press_get_current_user();

		if ( $curriculum ) :
			?>
			<ul class="curriculum-sections">
				<?php
				foreach ( $curriculum as $section ) {
					$args = [
						'section'                 => $section,
						'can_view_content_course' => $can_view_content_course,
						'user_course'             => $user_course,
						'user'                    => $user,
					];

					learn_press_get_template( 'single-course/loop-section.php', $args );
				}
				?>
			</ul>

		<?php else : ?>
			<div class="curriculum-empty">
				<?php
				echo wp_kses_post(
					apply_filters(
						'learnpress/course/curriculum/empty',
						esc_html__( 'Curriculum is empty', 'learnpress' )
					)
				);
				?>
			</div>
		<?php endif ?>

		<?php do_action( 'learn-press/after-single-course-curriculum' ); ?>

	</div>
</div>
