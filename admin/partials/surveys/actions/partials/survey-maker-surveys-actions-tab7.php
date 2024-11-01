<div id="tab7" class="ays-survey-tab-content <?php echo ($ays_tab == 'tab7') ? 'ays-survey-tab-content-active' : ''; ?>">
    <p class="ays-subtitle"><?php echo __('E-mail settings', $this->plugin_name); ?></p>
    <hr/>
    <div class="form-group row" style="margin:0px;">
        <div class="col-sm-12 only_pro">
            <div class="pro_features">
                <div>
                    <p>
                        <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                        <a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                    </p>
                    <p style="position: absolute;top: 0;">
                        <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                        <a href="https://ays-pro.com/wordpress/survey-maker/" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="ays_survey_enable_mail_user">
                        <?php echo __('Send email to user',$this->plugin_name)?>
                        <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-1">
                    <input type="checkbox" class="ays-enable-timerl" id="ays_survey_enable_mail_user" value="on" />
                </div>
                <div class="col-sm-8 ays_divider_left">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_survey_mail_message">
                                <?php echo __('Email message',$this->plugin_name)?>
                                <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                            <p class="ays_survey_small_hint_text_for_message_variables">
                                <span><?php echo __( "To see all Message Variables " , $this->plugin_name ); ?></span>
                                <a href="?page=survey-maker-settings" target="_blank"><?php echo __( "click here" , $this->plugin_name ); ?></a>
                            </p>
                        </div>
                        <div class="col-sm-9">
                            <?php
                            $content = '';
                            $editor_id = 'ays_survey_mail_message';
                            $settings = array('editor_height' => '8', 'textarea_name' => 'ays_survey_mail_message', 'editor_class' => 'ays-textarea', 'media_elements' => false);
                            wp_editor($content, $editor_id, $settings);
                            ?>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_survey_test_email">
                                <?php echo __('Send email for testing',$this->plugin_name)?>
                                <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <div class="ays_send_test">
                                <input type="text" id="ays_survey_test_email" class="ays-text-input" value="<?php echo $ays_super_admin_email; ?>">
                                <input type="hidden" value="<?php echo $id; ?>">
                                <a href="javascript:void(0)" class="ays_survey_test_mail_btn button button-primary"><?php echo __( "Send", $this->plugin_name ); ?></a>
                                <span id="ays_survey_test_delivered_message" data-src="<?php echo SURVEY_MAKER_ADMIN_URL . "/images/loaders/loading.gif" ?>" style="display: none;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Send Mail To User -->
            <hr/>
            <div class="form-group row ays_toggle_parent">
                <div class="col-sm-3">
                    <label for="ays_survey_enable_mail_admin">
                        <?php echo __('Send email to admin',$this->plugin_name)?>
                        <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-1">
                    <input type="checkbox" class="ays-enable-timerl ays_toggle_checkbox" id="ays_survey_enable_mail_admin" value="on" />
                </div>
                <div class="col-sm-8 ays_toggle_target ays_divider_left">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_survey_send_mail_to_site_admin">
                                <?php echo __('Admin', $this->plugin_name)?>
                                <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-1">
                            <input type="checkbox" class="ays-enable-timerl" id="ays_survey_send_mail_to_site_admin" value="on" />
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="ays-text-input ays-enable-timerl" placeholder="<?php echo $ays_super_admin_email; ?>" disabled />
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_survey_additional_emails">
                                <?php echo __('Additional emails',$this->plugin_name)?>
                                <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="ays-text-input" id="ays_survey_additional_emails" placeholder="example1@gmail.com, example2@gmail.com, ..."/>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_survey_mail_message_admin">
                                <?php echo __('Email message',$this->plugin_name)?>
                                <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                            <p class="ays_survey_small_hint_text_for_message_variables">
                                <span><?php echo __( "To see all Message Variables " , $this->plugin_name ); ?></span>
                                <a href="?page=survey-maker-settings" target="_blank"><?php echo __( "click here" , $this->plugin_name ); ?></a>
                            </p>
                        </div>
                        <div class="col-sm-9">
                            <?php
                            $content = '';
                            $editor_id = 'ays_survey_mail_message_admin';
                            $settings = array('editor_height' => '8', 'textarea_name' => 'ays_survey_mail_message_admin', 'editor_class' => 'ays-textarea', 'media_elements' => false);
                            wp_editor($content, $editor_id, $settings);
                            ?>
                        </div>
                    </div>
                </div>
            </div> <!-- Send mail to admin -->
            <hr/>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label>
                        <?php echo __('Email configuration',$this->plugin_name)?>
                        <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-8 ays_divider_left">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_survey_email_configuration_from_email">
                                <?php echo __('From email',$this->plugin_name)?>
                                <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="ays-text-input" id="ays_survey_email_configuration_from_email" value=""/>
                        </div>
                    </div> <!-- From email -->
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_survey_email_configuration_from_name">
                                <?php echo __('From name',$this->plugin_name)?>
                                <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="ays-text-input" id="ays_survey_email_configuration_from_names" value=""/>
                        </div>
                    </div><!-- From name -->
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_survey_email_configuration_from_subject">
                                <?php echo __('Subject',$this->plugin_name)?>
                                <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="ays-text-input" id="ays_survey_email_configuration_from_subject" value=""/>
                        </div>
                    </div> <!-- Subject -->
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_survey_email_configuration_replyto_email">
                                <?php echo __('Reply to email',$this->plugin_name)?>
                                <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="ays-text-input" id="ays_survey_email_configuration_replyto_email" value=""/>
                        </div>
                    </div> <!-- Reply to email -->
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_survey_email_configuration_replyto_name">
                                <?php echo __('Reply to name',$this->plugin_name)?>
                                <a  class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="ays-text-input" id="ays_survey_email_configuration_replyto_name" value=""/>
                        </div>
                    </div> <!-- Reply to name -->
                </div>
            </div> <!-- Email Configuration -->
        </div>
    </div>
</div>
