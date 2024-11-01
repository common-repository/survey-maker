<?php
class Survey_Maker_Settings_Actions {
    private $plugin_name;

    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
    }

    public function store_data($data){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ayssurvey_settings";
        if( isset($data["settings_action"]) && wp_verify_nonce( $data["settings_action"], 'settings_action' ) ){
            $success = 0;

            $roles = (isset($data['ays_user_roles']) && !empty($data['ays_user_roles'])) ? $data['ays_user_roles'] : array('administrator');

            // $next_button            = (isset($data['ays_next_button']) && $data['ays_next_button'] != '') ? $data['ays_next_button'] : 'Next' ;
            // $finish_button          = (isset($data['ays_finish_button']) && $data['ays_finish_button'] != '') ? $data['ays_finish_button'] : 'Finish' ;

            // $buttons_texts = array(
            //     'next_button'           => $next_button,
            //     'previous_button'       => $previous_button,
            // );

            $options = array(

            );
            
           // $month_count = 10;
            // $del_stat = "";
            // $month_count = isset($data['ays_delete_results_by']) ? intval($data['ays_delete_results_by']) : null;
            // if($month_count !== null && $month_count > 0){
            //     $year = intval( date( 'Y', current_time('timestamp') ) );
            //     $dt = intval( date( 'n', current_time('timestamp') ) );
            //     $month = $dt - $month_count;
            //     if($month < 0){
            //         $month = 12 - $month;
            //         if($month > 12){
            //             $mn = $month % 12;
            //             $mnac = ($month - $mn) / 12;
            //             $month = 12 - ($mn);
            //             $year -= $mnac;
            //         }
            //     }elseif($month == 0){        
            //         $month = 12;
            //         $year--;
            //     }                
            //     $sql = "DELETE FROM " . $wpdb->prefix . "aysquiz_reports 
            //             WHERE YEAR(end_date) = '".$year."' 
            //               AND MONTH(end_date) <= '".$month."'";
            //     $res = $wpdb->query($sql);
            //     if($res >= 0){
            //         $del_stat = "&del_stat=ok&mcount=".$data['ays_delete_results_by'];
            //     }
            // }
            
            // $result = update_option(
            //     'ays_quiz_integrations',
            //     json_encode($paypal_options)
            // );

            // if($result){
            //     $success++;
            // }
            // $result = $this->ays_update_setting('options', json_encode($options));
            // if ($result) {
            //     $success++;
            // }

            // $fields = array();

            $fields['user_roles'] = $roles;
            $fields['options'] = $options;

            $fields = apply_filters( 'ays_sm_settings_page_integrations_saves', $fields, $data );
            foreach ($fields as $key => $value) {
                $result = $this->ays_update_setting($key, json_encode($value));
                if($result){
                    $success++;
                }
            }

            $message = "saved";
            if($success > 0){
                $tab = "";
                if(isset($data['ays_survey_tab'])){
                    $tab = "&ays_survey_tab=".$data['ays_survey_tab'];
                }
                $url = admin_url('admin.php') . "?page=survey-maker-settings" . $tab . '&status=' . $message . $del_stat;
//                var_dump($url);
                wp_redirect( $url );
            }
        }
        
    }

    public function get_data(){
        $data = get_option( "ays_quiz_integrations" );
        if($data == null || $data == ''){
            return array();
        }else{
            return json_decode( get_option( "ays_quiz_integrations" ), true );
        }
    }

    public function get_db_data(){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ayssurvey_settings";
        $sql = "SELECT * FROM ".$settings_table;
        $results = $wpdb->get_results($sql, ARRAY_A);
        if(count($results) > 0){
            return $results;
        }else{
            return array();
        }
    }    
    
    public function check_settings_meta($metas){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ayssurvey_settings";
        foreach($metas as $meta_key){
            $sql = "SELECT COUNT(*) FROM ".$settings_table." WHERE meta_key = '".$meta_key."'";
            $result = $wpdb->get_var($sql);
            if(intval($result) == 0){
                $this->ays_add_setting($meta_key, "", "", "");
            }
        }
        return false;
    }
    
    public function check_setting_user_roles(){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ayssurvey_settings";
        $sql = "SELECT COUNT(*) FROM ".$settings_table." WHERE meta_key = 'user_roles'";
        $result = $wpdb->get_var($sql);
        if(intval($result) == 0){
            $roles = json_encode(array('administrator'));
            $this->ays_add_setting("user_roles", $roles, "", "");
        }
        return false;
    }
        
    public function get_reports_titles(){
        global $wpdb;

        $sql = "SELECT {$wpdb->prefix}aysquiz_quizes.id,{$wpdb->prefix}aysquiz_quizes.title FROM {$wpdb->prefix}aysquiz_quizes";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }
    
    public function ays_get_setting($meta_key){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ayssurvey_settings";
        $sql = "SELECT meta_value FROM ".$settings_table." WHERE meta_key = '".$meta_key."'";
        $result = $wpdb->get_var($sql);
        if($result != ""){
            return $result;
        }
        return false;
    }
    
    public function ays_add_setting($meta_key, $meta_value, $note = "", $options = ""){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ayssurvey_settings";
        $result = $wpdb->insert(
            $settings_table,
            array(
                'meta_key'    => $meta_key,
                'meta_value'  => $meta_value,
                'note'        => $note,
                'options'     => $options
            ),
            array( '%s', '%s', '%s', '%s' )
        );
        if($result >= 0){
            return true;
        }
        return false;
    }
    
    public function ays_update_setting($meta_key, $meta_value, $note = null, $options = null){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ayssurvey_settings";
        $value = array(
            'meta_value'  => $meta_value,
        );
        $value_s = array( '%s' );
        if($note != null){
            $value['note'] = $note;
            $value_s[] = '%s';
        }
        if($options != null){
            $value['options'] = $options;
            $value_s[] = '%s';
        }
        $result = $wpdb->update(
            $settings_table,
            $value,
            array( 'meta_key' => $meta_key, ),
            $value_s,
            array( '%s' )
        );
        if($result >= 0){
            return true;
        }
        return false;
    }
    
    public function ays_delete_setting($meta_key){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ayssurvey_settings";
        $wpdb->delete(
            $settings_table,
            array( 'meta_key' => $meta_key ),
            array( '%s' )
        );
    }

    public function get_empty_duration_rows_count(){
        global $wpdb;
        $sql = "SELECT COUNT(*) AS c
                FROM {$wpdb->prefix}aysquiz_reports
                WHERE (duration = '' OR duration IS NULL)";
        $result = $wpdb->get_var($sql);
        return intval($result);
    }

    public function update_duration_data(){
        global $wpdb;
        $sql = "UPDATE `{$wpdb->prefix}ayssurvey_reports`
                SET `duration`= TIMESTAMPDIFF(SECOND, start_date, end_date)";
        $result = $wpdb->query($sql);
        if($result){
            $tab = "&ays_survey_tab=tab3";
            $message = "duration_updated";
            $url = admin_url('admin.php') . "?page=survey-maker-settings" . $tab . '&status=' . $message;
            wp_redirect( $url );
            exit;
        }
    }

    public function survey_settings_notices($status){

        if ( empty( $status ) )
            return;

        if ( 'saved' == $status )
            $updated_message = esc_html( __( 'Changes saved.', $this->plugin_name ) );
        elseif ( 'updated' == $status )
            $updated_message = esc_html( __( 'Quiz attribute .', $this->plugin_name ) );
        elseif ( 'deleted' == $status )
            $updated_message = esc_html( __( 'Quiz attribute deleted.', $this->plugin_name ) );
        elseif ( 'duration_updated' == $status )
            $updated_message = esc_html( __( 'Duration old data is successfully updated.', $this->plugin_name ) );

        if ( empty( $updated_message ) )
            return;

        ?>
        <div class="notice notice-success is-dismissible">
            <p> <?php echo $updated_message; ?> </p>
        </div>
        <?php
    }
    
}
