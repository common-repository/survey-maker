<div id="tab1" class="m2 ays-survey-tab-content <?php echo ($ays_tab == 'tab1') ? 'ays-survey-tab-content-active' : ''; ?>">
    <p class="ays-subtitle"><?php echo __('General Settings',$this->plugin_name)?></p>
    <hr/>
    <div class="form-group row">
        <div class="col-sm-11">
            <div class="ays-survey-sections-conteiner">
            <?php
            if(empty($sections_ids)){
                ?>
                <div class="ays-survey-section-box ays-survey-new-section" data-name="<?php echo $html_name_prefix; ?>section_add" data-id="1">
                    <div class="ays-survey-section-head-wrap">
                        <div class="ays-survey-section-head-top display_none">
                            <div class="ays-survey-section-counter">
                                <span>
                                    <span><?php echo __( 'Section', $this->plugin_name ); ?></span>
                                    <span class="ays-survey-section-number">1</span>
                                    <span><?php echo __( 'of', $this->plugin_name ); ?></span>
                                    <span class="ays-survey-sections-count">1</span>
                                </span>
                            </div>
                        </div>
                        <div class="ays-survey-section-head">
                            <!--  Section Title Start  -->
                            <div class="ays-survey-section-title-conteiner">
                                <input type="text" class="ays-survey-section-title ays-survey-input" tabindex="0" name="<?php echo $html_name_prefix; ?>section_add[1][title]" placeholder="<?php echo __( 'Form title' , $this->plugin_name ); ?>" value=""/>
                                <div class="ays-survey-input-underline"></div>
                                <div class="ays-survey-input-underline-animation"></div>
                            </div>
                            <!--  Section Title End  -->

                            <!--  Section Description Start  -->
                            <div class="ays-survey-section-description-conteiner">
                                <input type="text" class="ays-survey-section-description ays-survey-input" name="<?php echo $html_name_prefix; ?>section_add[1][description]" placeholder="<?php echo __( 'Form Description' , $this->plugin_name ); ?>" value=""/>
                                <div class="ays-survey-input-underline"></div>
                                <div class="ays-survey-input-underline-animation"></div>
                            </div>
                            <!--  Section Description End  -->

                            <div class="ays-survey-answer-icon-box dropdown ays-survey-section-actions invisible">
                                <div class="ays-survey-action-more appsMaterialWizButtonPapericonbuttonEl" data-toggle="dropdown">
                                    <div class="ays-question-img-icon-content">
                                        <div class="ays-question-img-icon-content-div">
                                            <div class="ays-survey-icons">
                                                <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-more-vertical-m2" aria-hidden="true">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button type="button" class="dropdown-item ays-survey-delete-section"><?php echo __( 'Delete section', $this->plugin_name ); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ays-survey-section-body">
                        <div class="ays-survey-section-questions">
                            <div class="ays-survey-question-answer-conteiner" data-name="questions_add" data-id="1">
                                <div class="ays-survey-question-conteiner">
                                    <div class="ays-survey-question-dlg-dragHandle">
                                        <div class="ays-survey-icons ays-survey-icons-hidden">
                                            <div class="aysMaterialIconIconImage aysMaterialIconIconDarkIcon ays-qp-icon-drag-handle-horz-b" aria-hidden="true">&nbsp;</div>
                                        </div>
                                    </div>
                                    <div class="ays-survey-question-row">
                                        <div class="ays-survey-question-box">
                                            <div class="ays-survey-question-input-box">
                                                <textarea class="ays-survey-remove-default-border ays-survey-question-input-textarea ays-survey-question-input ays-survey-input" 
                                                    name="<?php echo $html_name_prefix; ?>section_add[1][questions_add][1][title]" 
                                                    placeholder="<?php echo __( 'Question', $this->plugin_name ); ?>" style="height: 24px;"></textarea>
                                                <input type="hidden" name="<?php echo $html_name_prefix; ?>question_ids[]" value="">
                                                <div class="ays-survey-input-underline"></div>
                                                <div class="ays-survey-input-underline-animation"></div>
                                            </div>
                                        </div>
                                        <div class="ays-survey-question-img-icon-box">
                                            <div class="ays-survey-add-question-image appsMaterialWizButtonPapericonbuttonEl" data-type="questionImgButton" data-type="questionImgButton" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="<?php echo __('Add image',$this->plugin_name)?>">
                                                <div class="ays-question-img-icon-content">
                                                    <div class="ays-question-img-icon-content-div">
                                                        <div class="ays-survey-icons ays-survey-icons-hidden">
                                                            <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-survey-question-type-box">
                                            <select name="<?php echo $html_name_prefix; ?>section_add[1][questions_add][1][type]" tabindex="-1" class="ays-survey-question-type" aria-hidden="true">
                                                <?php 
                                                    foreach ($question_types as $type_slug => $type):
                                                        ?>
                                                        <option value="<?php echo $type_slug; ?>"><?php echo $type; ?></option>
                                                        <?php
                                                    endforeach;
                                                ?>
                                            </select>
                                            <input type="hidden" class="ays-survey-check-type-before-change" value="<?php echo 'radio'; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="ays-survey-question-image-container" style="display: none;" >
                                    <div class="ays-survey-question-image-body">
                                        <div class="ays-survey-question-image-wrapper aysFormeditorViewMediaImageWrapper">
                                            <div class="ays-survey-question-image-pos aysFormeditorViewMediaImagePos">
                                                <div class="d-flex">
                                                    <div class="dropdown mr-1">
                                                        <div class="ays-survey-question-edit-menu-button dropdown-menu-actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ays_fa ays_fa_ellipsis_v"></i>
                                                        </div>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item ays-survey-question-img-action" data-action="edit-image" href="javascript:void(0);"><?php echo __( 'Edit', $this->plugin_name ); ?></a>
                                                            <a class="dropdown-item ays-survey-question-img-action" data-action="delete-image" href="javascript:void(0);"><?php echo __( 'Delete', $this->plugin_name ); ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img class="ays-survey-question-img" src="" tabindex="0" aria-label="Captionless image" />
                                                <input type="hidden" class="ays-survey-question-img-src" name="<?php echo $html_name_prefix; ?>section_add[1][questions_add][1][image]" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ays-survey-answers-conteiner">
                                    <div class="ays-survey-answer-row" data-id="1">
                                        <div class="ays-survey-answer-wrap">
                                            <div class="ays-survey-answer-dlg-dragHandle">
                                                <div class="ays-survey-icons ays-survey-icons-hidden">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                        <circle cy="6.5" cx="9.5" r="1.5"></circle>
                                                        <circle cy="6.5" cx="14.5" r="1.5"></circle>
                                                        <circle cy="12.5" cx="9.5" r="1.5"></circle>
                                                        <circle cy="12.5" cx="14.5" r="1.5"></circle>
                                                        <circle cy="18.5" cx="9.5" r="1.5"></circle>
                                                        <circle cy="18.5" cx="14.5" r="1.5"></circle>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ays-survey-answer-icon-box ays-survey-answer-icon-just">
                                                <span class="ays-survey-answer-icon">
                                                    <i class="ays_fa ays_fa_circle_thin"></i>
                                                </span>
                                            </div>
                                            <div class="ays-survey-answer-box">
                                                <input type="text" class="ays-survey-input" name="<?php echo $html_name_prefix; ?>section_add[1][questions_add][1][answers_add][1][title]" placeholder="Option 1" value="Option 1">
                                                <div class="ays-survey-input-underline"></div>
                                                <div class="ays-survey-input-underline-animation"></div>
                                            </div>
                                            <div class="ays-survey-answer-icon-box">
                                                <div class="ays-survey-add-answer-image appsMaterialWizButtonPapericonbuttonEl" data-type="answerImgButton">
                                                    <div class="ays-question-img-icon-content">
                                                        <div class="ays-question-img-icon-content-div">
                                                            <div class="ays-survey-icons ays-survey-icons-hidden">
                                                                <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ays-survey-answer-icon-box">
                                                <span class="ays-survey-answer-icon ays-survey-answer-delete appsMaterialWizButtonPapericonbuttonEl" style="visibility: hidden;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                        <path fill="#5f6368" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                                        <path d="M0 0h24v24H0z" fill="none"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ays-survey-answer-image-container" style="display: none;">
                                            <div class="ays-survey-answer-image-body">
                                                <div class="ays-survey-answer-image-wrapper">
                                                    <div class="ays-survey-answer-image-wrapper-delete-wrap">
                                                        <div role="button" class="ays-survey-answer-image-wrapper-delete-cont removeAnswerImage">
                                                            <span class="exportIcon">
                                                                <div class="ays-survey-answer-image-wrapper-delete-icon-cont">
                                                                    <div class="aysMaterialIconIconImage ays-qp-icon-clear" aria-hidden="true">&nbsp;</div>
                                                                </div>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <img class="ays-survey-answer-img" src="" tabindex="0" aria-label="Captionless image" />
                                                    <input type="hidden" class="ays-survey-answer-img-src" name="<?php echo $html_name_prefix; ?>section_add[1][questions_add][1][answers_add][1][image]" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ays-survey-other-answer-and-actions-row">
                                    <div class="ays-survey-answer-row ays-survey-other-answer-row" style="display: none;">
                                        <div class="ays-survey-answer-wrap">
                                            <div class="ays-survey-answer-dlg-dragHandle">
                                                <div class="ays-survey-icons invisible">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                        <circle cy="6.5" cx="9.5" r="1.5"></circle>
                                                        <circle cy="6.5" cx="14.5" r="1.5"></circle>
                                                        <circle cy="12.5" cx="9.5" r="1.5"></circle>
                                                        <circle cy="12.5" cx="14.5" r="1.5"></circle>
                                                        <circle cy="18.5" cx="9.5" r="1.5"></circle>
                                                        <circle cy="18.5" cx="14.5" r="1.5"></circle>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ays-survey-answer-icon-box ays-survey-answer-icon-just">
                                                <span class="ays-survey-answer-icon">
                                                    <i class="ays_fa ays_fa_circle_thin"></i>
                                                </span>
                                            </div>
                                            <div class="ays-survey-answer-box">
                                                <input type="text" disabled class="ays-survey-input ays-survey-input-other-answer" placeholder="<?php echo __( 'Other...', $this->plugin_name ); ?>" value="<?php echo __( 'Other...', $this->plugin_name ); ?>">
                                                <div class="ays-survey-input-underline"></div>
                                                <div class="ays-survey-input-underline-animation"></div>
                                            </div>
                                            <div class="ays-survey-answer-icon-box">
                                                <div class="appsMaterialWizButtonPapericonbuttonEl invisible">
                                                    <div class="ays-question-img-icon-content">
                                                        <div class="ays-question-img-icon-content-div">
                                                            <div class="ays-survey-icons ays-survey-icons-hidden">
                                                                <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ays-survey-answer-icon-box">
                                                <span class="ays-survey-answer-icon ays-survey-other-answer-delete appsMaterialWizButtonPapericonbuttonEl">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                        <path fill="#5f6368" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                                        <path d="M0 0h24v24H0z" fill="none"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays-survey-answer-row">
                                        <div class="ays-survey-answer-wrap">
                                            <div class="ays-survey-answer-dlg-dragHandle">
                                                <div class="ays-survey-icons invisible">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                        <circle cy="6.5" cx="9.5" r="1.5"></circle>
                                                        <circle cy="6.5" cx="14.5" r="1.5"></circle>
                                                        <circle cy="12.5" cx="9.5" r="1.5"></circle>
                                                        <circle cy="12.5" cx="14.5" r="1.5"></circle>
                                                        <circle cy="18.5" cx="9.5" r="1.5"></circle>
                                                        <circle cy="18.5" cx="14.5" r="1.5"></circle>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ays-survey-answer-icon-box ays-survey-answer-icon-just">
                                                <span class="ays-survey-answer-icon">
                                                    <i class="ays_fa ays_fa_circle_thin"></i>
                                                </span>
                                            </div>
                                            <div class="ays-survey-answer-box d-flex">
                                                <div class="ays-survey-action-add-answer appsMaterialWizButtonPapericonbuttonEl">
                                                    <div class="ays-question-img-icon-content">
                                                        <div class="ays-question-img-icon-content-div">
                                                            <div class="ays-survey-icons">
                                                                <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-add-circle-outline" aria-hidden="true">&nbsp;</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ays-survey-other-answer-add-wrap">
                                                    <span class=""><?php echo __( 'or', $this->plugin_name ) ?></span>
                                                    <div class="ays-survey-other-answer-container ays-survey-other-answer-add">
                                                        <div class="ays-survey-other-answer-container-overlay"></div>
                                                        <span class="ays-survey-other-answer-content">
                                                            <span class="appsMaterialWizButtonPaperbuttonLabel quantumWizButtonPaperbuttonLabel"><?php echo __( 'add "Other"', $this->plugin_name ) ?></span>
                                                            <input type="checkbox" class="display_none ays-survey-other-answer-checkbox" value="on" name="<?php echo $html_name_prefix; ?>section_add[1][questions_add][1][user_variant]">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ays-survey-answer-icon-box">
                                                <div class="appsMaterialWizButtonPapericonbuttonEl invisible">
                                                    <div class="ays-question-img-icon-content">
                                                        <div class="ays-question-img-icon-content-div">
                                                            <div class="ays-survey-icons ays-survey-icons-hidden">
                                                                <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ays-survey-answer-icon-box invisible">
                                                <span class="ays-survey-answer-icon appsMaterialWizButtonPapericonbuttonEl">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                        <path fill="#5f6368" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                                        <path d="M0 0h24v24H0z" fill="none"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ays-survey-row-divider"><div></div></div>
                                <div class="ays-survey-actions-row">
                                    <div></div>
                                    <div class="ays-survey-actions">
                                        <div class="ays-survey-answer-icon-box">
                                            <div class="ays-survey-action-duplicate-question appsMaterialWizButtonPapericonbuttonEl" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="<?php echo __('Duplicate',$this->plugin_name)?>">
                                                <div class="ays-question-img-icon-content">
                                                    <div class="ays-question-img-icon-content-div">
                                                        <div class="ays-survey-icons">
                                                            <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-content-copy" aria-hidden="true">&nbsp;</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-survey-answer-icon-box">
                                            <div class="ays-survey-action-delete-question appsMaterialWizButtonPapericonbuttonEl" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="<?php echo __('Delete',$this->plugin_name)?>">
                                                <div class="ays-question-img-icon-content">
                                                    <div class="ays-question-img-icon-content-div">
                                                        <div class="ays-survey-icons">
                                                            <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-delete" aria-hidden="true">&nbsp;</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-survey-vertical-divider"><div></div></div>
                                        <div class="ays-survey-answer-elem-box">
                                            <label>
                                                <span>
                                                    <span><?php echo __( 'Required', $this->plugin_name ); ?></span>
                                                </span>
                                                <input type="checkbox" class="display_none ays-survey-input-required-question ays-switch-checkbox" name="<?php echo $html_name_prefix; ?>section_add[1][questions_add][1][options][required]" value="on">
                                                <div class="switch-checkbox-wrap" aria-label="Required" tabindex="0" role="checkbox">
                                                    <div class="switch-checkbox-track"></div>
                                                    <div class="switch-checkbox-ink"></div>
                                                    <div class="switch-checkbox-circles">
                                                        <div class="switch-checkbox-thumb"></div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="ays-survey-answer-icon-box">
                                            <div class="ays-survey-action-more appsMaterialWizButtonPapericonbuttonEl">
                                                <div class="ays-question-img-icon-content">
                                                    <div class="ays-question-img-icon-content-div">
                                                        <div class="ays-survey-icons">
                                                            <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-more-vertical-m2" aria-hidden="true">&nbsp;</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
            } else{
                foreach ($sections as $key => $section):
                    ?>
                    <!-- Sections start -->
                    <div class="ays-survey-section-box" data-name="<?php echo $html_name_prefix; ?>sections" data-id="<?php echo $section['id']; ?>">
                        <input type="hidden" name="<?php echo $html_name_prefix; ?>sections_ids[]" value="<?php echo $section['id']; ?>">
                        <div class="ays-survey-section-head-wrap">
                            <div class="ays-survey-section-head-top <?php echo $multiple_sections ? '' : 'display_none'; ?>">
                                <div class="ays-survey-section-counter">
                                    <span>
                                        <span><?php echo __( 'Section', $this->plugin_name ); ?></span>
                                        <span class="ays-survey-section-number"><?php echo $key+1; ?></span>
                                        <span><?php echo __( 'of', $this->plugin_name ); ?></span>
                                        <span class="ays-survey-sections-count"><?php echo count($sections); ?></span>
                                    </span>
                                </div>
                            </div>
                            <div class="ays-survey-section-head <?php echo count($sections) > 1 ? 'ays-survey-section-head-topleft-border-none' : ''; ?>">
                                <!--  Section Title Start  -->
                                <div class="ays-survey-section-title-conteiner">
                                    <input type="text" class="ays-survey-section-title ays-survey-input" tabindex="0" name="<?php echo $html_name_prefix; ?>sections[<?php echo $section['id']; ?>][title]" placeholder="<?php echo __( 'Section title' , $this->plugin_name ); ?>" value="<?php echo $section['title']; ?>"/>
                                    <div class="ays-survey-input-underline"></div>
                                    <div class="ays-survey-input-underline-animation"></div>
                                </div>
                                <!--  Section Title End  -->

                                <!--  Section Description Start  -->
                                <div class="ays-survey-section-description-conteiner">
                                    <input type="text" class="ays-survey-section-description ays-survey-input" name="<?php echo $html_name_prefix; ?>sections[<?php echo $section['id']; ?>][description]" placeholder="<?php echo __( 'Section Description' , $this->plugin_name ); ?>" value="<?php echo $section['description']; ?>"/>
                                    <div class="ays-survey-input-underline"></div>
                                    <div class="ays-survey-input-underline-animation"></div>
                                </div>

                                <div class="ays-survey-answer-icon-box dropdown ays-survey-section-actions <?php echo $multiple_sections ? '' : 'invisible'; ?>">
                                    <div class="ays-survey-action-more appsMaterialWizButtonPapericonbuttonEl" data-toggle="dropdown">
                                        <div class="ays-question-img-icon-content">
                                            <div class="ays-question-img-icon-content-div">
                                                <div class="ays-survey-icons">
                                                    <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-more-vertical-m2" aria-hidden="true">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" class="dropdown-item ays-survey-delete-section"><?php echo __( 'Delete section', $this->plugin_name ); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ays-survey-section-body">
                            <div class="ays-survey-section-questions">
                                <!-- Questons start -->
                                <?php
                                foreach ($section['questions'] as $k => $question):
                                    ?>
                                    <div class="ays-survey-question-answer-conteiner" data-name="questions" data-id="<?php echo $question['id']; ?>">
                                        <div class="ays-survey-question-conteiner">
                                            <div class="ays-survey-question-dlg-dragHandle">
                                                <div class="ays-survey-icons ays-survey-icons-hidden">
                                                    <div class="aysMaterialIconIconImage aysMaterialIconIconDarkIcon ays-qp-icon-drag-handle-horz-b" aria-hidden="true">&nbsp;</div>
                                                </div>
                                            </div>
                                            <div class="ays-survey-question-row">
                                                <div class="ays-survey-question-box">
                                                    <div class="ays-survey-question-input-box">
                                                        <textarea type="text" class="ays-survey-remove-default-border ays-survey-question-input-textarea ays-survey-question-input ays-survey-input" name="<?php echo $html_name_prefix; ?>sections[<?php echo $section['id']; ?>][questions][<?php echo $question['id']; ?>][title]" placeholder="<?php echo __( 'Question', $this->plugin_name ); ?>"style="height: 24px;"><?php echo $question['question']; ?></textarea>
                                                        <input type="hidden" name="<?php echo $html_name_prefix; ?>question_ids[]" value="<?php echo $question['id']; ?>">
                                                        <div class="ays-survey-input-underline"></div>
                                                        <div class="ays-survey-input-underline-animation"></div>
                                                    </div>
                                                </div>
                                                <div class="ays-survey-question-img-icon-box">
                                                    <div class="ays-survey-add-question-image appsMaterialWizButtonPapericonbuttonEl" data-type="questionImgButton" data-type="questionImgButton" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="<?php echo __('Add image',$this->plugin_name)?>">
                                                        <div class="ays-question-img-icon-content">
                                                            <div class="ays-question-img-icon-content-div">
                                                                <div class="ays-survey-icons ays-survey-icons-hidden">
                                                                    <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ays-survey-question-type-box">
                                                    <select name="<?php echo $html_name_prefix; ?>sections[<?php echo $section['id']; ?>][questions][<?php echo $question['id']; ?>][type]" tabindex="-1" class="ays-survey-question-type" aria-hidden="true">
                                                        <?php 
                                                            foreach ($question_types as $type_slug => $type):
                                                                $selected = '';
                                                                if( $type_slug == $question['type'] ){
                                                                    $selected = ' selected ';
                                                                }
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?php echo $type_slug; ?>"><?php echo $type; ?></option>
                                                                <?php
                                                            endforeach;
                                                        ?>
                                                    </select>
                                                    <input type="hidden" class="ays-survey-check-type-before-change" value="<?php echo $question['type']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-survey-question-image-container" <?php echo $question['image'] == '' ? 'style="display: none;"' : ''; ?> >
                                            <div class="ays-survey-question-image-body">
                                                <div class="ays-survey-question-image-wrapper aysFormeditorViewMediaImageWrapper">
                                                    <div class="ays-survey-question-image-pos aysFormeditorViewMediaImagePos">
                                                        <div class="d-flex">
                                                            <div class="dropdown mr-1">
                                                                <div class="ays-survey-question-edit-menu-button dropdown-menu-actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="ays_fa ays_fa_ellipsis_v"></i>
                                                                </div>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item ays-survey-question-img-action" data-action="edit-image" href="javascript:void(0);"><?php echo __( 'Edit', $this->plugin_name ); ?></a>
                                                                    <a class="dropdown-item ays-survey-question-img-action" data-action="delete-image" href="javascript:void(0);"><?php echo __( 'Delete', $this->plugin_name ); ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <img class="ays-survey-question-img" src="<?php echo $question['image']; ?>" tabindex="0" aria-label="Captionless image" />
                                                        <input type="hidden" class="ays-survey-question-img-src" name="<?php echo $html_name_prefix; ?>sections[<?php echo $section['id']; ?>][questions][<?php echo $question['id']; ?>][image]" value="<?php echo $question['image']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ays-survey-answers-conteiner">
                                        <?php
                                            $selected_question_type = $question['type'];
                                            $question_type_Radio_Checkbox_Select = false;
                                            $question_type_Text_ShortText_Number = false;
                                            // if ($selected_question_type == 'radio' || $selected_question_type == 'select' || $selected_question_type == 'checkbox' ) {
                                            //     $question_type_Radio_Checkbox_Select = true;
                                            // }
                                            
                                            if ( in_array( $selected_question_type, $text_question_types ) ){// == 'text' || $selected_question_type == 'short_text' || $selected_question_type == 'number' ) {
                                                $question_type_Text_ShortText_Number = true;
                                            }else{
                                                $question_type_Radio_Checkbox_Select = true;
                                            }

                                            if ($question_type_Radio_Checkbox_Select):

                                                $selected_anser_i_class = '';
                                                switch ($selected_question_type) {
                                                    case 'radio':
                                                        $selected_anser_i_class = 'ays_fa_circle_thin';
                                                        break;
                                                    case 'select':
                                                        $selected_anser_i_class = 'ays_fa_circle_thin';
                                                        break;
                                                    case 'checkbox':
                                                        $selected_anser_i_class = 'ays_fa_square_o';
                                                        break;    
                                                    default:
                                                        $selected_anser_i_class = 'ays_fa_circle_thin';
                                                        break;
                                                }
                                        
                                            foreach ($question['answers'] as $answer_key => $answer):
                                            ?>
                                            <!-- Answers start -->
                                            <div class="ays-survey-answer-row" data-id="<?php echo $answer['id']; ?>">
                                                <div class="ays-survey-answer-wrap">
                                                    <div class="ays-survey-answer-dlg-dragHandle">
                                                        <div class="ays-survey-icons ays-survey-icons-hidden">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <circle cy="6.5" cx="9.5" r="1.5"></circle>
                                                                <circle cy="6.5" cx="14.5" r="1.5"></circle>
                                                                <circle cy="12.5" cx="9.5" r="1.5"></circle>
                                                                <circle cy="12.5" cx="14.5" r="1.5"></circle>
                                                                <circle cy="18.5" cx="9.5" r="1.5"></circle>
                                                                <circle cy="18.5" cx="14.5" r="1.5"></circle>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ays-survey-answer-icon-box ays-survey-answer-icon-just">
                                                        <span class="ays-survey-answer-icon">
                                                            <i class="ays_fa <?php echo $selected_anser_i_class; ?>"></i>
                                                        </span>
                                                    </div>
                                                    <div class="ays-survey-answer-box">
                                                        <input type="text" class="ays-survey-input" name="<?php echo $html_name_prefix; ?>sections[<?php echo $section['id']; ?>][questions][<?php echo $question['id']; ?>][answers][<?php echo $answer['id']; ?>][title]" placeholder="Option 1" value="<?php echo $answer['answer']; ?>">
                                                        <div class="ays-survey-input-underline"></div>
                                                        <div class="ays-survey-input-underline-animation"></div>
                                                    </div>
                                                    <div class="ays-survey-answer-icon-box">
                                                        <div class="ays-survey-add-answer-image appsMaterialWizButtonPapericonbuttonEl" data-type="answerImgButton">
                                                            <div class="ays-question-img-icon-content">
                                                                <div class="ays-question-img-icon-content-div">
                                                                    <div class="ays-survey-icons ays-survey-icons-hidden">
                                                                        <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ays-survey-answer-icon-box">
                                                        <span class="ays-survey-answer-icon ays-survey-answer-delete appsMaterialWizButtonPapericonbuttonEl" <?php echo count( $question['answers'] ) > 1 ? '' : 'style="visibility: hidden;"'; ?>>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path fill="#5f6368" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ays-survey-answer-image-container" <?php echo $answer['image'] == '' ? 'style="display: none;"' : ''; ?> >
                                                    <div class="ays-survey-answer-image-body">
                                                        <div class="ays-survey-answer-image-wrapper">
                                                            <div class="ays-survey-answer-image-wrapper-delete-wrap">
                                                                <div role="button" class="ays-survey-answer-image-wrapper-delete-cont removeAnswerImage">
                                                                    <span class="exportIcon">
                                                                        <div class="ays-survey-answer-image-wrapper-delete-icon-cont">
                                                                            <div class="aysMaterialIconIconImage ays-qp-icon-clear" aria-hidden="true">&nbsp;</div>
                                                                        </div>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <img class="ays-survey-answer-img" src="<?php echo $answer['image']; ?>" tabindex="0" aria-label="Captionless image" />
                                                            <input type="hidden" class="ays-survey-answer-img-src" name="<?php echo $html_name_prefix; ?>sections[<?php echo $section['id']; ?>][questions][<?php echo $question['id']; ?>][answers][<?php echo $answer['id']; ?>][image]" value="<?php echo $answer['image']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Answers end -->
                                            <?php
                                        endforeach;

                                        elseif ($question_type_Text_ShortText_Number):

                                            $selected_question_type_class = '';
                                            $selected_question_type_placeholder = '';
                                            switch ($selected_question_type) {
                                                case 'text':
                                                    $selected_question_type_class = 'ays-survey-question-type-text-box';
                                                    $selected_question_type_placeholder = $question_types_placeholders['text'];
                                                    break;
                                                case 'short_text':
                                                    $selected_question_type_class = 'ays-survey-question-type-short-text-box';
                                                    $selected_question_type_placeholder = $question_types_placeholders['short_text'];
                                                    break;
                                                case 'number':
                                                    $selected_question_type_class = 'ays-survey-question-type-number-box';
                                                    $selected_question_type_placeholder = $question_types_placeholders['number'];
                                                    break;
                                                case 'email':
                                                    $selected_question_type_class = 'ays-survey-question-type-email-box';
                                                    $selected_question_type_placeholder = $question_types_placeholders['email'];
                                                    break;
                                                case 'name':
                                                    $selected_question_type_class = 'ays-survey-question-type-name-box';
                                                    $selected_question_type_placeholder = $question_types_placeholders['name'];
                                                    break;
                                                default:
                                                    $selected_question_type_class = 'ays-survey-question-type-text-box';
                                                    $selected_question_type_placeholder = $question_types_placeholders['text'];
                                                    break;
                                            }
                                            ?>
                                            <div class="ays-survey-question-types">
                                                <div class="ays-survey-answer-row" data-id="1">
                                                    <div class="ays-survey-question-types-conteiner">
                                                        <div class="ays-survey-question-types-box isDisabled <?php echo $selected_question_type_class; ?>">
                                                            <div class="ays-survey-question-types-box-body">
                                                                <div class="ays-survey-question-types-input-box">
                                                                    <input type="text" class="ays-survey-remove-default-border ays-survey-question-types-input" autocomplete="off" tabindex="0" disabled="" placeholder="<?php echo $selected_question_type_placeholder; ?>" style="font-size: 14px;">
                                                                </div>
                                                                <div class="ays-survey-question-types-input-underline"></div>
                                                                <div class="ays-survey-question-types-input-focus-underline"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        endif;
                                        ?>
                                        </div>
                                        <div class="ays-survey-other-answer-and-actions-row">
                                        <?php
                                            if($question_type_Radio_Checkbox_Select):
                                                $selected_other_anser_i_class = '';
                                                switch ($selected_question_type) {
                                                    case 'radio':
                                                        $selected_other_anser_i_class = 'ays_fa_circle_thin';
                                                        break;
                                                    case 'select':
                                                        $selected_other_anser_i_class = 'ays_fa_circle_thin';
                                                        break;
                                                    case 'checkbox':
                                                        $selected_other_anser_i_class = 'ays_fa_square_o';
                                                        break;    
                                                    default:
                                                        $selected_other_anser_i_class = 'ays_fa_circle_thin';
                                                        break;
                                                }
                                            ?>
                                            <div class="ays-survey-answer-row ays-survey-other-answer-row" <?php echo $question['user_variant'] ? '' : 'style="display: none;"'; ?>>
                                                <div class="ays-survey-answer-wrap">
                                                    <div class="ays-survey-answer-dlg-dragHandle">
                                                        <div class="ays-survey-icons invisible">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <circle cy="6.5" cx="9.5" r="1.5"></circle>
                                                                <circle cy="6.5" cx="14.5" r="1.5"></circle>
                                                                <circle cy="12.5" cx="9.5" r="1.5"></circle>
                                                                <circle cy="12.5" cx="14.5" r="1.5"></circle>
                                                                <circle cy="18.5" cx="9.5" r="1.5"></circle>
                                                                <circle cy="18.5" cx="14.5" r="1.5"></circle>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ays-survey-answer-icon-box ays-survey-answer-icon-just">
                                                        <span class="ays-survey-answer-icon">
                                                            <i class="ays_fa <?php echo $selected_other_anser_i_class; ?>"></i>
                                                        </span>
                                                    </div>
                                                    <div class="ays-survey-answer-box">
                                                        <input type="text" disabled class="ays-survey-input ays-survey-input-other-answer" placeholder="<?php echo __( 'Other...', $this->plugin_name ); ?>" value="<?php echo __( 'Other...', $this->plugin_name ); ?>">
                                                        <div class="ays-survey-input-underline"></div>
                                                        <div class="ays-survey-input-underline-animation"></div>
                                                    </div>
                                                    <div class="ays-survey-answer-icon-box">
                                                        <div class="appsMaterialWizButtonPapericonbuttonEl invisible">
                                                            <div class="ays-question-img-icon-content">
                                                                <div class="ays-question-img-icon-content-div">
                                                                    <div class="ays-survey-icons ays-survey-icons-hidden">
                                                                        <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ays-survey-answer-icon-box">
                                                        <span class="ays-survey-answer-icon ays-survey-other-answer-delete appsMaterialWizButtonPapericonbuttonEl">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path fill="#5f6368" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ays-survey-answer-row">
                                                <div class="ays-survey-answer-wrap">
                                                    <div class="ays-survey-answer-dlg-dragHandle">
                                                        <div class="ays-survey-icons invisible">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <circle cy="6.5" cx="9.5" r="1.5"></circle>
                                                                <circle cy="6.5" cx="14.5" r="1.5"></circle>
                                                                <circle cy="12.5" cx="9.5" r="1.5"></circle>
                                                                <circle cy="12.5" cx="14.5" r="1.5"></circle>
                                                                <circle cy="18.5" cx="9.5" r="1.5"></circle>
                                                                <circle cy="18.5" cx="14.5" r="1.5"></circle>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ays-survey-answer-icon-box ays-survey-answer-icon-just">
                                                        <span class="ays-survey-answer-icon">
                                                            <i class="ays_fa <?php echo $selected_other_anser_i_class; ?>"></i>
                                                        </span>
                                                    </div>
                                                    <div class="ays-survey-answer-box d-flex">
                                                        <div class="ays-survey-action-add-answer appsMaterialWizButtonPapericonbuttonEl">
                                                            <div class="ays-question-img-icon-content">
                                                                <div class="ays-question-img-icon-content-div">
                                                                    <div class="ays-survey-icons">
                                                                        <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-add-circle-outline" aria-hidden="true">&nbsp;</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ays-survey-other-answer-add-wrap" <?php echo $question['user_variant'] ? 'style="display: none;"' : ''; ?>>
                                                            <span class=""><?php echo __( 'or', $this->plugin_name ) ?></span>
                                                            <div class="ays-survey-other-answer-container ays-survey-other-answer-add">
                                                                <div class="ays-survey-other-answer-container-overlay"></div>
                                                                <span class="ays-survey-other-answer-content">
                                                                    <span class="appsMaterialWizButtonPaperbuttonLabel quantumWizButtonPaperbuttonLabel"><?php echo __( 'add "Other"', $this->plugin_name ) ?></span>
                                                                    <input type="checkbox" <?php echo $question['user_variant'] ? 'checked' : ''; ?> class="display_none ays-survey-other-answer-checkbox" value="on" name="<?php echo $html_name_prefix; ?>sections[<?php echo $section['id']; ?>][questions][<?php echo $question['id']; ?>][user_variant]">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ays-survey-answer-icon-box">
                                                        <div class="appsMaterialWizButtonPapericonbuttonEl invisible">
                                                            <div class="ays-question-img-icon-content">
                                                                <div class="ays-question-img-icon-content-div">
                                                                    <div class="ays-survey-icons ays-survey-icons-hidden">
                                                                        <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ays-survey-answer-icon-box invisible">
                                                        <span class="ays-survey-answer-icon ays-survey-other-answer-delete-icon appsMaterialWizButtonPapericonbuttonEl">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path fill="#5f6368" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                                                <path d="M0 0h24v24H0z" fill="none"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                        <div class="ays-survey-row-divider"><div></div></div>
                                        <div class="ays-survey-actions-row">
                                            <div></div>
                                            <div class="ays-survey-actions">
                                                <div class="ays-survey-answer-icon-box">
                                                    <div class="ays-survey-action-duplicate-question appsMaterialWizButtonPapericonbuttonEl" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="<?php echo __('Duplicate',$this->plugin_name)?>">
                                                        <div class="ays-question-img-icon-content">
                                                            <div class="ays-question-img-icon-content-div">
                                                                <div class="ays-survey-icons">
                                                                    <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-content-copy" aria-hidden="true">&nbsp;</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ays-survey-answer-icon-box">
                                                    <div class="ays-survey-action-delete-question appsMaterialWizButtonPapericonbuttonEl" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="<?php echo __('Delete',$this->plugin_name)?>">
                                                        <div class="ays-question-img-icon-content">
                                                            <div class="ays-question-img-icon-content-div">
                                                                <div class="ays-survey-icons">
                                                                    <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-delete" aria-hidden="true">&nbsp;</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ays-survey-vertical-divider"><div></div></div>
                                                <div class="ays-survey-answer-elem-box">
                                                    <label>
                                                        <span>
                                                            <span><?php echo __( 'Required', $this->plugin_name ); ?></span>
                                                        </span>
                                                        <input type="checkbox" <?php echo $question['options']['required'] ? 'checked' : ''; ?> class="display_none ays-survey-input-required-question ays-switch-checkbox" name="<?php echo $html_name_prefix; ?>sections[<?php echo $section['id']; ?>][questions][<?php echo $question['id']; ?>][options][required]" value="on">
                                                        <div class="switch-checkbox-wrap" aria-label="Required" tabindex="0" role="checkbox">
                                                            <div class="switch-checkbox-track"></div>
                                                            <div class="switch-checkbox-ink"></div>
                                                            <div class="switch-checkbox-circles">
                                                                <div class="switch-checkbox-thumb"></div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="ays-survey-answer-icon-box">
                                                    <div class="ays-survey-action-more appsMaterialWizButtonPapericonbuttonEl">
                                                        <div class="ays-question-img-icon-content">
                                                            <div class="ays-question-img-icon-content-div">
                                                                <div class="ays-survey-icons">
                                                                    <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-more-vertical-m2" aria-hidden="true">&nbsp;</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Questons end -->
                                    <?php
                                endforeach;
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Sections end -->
                <?php
                endforeach;
            }
            ?>
            </div>
        </div>
        <div class="col-sm-1">
            <input type="hidden" class="ays-survey-scroll-section" value="1">
            <!-- Bar Menu  Start-->
            <div class="aysFormeditorViewFatRoot aysFormeditorViewFatDesktop">
                <div class="aysFormeditorViewFatPositioner">
                    <div class="aysFormeditorViewFatCard">
                        <div class="dropleft">
                            <div data-action="add-question" class="ays-survey-general-action" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?php echo __('Add Question',$this->plugin_name)?>">
                                <div class="appsMaterialWizButtonPapericonbuttonEl">
                                    <div class="ays-question-img-icon-content">
                                        <div class="ays-question-img-icon-content-div">
                                            <div class="ays-survey-icons">
                                                <div class="aysMaterialIconIconImage ays-qp-icon-add-circle-outline" aria-hidden="true">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-menu"></div>
                        </div>
                        <!-- <div data-action="import-question" class="ays-survey-general-action">
                            <div class="appsMaterialWizButtonPapericonbuttonEl">
                                <div class="ays-question-img-icon-content">
                                    <div class="ays-question-img-icon-content-div">
                                        <div class="ays-survey-icons">
                                            <div class="aysMaterialIconIconImage ays-qp-icon-import-question-m2" aria-hidden="true">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-action="add-section-header" data-action-properties="enabled" class="ays-survey-general-action">
                            <div class="appsMaterialWizButtonPapericonbuttonEl">
                                <div class="ays-question-img-icon-content">
                                    <div class="ays-question-img-icon-content-div">
                                        <div class="ays-survey-icons">
                                            <div class="aysMaterialIconIconImage ays-qp-icon-add-header" aria-hidden="true">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-action="add-image" class="ays-survey-general-action">
                            <div class="appsMaterialWizButtonPapericonbuttonEl">
                                <div class="ays-question-img-icon-content">
                                    <div class="ays-question-img-icon-content-div">
                                        <div class="ays-survey-icons">
                                            <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-action="add-video" class="ays-survey-general-action">
                            <div class="appsMaterialWizButtonPapericonbuttonEl">
                                <div class="ays-question-img-icon-content">
                                    <div class="ays-question-img-icon-content-div">
                                        <div class="ays-survey-icons">
                                            <div class="aysMaterialIconIconImage ays-qp-icon-video-m2" aria-hidden="true">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div data-action="add-section" class="ays-survey-general-action" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="<?php echo __('Add Section',$this->plugin_name)?>">
                            <div class="appsMaterialWizButtonPapericonbuttonEl">
                                <div class="ays-question-img-icon-content">
                                    <div class="ays-question-img-icon-content-div">
                                        <div class="ays-survey-icons">
                                            <div class="aysMaterialIconIconImage ays-qp-icon-section-m2" aria-hidden="true">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bar Menu  End-->

            <!-- Question to clone -->
            <div class="ays-question-to-clone display_none">
                <div class="ays-survey-question-answer-conteiner" data-name="questions_add" data-id="1">
                    <div class="ays-survey-question-conteiner">
                        <div class="ays-survey-question-dlg-dragHandle">
                            <div class="ays-survey-icons ays-survey-icons-hidden">
                                <div class="aysMaterialIconIconImage aysMaterialIconIconDarkIcon ays-qp-icon-drag-handle-horz-b" aria-hidden="true">&nbsp;</div>
                            </div>
                        </div>
                        <div class="ays-survey-question-row">
                            <div class="ays-survey-question-box">
                                <div class="ays-survey-question-input-box">
                                    <textarea type="text" class="ays-survey-remove-default-border ays-survey-question-input-textarea ays-survey-question-input ays-survey-input" placeholder="<?php echo __( 'Question', $this->plugin_name ); ?>"style="height: 24px;"></textarea>
                                    <input type="hidden" value="">
                                    <div class="ays-survey-input-underline"></div>
                                    <div class="ays-survey-input-underline-animation"></div>
                                </div>
                            </div>
                            <div class="ays-survey-question-img-icon-box">
                                <div class="ays-survey-add-question-image appsMaterialWizButtonPapericonbuttonEl" data-type="questionImgButton" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="<?php echo __('Add image',$this->plugin_name)?>">
                                    <div class="ays-question-img-icon-content">
                                        <div class="ays-question-img-icon-content-div">
                                            <div class="ays-survey-icons ays-survey-icons-hidden">
                                                <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ays-survey-question-type-box">
                                <select tabindex="-1" class="ays-survey-question-type" aria-hidden="true">
                                    <?php 
                                        foreach ($question_types as $type_slug => $type):
                                            ?>
                                            <option value="<?php echo $type_slug; ?>"><?php echo $type; ?></option>
                                            <?php
                                        endforeach;
                                    ?>
                                </select>
                                <input type="hidden" class="ays-survey-check-type-before-change" value="<?php echo 'radio'; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="ays-survey-question-image-container" style="display: none;" >
                        <div class="ays-survey-question-image-body">
                            <div class="ays-survey-question-image-wrapper aysFormeditorViewMediaImageWrapper">
                                <div class="ays-survey-question-image-pos aysFormeditorViewMediaImagePos">
                                    <div class="d-flex">
                                        <div class="dropdown mr-1">
                                            <div class="ays-survey-question-edit-menu-button dropdown-menu-actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ays_fa ays_fa_ellipsis_v"></i>
                                            </div>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item ays-survey-question-img-action" data-action="edit-image" href="javascript:void(0);"><?php echo __( 'Edit', $this->plugin_name ); ?></a>
                                                <a class="dropdown-item ays-survey-question-img-action" data-action="delete-image" href="javascript:void(0);"><?php echo __( 'Delete', $this->plugin_name ); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="ays-survey-question-img" src="" tabindex="0" aria-label="Captionless image" />
                                    <input type="hidden" class="ays-survey-question-img-src" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ays-survey-answers-conteiner">
                        <div class="ays-survey-answer-row" data-id="1">
                            <div class="ays-survey-answer-wrap">
                                <div class="ays-survey-answer-dlg-dragHandle">
                                    <div class="ays-survey-icons ays-survey-icons-hidden">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <circle cy="6.5" cx="9.5" r="1.5"></circle>
                                            <circle cy="6.5" cx="14.5" r="1.5"></circle>
                                            <circle cy="12.5" cx="9.5" r="1.5"></circle>
                                            <circle cy="12.5" cx="14.5" r="1.5"></circle>
                                            <circle cy="18.5" cx="9.5" r="1.5"></circle>
                                            <circle cy="18.5" cx="14.5" r="1.5"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ays-survey-answer-icon-box ays-survey-answer-icon-just">
                                    <span class="ays-survey-answer-icon">
                                        <i class="ays_fa ays_fa_circle_thin"></i>
                                    </span>
                                </div>
                                <div class="ays-survey-answer-box">
                                    <input type="text" class="ays-survey-input" placeholder="Option 1" value="Option 1">
                                    <div class="ays-survey-input-underline"></div>
                                    <div class="ays-survey-input-underline-animation"></div>
                                </div>
                                <div class="ays-survey-answer-icon-box">
                                    <div class="ays-survey-add-answer-image appsMaterialWizButtonPapericonbuttonEl" data-type="answerImgButton">
                                        <div class="ays-question-img-icon-content">
                                            <div class="ays-question-img-icon-content-div">
                                                <div class="ays-survey-icons ays-survey-icons-hidden">
                                                    <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ays-survey-answer-icon-box">
                                    <span class="ays-survey-answer-icon ays-survey-answer-delete appsMaterialWizButtonPapericonbuttonEl" style="visibility: hidden;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="#5f6368" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="ays-survey-answer-image-container" style="display: none;" >
                                <div class="ays-survey-answer-image-body">
                                    <div class="ays-survey-answer-image-wrapper">
                                        <div class="ays-survey-answer-image-wrapper-delete-wrap">
                                            <div role="button" class="ays-survey-answer-image-wrapper-delete-cont removeAnswerImage">
                                                <span class="exportIcon">
                                                    <div class="ays-survey-answer-image-wrapper-delete-icon-cont">
                                                        <div class="aysMaterialIconIconImage ays-qp-icon-clear" aria-hidden="true">&nbsp;</div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <img class="ays-survey-answer-img" src="" tabindex="0" aria-label="Captionless image" />
                                        <input type="hidden" class="ays-survey-answer-img-src" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ays-survey-other-answer-and-actions-row">
                        <div class="ays-survey-answer-row ays-survey-other-answer-row" style="display: none;">
                            <div class="ays-survey-answer-wrap">
                                <div class="ays-survey-answer-dlg-dragHandle">
                                    <div class="ays-survey-icons invisible">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <circle cy="6.5" cx="9.5" r="1.5"></circle>
                                            <circle cy="6.5" cx="14.5" r="1.5"></circle>
                                            <circle cy="12.5" cx="9.5" r="1.5"></circle>
                                            <circle cy="12.5" cx="14.5" r="1.5"></circle>
                                            <circle cy="18.5" cx="9.5" r="1.5"></circle>
                                            <circle cy="18.5" cx="14.5" r="1.5"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ays-survey-answer-icon-box ays-survey-answer-icon-just">
                                    <span class="ays-survey-answer-icon">
                                        <i class="ays_fa ays_fa_circle_thin"></i>
                                    </span>
                                </div>
                                <div class="ays-survey-answer-box">
                                    <input type="text" disabled class="ays-survey-input ays-survey-input-other-answer" placeholder="<?php echo __( 'Other...', $this->plugin_name ); ?>" value="<?php echo __( 'Other...', $this->plugin_name ); ?>">
                                    <div class="ays-survey-input-underline"></div>
                                    <div class="ays-survey-input-underline-animation"></div>
                                </div>
                                <div class="ays-survey-answer-icon-box">
                                    <div class="appsMaterialWizButtonPapericonbuttonEl invisible">
                                        <div class="ays-question-img-icon-content">
                                            <div class="ays-question-img-icon-content-div">
                                                <div class="ays-survey-icons ays-survey-icons-hidden">
                                                    <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ays-survey-answer-icon-box">
                                    <span class="ays-survey-answer-icon ays-survey-other-answer-delete appsMaterialWizButtonPapericonbuttonEl invisible">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="#5f6368" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="ays-survey-answer-row">
                            <div class="ays-survey-answer-wrap">
                                <div class="ays-survey-answer-dlg-dragHandle">
                                    <div class="ays-survey-icons invisible">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <circle cy="6.5" cx="9.5" r="1.5"></circle>
                                            <circle cy="6.5" cx="14.5" r="1.5"></circle>
                                            <circle cy="12.5" cx="9.5" r="1.5"></circle>
                                            <circle cy="12.5" cx="14.5" r="1.5"></circle>
                                            <circle cy="18.5" cx="9.5" r="1.5"></circle>
                                            <circle cy="18.5" cx="14.5" r="1.5"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ays-survey-answer-icon-box ays-survey-answer-icon-just">
                                    <span class="ays-survey-answer-icon">
                                        <i class="ays_fa ays_fa_circle_thin"></i>
                                    </span>
                                </div>
                                <div class="ays-survey-answer-box d-flex">
                                    <div class="ays-survey-action-add-answer appsMaterialWizButtonPapericonbuttonEl">
                                        <div class="ays-question-img-icon-content">
                                            <div class="ays-question-img-icon-content-div">
                                                <div class="ays-survey-icons">
                                                    <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-add-circle-outline" aria-hidden="true">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ays-survey-other-answer-add-wrap">
                                        <span class=""><?php echo __( 'or', $this->plugin_name ) ?></span>
                                        <div class="ays-survey-other-answer-container ays-survey-other-answer-add">
                                            <div class="ays-survey-other-answer-container-overlay"></div>
                                            <span class="ays-survey-other-answer-content">
                                                <span class="appsMaterialWizButtonPaperbuttonLabel quantumWizButtonPaperbuttonLabel"><?php echo __( 'add "Other"', $this->plugin_name ) ?></span>
                                                <input type="checkbox" class="display_none ays-survey-other-answer-checkbox" value="on">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ays-survey-answer-icon-box">
                                    <div class="appsMaterialWizButtonPapericonbuttonEl invisible">
                                        <div class="ays-question-img-icon-content">
                                            <div class="ays-question-img-icon-content-div">
                                                <div class="ays-survey-icons ays-survey-icons-hidden">
                                                    <div class="aysMaterialIconIconImage ays-qp-icon-image-m2" aria-hidden="true">&nbsp;</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ays-survey-answer-icon-box">
                                    <span class="ays-survey-answer-icon ays-survey-other-answer-delete-icon appsMaterialWizButtonPapericonbuttonEl invisible">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="#5f6368" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path>
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ays-survey-row-divider"><div></div></div>
                    <div class="ays-survey-actions-row">
                        <div></div>
                        <div class="ays-survey-actions">
                            <div class="ays-survey-answer-icon-box">
                                <div class="ays-survey-action-duplicate-question appsMaterialWizButtonPapericonbuttonEl" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="<?php echo __('Duplicate',$this->plugin_name)?>">
                                    <div class="ays-question-img-icon-content">
                                        <div class="ays-question-img-icon-content-div">
                                            <div class="ays-survey-icons">
                                                <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-content-copy" aria-hidden="true">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ays-survey-answer-icon-box">
                                <div class="ays-survey-action-delete-question appsMaterialWizButtonPapericonbuttonEl" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="<?php echo __('Delete',$this->plugin_name)?>">
                                    <div class="ays-question-img-icon-content">
                                        <div class="ays-question-img-icon-content-div">
                                            <div class="ays-survey-icons">
                                                <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-delete" aria-hidden="true">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ays-survey-vertical-divider"><div></div></div>
                            <div class="ays-survey-answer-elem-box">
                                <label>
                                    <span>
                                        <span><?php echo __( 'Required', $this->plugin_name ); ?></span>
                                    </span>
                                    <input type="checkbox" class="display_none ays-survey-input-required-question ays-switch-checkbox" value="on">
                                    <div class="switch-checkbox-wrap" aria-label="Required" tabindex="0" role="checkbox">
                                        <div class="switch-checkbox-track"></div>
                                        <div class="switch-checkbox-ink"></div>
                                        <div class="switch-checkbox-circles">
                                            <div class="switch-checkbox-thumb"></div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="ays-survey-answer-icon-box">
                                <div class="ays-survey-action-more appsMaterialWizButtonPapericonbuttonEl">
                                    <div class="ays-question-img-icon-content">
                                        <div class="ays-question-img-icon-content-div">
                                            <div class="ays-survey-icons">
                                                <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-more-vertical-m2" aria-hidden="true">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ays-survey-section-box ays-survey-new-section" data-name="<?php echo $html_name_prefix; ?>section_add" data-id="1">
                    <div class="ays-survey-section-head-wrap">
                        <div class="ays-survey-section-head-top display_none">
                            <div class="ays-survey-section-counter">
                                <span>
                                    <span><?php echo __( 'Section', $this->plugin_name ); ?></span>
                                    <span class="ays-survey-section-number">1</span>
                                    <span><?php echo __( 'of', $this->plugin_name ); ?></span>
                                    <span class="ays-survey-sections-count">1</span>
                                </span>
                            </div>
                        </div>
                        <div class="ays-survey-section-head">
                            <!--  Section Title Start  -->
                            <div class="ays-survey-section-title-conteiner">
                                <input type="text" class="ays-survey-section-title ays-survey-input" tabindex="0" placeholder="<?php echo __( 'Section title' , $this->plugin_name ); ?>" value=""/>
                                <div class="ays-survey-input-underline"></div>
                                <div class="ays-survey-input-underline-animation"></div>
                            </div>
                            <!--  Section Title End  -->

                            <!--  Section Description Start  -->
                            <div class="ays-survey-section-description-conteiner">
                                <input type="text" class="ays-survey-section-description ays-survey-input" placeholder="<?php echo __( 'Section Description' , $this->plugin_name ); ?>" value=""/>
                                <div class="ays-survey-input-underline"></div>
                                <div class="ays-survey-input-underline-animation"></div>
                            </div>
                            <!--  Section Description End  -->

                            <div class="ays-survey-answer-icon-box dropdown ays-survey-section-actions invisible">
                                <div class="ays-survey-action-more appsMaterialWizButtonPapericonbuttonEl" data-toggle="dropdown">
                                    <div class="ays-question-img-icon-content">
                                        <div class="ays-question-img-icon-content-div">
                                            <div class="ays-survey-icons">
                                                <div class="aysMaterialIconIconImage aysMaterialIconIconM2Icon ays-qp-icon-more-vertical-m2" aria-hidden="true">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button type="button" class="dropdown-item ays-survey-delete-section"><?php echo __( 'Delete section', $this->plugin_name ); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ays-survey-section-body">
                        <div class="ays-survey-section-questions">
                        </div>
                    </div>
                </div>
                
                <!-- Question Type Text/Short Text clone Start -->
                <div class="ays-survey-question-types">
                    <div class="ays-survey-answer-row" data-id="1">
                        <div class="ays-survey-question-types-conteiner">
                            <div class="ays-survey-question-types-box isDisabled">
                                <div class="ays-survey-question-types-box-body">
                                    <div class="ays-survey-question-types-input-box">
                                        <input type="text" class="ays-survey-remove-default-border ays-survey-question-types-input" autocomplete="off" tabindex="0" disabled="" placeholder="" style="font-size: 14px;">
                                    </div>
                                    
                                    <div class="ays-survey-question-types-input-underline"></div>
                                    <div class="ays-survey-question-types-input-focus-underline"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Question Type Text/Short Text clone End -->
            </div>
        </div>
    </div>
</div>