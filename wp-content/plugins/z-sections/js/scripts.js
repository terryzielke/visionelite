jQuery(document).ready(function($) {

    // if .z-sections has a gx-5, gx-4, gx-3, gx-2, gx-1, gx-0 class, add it to the child .row element
    $('.z-section').each(function() {
        var $this = $(this);
        var gxClass = $this.attr('class').match(/gx-\d/);
        if (gxClass) {
            $this.find('.row').addClass(gxClass[0]);
        }
    });

});