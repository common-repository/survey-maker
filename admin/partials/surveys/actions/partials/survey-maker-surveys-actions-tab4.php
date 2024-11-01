<div id="tab4" class="ays-survey-tab-content <?php echo ($ays_tab == 'tab4') ? 'ays-survey-tab-content-active' : ''; ?>">
    <p class="ays-subtitle"><?php echo __('Survey results settings',$this->plugin_name); ?></p>
    <hr/>
    <div class="form-group row ays_toggle_parent">
        <div class="col-sm-4">
            <label for="ays_survey_redirect_after_submit">
                <?php echo __('Redirect after submit',$this->plugin_name)?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-1">
            <input type="checkbox" class="ays-enable-timer1 ays_toggle_checkbox" id="ays_survey_redirect_after_submit" name="ays_survey_redirect_after_submit" value="on" <?php echo $survey_redirect_after_submit ? 'checked' : '' ?>/>
        </div>
        <div class="col-sm-7 ays_toggle_target ays_divider_left <?php echo $survey_redirect_after_submit ? '' : 'display_none_not_important'; ?>">
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="ays_survey_submit_redirect_url">
                        <?php echo __('Redirect URL',$this->plugin_name)?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-8">
                    <input type="text" class="ays-text-input" id="ays_survey_submit_redirect_url" name="ays_survey_submit_redirect_url" value="<?php echo $survey_submit_redirect_url; ?>"/>
                </div>
            </div>
            <hr/>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="ays_survey_submit_redirect_delay">
                        <?php echo __('Redirect delay (sec)', $this->plugin_name)?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-8">
                    <input type="number" class="ays-text-input" id="ays_survey_submit_redirect_delay" name="ays_survey_submit_redirect_delay" value="<?php echo $survey_submit_redirect_delay; ?>"/>
                </div>
            </div>
        </div>
    </div> <!-- Redirect after submit -->
    <hr/>
    <div class="form-group row ays_toggle_parent">
        <div class="col-sm-4">
            <label for="ays_survey_enable_exit_button">
                <?php echo __('Enable EXIT button',$this->plugin_name)?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-1">
            <input type="checkbox" class="ays-enable-timer1 ays_toggle_checkbox" id="ays_survey_enable_exit_button" name="ays_survey_enable_exit_button" value="on" <?php echo $survey_enable_exit_button ? 'checked' : '' ?>/>
        </div>
        <div class="col-sm-7 ays_toggle_target ays_divider_left <?php echo $survey_enable_exit_button ? '' : 'display_none_not_important'; ?>">
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="ays_survey_exit_redirect_url">
                        <?php echo __('Redirect URL',$this->plugin_name)?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-8">
                    <input type="text" class="ays-text-input" id="ays_survey_exit_redirect_url" name="ays_survey_exit_redirect_url" value="<?php echo $survey_exit_redirect_url; ?>"/>
                </div>
            </div>
        </div>
    </div> <!-- Enable EXIT button -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-4">
            <label>
                <?php echo __('Select survey loader',$this->plugin_name)?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-8">
            <label class="ays_survey_loader">
                <input name="ays_survey_loader" type="radio" value="default" <?php echo ($survey_loader == 'default') ? 'checked' : ''; ?>>
                <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
            </label>
            <label class="ays_survey_loader">
                <input name="ays_survey_loader" type="radio" value="circle" <?php echo ($survey_loader == 'circle') ? 'checked' : ''; ?>>
                <div class="lds-circle"></div>
            </label>
            <label class="ays_survey_loader">
                <input name="ays_survey_loader" type="radio" value="dual_ring" <?php echo ($survey_loader == 'dual_ring') ? 'checked' : ''; ?>>
                <div class="lds-dual-ring"></div>
            </label>
            <label class="ays_survey_loader">
                <input name="ays_survey_loader" type="radio" value="facebook" <?php echo ($survey_loader == 'facebook') ? 'checked' : ''; ?>>
                <div class="lds-facebook"><div></div><div></div><div></div></div>
            </label>
            <label class="ays_survey_loader">
                <input name="ays_survey_loader" type="radio" value="hourglass" <?php echo ($survey_loader == 'hourglass') ? 'checked' : ''; ?>>
                <div class="lds-hourglass"></div>
            </label>
            <label class="ays_survey_loader">
                <input name="ays_survey_loader" type="radio" value="ripple" <?php echo ($survey_loader == 'ripple') ? 'checked' : ''; ?>>
                <div class="lds-ripple"><div></div><div></div></div>
            </label>
        </div>
    </div> <!-- Select quiz loader -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-4">
            <label for="ays_survey_final_result_text">
                <?php echo __('Thank you message',$this->plugin_name)?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name);?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
            <p class="ays_survey_small_hint_text_for_message_variables">
                <span><?php echo __( "To see all Message Variables " , $this->plugin_name ); ?></span>
                <a href="?page=survey-maker-settings" target="_blank"><?php echo __( "click here" , $this->plugin_name ); ?></a>
            </p>
        </div>
        <div class="col-sm-8">
            <?php
            $content = $ays_survey_final_result_text;
            $editor_id = 'ays_survey_final_result_text';
            $settings = array('editor_height' => '8', 'textarea_name' => 'ays_survey_final_result_text', 'editor_class' => 'ays-textarea', 'media_elements' => false);
            wp_editor($content, $editor_id, $settings);
            ?>
        </div>
    </div> <!-- Thank you message -->
</div>