<div id="tab3" class="ays-survey-tab-content <?php echo ($ays_tab == 'tab3') ? 'ays-survey-tab-content-active' : ''; ?>">
    <p class="ays-subtitle"><?php echo __('Survey Settings',$this->plugin_name)?></p>
    <hr/>
    <div class="form-group row">
        <div class="col-sm-4">
            <label for="ays-category">
                <?php echo __('Survey categories', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Categories of the survey. For making a category please visit Survey Categories page from left navbar',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-8">
            <select id="ays-category" name="<?php echo $html_name_prefix; ?>category_ids[]" multiple>
                <option></option>
                <?php
                foreach ($categories as $key => $category) {
                    $selected = in_array( $category['id'], $category_ids ) ? "selected" : "";
                    if( empty( $category_ids ) ){
                        if ( intval( $category['id'] ) == 1 ) {
                            $selected = 'selected';
                        }
                    }
                    echo '<option value="' . $category["id"] . '" ' . $selected . '>' . stripslashes( $category['title'] ) . '</option>';
                }
                ?>
            </select>
        </div>
    </div> <!-- Survey Category -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-4">
            <label for="ays-status">
                <?php echo __('Survey status', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Choose whether the quiz is active or not.If you choose Unpublished option, the quiz won’t be shown anywhere in your website (You don’t need to remove shortcodes).',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-8">
            <select id="ays-status" name="<?php echo $html_name_prefix; ?>status">
                <option></option>
                <option <?php selected( $status, 'published' ); ?> value="published"><?php echo __( "Published", $this->plugin_name ); ?></option>
                <option <?php selected( $status, 'draft' ); ?> value="draft"><?php echo __( "Draft", $this->plugin_name ); ?></option>
            </select>
        </div>
    </div> <!-- Survey Status -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-4">
            <label for="ays_survey_show_title">
                <?php echo __('Show survey title',$this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-8">
                <input type="checkbox" id="ays_survey_show_title" name="ays_survey_show_title" value="on" <?php echo $survey_show_title ? 'checked' : ''; ?>/>
        </div>
    </div> <!-- Show survey title -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-4">
            <label for="ays_survey_enable_randomize_answers">
                <?php echo __('Enable randomize answers',$this->plugin_name)?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-8">
            <input type="checkbox" class="ays-enable-timerl" id="ays_survey_enable_randomize_answers" name="ays_survey_enable_randomize_answers" value="on" <?php echo ($survey_enable_randomize_answers) ? 'checked' : ''; ?>/>
        </div>
    </div> <!-- Enable randomize answers -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-4">
            <label for="ays_survey_enable_randomize_questions">
               <?php echo __('Enable randomize questions',$this->plugin_name)?>
               <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-8">
            <input type="checkbox" class="ays-enable-timerl" id="ays_survey_enable_randomize_questions" name="ays_survey_enable_randomize_questions" value="on" <?php echo ($survey_enable_randomize_questions) ? 'checked' : ''; ?>/>
        </div>
    </div> <!-- Enable randomize questions -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-4">
            <label for="ays_survey_enable_clear_answer">
                <?php echo __('Enable clear answer button',$this->plugin_name)?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-8">
            <input type="checkbox" class="ays-enable-timer1" id="ays_survey_enable_clear_answer" name="ays_survey_enable_clear_answer" value="on" <?php echo ($survey_enable_clear_answer) ? 'checked' : '' ?>/>
        </div>
    </div> <!-- Enable clear answer button -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-4">
            <label for="ays_survey_enable_leave_page">
                <?php echo __('Enable confirmation box for leaving the page',$this->plugin_name)?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-8">
            <input type="checkbox" class="ays-enable-timer1" id="ays_survey_enable_leave_page" name="ays_survey_enable_leave_page" value="on" <?php echo ($survey_enable_leave_page) ? 'checked' : ''; ?>/>
        </div>
    </div> <!-- Enable confirmation box for leaving the page -->
    <!-- <hr/> -->
</div>
