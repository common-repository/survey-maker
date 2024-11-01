(function( $ ) {
	'use strict';
    $.fn.serializeFormJSON = function () {
        let o = {},
            a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

	$(document).ready(function () {
        // Notifications dismiss button
        var $html_name_prefix = 'ays_';
        $(document).on('click', '.notice-dismiss', function (e) {
            changeCurrentUrl('status');
        });

        if(location.href.indexOf('del_stat')){
            setTimeout(function(){
                changeCurrentUrl('del_stat');
                changeCurrentUrl('mcount');
            }, 500);
        }

        var aysSurveyTextArea = $(document).find('textarea.ays-survey-question-input-textarea');
        autosize(aysSurveyTextArea);


        function changeCurrentUrl(key){
            var linkModified = location.href.split('?')[1].split('&');
            for(var i = 0; i < linkModified.length; i++){
                if(linkModified[i].split("=")[0] == key){
                    linkModified.splice(i, 1);
                }
            }
            linkModified = linkModified.join('&');
            window.history.replaceState({}, document.title, '?'+linkModified);
        }

        // Quiz toast close button
        jQuery('.quiz_toast__close').click(function(e){
            e.preventDefault();
            var parent = $(this).parent('.quiz_toast');
            parent.fadeOut("slow", function() { $(this).remove(); } );
        });
        
        var toggle_ddmenu = $(document).find('.toggle_ddmenu');
        toggle_ddmenu.on('click', function () {
            var ddmenu = $(this).next();
            var state = ddmenu.attr('data-expanded');
            switch (state) {
                case 'true':
                    $(this).find('.ays_fa').css({
                        transform: 'rotate(0deg)'
                    });
                    ddmenu.attr('data-expanded', 'false');
                    break;
                case 'false':
                    $(this).find('.ays_fa').css({
                        transform: 'rotate(90deg)'
                    });
                    ddmenu.attr('data-expanded', 'true');
                    break;
            }
        });
        
        $('[data-toggle="popover"]').popover();
        $('[data-toggle="tooltip"]').tooltip();

        $(document).find('.ays_survey_aysDropdown').aysDropdown();

        // $(document).on('mouseover','.ays-survey-action-duplicate-question', function(){
        //     var content = $(this).html();

        //     $(this).popover({
        //         container: 'body',
        //         placement: 'bottom',
        //         html: true,
        //         content: function(){
        //           return content;
        //         }
        //     })
        // });

        // Disabling submit when press enter button on inputing
        $(document).on("input", 'input', function(e){
            if(e.keyCode == 13){
                if($(document).find("#ays-question-form").length !== 0 ||
                   $(document).find("#ays-survey-category-form").length !== 0 ||
                   $(document).find("#ays-survey-settings-form").length !== 0){
                    return false;
                }
            }
        });
        
        $(document).on("keydown", function(e){
            if(e.target.nodeName == "TEXTAREA"){
                return true;
            }
            if(e.keyCode == 13){
                if($(document).find("#ays-question-form").length !== 0 ||
                   $(document).find("#ays-survey-category-form").length !== 0 ||
                   $(document).find("#ays-survey-settings-form").length !== 0){
                    return false;
                }
            }
            if(e.keyCode === 27){
                $(document).find('.ays-modal').aysModal('hide');
                return false;
            }
        });

        $(document).find('#ays_user_roles').select2({
            allowClear: true,
            placeholder: SurveyMakerAdmin.selectUserRoles
        });

        $(document).on('change', '.ays_toggle_checkbox', function (e) {
            var state = $(this).prop('checked');
            var parent = $(this).parents('.ays_toggle_parent');
            
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });
        
        $(document).on('change', '.ays_toggle_select', function (e) {
            var state = $(this).val();
            var toggle = $(this).data('hide');
            var parent = $(this).parents('.ays_toggle_parent');
            
            if($(this).hasClass('ays_toggle_slide')){
                if (toggle == state) {
                    parent.find('.ays_toggle_target').slideUp(250);
                    parent.find('.ays_toggle_target_inverse').slideDown(150);
                }else{
                    parent.find('.ays_toggle_target').slideDown(150);
                    parent.find('.ays_toggle_target_inverse').slideUp(250);
                }
            }else{
                if (toggle == state) {
                    parent.find('.ays_toggle_target').hide(150);
                    parent.find('.ays_toggle_target_inverse').show(250);
                }else{
                    parent.find('.ays_toggle_target').show(250);
                    parent.find('.ays_toggle_target_inverse').hide(150);
                }
            }
        });


        $(document).find('#ays-category').select2({
            placeholder: 'Select category'
        });

        $(document).find('#ays-status').select2({
            placeholder: 'Select status'
        });


        // Tabulation
        $(document).find('.nav-tab-wrapper a.nav-tab').on('click', function (e) {
            if(! $(this).hasClass('no-js')){
                var elemenetID = $(this).attr('href');
                var active_tab = $(this).attr('data-tab');
                $(document).find('.nav-tab-wrapper a.nav-tab').each(function () {
                    if ($(this).hasClass('nav-tab-active')) {
                        $(this).removeClass('nav-tab-active');
                    }
                });
                $(this).addClass('nav-tab-active');
                $(document).find('.ays-survey-tab-content').each(function () {
                    $(this).css('display', 'none');
                });
                $(document).find("[name='ays_survey_tab']").val(active_tab);
                $('.ays-survey-tab-content' + elemenetID).css('display', 'block');
                e.preventDefault();
            }
        });


        // Quizzes form submit
        // Checking the issues
        // $(document).find('#ays-survey-category-form').on('submit', function(e){
            
        //     if($(document).find('#ays-title').val() == ''){
        //         $(document).find('#ays-title').val('Quiz').trigger('input');
        //     }
        //     var $this = $(this)[0];
        //     if($(document).find('#ays-title').val() != ""){
        //         $this.submit();
        //     }else{
        //         e.preventDefault();
        //         $this.submit();
        //     }
        // });
        
        // Delete confirmation
        $(document).on('click', '.ays_confirm_del', function(e){            
            e.preventDefault();
            var message = $(this).data('message');
            var confirm = window.confirm('Are you sure you want to delete '+message+'?');
            if(confirm === true){
                window.location.replace($(this).attr('href'));
            }
        });


        $(document).find('.cat-filter-apply-top').on('click', function(e) {
            e.preventDefault();
            catFilterForListTable('top');
        });

        $(document).find('.cat-filter-apply-bottom').on('click', function(e){
            e.preventDefault();
            catFilterForListTable('bottom');
        });

        $(document).find('.user-filter-apply').on('click', function(e){
            e.preventDefault();
            var catFilter = $(document).find('select[name="filterbyuser"]').val();
            var link = location.href;
            var linkFisrtPart = link.split('?')[0];
            var linkModified = link.split('?')[1].split('&');
            for(var i = 0; i < linkModified.length; i++){
                if(linkModified[i].split("=")[0] == "wpuser"){
                    linkModified.splice(i, 1);
                }
            }
            link = linkFisrtPart + "?" + linkModified.join('&');
            
            if( catFilter != '' ){
                catFilter = "&wpuser="+catFilter;
                document.location.href = link+catFilter;
            }else{
                document.location.href = link;
            }
        });

        function catFilterForListTable(which){
            var catFilter = $(document).find('select[name="filterby-' + which + '"]').val();

            var link = location.href;
            if( catFilter != '' ){
                catFilter = "&filterby="+catFilter;
                var linkModifiedStart = link.split('?')[0];
                var linkModified = link.split('?')[1].split('&');
                for(var i = 0; i < linkModified.length; i++){
                    if(linkModified[i].split("=")[0] == "filterby"){
                        linkModified.splice(i, 1);
                    }
                }
                linkModified = linkModified.join('&');
                document.location.href = linkModifiedStart + "?" + linkModified + catFilter;
            }else{
                var linkModifiedStart = link.split('?')[0];
                var linkModified = link.split('?')[1].split('&');
                for(var i = 0; i < linkModified.length; i++){
                    if(linkModified[i].split("=")[0] == "filterby"){
                        linkModified.splice(i, 1);
                    }
                }
                linkModified = linkModified.join('&');
                document.location.href = linkModifiedStart + "?" + linkModified;
            }
        }

        $(document).on('change', '#import_file', function(e){
            var pattern = /(.csv|.xlsx|.json)$/g;
            if(pattern.test($(this).val())){
                $(this).parents('form').find('input[name="ays_survey_import"]').removeAttr('disabled')
            }
        });


        /////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////ARO START///////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////

        function aysSurveyQuestionSortableHelper( event ) {
            var clone = $(event.target).parents('.ays-survey-question-answer-conteiner').clone(true, true);
            clone.find('.ays-survey-question-image-container').remove();
            clone.find('.ays-survey-other-answer-and-actions-row').remove();
            clone.find('.ays-survey-answers-conteiner').html('<div class="ays-survey-sortable-ect">…</div>');
            return clone;
        }

        var questionDragHandle = {
            handle: '.ays-survey-question-dlg-dragHandle',
            appendTo: "parent",
            cursor: 'move',
            opacity: 0.8,
            axis: 'y',
            placeholder: 'ays-survey-sortable-placeholder',
            tolerance: "pointer",
            revert: true,
            forcePlaceholderSize: true,
            forceHelperSize: true,
            helper: aysSurveyQuestionSortableHelper
        };

        var answerDragHandle = {
            handle: '.ays-survey-answer-dlg-dragHandle',
            cursor: 'move',
            opacity: 0.8,
            axis: 'y',
            placeholder: 'clone',
            tolerance: "pointer",
            helper: "clone",
            revert: true,
            forcePlaceholderSize: true,
            forceHelperSize: true,
        }
        // Answers ordering jQuery UI
        $(document).find('.ays-survey-sections-conteiner .ays-survey-answers-conteiner').sortable(answerDragHandle);
        // Question ordering jQuery UI
        $(document).find('.ays-survey-sections-conteiner .ays-survey-section-questions').sortable(questionDragHandle).disableSelection();


        // Add Question and Answer Image 
        $(document).on('click', '.ays-survey-add-question-image, .ays-survey-add-answer-image', function (e) {
            var dataType = $(this).data('type');
            openMediaUploader(e, $(this), dataType);
        });



        // Add Answer Button
        $(document).on('click', '.ays-survey-action-add-answer', function(e){
            var $this = $(this);
            var section = $this.parents('.ays-survey-section-box');
            var sectionId = section.data('id');
            var questsCont = $this.parents('.ays-survey-question-answer-conteiner');
            var itemId = questsCont.data('id');
            var answersCont = questsCont.find('.ays-survey-answers-conteiner');
            var cloningElement = answersCont.find('.ays-survey-answer-row:first-child');
            var id = cloningElement.data('id');
            var answerLength = answersCont.find('.ays-survey-answer-row').length + 1;

            var clone = cloningElement.clone(true,true).attr('data-id', answerLength).appendTo(answersCont);

            var answerContainer = questsCont.find('.ays-survey-answers-conteiner');
            var length = answerContainer.find('.ays-survey-answer-row').length;
            var clonedElem = clone.find('.ays-survey-input');
            var clonedElemInp = clonedElem.val('Option '+ length);

            clonedElem.attr('name', newAnswerAttrName( section.data('name'), sectionId, questsCont.data('name'), itemId, length, 'title'));
            // clonedElem.find('.aysAnswerImgConteiner').html('');
            clonedElemInp.select();

            clone.addClass('ays-survey-new-answer');
            clone.find('.ays-survey-answer-image-container').hide();
            clone.find('.ays-survey-answer-image-container .ays-survey-answer-img').removeAttr('src');
            clone.find('.ays-survey-answer-image-container .ays-survey-answer-img-src').val('');
            clone.find('.ays-survey-answer-image-container .ays-survey-answer-img-src').attr('name', newAnswerAttrName( section.data('name'), sectionId, questsCont.data('name'), itemId, length, 'image'));
            var deleteButton = answerContainer.find('.ays-survey-answer-delete');
            if(length == 1){
                deleteButton.css('visibility', 'hidden');
            }else{
                deleteButton.removeAttr('style');
            }
            answerContainer.sortable(answerDragHandle);
        });

        // Delete Answer Button
        $(document).on('click', '.ays-survey-answer-delete', function(e){
            var $this = $(this);
            var itemId = $this.parents('.ays-survey-question-answer-conteiner').data('id');
            var answerId = $this.parents('.ays-survey-answer-row').data('id');
            var length = $this.parents('.ays-survey-answers-conteiner').find('.ays-survey-answer-delete').length - 1;
            var parent = $this.parents('.ays-survey-answers-conteiner');
            var hideDeleteButton = parent.find('.ays-survey-answer-delete');

            if(length == 1){
                hideDeleteButton.css('visibility','hidden');
            }else{
                hideDeleteButton.removeAttr('style');
            }
            if( ! $this.parents('.ays-survey-answer-row').hasClass('ays-survey-new-answer') ){
                var delImp = '<input type="hidden" name="'+ $html_name_prefix +'answers_delete[]" value="'+ answerId +'">';
                $this.parents('form').append( delImp );
            }
            $this.parents('.ays-survey-answer-row').remove();
        });

        // Add "Other" Answer
        $(document).on('click', '.ays-survey-other-answer-add', function(e){
            var $this = $(this);
            var parent = $this.parents('.ays-survey-question-answer-conteiner');
            var checkbox = parent.find('.ays-survey-other-answer-checkbox').attr('checked', 'checked');
            var oterAnswer = parent.find('.ays-survey-other-answer-row');
            oterAnswer.removeAttr('style');
            $this.parents('.ays-survey-other-answer-add-wrap').css('display','none');
        });

        // Delete "Other" Answer
        $(document).on('click', '.ays-survey-other-answer-delete', function(e){
            var $this = $(this);
            var parent = $this.parents('.ays-survey-question-answer-conteiner');
            var checkbox = parent.find('.ays-survey-other-answer-checkbox').removeAttr('checked');
            var oterAnswer = parent.find('.ays-survey-other-answer-row');
            oterAnswer.css('display','none');
            parent.find('.ays-survey-other-answer-add-wrap').removeAttr('style');
        });

        // Dublicate Question Button
        $(document).on('click', '.ays-survey-action-duplicate-question', function(e){
            var $this = $(this);
            var sectionId = $this.parents('.ays-survey-section-box').data('id');
            var sectionName = $this.parents('.ays-survey-section-box').data('name');
            var cloningElement = $this.parents('.ays-survey-question-answer-conteiner');
            var itemId = cloningElement.data('id');
            var question_length = cloningElement.parent().find('.ays-survey-question-answer-conteiner').length + 1;
            var question_type = cloningElement.find('.ays-survey-question-conteiner .ays-survey-question-type').val();

            cloningElement.find('.ays-survey-question-type').aysDropdown('destroy');
            var clone = cloningElement.clone(true,true).attr('data-id', question_length).insertAfter( cloningElement );
            var newElement = $this.parents('.ays-survey-section-box').find('.ays-survey-question-answer-conteiner[data-id = '+ question_length +']');

            newElement.find('textarea.ays-survey-question-input.ays-survey-input').attr( 'name', newQuestionAttrName( sectionName, sectionId, question_length, 'title') );
            newElement.find('input.ays-survey-question-img-src').attr( 'name', newQuestionAttrName( sectionName, sectionId, question_length, 'image') );
            newElement.find('select.ays-survey-question-type').attr( 'name', newQuestionAttrName( sectionName, sectionId, question_length, 'type') );
            newElement.find('.ays-survey-question-conteiner .ays-survey-question-type').val(question_type);
            newElement.find('.ays_question_ids').val(question_length);
            newElement.find('.ays_question_old_ids').remove();
            newElement.addClass('ays-survey-new-question');
            var answer = newElement.find('.ays-survey-answer-box input.ays-survey-input').each(function(i){
                $(this).attr('name', newAnswerAttrName( sectionName, sectionId, newElement.data('name'), question_length, i+1, 'title') );
                $(this).parents('.ays-survey-answer-box').find('.ays-survey-answer-img-src').attr('name', newAnswerAttrName( sectionName, sectionId, newElement.data('name'), question_length, i+1, 'image') );
            });
            newElement.find('.ays-survey-question-type').aysDropdown();
            cloningElement.find('.ays-survey-question-type').aysDropdown();
            // newElement.find('.ays-survey-question-type').dropdown('refresh');
            // var answerImg = newElement.find('.aysFormeditorAnswerConteiner input.quantumWizTextinputSimpleinputInput').each(function(i){
            //     $(this).attr('name', $html_name_prefix + 'section_add['+ sectionId +'][question]['+ question_length +'][answer]['+ i +'][title]');
            // });

        });

        // Remove Question Button
        $(document).on('click', '.ays-survey-action-delete-question', function(e){
            var $this = $(this);
            var length = $this.parents('.ays-survey-section-questions').find('.ays-survey-question-answer-conteiner').length;
            var status = true;
            if(length == 1){
                swal.fire({
                    type: 'warning',
                    text:'Sorry minimum count of questions should be 1'
                });
                status = false;
            }else{
                if( ! $this.parents('.ays-survey-question-answer-conteiner').hasClass('ays-survey-new-question') ){
                    var qId = $this.parents('.ays-survey-question-answer-conteiner').data('id');
                    var delImp = '<input type="hidden" name="'+ $html_name_prefix +'questions_delete[]" value="'+ qId +'">';
                    $this.parents('form').append( delImp );
                }
                $this.parents('.ays-survey-question-answer-conteiner').remove();
            }

            if (status == false) {
                e.preventDefault();
            }

        });

        // Remove Section Button
        $(document).on('click', '.ays-survey-delete-section', function(e){
            var $this = $(this);

            var parent = $this.parents('.ays-survey-section-box');
            if( ! parent.hasClass('ays-survey-new-section') ){
                var sId = parent.data('id');
                var delImp = '<input type="hidden" name="'+ $html_name_prefix +'sections_delete[]" value="'+ sId +'">';
                $this.parents('form').append( delImp );
            }
            parent.remove();

            var sectionCont = $(document).find('.ays-survey-sections-conteiner');
            var sections = sectionCont.find('.ays-survey-section-box');
            var addQuestionButton = $(document).find('.ays-survey-general-action[data-action="add-question"]');

            var length = sectionCont.find('.ays-survey-section-box').length;
            sections.each(function(i, el){
                $(this).find('.ays-survey-section-number').text(i+1);
                $(this).find('.ays-survey-sections-count').text( sections.length );
            });

            if (length == 1) {
                addQuestionButton.dropdown('dispose');
                addQuestionButton.removeAttr('data-toggle');
                sections.find('.ays-survey-section-head-top').addClass('display_none');
                sections.find('.ays-survey-section-head').removeClass('ays-survey-section-head-topleft-border-none');
                sections.find('.ays-survey-section-actions').addClass('invisible');
            }

            aysSurveySectionsInitToAddQuestions();
        });

        // Remove Answer Image
        $(document).on('click', '.removeAnswerImage', function (e) {
            var $this = $(this);
            $this.parents('.ays-survey-answer-image-container').fadeOut(500);
            setTimeout(function(){
                $this.parents('.ays-survey-answer-image-container').find('.ays-survey-answer-img').removeAttr('src');
                $this.parents('.ays-survey-answer-image-container').find('.ays-survey-answer-img-src').val('');
            }, 500);
        });

        // Survey Question Image actions Buttons
        $(document).on('click', '.ays-survey-question-img-action', function(e){
            var $this = $(this);
            var action = $this.data('action');
            switch( action ){
                case 'edit-image':
                    $this.parents('.ays-survey-question-answer-conteiner').find('.ays-survey-add-question-image').trigger('click');
                break;
                case 'delete-image':
                    $this.parents('.ays-survey-question-image-container').fadeOut(500);
                    setTimeout(function(){
                        $this.parents('.ays-survey-question-image-container').find('.ays-survey-question-img').removeAttr('src');
                        $this.parents('.ays-survey-question-image-container').find('.ays-survey-question-img-src').val('');
                    }, 500);
                break;
            }
        });


        // Survey General actions Buttons
        $(document).on('click', '.ays-survey-general-action', function(e){
            var $this = $(this);
            var action = $this.data('action');
            switch( action ){
                case 'add-question':
                    if(! $this.attr('data-toggle')){
                        var sectionCont = $(document).find('.ays-survey-sections-conteiner');
                        var sections = sectionCont.find('.ays-survey-section-box');
                        aysSurveyAddQuestion( sections.data('id') );
                    }
                break;
                case 'import-question':
                
                break;
                case 'add-section-header':
                
                break;
                case 'add-image':
                
                break;
                case 'add-video':
                
                break;
                case 'add-section':
                    aysSurveyAddSection();
                    aysSurveySectionsInitToAddQuestions();
                break;
            }
        });

        $(document).on('click', '.ays-survey-add-question-into-section', function(e){
            aysSurveyAddQuestion( $(this).data( 'id' ) );
        });

        $(document).on('change', '.ays-survey-question-type' , function(e) {
            var $this = $(this);
            var parent = $this.parents('.ays-survey-section-box');
            var sectionId = parent.attr('data-id');
            var questionId = $this.parents('.ays-survey-question-answer-conteiner').attr('data-id');
            var questionDataName = $this.parents('.ays-survey-question-answer-conteiner').data('name');
            var questionType = $this.aysDropdown('get value'); //$this.val();
            var questionTypeBeforeChange = $this.parents('.ays-survey-question-type-box').find('.ays-survey-check-type-before-change').val();
            var answerIds = $this.parents('.ays-survey-question-answer-conteiner').find('.ays-survey-answers-conteiner .ays-survey-answer-row');
            $this.parents('.ays-survey-question-type-box').find('.ays-survey-check-type-before-change').val(questionType);

            if (answerIds != undefined) {
                answerIds.each(function(e) {
                    var answerId = $(this).data('id');
                    if( ! $(this).hasClass('ays-survey-new-answer') ){
                        var delImp = '<input type="hidden" name="'+ $html_name_prefix +'answers_delete[]" value="'+ answerId +'">';
                        $this.parents('form').append( delImp );
                    }
                });
            }

            switch( questionType ){
                case 'radio':
                    aysSurveyQuestionType_Radio_Checkbox_Select_Html( sectionId , questionId , questionDataName, questionType, questionTypeBeforeChange, false , null );
                break;
                case 'checkbox':
                    aysSurveyQuestionType_Radio_Checkbox_Select_Html( sectionId , questionId , questionDataName, questionType, questionTypeBeforeChange, false , null );
                break;
                case 'select':
                    aysSurveyQuestionType_Radio_Checkbox_Select_Html( sectionId , questionId , questionDataName, questionType, questionTypeBeforeChange, false , null );
                break;
                case 'text':
                    aysSurveyQuestionType_Text_ShortText_Number_Html( sectionId , questionId , questionDataName, questionType, false , null );
                break;
                case 'short_text':
                    aysSurveyQuestionType_Text_ShortText_Number_Html( sectionId , questionId , questionDataName, questionType, false , null );
                break;
                case 'number':
                    aysSurveyQuestionType_Text_ShortText_Number_Html( sectionId , questionId , questionDataName, questionType, false , null );
                break;
                case 'email':
                    aysSurveyQuestionType_Text_ShortText_Number_Html( sectionId , questionId , questionDataName, questionType, false , null );
                break;
                case 'name':
                    aysSurveyQuestionType_Text_ShortText_Number_Html( sectionId , questionId , questionDataName, questionType, false , null );
                break;
                default:
                    aysSurveyQuestionType_Radio_Checkbox_Select_Html( sectionId , questionId , questionDataName, questionType, false , null );
            }
        });

        setTimeout(function(){
            if($(document).find('#ays_survey_custom_css').length > 0){
                if(wp.codeEditor){
                    wp.codeEditor.initialize($(document).find('#ays_survey_custom_css'), cm_settings);
                }
            }
        }, 500);

        $(document).find('a[href="#tab2"]').on('click', function (e) {        
            setTimeout(function(){
                if($(document).find('#ays_survey_custom_css').length > 0){
                    var ays_survey_custom_css = $(document).find('#ays_survey_custom_css').html();
                    if(wp.codeEditor){
                        $(document).find('#ays_survey_custom_css').next('.CodeMirror').remove();
                        wp.codeEditor.initialize($(document).find('#ays_survey_custom_css'), cm_settings);
                        $(document).find('#ays_survey_custom_css').html(ays_survey_custom_css);
                    }
                }
            }, 500);
        });

        $(document).find('#ays_survey_schedule_active, #ays_survey_schedule_deactive').datetimepicker({
            controlType: 'select',
            oneLine: true,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss"
        });




        /////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////ARO END/////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////

        aysSurveySectionsInitToAddQuestions();
        function aysSurveySectionsInitToAddQuestions(){
            var sectionCont = $(document).find('.ays-survey-sections-conteiner');
            var sections = sectionCont.find('.ays-survey-section-box');
            var addQuestionButton = $(document).find('.ays-survey-general-action[data-action="add-question"]');
            var ddmenu = addQuestionButton.parent().find('.dropdown-menu');
            ddmenu.html('');
            sections.each(function(i){
                var buttonItem = '<button class="dropdown-item ays-survey-add-question-into-section" data-id="'+ $(this).data('id') +'" type="button">';
                buttonItem += 'Add into Section '+ (i+1);
                buttonItem += '</button>';
                ddmenu.append(buttonItem);
            });
            if(sections.length > 1){
                addQuestionButton.attr('data-toggle', 'dropdown');
                addQuestionButton.attr('aria-expanded', 'false');
                addQuestionButton.trigger( 'click' );
            }else{
                addQuestionButton.dropdown('dispose');
                addQuestionButton.removeAttr('data-toggle');
            }
        }

        function aysSurveyAddQuestion( sectionId, returnElem = false, sectionElem = null ){
            var section = $(document).find('.ays-survey-sections-conteiner .ays-survey-section-box[data-id="'+sectionId+'"]');
            var cloningElement = $(document).find('.ays-question-to-clone .ays-survey-question-answer-conteiner');
            var clonedElement = cloningElement.clone( true, true );
            // var questionsLength = section.find('.ays-survey-question-answer-conteiner .ays-survey-question-input-box .ays-survey-input[name^="ays_section_add"]').length;
            var questionsLength = section.find('.ays-survey-question-answer-conteiner').length;
            var answers = clonedElement.find('.ays-survey-answers-conteiner .ays-survey-answer-row');

            var questionId = questionsLength + 1;
            var questionName = clonedElement.data('name');
            var sectionName = section.data('name');
            if( sectionElem !== null ){
                sectionName = sectionElem.data('name');
            }

            // Answers ordering jQuery UI
            clonedElement.find('.ays-survey-answers-conteiner').sortable(answerDragHandle);


            clonedElement.addClass('ays-survey-new-question');
            clonedElement.attr('data-id', questionId);
            clonedElement.find('textarea.ays-survey-input').attr('name', newQuestionAttrName( sectionName, sectionId, questionId, 'title'));
            clonedElement.find('select.ays-survey-question-type').attr('name', newQuestionAttrName( sectionName, sectionId, questionId, 'type'));
            clonedElement.find('.ays-survey-question-img-src').attr('name', newQuestionAttrName( sectionName, sectionId, questionId, 'image'));
            clonedElement.find('.ays-survey-other-answer-checkbox').attr('name', newQuestionAttrName( sectionName, sectionId, questionId, 'user_variant'));
            clonedElement.find('.ays-survey-input-required-question').attr('name', newQuestionAttrName( sectionName, sectionId, questionId, 'options', 'required'));

            answers.each(function(){
                var answerId = answers.find('.ays-survey-answer-box input.ays-survey-input').length;
                $(this).attr('data-id', answerId);
                $(this).find('.ays-survey-answer-box input.ays-survey-input').attr('name', newAnswerAttrName( sectionName, sectionId, questionName, questionId, answerId, 'title'));
                $(this).find('.ays-survey-answer-img-src').attr('name', newAnswerAttrName( sectionName, sectionId, questionName, questionId, answerId, 'image'));
            });

            
            clonedElement.find('select.ays-survey-question-type').aysDropdown();

            if( returnElem ){
                return clonedElement;
            }else{
                section.find('.ays-survey-section-questions').append(clonedElement);
            }
        }

        function aysSurveyAddSection(){

            var sectionCont = $(document).find('.ays-survey-sections-conteiner');
            var sections = sectionCont.find('.ays-survey-section-box');
            var sectionsAdd = sectionCont.find('.ays-survey-new-section');

            var section = $(document).find('.ays-question-to-clone .ays-survey-section-box');
            var clonedElement = section.clone( true, true );
            var sectionNewId = sectionsAdd.length + 1;

            clonedElement.attr('data-id', sectionNewId);
            clonedElement.addClass('ays-survey-new-section');
            clonedElement.find('.ays-survey-section-title').attr('name', newSectionAttrName( sectionNewId, 'title' ));
            clonedElement.find('.ays-survey-section-description').attr('name', newSectionAttrName( sectionNewId, 'description' ));
            
            sectionCont.append(clonedElement);
            var question = aysSurveyAddQuestion( sectionNewId, true, clonedElement );
            clonedElement.find('.ays-survey-section-questions').append( question );
            
            clonedElement.find('.ays-survey-section-questions').sortable(questionDragHandle);

            sectionCont = $(document).find('.ays-survey-sections-conteiner');
            sections = sectionCont.find('.ays-survey-section-box');

            clonedElement.find('.ays-survey-section-number').text(sectionCont.find('.ays-survey-section-box').index(clonedElement) + 1);
            sectionCont.find('.ays-survey-section-head-top').removeClass('display_none');
            sectionCont.find('.ays-survey-section-head').addClass('ays-survey-section-head-topleft-border-none');
            sectionCont.find('.ays-survey-sections-count').text( sections.length );
            sectionCont.find('.invisible').removeClass( 'invisible' );
            sectionCont.find('.ays-survey-other-answer-and-actions-row .ays-survey-answer-dlg-dragHandle .ays-survey-icons').addClass( 'invisible' );
            sectionCont.find('.ays-survey-other-answer-and-actions-row .ays-survey-other-answer-delete-icon').addClass( 'invisible' );


        }

        function aysSurveyQuestionType_Radio_Checkbox_Select_Html( sectionId, questionId, questionDataName, questionType, questionTypeBeforeChange, returnElem = false, sectionElem = null ){

            var removeHtml = true; // Remove Html
            if(questionTypeBeforeChange == 'radio' || questionTypeBeforeChange == 'select' || questionTypeBeforeChange == 'checkbox'){
                removeHtml = false;
            }

            var section = $(document).find('.ays-survey-sections-conteiner .ays-survey-section-box[data-id="'+sectionId+'"]');
            var cloningElement = $(document).find('.ays-question-to-clone .ays-survey-question-answer-conteiner .ays-survey-answers-conteiner');
            var cloningElement_2 = $(document).find('.ays-question-to-clone .ays-survey-question-answer-conteiner .ays-survey-other-answer-and-actions-row');

            var clonedElement = cloningElement.clone( true, true );
            var clonedElement_2 = cloningElement_2.clone( true, true );
            
            var answers = clonedElement.find('.ays-survey-answer-row');
            clonedElement.sortable(answerDragHandle);

            var questionName = questionDataName;
            var sectionName = section.data('name');
            if( sectionElem !== null ){
                sectionName = sectionElem.data('name');
            }

            var placeholderVal = '';
            var questionTypeIconClass = '';
            var answer_icon = clonedElement.find('.ays-survey-answer-icon i');
            var other_answer_icon = clonedElement_2.find('.ays-survey-answer-icon i');
            switch( questionType ){
                case 'radio':
                    questionTypeIconClass = 'ays_fa_circle_thin';
                break;
                case 'checkbox':
                    questionTypeIconClass = 'ays_fa_square_o';
                break;
                case 'select':
                    questionTypeIconClass = 'ays_fa_circle_thin';
                break;
                default:
                    questionTypeIconClass = 'ays_fa_circle_thin';
            }

            if (questionType == 'radio' || questionType == 'select') {
                if (other_answer_icon.hasClass('ays_fa_square_o')) {
                    other_answer_icon.removeClass('ays_fa_square_o')
                }
                if (answer_icon.hasClass('ays_fa_square_o')) {
                    answer_icon.removeClass('ays_fa_square_o')
                }
            }else if (questionType == 'checkbox') {
                if (other_answer_icon.hasClass('ays_fa_circle_thin')) {
                    other_answer_icon.removeClass('ays_fa_circle_thin')
                }
                if (answer_icon.hasClass('ays_fa_circle_thin')) {
                    answer_icon.removeClass('ays_fa_circle_thin')
                }
            }

            clonedElement_2.find('.ays-survey-other-answer-checkbox').attr('name', newQuestionAttrName( sectionName, sectionId, questionId, 'user_variant'));
            clonedElement_2.find('.ays-survey-answer-icon i').addClass(questionTypeIconClass);

            var answerId = answers.find('.ays-survey-answer-box input.ays-survey-input').length;
            answers.attr('data-id', answerId);
            answers.find('.ays-survey-answer-box input.ays-survey-input').attr('name', newAnswerAttrName( sectionName, sectionId, questionName, questionId, answerId, 'title'));
            answers.find('.ays-survey-answer-img-src').attr('name', newAnswerAttrName( sectionName, sectionId, questionName, questionId, answerId, 'image'));
            answers.find('.ays-survey-answer-icon i').addClass(questionTypeIconClass);

            if( returnElem ){
                clonedElement = $( clonedElement.html() );
                var clonedElementArr = new Array(clonedElement, clonedElement_2);
                return clonedElementArr;
            }else{
                // Remove Html
                if (removeHtml) {
                    clonedElement = $( clonedElement.html() );
                    section.find('.ays-survey-question-answer-conteiner[data-id="'+questionId+'"] .ays-survey-answers-conteiner').html(clonedElement);
                    var addAnswerRow = section.find('.ays-survey-question-answer-conteiner[data-id="'+questionId+'"]  .ays-survey-other-answer-and-actions-row');
                    clonedElement_2.find('.ays-survey-other-answer-row .ays-survey-answer-icon-box .invisible').removeClass( 'invisible' );
                    addAnswerRow.html(clonedElement_2.html());
                }else{
                    var answer_icon_tags = section.find('.ays-survey-question-answer-conteiner[data-id="'+questionId+'"] .ays-survey-answer-icon i');
                    if (questionType == 'checkbox') {
                        if (answer_icon_tags.hasClass('ays_fa_circle_thin')) {
                            answer_icon_tags.removeClass('ays_fa_circle_thin');
                            answer_icon_tags.addClass('ays_fa_square_o');
                        }
                    }else if(questionType == 'radio' || questionType == 'select'){
                        if (answer_icon_tags.hasClass('ays_fa_square_o')) {
                            answer_icon_tags.removeClass('ays_fa_square_o');
                            answer_icon_tags.addClass('ays_fa_circle_thin');
                        }
                    }
                }
            }
        }

        function aysSurveyQuestionType_Text_ShortText_Number_Html( sectionId, questionId, questionDataName, questionType, returnElem = false, sectionElem = null ){
            var section = $(document).find('.ays-survey-sections-conteiner .ays-survey-section-box[data-id="'+sectionId+'"]');
            var cloningElement = $(document).find('.ays-question-to-clone .ays-survey-question-types');
            var clonedElement = cloningElement.clone( true, true );
            
            var answers = clonedElement.find('.ays-survey-answer-row');

            var questionName = questionDataName;
            var sectionName = section.data('name');
            if( sectionElem !== null ){
                sectionName = sectionElem.data('name');
            }

            var placeholderVal = '';
            var questionTypeClass = '';
            switch( questionType ){
                case 'text':
                    placeholderVal = SurveyMakerAdmin.longAnswerText;
                    questionTypeClass = 'ays-survey-question-type-text-box';
                break;
                case 'short_text':
                    placeholderVal = SurveyMakerAdmin.shortAnswerText;
                    questionTypeClass = 'ays-survey-question-type-short-text-box';
                break;
                case 'number':
                    placeholderVal = SurveyMakerAdmin.numberAnswerText;
                    questionTypeClass = 'ays-survey-question-type-number-box';
                break;
                case 'email':
                    placeholderVal = SurveyMakerAdmin.emailField;
                    questionTypeClass = 'ays-survey-question-type-email-box';
                break;
                case 'name':
                    placeholderVal = SurveyMakerAdmin.nameField;
                    questionTypeClass = 'ays-survey-question-type-name-box';
                break;
                default:
                    placeholderVal = SurveyMakerAdmin.shortAnswerText;
                    questionTypeClass = 'ays-survey-question-type-text-box';
            }

            var answerId = answers.find('input.ays-survey-question-types-input').length;
            answers.attr('data-id', answerId);
            answers.find('input.ays-survey-question-types-input').attr('name', newAnswerAttrName( sectionName, sectionId, questionName, questionId, answerId, 'title'));
            answers.find('input.ays-survey-question-types-input').attr('placeholder', placeholderVal);
            answers.find('input.ays-survey-question-types-input').val(placeholderVal);
            answers.find('.ays-survey-question-types-box').addClass(questionTypeClass);

            if( returnElem ){
                return clonedElement;
            }else{
                section.find('.ays-survey-question-answer-conteiner[data-id="'+questionId+'"] .ays-survey-answers-conteiner').html(clonedElement);
                section.find('.ays-survey-question-answer-conteiner[data-id="'+questionId+'"] .ays-survey-other-answer-and-actions-row').html('');
            }
        }


        function newSectionAttrName(sectionId, field, field2 = null){
            if(field2 !== null){
                return $html_name_prefix + 'section_add['+ sectionId +']['+ field +']['+ field2 +']';
            }
            return $html_name_prefix + 'section_add['+ sectionId +']['+ field +']';
        }

        function newQuestionAttrName(sectionName, sectionId, questionId, field, field2 = null){
            if(field2 !== null){
                return sectionName + '['+ sectionId +'][questions_add]['+ questionId +']['+ field +']['+ field2 +']';
            }
            return sectionName + '['+ sectionId +'][questions_add]['+ questionId +']['+ field +']';
        }

        function newAnswerAttrName( sectionName, sectionId, questionName, questionId, answerId, field, field2 = null){
            if(field2 !== null){
                return sectionName + '['+ sectionId +']['+ questionName +']['+ questionId +'][answers_add]['+ answerId +']['+ field +']['+ field2 +']';
            }
            return sectionName + '['+ sectionId +']['+ questionName +']['+ questionId +'][answers_add]['+ answerId +']['+ field +']';
        }


        $(document).find('#ays_select_surveys').select2({
            allowClear: true,
            placeholder: false
        });

        $(document).find('.ays-survey-sections-conteiner .ays-survey-question-type').aysDropdown({
            // allowClear: true,
            // placeholder: false
        });

        var heart_interval = setInterval(function () {
            $(document).find('.ays-survey-maker-wrapper i.ays_fa').toggleClass('ays_survey_pulse');
        }, 1000);

        // ===============================================================
        // ======================      Ani      ==========================
        // ===============================================================

        var count = 0;
        $(document).find('.ays_survey_previous_next').on('click',function(){
            if($(this).attr('data-name') == 'ays_survey_next'){
                if($(document).find('.ays_number_of_result').val() == $(document).find('.ays_number_of_result').attr('max')){
                    count = $(document).find('.ays_number_of_result').attr('min');
                    $(document).find('.ays_number_of_result').val(count);
                }else{
                    var selectVal = parseInt($(document).find('.ays_number_of_result').val());
                    count = selectVal + 1;
                    $(document).find('.ays_number_of_result').val(count);
                }
            }else if($(this).attr('data-name') == 'ays_survey_previous'){
                if($(document).find('.ays_number_of_result').val() == $(document).find('.ays_number_of_result').attr('min')){
                    count = $(document).find('.ays_number_of_result').attr('max');
                    $(document).find('.ays_number_of_result').val(count);
                }else{
                    var selectVal = parseInt($(document).find('.ays_number_of_result').val());
                    count = selectVal - 1;
                    $(document).find('.ays_number_of_result').val(count);
                }
            }
            $(document).find('.ays_number_of_result').trigger('change');
        });
        
        $(document).find('.ays_number_of_result').on('change', refreshSubmissionData);
        // $(document).find('.ays_survey_previous_next').on('click', refreshSubmissionData);

        function refreshSubmissionData(){
            var submissionPrevVal;
            var parent = $(this).parents('.ays_survey_previous_next_conteiner');
            var submissionIdStr = parent.find('.ays_submissions_id_str').val();
            var submissionIdArr = submissionIdStr.split(",");
            var submissionElVal = parseInt(parent.find('.ays_number_of_result').val());
            var surveyId = $(document).find('.ays_number_of_result').attr('data-id');
            var submissionId = '';
            var data = {};
            
            if(submissionElVal < 0){
                submissionElVal = 1;
                parseInt(parent.find('.ays_number_of_result').val(1));
            }else if(submissionElVal > parseInt(parent.find('.ays_number_of_result').attr('max'))){
                var maxVal = parseInt(parent.find('.ays_number_of_result').attr('max'));
                parseInt(parent.find('.ays_number_of_result').val(maxVal));
                submissionElVal = maxVal;
            }
            
            if(submissionElVal>submissionPrevVal || submissionElVal+1){
                submissionId = submissionIdArr[submissionElVal-1];
            }else{
                submissionId = submissionIdArr[submissionElVal+1];
            } 
            
            data.action = 'ays_survey_submission_report';
            data.submissionId = submissionId;
            data.surveyId = surveyId;
            var preloader = $(this).parents('.ays_survey_container_each_result').find('.question_result_container').find('div.ays_survey_preloader');
            preloader.css({'display':'flex'});
            $.ajax({
                url: ajaxurl,
                dataType: 'json',
                data: data,
                method: 'post',
                success: function(response){
                    if (response.status) {
                        preloader.css({'display':'none'});
                        var questionsData = response.questions;
                        var questionsInHTML = $(document).find('.ays_questions_answers');
                        $.each(questionsInHTML, function(){
                            var question = $(this);
                            var qId = question.data('id');
                            var qType = question.data('type');
                            
                            question.find('.ays_each_question_answer input[type="radio"]').removeAttr('checked');
                            question.find('.ays_each_question_answer input[type="checkbox"]').removeAttr('checked');
                            question.find('.ays_each_question_answer .ays-survey-submission-select option').removeAttr('selected');
                            question.find('.ays_text_answer').html('');

                            if( typeof questionsData[qId] != 'undefined'){
                                var surveyAnswer = questionsData[qId];
                                switch( qType ){
                                    case 'radio':
                                        question.find('.ays_each_question_answer input[type="radio"]').removeAttr('checked');
                                        question.find('.ays_each_question_answer input[type="radio"]').each(function(){
                                            if( surveyAnswer == $(this).data('id') ){
                                                $(this).prop('checked', true);
                                            }
                                        });
                                        break;
                                    case 'checkbox':
                                        question.find('.ays_each_question_answer input[type="checkbox"]').removeAttr('checked');
                                        question.find('.ays_each_question_answer input[type="checkbox"]').each(function(){
                                            for(var i=0; i < surveyAnswer.length; i++){
                                                if( surveyAnswer[i] == $(this).data('id') ){
                                                    $(this).prop('checked', true);
                                                }
                                            }
                                        });
                                        break;
                                    case 'select':
                                        // question.find('.ays_each_question_answer .ays-survey-submission-select').aysDropdown('clear');
                                        // question.find('.ays_each_question_answer .ays-survey-submission-select').aysDropdown('set selected', surveyAnswer);
                                        question.find('.ays_each_question_answer .ays-survey-submission-select option').removeAttr('selected');
                                        question.find('.ays_each_question_answer .ays-survey-submission-select option').each(function(){
                                            if( surveyAnswer == $(this).attr('value') ){
                                                $(this).prop('selected', true);
                                            }
                                        });
                                        break;
                                    case 'text':
                                    case 'short_text':
                                    case 'number':
                                    case 'name':
                                    case 'email':
                                        var elem = question.find('.ays_text_answer');
                                        elem.html( surveyAnswer );
                                        break;
                                }
                            }
                        });
                    }
                }
            });
            submissionPrevVal = submissionElVal;
        }

    });

})( jQuery );
