<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Survey_Maker
 * @subpackage Survey_Maker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Survey_Maker
 * @subpackage Survey_Maker/admin
 * @author     Survey Maker team <info@ays-pro.com>
 */
class Survey_Maker_Admin {

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

	/**
	 * The surveys list table object.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $surveys_obj    The surveys list table object.
	 */
    private $surveys_obj;

	/**
	 * The surveys categories list table object.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $surveys_categories_obj    The surveys categories list table object.
	 */
    private $surveys_categories_obj;

	/**
	 * The survey questions list table object.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $questions_obj    The survey questions list table object.
	 */
    private $questions_obj;

	/**
	 * The survey questions categories list table object.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $question_categories_obj    The survey questions categories list table object.
	 */
    private $question_categories_obj;

	/**
	 * The survey submissions list table object.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $results_obj    The survey submissions list table object.
	 */
    private $submissions_obj;

	/**
	 * The survey questions categories list table object for each survey.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $each_result_obj    The survey submissions list table object for each survey.
	 */
    private $each_submission_obj;

	/**
	 * The settings object of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $settings_obj    The settings object of this plugin.
	 */
    private $settings_obj;

	/**
	 * The capability of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $capability    The capability for users access to this plugin.
	 */
    private $capability;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        add_filter('set-screen-option', array(__CLASS__, 'set_screen'), 10, 3);
        // $per_page_array = array(
        //     'quizes_per_page',
        //     'questions_per_page',
        //     'quiz_categories_per_page',
        //     'question_categories_per_page',
        //     'attributes_per_page',
        //     'quiz_results_per_page',
        //     'quiz_each_results_per_page',
        //     'quiz_orders_per_page',
        // );
        // foreach($per_page_array as $option_name){
        //     add_filter('set_screen_option_'.$option_name, array(__CLASS__, 'set_screen'), 10, 3);
        // }

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook_suffix ) {

        wp_enqueue_style( $this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'css/admin.css', array(), $this->version, 'all');
        
        if (false !== strpos($hook_suffix, "plugins.php")){
            wp_enqueue_style( $this->plugin_name . '-sweetalert-css', SURVEY_MAKER_PUBLIC_URL . '/css/survey-maker-sweetalert2.min.css', array(), $this->version, 'all');
        }

        if (false === strpos($hook_suffix, $this->plugin_name))
            return;

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style( $this->plugin_name . '-banner.css', plugin_dir_url(__FILE__) . 'css/banner.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-animate.css', plugin_dir_url(__FILE__) . 'css/animate.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-animations.css', plugin_dir_url(__FILE__) . 'css/animations.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-font-awesome-icons', plugin_dir_url(__FILE__) . 'css/ays-font-awesome.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-select2', SURVEY_MAKER_PUBLIC_URL .  '/css/survey-maker-select2.min.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-transition', SURVEY_MAKER_PUBLIC_URL .  '/css/transition.min.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-dropdown', SURVEY_MAKER_PUBLIC_URL .  '/css/dropdown.min.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-data-bootstrap', plugin_dir_url(__FILE__) . 'css/dataTables.bootstrap4.min.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-datetimepicker', plugin_dir_url(__FILE__) . 'css/jquery-ui-timepicker-addon.css', array(), $this->version, 'all');

        wp_enqueue_style( $this->plugin_name . "-general", plugin_dir_url( __FILE__ ) . 'css/survey-maker-general.css', array(), time(), 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/survey-maker-admin.css', array(), time(), 'all' );
        wp_enqueue_style( $this->plugin_name . "-loaders", plugin_dir_url(__FILE__) . 'css/loaders.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook_suffix ) {

        if (false !== strpos($hook_suffix, "plugins.php")){
            wp_enqueue_script( $this->plugin_name . '-sweetalert-js', SURVEY_MAKER_PUBLIC_URL . '/js/survey-maker-sweetalert2.all.min.js', array('jquery'), $this->version, true );
            wp_enqueue_script( $this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array( 'jquery' ), $this->version, true );
            wp_localize_script( $this->plugin_name . '-admin', 'SurveyMakerAdmin', array( 
            	'ajaxUrl' => admin_url( 'admin-ajax.php' )
            ) );
        }
        
        if (false === strpos($hook_suffix, $this->plugin_name))
            return;

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-effects-core' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_media();
        wp_enqueue_script( $this->plugin_name . '-color-picker-alpha', plugin_dir_url(__FILE__) . 'js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), $this->version, true );
        $color_picker_strings = array(
            'clear'            => __( 'Clear', $this->plugin_name ),
            'clearAriaLabel'   => __( 'Clear color', $this->plugin_name ),
            'defaultString'    => __( 'Default', $this->plugin_name ),
            'defaultAriaLabel' => __( 'Select default color', $this->plugin_name ),
            'pick'             => __( 'Select Color', $this->plugin_name ),
            'defaultLabel'     => __( 'Color value', $this->plugin_name ),
        );
        wp_localize_script( $this->plugin_name . '-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );


		/* 
        ========================================== 
           * Bootstrap
           * select2
           * jQuery DataTables
        ========================================== 
        */
        wp_enqueue_script( $this->plugin_name . "-popper", plugin_dir_url(__FILE__) . 'js/popper.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . "-bootstrap", plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . '-select2js', SURVEY_MAKER_PUBLIC_URL . '/js/survey-maker-select2.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script( $this->plugin_name . '-sweetalert-js', SURVEY_MAKER_PUBLIC_URL . '/js/survey-maker-sweetalert2.all.min.js', array('jquery'), $this->version, true );
        wp_enqueue_script( $this->plugin_name . '-datatable-min', SURVEY_MAKER_PUBLIC_URL . '/js/survey-maker-datatable.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script( $this->plugin_name . '-transition-min', SURVEY_MAKER_PUBLIC_URL . '/js/transition.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script( $this->plugin_name . '-dropdown-min', SURVEY_MAKER_PUBLIC_URL . '/js/dropdown.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script( $this->plugin_name . "-db4.min.js", plugin_dir_url( __FILE__ ) . 'js/dataTables.bootstrap4.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . "-datetimepicker", plugin_dir_url( __FILE__ ) . 'js/jquery-ui-timepicker-addon.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . '-autosize', SURVEY_MAKER_PUBLIC_URL . '/js/survey-maker-autosize.js', array( 'jquery' ), $this->version, false );

        /* 
        ================================================
           Survey admin dashboard scripts (Google charts)
        ================================================
        */
        if ( strpos($hook_suffix, 'each-submission') !== false ) {
            wp_enqueue_script( $this->plugin_name . '-charts-google', plugin_dir_url(__FILE__) . 'js/google-chart.js', array('jquery'), $this->version, true);
            wp_enqueue_script( $this->plugin_name . '-charts', plugin_dir_url(__FILE__) . 'js/partials/survey-maker-admin-submissions-charts.js', array('jquery'), $this->version, true);
        }
        /* 

		/* 
        ================================================
           Quiz admin dashboard scripts (and for AJAX)
        ================================================
        */
        wp_enqueue_script( $this->plugin_name . "-survey-styles", plugin_dir_url(__FILE__) . 'js/partials/survey-maker-admin-survey-styles.js', array('jquery', 'wp-color-picker'), $this->version, true);
        wp_enqueue_script( $this->plugin_name . "-functions", plugin_dir_url(__FILE__) . 'js/functions.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . '-ajax', plugin_dir_url(__FILE__) . 'js/survey-maker-admin-ajax.js', array('jquery'), $this->version, true);
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/survey-maker-admin.js', array( 'jquery' ), $this->version, true );
        wp_localize_script( $this->plugin_name, 'SurveyMakerAdmin', array( 
        	'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'longAnswerText'     => __( 'Long answer text', $this->plugin_name ),
            'shortAnswerText'    => __( 'Short answer text', $this->plugin_name ),
            'numberAnswerText'   => __( 'Number answer text', $this->plugin_name ),
            'emailField'         => __( 'Email field', $this->plugin_name ),
            'nameField'          => __( 'Name field', $this->plugin_name ),
            'selectUserRoles'    => __( 'Select user roles', $this->plugin_name ),
            'addQuestion'        => __( 'Add question', $this->plugin_name ),
            'addSection'         => __( 'Add section', $this->plugin_name ),
            'duplicate'          => __( 'Duplicate', $this->plugin_name ),
            'delete'             => __( 'Delete', $this->plugin_name ),
        ) );

    }
    
    public function codemirror_enqueue_scripts($hook) {
        if(strpos($hook, $this->plugin_name) !== false){
            if(function_exists('wp_enqueue_code_editor')){
                $cm_settings['codeEditor'] = wp_enqueue_code_editor(array(
                    'type' => 'text/css',
                    'codemirror' => array(
                        'inputStyle' => 'contenteditable',
                        'theme' => 'cobalt',
                    )
                ));

                wp_enqueue_script('wp-theme-plugin-editor');
                wp_localize_script('wp-theme-plugin-editor', 'cm_settings', $cm_settings);

                wp_enqueue_style('wp-codemirror');
            }
        }
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu(){

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        global $wpdb;
        $sql = "SELECT COUNT(*) FROM " . esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "submissions WHERE `read` = 0 ";
        $unread_results_count = intval( $wpdb->get_var( $sql ) );
        $menu_item = ($unread_results_count == 0) ? 'Survey Maker' : 'Survey Maker' . '<span class="ays-survey-menu-badge ays-survey-results-bage">' . $unread_results_count . '</span>';
        
        $this->capability = $this->survey_maker_capabilities();
        $capability = $this->capability;
                
        add_menu_page(
            'Survey Maker', 
            $menu_item, 
            $this->capability,
            $this->plugin_name,
            array($this, 'display_plugin_surveys_page'), 
            'dashicons-analytics',//AYS_QUIZ_ADMIN_URL . '/images/icons/icon-128x128.png', 
            6
        );

    }

    public function add_plugin_surveys_submenu(){
        $hook_survey_maker = add_submenu_page(
            $this->plugin_name,
            __('Surveys', $this->plugin_name),
            __('Surveys', $this->plugin_name),
            $this->capability,
            $this->plugin_name,
            array($this, 'display_plugin_surveys_page')
        );

        add_action("load-$hook_survey_maker", array($this, 'screen_option_surveys'));
    }

    public function add_plugin_survey_categories_submenu(){
        $hook_survey_categories = add_submenu_page(
            $this->plugin_name,
            __('Survey Categories', $this->plugin_name),
            __('Survey Categories', $this->plugin_name),
            $this->capability,
            $this->plugin_name . '-survey-categories',
            array($this, 'display_plugin_survey_categories_page')
        );

        add_action("load-$hook_survey_categories", array($this, 'screen_option_survey_categories'));
    }

    public function add_plugin_submissions_submenu(){
        global $wpdb;
        $sql = "SELECT COUNT(*) FROM " . esc_sql( $wpdb->prefix . SURVEY_MAKER_DB_PREFIX ) . "submissions WHERE `read` = 0 ";
        $unread_results_count = intval( $wpdb->get_var( $sql ) );

        $results_text = __('Submissions', $this->plugin_name);
        $menu_item = ( $unread_results_count == 0 ) ? $results_text : $results_text . '<span class="ays-survey-menu-badge ays-survey-results-bage">' . $unread_results_count . '</span>';
        $hook_submissions = add_submenu_page(
            $this->plugin_name,
            $results_text,
            $menu_item,
            $this->capability,
            $this->plugin_name . '-submissions',
            array($this, 'display_plugin_submissions_page')
        );

        add_action("load-$hook_submissions", array($this, 'screen_option_submissions'));
        
        $hook_each_submission = add_submenu_page(
            'each_submission_slug',
            __('Each', $this->plugin_name),
            null,
            $this->capability,
            $this->plugin_name . '-each-submission',
            array($this, 'display_plugin_each_submission_page')
        );

        add_action("load-$hook_each_submission", array($this, 'screen_option_each_survey_submission'));

        add_filter('parent_file', array($this,'survey_maker_select_submenu'));
    }

    public function add_plugin_dashboard_submenu(){
        $hook_quizes = add_submenu_page(
            $this->plugin_name,
            __('How to use', $this->plugin_name),
            __('How to use', $this->plugin_name),
            $this->capability,
            $this->plugin_name . '-dashboard',
            array($this, 'display_plugin_setup_page')
        );
    }

    public function add_plugin_general_settings_submenu(){
        $hook_settings = add_submenu_page( $this->plugin_name,
            __('General Settings', $this->plugin_name),
            __('General Settings', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_plugin_settings_page') 
        );
        add_action("load-$hook_settings", array($this, 'screen_option_settings'));
    }

    public function add_plugin_featured_plugins_submenu(){
        add_submenu_page( $this->plugin_name,
            __('Featured Plugins', $this->plugin_name),
            __('Featured Plugins', $this->plugin_name),
            $this->capability,
            $this->plugin_name . '-featured-plugins',
            array($this, 'display_plugin_featured_plugins_page') 
        );
    }

    public function add_plugin_survey_features_plugins_submenu(){
        add_submenu_page( $this->plugin_name,
            __('PRO Featurs', $this->plugin_name),
            __('PRO Featurs', $this->plugin_name),
            $this->capability,
            $this->plugin_name . '-survey-features',
            array($this, 'display_plugin_features_page') 
        );
    }

    public function survey_maker_select_submenu($file) {
        global $plugin_page;
        if ($this->plugin_name."-each-submission" == $plugin_page) {
            $plugin_page = $this->plugin_name."-submissions";
        }
        return $file;
    }
    
    protected function survey_maker_capabilities(){
        global $wpdb;
        return 'read';
        return 'manage_options';

        $sql = "SELECT meta_value FROM {$wpdb->prefix}aysquiz_settings WHERE `meta_key` = 'user_roles'";
        $result = $wpdb->get_var($sql);
        
        $capability = 'manage_options';
        if($result !== null){
            $ays_user_roles = json_decode($result, true);
            if(is_user_logged_in()){
                $current_user = wp_get_current_user();
                $current_user_roles = $current_user->roles;
                $ishmar = 0;
                foreach($current_user_roles as $r){
                    if(in_array($r, $ays_user_roles)){
                        $ishmar++;
                    }
                }
                if($ishmar > 0){
                    $capability = "read";
                }
            }
        }
        return $capability;
    }


    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function add_action_links($links){
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url('admin.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_setup_page(){
        include_once('partials/survey-maker-admin-display.php');
    }

    public function display_plugin_surveys_page(){
        $action = (isset($_GET['action'])) ? sanitize_text_field($_GET['action']) : '';
        switch ($action) {
            case 'add':
                include_once('partials/surveys/actions/survey-maker-surveys-actions.php');
                break;
            case 'edit':
                include_once('partials/surveys/actions/survey-maker-surveys-actions.php');
                break;
            default:
                include_once('partials/surveys/survey-maker-surveys-display.php');
        }
    }

    public function display_plugin_survey_categories_page(){
        $action = (isset($_GET['action'])) ? sanitize_text_field($_GET['action']) : '';

        switch ($action) {
            case 'add':
                include_once('partials/surveys/actions/survey-maker-survey-categories-actions.php');
                break;
            case 'edit':
                include_once('partials/surveys/actions/survey-maker-survey-categories-actions.php');
                break;
            default:
                include_once('partials/surveys/survey-maker-survey-categories-display.php');
        }
    }

    public function display_plugin_submissions_page(){

        include_once('partials/submissions/survey-maker-submissions-display.php');
    }
    
    public function display_plugin_each_submission_page(){
        include_once 'partials/submissions/survey-maker-each-submission-display.php';
    }
    
    public function display_plugin_settings_page(){        
        include_once('partials/settings/survey-maker-settings.php');
    }

    public function display_plugin_featured_plugins_page(){
        include_once('partials/features/survey-maker-plugin-featured-display.php');
    }

    public function display_plugin_features_page(){
        include_once('partials/features/survey-maker-features-display.php');
    }

    public static function set_screen($status, $option, $value){
        return $value;
    }

    public function screen_option_surveys(){
        $option = 'per_page';
        $args = array(
            'label' => __('Surveys', $this->plugin_name),
            'default' => 20,
            'option' => 'surveys_per_page'
        );

        add_screen_option($option, $args);
        $this->surveys_obj = new Surveys_List_Table($this->plugin_name);
        $this->settings_obj = new Survey_Maker_Settings_Actions($this->plugin_name);
    }

    public function screen_option_survey_categories(){
        $option = 'per_page';
        $args = array(
            'label' => __('Survey Categories', $this->plugin_name),
            'default' => 20,
            'option' => 'survey_categories_per_page'
        );

        add_screen_option($option, $args);
        $this->surveys_categories_obj = new Survey_Categories_List_Table($this->plugin_name);
    }

    public function screen_option_submissions(){
        $option = 'per_page';
        $args = array(
            'label' => __('Submissions', $this->plugin_name),
            'default' => 20,
            'option' => 'survey_submissions_results_per_page'
        );

        add_screen_option($option, $args);
        $this->submissions_obj = new Submissions_List_Table( $this->plugin_name );
    }

    public function screen_option_each_survey_submission() {
        $option = 'per_page';
        $args = array(
            'label' => __('Results', $this->plugin_name),
            'default' => 50,
            'option' => 'survey_each_submission_results_per_page',
        );

        add_screen_option($option, $args);
        $this->each_submission_obj = new Survey_Each_Submission_List_Table($this->plugin_name);
    }
    
    public function screen_option_settings(){
        $this->settings_obj = new Survey_Maker_Settings_Actions($this->plugin_name);
    }

    public function deactivate_plugin_option(){
        $request_value = sanitize_text_field( $_REQUEST['upgrade_plugin'] );
        $upgrade_option = get_option( 'ays_survey_maker_upgrade_plugin', '' );
        if($upgrade_option === ''){
            add_option( 'ays_survey_maker_upgrade_plugin', $request_value );
        }else{
            update_option( 'ays_survey_maker_upgrade_plugin', $request_value );
        }
        ob_end_clean();
        $ob_get_clean = ob_get_clean();
        echo json_encode( array( 'option' => get_option( 'ays_survey_maker_upgrade_plugin', '' ) ) );
        wp_die();
    }

    public static function ays_restriction_string($type, $x, $length){
        $output = "";
        switch($type){
            case "char":                
                if(strlen($x)<=$length){
                    $output = $x;
                } else {
                    $output = substr($x,0,$length) . '...';
                }
                break;
            case "word":
                $res = explode(" ", $x);
                if(count($res)<=$length){
                    $output = implode(" ",$res);
                } else {
                    $res = array_slice($res,0,$length);
                    $output = implode(" ",$res) . '...';
                }
            break;
        }
        return $output;
    }    
    
    public static function validateDate($date, $format = 'Y-m-d H:i:s'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function get_max_id( $table ) {
        global $wpdb;
        $db_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . $table;

        $sql = "SELECT MAX(id) FROM {$db_table}";

        $result = intval( $wpdb->get_var( $sql ) );

        return $result;
    }

    public function get_all_surveys(){
        global $wpdb;
        $surveys_table = $wpdb->prefix . "ayssurvey_surveys";
        $surveys = $wpdb->get_results("SELECT * FROM {$surveys_table}");
        return $surveys;
    }

    public static function string_starts_with_number($string){
        $match = preg_match('/^\d/', $string);
        if($match === 1){
            return true;
        }else{
            return false;
        }
    }

    public function get_question_answers( $question_id ) {
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ayssurvey_answers WHERE question_id=" . absint( intval( $question_id ) );

        $results = $wpdb->get_results( $sql, 'ARRAY_A' );
        foreach ($results as $key => &$result) {
            unset($result['id']);
            unset($result['question_id']);
        }

        return $results;
    }

    public function ays_survey_question_results( $survey_id, $submission_ids = null ){
        global $wpdb;
        // $survey_id = isset( $_GET['survey'] ) ? intval( $_GET['survey'] ) : null;

        if($survey_id === null){
            return false;
        }

        $submitions_questiions_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions_questions";
        $answer_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "answers";
        $question_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "questions";
        $submitions_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions";
        $survey_section_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "sections";
        $surveys_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys";

        $question_ids = "SELECT question_ids FROM {$surveys_table} WHERE id =". $survey_id;
        $question_ids_results = $wpdb->get_var( $question_ids );
        $ays_question_id = ($question_ids_results != '') ? $question_ids_results : null;

        if($ays_question_id == null){
            return false;
        }

        $questions_ids_arr = explode(',',$ays_question_id);
        $answer_id = "SELECT a.id, a.answer, COUNT(s_q.answer_id) AS answer_count
                    FROM {$answer_table} AS a
                    LEFT JOIN {$submitions_questiions_table} AS s_q 
                    ON a.id = s_q.answer_id
                    GROUP BY a.id";

        $answer_id_result = $wpdb->get_results($answer_id,'ARRAY_A');

        $for_checkbox = "SELECT a.id, a.answer, COUNT(s_q.answer_id) AS answer_count
                    FROM {$answer_table} AS a
                    LEFT JOIN {$submitions_questiions_table} AS s_q 
                    ON a.id = s_q.answer_id OR FIND_IN_SET( a.id, s_q.user_answer )
                    WHERE s_q.type = 'checkbox'
                    GROUP BY a.id";

        $for_checkbox_result = $wpdb->get_results($for_checkbox,'ARRAY_A');

        $for_text_type = "SELECT a.id, a.answer, COUNT(s_q.id) AS answer_count
                    FROM {$answer_table} AS a
                    LEFT JOIN {$submitions_questiions_table} AS s_q 
                    ON a.id = s_q.answer_id OR FIND_IN_SET( a.id, s_q.user_answer )
                    WHERE s_q.type IN ('name', 'email', 'text', 'short_text', 'number')
                    GROUP BY a.id";

        $for_text_type_result = $wpdb->get_results($for_checkbox,'ARRAY_A');

        $answer_count = array();
        $question_type = '';
        foreach ($answer_id_result as $key => $answer_count_by_id) {
            $ays_survey_answer_count = (isset($answer_count_by_id['answer_count']) && $answer_count_by_id['answer_count'] !="") ? absint(intval($answer_count_by_id['answer_count'])) : '';
            $answer_count[$answer_count_by_id['id']] = $ays_survey_answer_count;
        }

        foreach ($for_checkbox_result as $key => $answer_count_by_id) {
            $ays_survey_answer_count = (isset($answer_count_by_id['answer_count']) && $answer_count_by_id['answer_count'] !="") ? absint(intval($answer_count_by_id['answer_count'])) : '';
            $answer_count[$answer_count_by_id['id']] = $ays_survey_answer_count;
        }

        foreach ($for_text_type_result as $key => $answer_count_by_id) {
            $ays_survey_answer_count = (isset($answer_count_by_id['answer_count']) && $answer_count_by_id['answer_count'] !="") ? absint(intval($answer_count_by_id['answer_count'])) : '';
            $answer_count[$answer_count_by_id['id']] = $ays_survey_answer_count;
        }

        $question_by_ids = Survey_Maker_Data::get_question_by_ids( $questions_ids_arr );

        $select_answer_q_type = "SELECT q.type, s_q.user_answer, s_q.id
            FROM {$question_table} AS q
            JOIN {$submitions_questiions_table} AS s_q 
            ON q.type = s_q.type
            WHERE s_q.user_answer != '' 
            AND s_q.type != 'checkbox' 
            AND s_q.survey_id=".$survey_id;

        if( $submission_ids !== null ){
            if( is_array( $submission_ids ) ){
                $select_answer_q_type .= " AND s_q.submission_id IN (" . implode( ',', $submission_ids ) . ") ";
            }
        }
            
        $result_answers_q_type = $wpdb->get_results($select_answer_q_type,'ARRAY_A');
        $text_answer = array();
        foreach($result_answers_q_type as $key => $result_answer_q_type){
            $text_answer[$result_answer_q_type['type']][$result_answer_q_type['id']] = $result_answer_q_type['user_answer'];
        }

        $text_types = array(
            'text',
            'short_text',
            'number',
            'name',
            'email',
        );

        //Question types different charts
        $ays_submissions_count  = array();
        $question_results = array();
        
        $total_count = 0;
        foreach ($question_by_ids as $key => $question) {
            $answers = $question->answers;
            $question_id = $question->id;
            $question_title = $question->question;

            //questions
            $question_results[$question_id]['question_id'] = $question_id;
            $question_results[$question_id]['question'] = $question_title;
            $ays_answer = array();
            $question_answer_ids = array();
            foreach ($answers as $key => $answer) {
                $answer_id = $answer->id;
                $answer_title = $answer->answer;
                
                $ays_answer[$answer_id] = $answer_count[$answer_id];
                $question_answer_ids[$answer_id] = $answer_title;
            }
            
            
            //sum of submissions count per questions
            $sum_of_count = array_sum( array_values( $ays_answer ) );

            if( in_array( $question->type, $text_types ) ){
                $question_results[$question_id]['answers'] = $text_answer[$question->type];
                $question_results[$question_id]['answerTitles'] = $text_answer[$question->type];
                $question_results[$question_id]['sum_of_answers_count'] = count( $text_answer[$question->type] );
            }else{
                $question_results[$question_id]['answers'] = $ays_answer;
                $question_results[$question_id]['answerTitles'] = $question_answer_ids;
                $question_results[$question_id]['sum_of_answers_count'] = $sum_of_count;
            }

            $total_count += intval( $question_results[$question_id]['sum_of_answers_count'] );

            $question_results[$question_id]['question_type'] = $question->type;
        }

        return array(
            'total_count' => $total_count,
            'questions' => $question_results
        );
    }
    
    public function ays_survey_get_last_submission_id( $survey_id ){
        global $wpdb;

        if($survey_id === null){
            return false;
        }

        $submitions_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions";

        //submission of each result
        $submission = "SELECT * FROM {$submitions_table} WHERE survey_id=".$survey_id." ORDER BY id DESC LIMIT 1 ";
        $last_submission = $wpdb->get_row( $submission, 'ARRAY_A' );
        
        return $last_submission;
    }

    public function ays_survey_individual_results_for_one_submission( $submission, $survey ){
        global $wpdb;
        $survey_id = isset( $survey['id'] ) ? absint( intval( $survey['id'] ) ) : null;

        if( is_null( $survey_id ) ){
            return array(
                'submission_id' => 0,
                'questions' => array(),
                'sections' => array(),
            );
        }

        if( is_null( $submission ) ){
            return array(
                'submission_id' => 0,
                'questions' => array(),
                'sections' => array(),
            );
        }

        $submitions_questiions_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions_questions";

        $ays_individual_questions_for_one_submission = array();
        $question_answer_id = array();

        $checkbox_ids = '';
        
        $individual_questions = "SELECT * FROM {$submitions_questiions_table} WHERE submission_id=" . $submission['id'];
        $individual_questions_results = $wpdb->get_results($individual_questions,'ARRAY_A');

        // Survey questions IDs
        $question_ids = isset( $survey['question_ids'] ) && $survey['question_ids'] != '' ? $survey['question_ids'] : '';

        // Section Ids
        $sections_ids = (isset( $survey['section_ids' ] ) && $survey['section_ids'] != '') ? $survey['section_ids'] : '';

        $sections = Survey_Maker_Data::get_sections_by_survey_id($sections_ids);
        $sections_count = count( $sections );
        
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
    
        $text_types = array(
            'text',
            'short_text',
            'number',
            'name',
            'email',
        );

        foreach ($individual_questions_results as $key => $individual_questions_result) {
            if($individual_questions_result['type'] == 'checkbox'){
                $checkbox_ids = $individual_questions_result['user_answer'] != '' ? explode(',', $individual_questions_result['user_answer']) : array();
                $question_answer_id[ $individual_questions_result['question_id'] ] = $checkbox_ids;
            }elseif( in_array( $individual_questions_result['type'], $text_types ) ){
                $question_answer_id[ $individual_questions_result['question_id'] ] = $individual_questions_result['user_answer'];
            }else{
                $question_answer_id[ $individual_questions_result['question_id'] ] = $individual_questions_result['answer_id'];
            }
        }
        $ays_individual_questions_for_one_submission['submission_id'] = $submission['id'];
        $ays_individual_questions_for_one_submission['questions'] = $question_answer_id;
        $ays_individual_questions_for_one_submission['sections'] = $sections;

        return $ays_individual_questions_for_one_submission;
    }

    public function ays_survey_submission_question_results( $id, $submission_id ) {
        global $wpdb;
        $survey_id = isset( $id ) ? absint( intval( $id ) ) : null;
        $submission_id = isset( $submission_id ) ? absint( intval( $submission_id ) ) : null;

        if( is_null( $survey_id ) || is_null( $submission_id ) ){
            return false;
        }

        $submitions_questiions_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions_questions";
        $answer_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "answers";
        $question_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "questions";
        $submitions_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions";
        $survey_section_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "sections";

        $question_ids = "SELECT questions_ids FROM {$submitions_table} WHERE survey_id =". $survey_id. " ORDER BY id DESC LIMIT 1";
        $question_ids_results = $wpdb->get_row($question_ids,'ARRAY_A');
        $ays_question_id = (isset($question_ids_results['questions_ids']) && $question_ids_results['questions_ids'] != '') ? $question_ids_results['questions_ids'] : null;

        if($ays_question_id == null){
            return false;
        }

        $questions_ids_arr = explode(',',$ays_question_id);
        $answer_id = "SELECT a.id,a.answer, COUNT(s_q.answer_id) AS answer_count
                    FROM {$answer_table} AS a
                    LEFT JOIN {$submitions_questiions_table} AS s_q 
                    ON a.id = s_q.answer_id
                    GROUP BY a.id";
        $answer_id_result = $wpdb->get_results($answer_id,'ARRAY_A');
        $answer_count = array();
        $question_type = '';
        foreach ($answer_id_result as $key => $answer_count_by_id) {
            $ays_survey_answer_count = (isset($answer_count_by_id['answer_count']) && $answer_count_by_id['answer_count'] !="") ? absint(intval($answer_count_by_id['answer_count'])) : '';
            $answer_count[$answer_count_by_id['id']] = $ays_survey_answer_count;
        }

        $question_by_ids = Survey_Maker_Data::get_question_by_ids($questions_ids_arr);
       
        $select_answer_q_type = "SELECT q.type,s_q.user_answer,s_q.id,s_q.answer_id
                                FROM {$question_table} AS q
                                JOIN {$submitions_questiions_table} AS s_q 
                                ON q.type = s_q.type
                                WHERE s_q.user_answer != '' 
                                AND s_q.type != 'checkbox' 
                                AND s_q.survey_id=".$survey_id."
                                AND s_q.submission_id=".$submission_id;
        $result_answers_q_type = $wpdb->get_results($select_answer_q_type,'ARRAY_A');

        $text_answer = array();
        foreach($result_answers_q_type as $key => $result_answer_q_type){
            $text_answer[$result_answer_q_type['type']][$result_answer_q_type['user_answer']] = $result_answer_q_type['id'];
        }
        
        //Question types different charts
        $ays_submissions_count  = array();
        $question_results = array();
        foreach ($question_by_ids as $key => $question) {
            $answers = $question->answers;
            $question_id = $question->id;
            $question_title = $question->question;

            //questions
            $question_results[$question_id]['question_id'] = $question_id;
            $question_results[$question_id]['question'] = $question_title;
            $ays_answer = array();
            $question_answer_ids = array();
            foreach ($answers as $key => $answer) {
                $answer_id = $answer->id;
                $answer_title = $answer->answer;
                
                $ays_answer[$answer_title] = $answer_count[$answer_id];
                $question_answer_ids[$answer_title] = $answer_id;
            }
            //sum of submissions count per questions
            $sum_of_count = array_sum(array_values($ays_answer));
            
            if($question->type == 'short_text' || $question->type == 'number' || $question->type == 'text'){
                $question_results[$question_id]['answers'] = $text_answer[$question->type];
                $question_results[$question_id]['answer_id'] = $text_answer[$question->type];
            }else{
                $question_results[$question_id]['answers'] = $ays_answer;
                $question_results[$question_id]['answer_id'] = $question_answer_ids;
            }

            $question_results[$question_id]['sum_of_answers_count'] = $sum_of_count;
            $question_results[$question_id]['question_type'] = $question->type;
        }
        return $question_results;
    }

    public function get_submission_count_and_ids(){
        global $wpdb;
        $survey_id = isset($_GET['survey']) ? absint( intval($_GET['survey']) ) : null;

        if($survey_id === null){
            return false;
        }
        $submitions_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions";
       
        //submission of each result
        $submission_ids = "SELECT id,
                            (SELECT COUNT(id) FROM {$submitions_table} i 
                            WHERE i.survey_id=j.survey_id) AS count_submission 
                            FROM {$submitions_table} j 
                            WHERE survey_id=".$survey_id."
                            ORDER BY id";
        $submission_ids_result = $wpdb->get_results($submission_ids,'ARRAY_A');
        $submission_count = '';
        $submissions_id_arr = array();
        foreach ($submission_ids_result as $key => $submission_id_result) {
            $submission_id_count = $submission_id_result['count_submission'];
            $submission_count = intval($submission_id_count);
            $submissions_id_arr[] = $submission_id_result['id'];
        }
        $submissions_id_str = implode(',', $submissions_id_arr );
        
        $submission_count_and_ids = array(
            'submission_count' => $submission_count,
            'submission_ids' => $submissions_id_str
        );

        return $submission_count_and_ids;
    }

    public function ays_survey_submission_report(){
        global $wpdb;
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'ays_survey_submission_report') {

            $survey_id = (isset($_REQUEST['surveyId']) && $_REQUEST['surveyId'] != "") ? absint( intval($_REQUEST['surveyId']) ) : null;
            if($survey_id === null){
                return false;
            }
            
            $sql = "SELECT * FROM " . $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys WHERE id =" . $survey_id;
            $survey = $wpdb->get_row( $sql, 'ARRAY_A' );

            $submission_id = (isset($_REQUEST['submissionId']) && $_REQUEST['submissionId'] != '') ? absint( intval($_REQUEST['submissionId']) ) : null;
            if($submission_id == null){
                return false;
            }
            $submission = array(
                'id' => $submission_id
            );

            $results = $this->ays_survey_individual_results_for_one_submission( $submission, $survey );
            // var_dump($results);
            // die();
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
            $response = array(
                'status' => true,
                'questions' => $results['questions']
            );
            echo json_encode($response);
            wp_die();
        }
        ob_end_clean();
        $ob_get_clean = ob_get_clean();
        $response = array(
            'status' => false
        );
        echo json_encode($response);
        wp_die();
    }

}