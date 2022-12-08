<?php

function thim_child_enqueue_styles() {
	wp_enqueue_style( 'thim-parent-style', get_template_directory_uri() . '/style.css', array(), THIM_THEME_VERSION  );
}
add_action( 'wp_enqueue_scripts', 'thim_child_enqueue_styles', 1000 );

add_action( 'wp_enqueue_scripts', 'thim_child_enqueue_styles', 1000 );

function add_login_check()
{
$url = site_url();
    if ( is_user_logged_in() && is_page(16506) ) {
        wp_redirect($url.'/profile');
        exit;
    }
}

add_action('wp', 'add_login_check');

function add_register_check()
{
$url = site_url();
    if ( is_user_logged_in() && is_page(16791) ) {
        wp_redirect($url.'/profile');
        exit;
    }
}
add_action('wp', 'add_register_check');

function add_profile_check_notempty_brilla()
{
global $woocommerce;
$url = site_url();
$items = $woocommerce->cart->get_cart();
if (count($items) > 0 || !empty($items)) {
    if (is_user_logged_in() && is_page( 4519 ) && !is_cart() && !is_checkout()) {
        wp_redirect($url.'/carrito');
        exit; 
    }
}
}
add_action('wp_head', 'add_profile_check_notempty_brilla');


function wpse_131562_redirect() {
    if (! is_user_logged_in()&& ( is_checkout())
    ) {
        wp_redirect($url.'/acceder');
        exit;
    }
}
add_action('wp', 'wpse_131562_redirect'); 

/* redirect profile */
function redirect_profile() {
    if ( is_user_logged_in() && is_page(18) ) {
        wp_redirect($url.'/profile');
        exit;
    }
}
add_action('wp', 'redirect_profile');

/* LEARNPRESS EDUMA AUTOMATIC NEXT LESSON WHEN VIDEO IFRAME ENDED */
add_action( 'wp_footer', 'lp_automatic_next_lesson' );
function lp_automatic_next_lesson() {
    if ( ! is_singular( LP_COURSE_CPT ) ) {
        return;
    }
    ?>
    <script>
        jQuery( document ).ready( function( $ ) {
            $( '.lp-course-item-video iframe' ).on( 'ended', function() {
                $( '.lp-course-item-video iframe' ).off( 'ended' );
                $( '.lp-course-item-video iframe' ).remove();
                $( '.lp-course-item-video' ).html( '<div class="lp-course-item-video-message"><?php _e( 'Video ended', 'learnpress' ); ?></div>' );
                $( '.lp-course-item-video' ).parent().find( '.lp-course-item-next' ).trigger( 'click' );
            } );
        } );
    </script>
    <?php
}

function my_login_logo() { ?>
    <style type="text/css">
        .login h1 a {
            width: auto !important;
            background-image: url("<?php echo get_stylesheet_directory_uri();?>/LOGO.png") !important;
			height: 70px !important;
        }
    </style>
<?php }

add_filter( 'gettext', 'change_woocommerce_return_to_shop_text', 20, 3 );

function change_woocommerce_return_to_shop_text( $translated_text, $text, $domain ) {

        switch ( $translated_text ) {

            case 'Return to shop' :

                $translated_text = __( 'Ver Cursos', 'woocommerce' );
                break;

        }

    return $translated_text;
}
function wc_empty_cart_redirect_url() {
	return 'https://brilla.org.pe/aula-virtual/';
}
add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );



