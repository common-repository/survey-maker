<div id="tab5" class="ays-survey-tab-content <?php echo ($ays_tab == 'tab5') ? 'ays-survey-tab-content-active' : ''; ?>">
    <p class="ays-subtitle"><?php echo __('Limitation of Users',$this->plugin_name); ?></p>
    <hr/>
    <div class="form-group row ays_toggle_parent">
        <div class="col-sm-3">
            <label for="ays_survey_limit_users">
                <?php echo __('Maximum number of attempts per user',$this->plugin_name)?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name)?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-1">
            <input type="checkbox" class="ays-enable-timer1 ays_toggle_checkbox" id="ays_survey_limit_users" name="ays_survey_limit_users"
                   value="on" <?php echo ($survey_limit_users) ? 'checked' : ''; ?>/>
        </div>
        <div class="col-sm-8 ays_toggle_target ays_divider_left <?php echo ($survey_limit_users) ? "" : "display_none_not_important"; ?>">
            <div class="ays-limitation-options">
                <!-- Limitation by -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_limit_users_by_ip">
                            <?php echo __('Detects users by',$this->plugin_name)?>
                            <a class="ays_help" data-toggle="tooltip" data-html="true" title="<?php echo __('.',$this->plugin_name)?>">
                                <i class="ays_fa ays_fa_info_circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-check form-check-inline checkbox_ays">
                            <input type="radio" id="ays_limit_users_by_ip" class="form-check-input" name="ays_survey_limit_users_by" value="ip" <?php echo ($survey_limit_users_by == 'ip') ? 'checked' : ''; ?>/>
                            <label class="form-check-label" for="ays_limit_users_by_ip"><?php echo __('IP',$this->plugin_name)?></label>
                        </div>
                        <div class="form-check form-check-inline checkbox_ays">
                            <input type="radio" id="ays_limit_users_by_user_id" class="form-check-input" name="ays_survey_limit_users_by" value="user_id" <?php echo ($survey_limit_users_by == 'user_id') ? 'checked' : ''; ?>/>
                            <label class="form-check-label" for="ays_limit_users_by_user_id"><?php echo __('User ID',$this->plugin_name)?></label>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_survey_limitation_message">
                            <?php echo __('Message',$this->plugin_name)?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name)?>">
                                <i class="ays_fa ays_fa_info_circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <?php
                        $content = $survey_limitation_message;
                        $editor_id = 'ays_survey_limitation_message';
                        $settings = array('editor_height' => '8', 'textarea_name' => 'ays_survey_limitation_message', 'editor_class' => 'ays-textarea', 'media_elements' => false);
                        wp_editor($content, $editor_id, $settings);
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- Maximum number of attempts per user -->
    <hr/>
    <div class="form-group row ays_toggle_parent">
        <div class="col-sm-3">
            <label for="ays_survey_enable_logged_users">
                <?php echo __('Only for logged in users',$this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-1">
            <input type="checkbox" class="ays-enable-timer1 ays_toggle_checkbox" id="ays_survey_enable_logged_users" name="ays_survey_enable_logged_users" value="on" <?php echo ($survey_enable_logged_users) ? 'checked' : ''; ?> />
        </div>
        <div class="col-sm-8 ays_toggle_target ays_divider_left <?php echo ($survey_enable_logged_users) ? '' : 'display_none_not_important'; ?>">
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="ays_survey_logged_in_message">
                        <?php echo __('Message',$this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <?php
                    $content = $survey_logged_in_message;
                    $editor_id = 'ays_survey_logged_in_message';
                    $settings = array('editor_height' => '8', 'textarea_name' => 'ays_survey_logged_in_message', 'editor_class' => 'ays-textarea', 'media_elements' => false);
                    wp_editor($content, $editor_id, $settings);
                    ?>
                </div>
            </div>
        </div>
    </div> <!-- Only for logged in users -->
</div>
