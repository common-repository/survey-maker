<?php
global $ays_survey_db_version;
$ays_survey_db_version = '1.0.0';

/**
 * Fired during plugin activation
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Survey_Maker
 * @subpackage Survey_Maker/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Survey_Maker
 * @subpackage Survey_Maker/includes
 * @author     Survey Maker team <info@ays-pro.com>
 */
class Survey_Maker_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    private static function activate() {
        global $wpdb;
        global $ays_survey_db_version;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $installed_ver = get_option( "ays_survey_db_version" );
        $surveys_table                  = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . 'surveys';
        $questions_table                = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . 'questions';
        $sections_table                 = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . 'sections';
        $survey_categories_table        = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . 'survey_categories';
        $question_categories_table      = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . 'question_categories';
        $answers_table                  = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . 'answers';
        $submissions_table              = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . 'submissions';
        $submissions_questions_table    = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . 'submissions_questions';
        $settings_table                 = $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . 'settings';
        $charset_collate = $wpdb->get_charset_collate();

        if($installed_ver != $ays_survey_db_version)  {

            $sql = "CREATE TABLE `".$surveys_table."` (
                `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                `author_id` INT(16) UNSIGNED NOT NULL DEFAULT '0',
                `title` TEXT NOT NULL,
                `description` TEXT NOT NULL DEFAULT '',
                `category_ids` TEXT NOT NULL DEFAULT '',
                `question_ids` TEXT NOT NULL DEFAULT '',
                `section_ids` TEXT NOT NULL DEFAULT '',
                `sections_count` INT(11) NOT NULL DEFAULT '0',
                `questions_count` INT(11) NOT NULL DEFAULT '0',
                `date_created` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `date_modified` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `image` TEXT NOT NULL DEFAULT '',
                `status` VARCHAR(256) NOT NULL DEFAULT 'published',
                `trash_status` VARCHAR(256) NOT NULL DEFAULT '',
                `ordering` INT(16) NOT NULL,
                `post_id` INT(16) UNSIGNED DEFAULT NULL,
                `options` TEXT NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$surveys_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            $sql = "CREATE TABLE `".$questions_table."` (
                `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                `author_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
                `section_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
                `category_ids` TEXT NOT NULL DEFAULT '',
                `question` TEXT NOT NULL DEFAULT '',
                `type` VARCHAR(256) NOT NULL DEFAULT '',
                `status` VARCHAR(256) NOT NULL DEFAULT 'published',
                `trash_status` VARCHAR(256) NOT NULL DEFAULT '',
                `date_created` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `date_modified` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `user_variant` TEXT NULL DEFAULT '',
                `user_explanation` TEXT NULL DEFAULT '',
                `image` TEXT NOT NULL DEFAULT '',
                `ordering` INT(11) NOT NULL DEFAULT '1',
                `options` TEXT NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$questions_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            $sql = "CREATE TABLE `".$survey_categories_table."` (
                `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                `title` VARCHAR(256) NOT NULL DEFAULT '',
                `description` TEXT NOT NULL DEFAULT '',
                `status` VARCHAR(256) NOT NULL DEFAULT 'published',
                `trash_status` VARCHAR(256) NOT NULL DEFAULT '',
                `date_created` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `date_modified` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `options` TEXT NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$survey_categories_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }
 
            $sql = "CREATE TABLE `".$sections_table."` (
                `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                `title` VARCHAR(256) NOT NULL DEFAULT '',
                `description` TEXT NOT NULL DEFAULT '',
                `ordering` INT(11) NOT NULL DEFAULT '1',
                `options` TEXT NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$sections_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            $sql = "CREATE TABLE `".$question_categories_table."` (
                `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                `title` VARCHAR(256) NOT NULL DEFAULT '',
                `description` TEXT NOT NULL DEFAULT '',
                `status` VARCHAR(256) NOT NULL DEFAULT 'published',
                `trash_status` VARCHAR(256) NOT NULL DEFAULT '',
                `date_created` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `date_modified` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `options` TEXT NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$question_categories_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            $sql = "CREATE TABLE `".$answers_table."` (
                `id` INT(150) UNSIGNED NOT NULL AUTO_INCREMENT,
                `question_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
                `answer` TEXT NOT NULL DEFAULT '',
                `image` TEXT NOT NULL DEFAULT '',
                `ordering` INT(11) NOT NULL DEFAULT '1',
                `placeholder` TEXT NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$answers_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            $sql = "CREATE TABLE `".$submissions_table."` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `survey_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
                `questions_ids` TEXT NOT NULL DEFAULT '',
                `user_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
                `user_ip` VARCHAR(256) NOT NULL DEFAULT '',
                `user_name` TEXT NOT NULL DEFAULT '',
                `user_email` TEXT NOT NULL DEFAULT '',
                `start_date` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `end_date` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `submission_date` DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
                `duration` VARCHAR(256) NOT NULL DEFAULT '0',
                `questions_count` VARCHAR(256) NOT NULL DEFAULT '0',
                `unique_code` VARCHAR(256) NOT NULL DEFAULT '',
                `read` tinyint(3) NOT NULL DEFAULT 0,
                `status` VARCHAR(256) NOT NULL DEFAULT 'published',
                `options` TEXT NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$submissions_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            $sql = "CREATE TABLE `".$submissions_questions_table."` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `submission_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
                `question_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
                `section_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
                `survey_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
                `user_id` INT(11) NOT NULL DEFAULT '0',
                `answer_id` INT(11) NOT NULL DEFAULT '0',
                `user_answer` TEXT NOT NULL DEFAULT '',
                `user_variant` TEXT NOT NULL DEFAULT '',
                `user_explanation` TEXT NOT NULL DEFAULT '',
                `type` TEXT NOT NULL DEFAULT '',
                `options` TEXT NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$submissions_questions_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            $sql = "CREATE TABLE `".$settings_table."` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `meta_key` TEXT NOT NULL DEFAULT '',
                `meta_value` TEXT NOT NULL DEFAULT '',
                `note` TEXT NOT NULL DEFAULT '',
                `options` TEXT NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$settings_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            update_option( 'ays_survey_db_version', $ays_survey_db_version );
            
            $survey_categories = $wpdb->get_var( "SELECT COUNT(*) FROM " . $survey_categories_table );            
            if( intval($survey_categories) == 0 ){
                $wpdb->query("TRUNCATE TABLE `{$survey_categories_table}`");
                $wpdb->insert( $survey_categories_table, array(
                    'title' => 'Uncategorized',
                    'description' => '',
                    'status' => 'published',
                    'date_created' => current_time( 'mysql' ),
                    'date_modified' => current_time( 'mysql' ),
                ) );
            }

            $question_categories = $wpdb->get_var( "SELECT COUNT(*) FROM " . $question_categories_table );            
            if( intval($question_categories) == 0 ){
                $wpdb->query("TRUNCATE TABLE `{$question_categories_table}`");
                $wpdb->insert( $question_categories_table, array(
                    'title' => 'Uncategorized',
                    'description' => '',
                    'status' => 'published',
                    'date_created' => current_time( 'mysql' ),
                    'date_modified' => current_time( 'mysql' ),
                ) );
            }
        }
        
        $metas = array(
            "user_roles",
            "options",
        );
        
        foreach($metas as $meta_key){
            $meta_val = "";
            if($meta_key == "user_roles"){
                $meta_val = json_encode(array('administrator'));
            }
            $sql = "SELECT COUNT(*) FROM `".$settings_table."` WHERE `meta_key` = '".$meta_key."'";
            $result = $wpdb->get_var($sql);
            if(intval($result) == 0){
                $result = $wpdb->insert(
                    $settings_table,
                    array(
                        'meta_key'    => $meta_key,
                        'meta_value'  => $meta_val,
                        'note'        => "",
                        'options'     => ""
                    ),
                    array( '%s', '%s', '%s', '%s' )
                );
            }
        }
        
    }

    public static function ays_survey_update_db_check() {
        global $ays_survey_db_version;
        if ( get_site_option( 'ays_survey_db_version' ) != $ays_survey_db_version ) {
            self::activate();
        }
    }

}