add_action( 'wp_enqueue_scripts', 'custom_scripts_brilla' );
function custom_scripts_brilla() {
    wp_enqueue_script( 'jquery-mask', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/custom/main.js', array( 'jquery' ),'',true );
   
}


add_action( 'register_form', 'add_extra_fields_brilla_registro');
if ( !function_exists( 'add_extra_fields_brilla_registro') ):
    function add_extra_fields_brilla_registro(){
    $option_name = 'woocommerce_default_country' ;
    $new_value = 'PE' ;
    $country = isset( $_POST['billing_country'] ) ? wc_clean( $_POST['billing_country'] ) : apply_filters( 'woocommerce_registration_default_country', 'PE' );
    $state = isset( $_POST['billing_state'] ) ? wc_clean( $_POST['billing_state'] ) : '';
    $states = WC()->countries->get_states( $country );
    $state_field = '';
    $countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    $default_country = $countries_obj->get_base_country();
    $default_county_states = $countries_obj->get_states( $default_country );
    $default_state = $countries_obj->get_base_state();
    $default_city = $countries_obj->get_base_city();
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_script('wc-country-select');
    wp_enqueue_script('wc-address-i18n');
    wp_enqueue_script('wc-city-select');
    wp_enqueue_script('wc-state-select');

    ?>
    <p class="form-row form-row-wide direction-login ">
        <label for="reg_billing_cedula"><?php _e( 'DNI', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="text" class="input-text required" placeholder="00000000" required name="billing_dni" id="reg_billing_dni" value="<?php if ( ! empty( $_POST['billing_dni'] ) ) esc_attr_e( $_POST['billing_cedula'] ); ?>" />
    </p>
    <p class="form-row form-row-wide direction-login ">
        <label for="reg_billing_cedula"><?php _e( 'Fecha de Nacimiento', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="date" class="input-date datepicker required" required name="billing_birthdate" id="reg_billing_birthdate" value="<?php if ( ! empty( $_POST['billing_birthdate'] ) ) esc_attr_e( $_POST['billing_birthdate'] ); ?>" />
    </p>
    <p class="form-row form-row-wide direction-login ">
        <label for="reg_billing_country"><?php _e( 'País', 'woocommerce' ); ?> <span class="required">*</span></label>
        <select name="billing_country" id="reg_billing_country" required class="country_to_state country_select required">
            <?php
            foreach( $countries as $key => $value ){
                echo '<option value="'.$key.'" '.selected( $default_country, $key, false ).'>'.$value.'</option>';
            }
            ?>
        </select>
    </p>
    <?php
    if ( is_array( $states ) && empty( $states ) ) {
        $state_field .= '<input type="hidden" required name="billing_state" id="billing_state" placeholder="' . esc_attr__( 'Departamento', 'woocommerce' ) . '" />';
    } elseif ( is_array( $states ) ) {
        $state_field .= '<select name="billing_state" id="billing_state" required class="woocommerce-Input woocommerce-Input--select input-select" data-placeholder="' . esc_attr__( 'Departamento', 'woocommerce' ) . '">';
        $state_field .= '<option value="">' . esc_html__( 'Departamento', 'woocommerce' ) . '</option>';
        foreach ( $states as $ckey => $cvalue ) {
            $state_field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $state, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
        }
        $state_field .= '</select>';
    } else {
        $state_field .= '<input type="text" required class="input-text" value="' . esc_attr( $state ) . '" placeholder="' . esc_attr__( 'Departamento', 'woocommerce' ) . '" name="billing_state" id="billing_state" />';
    }
    ?>
    
    <p class="form-row form-row-wide direction-login">
        <label for="reg_billing_state"><?php _e( 'Departamento', 'woocommerce' ); ?> <span class="required">*</span></label>
        <?php echo $state_field; ?>
    </p>
    <p class="form-row form-row-wide direction-login">
        <label for="reg_billing_city"><?php _e( 'Ciudad', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="text" class="input-text required" required name="billing_city" id="reg_billing_city" value="<?php if ( ! empty( $_POST['billing_city'] ) ) esc_attr_e( $_POST['billing_city'] ); ?>" />  
    </p>

    <?php

    }
endif;

add_filter( 'registration_errors', 'registration_process_validation', 10, 3 );
function registration_process_validation( $errors, $sanitized_user_login, $user_email ) 
{
    if ( empty( $_POST['billing_dni'] ) || ! empty( $_POST['billing_dni'] ) && trim( $_POST['billing_dni'] ) =='' ) {
        $errors->add( 'billing_dni', __( 'Por favor, ingrese su DNI.' ) );
    }
    if ( empty( $_POST['billing_birthdate'] ) || ! empty( $_POST['billing_birthdate'] ) && trim( $_POST['billing_birthdate'] ) =='' ) {
        $errors->add( 'billing_birthdate', __( 'Por favor, proporciona tu fecha de nacimiento.' ) );
    }
    if ( empty( $_POST['billing_country'] ) || ! empty( $_POST['billing_country'] ) && trim( $_POST['billing_country'] ) =='' ) {
        $errors->add( 'billing_country', __( 'Por favor, selecciona un país.' ) );
    }
    if ( empty( $_POST['billing_state'] ) || ! empty( $_POST['billing_state'] ) && trim( $_POST['billing_state'] ) =='' ) {
        $errors->add( 'billing_state', __( 'Por favor, selecciona un departamento.' ) );
    }
    if ( empty( $_POST['billing_city'] ) || ! empty( $_POST['billing_city'] ) && trim( $_POST['billing_city'] ) =='' ) {
        $errors->add( 'billing_city', __( 'Por favor, proporciona tu ciudad.' ) );
    }
    return $errors;
}

add_action('user_register','brilla_save_user_register_fields');
function brilla_save_user_register_fields( $user_id ){
        $user_data = array();
        $user_data['ID'] = $user_id;
        if( !empty( $_POST['billing_dni'] ) ):
         update_user_meta( $user_id, 'billing_dni', $_POST['billing_dni'] );
        endif;
        if( !empty( $_POST['billing_birthdate'] ) ):
         update_user_meta( $user_id, 'billing_birthdate', $_POST['billing_birthdate'] );
        endif;
        if( !empty( $_POST['billing_country'] ) ):
         update_user_meta( $user_id, 'billing_country', $_POST['billing_country'] );
        endif;
        if( !empty( $_POST['billing_state'] ) ):
         update_user_meta( $user_id, 'billing_state', $_POST['billing_state'] );
        endif;
        if( !empty( $_POST['billing_city'] ) ):
         update_user_meta( $user_id, 'billing_city', $_POST['billing_city'] );
        endif;
        
}
add_action( 'learn-press/end-profile-basic-information-fields', 'brilla_add_extra_fieldsuserprofile' ) ;

function brilla_add_extra_fieldsuserprofile(){

    $option_name = 'woocommerce_default_country' ;
    $new_value = 'PE' ;
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_script('wc-country-select');
    wp_enqueue_script('wc-address-i18n');
    wp_enqueue_script('wc-city-select');
    wp_enqueue_script('wc-state-select');
    $profile = LP_Profile::instance();
    if (! isset($section)) {
        $section = 'basic-information';
    }

    $user = $profile->get_user();
    $user_id = $user->get_id();
    $billing_dni = get_user_meta($user_id, 'billing_dni', true);
    $billing_birthdate = get_user_meta($user_id, 'billing_birthdate', true);
    $billing_country = get_user_meta($user_id, 'billing_country', true);
    $billing_state = get_user_meta($user_id, 'billing_state', true);
    $billing_city = get_user_meta($user_id, 'billing_city', true);

    if (!empty($billing_dni)) {
        $author_dni = $billing_dni;
    }
    if (!empty($billing_birthdate)) {
        $author_birthdate = $billing_birthdate;
    }
    if (!empty($billing_country)) {
        $author_country = $billing_country;
    }
    if (!empty($billing_state)) {
        $author_state = $billing_state;
    }
    if (!empty($billing_city)) {
        $author_city = $billing_city;
    }

    $country = $author_country;
    $state = $author_state;
    $states = WC()->countries->get_states( $country );
    $state_field = '';
    $countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    $default_country = $countries_obj->get_base_country();
    $default_county_states = $countries_obj->get_states( $default_country );
    $default_state = $countries_obj->get_base_state();
    $default_city = $countries_obj->get_base_city();
    ?>
    <li class="form-field form-field__50">
        <p class="form-row form-row-wide">
        <label for="billing_dni"><?php _e('DNI', 'woocommerce'); ?></label>
        <input type="text" class="input-text required" name="billing_dni" id="billing_dni" required value="<?php echo $author_dni; ?>" />
        </p>
    </li>
    <li class="form-field form-field__50">
    <p class="form-row form-row-wide">
        <label for="billing_birthdate"><?php _e('Fecha de nacimiento', 'woocommerce'); ?></label>
        <input type="date" class="input-text required" name="billing_birthdate" id="billing_birthdate" required value="<?php echo $author_birthdate; ?>" />
    </p>
    </li>
    <li class="form-field form-field__50"></li>
        <p class="form-row form-row-wide ">
            <label for="reg_billing_country"><?php _e( 'País', 'woocommerce' ); ?> <span class="required">*</span></label>
            <select name="billing_country" id="reg_billing_country" class="country_to_state country_select">
                <?php
                foreach( $countries as $key => $value ){
                    echo '<option value="'.$key.'" '.selected( $author_country, $key, false ).'>'.$value.'</option>';
                }
                ?>
            </select>
        </p>
   </li>
    <li class="form-field form-field__50"></li>
    <?php
    if ( is_array( $states ) && empty( $states ) ) {
        $state_field .= '<input type="hidden" name="billing_state" id="billing_state" placeholder="' . esc_attr__( 'Departamento', 'woocommerce' ) . '" />';
    } elseif ( is_array( $states ) ) {
        $state_field .= '<select name="billing_state" id="billing_state" class="woocommerce-Input woocommerce-Input--select input-select" data-placeholder="' . esc_attr__( 'Departamento', 'woocommerce' ) . '">';
        $state_field .= '<option value="">' . esc_html__( 'Departamento', 'woocommerce' ) . '</option>';
        foreach ( $states as $ckey => $cvalue ) {
            $state_field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $state, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
        }
        $state_field .= '</select>';
    } else {
        $state_field .= '<input type="text" class="input-text" value="' . esc_attr( $state ) . '" placeholder="' . esc_attr__( 'Departamento', 'woocommerce' ) . '" name="billing_state" id="billing_state" />';
    }
    ?>
    
    <p class="form-row form-row-wide">
        <label for="reg_billing_state"><?php _e( 'Departamento', 'woocommerce' ); ?> <span class="required">*</span></label>
        <?php echo $state_field; ?>
    </p>
   </li>
    <li class="form-field form-field__50">
        <p class="form-row form-row-wide">
        <label for="billing_city"><?php _e('Ciudad', 'woocommerce'); ?></label>
        <input type="text" class="input-text validate required" name="billing_city" id="billing_city" required value="<?php echo $author_city; ?>" />
        </p>
    </li>
    <?php
 }

 
 add_filter( 'woocommerce_checkout_fields' , 'brilla_custom_override_checkout_fields' );
function brilla_custom_override_checkout_fields( $fields ) {
    if (is_user_logged_in()) {
        $profile = LP_Profile::instance();
        $user = $profile->get_user();
        $user_id = $user->get_id();
        $nombre = $user->get_first_name();
        $apellido = $user->get_last_name();
        $pais = get_user_meta($user_id, 'billing_country', true);
        $departamento = get_user_meta($user_id, 'billing_state', true);
        $ciudad = get_user_meta($user_id, 'billing_city', true);
        $fields['billing']['billing_first_name']['default'] = $nombre;
        $fields['billing']['billing_last_name']['default'] = $apellido;
        $fields['billing']['billing_country']['default'] = $pais;
        $fields['billing']['billing_state']['default'] = $departamento;
        $fields['billing']['billing_city']['default'] = $ciudad;
        echo $pais;

    }
     unset($fields['order']['order_comments']);
     unset($fields['billing']['billing_postcode']);
     unset($fields['billing']['billing_address_2']);
     return $fields;
}
add_filter( 'default_checkout_billing_country', 'change_default_checkout_country' );
function change_default_checkout_country() {
    if (is_user_logged_in()) {
        $profile = LP_Profile::instance();
        $user = $profile->get_user();
        $user_id = $user->get_id();
        $pais = get_user_meta($user_id, 'billing_country', true);
        return $pais;
    }else{
        return 'PE';
    }
}
add_filter( 'default_checkout_billing_state', 'change_default_checkout_state' );
function change_default_checkout_state() {
    if (is_user_logged_in()) {
        $profile = LP_Profile::instance();
        $user = $profile->get_user();
        $user_id = $user->get_id();
        $departamento = get_user_meta($user_id, 'billing_state', true);
        return $departamento;
    }else{
        return 'Lima';
    }
}
/* shortcode get user name brilla*/
add_shortcode('get_user_namebrilla', 'get_user_namebrilla');
function get_user_namebrilla() {
    if (is_user_logged_in()) {
        $profile = LP_Profile::instance();
        $user = $profile->get_user();
        $user_id = $user->get_id();
        $nombre = $user->get_first_name();
        $apellido = $user->get_last_name();
        $user_name = $nombre . ' ' . $apellido;
        return $user_name;
    }
}
add_action('wp_footer', 'get_user_name_js');
function get_user_name_js() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            console.log("ready!");
            const user_name_display_name = '<?php echo get_user_namebrilla(); ?>';
            if (user_name_display_name !== '') {
                console.log('MI USUARIO' + user_name_display_name);
               
                $('#userinfo-profile > div > .thim-login-popup > a.profile').html(`<i aria-hidden="true" class="far fa-user"></i> ${user_name_display_name}`);
                $('#learn-press-course-curriculum > div > ul.curriculum-sections > li.section-content').show();
            }
            else{
                console.log('NO HAY USUARIO');
                $('.course-item').hide();
            }
            $('.quiz-intro-item--duration > item__title').text('Duración');
            $('.quiz-intro-item--questions-count > .quiz-intro-item__title').text('Preguntas');
            $('.quiz-intro-item--passing-grade > .quiz-intro-item__title').text('Nota de aprobación');
            $('.lp-button.start').text('Iniciar');

            
            /* translate text count-questions quiz item */
            $('.quiz-intro-item--questions-count > .quiz-intro-item__title').text('Preguntas');

            
        });
    </script>
    <?php
}

/* add css when user logged in and when user not logged in */
add_action('wp_head', 'add_css_user_logged_in');
function add_css_user_logged_in() {
    if (is_user_logged_in()) {
        ?>
        <style>
            .course-item {
                display: block !important;
            }
            li.students-feature{
                display: none !important;
            }
            li.skill-feature{
                display: none !important;
            }
        </style>
        <?php
    }else{
        ?>
        <style>
            .course-item {
                display: none !important;
            }
            li.students-feature{
                display: none !important;
            }
            li.skill-feature{
                display: none !important;
            }
        </style>
        <?php
    }
}

