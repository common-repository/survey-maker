<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Survey_Maker
 * @subpackage Survey_Maker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Survey_Maker
 * @subpackage Survey_Maker/public
 * @author     Survey Maker team <info@ays-pro.com>
 */
class Survey_Maker_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $html_class_prefix = 'ays-survey-';
	private $html_name_prefix = 'ays-survey-';
	private $name_prefix = 'survey_';
    private $unique_id;
    private $unique_id_in_class;
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        add_shortcode('ays_survey', array($this, 'ays_generate_survey_method'));
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Survey_Maker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Survey_Maker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_style( $this->plugin_name . "-font-awesome", plugin_dir_url( __FILE__ ) . 'css/survey-maker-font-awesome.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name . "-transition", plugin_dir_url( __FILE__ ) . 'css/transition.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name . "-dropdown", plugin_dir_url( __FILE__ ) . 'css/dropdown.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name . '-select2', plugin_dir_url(__FILE__) . 'css/survey-maker-select2.min.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name . "-loaders", plugin_dir_url( __FILE__ ) . 'css/loaders.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/survey-maker-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Survey_Maker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Survey_Maker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_script( $this->plugin_name . '-autosize', plugin_dir_url( __FILE__ ) . 'js/survey-maker-autosize.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name . '-transition', plugin_dir_url( __FILE__ ) . 'js/transition.min.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name . '-dropdown', plugin_dir_url( __FILE__ ) . 'js/dropdown.min.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name . '-select2js', plugin_dir_url(__FILE__) . 'js/survey-maker-select2.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script( $this->plugin_name . '-test', plugin_dir_url( __FILE__ ) . 'js/survey-maker-public-test.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/survey-maker-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-ajax', plugin_dir_url( __FILE__ ) . 'js/survey-maker-public-ajax.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name . '-test', 'aysSurveyMakerAjaxPublic', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'warningIcon' => SURVEY_MAKER_PUBLIC_URL . "/images/warning.svg",
        ) );
        wp_localize_script( $this->plugin_name, 'aysSurveyLangObj', array(
            'notAnsweredText'       => __( 'You have not answered this question', $this->plugin_name ),
            'areYouSure'            => __( 'Do you want to finish the quiz? Are you sure?', $this->plugin_name ),
            'sorry'                 => __( 'Sorry', $this->plugin_name ),
            'unableStoreData'       => __( 'We are unable to store your data', $this->plugin_name ),
            'connectionLost'        => __( 'Connection is lost', $this->plugin_name ),
            'checkConnection'       => __( 'Please check your connection and try again', $this->plugin_name ),
            'selectPlaceholder'     => __( 'Select an answer', $this->plugin_name ),
            'shareDialog'           => __( 'Share Dialog', $this->plugin_name ),
            'passwordIsWrong'       => __( 'Password is wrong!', $this->plugin_name ),
            'choose'                => __( 'Choose', $this->plugin_name ),
            'redirectAfter'         => __( 'Redirecting after', $this->plugin_name ),
            'emailValidationError'  => __( 'Must be a valid email address', $this->plugin_name ),
            'requiredError'         => __( 'This is a required question', $this->plugin_name ),
        ) );
	}

	public function ays_survey_ajax(){
		global $wpdb;

		$results = array(
			"status" => false
		);
		$function = isset($_REQUEST['function']) ? sanitize_text_field( $_REQUEST['function'] ) : null;
		if($function !== null){
			$results = array();
			unset($_REQUEST['action']);
			unset($_REQUEST['function']);
			switch ($function) {
				case 'ays_finish_survey':
					$results = $this->ays_finish_survey();
					break;
			}
			echo json_encode( $results );
			wp_die();
		}
		echo json_encode( $results );
		wp_die();
	}

	public function ays_finish_survey(){
        $unique_id = isset($_REQUEST['unique_id']) ? sanitize_text_field( $_REQUEST['unique_id'] ) : null;
        if($unique_id === null){
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
            echo json_encode(array("status" => false, "message" => "No no no" ));
            wp_die();
        } else {
            global $wpdb;
            $name_prefix = 'ays-survey-';
            $valid_name_prefix = 'survey_';
            $survey_id = isset( $_REQUEST[ $name_prefix . 'id-' . $unique_id ] ) ? absint( intval( $_REQUEST[ $name_prefix . 'id-' . $unique_id ] ) ) : null;

            if($survey_id === null){
				ob_end_clean();
	            $ob_get_clean = ob_get_clean();
	            echo json_encode(array("status" => false, "message" => "No no no" ));
	            wp_die();
            }else{
                $survey = Survey_Maker_Data::get_survey_by_id( $survey_id );
                $attr = array(
                    'id' => $survey_id
                );
                $options = Survey_Maker_Data::get_survey_validated_data_from_array( $survey, $attr );

                $thank_you_message = $options[ $valid_name_prefix . 'final_result_text' ];
                if( $thank_you_message == '' ){
                    $thank_you_message = __( "Thank you for passing this survey.", $this->plugin_name );
                }

                $answered_questions = isset( $_REQUEST[ $name_prefix . 'answers-' . $unique_id ] ) && !empty( $_REQUEST[ $name_prefix . 'answers-' . $unique_id ] ) ? array_map( 'sanitize_text_field', $_REQUEST[ $name_prefix . 'answers-' . $unique_id ] ) : array();
                $questions_data = isset( $_REQUEST[ $name_prefix . 'questions-' . $unique_id ] ) && !empty( $_REQUEST[ $name_prefix . 'questions-' . $unique_id ] ) ? array_map( 'sanitize_text_field', $_REQUEST[ $name_prefix . 'questions-' . $unique_id ] ) : array();
                // $section_ids = isset( $_REQUEST[ $name_prefix . 'answers-' . $unique_id ] ) && !empty( $_REQUEST[ $name_prefix . 'answers-' . $unique_id ] ) ? $_REQUEST[ $name_prefix . 'answers-' . $unique_id ] : array();

                $user_email = '';
                if( isset( $_REQUEST[ $name_prefix . 'user-email-' . $unique_id ] ) && !empty( $_REQUEST[ $name_prefix . 'user-email-' . $unique_id ] ) ){
                    $user_email = $answered_questions[ sanitize_text_field( $_REQUEST[ $name_prefix . 'user-email-' . $unique_id ] ) ];
                }
                
                $user_name = '';
                if( isset( $_REQUEST[ $name_prefix . 'user-name-' . $unique_id ] ) && !empty( $_REQUEST[ $name_prefix . 'user-name-' . $unique_id ] ) ){
                    $user_name = $answered_questions[ sanitize_text_field( $_REQUEST[ $name_prefix . 'user-name-' . $unique_id ] ) ];
                }

                $result_unique_code = strtoupper( uniqid() );

                $send_data = array(
                    'questions_data' => $questions_data,
                    'answered_questions' => $answered_questions,
                    'survey' => $survey,
                    'questions_ids' => $survey->question_ids,
                    'user_id' => get_current_user_id(),
                    'user_ip' => Survey_Maker_Data::get_user_ip(),
                    'user_name' => $user_name,
                    'user_email' => $user_email,
                    'start_date' => current_time( 'mysql' ),
                    'end_date' => current_time( 'mysql' ),
                    'unique_code' => $result_unique_code,
                );
                $result = $this->add_results_to_db( $send_data );


            	echo json_encode( array(
                    'status' => $result,
                    "message" => $thank_you_message
                ) );
            	wp_die();
            }
        }
        echo json_encode(array("status" => false, "message" => "No no no" ));
        wp_die();
    }

    protected function add_results_to_db( $data ){
        global $wpdb;

        $questions_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "questions";
        $answers_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "answers";
        $submissions_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "submissions";
        $submissions_questions_table = esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "submissions_questions";

        $survey = $data['survey'];
        $questions_ids = $data['questions_ids'];
        $section_id = $data['section_id'];
        $user_id = $data['user_id'];
        $user_ip = $data['user_ip'];
        $user_name = $data['user_name'];
        $user_email = $data['user_email'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        $answered_questions = $data['answered_questions'];
        $questions_data = $data['questions_data'];
        $duration = strtotime($end_date) - strtotime($start_date);
        $unique_code = $data['unique_code'];

        $question_ids_array = $questions_ids != '' ? explode(',', $questions_ids) : array();
        $questions_count = count( $question_ids_array );

        $options = array(

        );

        $results_submissions = $wpdb->insert(
            $submissions_table,
            array(
                'survey_id' => absint( intval( $survey->id ) ),
                'questions_ids' => $questions_ids,
                'user_id' => $user_id,
                'user_ip' => $user_ip,
                'user_name' => $user_name,
                'user_email' => $user_email,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'submission_date' => $end_date,
                'duration' => $duration,
                'questions_count' => $questions_count,
                'unique_code' => $unique_code,
                'options' => json_encode($options)
            ),
            array(
                '%d', // survey_id
                '%s', // questions_ids
                '%d', // user_id
                '%s', // user_ip
                '%s', // user_name
                '%s', // user_email
                '%s', // start_date
                '%s', // end_date
                '%s', // submission_date
                '%s', // duration
                '%s', // questions_count
                '%s', // unique_code
                '%s', // options
            )
        );

        $submission_id = $wpdb->insert_id;
            // var_dump($questions_data);
        $results_submissions_questions = 0;
        foreach ($question_ids_array as $key => $qid) {
            $questions_options = array(

            );

            $answer_id = $answered_questions[$qid];
            $user_answer = '';
            $user_variant = '';
            $section_id = $questions_data[$qid]['section'];
            
            if( is_array( $answered_questions[$qid] ) && isset( $answered_questions[$qid]['other'] ) ){
                $user_variant = $answered_questions[$qid]['other'];
            }

            $question_type = (isset($questions_data[$qid]['questionType']) && $questions_data[$qid]['questionType'] != '') ? stripslashes ( sanitize_text_field( $questions_data[$qid]['questionType'] ) ) : 'radio';
            switch ( $question_type ) {
                case "radio":
                    $user_answer = '';
                    break;
                case "checkbox":
                    $answer_id_arr = $answered_questions[$qid];
                    $user_answer = implode(',', $answer_id_arr);
                    break;    
                case "select":
                    $user_answer = '';
                    break;
                case "text":
                    $user_answer = $answered_questions[$qid];
                    $answer_id = 0;
                    break;
                case "short_text":
                    $user_answer = $answered_questions[$qid];
                    $answer_id = 0;
                    break;
                case "number":
                    $user_answer = $answered_questions[$qid];
                    $answer_id = 0;
                    break;
                case "name":
                    $user_answer = $answered_questions[$qid];
                    $answer_id = 0;
                    break;
                case "email":
                    $user_answer = $answered_questions[$qid];
                    $answer_id = 0;
                    break;
                default:
                    $user_answer = '';
                    break;
            }

            $results_submissions_quests = $wpdb->insert(
                $submissions_questions_table,
                array(
                    'submission_id' => intval( $submission_id ),
                    'question_id' => intval( $qid ),
                    'section_id' => intval( $section_id ),
                    'survey_id' => intval( $survey->id ),
                    'user_id' => $user_id,
                    'answer_id' => intval( $answer_id ),
                    'user_answer' => $user_answer,
                    'user_variant' => $user_variant,
                    'user_explanation' => '',
                    'type' => $question_type,
                    'options' => json_encode( $questions_options )
                ),
                array(
                    '%d', // submission_id
                    '%d', // question_id
                    '%d', // section_id
                    '%d', // survey_id
                    '%d', // user_id
                    '%d', // answer_id
                    '%s', // user_answer
                    '%s', // user_variant
                    '%s', // user_explanation
                    '%s', // type
                    '%s', // options
                )
            );
        }


        if ($results_submissions >= 0) {
            return true;
        }

        return false;
    }

    public function ays_generate_survey_method( $attr ){
        ob_start();
        $id = (isset($attr['id'])) ? absint(intval($attr['id'])) : null;
        
        if (is_null($id)) {
            echo "<p class='wrong_shortcode_text' style='color:red;'>" . __( 'Wrong shortcode initialized', $this->plugin_name ) . "</p>";
            return false;
        }
        
        $this->enqueue_styles();
        $this->enqueue_scripts();

        $content = $this->show_survey($id, $attr);
        echo $content;
        return str_replace( array( "\r\n", "\n", "\r" ), '', ob_get_clean() );        
    }

    public function show_survey( $id, $attr ){

    	$survey = Survey_Maker_Data::get_survey_by_id( $id );

        if ( is_null( $survey ) ) {
            echo "<p class='wrong_shortcode_text' style='color:red;'>" . __('Wrong shortcode initialized', $this->plugin_name) . "</p>";
            return false;
        }

    	$status = isset( $survey->status ) && $survey->status != '' ? $survey->status : '';

        if ( $status != 'published' ) {
            return false;
        }

        $unique_id = uniqid();
        $this->unique_id = $unique_id;
        $this->unique_id_in_class = $id . "-" . $unique_id;;

        /*******************************************************************************************************/

        // $settings_options = $this->settings->ays_get_setting('options');
        // if($settings_options){
        //     $settings_options = json_decode($settings_options, true);
        // }else{
        //     $settings_options = array();
        // }

        $this->options = Survey_Maker_Data::get_survey_validated_data_from_array( $survey, $attr );
        
        $user_id = get_current_user_id();

        /*******************************************************************************************************/
        
        
        $options = isset( $survey->options ) && $survey->options != '' ? json_decode( $survey->options, true ) : array();
    	
    	$sections_ids = isset( $survey->section_ids ) && $survey->section_ids != '' ? $survey->section_ids : '';
        $question_ids = isset( $survey->question_ids ) && $survey->question_ids != '' ? $survey->question_ids : '';
    	
    	if( $sections_ids != '' ){
    		$section_ids_array = explode( ',', $sections_ids );
    	}else{
    		$section_ids_array = array();
        }
        
        /*******************************************************************************************************/
        /* Limit users                                                                                         */
        /*******************************************************************************************************/
        $limit = false;
        $limit_message = false;
        if( $this->options[ $this->name_prefix . 'limit_users' ] ){
            switch( $this->options[ $this->name_prefix . 'limit_users_by' ] ){
                case 'ip':
                    $limit_by = Survey_Maker_Data::get_limit_user_by_ip( $id );
                break;
                case 'user_id':
                    $limit_by = Survey_Maker_Data::get_limit_user_by_id( $id, $user_id );
                break;
            }

            if( $limit_by >= 1 ){
                $limit = true;
                $limit_message = $this->options[ $this->name_prefix . 'limitation_message' ];
                
                if( $limit_message == '' ){
                    $limit_message = __( "You've already responded", $this->plugin_name );
                }
            }
        }
        
        if( $this->options[ $this->name_prefix . 'enable_logged_users' ] ){
            if( ! is_user_logged_in() ){
                $limit = true;
                $limit_message = $this->options[ $this->name_prefix . 'logged_in_message' ];
                
                if( $limit_message == '' ){
                    $limit_message = "<h4 style='margin-top:0;'>" . __( "Sign in to continue", $this->plugin_name ) . "</h4>";
                    $limit_message .= "<p>" . __( "To fill out this form, you must be signed in. Your identity will remain anonymous.", $this->plugin_name ) . "</p>";
                }
            }
        }


        $survey_loader = $this->options[ $this->name_prefix . 'loader' ];

        switch( $survey_loader ){
            case 'default':
                $survey_loader_html = "<div data-class='lds-ellipsis' data-role='loader' class='ays-loader'><div></div><div></div><div></div><div></div></div>";
                break;
            case 'circle':
                $survey_loader_html = "<div data-class='lds-circle' data-role='loader' class='ays-loader'></div>";
                break;
            case 'dual_ring':
                $survey_loader_html = "<div data-class='lds-dual-ring' data-role='loader' class='ays-loader'></div>";
                break;
            case 'facebook':
                $survey_loader_html = "<div data-class='lds-facebook' data-role='loader' class='ays-loader'><div></div><div></div><div></div></div>";
                break;
            case 'hourglass':
                $survey_loader_html = "<div data-class='lds-hourglass' data-role='loader' class='ays-loader'></div>";
                break;
            case 'ripple':
                $survey_loader_html = "<div data-class='lds-ripple' data-role='loader' class='ays-loader'><div></div><div></div></div>";
                break;
            // case 'text':
            //     if ($quiz_loader_text_value != '') {
            //         $survey_loader_html = "
            //         <div class='ays-loader' data-class='text' data-role='loader'>
            //             <p class='ays-loader-content'>". $quiz_loader_text_value ."</p>
            //         </div>";
            //     }else{
            //         $survey_loader_html = "<div data-class='lds-ellipsis' data-role='loader' class='ays-loader'><div></div><div></div><div></div><div></div></div>";
            //     }
            //     break;
            case '1':
                $survey_loader_html = '<div class="ays-survey-loader" data-class="ays-survey-loader-1" data-role="loader"><div></div><div></div><div></div><div></div><div></div><div></div></div>';
            break;
            default:
                $survey_loader_html = '<div class="ays-survey-loader" data-class="ays-survey-loader-1" data-role="loader"><div></div><div></div><div></div><div></div><div></div><div></div></div>';
            break;
        }

        $this->options[ $this->name_prefix . 'loader_html' ] = $survey_loader_html;
    	// $sections = array();
    	// foreach ( $section_ids as $key => $value ) {
    	// 	$sections[ $value ] = Survey_Maker_Data::get_section_by_id( $value );
    	// }

        // Section Ids
        // $sections_ids = (isset( $object['section_ids'] ) && $object['section_ids'] != '') ? $object['section_ids'] : '';
        
        if( !$limit ){
            $sections = Survey_Maker_Data::get_sections_by_survey_id( $sections_ids );
            $sections_count = count( $sections );

            $multiple_sections = $sections_count > 1 ? true : false;

            foreach ($sections as $section_key => $section) {
                $sections[$section_key]['title'] = (isset($section['title']) && $section['title'] != '') ? stripslashes( htmlentities( $section['title'] ) ) : '';
                $sections[$section_key]['description'] = (isset($section['description']) && $section['description'] != '') ? stripslashes( htmlentities( $section['description'] ) ) : '';

                $section_questions = Survey_Maker_Data::get_questions_by_section_id( intval( $section['id'] ), $question_ids );

                foreach ($section_questions as $question_key => $question) {
                    $section_questions[$question_key]['question'] = (isset($question['question']) && $question['question'] != '') ? stripslashes( $question['question'] ) : '';
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
        }

        $blocked_content_class = '';
        if( $limit ){
            $blocked_content_class = ' ' . $this->html_class_prefix . 'blocked-content ';
        }

        $content = array();
        
    	$content[] = '<div class="' . $this->html_class_prefix . 'container ' . $blocked_content_class . $this->options[ $this->name_prefix . 'custom_class' ] . '" id="' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . '" data-id="' . $unique_id . '">';

        if( $this->options[ $this->name_prefix . 'show_title' ] ){
            $content[] = '<h2 class="">' . $survey->title . '</h2>';
        }

    	$content[] = '<form class="' . $this->html_class_prefix . 'form" method="post">';
    	$content[] = '<input type="hidden" name="'. $this->html_name_prefix .'id-' . $unique_id . '" value="'. $id .'">';

        if( !$limit ){
            $content[] = $this->create_sections( $sections );
        }else{
            $content[] = $this->create_restricted_content( $limit_message );
        }
        
        $content[] = '</form>';

        $content[] = $this->get_styles();
        $content[] = $this->get_custom_css();

        $content[] = $this->get_encoded_options( $limit );

        $content[] = '</div>';
        
    	$content = implode( '', $content );
    	return $content;

    }

    public function create_sections( $sections ){

    	$content = array();
    	$content[] = '<div class="' . $this->html_class_prefix . 'sections">';

        $sections_count = count( $sections );
    	foreach ( $sections as $key => $section ) {
            $last = $key + 1 == $sections_count ? true : false;
    		$content[] = $this->create_section( $section, $last );
        }
        
        $content[] = '<div class="' . $this->html_class_prefix . 'section ' . $this->html_class_prefix . 'results-content">';
            $content[] = '<div class="' . $this->html_class_prefix . 'section-header">';
            
                $content[] = '<div class="' . $this->html_class_prefix . 'results">';
                    $content[] = '<div class="' . $this->html_class_prefix . 'loader">' . $this->options[ $this->name_prefix . 'loader_html' ] . '</div>';
                    $content[] = '<div class="' . $this->html_class_prefix . 'thank-you-page">';

                    if( $this->options[ $this->name_prefix . 'enable_exit_button' ] ){
                        if( $this->options[ $this->name_prefix . 'exit_redirect_url' ] != '' && filter_var( $this->options[ $this->name_prefix . 'exit_redirect_url' ], FILTER_VALIDATE_URL) !== false ){

                            $content[] = '<div class="' . $this->html_class_prefix . 'section-buttons">';
                                $content[] = '<div class="' . $this->html_class_prefix . 'section-button-container">';
                                    $content[] = '<div class="' . $this->html_class_prefix . 'section-button-content">';
                                        $content[] = '<a href="' . $this->options[ $this->name_prefix . 'exit_redirect_url' ] . '" class="' . $this->html_class_prefix . 'section-button">'. __( "Exit", $this->plugin_name ) .'</a>';
                                    $content[] = '</div>';
                                $content[] = '</div>';
                            $content[] = '</div>';
                        }
                    }

                    $content[] = '</div>';
                $content[] = '</div>';

            $content[] = '</div>';
        $content[] = '</div>';

    	$content[] = '</div>';

    	$content = implode( '', $content );

    	return $content;
    }

    public function create_section( $section, $last ){
		
		$content = array();
    	$content[] = '<div class="' . $this->html_class_prefix . 'section">';

            $content[] = '<div class="' . $this->html_class_prefix . 'section-header">';
            
	    	    $content[] = '<div class="' . $this->html_class_prefix . 'section-title-row">';
		    	    $content[] = '<span class="' . $this->html_class_prefix . 'section-title">' . stripslashes( $section['title'] ) . '</span>';
	    	    $content[] = '</div>';

                $content[] = '<div class="' . $this->html_class_prefix . 'section-desc">' . stripslashes( $section['description'] ) . '</div>';

	    	$content[] = '</div>';

	    	$content[] = '<div class="' . $this->html_class_prefix . 'section-content">';

                $content[] = '<div class="' . $this->html_class_prefix . 'section-questions">';
                
                if( $this->options[ $this->name_prefix . 'enable_randomize_questions' ] ){
                    shuffle( $section['questions'] );
                }

		    	foreach ( $section['questions'] as $key => $question ) {
		    		$content[] = $this->create_question( $question );
		    	}
		    	$content[] = '</div>';

	    	$content[] = '</div>';

	    	$content[] = '<div class="' . $this->html_class_prefix . 'section-footer">';
		    	$content[] = '<div class="' . $this->html_class_prefix . 'section-buttons">';
                    $content[] = '<div class="' . $this->html_class_prefix . 'section-button-container">';
                        $content[] = '<div class="' . $this->html_class_prefix . 'section-button-content">';
                        if( $last ){
                            $content[] = '<input type="button" class="' . $this->html_class_prefix . 'section-button ' . $this->html_class_prefix . 'finish-button" value="'. __( "Finish", $this->plugin_name ) .'" />';
                        }else{
                            $content[] = '<input type="button" class="' . $this->html_class_prefix . 'section-button ' . $this->html_class_prefix . 'next-button" value="'. __( "Next", $this->plugin_name ) .'" />';
                        }
                        $content[] = '</div>';
                    $content[] = '</div>';
		    	$content[] = '</div>';
	    	$content[] = '</div>';
    	
    	$content[] = '</div>';

    	$content = implode( '', $content );

    	return $content;
    }

    public function create_question( $question ){

        $question_type = $question['type'];
        $answers = $question['answers'];
        $answers_html = array();
        $is_required = isset( $question['options']['required'] ) && $question['options']['required'] == 'on' ? true : false;

        if( $this->options[ $this->name_prefix . 'enable_randomize_answers' ] ){
            shuffle( $question['answers'] );
            shuffle( $answers );
        }

        $other_answer = $question['user_variant'];
        if( $other_answer ){
            $answers[] = array(
                'id' => '0',
                'question_id' => $question['id'],
                'answer' => '',
                'image' => '',
                'ordering' => count( $answers ) + 1,
                'placeholder' => '',
                'is_other' => true,
            );
        }
        
        $has_answer_image = false;
        foreach ($answers as $key => $answer) {
            if(isset( $answer['image'] ) && $answer['image'] != ""){
                $has_answer_image = true;
            }
        }

        $question_types = array(
            "radio",
            "checkbox",
            "select",
            "text",
            "short_text",
            "number",
            "email",
            "name",
        );

        $question_types_getting_answers_array = array(
            "radio",
            "checkbox",
        );

        if( !in_array( $question_type, $question_types ) ){
            $question_type = "radio";
        }
        
        // switch ( $question_type ) {
        //     case "radio":
        //         $answers_html[] = $this->ays_survey_question_type_RADIO_html( $answers );
        //         break;
        //     case "checkbox":
        //         $answers_html[] = $this->ays_survey_question_type_CHECKBOX_html( $answers );
        //         break;
        //     case "select":
        //         $answers_html[] = $this->ays_survey_question_type_SELECT_html( $question );
        //         $has_answer_image = false;
        //         break;
        //     case "text":
        //         $answers_html[] = $this->ays_survey_question_type_TEXT_html( $question );
        //         $has_answer_image = false;
        //         break;
        //     case "short_text":
        //         $answers_html[] = $this->ays_survey_question_type_SHORT_TEXT_html( $question );
        //         $has_answer_image = false;
        //         break;
        //     case "number":
        //         $answers_html[] = $this->ays_survey_question_type_NUMBER_html( $question );
        //         $has_answer_image = false;
        //         break;
        //     default:
        //         $answers_html[] = $this->ays_survey_question_type_RADIO_html( $answers );
        //         break;
        // }

        $question_type_function = 'ays_survey_question_type_' . strtoupper( $question_type ) . '_html';
        
        $transmitting_array = in_array( $question_type, $question_types_getting_answers_array ) ? $answers : $question;

        $answers_html[] = $this->$question_type_function( $transmitting_array );

        $answers_html = implode( '', $answers_html );

        $answer_grid = '';
        if( $has_answer_image || $this->options[ $this->name_prefix . 'answers_view' ] == 'grid' ){
            $answer_grid = $this->html_class_prefix . 'question-answers-grid';
        }
        $data_required = $is_required ? "true" : "false";

		$content = array();
    	$content[] = '<div class="' . $this->html_class_prefix . 'question" data-required="' . $data_required . '" data-type="' . $question_type . '">';

	    	$content[] = '<div class="' . $this->html_class_prefix . 'question-header">';

                $content[] = '<div class="' . $this->html_class_prefix . 'question-title">' . stripslashes( $question['question'] );
                
                if( $is_required ){
                    $content[] = '<sup class="' . $this->html_class_prefix . 'question-required-icon">*</sup>';
                }

                $content[] = '</div>';

                if( isset( $question['image'] ) && $question['image'] != "" ){
                    $content[] = '<div class="' . $this->html_class_prefix . 'question-image">';
                        $content[] = '<img class="' . $this->html_class_prefix . 'question-image" src="' . $question['image'] . '" alt="' . stripslashes( $question['question'] ) . '" />';
                    $content[] = '</div>';
                }

	    	$content[] = '</div>';

	    	$content[] = '<div class="' . $this->html_class_prefix . 'question-content">';

		    	$content[] = '<div class="' . $this->html_class_prefix . 'question-answers ' . $answer_grid . '">';
		    	
                    $content[] = $answers_html;

                    $content[] = '<input type="hidden" name="' . $this->html_name_prefix . 'questions-' . $this->unique_id . '[' . $question['id'] . '][section]" value="' . $question['section_id'] . '">';
                    $content[] = '<input type="hidden" name="' . $this->html_name_prefix . 'questions-' . $this->unique_id . '[' . $question['id'] . '][questionType]" value="' . $question_type . '">';
                
                if( $this->options[ $this->name_prefix . 'enable_clear_answer' ] ){
                    $content[] = '<div class="' . $this->html_class_prefix . 'answer-clear-selection-container ' . $this->html_class_prefix . 'display-none transition fade">';
                        $content[] = '<div class="' . $this->html_class_prefix . 'simple-button-container">';
                            $content[] = '<div class="' . $this->html_class_prefix . 'button-content">';
                                $content[] = '<span class="' . $this->html_class_prefix . 'answer-clear-selection-text ' . $this->html_class_prefix . 'button">' . __( 'Clear selection', $this->plugin_name ) . '</span>';
                            $content[] = '</div>';
                        $content[] = '</div>';
                    $content[] = '</div>';
                }

                $content[] = '</div>';
                
            $content[] = '</div>';
                
            $content[] = '<div class="' . $this->html_class_prefix . 'question-footer">';
                $content[] = '<div class="' . $this->html_class_prefix . 'question-validation-error" role="alert"></div>';
	    	$content[] = '</div>';

    	$content[] = '</div>';

    	$content = implode( '', $content );

    	return $content;
    }

    // public function create_answer( $answer ){
    public function ays_survey_question_type_RADIO_html( $answers ){
		
        $content = array();

        $has_answer_image = false;
        foreach ($answers as $key => $answer) {
            if(isset( $answer['image'] ) && $answer['image'] != ""){
                $has_answer_image = true;
            }
        }

        $answer_grid = '';
        $answer_label_grid = '';
        if( $has_answer_image || $this->options[ $this->name_prefix . 'answers_view' ] == 'grid' ){
            $answer_grid = $this->html_class_prefix . 'answer-grid';
            $answer_label_grid = $this->html_class_prefix . 'answer-label-grid';
        }

        foreach ($answers as $key => $answer) {
            
            $is_other = false;
            if( isset( $answer['is_other'] ) && $answer['is_other'] == true ){
                $is_other = true;
            }
        
            $answer_label_other = '';
            if( $is_other ){
                $answer_label_other = $this->html_class_prefix . 'answer-label-other';
            }

            $content[] = '<div class="' . $this->html_class_prefix . 'answer ' . $answer_grid . '">';
            
                $content[] = '<label class="' . $this->html_class_prefix . 'answer-label ' . $answer_label_grid . ' ' . $answer_label_other . '">';
                    $content[] = '<input class="" type="radio" name="' . $this->html_name_prefix . 'answers-' . $this->unique_id . '[' . $answer['question_id'] . ']" value="' . $answer['id'] . '">';

                    if( isset( $answer['image'] ) && $answer['image'] != "" ){
                        $content[] = '<div class="' . $this->html_class_prefix . 'answer-image-container">';
                            $content[] = '<img class="' . $this->html_class_prefix . 'answer-image" src="' . $answer['image'] . '" alt="' . stripslashes( $answer['answer'] ) . '" />';
                        $content[] = '</div>';
                    }

                    $content[] = '<div class="' . $this->html_class_prefix . 'answer-label-content">';

                        $content[] = '<div class="' . $this->html_class_prefix . 'answer-icon-content">';
                            $content[] = '<div class="' . $this->html_class_prefix . 'answer-icon-ink"></div>';
                            $content[] = '<div class="' . $this->html_class_prefix . 'answer-icon-content-1">';
                                $content[] = '<div class="' . $this->html_class_prefix . 'answer-icon-content-2">';
                                    $content[] = '<div class="' . $this->html_class_prefix . 'answer-icon-content-3"></div>';
                                $content[] = '</div>';
                            $content[] = '</div>';
                        $content[] = '</div>';

                        if( $is_other ){
                            $content[] = '<span class="">' . __( 'Other', $this->plugin_name ) . ':</span>';
                        }else{
                            $content[] = '<span class="">' . $answer['answer'] . '</span>';
                        }

                    $content[] = '</div>';
                $content[] = '</label>';

                if( $is_other ){

                    $content[] = '<div class="' . $this->html_class_prefix . 'answer-other-text">';
                        $content[] = '<input id="' . $this->html_class_prefix . 'answer-other-input-' . $answer['question_id'] . '" class="' . $this->html_class_prefix . 'answer-other-input ' .
                                        $this->html_class_prefix . 'remove-default-border ' . 
                                        $this->html_class_prefix . 'question-input ' . 
                                        $this->html_class_prefix . 'input" 
                                        name="' . $this->html_name_prefix . 'answers-' . $this->unique_id . '[' . $answer['question_id'] . '][other]" 
                                        type="text" autocomplete="off" tabindex="0" />';
                        $content[] = '<div class="' . $this->html_class_prefix . 'input-underline" style="margin:0;"></div>';
                        $content[] = '<div class="' . $this->html_class_prefix . 'input-underline-animation" style="margin:0;"></div>';
                    $content[] = '</div>';
                    
                }

            $content[] = '</div>';
        }
        
    	$content = implode( '', $content );

    	return $content;
    }

    public function ays_survey_question_type_CHECKBOX_html( $answers ){
        $content = array();
        $has_answer_image = false;
        foreach ($answers as $key => $answer) {
            if(isset( $answer['image'] ) && $answer['image'] != ""){
                $has_answer_image = true;
            }
        }

        $answer_grid = '';
        $answer_label_grid = '';
        if( $has_answer_image || $this->options[ $this->name_prefix . 'answers_view' ] == 'grid' ){
            $answer_grid = $this->html_class_prefix . 'answer-grid';
            $answer_label_grid = $this->html_class_prefix . 'answer-label-grid';
        }

        foreach ($answers as $key => $answer) {
            
            $is_other = false;
            if( isset( $answer['is_other'] ) && $answer['is_other'] == true ){
                $is_other = true;
            }
        
            $answer_label_other = '';
            if( $is_other ){
                $answer_label_other = $this->html_class_prefix . 'answer-label-other';
            }

            $content[] = '<div class="' . $this->html_class_prefix . 'answer ' . $answer_grid . '">';
            
                $content[] = '<label class="' . $this->html_class_prefix . 'answer-label ' . $answer_label_grid . ' ' . $answer_label_other . '">';
                
                    $content[] = '<input class="" type="checkbox" name="' . $this->html_name_prefix . 'answers-' . $this->unique_id . '[' . $answer['question_id'] . '][]" value="' . $answer['id'] . '">';
                    
                    if( isset( $answer['image'] ) && $answer['image'] != "" ){
                        $content[] = '<div class="' . $this->html_class_prefix . 'answer-image-container">';
                            $content[] = '<img class="' . $this->html_class_prefix . 'answer-image" src="' . $answer['image'] . '" alt="' . stripslashes( $answer['answer'] ) . '" />';
                        $content[] = '</div>';
                    }

                    $content[] = '<div class="' . $this->html_class_prefix . 'answer-label-content">';
                
                        $content[] = '<div class="' . $this->html_class_prefix . 'answer-icon-content">';
                            $content[] = '<div class="' . $this->html_class_prefix . 'answer-icon-ink"></div>';
                            $content[] = '<div class="' . $this->html_class_prefix . 'answer-icon-content-1">';
                                $content[] = '<div class="' . $this->html_class_prefix . 'answer-icon-content-2">';
                                    $content[] = '<div class="' . $this->html_class_prefix . 'answer-icon-content-3"></div>';
                                $content[] = '</div>';
                            $content[] = '</div>';
                        $content[] = '</div>';
                        
                        if( $is_other ){
                            $content[] = '<span class="">' . __( 'Other', $this->plugin_name ) . ':</span>';
                        }else{
                            $content[] = '<span class="">' . $answer['answer'] . '</span>';
                        }

                    $content[] = '</div>';
                $content[] = '</label>';

                if( $is_other ){

                    $content[] = '<div class="' . $this->html_class_prefix . 'answer-other-text">';
                        $content[] = '<input id="' . $this->html_class_prefix . 'answer-other-input-' . $answer['question_id'] . '" class="' . $this->html_class_prefix . 'answer-other-input ' .
                                        $this->html_class_prefix . 'remove-default-border ' . 
                                        $this->html_class_prefix . 'question-input ' . 
                                        $this->html_class_prefix . 'input" type="text" autocomplete="off" tabindex="0" />';
                        $content[] = '<div class="' . $this->html_class_prefix . 'input-underline" style="margin:0;"></div>';
                        $content[] = '<div class="' . $this->html_class_prefix . 'input-underline-animation" style="margin:0;"></div>';
                    $content[] = '</div>';

                }

            $content[] = '</div>';
        }

        $content = implode( '', $content );

        return $content;
    }

    public function ays_survey_question_type_SELECT_html( $question ){
        $content = array();

        $content[] = '<div class="' . $this->html_class_prefix . 'answer">';

            $content[] = '<div class="' . $this->html_class_prefix . 'question-type-select-box">';
                $content[] = '<div class="' . $this->html_class_prefix . 'question-select-conteiner">';

                    $content[] = '<div class="' . $this->html_class_prefix . 'question-select ui selection icon dropdown">';
                        
                        $content[] = '<input type="hidden" name="' . $this->html_name_prefix . 'answers-' . $this->unique_id . '[' . $question['id'] . ']">';

                        $content[] = '<i class="dropdown icon"></i>';
                        $content[] = '<div class="default text">'.__('Choose', $this->plugin_name).'</div>';

                        $content[] = '<div class="menu">';
                        
                            foreach ( $question['answers'] as $key => $answer ) {
                                $content[] = '<div class="item" data-value="'. $answer['id'] .'">';

                                    if( isset( $answer['image'] ) && $answer['image'] != "" ){
                                        $content[] = '<img class="' . $this->html_class_prefix . 'answer-image" src="' . $answer['image'] . '" alt="' . stripslashes( $answer['answer'] ) . '" />';
                                    }

                                    $content[] = stripslashes( $answer['answer'] );

                                $content[] = '</div>';
                            }

                        $content[] = '</div>';
                    $content[] = '</div>';

                $content[] = '</div>';
            $content[] = '</div>';

        $content[] = '</div>';

        $content = implode( '', $content );

        return $content;
    }

    public function ays_survey_question_type_TEXT_html( $question ){
        $content = array();

        $content[] = '<div class="' . $this->html_class_prefix . 'answer">';

            $content[] = '<div class="' . $this->html_class_prefix . 'question-box ' . $this->html_class_prefix . 'question-type-text-box">';
                $content[] = '<div class="' . $this->html_class_prefix . 'question-input-box">';

                    $content[] = '<textarea class="' . 
                                    $this->html_class_prefix . 'remove-default-border ' . 
                                    $this->html_class_prefix . 'question-input-textarea ' . 
                                    $this->html_class_prefix . 'question-input ' . 
                                    $this->html_class_prefix . 'input" type="text" style="min-height: 24px;"
                                    placeholder="'. __( "Your answer", $this->plugin_name ) .'"
                                    name="' . $this->html_name_prefix . 'answers-' . $this->unique_id . '[' . $question['id'] . ']">';
                    $content[] = '</textarea>';

                    $content[] = '<div class="' . $this->html_class_prefix . 'input-underline"></div>';
                    $content[] = '<div class="' . $this->html_class_prefix . 'input-underline-animation"></div>';

                $content[] = '</div>';
            $content[] = '</div>';

        $content[] = '</div>';

        $content = implode( '', $content );

        return $content;
    }

    public function ays_survey_question_type_SHORT_TEXT_html( $question ){
        $content = array();

        $content[] = '<div class="' . $this->html_class_prefix . 'answer">';

            $content[] = '<div class="' . $this->html_class_prefix . 'question-box">';
                $content[] = '<div class="' . $this->html_class_prefix . 'question-input-box">';

                    $content[] = '<input class="' . 
                                    $this->html_class_prefix . 'remove-default-border ' . 
                                    $this->html_class_prefix . 'question-input ' . 
                                    $this->html_class_prefix . 'input" type="text" style="min-height: 24px;"
                                    placeholder="'. __( "Your answer", $this->plugin_name ) .'"
                                    name="' . $this->html_name_prefix . 'answers-' . $this->unique_id . '[' . $question['id'] . ']">';

                    $content[] = '<div class="' . $this->html_class_prefix . 'input-underline"></div>';
                    $content[] = '<div class="' . $this->html_class_prefix . 'input-underline-animation"></div>';

                $content[] = '</div>';
            $content[] = '</div>';

        $content[] = '</div>';

        $content = implode( '', $content );

        return $content;
    }

    public function ays_survey_question_type_NUMBER_html( $question ){
        $content = array();

        $content[] = '<div class="' . $this->html_class_prefix . 'answer">';

            $content[] = '<div class="' . $this->html_class_prefix . 'question-box">';
                $content[] = '<div class="' . $this->html_class_prefix . 'question-input-box">';

                    $content[] = '<input class="' . 
                                    $this->html_class_prefix . 'remove-default-border ' . 
                                    $this->html_class_prefix . 'question-input ' . 
                                    $this->html_class_prefix . 'input" type="number" step="any" style="min-height: 24px;"
                                    placeholder="'. __( "Your answer", $this->plugin_name ) .'"
                                    name="' . $this->html_name_prefix . 'answers-' . $this->unique_id . '[' . $question['id'] . ']">';

                    $content[] = '<div class="' . $this->html_class_prefix . 'input-underline"></div>';
                    $content[] = '<div class="' . $this->html_class_prefix . 'input-underline-animation"></div>';

                $content[] = '</div>';
            $content[] = '</div>';

        $content[] = '</div>';

        $content = implode( '', $content );

        return $content;
    }

    public function ays_survey_question_type_EMAIL_html( $question ){
        $content = array();

        $content[] = '<div class="' . $this->html_class_prefix . 'answer">';

            $content[] = '<div class="' . $this->html_class_prefix . 'question-box">';
                $content[] = '<div class="' . $this->html_class_prefix . 'question-input-box">';

                    $content[] = '<input class="' . 
                                    $this->html_class_prefix . 'remove-default-border ' . 
                                    $this->html_class_prefix . 'question-email-input ' . 
                                    $this->html_class_prefix . 'question-input ' . 
                                    $this->html_class_prefix . 'input" type="text" style="min-height: 24px;"
                                    placeholder="'. __( "Your email", $this->plugin_name ) .'"
                                    name="' . $this->html_name_prefix . 'answers-' . $this->unique_id . '[' . $question['id'] . ']">';
                    if( true ){
                        $content[] = '<input type="hidden" name="' . $this->html_name_prefix . 'user-email-' . $this->unique_id . '" value="' . $question['id'] . '" >';
                    }

                    $content[] = '<div class="' . $this->html_class_prefix . 'input-underline"></div>';
                    $content[] = '<div class="' . $this->html_class_prefix . 'input-underline-animation"></div>';

                $content[] = '</div>';
            $content[] = '</div>';

        $content[] = '</div>';

        $content = implode( '', $content );

        return $content;
    }

    public function ays_survey_question_type_NAME_html( $question ){
        $content = array();

        $content[] = '<div class="' . $this->html_class_prefix . 'answer">';

            $content[] = '<div class="' . $this->html_class_prefix . 'question-box">';
                $content[] = '<div class="' . $this->html_class_prefix . 'question-input-box">';

                    $content[] = '<input class="' . 
                                    $this->html_class_prefix . 'remove-default-border ' . 
                                    $this->html_class_prefix . 'question-input ' . 
                                    $this->html_class_prefix . 'input" type="text" style="min-height: 24px;"
                                    placeholder="'. __( "Your name", $this->plugin_name ) .'"
                                    name="' . $this->html_name_prefix . 'answers-' . $this->unique_id . '[' . $question['id'] . ']">';

                    if( true ){
                        $content[] = '<input type="hidden" name="' . $this->html_name_prefix . 'user-name-' . $this->unique_id . '" value="' . $question['id'] . '" >';
                    }

                    $content[] = '<div class="' . $this->html_class_prefix . 'input-underline"></div>';
                    $content[] = '<div class="' . $this->html_class_prefix . 'input-underline-animation"></div>';

                $content[] = '</div>';
            $content[] = '</div>';

        $content[] = '</div>';

        $content = implode( '', $content );

        return $content;
    }

    public function create_restricted_content( $limit_message ){
		
		$content = array();
    	$content[] = '<div class="' . $this->html_class_prefix . 'section ' . $this->html_class_prefix . 'restricted-content">';

            $content[] = '<div class="' . $this->html_class_prefix . 'section-header">';
            
                $content[] = $limit_message;

	    	    // $content[] = '<div class="' . $this->html_class_prefix . 'section-title-row">';
		    	//     $content[] = '<div class="' . $this->html_class_prefix . 'section-title">' . $limit_message . '</div>';
	    	    // $content[] = '</div>';

                // $content[] = '<div class="' . $this->html_class_prefix . 'section-desc">' . stripslashes( $section['description'] ) . '</div>';

	    	$content[] = '</div>';

	    	// $content[] = '<div class="' . $this->html_class_prefix . 'section-footer">';
		    // 	$content[] = '<div class="' . $this->html_class_prefix . 'section-buttons">';
            //         $content[] = '<div class="' . $this->html_class_prefix . 'section-button-container">';
            //             $content[] = '<div class="' . $this->html_class_prefix . 'section-button-content">';
            //                 $content[] = '<input type="button" class="' . $this->html_class_prefix . 'section-button ' . $this->html_class_prefix . 'next-button" value="'. __( "Next", $this->plugin_name ) .'" />';
            //             $content[] = '</div>';
            //         $content[] = '</div>';
		    // 	$content[] = '</div>';
	    	// $content[] = '</div>';
    	
    	$content[] = '</div>';

    	$content = implode( '', $content );

    	return $content;
    }

    public function get_styles(){
		
		$content = array();
        $content[] = '<style type="text/css">';


        $question_image_width = '100%';
        if( $this->options[ $this->name_prefix . 'question_image_width' ] != '' ){
            $question_image_width = $this->options[ $this->name_prefix . 'question_image_width' ] . 'px';
        }

        $question_image_height = 'auto';
        if( $this->options[ $this->name_prefix . 'question_image_height' ] != '' ){
            $question_image_height = $this->options[ $this->name_prefix . 'question_image_height' ] . 'px';
        }


        $width = $this->options[ $this->name_prefix . 'width' ];
        $width_by = $this->options[ $this->name_prefix . 'width_by_percentage_px' ];
        
        if( $width == '' ){
            $width = '100';
            $width_by = 'percentage';
        }

        switch( $width_by ){
            case 'percentage':
                $width .= '%';
            break;
            case 'pixels':
                $width .= 'px';
            break;
            default:
                $width .= '%';
            break;
        }

        $content[] = '
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' {
                width: ' . $width . ';
            }

            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'section-header {
                border-top-color: ' . $this->options[ $this->name_prefix . 'color' ] . ';
            }
            
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'question {
                border-left-color: ' . $this->options[ $this->name_prefix . 'color' ] . ';
            }
            
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'section-header,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'question {
                background-color: ' . $this->options[ $this->name_prefix . 'background_color' ] . ';
            }
            
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' input.' . $this->html_class_prefix . 'question-input ~ .' . $this->html_class_prefix . 'input-underline,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' input.' . $this->html_class_prefix . 'question-input ~ .' . $this->html_class_prefix . 'input-underline-animation,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'simple-button-container,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'section-buttons .' . $this->html_class_prefix . 'section-button-container,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'answer-label-content > span,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'question-select.dropdown div.item,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'section-desc,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'question-title,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'section-title-row {
                color: ' . $this->options[ $this->name_prefix . 'text_color' ] . ';
            }
            
            
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'answer-label > input[type="checkbox"] ~ .' . $this->html_class_prefix . 'answer-label-content .' . $this->html_class_prefix . 'answer-icon-content .' . $this->html_class_prefix . 'answer-icon-content-3,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'answer-label > input[type="radio"] ~ .' . $this->html_class_prefix . 'answer-label-content .' . $this->html_class_prefix . 'answer-icon-content .' . $this->html_class_prefix . 'answer-icon-content-3,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'answer-label > input[type="checkbox"]:checked ~ .' . $this->html_class_prefix . 'answer-label-content .' . $this->html_class_prefix . 'answer-icon-content .' . $this->html_class_prefix . 'answer-icon-content-2,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'answer-label > input[type="radio"]:checked ~ .' . $this->html_class_prefix . 'answer-label-content .' . $this->html_class_prefix . 'answer-icon-content .' . $this->html_class_prefix . 'answer-icon-content-2,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'answer-label .' . $this->html_class_prefix . 'answer-image-container {
                border-color: ' . $this->options[ $this->name_prefix . 'color' ] . ';
            }
            
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' input.' . $this->html_class_prefix . 'input:focus ~ .' . $this->html_class_prefix . 'input-underline-animation {
                background-color: ' . $this->options[ $this->name_prefix . 'color' ] . ';
            }
            
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'section-buttons .' . $this->html_class_prefix . 'section-button-container .' . $this->html_class_prefix . 'section-button-content button.' . $this->html_class_prefix . 'section-button,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'section-buttons .' . $this->html_class_prefix . 'section-button-container .' . $this->html_class_prefix . 'section-button-content a.' . $this->html_class_prefix . 'section-button,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'section-buttons .' . $this->html_class_prefix . 'section-button-container .' . $this->html_class_prefix . 'section-button-content input.' . $this->html_class_prefix . 'section-button {
                color: ' . $this->options[ $this->name_prefix . 'buttons_text_color' ] . ';
            }
            
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'answer-label:hover .' . $this->html_class_prefix . 'answer-icon-ink,
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'section-buttons .' . $this->html_class_prefix . 'section-button-container:hover .' . $this->html_class_prefix . 'section-button-content input.' . $this->html_class_prefix . 'section-button {
                background-color: ' . Survey_Maker_Data::hex2rgba( $this->options[ $this->name_prefix . 'color' ], 0.04 ) . ';
            }

            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'question-title {
                font-size: ' . $this->options[ $this->name_prefix . 'question_font_size' ] . 'px;
            }
            
            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'question-image {
                width: ' . $question_image_width . ';
                height: ' . $question_image_height . ';
                object-fit: ' . $this->options[ $this->name_prefix . 'question_image_sizing' ] . ';
            }

            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'answer-label-content > span {
                font-size: ' . $this->options[ $this->name_prefix . 'answer_font_size' ] . 'px;
            }

            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'answer {
                padding: ' . $this->options[ $this->name_prefix . 'answers_padding' ] . 'px ' . $this->options[ $this->name_prefix . 'answers_padding' ] . 'px ' . $this->options[ $this->name_prefix . 'answers_padding' ] . 'px 0;
                margin: ' . $this->options[ $this->name_prefix . 'answers_gap' ] . 'px ' . $this->options[ $this->name_prefix . 'answers_gap' ] . 'px ' . $this->options[ $this->name_prefix . 'answers_gap' ] . 'px 0;
            }

            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'answer-image {
                object-fit: ' . $this->options[ $this->name_prefix . 'answers_object_fit' ] . ';
            }

            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'section-buttons .' . $this->html_class_prefix . 'section-button-container .' . $this->html_class_prefix . 'section-button-content input.' . $this->html_class_prefix . 'section-button {
                font-size: ' . $this->options[ $this->name_prefix . 'buttons_font_size' ] . 'px;
                padding-left: ' . $this->options[ $this->name_prefix . 'buttons_left_right_padding' ] . 'px;
                padding-right: ' . $this->options[ $this->name_prefix . 'buttons_left_right_padding' ] . 'px;
                padding-top: ' . $this->options[ $this->name_prefix . 'buttons_top_bottom_padding' ] . 'px;
                padding-bottom: ' . $this->options[ $this->name_prefix . 'buttons_top_bottom_padding' ] . 'px;
            }

            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'section-buttons .' . $this->html_class_prefix . 'section-button-container {
                border-radius: ' . $this->options[ $this->name_prefix . 'buttons_border_radius' ] . 'px;
            }

            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'question-select.dropdown div.text {
                font-size: ' . $this->options[ $this->name_prefix . 'answer_font_size' ] . 'px !important;
                color: ' . Survey_Maker_Data::hex2rgba( $this->options[ $this->name_prefix . 'text_color' ], 0.87 ) . ' !important;
            }

            #' . $this->html_class_prefix . 'container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'question-select.dropdown div.item {
                font-size: ' . $this->options[ $this->name_prefix . 'answer_font_size' ] . 'px !important;
                color: ' . $this->options[ $this->name_prefix . 'text_color' ] . ' !important;
            }
            
            ';
    	
    	$content[] = '</style>';

    	$content = implode( '', $content );

    	return $content;
    }

    public function get_custom_css(){
		
        $content = array();

        if( $this->options[ $this->name_prefix . 'custom_css' ] != '' ){

            $content[] = '<style type="text/css">';
            
	        	$content[] = $this->options[ $this->name_prefix . 'custom_css' ];
            
            $content[] = '</style>';
            
        }

        $content = implode( '', $content );

    	return $content;
    }

    public function get_encoded_options( $limit ){
        
        $content = array();

        if( ! $limit ){

            $quiz_content_script = "<script>";
        
            if( isset( $this->options[ $this->name_prefix . 'submit_redirect_delay' ] ) ){
                $this->options[ $this->name_prefix . 'submit_redirect_seconds'] = Survey_Maker_Data::secondsToWords( intval( $this->options[ $this->name_prefix . 'submit_redirect_delay' ] ) );
            }
                
                // $options['rw_answers_sounds'] = $enable_rw_asnwers_sounds;
                
            foreach( $this->options as $k => $q ){
                if( strpos( $k, 'email' ) !== false ){
                    unset( $this->options[ $k ] );
                }
            }
                
            $content[] = '<script type="text/javascript">';

            $this->options['is_user_logged_in'] = is_user_logged_in();
        
            $content[] = "
                    if(typeof aysSurveyOptions === 'undefined'){
                        var aysSurveyOptions = [];
                    }
                    aysSurveyOptions['" . $this->unique_id . "']  = '" . base64_encode( json_encode( $this->options ) ) . "';";
            
            $content[] = '</script>';
            
        }

        $content = implode( '', $content );

        return $content;
    }

}
