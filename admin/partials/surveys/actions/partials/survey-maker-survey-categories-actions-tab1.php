<div id="tab1" class="ays-survey-tab-content ays-survey-tab-content-active">
    <div class="form-group row">
        <div class="col-sm-2">
            <label for='ays-title'>
                <?php echo __('Title', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Title of the survey category',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-10">
            <input type="text" class="ays-text-input" id='ays-title' name='<?php echo $html_name_prefix; ?>title'
                   value="<?php echo $title; ?>" required />
        </div>
    </div> <!-- Title -->
    <hr/>
    <div class='ays-field-dashboard'>
        <label for='ays-description'>
            <?php echo __('Description', $this->plugin_name); ?>
            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Provide more information about the survey category',$this->plugin_name)?>">
                <i class="ays_fa ays_fa_info_circle"></i>
            </a>
        </label>
        <?php
            $content = $description;
            $editor_id = 'ays-description';
            $settings = array( 
                'editor_height' => '4',
                'textarea_name' => $html_name_prefix . 'description',
                'editor_class' => 'ays-textarea'
            );
            wp_editor( $content, $editor_id, $settings );
        ?>
    </div> <!-- Description -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-2">
            <label for="ays-status">
                <?php echo __('Category status', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Choose whether the quiz is active or not.If you choose Unpublished option, the quiz won’t be shown anywhere in your website (You don’t need to remove shortcodes).',$this->plugin_name)?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-10">
            <select id="ays-status" name="<?php echo $html_name_prefix; ?>status">
                <option></option>
                <option <?php selected( $status, 'published' ); ?> value="published"><?php echo __( "Published", $this->plugin_name ); ?></option>
                <option <?php selected( $status, 'draft' ); ?> value="draft"><?php echo __( "Draft", $this->plugin_name ); ?></option>
            </select>
        </div>
    </div> <!-- Status -->
</div>
