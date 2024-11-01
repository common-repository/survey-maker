<?php
    require_once( SURVEY_MAKER_ADMIN_PATH . "/partials/surveys/actions/survey-maker-survey-categories-actions-options.php" );
?>
<div class="wrap">
    <div class="container-fluid">
        <form class="ays-survey-category-form" id="ays-survey-category-form" method="post">
            <h1><?php echo $heading; ?></h1>
            <hr/>
            
            <?php
                for($tab_ind = 1; $tab_ind <= 1; $tab_ind++){
                    require_once( SURVEY_MAKER_ADMIN_PATH . "/partials/surveys/actions/partials/survey-maker-survey-categories-actions-tab".$tab_ind.".php" );
                }
            ?>
            
            <input type="hidden" name="<?php echo $html_name_prefix; ?>date_created" value="<?php echo $date_created; ?>">
            <input type="hidden" name="<?php echo $html_name_prefix; ?>date_modified" value="<?php echo $date_modified; ?>">
            <hr/>
            <?php
                wp_nonce_field('survey_category_action', 'survey_category_action');
                $other_attributes = array('id' => 'ays-button-save');
                submit_button(__('Save and close', $this->plugin_name), 'primary ays-button', 'ays_submit', false, $other_attributes);
                $other_attributes = array('id' => 'ays-button-save-new');
                submit_button(__('Save and new', $this->plugin_name), 'primary ays-button', 'ays_save_new', false, $other_attributes);
                $other_attributes = array('id' => 'ays-button-apply');
                submit_button(__('Save', $this->plugin_name), 'ays-button', 'ays_apply', false, $other_attributes);
            ?>
        </form>
    </div>
</div>
