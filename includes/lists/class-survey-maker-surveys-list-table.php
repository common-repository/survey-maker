<?php
ob_start();
class Surveys_List_Table extends WP_List_Table {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The table name in database of the survey categories.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $table_name    The table name in database of the survey categories.
     */
    private $table_name;

    /**
     * The settings object of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      object    $settings_obj    The settings object of this plugin.
     */
    private $settings_obj;


    /** Class constructor */
    public function __construct( $plugin_name ) {
        global $wpdb;

        $this->plugin_name = $plugin_name;

        $this->table_name = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys";

        $this->settings_obj = new Survey_Maker_Settings_Actions($this->plugin_name);

        parent::__construct( array(
            'singular' => __( 'Survey', $this->plugin_name ), //singular name of the listed records
            'plural'   => __( 'Surveys', $this->plugin_name ), //plural name of the listed records
            'ajax'     => false //does this table support ajax?
        ) );

        add_action( 'admin_notices', array( $this, 'survey_notices' ) );

    }

    /**
     * Override of table nav to avoid breaking with bulk actions & according nonce field
     */
    public function display_tablenav( $which ) {
        ?>
        <div class="tablenav <?php echo esc_attr( $which ); ?>">
            
            <div class="alignleft actions">
                <?php  $this->bulk_actions( $which ); ?>
            </div>
            <?php
            $this->extra_tablenav( $which );
            $this->pagination( $which );
            ?>
            <br class="clear" />
        </div>
        <?php
    }

    /**
     * Disables the views for 'side' context as there's not enough free space in the UI
     * Only displays them on screen/browser refresh. Else we'd have to do this via an AJAX DB update.
     *
     * @see WP_List_Table::extra_tablenav()
     */
    public function extra_tablenav( $which ) {
        global $wpdb;
        $titles_sql = "SELECT s.title, s.id
                       FROM " .$wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "survey_categories AS s";
        $cat_titles = $wpdb->get_results($titles_sql);

        $cat_id = null;
        if( isset( $_GET['filterby'] )){
            $cat_id = intval($_GET['filterby']);
        }
        $categories_select = array();
        foreach($cat_titles as $key => $cat_title){
            $selected = "";
            if($cat_id === intval($cat_title->id)){
                $selected = "selected";
            }
            $categories_select[$cat_title->id]['title'] = $cat_title->title;
            $categories_select[$cat_title->id]['selected'] = $selected;
            $categories_select[$cat_title->id]['id'] = $cat_title->id;
        }
        sort($categories_select);
        ?>
        <div id="category-filter-div-surveylist" class="alignleft actions bulkactions">
            <select name="filterby-<?php echo $which; ?>" id="survey-category-filter-<?php echo $which; ?>">
                <option value=""><?php echo __('Select Category',$this->plugin_name)?></option>
                <?php
                    foreach($categories_select as $key => $cat_title){
                        echo "<option ".$cat_title['selected']." value='".$cat_title['id']."'>".$cat_title['title']."</option>";
                    }
                ?>
            </select>
            <input type="button" id="doaction-<?php echo $which; ?>" class="cat-filter-apply-<?php echo $which; ?> button" value="Filter">
        </div>
        
        <a style="margin: 0px 8px 0 0;" href="?page=<?php echo esc_url( $_REQUEST['page'] ); ?>" class="button"><?php echo __( "Clear filters", $this->plugin_name ); ?></a>
        <?php
    }
    
    protected function get_views() {
        $published_count = $this->get_statused_record_count( 'published' );
        $draft_count = $this->get_statused_record_count( 'draft' );
        $trashed_count = $this->get_statused_record_count( 'trashed' );
        $all_count = $this->all_record_count();
        $selected_all = "";
        $selected_published = "";
        $selected_draft = "";
        $selected_trashed = "";
        if(isset($_GET['fstatus'])){
            switch($_GET['fstatus']){
                case "published":
                    $selected_published = " style='font-weight:bold;' ";
                    break;
                case "draft":
                    $selected_draft = " style='font-weight:bold;' ";
                    break;
                case "trashed":
                    $selected_trashed = " style='font-weight:bold;' ";
                    break;
                default:
                    $selected_all = " style='font-weight:bold;' ";
                    break;
            }
        }else{
            $selected_all = " style='font-weight:bold;' ";
        }
        $status_links = array(
            "all" => "<a ".$selected_all." href='?page=".esc_attr( $_REQUEST['page'] )."'>" . __( "All", $this->plugin_name ) . " (".$all_count.")</a>",
        );
        if( intval( $published_count ) > 0 ){
            $status_links["published"] = "<a ".$selected_published." href='?page=".esc_attr( $_REQUEST['page'] )."&fstatus=published'>" . __( "Published", $this->plugin_name ) . " (".$published_count.")</a>";
        }
        if( intval( $draft_count ) > 0 ){
            $status_links["draft"] = "<a ".$selected_draft." href='?page=".esc_attr( $_REQUEST['page'] )."&fstatus=draft'>" . __( "Draft", $this->plugin_name ) . " (".$draft_count.")</a>";
        }
        if( intval( $trashed_count ) > 0 ){
            $status_links["trashed"] = "<a ".$selected_trashed." href='?page=".esc_attr( $_REQUEST['page'] )."&fstatus=trashed'>" . __( "Trash", $this->plugin_name ) . " (".$trashed_count.")</a>";
        }
        return $status_links;
    }

