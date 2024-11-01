<?php
global $wpdb;
$survey_id = isset($_GET['survey']) ? intval($_GET['survey']) : null;
if($survey_id === null){
    wp_redirect( admin_url('admin.php') . '?page=' . $this->plugin_name . '-submissions' );
}

$sql = "SELECT * FROM " . $wpdb->prefix . SURVEY_MAKER_DB_PREFIX . "surveys WHERE id =" . $survey_id;
$survey_name = $wpdb->get_row( $sql, 'ARRAY_A' );

$get_count_per_day = $this->each_submission_obj->get_submision_line_chart($survey_id);
$get_users_count = $this->each_submission_obj->survey_users_count();

// For charts in summary
$survey_question_results = $this->ays_survey_question_results( $survey_id );
$question_results = $survey_question_results['questions'];
$total_count = $survey_question_results['total_count'];

$last_submission = $this->ays_survey_get_last_submission_id( $survey_id );

$ays_survey_individual_questions = $this->ays_survey_individual_results_for_one_submission( $last_submission, $survey_name );


$text_types = array(
    'text',
    'short_text',
    'number',
    'name',
    'email',
);

$submission_count_and_ids = $this->get_submission_count_and_ids();

wp_localize_script( $this->plugin_name, 'SurveyChartData', array( 
    'countPerDayData' => $get_count_per_day,
    'usersCount' => $get_users_count,
    // 'perAnswerCount' => $question_results,
    // 'submission_count' => $submission_count
    'perAnswerCount' => $question_results
) );

?>

