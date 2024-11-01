<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Survey_Maker
 * @subpackage Survey_Maker/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Survey_Maker
 * @subpackage Survey_Maker/includes
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Survey_Maker_Data {

    public static function get_survey_validated_data_from_array( $survey, $attr ){
        global $wpdb;

        // Array for survey validated options
        $settings = array();
        $name_prefix = 'survey_';
        
        // ID
        $id = ( isset($attr['id']) ) ? absint( intval( $attr['id'] ) ) : null;
        $settings['id'] = $id;

        // Survey options
        $options = array();
        if( isset( $survey->options ) && $survey->options != '' ){
            $options = json_decode( $survey->options, true );
        }

        // =======================  //  ======================= // ======================= // ======================= // ======================= //


        // =============================================================
        // ======================    Styles Tab    =====================
        // ========================    START    ========================


        // Survey Theme
        $settings[ $name_prefix . 'theme' ] = (isset($options[ $name_prefix . 'theme' ]) && $options[ $name_prefix . 'theme' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'theme' ] ) ) : 'classic_light';

        // Survey Color
        $settings[ $name_prefix . 'color' ] = (isset($options[ $name_prefix . 'color' ]) && $options[ $name_prefix . 'color' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'color' ] ) ) :  'rgb(255, 87, 34)'; // '#673ab7'

        // Background color
        $settings[ $name_prefix . 'background_color' ] = (isset($options[ $name_prefix . 'background_color' ]) && $options[ $name_prefix . 'background_color' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'background_color' ] ) ) : '#fff';

        // Text Color
        $settings[ $name_prefix . 'text_color' ] = (isset($options[ $name_prefix . 'text_color' ]) && $options[ $name_prefix . 'text_color' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'text_color' ] ) ) : '#333';

        // Buttons text Color
        $settings[ $name_prefix . 'buttons_text_color' ] = (isset($options[ $name_prefix . 'buttons_text_color' ]) && $options[ $name_prefix . 'buttons_text_color' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'buttons_text_color' ] ) ) :  $settings[ $name_prefix . 'text_color' ];

        // Width
        $settings[ $name_prefix . 'width' ] = (isset($options[ $name_prefix . 'width' ]) && $options[ $name_prefix . 'width' ] != '') ? absint ( intval( $options[ $name_prefix . 'width' ] ) ) : '';


        // Survey Width by percentage or pixels
        $settings[ $name_prefix . 'width_by_percentage_px' ] = (isset($options[ $name_prefix . 'width_by_percentage_px' ]) && $options[ $name_prefix . 'width_by_percentage_px' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'width_by_percentage_px' ] ) ) : 'pixels';

        // Custom class for survey container
        $settings[ $name_prefix . 'custom_class' ] = (isset($options[ $name_prefix . 'custom_class' ]) && $options[ $name_prefix . 'custom_class' ] != '') ? stripslashes ( esc_attr( $options[ $name_prefix . 'custom_class' ] ) ) : '';

        // Custom CSS
        $settings[ $name_prefix . 'custom_css' ] = (isset($options[ $name_prefix . 'custom_css' ]) && $options[ $name_prefix . 'custom_css' ] != '') ? stripslashes ( esc_attr( $options[ $name_prefix . 'custom_css' ] ) ) : '';


        // =========== Questions Styles Start ===========

        // Question font size
        $settings[ $name_prefix . 'question_font_size' ] = (isset($options[ $name_prefix . 'question_font_size' ]) && $options[ $name_prefix . 'question_font_size' ] != '') ? absint ( intval( $options[ $name_prefix . 'question_font_size' ] ) ) : 16;

        // Question Image Width
        $settings[ $name_prefix . 'question_image_width' ] = (isset($options[ $name_prefix . 'question_image_width' ]) && $options[ $name_prefix . 'question_image_width' ] != '') ? absint ( intval( $options[ $name_prefix . 'question_image_width' ] ) ) : '';

        // Question Image Height
        $settings[ $name_prefix . 'question_image_height' ] = (isset($options[ $name_prefix . 'question_image_height' ]) && $options[ $name_prefix . 'question_image_height' ] != '') ? absint ( intval( $options[ $name_prefix . 'question_image_height' ] ) ) : '';

        // Question Image sizing
        $settings[ $name_prefix . 'question_image_sizing' ] = (isset($options[ $name_prefix . 'question_image_sizing' ]) && $options[ $name_prefix . 'question_image_sizing' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'question_image_sizing' ] ) ) : 'cover';

        // =========== Questions Styles End   =========== 


        // =========== Answers Styles Start ===========

        // Answer font size
        $settings[ $name_prefix . 'answer_font_size' ] = (isset($options[ $name_prefix . 'answer_font_size' ]) && $options[ $name_prefix . 'answer_font_size' ] != '') ? absint ( intval( $options[ $name_prefix . 'answer_font_size' ] ) ) : 15;

        // Answer view
        $settings[ $name_prefix . 'answers_view' ] = (isset($options[ $name_prefix . 'answers_view' ]) && $options[ $name_prefix . 'answers_view' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'answers_view' ] ) ) : 'list';

        // Answer object-fit
        $settings[ $name_prefix . 'answers_object_fit' ] = (isset($options[ $name_prefix . 'answers_object_fit' ]) && $options[ $name_prefix . 'answers_object_fit' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'answers_object_fit' ] ) ) : 'cover';

        // Answer padding
        $settings[ $name_prefix . 'answers_padding' ] = (isset($options[ $name_prefix . 'answers_padding' ]) && $options[ $name_prefix . 'answers_padding' ] != '') ? absint ( intval( $options[ $name_prefix . 'answers_padding' ] ) ) : 10;

        // Answer Gap
        $settings[ $name_prefix . 'answers_gap' ] = (isset($options[ $name_prefix . 'answers_gap' ]) && $options[ $name_prefix . 'answers_gap' ] != '') ? absint ( intval( $options[ $name_prefix . 'answers_gap' ] ) ) : 10;


        // =========== Answers Styles End   ===========


        // =========== Buttons Styles Start ===========

        // Buttons size
        $settings[ $name_prefix . 'buttons_size' ] = (isset($options[ $name_prefix . 'buttons_size' ]) && $options[ $name_prefix . 'buttons_size' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'buttons_size' ] ) ) : 'medium';

        // Buttons font size
        $settings[ $name_prefix . 'buttons_font_size' ] = (isset($options[ $name_prefix . 'buttons_font_size' ]) && $options[ $name_prefix . 'buttons_font_size' ] != '') ? absint ( intval( $options[ $name_prefix . 'buttons_font_size' ] ) ) : 14;

        // Buttons Left / Right padding
        $settings[ $name_prefix . 'buttons_left_right_padding' ] = (isset($options[ $name_prefix . 'buttons_left_right_padding' ]) && $options[ $name_prefix . 'buttons_left_right_padding' ] != '') ? absint ( intval( $options[ $name_prefix . 'buttons_left_right_padding' ] ) ) : 24;

        // Buttons Top / Bottom padding
        $settings[ $name_prefix . 'buttons_top_bottom_padding' ] = (isset($options[ $name_prefix . 'buttons_top_bottom_padding' ]) && $options[ $name_prefix . 'buttons_top_bottom_padding' ] != '') ? absint ( intval( $options[ $name_prefix . 'buttons_top_bottom_padding' ] ) ) : 0;

        // Buttons border radius
        $settings[ $name_prefix . 'buttons_border_radius' ] = (isset($options[ $name_prefix . 'buttons_border_radius' ]) && $options[ $name_prefix . 'buttons_border_radius' ] != '') ? absint ( intval( $options[ $name_prefix . 'buttons_border_radius' ] ) ) : 4;

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
        $settings[ $name_prefix . 'show_title' ] = (isset($options[ $name_prefix . 'show_title' ]) && $options[ $name_prefix . 'show_title' ] == 'on') ? true : false;

        // Enable randomize answers
        $options[ $name_prefix . 'enable_randomize_answers' ] = isset($options[ $name_prefix . 'enable_randomize_answers' ]) ? $options[ $name_prefix . 'enable_randomize_answers' ] : 'off';
        $settings[ $name_prefix . 'enable_randomize_answers' ] = (isset($options[ $name_prefix . 'enable_randomize_answers' ]) && $options[ $name_prefix . 'enable_randomize_answers' ] == 'on') ? true : false;

        // Enable randomize questions
        $options[ $name_prefix . 'enable_randomize_questions' ] = isset($options[ $name_prefix . 'enable_randomize_questions' ]) ? $options[ $name_prefix . 'enable_randomize_questions' ] : 'off';
        $settings[ $name_prefix . 'enable_randomize_questions' ] = (isset($options[ $name_prefix . 'enable_randomize_questions' ]) && $options[ $name_prefix . 'enable_randomize_questions' ] == 'on') ? true : false;

        // Enable rtl direction
        $options[ $name_prefix . 'enable_rtl_direction' ] = isset($options[ $name_prefix . 'enable_rtl_direction' ]) ? $options[ $name_prefix . 'enable_rtl_direction' ] : 'off';
        $settings[ $name_prefix . 'enable_rtl_direction' ] = (isset($options[ $name_prefix . 'enable_rtl_direction' ]) && $options[ $name_prefix . 'enable_rtl_direction' ] == 'on') ? true : false;

        // Enable confirmation box for leaving the page
        $options[ $name_prefix . 'enable_leave_page' ] = isset($options[ $name_prefix . 'enable_leave_page' ]) ? $options[ $name_prefix . 'enable_leave_page' ] : 'on';
        $settings[ $name_prefix . 'enable_leave_page' ] = (isset($options[ $name_prefix . 'enable_leave_page' ]) && $options[ $name_prefix . 'enable_leave_page' ] == 'on') ? true : false;

        // Enable clear answer button
        $options[ $name_prefix . 'enable_clear_answer' ] = isset($options[ $name_prefix . 'enable_clear_answer' ]) ? $options[ $name_prefix . 'enable_clear_answer' ] : 'off';
        $settings[ $name_prefix . 'enable_clear_answer' ] = (isset($options[ $name_prefix . 'enable_clear_answer' ]) && $options[ $name_prefix . 'enable_clear_answer' ] == 'on') ? true : false;


        // =============================================================
        // =================== Results Settings Tab  ===================
        // ========================    START   =========================


        // Redirect after submit
        $options[ $name_prefix . 'redirect_after_submit' ] = isset($options[ $name_prefix . 'redirect_after_submit' ]) ? $options[ $name_prefix . 'redirect_after_submit' ] : 'off';
        $settings[ $name_prefix . 'redirect_after_submit' ] = (isset($options[ $name_prefix . 'redirect_after_submit' ]) && $options[ $name_prefix . 'redirect_after_submit' ] == 'on') ? true : false;

        // Redirect URL
        $settings[ $name_prefix . 'submit_redirect_url' ] = (isset($options[ $name_prefix . 'submit_redirect_url' ]) && $options[ $name_prefix . 'submit_redirect_url' ] != '') ? stripslashes ( esc_url( $options[ $name_prefix . 'submit_redirect_url' ] ) ) : '';

        // Redirect delay (sec)
        $settings[ $name_prefix . 'submit_redirect_delay' ] = (isset($options[ $name_prefix . 'submit_redirect_delay' ]) && $options[ $name_prefix . 'submit_redirect_delay' ] != '') ? absint ( intval( $options[ $name_prefix . 'submit_redirect_delay' ] ) ) : '';

        // Enable EXIT button
        $options[ $name_prefix . 'enable_exit_button' ] = isset($options[ $name_prefix . 'enable_exit_button' ]) ? $options[ $name_prefix . 'enable_exit_button' ] : 'off';
        $settings[ $name_prefix . 'enable_exit_button' ] = (isset($options[ $name_prefix . 'enable_exit_button' ]) && $options[ $name_prefix . 'enable_exit_button' ] == 'on') ? true : false;

        // Redirect URL
        $settings[ $name_prefix . 'exit_redirect_url' ] = (isset($options[ $name_prefix . 'exit_redirect_url' ]) && $options[ $name_prefix . 'exit_redirect_url' ] != '') ? stripslashes ( esc_url( $options[ $name_prefix . 'exit_redirect_url' ] ) ) : '';

        // Thank you message
        $settings[ $name_prefix . 'final_result_text' ]  = (isset($options[ $name_prefix . 'final_result_text' ]) &&  $options[ $name_prefix . 'final_result_text' ] != '') ? stripslashes( wpautop( $options[ $name_prefix . 'final_result_text' ] ) ) : '';

        // Select survey loader
        $settings[ $name_prefix . 'loader' ] = (isset($options[ $name_prefix . 'loader' ]) && $options[ $name_prefix . 'loader' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'loader' ] ) ) : 'default';



        // =============================================================
        // =================== Results Settings Tab  ===================
        // ========================    END    ==========================



        // =======================  //  ======================= // ======================= // ======================= // ======================= //



        // =============================================================
        // ===================    Limitation Tab     ===================
        // ========================    START   =========================

        // Maximum number of attempts per user
        $options[ $name_prefix . 'limit_users' ] = isset($options[ $name_prefix . 'limit_users' ]) ? $options[ $name_prefix . 'limit_users' ] : 'off';
        $settings[ $name_prefix . 'limit_users' ] = (isset($options[ $name_prefix . 'limit_users' ]) && $options[ $name_prefix . 'limit_users' ] == 'on') ? true : false;

        // Detects users by IP / ID
        $settings[ $name_prefix . 'limit_users_by' ] = (isset($options[ $name_prefix . 'limit_users_by' ]) && $options[ $name_prefix . 'limit_users_by' ] != '') ? stripslashes ( sanitize_text_field( $options[ $name_prefix . 'limit_users_by' ] ) ) : 'ip';

        // Limitation Message
        $settings[ $name_prefix . 'limitation_message' ] = (isset($options[ $name_prefix . 'limitation_message' ]) &&  $options[ $name_prefix . 'limitation_message' ] != '') ? stripslashes( wpautop( $options[ $name_prefix . 'limitation_message' ] ) ) : '';

        // Only for logged in users
        $options[ $name_prefix . 'enable_logged_users' ] = isset($options[ $name_prefix . 'enable_logged_users' ]) ? $options[ $name_prefix . 'enable_logged_users' ] : 'off';
        $settings[ $name_prefix . 'enable_logged_users' ] = (isset($options[ $name_prefix . 'enable_logged_users' ]) && $options[ $name_prefix . 'enable_logged_users' ] == 'on') ? true : false;

        // Message - Only for logged in users
        $settings[ $name_prefix . 'logged_in_message' ] = (isset($options[ $name_prefix . 'logged_in_message' ]) &&  $options[ $name_prefix . 'logged_in_message' ] != '') ? stripslashes( wpautop( $options[ $name_prefix . 'logged_in_message' ] ) ) : '';

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


        return $settings;
    }

    public static function get_survey_by_id( $id ){
        global $wpdb;
        $surveys_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "surveys";

        $sql = "SELECT *
                FROM {$surveys_table}
                WHERE id=" . esc_sql( $id );

        $survey = $wpdb->get_row( $sql );

        return $survey;
    }

    public static function get_survey_category_by_id( $id ){
        global $wpdb;
        $survey_cat_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "survey_categories";

        $sql = "SELECT *
                FROM {$survey_cat_table}
                WHERE id=" . esc_sql( $id );

        $category = $wpdb->get_row( $sql );

        return $category;
    }

    public static function get_question_category_by_id( $id ){
        global $wpdb;
        $question_cat_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "question_categories";

        $sql = "SELECT *
                FROM {$question_cat_table}
                WHERE id=" . esc_sql( $id );

        $category = $wpdb->get_row( $sql );

        return $category;
    }

    public static function get_question_by_id( $id ){
        global $wpdb;
        $questions_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "questions";
        $answers_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "answers";

        $sql = "SELECT *
                FROM {$questions_table}
                WHERE id=" . esc_sql( $id );

        $question = $wpdb->get_row( $sql );

        $sql = "SELECT *
                FROM {$answers_table}
                WHERE question_id=" . esc_sql( $id );

        $answers = $wpdb->get_results( $sql );

        $question->answers = $answers;

        return $question;
    }

    public static function get_question_by_ids( $ids ){
        global $wpdb;
        $questions_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "questions";
        $answers_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "answers";

        $qids = esc_sql( implode( ',', $ids ) );

        $sql = "SELECT *
                FROM {$questions_table}
                WHERE id IN (" . $qids . ")
                ORDER BY ordering";

        $questions = $wpdb->get_results( $sql );

        foreach ( $questions as $key => &$question ) {

            $sql = "SELECT *
                    FROM {$answers_table}
                    WHERE question_id=" . esc_sql( $question->id ) ."
                    ORDER BY ordering";

            $answers = $wpdb->get_results( $sql );

            $question->answers = $answers;

        }

        return $questions;
    }

    public static function get_section_by_id($id){
        global $wpdb;
        $sections_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "sections";

        $sid = esc_sql( $id );

        $sql = "SELECT *
                FROM {$sections_table}
                WHERE id={$sid}
                ORDER BY ordering";

        $section = $wpdb->get_row( $sql );

        return $section;
    }

    public static function get_answer_by_id($id){
        global $wpdb;
        $answers_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "answers";

        $sql = "SELECT *
                FROM {$answers_table}
                WHERE id=" . esc_sql( $id );

        $answer = $wpdb->get_row( $sql );

        return $answer;
    }

    public static function get_answers_by_question_id($id){
        global $wpdb;
        $answers_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "answers";

        $sql = "SELECT *
                FROM {$answers_table}
                WHERE question_id=" . esc_sql( $id ) . "
                ORDER BY ordering";

        $answers = $wpdb->get_results( $sql, 'ARRAY_A' );

        if(! empty($answers) ){
            return $answers;
        }

        return array();
    }

    public static function get_survey_questions_count($id){
        global $wpdb;
        $surveys_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "surveys";

        $sql = "SELECT `questions_count`
                FROM {$surveys_table}
                WHERE id=" . esc_sql( $id );

        $questions_str = $wpdb->get_var( $sql );
        $count = intval( $questions_str );

        return $count;
    }

    public static function get_sections_by_survey_id( $ids ) {
        global $wpdb;
        if (empty($ids)) {
            return array();
        }
        $table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "sections";

        $sql = "SELECT * FROM {$table} WHERE `id` IN (" . $ids .") ORDER BY `ordering`;";
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        if(! empty($result) ){
            return $result;
        }

        return array();
    }

    public static function get_questions_by_section_id( $section_id, $question_ids ) {
        global $wpdb;
        if (empty($question_ids) || empty($section_id)) {
            return array();
        }
        $table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "questions";

        $sql = "SELECT * FROM {$table} WHERE `section_id` = ". absint( $section_id ) ." AND `id` IN (" . $question_ids .") ORDER BY ordering;";
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        if(! empty($result) ){
            return $result;
        }

        return array();
    }

    public static function get_answers_by_question_id_aro( $question_id ) {
        global $wpdb;
        if (empty($question_id)) {
            return false;
        }
        $table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "answers";

        $sql = "SELECT * FROM {$table} WHERE `question_id` = ". absint( $question_id );
        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        return $result;
    }

    public static function sort_array_keys_by_array($array, $orderArray) {
        $ordered = array();
        foreach ($orderArray as $key) {
            if (array_key_exists('ays-question-'.$key, $array)) {
                $ordered['ays-question-'.$key] = $array['ays-question-'.$key];
                unset($array['ays-question-'.$key]);
            }
        }
        return $ordered + $array;
    }

    public static function replace_message_variables($content, $data){
        foreach($data as $variable => $value){
            $content = str_replace("%%".$variable."%%", $value, $content);
        }
        return $content;
    }

    public static function question_type_is($question_id){
        global $wpdb;
        $questions_table = $wpdb->prefix . "aysquiz_questions";
        $question_id = absint(intval($question_id));
        $custom_types = array("custom");
        $question_type = $wpdb->get_var("SELECT type FROM {$questions_table} WHERE id={$question_id};");
        if($question_type == ''){
            $question_type = 'radio';
        }

        if(in_array($question_type, $custom_types)){
            return true;
        }
        return false;
    }

    public static function hex2rgba($color, $opacity = false){

        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if (empty($color))
            return $default;

        //Sanitize $color if "#" is provided
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }else{
            return $color;
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if ($opacity) {
            if (abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }

        //Return rgb(a) color string
        return $output;
    }

    public static function secondsToWords($seconds){
        $ret = "";

        /*** get the days ***/
        $days = intval(intval($seconds) / (3600 * 24));
        if ($days > 0) {
            $ret .= "$days " . __( 'days', SURVEY_MAKER_NAME ) . ' ';
        }

        /*** get the hours ***/
        $hours = (intval($seconds) / 3600) % 24;
        if ($hours > 0) {
            $ret .= "$hours " . __( 'hours', SURVEY_MAKER_NAME ) . ' ';
        }

        /*** get the minutes ***/
        $minutes = (intval($seconds) / 60) % 60;
        if ($minutes > 0) {
            $ret .= "$minutes " . __( 'minutes', SURVEY_MAKER_NAME ) . ' ';
        }

        /*** get the seconds ***/
        $seconds = intval($seconds) % 60;
        if ($seconds > 0) {
            $ret .= "$seconds " . __( 'seconds', SURVEY_MAKER_NAME );
        }

        return $ret;
    }

    public static function get_limit_user_by_ip($id){
        global $wpdb;
        $table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions" );
        $user_ip = self::get_user_ip();
        $sql = "SELECT COUNT(*)
                FROM `{$table}`
                WHERE `user_ip` = '$user_ip'
                  AND `survey_id` = $id";
        $result = $wpdb->get_var($sql);
        return $result;
    }

    public static function get_limit_user_by_id($survey_id, $user_id){
        global $wpdb;
        $table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions" );
        $sql = "SELECT COUNT(*)
                FROM `{$table}`
                WHERE `user_id` = $user_id
                  AND `survey_id` = $survey_id";
        $result = intval($wpdb->get_var($sql));
        return $result;
    }

    public static function get_user_ip(){
        $ipaddress = '';
        if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        elseif (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function get_time_difference($strStart, $strEnd){
        $dteStart = new DateTime($strStart);
        $dteEnd = new DateTime($strEnd);
        $texts = array(
            'year' => __( "year", AYS_QUIZ_NAME ),
            'years' => __( "years", AYS_QUIZ_NAME ),
            'month' => __( "month", AYS_QUIZ_NAME ),
            'months' => __( "months", AYS_QUIZ_NAME ),
            'day' => __( "day", AYS_QUIZ_NAME ),
            'days' => __( "days", AYS_QUIZ_NAME ),
            'hour' => __( "hour", AYS_QUIZ_NAME ),
            'hours' => __( "hours", AYS_QUIZ_NAME ),
            'minute' => __( "minute", AYS_QUIZ_NAME ),
            'minutes' => __( "minutes", AYS_QUIZ_NAME ),
            'second' => __( "second", AYS_QUIZ_NAME ),
            'seconds' => __( "seconds", AYS_QUIZ_NAME ),
        );
        $interval = $dteStart->diff($dteEnd);
        $return = '';

        if ($v = $interval->y >= 1) $return .= $interval->y ." ". $texts[self::pluralize_new($interval->y, 'year')] . ' ';
        if ($v = $interval->m >= 1) $return .= $interval->m ." ". $texts[self::pluralize_new($interval->m, 'month')] . ' ';
        if ($v = $interval->d >= 1) $return .= $interval->d ." ". $texts[self::pluralize_new($interval->d, 'day')] . ' ';
        if ($v = $interval->h >= 1) $return .= $interval->h ." ". $texts[self::pluralize_new($interval->h, 'hour')] . ' ';
        if ($v = $interval->i >= 1) $return .= $interval->i ." ". $texts[self::pluralize_new($interval->i, 'minute')] . ' ';

        $return .= $interval->s ." ". $texts[self::pluralize_new($interval->s, 'second')];

        return $return;
    }

    public static function pluralize($count, $text){
        return $count . (($count == 1) ? (" $text") : (" ${text}s"));
    }

    public static function pluralize_new($count, $text){
        return ($count == 1) ? $text."" : $text."s";
    }

    public static function ays_autoembed( $content ) {
        global $wp_embed;
        $content = stripslashes( wpautop( $content ) );
        $content = $wp_embed->autoembed( $content );
        if ( strpos( $content, '[embed]' ) !== false ) {
            $content = $wp_embed->run_shortcode( $content );
        }
        $content = do_shortcode( $content );
        return $content;
    }

    public static function get_questions_categories($q_ids){
        global $wpdb;

        if($q_ids == ''){
            return array();
        }
        $sql = "SELECT DISTINCT c.id, c.title
                FROM {$wpdb->prefix}aysquiz_categories c
                JOIN {$wpdb->prefix}aysquiz_questions q
                ON c.id = q.category_id
                WHERE q.id IN ({$q_ids})";

        $result = $wpdb->get_results($sql, 'ARRAY_A');
        $cats = array();

        foreach($result as $res){
            $cats[$res['id']] = $res['title'];
        }

        return $cats;
    }
}