    /**
     * Retrieve customers data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    public static function get_items( $per_page = 20, $page_number = 1, $search = '' ) {

        global $wpdb;
        
        $sql = "SELECT * FROM ". $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys";
        
        $where = array();

        if ( isset( $_GET['fstatus'] ) && $_GET['fstatus'] != ''){
            $where[] = ' status = "' . esc_sql( $_GET['fstatus'] ) . '" ';
        }else{
            $where[] = ' status != "trashed" ';
        }

        if( $search != '' ){
            $where[] = $search;
        }

        if(! empty( $_REQUEST['filterby'] ) && intval( $_REQUEST['filterby'] ) > 0){
            $cat_id = intval($_REQUEST['filterby']);
            $where[] = ' '.$cat_id.' IN (category_ids) ';
        }

        if ( ! empty( $where ) ){
            $sql .= ' WHERE ' . implode( ' AND ', $where );
        }

        if ( ! empty( $_REQUEST['orderby'] ) ) {
            $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
            $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' DESC';
        }else{
            $sql .= ' ORDER BY ordering DESC';
        }
        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        return $result;
    }

    public function get_categories(){
        global $wpdb;

        $sql = "SELECT * FROM " . $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "survey_categories ORDER BY title ASC";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    public static function get_item_by_id( $id ){
        global $wpdb;

        $sql = "SELECT * FROM " . $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys WHERE id=" . absint( intval( $id ) );

        $result = $wpdb->get_row($sql, 'ARRAY_A');

        return $result;
    }
    

    public function add_or_edit_item(){
        global $wpdb;
        $table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys";
        $sections_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "sections";
        $questions_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "questions";
        $answers_table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "answers";

        // echo htmlentities(json_encode($data));
        // echo "<hr>";
        // echo htmlentities(json_encode($_POST));
        // die();
        $data = array();

        if( isset( $_POST["survey_action"] ) && wp_verify_nonce( $_POST["survey_action"], 'survey_action' ) ){

            $name_prefix = 'ays_';
            
            // Save type
            $save_type = (isset($_POST['save_type'])) ? sanitize_text_field( $_POST['save_type'] ) : '';

            // Id of item
            $id = isset( $_POST['id'] ) ? absint( intval( $_POST['id'] ) ) : 0;

            // Ordering
            $max_id = $this->get_max_id();
            $ordering = ( $max_id != NULL ) ? ( absint( intval( $max_id ) ) + 1 ) : 1;
            
            // Author ID
            $user_id = get_current_user_id();
            $author_id = isset( $_POST[ $name_prefix . 'author_id' ] ) && $_POST[ $name_prefix . 'author_id' ] != '' ? absint( intval( $_POST[ $name_prefix . 'author_id' ] ) ) : $user_id;

            // Title
            $title = isset( $_POST[ $name_prefix . 'title' ] ) && $_POST[ $name_prefix . 'title' ] != '' ? stripslashes( sanitize_text_field( $_POST[ $name_prefix . 'title' ] ) ) : '';

            // if($title == ''){
            //     $url = esc_url_raw( remove_query_arg( false ) );
            //     wp_redirect( $url );
            // }

            // Description
            $description = isset( $_POST[ $name_prefix . 'description' ] ) && $_POST[ $name_prefix . 'description' ] != '' ? stripslashes( sanitize_textarea_field( $_POST[ $name_prefix . 'description' ] ) ) : '';

            // Status
            $status = isset( $_POST[ $name_prefix . 'status' ] ) && $_POST[ $name_prefix . 'status' ] != '' ? sanitize_text_field( $_POST[ $name_prefix . 'status' ] ) : 'published';

            // Trash status
            $trash_status = '';
            
            // Date created
            $date_created = isset( $_POST[ $name_prefix . 'date_created' ] ) && Survey_Maker_Admin::validateDate( $_POST[ $name_prefix . 'date_created' ] ) ? sanitize_text_field( $_POST[ $name_prefix . 'date_created' ] ) : current_time( 'mysql' );
            
            // Date modified
            $date_modified = isset( $_POST[ $name_prefix . 'date_modified' ] ) && Survey_Maker_Admin::validateDate( $_POST[ $name_prefix . 'date_modified' ] ) ? sanitize_text_field( $_POST[ $name_prefix . 'date_modified' ] ) : current_time( 'mysql' );

            // Survey categories IDs
            $category_ids = isset( $_POST[ $name_prefix . 'category_ids' ] ) && $_POST[ $name_prefix . 'category_ids' ] != '' ? array_map( 'sanitize_text_field', $_POST[ $name_prefix . 'category_ids' ] ) : array();
            $category_ids = empty( $category_ids ) ? '' : implode( ',', $category_ids );

            // Survey questions IDs
            $question_ids = isset( $_POST[ $name_prefix . 'question_ids' ] ) && $_POST[ $name_prefix . 'question_ids' ] != '' ? array_map( 'sanitize_text_field', $_POST[ $name_prefix . 'question_ids' ] ) : array();
            // $question_ids = empty( $question_ids ) ? '' : implode( ',', $question_ids );

            // Survey image
            $image = isset( $_POST[ $name_prefix . 'image' ] ) && $_POST[ $name_prefix . 'image' ] != '' ? sanitize_text_field( $_POST[ $name_prefix . 'image' ] ) : '';

            // Post ID
            $post_id = isset( $_POST[ $name_prefix . 'post_id' ] ) && ! empty( $_POST[ $name_prefix . 'post_id' ] ) ? absint( intval( $_POST[ $name_prefix . 'post_id' ] ) ) : 0;

            // Section ids
            $section_ids = (isset( $_POST[ $name_prefix . 'sections_ids' ] ) && $_POST[ $name_prefix . 'sections_ids' ] != '') ? array_map( 'sanitize_text_field', $_POST[ $name_prefix . 'sections_ids' ] ) : array();


            // =======================  //  ======================= // ======================= // ======================= // ======================= //

            // =============================================================
            // ======================    Styles Tab    =====================
            // ========================    START    ========================


            // Survey Theme
            $survey_theme = (isset( $_POST[ $name_prefix . 'survey_theme' ] ) && $_POST[ $name_prefix . 'survey_theme' ] != '') ? stripslashes( sanitize_text_field( $_POST[ $name_prefix . 'survey_theme' ] ) ) : 'classic_light';

            // Survey Color
            $survey_color = (isset( $_POST[ $name_prefix . 'survey_color' ] ) && $_POST[ $name_prefix . 'survey_color' ] != '') ? stripslashes( sanitize_text_field( $_POST[ $name_prefix . 'survey_color' ] ) ) : 'rgb(255, 87, 34)';

            // Background color
            $survey_background_color = (isset( $_POST[ $name_prefix . 'survey_background_color' ] ) && $_POST[ $name_prefix . 'survey_background_color' ] != '') ? stripslashes( sanitize_text_field( $_POST[ $name_prefix . 'survey_background_color' ] ) ) : '#fff';

            // Text Color
            $survey_text_color = (isset( $_POST[ $name_prefix . 'survey_text_color' ] ) && $_POST[ $name_prefix . 'survey_text_color' ] != '') ? stripslashes( sanitize_text_field( $_POST[ $name_prefix . 'survey_text_color' ] ) ) : '#333';

            // Buttons text Color
            $survey_buttons_text_color = (isset( $_POST[ $name_prefix . 'survey_buttons_text_color' ] ) && $_POST[ $name_prefix . 'survey_buttons_text_color' ] != '') ? stripslashes( sanitize_text_field( $_POST[ $name_prefix . 'survey_buttons_text_color' ] ) ) : '#333';

            // Width
            $survey_width = (isset( $_POST[ $name_prefix . 'survey_width' ] ) && $_POST[ $name_prefix . 'survey_width' ] != '') ? absint( intval( $_POST[ $name_prefix . 'survey_width' ] ) ) : '';

            // Survey Width by percentage or pixels
            $survey_width_by_percentage_px = (isset( $_POST[ $name_prefix . 'survey_width_by_percentage_px' ] ) && $_POST[ $name_prefix . 'survey_width_by_percentage_px' ] != '') ? stripslashes( sanitize_text_field( $_POST[ $name_prefix . 'survey_width_by_percentage_px' ] ) ) : 'pixels';

            // Custom class for survey container
            $survey_custom_class = (isset( $_POST[ $name_prefix . 'survey_custom_class' ] ) && $_POST[ $name_prefix . 'survey_custom_class' ] != '') ? stripslashes( esc_attr( $_POST[ $name_prefix . 'survey_custom_class' ] ) ) : ''; 

            // Custom CSS
            $survey_custom_css = (isset( $_POST[ $name_prefix . 'survey_custom_css' ] ) && $_POST[ $name_prefix . 'survey_custom_css' ] != '') ? stripslashes( esc_attr( $_POST[ $name_prefix . 'survey_custom_css' ] ) ) : '';



            // =========== Questions Styles Start ===========

            // Question font size
            $survey_question_font_size = (isset( $_POST[ $name_prefix . 'survey_question_font_size' ] ) && $_POST[ $name_prefix . 'survey_question_font_size' ] != '') ? absint ( intval( $_POST[ $name_prefix . 'survey_question_font_size' ] ) ) : 16;

            // Question Image Width
            $survey_question_image_width = (isset( $_POST[ $name_prefix . 'survey_question_image_width' ] ) && $_POST[ $name_prefix . 'survey_question_image_width' ] != '') ? absint ( intval( $_POST[ $name_prefix . 'survey_question_image_width' ] ) ) : '';

            // Question Image Height
            $survey_question_image_height = (isset( $_POST[ $name_prefix . 'survey_question_image_height' ] ) && $_POST[ $name_prefix . 'survey_question_image_height' ] != '') ? absint ( intval( $_POST[ $name_prefix . 'survey_question_image_height' ] ) ) : '';

            // Question Image sizing
            $survey_question_image_sizing = (isset( $_POST[ $name_prefix . 'survey_question_image_sizing' ] ) && $_POST[ $name_prefix . 'survey_question_image_sizing' ] != '') ? stripslashes ( sanitize_text_field( $_POST[ $name_prefix . 'survey_question_image_sizing' ] ) ) : 'cover';
            
            // =========== Questions Styles End   ===========



            // =========== Answers Styles Start ===========

            // Question font size
            $survey_answer_font_size = (isset( $_POST[ $name_prefix . 'survey_answer_font_size' ] ) && $_POST[ $name_prefix . 'survey_answer_font_size' ] != '') ? absint ( intval( $_POST[ $name_prefix . 'survey_answer_font_size' ] ) ) : 15;

            // Answer view
            $survey_answers_view = (isset( $_POST[ $name_prefix . 'survey_answers_view' ] ) && $_POST[ $name_prefix . 'survey_answers_view' ] != '') ? stripslashes ( sanitize_text_field( $_POST[ $name_prefix . 'survey_answers_view' ] ) ) : 'list';

            // Answer object-fit
            $survey_answers_object_fit = (isset( $_POST[ $name_prefix . 'survey_answers_object_fit' ] ) && $_POST[ $name_prefix . 'survey_answers_object_fit' ] != '') ? stripslashes ( sanitize_text_field( $_POST[ $name_prefix . 'survey_answers_object_fit' ] ) ) : 'cover';

            // Answer padding
            $survey_answers_padding = (isset( $_POST[ $name_prefix . 'survey_answers_padding' ] ) && $_POST[ $name_prefix . 'survey_answers_padding' ] != '') ? absint ( intval( $_POST[ $name_prefix . 'survey_answers_padding' ] ) ) : 10;

            // Answer Gap
            $survey_answers_gap = (isset( $_POST[ $name_prefix . 'survey_answers_gap' ] ) && $_POST[ $name_prefix . 'survey_answers_gap' ] != '') ? absint ( intval( $_POST[ $name_prefix . 'survey_answers_gap' ] ) ) : 10;

            // =========== Answers Styles End   ===========



            // =========== Buttons Styles Start ===========

            // Buttons size
            $survey_buttons_size = (isset( $_POST[ $name_prefix . 'survey_buttons_size' ] ) && $_POST[ $name_prefix . 'survey_buttons_size' ] != '') ? stripslashes ( sanitize_text_field( $_POST[ $name_prefix . 'survey_buttons_size' ] ) ) : 'medium';

            // Buttons font size
            $survey_buttons_font_size = (isset( $_POST[ $name_prefix . 'survey_buttons_font_size' ] ) && $_POST[ $name_prefix . 'survey_buttons_font_size' ] != '') ? absint ( intval( $_POST[ $name_prefix . 'survey_buttons_font_size' ] ) ) : 14;

            // Buttons Left / Right padding
            $survey_buttons_left_right_padding = (isset( $_POST[ $name_prefix . 'survey_buttons_left_right_padding' ] ) && $_POST[ $name_prefix . 'survey_buttons_left_right_padding' ] != '') ? absint ( intval( $_POST[ $name_prefix . 'survey_buttons_left_right_padding' ] ) ) : 24;

            // Buttons Top / Bottom padding
            $survey_buttons_top_bottom_padding = (isset( $_POST[ $name_prefix . 'survey_buttons_top_bottom_padding' ] ) && $_POST[ $name_prefix . 'survey_buttons_top_bottom_padding' ] != '') ? absint ( intval( $_POST[ $name_prefix . 'survey_buttons_top_bottom_padding' ] ) ) : 0;

            // Buttons border radius
            $survey_buttons_border_radius = (isset( $_POST[ $name_prefix . 'survey_buttons_border_radius' ] ) && $_POST[ $name_prefix . 'survey_buttons_border_radius' ] != '') ? absint ( intval( $_POST[ $name_prefix . 'survey_buttons_border_radius' ] ) ) : 4;

            // ===========  Buttons Styles End  ===========


            // =============================================================
            // ======================    Styles Tab    =====================
            // ========================     END     ========================


            // =======================  //  ======================= // ======================= // ======================= // ======================= //


            // =============================================================
            // ======================  Settings Tab  =======================
            // ========================    START   =========================

            // Show survey title
            $survey_show_title = (isset( $_POST[ $name_prefix . 'survey_show_title' ] ) && $_POST[ $name_prefix . 'survey_show_title' ] == 'on') ? 'on' : 'off';

            // Enable randomize answers
            $survey_enable_randomize_answers = (isset( $_POST[ $name_prefix . 'survey_enable_randomize_answers' ] ) && $_POST[ $name_prefix . 'survey_enable_randomize_answers' ] == 'on') ? 'on' : 'off';

            // Enable randomize questions
            $survey_enable_randomize_questions = (isset( $_POST[ $name_prefix . 'survey_enable_randomize_questions' ] ) && $_POST[ $name_prefix . 'survey_enable_randomize_questions' ] == 'on') ? 'on' : 'off';

            // Enable confirmation box for leaving the page
            $survey_enable_leave_page = (isset( $_POST[ $name_prefix . 'survey_enable_leave_page' ] ) && $_POST[ $name_prefix . 'survey_enable_leave_page' ] == 'on') ? 'on' : 'off';

            // Enable clear answer button
            $survey_enable_clear_answer = (isset( $_POST[ $name_prefix . 'survey_enable_clear_answer' ] ) && $_POST[ $name_prefix . 'survey_enable_clear_answer' ] == 'on') ? 'on' : 'off';


            // =============================================================
            // ======================  Settings Tab  =======================
            // ========================     END    =========================


            // =======================  //  ======================= // ======================= // ======================= // ======================= //


            // =============================================================
            // =================== Results Settings Tab  ===================
            // ========================    START   =========================


            // Redirect after submit
            $survey_redirect_after_submit = (isset( $_POST[ $name_prefix . 'survey_redirect_after_submit' ] ) && $_POST[ $name_prefix . 'survey_redirect_after_submit' ] == 'on') ? 'on' : 'off';

            // Redirect URL
            $survey_submit_redirect_url = (isset( $_POST[ $name_prefix . 'survey_submit_redirect_url' ] ) && $_POST[ $name_prefix . 'survey_submit_redirect_url' ] != '') ? stripslashes ( esc_url( $_POST[ $name_prefix . 'survey_submit_redirect_url' ] ) ) : '';

            // Redirect delay (sec)
            $survey_submit_redirect_delay = (isset( $_POST[ $name_prefix . 'survey_submit_redirect_delay' ] ) && $_POST[ $name_prefix . 'survey_submit_redirect_delay' ] != '') ? absint ( intval( $_POST[ $name_prefix . 'survey_submit_redirect_delay' ] ) ) : '';

            // Enable EXIT button
            $survey_enable_exit_button = (isset( $_POST[ $name_prefix . 'survey_enable_exit_button' ] ) && $_POST[ $name_prefix . 'survey_enable_exit_button' ] == 'on') ? 'on' : 'off';

            // Redirect URL
            $survey_exit_redirect_url = (isset( $_POST[ $name_prefix . 'survey_exit_redirect_url' ] ) && $_POST[ $name_prefix . 'survey_exit_redirect_url' ] != '') ? stripslashes ( esc_url( $_POST[ $name_prefix . 'survey_exit_redirect_url' ] ) ) : '';

            // Thank you message
            $survey_final_result_text = (isset( $_POST[ $name_prefix . 'survey_final_result_text' ] ) && $_POST[ $name_prefix . 'survey_final_result_text' ] != '') ? stripslashes ( sanitize_textarea_field( $_POST[ $name_prefix . 'survey_final_result_text' ] ) ) : '';

            // Select survey loader
            $survey_loader = (isset( $_POST[ $name_prefix . 'survey_loader' ] ) && $_POST[ $name_prefix . 'survey_loader' ] != '') ? stripslashes ( sanitize_text_field( $_POST[ $name_prefix . 'survey_loader' ] ) ) : 'default';


            // =============================================================
            // =================== Results Settings Tab  ===================
            // ========================    END    ==========================


            // =======================  //  ======================= // ======================= // ======================= // ======================= //


            // =============================================================
            // ===================    Limitation Tab     ===================
            // ========================    START   =========================

            // Maximum number of attempts per user
            $survey_limit_users = (isset( $_POST[ $name_prefix . 'survey_limit_users' ] ) && $_POST[ $name_prefix . 'survey_limit_users' ] == 'on') ? 'on' : 'off';

            // Detects users by IP / ID
            $survey_limit_users_by = (isset( $_POST[ $name_prefix . 'survey_limit_users_by' ] ) && $_POST[ $name_prefix . 'survey_limit_users_by' ] != '') ? stripslashes ( sanitize_text_field( $_POST[ $name_prefix . 'survey_limit_users_by' ] ) ) : 'ip';
            $survey_limit_users_by = (isset( $_POST[ $name_prefix . 'survey_limit_users_by' ] ) && $_POST[ $name_prefix . 'survey_limit_users_by' ] != '') ? stripslashes ( sanitize_text_field( $_POST[ $name_prefix . 'survey_limit_users_by' ] ) ) : 'ip';

            // Limitation Message
            $survey_limitation_message = (isset( $_POST[ $name_prefix . 'survey_limitation_message' ] ) && $_POST[ $name_prefix . 'survey_limitation_message' ] != '') ? stripslashes ( sanitize_textarea_field( $_POST[ $name_prefix . 'survey_limitation_message' ] ) ) : '';

            // Only for logged in users
            $survey_enable_logged_users = (isset( $_POST[ $name_prefix . 'survey_enable_logged_users' ] ) && $_POST[ $name_prefix . 'survey_enable_logged_users' ] == 'on') ? 'on' : 'off';

            // Message - Only for logged in users
            $survey_logged_in_message = (isset( $_POST[ $name_prefix . 'survey_logged_in_message' ] ) && $_POST[ $name_prefix . 'survey_logged_in_message' ] != '') ? stripslashes ( sanitize_textarea_field( $_POST[ $name_prefix . 'survey_logged_in_message' ] ) ) : '';


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


            // Options
            $options = array(
                'survey_version'                    => SURVEY_MAKER_VERSION,
                // Styles Tab
                'survey_theme'                      => $survey_theme,
                'survey_color'                      => $survey_color,
                'survey_background_color'           => $survey_background_color,
                'survey_text_color'                 => $survey_text_color,
                'survey_buttons_text_color'         => $survey_buttons_text_color,
                'survey_width'                      => $survey_width,
                'survey_width_by_percentage_px'     => $survey_width_by_percentage_px,
                'survey_custom_class'               => $survey_custom_class,
                'survey_custom_css'                 => $survey_custom_css,
                'survey_question_font_size'         => $survey_question_font_size,
                'survey_question_image_width'       => $survey_question_image_width,
                'survey_question_image_height'      => $survey_question_image_height,
                'survey_question_image_sizing'      => $survey_question_image_sizing,
                'survey_answer_font_size'           => $survey_answer_font_size,
                'survey_answers_view'               => $survey_answers_view,
                'survey_answers_object_fit'         => $survey_answers_object_fit,
                'survey_answers_padding'            => $survey_answers_padding,
                'survey_answers_gap'                => $survey_answers_gap,

                'survey_buttons_size'               => $survey_buttons_size,
                'survey_buttons_font_size'          => $survey_buttons_font_size,
                'survey_buttons_left_right_padding' => $survey_buttons_left_right_padding,
                'survey_buttons_top_bottom_padding' => $survey_buttons_top_bottom_padding,
                'survey_buttons_border_radius'      => $survey_buttons_border_radius,

                // Settings Tab
                'survey_show_title'                 => $survey_show_title,
                'survey_enable_randomize_answers'   => $survey_enable_randomize_answers,
                'survey_enable_randomize_questions' => $survey_enable_randomize_questions,
                'survey_enable_leave_page'          => $survey_enable_leave_page,
                'survey_enable_clear_answer'        => $survey_enable_clear_answer,

                // Result Settings Tab
                'survey_redirect_after_submit'      => $survey_redirect_after_submit,
                'survey_submit_redirect_url'        => $survey_submit_redirect_url,
                'survey_submit_redirect_delay'      => $survey_submit_redirect_delay,
                'survey_enable_exit_button'         => $survey_enable_exit_button,
                'survey_exit_redirect_url'          => $survey_exit_redirect_url,
                'survey_final_result_text'          => $survey_final_result_text,
                'survey_loader'                     => $survey_loader,

                // Limitation Tab
                'survey_limit_users'                => $survey_limit_users,
                'survey_limit_users_by'             => $survey_limit_users_by,
                'survey_limitation_message'         => $survey_limitation_message,
                'survey_enable_logged_users'        => $survey_enable_logged_users,
                'survey_logged_in_message'          => $survey_logged_in_message,

            );

            if (isset($_POST['save_type_default_options']) && $_POST['save_type_default_options'] == 'save_type_default_options') {

                $survey_default_options = $options;
                $survey_default_options['survey_enable_schedule'] = 'off';
                unset($survey_default_options['survey_schedule_active']);
                unset($survey_default_options['survey_schedule_deactive']);

                $this->settings_obj->ays_update_setting( 'survey_default_options', json_encode( $survey_default_options ) );
            }

            if (isset($_POST[ $name_prefix . 'sections_delete' ]) && ! empty( $_POST[ $name_prefix . 'sections_delete' ] )) {
                foreach ($_POST[ $name_prefix . 'sections_delete' ] as $key => $del_id) {
                    if( in_array( $del_id, $section_ids ) ){
                        $del_index = array_search( $del_id, $section_ids );
                        unset($section_ids[$del_index]);
                    }
                    $wpdb->delete(
                        $sections_table,
                        array( 'id' => intval( $del_id ) ),
                        array( '%d' )
                    );
                }
            }

            if (isset($_POST[ $name_prefix . 'questions_delete' ]) && ! empty( $_POST[ $name_prefix . 'questions_delete' ] )) {
                foreach ($_POST[ $name_prefix . 'questions_delete' ] as $key => $del_id) {
                    if( in_array( $del_id, $question_ids ) ){
                        $del_index = array_search( $del_id, $question_ids );
                        unset($question_ids[$del_index]);
                    }
                    $wpdb->delete(
                        $questions_table,
                        array( 'id' => intval( $del_id ) ),
                        array( '%d' )
                    );
                }
            }

            if (isset($_POST[ $name_prefix . 'answers_delete' ]) && ! empty( $_POST[ $name_prefix . 'answers_delete' ] )) {
                foreach ($_POST[ $name_prefix . 'answers_delete' ] as $key => $del_id) {
                    $wpdb->delete(
                        $answers_table,
                        array( 'id' => intval( $del_id ) ),
                        array( '%d' )
                    );
                }
            }

            // var_dump($_POST);
            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";
            // die();

            $question_ids_new = array();
            $section_ids_array = array();

            if (isset($_POST[ $name_prefix . 'section_add' ]) && ! empty( $_POST[ $name_prefix . 'section_add' ] )) {
                // --------------------------- Sections Table ------------Start--------------- //
                $section_ordering = 1;
                foreach ($_POST[ $name_prefix . 'section_add' ] as $key => $section) {

                    //Section Title
                    $section_title = ( isset($section['title']) && $section['title'] != '' ) ? stripslashes( sanitize_text_field( $section['title'] ) ) : '';

                    //Section Description
                    $section_description = ( isset($section['description']) && $section['description'] != '' ) ? stripslashes( sanitize_text_field( $section['description'] ) ) : '';;

                    // Options
                    $section_options = array(

                    );

                    $result = $wpdb->insert(
                        $sections_table,
                        array(
                            'title'         => $section_title,
                            'description'   => $section_description,
                            'ordering'      => $section_ordering,
                            'options'       => json_encode( $section_options ),
                        ),
                        array(
                            '%s', // title
                            '%s', // description
                            '%d', // ordering
                            '%s', // options
                        )
                    );

                    $section_insert_id = $wpdb->insert_id;
                    $section_ids_array[] = $section_insert_id;

                    // --------------------------- Question Table ------------Start--------------- //
                    $question_ordering = 1;
                    $question_id_array = array();
                    if ( isset( $section['questions_add'] ) && ! empty( $section['questions_add'] ) ) {
                        foreach ($section['questions_add'] as $question_id => $question) {
                            $ays_question = ( isset($question['title']) && $question['title'] != '' ) ? stripslashes( sanitize_text_field( $question['title'] ) ) : '';

                            $type = ( isset($question['type']) && $question['type'] != '' ) ? sanitize_text_field( $question['type'] ) : 'radio';

                            $user_variant = ( isset($question['user_variant']) && $question['user_variant'] != '' ) ? sanitize_text_field( $question['user_variant'] ) : 'off';

                            $user_explanation = '';

                            $question_image = ( isset($question['image']) && $question['image'] != '' ) ? esc_url_raw( $question['image'] ) : '';

                            $required = isset( $question['options']['required'] ) ? sanitize_text_field( $question['options']['required'] ) : 'off';

                            $question_options = array(
                                'required' => $required,
                            );

                            $question_result = $wpdb->insert(
                                $questions_table,
                                array(
                                    'author_id'         => $author_id,
                                    'section_id'        => $section_insert_id,
                                    'category_ids'      => $category_ids,
                                    'question'          => $ays_question,
                                    'type'              => $type,
                                    'status'            => $status,
                                    'trash_status'      => $trash_status,
                                    'date_created'      => $date_created,
                                    'date_modified'     => $date_modified,
                                    'user_variant'      => $user_variant,
                                    'user_explanation'  => $user_explanation,
                                    'image'             => $question_image,
                                    'ordering'          => $question_ordering,
                                    'options'           => json_encode($question_options),
                                ),
                                array(
                                    '%d', // author_id
                                    '%d', // section_id
                                    '%s', // category_ids
                                    '%s', // question
                                    '%s', // type
                                    '%s', // status
                                    '%s', // trash_status
                                    '%s', // date_created
                                    '%s', // date_modified
                                    '%s', // user_variant
                                    '%s', // user_explanation
                                    '%s', // image
                                    '%d', // ordering
                                    '%s', // options
                                )
                            );

                            $question_insert_id = $wpdb->insert_id;
                            $question_ids_new[] = $question_insert_id;

                            // --------------------------- Answers Table ------------Start--------------- //
                            $answer_ordering = 1;
                            foreach ($question['answers_add'] as $answer_id => $answer) {
                                $answer_title = sanitize_text_field( $answer['title'] );
                                $answer_image = '';
                                if ( isset( $answer['image'] ) && $answer['image'] != '' ) {
                                    $answer_image = esc_url_raw( $answer['image'] );
                                }
                                $placeholder = '';
                                $answer_result = $wpdb->insert(
                                    $answers_table,
                                    array(
                                        'question_id'       => $question_insert_id,
                                        'answer'            => $answer_title,
                                        'image'             => $answer_image,
                                        'ordering'          => $answer_ordering,
                                        'placeholder'       => $placeholder,
                                    ),
                                    array(
                                        '%d', // question_id
                                        '%s', // answer
                                        '%s', // image
                                        '%d', // ordering
                                        '%s', // placeholder
                                    )
                                );
                                $answer_ordering++;
                            }
                            // --------------------------- Answers Table ------------End--------------- //
                            $question_ordering++;
                        }
                    }
                    // --------------------------- Question Table ------------End--------------- //
                    $section_ordering++;
                }
                // --------------------------- Sections Table ------------End--------------- //
            }

            if (isset($_POST[ $name_prefix . 'sections' ]) && !empty( $_POST[ $name_prefix . 'sections' ] )) {
                // --------------------------- Sections Table ------------Start--------------- //

                $section_ordering = 1;
                foreach ($_POST[ $name_prefix . 'sections' ] as $section_id => $section) {
                    $section_id = absint(intval($section_id));
                    $section_title = sanitize_text_field( $section['title'] );
                    $section_description = sanitize_text_field( $section['description'] );

                    // Options
                    $section_options = array(

                    );

                    $result = $wpdb->update(
                        $sections_table,
                        array(
                            'title'             => $section_title,
                            'description'       => $section_description,
                            'ordering'          => $section_ordering,
                            'options'           => json_encode( $section_options ),
                        ),
                        array( 'id' => $section_id ),
                        array(
                            '%s', // title
                            '%s', // description
                            '%d', // ordering
                            '%s', // options
                        ),
                        array( '%d' )
                    );

                    // --------------------------- Question Table ------------Start--------------- //
                    $question_ordering = 1;
                    foreach ($section['questions'] as $question_id => $question) {
                        // if (strpos($question_old_ids, $question_id.'') === '' || strpos($section_old_ids, $section_id.'') === false) {
                        //     // var_dump('jnjum em question');
                        //     $delete_question = $wpdb->delete( $questions_table, array('id' => intval( $question_id )) );
                        // }
                        $question_id = absint(intval($question_id));

                        $ays_question = ( isset($question['title']) && $question['title'] != '' ) ? stripslashes( sanitize_text_field( $question['title'] ) ) : '';

                        $type = ( isset($question['type']) && $question['type'] != '' ) ? sanitize_text_field( $question['type'] ) : 'radio';

                        $user_variant = ( isset($question['user_variant']) && $question['user_variant'] != '' ) ? sanitize_text_field( $question['user_variant'] ) : 'off';

                        $user_explanation = '';

                        $question_image = ( isset($question['image']) && $question['image'] != '' ) ? esc_url_raw( $question['image'] ) : '';

                        $required = isset( $question['options']['required'] ) ? sanitize_text_field( $question['options']['required'] ) : 'off';

                        $question_options = array(
                            'required' => $required,
                        );

                        $question_result = $wpdb->update(
                            $questions_table,
                            array(
                                'author_id'         => $author_id,
                                'section_id'        => $section_id,
                                'category_ids'      => $category_ids,
                                'question'          => $ays_question,
                                'type'              => $type,
                                'status'            => $status,
                                'trash_status'      => $trash_status,
                                'date_created'      => $date_created,
                                'date_modified'     => $date_modified,
                                'user_variant'      => $user_variant,
                                'user_explanation'  => $user_explanation,
                                'image'             => $question_image,
                                'ordering'          => $question_ordering,
                                'options'           => json_encode($question_options),
                            ),
                            array( 'id' => $question_id ),
                            array(
                                '%d', // author_id
                                '%d', // section_id
                                '%s', // category_ids
                                '%s', // question
                                '%s', // type
                                '%s', // status
                                '%s', // trash_status
                                '%s', // date_created
                                '%s', // date_modified
                                '%s', // user_variant
                                '%s', // user_explanation
                                '%s', // image
                                '%d', // ordering
                                '%s', // options
                            ),
                            array( '%d' )
                        );

                        // --------------------------- Answers Table ------------Start--------------- //
                        $answer_ordering = 1;
                        // var_dump($question['oldId']);
                        if( isset( $question['answers'] ) && !empty( $question['answers'] ) ){
                            foreach ($question['answers'] as $answer_id => $answer) {
                                // var_dump($answer);
                                // // var_dump(strpos($question['oldId'], $answer_id.''));
                                // if (strpos($question['oldId'], $answer_id.'') === '' || strpos($section_old_ids, $section_id.'') === false) {
                                //     // var_dump('jnjum em answer');
                                //     $delete_answer = $wpdb->delete( $answers_table, array('id' => intval( $answer_id )) );
                                // }
                                $answer_id = absint(intval($answer_id));
                                $answer_title = sanitize_text_field( $answer['title'] );
                                $answer_image = '';
                                if ( isset( $answer['image'] ) && $answer['image'] != '' ) {
                                    $answer_image = esc_url_raw( $answer['image'] );
                                }
                                $placeholder = '';
                                $answer_result = $wpdb->update(
                                    $answers_table,
                                    array(
                                        'question_id'       => $question_id,
                                        'answer'            => $answer_title,
                                        'image'             => $answer_image,
                                        'ordering'          => $answer_ordering,
                                        'placeholder'       => $placeholder,
                                    ),
                                    array( 'id' => $answer_id ),
                                    array(
                                        '%d', // question_id
                                        '%s', // answer
                                        '%s', // image
                                        '%d', // ordering
                                        '%s', // placeholder
                                    ),
                                    array( '%d' )
                                );

                                $answer_ordering++;
                            }
                        }

                        if( isset( $question['answers_add'] ) && !empty( $question['answers_add'] ) ){
                            foreach ($question['answers_add'] as $answer_id => $answer) {
                                $answer_id = absint(intval($answer_id));
                                $answer_title = sanitize_text_field( $answer['title'] );
                                $answer_image = '';
                                if ( isset( $answer['image'] ) && $answer['image'] != '' ) {
                                    $answer_image = esc_url_raw( $answer['image'] );
                                }
                                $placeholder = '';
                                $answer_result = $wpdb->insert(
                                    $answers_table,
                                    array(
                                        'question_id'       => $question_id,
                                        'answer'            => $answer_title,
                                        'image'             => $answer_image,
                                        'ordering'          => $answer_ordering,
                                        'placeholder'       => $placeholder,
                                    ),
                                    array(
                                        '%d', // question_id
                                        '%s', // answer
                                        '%s', // image
                                        '%d', // ordering
                                        '%s', // placeholder
                                    )
                                );

                                $answer_ordering++;
                            }
                        }
                        // --------------------------- Answers Table ------------End--------------- //

                        $question_ordering++;
                    }

                    if( isset( $section['questions_add'] ) && !empty( $section['questions_add'] ) ){
                        foreach ($section['questions_add'] as $question_id => $question) {
                            $ays_question = ( isset($question['title']) && $question['title'] != '' ) ? stripslashes( sanitize_text_field( $question['title'] ) ) : '';

                            $type = ( isset($question['type']) && $question['type'] != '' ) ? sanitize_text_field( $question['type'] ) : 'radio';

                            $user_variant = ( isset($question['user_variant']) && $question['user_variant'] != '' ) ? sanitize_text_field( $question['user_variant'] ) : 'off';

                            $user_explanation = '';

                            $question_image = ( isset($question['image']) && $question['image'] != '' ) ? esc_url_raw( $question['image'] ) : '';

                            $required = isset( $question['options']['required'] ) ? sanitize_text_field( $question['options']['required'] ) : 'off';

                            $question_options = array(
                                'required' => $required,
                            );

                            $question_result = $wpdb->insert(
                                $questions_table,
                                array(
                                    'author_id'         => $author_id,
                                    'section_id'        => $section_id,
                                    'category_ids'      => $category_ids,
                                    'question'          => $ays_question,
                                    'type'              => $type,
                                    'status'            => $status,
                                    'trash_status'      => $trash_status,
                                    'date_created'      => $date_created,
                                    'date_modified'     => $date_modified,
                                    'user_variant'      => $user_variant,
                                    'user_explanation'  => $user_explanation,
                                    'image'             => $question_image,
                                    'ordering'          => $question_ordering,
                                    'options'           => json_encode($question_options),
                                ),
                                array(
                                    '%d', // author_id
                                    '%d', // section_id
                                    '%s', // category_ids
                                    '%s', // question
                                    '%s', // type
                                    '%s', // status
                                    '%s', // trash_status
                                    '%s', // date_created
                                    '%s', // date_modified
                                    '%s', // user_variant
                                    '%s', // user_explanation
                                    '%s', // image
                                    '%d', // ordering
                                    '%s', // options
                                )
                            );

                            $question_new_id = $wpdb->insert_id;
                            $question_ids_new[] = $question_new_id;

                            // --------------------------- Answers Table ------------Start--------------- //
                            $answer_ordering = 1;
                            if( isset( $question['answers_add'] ) && !empty( $question['answers_add'] ) ){
                                foreach ($question['answers_add'] as $answer_id => $answer) {
                                    $answer_id = absint(intval($answer_id));
                                    $answer_title = sanitize_text_field( $answer['title'] );
                                    $answer_image = '';
                                    if ( isset( $answer['image'] ) && $answer['image'] != '' ) {
                                        $answer_image = esc_url_raw( $answer['image'] );
                                    }
                                    $placeholder = '';
                                    $answer_result = $wpdb->insert(
                                        $answers_table,
                                        array(
                                            'question_id'       => $question_new_id,
                                            'answer'            => $answer_title,
                                            'image'             => $answer_image,
                                            'ordering'          => $answer_ordering,
                                            'placeholder'       => $placeholder,
                                        ),
                                        array(
                                            '%d', // question_id
                                            '%s', // answer
                                            '%s', // image
                                            '%d', // ordering
                                            '%s', // placeholder
                                        )
                                    );

                                    $answer_ordering++;
                                }
                            }
                            // --------------------------- Answers Table ------------End--------------- //

                            $question_ordering++;
                        }
                    }
                    // --------------------------- Question Table ------------End--------------- //

                    $section_ordering++;
                }
                // --------------------------- Sections Table ------------End--------------- //
            }

            $message = '';
            if( $id == 0 ){
                $sections_count = count( $section_ids_array );
                $questions_count = count( $question_ids_new );
                $section_ids = empty( $section_ids_array ) ? '' : implode( ',', $section_ids_array );
                $question_ids = empty( $question_ids_new ) ? '' : implode( ',', $question_ids_new );
                $result = $wpdb->insert(
                    $table,
                    array(
                        'author_id'         => $author_id,
                        'title'             => $title,
                        'description'       => $description,
                        'category_ids'      => $category_ids,
                        'question_ids'      => $question_ids,
                        'sections_count'    => $sections_count,
                        'questions_count'   => $questions_count,
                        'image'             => $image,
                        'status'            => $status,
                        'trash_status'      => $trash_status,
                        'date_created'      => $date_created,
                        'date_modified'     => $date_modified,
                        'ordering'          => $ordering,
                        'post_id'           => $post_id,
                        'section_ids'       => $section_ids,
                        'options'           => json_encode( $options ),
                    ),
                    array(
                        '%d', // author_id
                        '%s', // title
                        '%s', // description
                        '%s', // category_ids
                        '%s', // question_ids
                        '%d', // sections_count
                        '%d', // questions_count
                        '%s', // image
                        '%s', // status
                        '%s', // trash_status
                        '%s', // date_created
                        '%s', // date_modified
                        '%d', // ordering
                        '%d', // post_id
                        '%s', // section_ids
                        '%s', // options
                    )
                );

                $inserted_id = $wpdb->insert_id;
                $message = 'created';
            }else{
                if( ! empty( $section_ids ) ){
                    if( ! empty( $section_ids_array ) ){
                        $section_ids = array_merge( $section_ids, $section_ids_array );
                    }
                }else{
                    if( ! empty( $section_ids_array ) ){
                        $section_ids = array_merge( $section_ids, $section_ids_array );
                    }
                }
                $sections_count = count( $section_ids );
                $section_ids = !empty( $section_ids ) ? implode(',', $section_ids) : '';
                // $question_ids = empty( $question_ids_new ) ? '' : implode( ',', $question_ids_new );
                if( ! empty( $question_ids ) ){
                    if( ! empty( $question_ids_new ) ){
                        $question_ids = array_merge( $question_ids, $question_ids_new );
                    }
                }else{
                    if( ! empty( $question_ids_new ) ){
                        $question_ids = array_merge( $question_ids, $question_ids_new );
                    }
                }
                $questions_count = count( $question_ids );
                $question_ids = empty( $question_ids ) ? '' : implode( ',', $question_ids );


                $result = $wpdb->update(
                    $table,
                    array(
                        'author_id'         => $author_id,
                        'title'             => $title,
                        'description'       => $description,
                        'category_ids'      => $category_ids,
                        'question_ids'      => $question_ids,
                        'sections_count'    => $sections_count,
                        'questions_count'   => $questions_count,
                        'image'             => $image,
                        'status'            => $status,
                        'date_modified'     => $date_modified,
                        'post_id'           => $post_id,
                        'section_ids'       => $section_ids,
                        'options'           => json_encode( $options ),
                    ),
                    array( 'id' => $id ),
                    array(
                        '%d', // author_id
                        '%s', // title
                        '%s', // description
                        '%s', // category_ids
                        '%s', // question_ids
                        '%d', // sections_count
                        '%d', // questions_count
                        '%s', // image
                        '%s', // status
                        '%s', // date_modified
                        '%d', // post_id
                        '%s', // section_ids
                        '%s', // options
                    ),
                    array( '%d' )
                );

                $inserted_id = $id;
                $message = 'updated';
            }

            $ays_survey_tab = isset($_POST['ays_survey_tab']) ? sanitize_text_field( $_POST['ays_survey_tab'] ) : 'tab1';
            if( $result >= 0  ) {
                if($save_type == 'apply'){
                    if($id == 0){
                        $url = esc_url_raw( add_query_arg( array(
                            "action"    => "edit",
                            "id"        => $inserted_id,
                            "tab"       => $ays_survey_tab,
                            "status"    => $message
                        ) ) );
                    }else{
                        $url = esc_url_raw( add_query_arg( array(
                            "tab"    => $ays_survey_tab,
                            "status" => $message
                        ) ) );
                    }
                    wp_redirect( $url );
                }else{
                    $url = remove_query_arg( array('action', 'id') );
                    $url = esc_url_raw( add_query_arg( array(
                        "tab"    => $ays_survey_tab,
                        "status" => $message
                    ), $url ) );
                    wp_redirect( $url );
                }
            }

        }
    }

    private function get_max_id() {
        global $wpdb;
        $table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys";

        $sql = "SELECT MAX(id) FROM {$table}";

        $result = $wpdb->get_var($sql);

        return $result;
    }

    /**
     * Delete a customer record.
     *
     * @param int $id customer ID
     */
    public static function delete_items( $id ) {
        global $wpdb;

        $wpdb->delete(
            $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions",
            array( 'survey_id' => $id ),
            array( '%d' )
        );

        $wpdb->delete(
            $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys",
            array( 'id' => $id ),
            array( '%d' )
        );

    }

