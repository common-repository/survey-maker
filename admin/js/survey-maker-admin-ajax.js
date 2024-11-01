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
    
    $.fn.aysModal = function(action){
        let $this = $(this);
        switch(action){
            case 'hide':
                $(this).find('.ays-modal-content').css('animation-name', 'zoomOut');
                setTimeout(function(){
                    $(document.body).removeClass('modal-open');
                    $(document).find('.ays-modal-backdrop').remove();
                    $this.hide();
                }, 250);
            break;
            case 'show': 
            default:
                $this.show();
                $(this).find('.ays-modal-content').css('animation-name', 'zoomIn');
                $(document).find('.modal-backdrop').remove();
                $(document.body).append('<div class="ays-modal-backdrop"></div>');
                $(document.body).addClass('modal-open');
            break;
        }
    };
    
})( jQuery );