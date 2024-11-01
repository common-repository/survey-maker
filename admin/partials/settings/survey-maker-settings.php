<?php
    $actions = $this->settings_obj;

    if( isset( $_REQUEST['ays_submit'] ) ){
        $actions->store_data($_REQUEST);
    }
    if(isset($_GET['ays_survey_tab'])){
        $ays_survey_tab = $_GET['ays_survey_tab'];
    }else{
        $ays_survey_tab = 'tab1';
    }

    // if(isset($_GET['action']) && $_GET['action'] == 'update_duration'){
    //     $actions->update_duration_data();
    // }

    // $data = $actions->get_data();
    $db_data = $actions->get_db_data();
    $options = ($actions->ays_get_setting('options') === false) ? array() : json_decode($actions->ays_get_setting('options'), true);

    global $wp_roles;
    $ays_users_roles = $wp_roles->role_names;
    $user_roles = json_decode($actions->ays_get_setting('user_roles'), true);

    // $quizzes = $actions->get_reports_titles();
    // $empry_dur_count = $actions->get_empty_duration_rows_count();

    // $buttons_texts_res      = ($actions->ays_get_setting('buttons_texts') === false) ? json_encode(array()) : $actions->ays_get_setting('buttons_texts');
    // $buttons_texts          = json_decode($buttons_texts_res, true);

    // $next_button            = (isset($buttons_texts['next_button']) && $buttons_texts['next_button'] != '') ? $buttons_texts['next_button'] : 'Next' ;
    // $finish_button          = (isset($buttons_texts['finish_button']) && $buttons_texts['finish_button'] != '') ? $buttons_texts['finish_button'] : 'Finish' ;


?>
<div class="wrap" style="position:relative;">
    <div class="container-fluid">
        <form method="post" id="ays-quiz-settings-form">
            <input type="hidden" name="ays_survey_tab" value="<?php echo $ays_survey_tab; ?>">
            <h1 class="wp-heading-inline">
            <?php
                echo __('General Settings',$this->plugin_name);
            ?>
            </h1>
            <?php
                if( isset( $_REQUEST['status'] ) ){
                    $actions->survey_settings_notices($_REQUEST['status']);
                }
            ?>
            <hr/>
            <div class="ays-settings-wrapper">
                <div>
                    <div class="nav-tab-wrapper" style="position:sticky; top:35px;">
                        <a href="#tab1" data-tab="tab1" class="nav-tab <?php echo ($ays_survey_tab == 'tab1') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("General", $this->plugin_name);?>
                        </a>
                       <!--  <a href="#tab2" data-tab="tab2" class="nav-tab <?php echo ($ays_survey_tab == 'tab2') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("Integrations", $this->plugin_name);?>
                        </a> -->
                    </div>
                </div>
                <div class="ays-quiz-tabs-wrapper">
                    <div id="tab1" class="ays-survey-tab-content <?php echo ($ays_survey_tab == 'tab1') ? 'ays-survey-tab-content-active' : ''; ?>">
                        <p class="ays-subtitle"><?php echo __('General Settings',$this->plugin_name)?></p>
                        <hr/>
                        <fieldset>
                            <legend>
                                <strong style="font-size:30px;"><i class="ays_fa ays_fa_globe"></i></strong>
                                <h5><?php echo __('Who will have permission to Survey menu',$this->plugin_name)?></h5>
                            </legend>
                            <div class="form-group row" style="margin:0px;">
                                <div class="col-sm-12 only_pro">
                                    <div class="pro_features">
                                        <!-- <div>
                                            <p>
                                                <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                                                <a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                                            </p>
                                        </div> -->
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label for="ays_user_roles">
                                                <?php echo __( "Select user role", $this->plugin_name ); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Ability to manage Survey Maker plugin only for selected user roles.',$this->plugin_name)?>">
                                                    <i class="ays_fa ays_fa_info_circle"></i>
                                                </a>
                                            </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <select name="ays_user_roles[]" id="ays_user_roles" multiple="multiple">
                                                <?php
                                                    foreach($ays_users_roles as $role => $role_name){
                                                        $selected = in_array($role, $user_roles) ? 'selected' : '';
                                                        echo "<option ".$selected." value='".$role."'>".$role_name."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <blockquote>
                                        <?php echo __( "Ability to manage Survey Maker plugin only for selected user roles.", $this->plugin_name ); ?>
                                    </blockquote>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div id="tab2" class="ays-survey-tab-content <?php echo ($ays_survey_tab == 'tab2') ? 'ays-survey-tab-content-active' : ''; ?>">
                        <p class="ays-subtitle"><?php echo __('Integrations',$this->plugin_name)?></p>
                        <hr/>
                        <?php
                            do_action( 'ays_sm_settings_page_integrations' );
                        ?>                        
                    </div>
                </div>
            </div>
            <hr/>
            <div style="position:sticky;padding:15px 0px;bottom:0;">
            <?php
                wp_nonce_field('settings_action', 'settings_action');
                $other_attributes = array();
                submit_button(__('Save changes', $this->plugin_name), 'primary', 'ays_submit', true, $other_attributes);
            ?>
            </div>
        </form>
    </div>
</div>
