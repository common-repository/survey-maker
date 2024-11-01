<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Survey_Maker
 * @subpackage Survey_Maker/admin/partials
 */

$survey_page_url = sprintf('?page=%s', 'survey-maker');
$add_new_url = sprintf('?page=%s&action=%s', 'survey-maker', 'add');

?>
<div class="wrap">
    <!-- <div class="ays-survey-maker-wrapper" style="position:relative;">
        <h1 class="ays_heart_beat"><?php echo __(esc_html(get_admin_page_title()),$this->plugin_name); ?> <i class="ays_fa ays_fa_heart_o animated"></i></h1>
    </div> -->
    <h1 class="ays-survey-maker-wrapper ays_heart_beat">
        <?php echo __(esc_html(get_admin_page_title()),$this->plugin_name); ?> <i class="ays_fa ays_fa_heart_o animated"></i>
    </h1>
    <div class="ays-survey-faq-main">
        <h2>
            <?php echo __("How to create a simple survey in 3 steps with the help of the", $this->plugin_name ) .
            ' <strong>'. __("Survey Maker", $this->plugin_name ) .'</strong> '.
            __("plugin.", $this->plugin_name ); ?>
            
        </h2>
        <fieldset>
            <div class="ays-survey-ol-container">
                <ol>
                    <li>
                        <?php echo __( "Go to the", $this->plugin_name ) . ' <a href="'. $survey_page_url .'" target="_blank">'. __( "Surveys" , $this->plugin_name ) .'</a> ' .  __( "page and build your first survey by clicking on the", $this->plugin_name ) . ' <a href="'. $add_new_url .'" target="_blank">'. __( "Add New" , $this->plugin_name ) .'</a> ' .  __( "button", $this->plugin_name ); ?>,
                    </li>
                    <li>
                        <?php echo __( "Fill out the information by adding a title, creating questions and so on.", $this->plugin_name ); ?>
                    </li>
                    <li>
                        <?php echo __( "Copy the", $this->plugin_name ) . ' <strong>'. __( "shortcode" , $this->plugin_name ) .'</strong> ' .  __( "of the survey and paste it into any post․", $this->plugin_name ); ?> 
                    </li>
                </ol>
            </div>
            <div class="ays-survey-p-container">
                <p><?php echo __("Congrats! You have already created your first survey." , $this->plugin_name); ?></p>
            </div>
        </fieldset>
        <br>
        <p class="ays-survey-faq-footer">
            <?php echo __( "For more advanced needs, please take a look at our" , $this->plugin_name ); ?> 
            <a href="https://ays-pro.com/wordpress-survey-maker-user-manual" target="_blank"><?php echo __( "Survey Maker plugin User Manual." , $this->plugin_name ); ?></a>
            <br>
            <?php echo __( "If none of these guides help you, ask your question by contacting our" , $this->plugin_name ); ?>
            <a href="https://ays-pro.com/contact" target="_blank"><?php echo __( "support specialists." , $this->plugin_name ); ?></a> 
            <?php echo __( "and get a reply within a day." , $this->plugin_name ); ?>
        </p>
    </div>
</div>
<script>
    // var acc = document.getElementsByClassName("ays-survey-asked-question__header");
    // var i;

    // for (i = 0; i < acc.length; i++) {
    //   acc[i].addEventListener("click", function() {
        
    //     var panel = this.nextElementSibling;
        
        
    //     if (panel.style.maxHeight) {
    //       panel.style.maxHeight = null;
    //       this.children[1].children[0].style.transform="rotate(0deg)";
    //     } else {
    //       panel.style.maxHeight = panel.scrollHeight + "px";
    //       this.children[1].children[0].style.transform="rotate(180deg)";
    //     } 
    //   });
    // }
</script>