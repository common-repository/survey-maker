(function($){
    'use strict';
    $(document).ready(function(){

        var defaultColors = {
            classicLight: {
                surveyColor: "rgb(255, 87, 34)",
                bgColor: "#ffffff",
                textColor: "#333",
                buttonsTextColor: "#333",
            },
            classicDark: {
                surveyColor: "rgb(255, 87, 34)",
                bgColor: "#ffffff",
                textColor: "#333",
                buttonsTextColor: "#333",
            }
        };
        
        
        var defaultTextColor, defaultBgColor, defaultSurveyColor, defaultButtonsTextColor;
        var SurveyTheme = $(document).find('#ays_survey_theme').val();
        switch ( SurveyTheme ) {
            case 'classic_dark':
                defaultSurveyColor = defaultColors.classicDark.surveyColor;
                defaultBgColor = defaultColors.classicDark.bgColor;
                defaultTextColor = defaultColors.classicDark.textColor;
                defaultButtonsTextColor = defaultColors.classicDark.buttonsTextColor;
                break;
            case 'classic_light':
                defaultSurveyColor = defaultColors.classicLight.surveyColor;
                defaultBgColor = defaultColors.classicLight.bgColor;
                defaultTextColor = defaultColors.classicLight.textColor;
                defaultButtonsTextColor = defaultColors.classicLight.buttonsTextColor;
                break;
            default:
                defaultSurveyColor = defaultColors.classicLight.surveyColor;
                defaultBgColor = defaultColors.classicLight.bgColor;
                defaultTextColor = defaultColors.classicLight.textColor;
                defaultButtonsTextColor = defaultColors.classicLight.buttonsTextColor;
                break;
        }

        var ays_survey_color_picker = {
            defaultColor: defaultSurveyColor,
            change: function (e) {
            }
        };
                
        var ays_survey_background_color_picker = {
            defaultColor: defaultBgColor,
            change: function (e) {
            }
        };

        var ays_survey_text_color_picker = {
            defaultColor: defaultTextColor,
            change: function (e) {
            }
        };

        var ays_survey_buttons_text_color_picker = {
            defaultColor: defaultButtonsTextColor,
            change: function (e) {
            }
        };

        
        // Initialize color pickers
        $(document).find('#ays_survey_color').wpColorPicker(ays_survey_color_picker);
        $(document).find('#ays_survey_background_color').wpColorPicker(ays_survey_background_color_picker);
        $(document).find('#ays_survey_text_color').wpColorPicker(ays_survey_text_color_picker);
        $(document).find('#ays_survey_buttons_text_color').wpColorPicker(ays_survey_buttons_text_color_picker);


        // Theme select
        // aysSurveyRefreshLivePreview()
        // $(document).find('#ays_survey_theme').on('change', function () {
        //     console.log($(this));
        //     var SurveyTheme = $(this).val();
        //     var bg_image_url = '';
        //     var defaultTextColor, defaultBgColor, defaultQuizColor, defaultButtonsTextColor;
        //     switch ( SurveyTheme ) {
        //         case 'classic_dark':
        //             defaultSurveyColor = defaultColors.classicDark.surveyColor;
        //             defaultBgColor = defaultColors.classicDark.bgColor;
        //             defaultTextColor = defaultColors.classicDark.textColor;
        //             defaultButtonsTextColor = defaultColors.classicDark.buttonsTextColor;
        //             break;
        //         case 'classic_light':
        //             defaultSurveyColor = defaultColors.classicLight.surveyColor;
        //             defaultBgColor = defaultColors.classicLight.bgColor;
        //             defaultTextColor = defaultColors.classicLight.textColor;
        //             defaultButtonsTextColor = defaultColors.classicLight.buttonsTextColor;
        //             break;
        //         default:
        //             defaultSurveyColor = defaultColors.classicLight.surveyColor;
        //             defaultBgColor = defaultColors.classicLight.bgColor;
        //             defaultTextColor = defaultColors.classicLight.textColor;
        //             defaultButtonsTextColor = defaultColors.classicLight.buttonsTextColor;
        //             break;
        //     }

        //     var ays_survey_color_picker = {
        //         defaultColor: defaultSurveyColor,
        //         change: function (e) {
        //             $(document).find('#ays_survey_color').val(defaultSurveyColor);
        //         }
        //     };
                    
        //     var ays_survey_background_color_picker = {
        //         defaultColor: defaultBgColor,
        //         change: function (e) {
        //             $(document).find('#ays_survey_background_color').val(defaultBgColor);
        //         }
        //     };

        //     var ays_survey_text_color_picker = {
        //         defaultColor: defaultTextColor,
        //         change: function (e) {
        //             $(document).find('#ays_survey_text_color').wpColorPicker(defaultTextColor);
        //         }
        //     };

        //     var ays_survey_buttons_text_color_picker = {
        //         defaultColor: defaultButtonsTextColor,
        //         change: function (e) {
        //             $(document).find('#ays_survey_buttons_text_color').wpColorPicker(defaultButtonsTextColor);
        //         }
        //     };
            
        //     // Initialize color pickers
        //     $(document).find('#ays_survey_color').wpColorPicker(ays_survey_color_picker);
        //     $(document).find('#ays_survey_background_color').wpColorPicker(ays_survey_background_color_picker);
        //     $(document).find('#ays_survey_text_color').wpColorPicker(ays_survey_text_color_picker);
        //     $(document).find('#ays_survey_buttons_text_color').wpColorPicker(ays_survey_buttons_text_color_picker);

        //     // aysSurveyRefreshLivePreview();

        // });
        

        // $(document).find('input[name="ays_quiz_theme"],#ays-quiz-color,#ays-quiz-text-color,#ays-quiz-buttons-text-color, #ays_answers_view, #ays_answers_padding, #ays_answers_font_size,'+
        //     '#ays_answers_border, #ays_answers_border_width, #ays_answers_border_style, #ays_answers_box_shadow,'+
        //     '#ays_show_answers_caption, #ays_answers_margin, #ays_ans_rw_icon_preview, #ays_wrong_icon_preview, input[name="ays_ans_right_wrong_icon"], '+
        //     '#ays_buttons_font_size, #ays_buttons_top_bottom_padding, #ays_buttons_left_right_padding, #ays_buttons_border_radius, '+
        //     '#ays_ans_img_height, #ays_ans_img_caption_position, #ays_ans_img_caption_style, #ays_buttons_position, #ays_answers_object_fit').on('change', function(e){
        //     aysSurveyRefreshLivePreview();
        // });
        // // aysSurveyRefreshLivePreview();

        // function aysSurveyRefreshLivePreview(){
        //     let liveCSS = $(document).find('#ays_live_custom_css');
        //     let answersCSS = '';
        //     let answersCont = $(document).find('.ays-quiz-answers');
        //     let answersImagesCont = $(document).find('.answers-image-container .ays-quiz-answers');
        //     let answersField = $(document).find('.ays-quiz-answers .ays-field');

        //     let quizTheme = $(document).find('input[name="ays_quiz_theme"]:checked').val();
        //     $(document).find('.ays-quiz-live-container-answers').removeClass('ays_quiz_elegant_dark');
        //     $(document).find('.ays-quiz-live-container-answers').removeClass('ays_quiz_elegant_light');
        //     $(document).find('.ays-quiz-live-container-answers').removeClass('ays_quiz_rect_dark');
        //     $(document).find('.ays-quiz-live-container-answers').removeClass('ays_quiz_rect_light');
        //     switch(quizTheme){
        //         case "elegant_dark":
        //             quizTheme = 'ays_quiz_elegant_dark';
        //         break;
        //         case "elegant_light":
        //             quizTheme = 'ays_quiz_elegant_light';
        //         break;
        //         case "rect_dark":
        //             quizTheme = 'ays_quiz_rect_dark';
        //         break;
        //         case "rect_light":
        //             quizTheme = 'ays_quiz_rect_light';
        //         break;
        //         default:
        //             quizTheme = '';
        //     }
        //     if(quizTheme != ''){
        //         $(document).find('.ays-quiz-live-container-answers').addClass(quizTheme);
        //     }

        //     let viewType = $(document).find('#ays_answers_view').val();
        //     let showCaption = $(document).find('#ays_show_answers_caption').prop('checked');
        //     let captionPosition = $(document).find('#ays_ans_img_caption_position').val();
        //     let captionStyle = $(document).find('#ays_ans_img_caption_style').val();
        //     let imageHeight = $(document).find('#ays_ans_img_height').val();
        //     let answerObjectFit = $(document).find('#ays_answers_object_fit').val();

        //     let answersBorder = $(document).find('#ays_answers_border').prop('checked');
        //     let answersBoxShadow = $(document).find('#ays_answers_box_shadow').prop('checked');
        //     let answersBorderWidth = $(document).find('#ays_answers_border_width').val();
        //     let answersBorderStyle = $(document).find('#ays_answers_border_style').val();
        //     let answersBorderColor = $(document).find('#ays_answers_border_color').val();
        //     let answersBoxShadowColor = $(document).find('#ays_answers_box_shadow_color').val();

        //     let answersPadding = $(document).find('#ays_answers_padding').val();
        //     let answersMargin = $(document).find('#ays_answers_margin').val();
        //     let answersFontSize = $(document).find('#ays_answers_font_size').val();
        //     let AnswersRWIcon = $(document).find('input[name="ays_ans_right_wrong_icon"]:checked').val();
        //     let AnswersRIcon = $(document).find('input[name="ays_ans_right_wrong_icon"]:checked').next('.right_icon').attr('src');
        //     let AnswersWIcon = $(document).find('input[name="ays_ans_right_wrong_icon"]:checked').nextAll('.wrong_icon').attr('src');
        //     let showAnswersRWIcons = $(document).find('#ays_ans_rw_icon_preview').prop('checked');
        //     let showWrongIcons = $(document).find('#ays_wrong_icon_preview').prop('checked');

        //     let quizColor = $(document).find('#ays-quiz-color').val();
        //     let quizBgColor = $(document).find('#ays-quiz-bg-color').val();
        //     let quizTextColor = $(document).find('#ays-quiz-text-color').val();

        //     let buttonsPosition = $(document).find('#ays_buttons_position').val();
        //     let buttonsFontSize = $(document).find('#ays_buttons_font_size').val();
        //     let buttonsLeftRightPadding = $(document).find('#ays_buttons_left_right_padding').val();
        //     let buttonsTopBottomPadding = $(document).find('#ays_buttons_top_bottom_padding').val();
        //     let buttonsBorderRadius = $(document).find('#ays_buttons_border_radius').val();


        //     $(document).find('.ays-quiz-live-container .ays_buttons_div').css('justify-content', buttonsPosition);
        //     $(document).find('.ays_buttons_div input[name="next"]').css('font-size', buttonsFontSize + 'px');
        //     $(document).find('.ays_buttons_div input[name="next"]').css('padding', buttonsTopBottomPadding+'px '+ buttonsLeftRightPadding+'px');
        //     $(document).find('.ays_buttons_div input[name="next"]').css('border-radius', buttonsBorderRadius + 'px');

        //     answersImagesCont.find('.ays-field .ays-answer-image').css('object-fit', answerObjectFit);

        //     if(showAnswersRWIcons){
        //         $(document).find('.ays-quiz-answers .ays-field label').addClass('answered');
        //     }else{
        //         $(document).find('.ays-quiz-answers .ays-field label').removeClass('answered');
        //     }

        //     if(! showCaption){
        //         answersImagesCont.find('.ays-field input+label').addClass('display_none_imp');
        //     }else{
        //         answersImagesCont.find('.ays-field input+label').removeClass('display_none_imp');
        //     }

        //     if(viewType == 'list'){

        //         if(captionStyle == 'inside'){
        //             if(captionPosition == 'top'){
        //                 answersImagesCont.find('.ays-field input+label[for^="ays-answer-"]').css({
        //                     'position': 'initial',
        //                     'top': '0',
        //                     'bottom': 'unset',
        //                     'opacity': '1',
        //                 });
        //             }else if(captionPosition == 'bottom'){
        //                 answersImagesCont.find('.ays-field input+label[for^="ays-answer-"]').css({
        //                     'position': 'initial',
        //                     'top': 'unset',
        //                     'bottom': '0',
        //                     'opacity': '1',
        //                 });
        //             }
        //         }

        //         answersCont.removeClass('ays_grid_view_container');
        //         answersCont.addClass('ays_list_view_container');
        //         answersField.removeClass('ays_grid_view_item');
        //         answersField.addClass('ays_list_view_item');

        //         if(captionPosition == 'top'){
        //             $(document).find('.ays-field.ays_list_view_item').css({
        //                 'flex-direction': 'row'
        //             });
        //         }else if(captionPosition == 'bottom'){
        //             $(document).find('.ays-field.ays_list_view_item').css({
        //                 'flex-direction': 'row-reverse'
        //             });
        //         }

        //     }else if(viewType == 'grid'){

        //         answersCont.removeClass('ays_list_view_container');
        //         answersCont.addClass('ays_grid_view_container');
        //         answersField.removeClass('ays_list_view_item');
        //         answersField.addClass('ays_grid_view_item');

        //         if(captionStyle == 'outside'){
        //             if(captionPosition == 'top'){
        //                 answersImagesCont.find('.ays-field input+label[for^="ays-answer-"]').css({
        //                     'position': 'initial',
        //                     'top': '0',
        //                     'bottom': 'unset',
        //                     'opacity': '1',
        //                 });
        //             }else if(captionPosition == 'bottom'){
        //                 answersImagesCont.find('.ays-field input+label[for^="ays-answer-"]').css({
        //                     'position': 'initial',
        //                     'top': 'unset',
        //                     'bottom': '0',
        //                     'opacity': '1',
        //                 });
        //             }
        //         }else if(captionStyle == 'inside'){
        //             if(captionPosition == 'top'){
        //                 answersImagesCont.find('.ays-field input+label[for^="ays-answer-"]').css({
        //                     'position': 'absolute',
        //                     'top': '0',
        //                     'bottom': 'unset',
        //                     'opacity': '.5',
        //                 });
        //             }else if(captionPosition == 'bottom'){
        //                 answersImagesCont.find('.ays-field input+label[for^="ays-answer-"]').css({
        //                     'position': 'absolute',
        //                     'top': 'unset',
        //                     'bottom': '0',
        //                     'opacity': '.5',
        //                 });
        //             }
        //         }

        //         switch(captionPosition){
        //             case "bottom":
        //                 answersImagesCont.find('.ays-field.ays_grid_view_item').css({
        //                     'flex-direction': 'column-reverse'
        //                 });
        //             break;
        //             case "top":
        //                 answersImagesCont.find('.ays-field.ays_grid_view_item').css({
        //                     'flex-direction': 'column'
        //                 });
        //             break;
        //         }
        //     }

        //     if(answersBorder){
        //         $(document).find('.ays-quiz-answers .ays-field').css({
        //             'border-width': answersBorderWidth+'px',
        //             'border-style': answersBorderStyle,
        //             'border-color': answersBorderColor,
        //         });

        //     }else{
        //         $(document).find('.ays-quiz-answers .ays-field').css({
        //             'border-width': '0px',
        //             'border-style': 'none',
        //             'border-color': 'none',
        //         });
        //     }

        //     if(answersBoxShadow){
        //         $(document).find('.ays-quiz-answers .ays-field').css({
        //             'box-shadow': '0px 0px 10px ' + answersBoxShadowColor,
        //         });
        //     }else{
        //         $(document).find('.ays-quiz-answers .ays-field').css({
        //             'box-shadow': 'none',
        //         });
        //     }

        //     $(document).find('.ays-quiz-answers .ays-field .ays-answer-image').css({
        //         'height': imageHeight+'px',
        //     });
        //     $(document).find('.ays-quiz-answers .ays-field label').css({
        //         'font-size': answersFontSize + 'px'
        //     });
        //     $(document).find('.ays-quiz-answers .ays-field').css({
        //         'margin-bottom': answersMargin + 'px'
        //     });
        //     $(document).find('.ays-quiz-answers .ays-field.ays_grid_view_item').css({
        //         'width': 'calc(50% - ' + (answersMargin / 2) + 'px)',
        //     });
        //     $(document).find('.ays-quiz-answers .ays-field.ays_list_view_item').css({
        //         'width': '100%',
        //     });
        //     $(document).find('.ays-quiz-answers .ays-field.ays_grid_view_item:nth-child(odd)').css({
        //         'margin-right': (answersMargin / 2) + 'px',
        //     });

        //     answersCSS = '.ays-quiz-answers .ays-field input~label[for^="ays-answer-"] {'+
        //             'padding: ' + answersPadding + 'px !important;'+
        //             'color: '+ quizTextColor +';'+
        //         '}'+
        //         '.ays-quiz-live-container .ays-field input:checked~label:hover {'+
        //             'background-color: '+ quizColor +';'+
        //         '}'+
        //         '.ays-quiz-live-container .ays-field input:checked~label {'+
        //             'background-color: '+ quizColor +';'+
        //         '}';

        //     if(quizTheme == '' || quizTheme == 'elegant_dark' || quizTheme == 'elegant_light'){
        //         answersCSS += '.ays-quiz-live-container .ays-field {'+
        //             'background-color: transparent;'+
        //         '}';
        //     }else{
        //         answersCSS += '.ays-quiz-live-container .ays-field {'+
        //             'background-color: '+ quizColor +';'+
        //         '}';
        //     }
        //     answersCSS += '.ays-quiz-live-container .ays-field:hover,'+
        //         '.ays-quiz-live-container .ays-field:hover label {'+
        //             'background-color: '+ quizColor +';'+
        //             'color: '+ quizTextColor +';'+
        //         '}';
        //     let answerIcon = AnswersRIcon;
        //     if(showWrongIcons){
        //         answerIcon = AnswersWIcon;
        //     }
        //     if(showAnswersRWIcons){
        //         if(AnswersRWIcon == 'style-9'){

        //             answersCSS += '#step1 .ays-quiz-answers .ays-field label[for^="ays-answer-"]:first-of-type::after {'+
        //                 'content: url("' + answerIcon + '") !important;'+
        //                 'position: relative;'+
        //                 'top: -12px;'+
        //             '}'+
        //             '#step2 .ays-quiz-answers .ays-field label[for^="ays-answer-"]:last-of-type::after {'+
        //                 'content: url("' + answerIcon + '") !important;'+
        //                 'height: auto;'+
        //                 'position: absolute;';
        //                 if(captionPosition == 'top'){
        //                     answersCSS += 'bottom: ' + (parseInt(answersPadding)+5) + 'px;';
        //                 }else{
        //                     answersCSS += 'top: ' + (parseInt(answersPadding)+5) + 'px;';
        //                 }
        //                 answersCSS += 'left: '+ (parseInt(answersPadding)+5) +'px;'+
        //             '}';
        //         }else{

        //             answersCSS += '#step1 .ays-quiz-answers .ays-field label[for^="ays-answer-"]:first-of-type::after {'+
        //                 'content: url("' + answerIcon + '") !important;'+
        //             '}'+
        //             '#step2 .ays-quiz-answers .ays-field label[for^="ays-answer-"]:last-of-type::after {'+
        //                 'content: url("' + answerIcon + '") !important;'+
        //                 'height: auto;'+
        //                 'position: absolute;';
        //                 if(captionPosition == 'top'){
        //                     answersCSS += 'bottom: ' + (parseInt(answersPadding)+5) + 'px;';
        //                 }else{
        //                     answersCSS += 'top: ' + (parseInt(answersPadding)+5) + 'px;';
        //                 }
        //                 answersCSS += 'left: '+ (parseInt(answersPadding)+5) +'px;'+
        //             '}';
        //         }
        //     }else{
        //         answersCSS += '#step1 .ays-quiz-answers .ays-field label.answered[for^="ays-answer-"]::after,'+
        //             '#step2 .ays-quiz-answers .ays-field label.answered[for^="ays-answer-"]::after {'+
        //             'content: none!important;'+
        //         '}';
        //     }

        //     liveCSS.html('');
        //     liveCSS.html(liveCSS.html() + answersCSS);
        // }

        $(document).find('#ays_buttons_size').on('change', function(e){
            let buttonsSize = $(document).find('#ays_buttons_size').val();
            let buttonsFontSize,
                buttonsLeftRightPadding,
                buttonsTopBottomPadding,
                buttonsBorderRadius;

            switch(buttonsSize){
                case "small":
                    buttonsFontSize = 14;
                    buttonsLeftRightPadding = 14;
                    buttonsTopBottomPadding = 7;
                    buttonsBorderRadius = 3;
                break;
                case "large":
                    buttonsFontSize = 20;
                    buttonsLeftRightPadding = 30;
                    buttonsTopBottomPadding = 13;
                    buttonsBorderRadius = 3;
                break;
                default:
                    buttonsFontSize = 17;
                    buttonsLeftRightPadding = 20;
                    buttonsTopBottomPadding = 10;
                    buttonsBorderRadius = 3;
                break;
            }

            $(document).find('#ays_buttons_font_size').val(buttonsFontSize);
            $(document).find('#ays_buttons_left_right_padding').val(buttonsLeftRightPadding);
            $(document).find('#ays_buttons_top_bottom_padding').val(buttonsTopBottomPadding);
            $(document).find('#ays_buttons_border_radius').val(buttonsBorderRadius);

            $(document).find('.ays_buttons_div input[name="next"]').css('font-size', buttonsFontSize + 'px');
            $(document).find('.ays_buttons_div input[name="next"]').css('padding', buttonsTopBottomPadding+'px '+ buttonsLeftRightPadding+'px');
            $(document).find('.ays_buttons_div input[name="next"]').css('border-radius', buttonsBorderRadius + 'px');
        });

    });
})(jQuery);
