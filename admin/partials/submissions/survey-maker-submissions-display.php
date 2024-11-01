<?php

?>
<div class="wrap ays_results_table">
    <h1 class="wp-heading-inline">
        <?php
        echo __(esc_html(get_admin_page_title()),$this->plugin_name);
        ?>
    </h1>
    <!-- <div class="question-action-butons">
        <a href="javascript:void(0)" class="ays-export-filters ays_export_results page-title-action" style="float: right;"><?php echo __('Export', $this->plugin_name); ?></a>
    </div> -->
    <div class="nav-tab-wrapper">
        <a href="#tab1" class="nav-tab nav-tab-active"><?php echo __('Surveys',$this->plugin_name)?></a>
        <!-- <a href="#tab2" class="nav-tab"><?php echo __('Global Statistics',$this->plugin_name)?></a> -->
        <!-- <a href="#tab3" class="nav-tab"><?php echo __('Global Leaderboard',$this->plugin_name)?></a> -->
    </div>

    <div id="tab1" class="ays-survey-tab-content ays-survey-tab-content-active">
        <div id="poststuff">
            <div id="post-body" class="metabox-holder">
                <div id="post-body-content">
                    <div class="meta-box-sortables ui-sortable">
                        <form method="post">
                            <?php
                                $this->submissions_obj->prepare_items();
                                $this->submissions_obj->display();
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tab2" class="ays-survey-tab-content">

    </div>

    <div id="tab3" class="ays-survey-tab-content">
        
    </div>

    <div class="ays-modal" id="export-filters">
        <div class="ays-modal-content">
            <div class="ays-preloader">
                <img class="loader" src="<?php echo SURVEY_MAKER_ADMIN_URL; ?>/images/loaders/3-1.svg">
            </div>
          <!-- Modal Header -->
            <div class="ays-modal-header">
                <span class="ays-close">&times;</span>
                <h2><?=__('Export Filter', $this->plugin_name)?></h2>
            </div>

          <!-- Modal body -->
            <div class="ays-modal-body">
                <form method="post" id="ays_export_filter">
                    <div class="filter-col">
                        <label for="user_id-filter"><?=__("Users", $this->plugin_name)?></label>
                        <button type="button" class="ays_userid_clear button button-small wp-picker-default"><?=__("Clear", $this->plugin_name)?></button>
                        <select name="user_id-select[]" id="user_id-filter" multiple="multiple"></select>
                    </div>
                    <hr>
                    <div class="filter-col">
                        <label for="quiz_id-filter"><?=__("Quizzes", $this->plugin_name)?></label>
                        <button type="button" class="ays_quizid_clear button button-small wp-picker-default"><?=__("Clear", $this->plugin_name)?></button>
                        <select name="quiz_id-select[]" id="quiz_id-filter" multiple="multiple"></select>
                    </div>
                    <div class="filter-block">
                        <div class="filter-block filter-col">
                            <label for="start-date-filter"><?=__("Start Date from", $this->plugin_name)?></label>
                            <input type="date" name="start-date-filter" id="start-date-filter">
                        </div>
                        <div class="filter-block filter-col">
                            <label for="end-date-filter"><?=__("Start Date to", $this->plugin_name)?></label>
                            <input type="date" name="end-date-filter" id="end-date-filter">
                        </div>
                    </div>
                </form>
            </div>

          <!-- Modal footer -->
            <div class="ays-modal-footer">
                <div class="export_results_count">
                    <p>Matched <span></span> results</p>
                </div>
                <span><?php echo __('Export to', $this->plugin_name); ?></span>
                <button type="button" class="button button-primary export-action" data-type="csv"><?=__('CSV', $this->plugin_name)?></button>
                <button type="button" class="button button-primary export-action" data-type="xlsx"><?=__('XLSX', $this->plugin_name)?></button>
                <button type="button" class="button button-primary export-action" data-type="json"><?=__('JSON', $this->plugin_name)?></button>
                <a download="" id="downloadFile" hidden href=""></a>
            </div>

        </div>
    </div>
</div>