<div class="wrap ays_each_results_table">
    <h1 class="wp-heading-inline" style="padding-left:15px;">
        <?php
        echo sprintf( '<a href="?page=%s" class="go_back"><span><i class="fa fa-long-arrow-left" aria-hidden="true"></i> %s</span></a>', $this->plugin_name."-submissions", __("Back to Submissions", $this->plugin_name) );
        ?>
    </h1>
    <div style="display: flex; justify-content: space-between;">
        <h1 class="wp-heading-inline" style="padding-left:15px;">
            <?php
            echo __("submissions for", $this->plugin_name) . " \"" . __(esc_html($survey_name['title']), $this->plugin_name) . "\"";
            ?>
        </h1>
    </div>
    <div class="nav-tab-wrapper">
        <a href="#statistics_of_answer" class="nav-tab nav-tab-active"><?php echo __("Summary", $this->plugin_name); ?></a>
        <a href="#questions" class="nav-tab "><?php echo __("Questions", $this->plugin_name); ?></a>
        <a href="#poststuff" class="nav-tab " ><?php echo __("Submissions", $this->plugin_name); ?></a>
    </div>
    <div id="poststuff" class="ays-survey-tab-content ">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <?php
                        $this->each_submission_obj->views();
                    ?>
                    <form method="post">
                      <?php
                        $this->each_submission_obj->prepare_items();
                        $this->each_submission_obj->search_box('Search', $this->plugin_name);
                        $this->each_submission_obj->display();
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>

    <div id="questions" class="ays-survey-tab-content">
        <div class="wrap">
            <div class="ays_survey_container_each_result">
                <div class="ays_survey_response_count">
                    <p><?php echo __('Responses cannot be edited',$this->plugin_name); ?></p>
                    <h1><?php 
                        echo $submission_count_and_ids['submission_count'];
                        echo __(" Responses",$this->plugin_name);
                    ?></h1>
                    <div class="ays_survey_previous_next_conteiner">
                        <div class="ays_survey_previous_next ays_survey_previous" data-name="ays_survey_previous">
                            <i class="ays_fa fa-angle-left"></i>
                        </div>
                        <div class="ays_submissions_input_box">
                            <input type="number" class="ays_number_of_result ays_survey_previous_next" value="1" min="1" max="<?php echo $submission_count_and_ids['submission_count']; ?>" data-id="<?php echo $survey_id; ?>">
                            <input type="hidden" class="ays_submissions_id_str" value="<?php echo $submission_count_and_ids['submission_ids']; ?>">
                            <span>of <?php echo $submission_count_and_ids['submission_count']; ?></span>
                        </div>
                        <div class="ays_survey_previous_next ays_survey_next" data-name="ays_survey_next">
                            <i class="ays_fa fa-angle-right"></i>
                        </div>
                    </div>
                </div>
                <div class="question_result_container">
                    <div class="ays_question_answer" style="position:relative;">
                        <div class="ays-survey-sections">
                        <?php
                            $checked = '';
                            $disabled = '';
                            $selected = '';
                            $color = '';
                            foreach ($ays_survey_individual_questions['sections'] as $section_key => $section) {
                                ?>
                            <div class="ays-survey-section">
                                <div class="ays_survey_name">
                                    <h3><?php echo $section['title']; ?></h3>
                                    <p><?php echo $section['description']; ?></p>
                                </div>
                                <?php
                                foreach ( $section['questions'] as $q_key => $question ) {
                                    ?>
                                    <div class="ays_questions_answers" data-id="<?php echo $question['id']; ?>"  data-type="<?php echo $question['type']; ?>">
                                    <h1><?php echo $question['question']; ?></h1>
                                    <?php
                                    $question_type_content = '';
                                    $user_answer = isset( $ays_survey_individual_questions['questions'][ $question['id'] ] ) ? $ays_survey_individual_questions['questions'][ $question['id'] ] : '';
                                    $question_type_content = '';
                                    if( $question['type'] == 'select' ){
                                        $question_type_content .= '<select class="ays-survey-submission-select" disabled>';
                                    }

                                    if( in_array( $question['type'], $text_types ) ){
                                        $question_type_content .= '<div class="ays_each_question_answer">
                                            <p class="ays_text_answers">' . $user_answer . '</p>
                                        </div>';
                                    }

                                    foreach ($question['answers'] as $key => $answer) {
                                        $checked = '';
                                        $selected = '';
                                        $disabled = 'disabled';
                                        $color = '#777';
                                        // $color = 'black';
                                        switch( $question['type'] ){
                                            case 'radio':
                                                if( intval( $user_answer ) == intval( $answer['id'] ) ){
                                                    $checked = 'checked';
                                                }
                                                $question_type_content .= '<div class="ays_each_question_answer">
                                                    <label style="color:' . $color . '">
                                                        <input type="radio" ' . $checked . ' ' . $disabled . ' data-id="' . $answer['id'] . '"/>
                                                        <span style="font-size: 17px;">' . $answer['answer'] . '</span> 
                                                    </label>
                                                </div>';
                                                break;
                                            case 'checkbox':
                                                if( is_array( $user_answer ) ){
                                                    if( in_array( $answer['id'], $user_answer ) ){
                                                        $checked = 'checked';
                                                    }
                                                }
                                                $question_type_content .= '<div class="ays_each_question_answer">
                                                    <label style="color:' . $color . '">
                                                        <input type="checkbox" ' . $checked . ' ' . $disabled . ' data-id="' . $answer['id'] . '"/>
                                                        <span style="font-size: 17px;">' . $answer['answer'] . '</span> 
                                                    </label>
                                                    </div>';
                                                break;
                                            case 'select':
                                                if( intval( $user_answer ) == intval( $answer['id'] ) ){
                                                    $selected = 'selected';
                                                }
                                                $question_type_content .= '<option value=' . $answer['id'] . ' ' . $selected . '>' . $answer['answer'] . '</option>';
                                            break;
                                        }
                                    }
                                    if( $question['type'] == 'select' && $key == count( $question['answers'] ) - 1 ){
                                        $question_type_content .= '</select>';
                                    }
                                    echo $question_type_content;
                                    ?>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            }
                        ?>
                        </div>
                    </div>
                    <div class="ays_survey_preloader" style="display:none;">
                        <img src="<?php echo SURVEY_MAKER_ADMIN_URL ; ?>/images/loaders/tail-spin-result.svg" alt="" width="100">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="statistics_of_answer" class="ays-survey-tab-content ays-survey-tab-content-active">
        <div class="wrap">
            <div class="ays-survey-submission-summary-question-container" style="padding: 20px;">
                <h2 style="margin: 0;"><?php echo sprintf( __( 'In total %s submission', $this->plugin_name ), $submission_count_and_ids['submission_count'] ); ?></h2>
            </div>
            <?php
                foreach ($question_results as $key => $question_result){
                    ?>
                    <div class="ays-survey-submission-summary-question-container">
                        <div class="ays-survey-submission-summary-question-header">
                            <div class="ays-survey-submission-summary-question-header-content">
                                <h1 style="text-align:center;"><?php echo $question_result['question']; ?></h1>
                                <p style="text-align:center;"><?php echo $question_result['sum_of_answers_count'];echo __(' submissions',$this->plugin_name); ?></p>
                            </div>
                        </div>
                        <div class="ays-survey-submission-summary-question-content">
                            <?php
                                if( in_array( $question_result['question_type'], $text_types ) ):
                            ?>
                            <div class="ays-survey-submission-text-answers-div">
                                <?php
                                    foreach( $question_result['answers'] as $aid => $answer ):
                                ?>
                                <div class="ays-survey-submission-text-answer"><?php echo $answer; ?></div>
                                <?php
                                    endforeach;
                                ?>
                            </div>
                            <?php
                                else:
                            ?>
                            <div id="survey_answer_chart_<?php echo $question_result['question_id']; ?>" class="chart_div"></div>
                            <?php
                                endif;
                            ?>
                        </div>
                    </div>
                <?php
                }
            ?> 
        </div>
    </div>

    <div id="ays-results-modal" class="ays-modal">
        <div class="ays-modal-content">
            <div class="ays-preloader">
                <img class="loader" src="<?php echo SURVEY_MAKER_ADMIN_URL; ?>/images/loaders/3-1.svg">
            </div>
            <div class="ays-modal-header">
                <span class="ays-close" id="ays-close-results">&times;</span>
                <h2><?php echo __("Detailed report", $this->plugin_name); ?></h2>
            </div>
            <div class="ays-modal-body" id="ays-results-body">
            </div>
        </div>
    </div>

    <div class="ays-modal" id="export-answers-filters">
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
                <form method="post" id="ays_export_answers_filter">
                    <div class="filter-col">
                        <label for="user_id-answers-filter"><?=__("Users", $this->plugin_name)?></label>
                        <button type="button" class="ays_userid_clear button button-small wp-picker-default"><?=__("Clear", $this->plugin_name)?></button>
                        <select name="user_id-select[]" id="user_id-answers-filter" multiple="multiple"></select>
                        <input type="hidden" name="quiz_id-answers-filter" id="quiz_id-answers-filter" value="<?php echo $survey_id; ?>">
                    </div>
                    <div class="filter-block">
                        <div class="filter-block filter-col">
                            <label for="start-date-answers-filter"><?=__("Start Date from", $this->plugin_name)?></label>
                            <input type="date" name="start-date-filter" id="start-date-answers-filter">
                        </div>
                        <div class="filter-block filter-col">
                            <label for="end-date-answers-filter"><?=__("Start Date to", $this->plugin_name)?></label>
                            <input type="date" name="end-date-filter" id="end-date-answers-filter">
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
                <button type="button" class="button button-primary export-anwers-action" data-type="xlsx" quiz-id="<?php echo $survey_id; ?>"><?=__('XLSX', $this->plugin_name)?></button>
                <a download="" id="downloadFile" hidden href=""></a>
            </div>

        </div>
    </div>

</div>

