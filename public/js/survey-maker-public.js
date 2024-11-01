(function( $ ) {
	'use strict';

    $(document).ready(function () {
		
		$(document).find('.ays-survey-container').AysSurveyMaker();
		
		var questionTypeText = $(document).find('textarea.ays-survey-question-input-textarea');
		autosize(questionTypeText);

		var questionTypeSelect = $(document).find('.ays-survey-question-select');
		
        questionTypeSelect.each(function(){
			$(this).dropdown({
				duration: 150,
				transition: 'scale'
			});
		});
		
        // questionTypeSelect.select2({
        //     placeholder: aysSurveyLangObj.choose,
        // });

	});

})( jQuery );
