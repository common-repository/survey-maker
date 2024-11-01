<?php
    $ays_tab = 'tab1';
    if(isset($_GET['tab'])){
        $ays_tab = $_GET['tab'];
    }

    $action = (isset($_GET['action'])) ? sanitize_text_field($_GET['action']) : '';

    $id = (isset($_GET['id'])) ? absint(intval($_GET['id'])) : null;

    $html_name_prefix = 'ays_';
    $name_prefix = 'survey_';

    $user_id = get_current_user_id();

    $options = array(
        // Styles Tab
        'survey_theme' => 'classic_light',
        'survey_color' => 'rgb(255, 87, 34)', // #673ab7
        'survey_background_color' => '#fff',
        'survey_text_color' => '#333',
        'survey_buttons_text_color' => '#333',
        'survey_width' => '',
        'survey_width_by_percentage_px' => 'pixels',
        'survey_custom_class' => '',
        'survey_custom_css' => '',
        'survey_question_font_size' => 16,
        'survey_question_image_width' => '',
        'survey_question_image_height' => '',
        'survey_question_image_sizing' => 'cover',
        'survey_answer_font_size' => 15,
        'survey_answers_view' => 'list',
        'survey_answers_object_fit' => 'cover',
        'survey_answers_padding' => 10,
        'survey_answers_gap' => 10,

        'survey_buttons_size' => 'medium',
        'survey_buttons_font_size' => 17,
        'survey_buttons_left_right_padding' => 20,
        'survey_buttons_top_bottom_padding' => 10,
        'survey_buttons_border_radius' => 3,

        // Settings Tab
        'survey_show_title' => 'on',
        'survey_enable_randomize_answers' => 'off',
        'survey_enable_randomize_questions' => 'off',
        'survey_enable_leave_page' => 'on',

        // Result Settings Tab
        'survey_redirect_after_submit' => 'off',
        'survey_submit_redirect_url' => '',
        'survey_submit_redirect_delay' => '',
        'survey_enable_exit_button' => 'off',
        'survey_exit_redirect_url' => '',
        'survey_final_result_text' => '',
        'survey_loader' => 'default',

        // Limitation Tab
        'survey_limit_users' => 'off',
        'survey_limit_users_by' => 'ip',
        'survey_limitation_message' => '',
        'survey_enable_logged_users' => 'off',
        'survey_logged_in_message' => '',

        // E-Mail Tab
        'survey_enable_mail_user' => 'off',
        'survey_mail_message' => '',
        'survey_enable_mail_admin' => 'off',
        'survey_send_mail_to_site_admin' => 'on',
        'survey_additional_emails' => '',
        'survey_mail_message_admin' => '',
        'survey_email_configuration_from_email' => '',
        'survey_email_configuration_from_name' => '',
        'survey_email_configuration_from_subject' => '',
        'survey_email_configuration_replyto_email' => '',
        'survey_email_configuration_replyto_name' => '',

    );

    $object = array(
        'author_id' => $user_id,
        'title' => '',
        'description' => '',
        'category_ids' => '',
        'question_ids' => '',
        'date_created' => current_time( 'mysql' ),
        'date_modified' => current_time( 'mysql' ),
        'image' => '',
        'status' => 'published',
        'ordering' => '0',
        'post_id' => '0',
        'section_ids' => '',
        'options' => json_encode($options),
    );

    $heading = '';
    $survey_settings = $this->settings_obj;
    switch ($action) {
        case 'add':
            $heading = __( 'Add new survey', $this->plugin_name );
            $survey_default_options = ($survey_settings->ays_get_setting('survey_default_options') === false) ? json_encode(array()) : $survey_settings->ays_get_setting('survey_default_options');
            if (! empty($survey_default_options)) {
                $object['options'] = $survey_default_options;
            }
            break;
        case 'edit':
            $heading = __( 'Edit survey', $this->plugin_name );
            $object = $this->surveys_obj->get_item_by_id( $id );
            break;
    }

    if (isset($_POST['ays_submit']) || isset($_POST['ays_submit_top'])) {
        $_POST["id"] = $id;
        $this->surveys_obj->add_or_edit_item();
    }

    if(isset($_POST['ays_apply']) || isset($_POST['ays_apply_top'])){
        $_POST["id"] = $id;
        $_POST['save_type'] = 'apply';
        $this->surveys_obj->add_or_edit_item();
    }

    if(isset($_POST['ays_save_new']) || isset($_POST['ays_save_new_top'])){
        $_POST["id"] = $id;
        $_POST['save_type'] = 'save_new';
        $this->surveys_obj->add_or_edit_item();
    }

    if (isset($_POST['ays_default'])) {
        $_POST["id"] = $id;
        $_POST['save_type'] = 'apply';
        $_POST['save_type_default_options'] = 'save_type_default_options';
        $this->surveys_obj->add_or_edit_item();
    }

    $ays_super_admin_email = get_option('admin_email');
    $wp_general_settings_url = admin_url( 'options-general.php' ) ;

    // Options
    $options = isset( $object['options'] ) && $object['options'] != '' ? $object['options'] : '';
    $options = json_decode( $options, true );

    // Author ID
    $author_id = isset( $object['author_id'] ) && $object['author_id'] != '' ? intval( $object['author_id'] ) : $user_id;
    
    // Title
    $title = isset( $object['title'] ) && $object['title'] != '' ? stripslashes( htmlentities( $object['title'] ) ) : '';
    
    // Description
    $description = isset( $object['description'] ) && $object['description'] != '' ? stripslashes( htmlentities( $object['description'] ) ) : '';
    
    // Status
    $status = isset( $object['status'] ) && $object['status'] != '' ? stripslashes( $object['status'] ) : 'published';
    
    // Date created
    $date_created = isset( $object['date_created'] ) && Survey_Maker_Admin::validateDate( $object['date_created'] ) ? $object['date_created'] : current_time( 'mysql' );
    
    // Date modified
    $date_modified = current_time( 'mysql' );

    // Survey categories IDs
    $categories = $this->surveys_obj->get_categories();

    // Survey categories IDs
    $category_ids = isset( $object['category_ids'] ) && $object['category_ids'] != '' ? $object['category_ids'] : '';
    $category_ids = $category_ids == '' ? array() : explode( ',', $category_ids );

    // Survey questions IDs
    $question_ids = isset( $object['question_ids'] ) && $object['question_ids'] != '' ? $object['question_ids'] : '';
    // $question_ids = $question_ids == '' ? array() : explode( ',', $question_ids );

    // Survey image
    $image = isset( $object['image'] ) && $object['image'] != '' ? $object['image'] : '';

    // Post ID
    $post_id = isset( $object['post_id'] ) && ! empty( $object['post_id'] ) ? intval( $object['post_id'] ) : 0;

    // Section Ids
    $sections_ids = (isset( $object['section_ids' ] ) && $object['section_ids'] != '') ? $object['section_ids'] : '';

    $sections = Survey_Maker_Data::get_sections_by_survey_id($sections_ids);
    $sections_count = count( $sections );

    $multiple_sections = $sections_count > 1 ? true : false;

    $question_types = array(
        "radio" => __("Radio", $this->plugin_name),
        "checkbox" => __("Checkbox( Multiple )", $this->plugin_name),
        "select" => __("Dropdown", $this->plugin_name),
        "text" => __("Paragraph", $this->plugin_name),
        "short_text" => __("Short Text", $this->plugin_name),
        "number" => __("Number", $this->plugin_name),
        "email" => __("Email", $this->plugin_name),
        "name" => __("Name", $this->plugin_name),
    );
    
    $question_types_placeholders = array(
        "radio" => '',
        "checkbox" => '',
        "select" => '',
        "text" => __("Long answer text", $this->plugin_name),
        "short_text" => __("Short answer text", $this->plugin_name),
        "number" => __("Number answer text", $this->plugin_name),
        "email" => __("Email field", $this->plugin_name),
        "name" => __("Name field", $this->plugin_name),
    );

    $text_question_types = array(
        "text",
        "short_text",
        "number",
        "email",
        "name",
    );

    foreach ($sections as $section_key => $section) {
        $sections[$section_key]['title'] = (isset($section['title']) && $section['title'] != '') ? stripslashes( htmlentities( $section['title'] ) ) : '';
        $sections[$section_key]['description'] = (isset($section['description']) && $section['description'] != '') ? stripslashes( htmlentities( $section['description'] ) ) : '';

        $section_questions = Survey_Maker_Data::get_questions_by_section_id( intval( $section['id'] ), $question_ids );

        foreach ($section_questions as $question_key => $question) {
            $section_questions[$question_key]['question'] = (isset($question['question']) && $question['question'] != '') ? stripslashes( htmlentities( $question['question'] ) ) : '';
            $section_questions[$question_key]['image'] = (isset($question['image']) && $question['image'] != '') ? $question['image'] : '';
            $section_questions[$question_key]['type'] = (isset($question['type']) && $question['type'] != '') ? $question['type'] : 'radio';
            $section_questions[$question_key]['user_variant'] = (isset($question['user_variant']) && $question['user_variant'] == 'on') ? true : false;

            $opts = json_decode( $question['options'], true );
            $opts['required'] = (isset($opts['required']) && $opts['required'] == 'on') ? true : false;

            $q_answers = Survey_Maker_Data::get_answers_by_question_id( intval( $question['id'] ) );

            foreach ($q_answers as $answer_key => $answer) {
                $q_answers[$answer_key]['answer'] = (isset($answer['answer']) && $answer['answer'] != '') ? stripslashes( htmlentities( $answer['answer'] ) ) : '';
                $q_answers[$answer_key]['image'] = (isset($answer['image']) && $answer['image'] != '') ? $answer['image'] : '';
                $q_answers[$answer_key]['placeholder'] = (isset($answer['placeholder']) && $answer['placeholder'] != '') ? $answer['placeholder'] : '';
            }

            $section_questions[$question_key]['answers'] = $q_answers;

            $section_questions[$question_key]['options'] = $opts;
        }

        $sections[$section_key]['questions'] = $section_questions;
    }

        // =======================  //  ======================= // ======================= // ======================= // ======================= //

    // =============================================================
    // ======================    Styles Tab    =====================
    // ========================    START    ========================


    // Survey Theme
    $survey_theme = (isset($options[ $name_prefix . 'theme' ]) && $options[ $name_prefix . 'theme' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'theme' ] ) ) : 'classic_light';

    // Survey Color
    $survey_color = (isset($options[ $name_prefix . 'color' ]) && $options[ $name_prefix . 'color' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'color' ] ) ) : 'rgb(255, 87, 34)'; // #673ab7

    // Background color
    $survey_background_color = (isset($options[ $name_prefix . 'background_color' ]) && $options[ $name_prefix . 'background_color' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'background_color' ] ) ) : '#fff';

    // Text Color
    $survey_text_color = (isset($options[ $name_prefix . 'text_color' ]) && $options[ $name_prefix . 'text_color' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'text_color' ] ) ) : '#333';

    // Buttons text Color
    $survey_buttons_text_color = (isset($options[ $name_prefix . 'buttons_text_color' ]) && $options[ $name_prefix . 'buttons_text_color' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'buttons_text_color' ] ) ) : $survey_text_color;

    // Width
    $survey_width = (isset($options[ $name_prefix . 'width' ]) && $options[ $name_prefix . 'width' ] != '') ? absint ( intval( $options[ $name_prefix . 'width' ] ) ) : '';


    // Survey Width by percentage or pixels
    $survey_width_by_percentage_px = (isset($options[ $name_prefix . 'width_by_percentage_px' ]) && $options[ $name_prefix . 'width_by_percentage_px' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'width_by_percentage_px' ] ) ) : 'percentage';

    // Custom class for survey container
    $survey_custom_class = (isset($options[ $name_prefix . 'custom_class' ]) && $options[ $name_prefix . 'custom_class' ] != '') ? stripslashes ( esc_attr( $options[ $name_prefix . 'custom_class' ] ) ) : '';

    // Custom CSS
    $survey_custom_css = (isset($options[ $name_prefix . 'custom_css' ]) && $options[ $name_prefix . 'custom_css' ] != '') ? stripslashes ( esc_attr( $options[ $name_prefix . 'custom_css' ] ) ) : '';


    // =========== Questions Styles Start ===========

    // Question font size
    $survey_question_font_size = (isset($options[ $name_prefix . 'question_font_size' ]) && $options[ $name_prefix . 'question_font_size' ] != '') ? absint ( intval( $options[ $name_prefix . 'question_font_size' ] ) ) : 16;

    // Question Image Width
    $survey_question_image_width = (isset($options[ $name_prefix . 'question_image_width' ]) && $options[ $name_prefix . 'question_image_width' ] != '') ? absint ( intval( $options[ $name_prefix . 'question_image_width' ] ) ) : '';

    // Question Image Height
    $survey_question_image_height = (isset($options[ $name_prefix . 'question_image_height' ]) && $options[ $name_prefix . 'question_image_height' ] != '') ? absint ( intval( $options[ $name_prefix . 'question_image_height' ] ) ) : '';

    // Question Image sizing
    $survey_question_image_sizing = (isset($options[ $name_prefix . 'question_image_sizing' ]) && $options[ $name_prefix . 'question_image_sizing' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'question_image_sizing' ] ) ) : 'cover';

    // =========== Questions Styles End   =========== 

    // =========== Answers Styles Start ===========

    // Answer font size
    $survey_answer_font_size = (isset($options[ $name_prefix . 'answer_font_size' ]) && $options[ $name_prefix . 'answer_font_size' ] != '') ? absint ( intval( $options[ $name_prefix . 'answer_font_size' ] ) ) : 15;

    // Answer view
    $survey_answers_view = (isset($options[ $name_prefix . 'answers_view' ]) && $options[ $name_prefix . 'answers_view' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'answers_view' ] ) ) : 'list';

    // Answer object-fit
    $survey_answers_object_fit = (isset($options[ $name_prefix . 'answers_object_fit' ]) && $options[ $name_prefix . 'answers_object_fit' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'answers_object_fit' ] ) ) : 'cover';

    // Answer padding
    $survey_answers_padding = (isset($options[ $name_prefix . 'answers_padding' ]) && $options[ $name_prefix . 'answers_padding' ] != '') ? absint ( intval( $options[ $name_prefix . 'answers_padding' ] ) ) : 10;

    // Answer Gap
    $survey_answers_gap = (isset($options[ $name_prefix . 'answers_gap' ]) && $options[ $name_prefix . 'answers_gap' ] != '') ? absint ( intval( $options[ $name_prefix . 'answers_gap' ] ) ) : 10;


    // =========== Answers Styles End   ===========


    // =========== Buttons Styles Start ===========

    // Buttons size
    $survey_buttons_size = (isset($options[ $name_prefix . 'buttons_size' ]) && $options[ $name_prefix . 'buttons_size' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'buttons_size' ] ) ) : 'medium';

    // Buttons font size
    $survey_buttons_font_size = (isset($options[ $name_prefix . 'buttons_font_size' ]) && $options[ $name_prefix . 'buttons_font_size' ] != '') ? absint ( intval( $options[ $name_prefix . 'buttons_font_size' ] ) ) : 14;

    // Buttons Left / Right padding
    $survey_buttons_left_right_padding = (isset($options[ $name_prefix . 'buttons_left_right_padding' ]) && $options[ $name_prefix . 'buttons_left_right_padding' ] != '') ? absint ( intval( $options[ $name_prefix . 'buttons_left_right_padding' ] ) ) : 24;

    // Buttons Top / Bottom padding
    $survey_buttons_top_bottom_padding = (isset($options[ $name_prefix . 'buttons_top_bottom_padding' ]) && $options[ $name_prefix . 'buttons_top_bottom_padding' ] != '') ? absint ( intval( $options[ $name_prefix . 'buttons_top_bottom_padding' ] ) ) : 0;

    // Buttons border radius
    $survey_buttons_border_radius = (isset($options[ $name_prefix . 'buttons_border_radius' ]) && $options[ $name_prefix . 'buttons_border_radius' ] != '') ? absint ( intval( $options[ $name_prefix . 'buttons_border_radius' ] ) ) : 4;

    // ===========  Buttons Styles End  ===========


    // =============================================================
    // ======================    Styles Tab    =====================
    // ========================     END     ========================

    // =======================  //  ======================= // ======================= // ======================= // ======================= //

    // =============================================================
    // ======================  Settings Tab  =======================
    // ========================    START   =========================

    // Show survey title
    $options[ $name_prefix . 'show_title' ] = isset($options[ $name_prefix . 'show_title' ]) ? $options[ $name_prefix . 'show_title' ] : 'on';
    $survey_show_title = (isset($options[ $name_prefix . 'show_title' ]) && $options[ $name_prefix . 'show_title' ] == 'on') ? true : false;

    // Enable randomize answers
    $options[ $name_prefix . 'enable_randomize_answers' ] = isset($options[ $name_prefix . 'enable_randomize_answers' ]) ? $options[ $name_prefix . 'enable_randomize_answers' ] : 'off';
    $survey_enable_randomize_answers = (isset($options[ $name_prefix . 'enable_randomize_answers' ]) && $options[ $name_prefix . 'enable_randomize_answers' ] == 'on') ? true : false;

    // Enable randomize questions
    $options[ $name_prefix . 'enable_randomize_questions' ] = isset($options[ $name_prefix . 'enable_randomize_questions' ]) ? $options[ $name_prefix . 'enable_randomize_questions' ] : 'off';
    $survey_enable_randomize_questions = (isset($options[ $name_prefix . 'enable_randomize_questions' ]) && $options[ $name_prefix . 'enable_randomize_questions' ] == 'on') ? true : false;

    // Enable confirmation box for leaving the page
    $options[ $name_prefix . 'enable_leave_page' ] = isset($options[ $name_prefix . 'enable_leave_page' ]) ? $options[ $name_prefix . 'enable_leave_page' ] : 'on';
    $survey_enable_leave_page = (isset($options[ $name_prefix . 'enable_leave_page' ]) && $options[ $name_prefix . 'enable_leave_page' ] == 'on') ? true : false;

    // Enable clear answer button
    $options[ $name_prefix . 'enable_clear_answer' ] = isset($options[ $name_prefix . 'enable_clear_answer' ]) ? $options[ $name_prefix . 'enable_clear_answer' ] : 'off';
    $survey_enable_clear_answer = (isset($options[ $name_prefix . 'enable_clear_answer' ]) && $options[ $name_prefix . 'enable_clear_answer' ] == 'on') ? true : false;


    // =============================================================
    // =================== Results Settings Tab  ===================
    // ========================    START   =========================


    // Redirect after submit
    $options[ $name_prefix . 'redirect_after_submit' ] = isset($options[ $name_prefix . 'redirect_after_submit' ]) ? $options[ $name_prefix . 'redirect_after_submit' ] : 'off';
    $survey_redirect_after_submit = (isset($options[ $name_prefix . 'redirect_after_submit' ]) && $options[ $name_prefix . 'redirect_after_submit' ] == 'on') ? true : false;

    // Redirect URL
    $survey_submit_redirect_url = (isset($options[ $name_prefix . 'submit_redirect_url' ]) && $options[ $name_prefix . 'submit_redirect_url' ] != '') ? stripslashes ( esc_url( $options[ $name_prefix . 'submit_redirect_url' ] ) ) : '';

    // Redirect delay (sec)
    $survey_submit_redirect_delay = (isset($options[ $name_prefix . 'submit_redirect_delay' ]) && $options[ $name_prefix . 'submit_redirect_delay' ] != '') ? absint ( intval( $options[ $name_prefix . 'submit_redirect_delay' ] ) ) : '';

    // Enable EXIT button
    $options[ $name_prefix . 'enable_exit_button' ] = isset($options[ $name_prefix . 'enable_exit_button' ]) ? $options[ $name_prefix . 'enable_exit_button' ] : 'off';
    $survey_enable_exit_button = (isset($options[ $name_prefix . 'enable_exit_button' ]) && $options[ $name_prefix . 'enable_exit_button' ] == 'on') ? true : false;

    // Redirect URL
    $survey_exit_redirect_url = (isset($options[ $name_prefix . 'exit_redirect_url' ]) && $options[ $name_prefix . 'exit_redirect_url' ] != '') ? stripslashes ( esc_url( $options[ $name_prefix . 'exit_redirect_url' ] ) ) : '';

    // Thank you message
    $ays_survey_final_result_text = (isset($options[ $name_prefix . 'final_result_text' ]) &&  $options[ $name_prefix . 'final_result_text' ] != '') ? stripslashes( wpautop( $options[ $name_prefix . 'final_result_text' ] ) ) : '';

    // Select survey loader
    $survey_loader = (isset($options[ $name_prefix . 'loader' ]) && $options[ $name_prefix . 'loader' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'loader' ] ) ) : 'default';



    // =============================================================
    // =================== Results Settings Tab  ===================
    // ========================    END    ==========================

    // =======================  //  ======================= // ======================= // ======================= // ======================= //

    // =============================================================
    // ===================    Limitation Tab     ===================
    // ========================    START   =========================

    // Maximum number of attempts per user
    $options[ $name_prefix . 'limit_users' ] = isset($options[ $name_prefix . 'limit_users' ]) ? $options[ $name_prefix . 'limit_users' ] : 'off';
    $survey_limit_users = (isset($options[ $name_prefix . 'limit_users' ]) && $options[ $name_prefix . 'limit_users' ] == 'on') ? true : false;

    // Detects users by IP / ID
    $survey_limit_users_by = (isset($options[ $name_prefix . 'limit_users_by' ]) && $options[ $name_prefix . 'limit_users_by' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'limit_users_by' ] ) ) : 'ip';

    // Limitation Message
    $survey_limitation_message = (isset($options[ $name_prefix . 'limitation_message' ]) &&  $options[ $name_prefix . 'limitation_message' ] != '') ? stripslashes( wpautop( $options[ $name_prefix . 'limitation_message' ] ) ) : '';

    // Only for logged in users
    $options[ $name_prefix . 'enable_logged_users' ] = isset($options[ $name_prefix . 'enable_logged_users' ]) ? $options[ $name_prefix . 'enable_logged_users' ] : 'off';
    $survey_enable_logged_users = (isset($options[ $name_prefix . 'enable_logged_users' ]) && $options[ $name_prefix . 'enable_logged_users' ] == 'on') ? true : false;

    // Message - Only for logged in users
    $survey_logged_in_message = (isset($options[ $name_prefix . 'logged_in_message' ]) &&  $options[ $name_prefix . 'logged_in_message' ] != '') ? stripslashes( wpautop( $options[ $name_prefix . 'logged_in_message' ] ) ) : '';

    // =============================================================
    // ===================    Limitation Tab     ===================
    // ========================    END    ==========================

    // =======================  //  ======================= // ======================= // ======================= // ======================= //

    // =============================================================
    // =====================    E-Mail Tab     =====================
    // ========================    START   =========================



    // =============================================================
    // =====================    E-Mail Tab     =====================
    // ========================    END    ==========================