    /**
     * Move to trash a customer record.
     *
     * @param int $id customer ID
     */
    public static function trash_items( $id ) {
        global $wpdb;
        $db_item = self::get_item_by_id( $id );

        $wpdb->update(
            $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions",
            array( 'status' => 'trashed' ),
            array( 'survey_id' => $id ),
            array( '%s', '%s' ),
            array( '%d' )
        );

        $wpdb->update(
            $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys",
            array( 
                'status' => 'trashed',
                'trash_status' => $db_item['status'],
            ),
            array( 'id' => $id ),
            array( '%s', '%s' ),
            array( '%d' )
        );

    }

    /**
     * Restore a customer record.
     *
     * @param int $id customer ID
     */
    public static function restore_items( $id ) {
        global $wpdb;
        $db_item = self::get_item_by_id( $id );

        $wpdb->update(
            $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions",
            array( 'status' => 'published' ),
            array( 'survey_id' => $id ),
            array( '%s', '%s' ),
            array( '%d' )
        );

        $wpdb->update(
            $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys",
            array( 
                'status' => $db_item['trash_status'],
                'trash_status' => '',
            ),
            array( 'id' => $id ),
            array( '%s', '%s' ),
            array( '%d' )
        );
    }

    /**
     * Duplicate a customer record.
     *
     * @param int $id customer ID
     */
    public function duplicate_items( $id ){
        global $wpdb;
        $table = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys";
        $object = $this->get_item_by_id( $id );
        
        $author_id = get_current_user_id();
        
        $max_id = $this->get_max_id();
        $ordering = ( $max_id != NULL ) ? ( $max_id + 1 ) : 1;
        
        $options = json_decode($object['options'], true);
        
        $result = $wpdb->insert(
            $table,
            array(
                'author_id'         => $author_id,
                'title'             => "Copy - " . $object['title'],
                'description'       => $object['description'],
                'category_ids'      => $object['category_ids'],
                'question_ids'      => $object['question_ids'],
                'image'             => $object['image'],
                'status'            => $object['status'],
                'trash_status'      => $object['trash_status'],
                'date_created'      => current_time( 'mysql' ),
                'date_modified'     => current_time( 'mysql' ),
                'ordering'          => $ordering,
                'post_id'           => 0,
                'options'           => json_encode( $options ),
            ),
            array(
                '%d', // author_id
                '%s', // title
                '%s', // description
                '%s', // category_ids
                '%s', // question_ids
                '%s', // image
                '%s', // status
                '%s', // trash_status
                '%s', // date_created
                '%s', // date_modified
                '%d', // ordering
                '%d', // post_id
                '%s', // options
            )
        );        
    }



    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count() {
        global $wpdb;
        $filter = array();
        $sql = "SELECT COUNT(*) FROM " . $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys";
        
        if( isset( $_GET['filterby'] ) && intval($_GET['filterby']) > 0){
            $cat_id = intval($_GET['filterby']);
            $filter[] = ' '.$cat_id.' IN (category_ids) ';
        }
        if( isset( $_REQUEST['fstatus'] ) ){
            $fstatus = esc_url( $_REQUEST['fstatus'] );
            if($fstatus !== null){
                $filter[] = " status = '".$fstatus."' ";
            }
        }
        
        if(count($filter) !== 0){
            $sql .= " WHERE ".implode(" AND ", $filter);
        }

        return $wpdb->get_var( $sql );
    }
    
