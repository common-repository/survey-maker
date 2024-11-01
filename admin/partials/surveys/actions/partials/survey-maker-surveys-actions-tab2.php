<div id="tab2" class="ays-survey-tab-content <?php echo ($ays_tab == 'tab2') ? 'ays-survey-tab-content-active' : ''; ?>">
    <p class="ays-subtitle"><?php echo __('Survey Styles',$this->plugin_name); ?></p>
    <hr/>
    <div class="form-group row">
        <div class="col-sm-2">
            <label for="ays_survey_theme">
                <?php echo __('Theme', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-10">
            <select name="ays_survey_theme" id="ays_survey_theme" class="ays-text-input ays-text-input-short ays_survey_aysDropdown" style="display:block;">
                <option value="classic_light" <?php echo $survey_theme == 'classic_light' ? 'selected' : ''; ?>><?php echo __( "Classic Light", $this->plugin_name ); ?></option>
                <option value="classic_dark" <?php echo $survey_theme == 'classic_dark' ? 'selected' : ''; ?>><?php echo __( "Classic Dark", $this->plugin_name ); ?></option>
            </select>
        </div>
    </div> <!-- Survey Theme -->
    <hr/>	
    <div class="row">
        <div class="col-lg-7 col-sm-12">
            <div class="form-group row">
                <div class="col-sm-5">
                    <label for='ays_survey_color'>
                        <?php echo __('Survey color', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <input type="text" class="ays-text-input" id='ays_survey_color' name='ays_survey_color' data-alpha="true" value="<?php echo $survey_color; ?>"/>
                </div>
            </div> <!-- Survey Color -->
            <hr/>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label for='ays_survey_background_color'>
                        <?php echo __('Background color', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <input type="text" class="ays-text-input" id='ays_survey_background_color' data-alpha="true" name='ays_survey_background_color' value="<?php echo $survey_background_color; ?>"/>
                </div>
            </div> <!-- Survey Background Color -->
            <hr/>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label for='ays_survey_text_color'>
                        <?php echo __('Text color', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <input type="text" class="ays-text-input" id='ays_survey_text_color' data-alpha="true"name='ays_survey_text_color' value="<?php echo $survey_text_color; ?>"/>
                </div>
            </div> <!-- Text Color -->
            <hr/>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label for='ays_survey_buttons_text_color'>
                        <?php echo __('Button text color', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <input type="text" class="ays-text-input" id='ays_survey_buttons_text_color' data-alpha="true" name='ays_survey_buttons_text_color' value="<?php echo $survey_buttons_text_color; ?>"/>
                </div>
            </div> <!-- Buttons text Color -->
            <hr/>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label for='ays_survey_width'>
                        <?php echo __('Survey width', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-6 ays_divider_left ays_survey_display_flex">
                    <div>
                        <input type="number" class="ays-text-input ays-text-input-short" id='ays_survey_width' name='ays_survey_width' value="<?php echo $survey_width; ?>"/>
                        <span style="display:block;" class="ays_survey_small_hint_text"><?php echo __("For 100% leave blank", $this->plugin_name); ?></span>
                    </div>
                    <div>
                        <select id="ays_survey_width_by_percentage_px" name="ays_survey_width_by_percentage_px" class="ays-text-input ays-text-input-short ays_survey_aysDropdown" style="display:inline-block; width: 60px;">
                            <option value="pixels" <?php echo $survey_width_by_percentage_px == "pixels" ? "selected" : ""; ?>>px</option>
                            <option value="percentage" <?php echo $survey_width_by_percentage_px == "percentage" ? "selected" : ""; ?>>%</option>
                        </select>
                    </div>
                </div>
            </div> <!-- Survey width -->
            <hr/>
		    <p class="ays-subtitle" style="margin-top:0;"><?php echo __('Question Styles',$this->plugin_name); ?></p>
		    <hr/>
		    <div class="form-group row">
                <div class="col-sm-5">
                    <label for='ays_survey_question_font_size'>
                        <?php echo __('Question font size', $this->plugin_name); ?> (px)
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <input type="number" class="ays-text-input ays-text-input-short" id='ays_survey_question_font_size'name='ays_survey_question_font_size' value="<?php echo $survey_question_font_size; ?>"/>
                </div>
            </div> <!-- Question font size -->
            <hr/>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label>
                        <?php echo __('Question image styles',$this->plugin_name)?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="ays_survey_question_image_width">
                                <?php echo __('Image width',$this->plugin_name)?>(px)
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                            <input type="number" class="ays-text-input ays-text-input-short" id="ays_survey_question_image_width" name="ays_survey_question_image_width" value="<?php echo $survey_question_image_width; ?>"/>
                            <span class="ays_survey_small_hint_text"><?php echo __("For 100% leave blank", $this->plugin_name); ?></span>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="ays_survey_question_image_height">
                                <?php echo __('Image height',$this->plugin_name)?>(px)
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                            <input type="number" class="ays-text-input ays-text-input-short" id="ays_survey_question_image_height" name="ays_survey_question_image_height" value="<?php echo $survey_question_image_height; ?>"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="ays_survey_question_image_sizing">
                                <?php echo __('Image sizing', $this->plugin_name ); ?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                                    <i class="ays_fa ays_fa_info_circle"></i>
                                </a>
                            </label>
                            <select name="ays_survey_question_image_sizing" id="ays_survey_question_image_sizing" class="ays-text-input ays-text-input-short ays_survey_aysDropdown" style="display:block;">
                                <option value="cover" <?php echo $survey_question_image_sizing == 'cover' ? 'selected' : ''; ?>><?php echo __( "Cover", $this->plugin_name ); ?></option>
                                <option value="contain" <?php echo $survey_question_image_sizing == 'contain' ? 'selected' : ''; ?>><?php echo __( "Contain", $this->plugin_name ); ?></option>
                                <option value="none" <?php echo $survey_question_image_sizing == 'none' ? 'selected' : ''; ?>><?php echo __( "None", $this->plugin_name ); ?></option>
                                <option value="unset" <?php echo $survey_question_image_sizing == 'unset' ? 'selected' : ''; ?>><?php echo __( "Unset", $this->plugin_name ); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div> <!-- Question image styles -->
            <hr/>
		    <p class="ays-subtitle" style="margin-top:0;"><?php echo __('Answers Styles',$this->plugin_name); ?></p>
		    <hr/>
		    <div class="form-group row">
                <div class="col-sm-5">
                    <label for='ays_survey_answer_font_size'>
                        <?php echo __('Answer font size', $this->plugin_name); ?> (px)
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <input type="number" class="ays-text-input ays-text-input-short" id='ays_survey_answer_font_size'name='ays_survey_answer_font_size' value="<?php echo $survey_answer_font_size; ?>"/>
                </div>
            </div> <!-- Answer font size -->
            <hr/>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label for="ays_survey_answers_object_fit">
                        <?php echo __('Answer object-fit',$this->plugin_name)?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <select class="ays-text-input ays-text-input-short ays_survey_aysDropdown" id="ays_survey_answers_object_fit" name="ays_survey_answers_object_fit">
                        <option value="cover" <?php echo ($survey_answers_object_fit == 'cover') ? 'selected' : ''; ?>><?php echo __('Cover',$this->plugin_name); ?></option>
                        <option value="fill" <?php echo ($survey_answers_object_fit == 'fill') ? 'selected' : ''; ?>><?php echo __('Fill',$this->plugin_name); ?></option>
                        <option value="contain" <?php echo ($survey_answers_object_fit == 'contain') ? 'selected' : ''; ?>><?php echo __('Contain',$this->plugin_name); ?></option>
                        <option value="scale-down" <?php echo ($survey_answers_object_fit == 'scale-down') ? 'selected' : ''; ?>><?php echo __('Scale-down',$this->plugin_name); ?></option>
                        <option value="none" <?php echo ($survey_answers_object_fit == 'none') ? 'selected' : ''; ?>><?php echo __('None',$this->plugin_name); ?></option>
                    </select>
                </div>
            </div> <!-- Answer object-fit -->
            <hr/>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label for="ays_survey_answers_padding">
                        <?php echo __('Answer padding',$this->plugin_name); ?> (px)
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <input type="number" class="ays-text-input ays-text-input-short" id='ays_survey_answers_padding' name='ays_survey_answers_padding' value="<?php echo $survey_answers_padding; ?>"/>
                </div>
            </div> <!-- Answer padding -->
            <hr/>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label for="ays_survey_answers_gap">
                        <?php echo __('Answer gap',$this->plugin_name)?> (px)
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Gap between answers', $this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <input type="number" class="ays-text-input ays-text-input-short" id='ays_survey_answers_gap' name='ays_survey_answers_gap' value="<?php echo $survey_answers_gap; ?>"/>
                </div>
            </div> <!-- Answers gap -->
            <hr/>
        </div>
        <div class="col-lg-5 col-sm-12 ays_divider_left" style="position:relative; display: none;">

        </div> <!-- Live preview container -->
    </div>
    <hr/>
    <p class="ays-subtitle" style="margin-top:0;"><?php echo __('Buttons Styles',$this->plugin_name); ?></p>
    <hr/>
    <div class="form-group row"> <!-- Buttons Styles -->
        <div class="col-lg-7 col-sm-12">
            <div class="form-group row">
                <div class="col-sm-5">
                    <label for="ays_survey_buttons_size">
                        <?php echo __('Button size',$this->plugin_name)?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <select class="ays-text-input ays-text-input-short ays_survey_aysDropdown" id="ays_survey_buttons_size" name="ays_survey_buttons_size">
                        <option value="small" <?php echo ($survey_buttons_size == 'small') ? 'selected' : ''; ?>>
                            <?php echo __('Small',$this->plugin_name); ?>
                        </option>
                        <option value="medium" <?php echo ( ($survey_buttons_size == 'medium') || !isset($options['survey_buttons_size']) ) ? 'selected' : ''; ?>>
                            <?php echo __('Medium',$this->plugin_name); ?>
                        </option>
                        <option value="large" <?php echo ($survey_buttons_size == 'large') ? 'selected' : ''; ?>>
                            <?php echo __('Large',$this->plugin_name); ?>
                        </option>
                    </select>
                </div>
            </div> <!-- Button size -->
            <hr>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label for='ays_survey_buttons_font_size'>
                        <?php echo __('Button font-size', $this->plugin_name); ?> (px)
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <input type="number" class="ays-text-input ays-text-input-short" id='ays_survey_buttons_font_size' name='ays_survey_buttons_font_size' value="<?php echo $survey_buttons_font_size; ?>"/>
                </div>
            </div> <!-- Button font-size -->
            <hr>
            <div class="form-group row">
	            <div class="col-sm-5">
	                <label for="ays_survey_buttons_left_right_padding">
	                    <?php echo __('Button padding',$this->plugin_name)?> (px)
	                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
	                        <i class="ays_fa ays_fa_info_circle"></i>
	                    </a>
	                </label>
	            </div>
	            <div class="col-sm-7 ays_divider_left">
	                <div class="col-sm-5" style="display: inline-block; padding-left: 0;">
	                    <span class="ays_survey_small_hint_text"><?php echo __('Left / Right',$this->plugin_name); ?></span>
	                    <input type="number" class="ays-text-input" id='ays_survey_buttons_left_right_padding' name='ays_survey_buttons_left_right_padding' value="<?php echo $survey_buttons_left_right_padding; ?>" style="width: 100px;" />
	                </div>
	                <div class="col-sm-5 ays_divider_left" style="display: inline-block;">
	                    <span class="ays_survey_small_hint_text"><?php echo __('Top / Bottom',$this->plugin_name); ?></span>
	                    <input type="number" class="ays-text-input" id='ays_survey_buttons_top_bottom_padding' name='ays_survey_buttons_top_bottom_padding' value="<?php echo $survey_buttons_top_bottom_padding; ?>" style="width: 100px;" />
	                </div>
	            </div>
	        </div> <!-- Button padding -->
        	<hr/>
	        <div class="form-group row">
	            <div class="col-sm-5">
	                <label for="ays_survey_buttons_border_radius">
	                    <?php echo __('Button border-radius',$this->plugin_name)?> (px)
	                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
	                        <i class="ays_fa ays_fa_info_circle"></i>
	                    </a>
	                </label>
	            </div>
	            <div class="col-sm-7 ays_divider_left">
	                <input type="number" class="ays-text-input ays-text-input-short" id="ays_survey_buttons_border_radius" name="ays_survey_buttons_border_radius" value="<?php echo $survey_buttons_border_radius; ?>"/>
	            </div>
	        </div> <!-- Button border-radius -->
	        <hr/>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label for="ays_survey_custom_class">
                        <?php echo __('Custom class for survey container',$this->plugin_name)?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-7 ays_divider_left">
                    <input type="text" class="ays-text-input" name="ays_survey_custom_class" id="ays_survey_custom_class" placeholder="myClass myAnotherClass..." value="<?php echo $survey_custom_class; ?>">
                </div>
            </div> <!-- Custom class for survey container -->
        	<hr/>
        </div>
        <hr/>
        <div class="col-lg-5 col-sm-12 ays_divider_left" style="position:relative; display: none;">
            <div id="ays_buttons_styles_tab" style="position:sticky;top:50px; margin:auto;">
                <div class="ays_buttons_div" style="justify-content: center; overflow:hidden;">
                    <input type="button" name="next" class="action-button ays-quiz-live-button" style="padding:0;" value="<?php echo __( "Start", $this->plugin_name ); ?>">
                </div>
            </div>
        </div> <!-- Buttons Styles Live -->
    </div> <!-- Buttons Styles End -->
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="ays_survey_custom_css">
                <?php echo __('Custom CSS',$this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
        	<textarea class="ays-textarea" id="ays_survey_custom_css" name="ays_survey_custom_css" cols="30" rows="10"><?php echo $survey_custom_css; ?></textarea>
        </div>
    </div> <!-- Custom CSS -->
</div>
