<?php
    require_once( SURVEY_MAKER_ADMIN_PATH . "/partials/surveys/actions/survey-maker-surveys-actions-options.php" );
?>

<div class="wrap">
    <div class="container-fluid">
        <form method="post" id="ays-survey-form">
            <input type="hidden" name="ays_survey_tab" value="<?php echo $ays_tab; ?>">
            <h1 class="wp-heading-inline">
                <?php
                    echo $heading;
                    $other_attributes = array('id' => 'ays-button-save-top');
                    submit_button(__('Save and close', $this->plugin_name), 'primary ays-button', 'ays_submit_top', false, $other_attributes);
                    $other_attributes = array('id' => 'ays-button-apply-top');
                    submit_button(__('Save', $this->plugin_name), 'ays-button', 'ays_apply_top', false, $other_attributes);
                ?>
            </h1>
            <div>
                <?php if($id !== null): ?>
                <div class="row">
                    <div class="col-sm-3">
                        <label> <?php echo __( "Shortcode text for editor", $this->plugin_name ); ?> </label>
                    </div>
                    <div class="col-sm-9">
                        <p style="font-size:14px; font-style:italic;">
                            <?php echo __("To insert the Survey into a page, post or text widget, copy shortcode", $this->plugin_name); ?>
                            <strong onClick="selectElementContents(this)" style="font-size:16px; font-style:normal;"><?php echo "[ays_survey id='".$id."']"; ?></strong>
                            <?php echo " " . __( "and paste it at the desired place in the editor.", $this->plugin_name); ?>
                        </p>
                    </div>
                </div>
                <?php endif;?>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label for='ays-survey-title'>
                        <?php echo __('Title', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Title of the survey',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-10">
                    <input type="text" class="ays-text-input" id='ays-survey-title' name='<?php echo $html_name_prefix; ?>title' value="<?php echo $title; ?>"/>
                </div>
            </div> <!-- Survey Title -->
            <hr/>
            <div class="ays-top-menu-wrapper">
                <div class="ays_menu_left" data-scroll="0"><i class="ays_fa ays_fa_angle_left"></i></div>
                <div class="ays-top-menu">
                    <div class="nav-tab-wrapper ays-top-tab-wrapper">
                        <a href="#tab1" data-tab="tab1" class="nav-tab <?php echo ($ays_tab == 'tab1') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("General", $this->plugin_name);?>
                        </a>
                        <a href="#tab2" data-tab="tab2" class="nav-tab <?php echo ($ays_tab == 'tab2') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("Styles", $this->plugin_name);?>
                        </a>
                        <a href="#tab3" data-tab="tab3" class="nav-tab <?php echo ($ays_tab == 'tab3') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("Settings", $this->plugin_name);?>
                        </a>
                        <a href="#tab4" data-tab="tab4" class="nav-tab <?php echo ($ays_tab == 'tab4') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("Results Settings", $this->plugin_name);?>
                        </a>
                        <a href="#tab5" data-tab="tab5" class="nav-tab <?php echo ($ays_tab == 'tab5') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("Limitation Users", $this->plugin_name);?>
                        </a>
                        <!-- <a href="#tab6" data-tab="tab6" class="nav-tab <?php //echo ($ays_tab == 'tab6') ? 'nav-tab-active' : ''; ?>">
                            <?php // echo __("User Data", $this->plugin_name);?>
                        </a> -->
                        <!-- <a href="#tab7" data-tab="tab7" class="nav-tab <?php // echo ($ays_tab == 'tab7') ? 'nav-tab-active' : ''; ?>">
                            <?php // echo __("E-Mail", $this->plugin_name);?>
                        </a> -->
                        <!-- <a href="#tab8" data-tab="tab8" class="nav-tab <?php // echo ($ays_tab == 'tab8') ? 'nav-tab-active' : ''; ?>">
                            <?php // echo __("Integrations", $this->plugin_name);?>
                        </a> -->
                    </div>  
                </div>
                <div class="ays_menu_right" data-scroll="-1"><i class="ays_fa ays_fa_angle_right"></i></div>
            </div>
            
            <?php
                for($tab_ind = 1; $tab_ind <= 8; $tab_ind++){
                    require_once( SURVEY_MAKER_ADMIN_PATH . "/partials/surveys/actions/partials/survey-maker-surveys-actions-tab".$tab_ind.".php" );
                }
            ?>

            <input type="hidden" name="<?php echo $html_name_prefix; ?>author_id" value="<?php echo $author_id; ?>">
            <input type="hidden" name="<?php echo $html_name_prefix; ?>post_id" value="<?php echo $post_id; ?>">
            <input type="hidden" name="<?php echo $html_name_prefix; ?>date_created" value="<?php echo $date_created; ?>">
            <input type="hidden" name="<?php echo $html_name_prefix; ?>date_modified" value="<?php echo $date_modified; ?>">
            <hr>
            <?php
                wp_nonce_field('survey_action', 'survey_action');
                $other_attributes = array();
                $buttons_html = '';
                $buttons_html .= '<div class="ays_save_buttons_content">';
                    $buttons_html .= '<div class="ays_save_buttons_box">';
                    echo $buttons_html;
                        $other_attributes = array('id' => 'ays-button-save');
                        submit_button(__('Save and close', $this->plugin_name), 'primary ays-button', 'ays_submit', false, $other_attributes);
                        $other_attributes = array('id' => 'ays-button-save-new');
                        submit_button(__('Save', $this->plugin_name), 'ays-button', 'ays_apply', false, $other_attributes);
                    $buttons_html = '</div>';
                    $buttons_html .= '<div class="ays_save_default_button_box">';
                    echo $buttons_html;
                        // $buttons_html = '<a class="ays_help" data-toggle="tooltip" title=".">
                        //     <i class="ays_fa ays_fa_info_circle"></i>
                        // </a>';
                        // echo $buttons_html;
                        // $other_attributes = array( 'data-message' => __( 'Are you sure that you want to save these parameters as default?', $this->plugin_name ) );
                        // submit_button(__('Save as default', $this->plugin_name), 'primary ays_default_btn', 'ays_default', false, $other_attributes);
                    $buttons_html = '</div>';
                $buttons_html .= "</div>";
                echo $buttons_html;
            ?>
        </form>
    </div>
</div>