    public static function all_record_count() {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM " . $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys WHERE status != 'trashed'";

        if( isset( $_GET['filterby'] ) && intval($_GET['filterby']) > 0){
            $cat_id = intval($_GET['filterby']);
            $sql .= ' AND '.$cat_id.' IN (category_ids) ';
        }

        return $wpdb->get_var( $sql );
    }

    public static function published_questions_record_count() {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM " . $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "questions WHERE status = 'published'";

        return $wpdb->get_var( $sql );
    }

    public static function get_statused_record_count( $status ) {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM " . $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys WHERE status='" . esc_sql( $status ) . "'";

        if( isset( $_GET['filterby'] ) && intval($_GET['filterby']) > 0){
            $cat_id = intval($_GET['filterby']);
            $sql .= ' AND '.$cat_id.' IN (category_ids) ';
        }

        return $wpdb->get_var( $sql );
    }

    public static function get_passed_users_count( $id ) {
        global $wpdb;
        $id = intval($id);
        $sql = "SELECT COUNT(*) FROM " . $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "submissions WHERE survey_id=".$id;

        return $wpdb->get_var( $sql );
    }


    /** Text displayed when no customer data is available */
    public function no_items() {
        echo __( 'There are no surveys yet.', $this->plugin_name );
    }


    /**
     * Render a column when no column specific method exist.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'title':
            case 'category_ids':
            case 'shortcode':
            case 'code_include':
            case 'items_count':
            case 'author_id':
            case 'submissions_count':
            case 'status':
            case 'id':
                return $item[ $column_name ];
                break;
            default:
                return print_r( $item, true ); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
        );
    }


    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    function column_title( $item ) {
        if($item['status'] == 'trashed'){
            $delete_nonce = wp_create_nonce( $this->plugin_name . '-delete-survey' );
        }else{
            $delete_nonce = wp_create_nonce( $this->plugin_name . '-trash-survey' );
        }

        $restitle = Survey_Maker_Admin::ays_restriction_string( "word", stripcslashes( $item['title'] ), 5);
        
        $fstatus = '';
        if( isset( $_GET['fstatus'] ) && $_GET['fstatus'] != '' ){
            $fstatus = '&fstatus='. esc_url( $_GET['fstatus'] );
        }

        $title = sprintf( '<a href="?page=%s&action=%s&id=%d">%s</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['id'] ), stripcslashes($item['title']));

        $actions = array();
        if($item['status'] == 'trashed'){
            $title = sprintf( '<a><strong>%s</strong></a>', $restitle );
            $actions['restore'] = sprintf( '<a href="?page=%s&action=%s&id=%d&_wpnonce=%s'.$fstatus.'">'. __('Restore', $this->plugin_name) .'</a>', esc_attr( $_REQUEST['page'] ), 'restore', absint( $item['id'] ), $delete_nonce );
            $actions['delete'] = sprintf( '<a class="ays_confirm_del" data-message="%s" href="?page=%s&action=%s&id=%s&_wpnonce=%s'.$fstatus.'">'. __('Delete Permanently', $this->plugin_name) .'</a>', $restitle, esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce );
        }else{
            $title = sprintf( '<a href="?page=%s&action=%s&id=%d"><strong>%s</strong></a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['id'] ), $restitle );
            $actions['edit'] = sprintf( '<a href="?page=%s&action=%s&id=%d">'. __('Edit', $this->plugin_name) .'</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['id'] ) );
            $actions['duplicate'] = sprintf( '<a href="?page=%s&action=%s&id=%d&_wpnonce=%s'.$fstatus.'">'. __('Duplicate', $this->plugin_name) .'</a>', esc_attr( $_REQUEST['page'] ), 'duplicate', absint( $item['id'] ), $delete_nonce );
            $actions['trash'] = sprintf( '<a href="?page=%s&action=%s&id=%s&_wpnonce=%s'.$fstatus.'">'. __('Move to trash', $this->plugin_name) .'</a>', esc_attr( $_REQUEST['page'] ), 'trash', absint( $item['id'] ), $delete_nonce );
        }

        return $title . $this->row_actions( $actions );
    }

    function column_category_ids( $item ) {
        global $wpdb;

        // Survey categories IDs
        $category_ids = isset( $item['category_ids'] ) && $item['category_ids'] != '' ? $item['category_ids'] : '';
        // $category_ids = $category_ids == '' ? array() : explode( ',', $category_ids );
        
        if( ! empty( $category_ids ) ){
            $sql = "SELECT * FROM " . $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "survey_categories WHERE id IN (" . $category_ids . ")";

            $results = $wpdb->get_results($sql, 'ARRAY_A');
            
            $titles = array();
            foreach ($results as $key => $value) {
                $titles[] = $value['title'];
            }

            $titles = implode( ', ', $titles );

            return $titles;
        }

        return '-';
    }

    function column_code_include( $item ) {
        $shortcode = htmlentities('[\'[ays_survey id="'.$item["id"].'"]\']');
        return '<input type="text" onClick="this.setSelectionRange(0, this.value.length)" readonly value="<?php echo do_shortcode('.$shortcode.'); ?>" style="max-width:100%;" />';
    }

    function column_shortcode( $item ) {
        $shortcode = htmlentities('[ays_survey id="'.$item["id"].'"]');
        return '<input type="text" onClick="this.setSelectionRange(0, this.value.length)" readonly value="'.$shortcode.'" />';
    }

    function column_status( $item ) {
        global $wpdb;
        $status = ucfirst( $item['status'] );
        $date = date( 'Y/m/d', strtotime( $item['date_modified'] ) );
        $title_date = date( 'l jS \of F Y h:i:s A', strtotime( $item['date_modified'] ) );
        $html = "<p style='font-size:14px;margin:0;'>" . $status . "</p>";
        $html .= "<p style=';font-size:14px;margin:0;text-decoration: dotted underline;' title='" . $title_date . "'>" . $date . "</p>";
        return $html;
    }

    function column_author_id( $item ) {
        $user = get_user_by( 'id', $item['author_id'] );
        $author_name = '';
        if($user->data->display_name == ''){
            if($user->data->user_nicename == ''){
                $author_name = $user->data->user_login;
            }else{
                $author_name = $user->data->user_nicename;
            }
        }else{
            $author_name = $user->data->display_name;
        }
        return $author_name;
    }

    function column_submissions_count( $item ) {
        $id = $item['id'];
        $passed_count = $this->get_passed_users_count( $id );
        $text = "<p style='font-size:14px;'>".$passed_count."</p>";
        return $text;
    }

    function column_items_count( $item ) {
        global $wpdb;
        if(empty($item['questions_count'])){
            $count = 0;
        }else{
            $count = intval($item['questions_count']);
        }
        return "<p style='font-size:14px;'>" . $count . "</p>";
    }

    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Title', $this->plugin_name ),
        );

        if( is_super_admin() ){
            $columns['author_id'] = __( 'Author', $this->plugin_name );
        }

        $columns['category_ids'] = __( 'Categories', $this->plugin_name );
        $columns['shortcode'] = __( 'Shortcode', $this->plugin_name );
        $columns['code_include'] = __( 'Code include', $this->plugin_name );
        $columns['items_count'] = __( 'Count', $this->plugin_name );
        $columns['submissions_count'] = __( 'Submissions count', $this->plugin_name );
        $columns['status'] = __( 'Status', $this->plugin_name );
        $columns['id'] = __( 'ID', $this->plugin_name );

        return $columns;
    }


    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'title'         => array( 'title', true ),
            'id'            => array( 'id', true ),
        );

        return $sortable_columns;
    }


    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = array(
            'bulk-duplicate' => __( 'Duplicate', $this->plugin_name ),
            'bulk-trash' => __( 'Move to trash', $this->plugin_name ),
        );

        if(isset($_GET['fstatus']) && $_GET['fstatus'] == 'trashed'){
            $actions = array(
                'bulk-restore' => __( 'Restore', $this->plugin_name ),
                'bulk-delete' => __( 'Delete Permanently', $this->plugin_name ),
            );
        }

        return $actions;
    }



    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {

        $this->_column_headers = $this->get_column_info();

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page     = $this->get_items_per_page( 'surveys_per_page', 20 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args( array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page, //WE have to determine how many items to show on a page
            'total_pages' => ceil( $total_items / $per_page )
        ) );

        $search = ( isset( $_REQUEST['s'] ) ) ? esc_sql( $_REQUEST['s'] ) : false;

        $do_search = ( $search ) ? sprintf(" title LIKE '%%%s%%' ", $search ) : '';

        $this->items = self::get_items( $per_page, $current_page, $do_search );
    }

    public function process_bulk_action() {
       
        //Detect when a bulk action is being triggered...
        if ( 'delete' === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );

            if ( ! wp_verify_nonce( $nonce, $this->plugin_name . '-delete-survey' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                self::delete_items( absint( $_GET['id'] ) );

                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url

                $add_query_args = array(
                    "status" => 'deleted'
                );
                if( isset( $_GET['fstatus'] ) && $_GET['fstatus'] != '' ){
                    $add_query_args['fstatus'] = esc_url( $_GET['fstatus'] );
                }
                $url = remove_query_arg( array('action', 'id', '_wpnonce') );
                $url = esc_url_raw( add_query_arg( $add_query_args, $url ) );
                wp_redirect( $url );
            }

        }

        //Detect when a bulk action is being triggered...
        if ( 'trash' === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );

            if ( ! wp_verify_nonce( $nonce, $this->plugin_name . '-trash-survey' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                self::trash_items( absint( $_GET['id'] ) );

                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url

                $add_query_args = array(
                    "status" => 'trashed'
                );
                if( isset( $_GET['fstatus'] ) && $_GET['fstatus'] != '' ){
                    $add_query_args['fstatus'] = esc_url( $_GET['fstatus'] );
                }
                $url = remove_query_arg( array('action', 'id', '_wpnonce') );
                $url = esc_url_raw( add_query_arg( $add_query_args, $url ) );
                wp_redirect( $url );
            }

        }

        //Detect when a bulk action is being triggered...
        if ( 'restore' === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );

            if ( ! wp_verify_nonce( $nonce, $this->plugin_name . '-delete-survey' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                self::restore_items( absint( $_GET['id'] ) );

                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url

                $add_query_args = array(
                    "status" => 'restored'
                );
                if( isset( $_GET['fstatus'] ) && $_GET['fstatus'] != '' ){
                    $add_query_args['fstatus'] = esc_url( $_GET['fstatus'] );
                }
                $url = remove_query_arg( array('action', 'id', '_wpnonce') );
                $url = esc_url_raw( add_query_arg( $add_query_args, $url ) );
                wp_redirect( $url );
            }

        }

        //Detect when a bulk action is being triggered...
        if ( 'duplicate' === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );

            if ( ! wp_verify_nonce( $nonce, $this->plugin_name . '-trash-survey' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                self::duplicate_items( absint( $_GET['id'] ) );

                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url

                $add_query_args = array(
                    "status" => 'duplicated'
                );
                if( isset( $_GET['fstatus'] ) && $_GET['fstatus'] != '' ){
                    $add_query_args['fstatus'] = esc_url( $_GET['fstatus'] );
                }
                $url = remove_query_arg( array('action', 'id', '_wpnonce') );
                $url = esc_url_raw( add_query_arg( $add_query_args, $url ) );
                wp_redirect( $url );
            }

        }

        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' ) ) {

            $delete_ids = esc_sql( $_POST['bulk-delete'] );

            // loop over the array of record IDs and delete them
            foreach ( $delete_ids as $id ) {
                self::delete_items( $id );
            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            $add_query_args = array(
                "status" => 'all-deleted'
            );
            if( isset( $_GET['fstatus'] ) && $_GET['fstatus'] != '' ){
                $add_query_args['fstatus'] = esc_url( $_GET['fstatus'] );
            }
            $url = remove_query_arg( array('action', 'id', '_wpnonce') );
            $url = esc_url_raw( add_query_arg( $add_query_args, $url ) );
            wp_redirect( $url );
        }

        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-trash' ) || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-trash' ) ) {

            $trash_ids = esc_sql( $_POST['bulk-delete'] );

            // loop over the array of record IDs and delete them
            foreach ( $trash_ids as $id ) {
                self::trash_items( $id );
            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            $add_query_args = array(
                "status" => 'all-trashed'
            );
            if( isset( $_GET['fstatus'] ) && $_GET['fstatus'] != '' ){
                $add_query_args['fstatus'] = esc_url( $_GET['fstatus'] );
            }
            $url = remove_query_arg( array('action', 'id', '_wpnonce') );
            $url = esc_url_raw( add_query_arg( $add_query_args, $url ) );
            wp_redirect( $url );
        }

        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-restore' ) || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-restore' ) ) {

            $restore_ids = esc_sql( $_POST['bulk-delete'] );

            // loop over the array of record IDs and delete them
            foreach ( $restore_ids as $id ) {
                self::restore_items( $id );
            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            $add_query_args = array(
                "status" => 'all-restored'
            );
            if( isset( $_GET['fstatus'] ) && $_GET['fstatus'] != '' ){
                $add_query_args['fstatus'] = esc_url( $_GET['fstatus'] );
            }
            $url = remove_query_arg( array('action', 'id', '_wpnonce') );
            $url = esc_url_raw( add_query_arg( $add_query_args, $url ) );
            wp_redirect( $url );
        }

        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-duplicate' ) || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-duplicate' ) ) {

            $restore_ids = esc_sql( $_POST['bulk-delete'] );

            // loop over the array of record IDs and delete them
            foreach ( $restore_ids as $id ) {
                self::duplicate_items( $id );
            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            $add_query_args = array(
                "status" => 'all-duplicated'
            );
            if( isset( $_GET['fstatus'] ) && $_GET['fstatus'] != '' ){
                $add_query_args['fstatus'] = esc_url( $_GET['fstatus'] );
            }
            $url = remove_query_arg( array('action', 'id', '_wpnonce') );
            $url = esc_url_raw( add_query_arg( $add_query_args, $url ) );
            wp_redirect( $url );
        }
    }

    public function survey_notices(){
        $status = (isset($_REQUEST['status'])) ? sanitize_text_field( $_REQUEST['status'] ) : '';

        if ( empty( $status ) )
            return;

        if ( 'created' == $status )
            $updated_message = esc_html( __( 'Survey created.', $this->plugin_name ) );
        elseif ( 'updated' == $status )
            $updated_message = esc_html( __( 'Survey saved.', $this->plugin_name ) );
        elseif ( 'duplicated' == $status )
            $updated_message = esc_html( __( 'Survey duplicated.', $this->plugin_name ) );
        elseif ( 'deleted' == $status )
            $updated_message = esc_html( __( 'Survey deleted.', $this->plugin_name ) );
        elseif ( 'trashed' == $status )
            $updated_message = esc_html( __( 'Survey moved to trash.', $this->plugin_name ) );
        elseif ( 'restored' == $status )
            $updated_message = esc_html( __( 'Survey restored.', $this->plugin_name ) );
        elseif ( 'all-duplicated' == $status )
            $updated_message = esc_html( __( 'Surveys are duplicated.', $this->plugin_name ) );
        elseif ( 'all-deleted' == $status )
            $updated_message = esc_html( __( 'Surveys are deleted.', $this->plugin_name ) );
        elseif ( 'all-trashed' == $status )
            $updated_message = esc_html( __( 'Surveys are moved to trash.', $this->plugin_name ) );
        elseif ( 'all-restored' == $status )
            $updated_message = esc_html( __( 'Surveys are restored.', $this->plugin_name ) );

        if ( empty( $updated_message ) )
            return;

        ?>
        <div class="notice notice-success is-dismissible">
            <p> <?php echo $updated_message; ?> </p>
        </div>
        <?php
    }
}
