/**
 * Ajax Manager : one instance
 * Written like a class to have 'this' referencing itself, even if moved to an attribute of a higher manager
 */

var AjaxManager,
    ajaxManager = new(AjaxManager = function() {

    var show_mask = function() {
        jQuery('#opaque_screen').height( jQuery(document).height() );

        jQuery(window)
            .scroll(position_wait_anim)
            .resize(position_wait_anim);
        jQuery('#opaque_screen').show();
        jQuery(window).resize();
    };

    var hide_mask = function() {
        jQuery(window).unbind('scroll',position_wait_anim).unbind('resize',position_wait_anim);
        jQuery('#opaque_screen').hide();
    };

    var position_wait_anim = function(){
        jQuery('#wait_anim').center_on_screen();
    };

    this.ajax = function(options, container, form) {
        if (container && container == 'show_mask') show_mask();

        if (options.type == undefined) options.type = 'POST';
        if (options.dataType == undefined) options.dataType = 'json';

        // pointeurs sur les diffÃ©rentes mÃ©thodes fournies en paramÃ¨tres
        var success      = options.success;
        var error        = options.error;
        var complete     = options.complete;
        var beforeSend   = options.beforeSend;

        //surcharge de la fonction beforeSend
        options.beforeSend = function(jqXHR, settings) {
            if (typeof beforeSend == "function") return beforeSend(jqXHR, settings);
        };

        //surcharge de la fonction success
        options.success = function(data, textStatus, jqXHR){
            if (typeof success == "function") success(data, textStatus, jqXHR);
        };

        //surcharge de la fonction error
        options.error = function(jqXHR, textStatus, errorThrown) {
            if (typeof error == "function") error(jqXHR, textStatus, errorThrown);
        };

        //surcharge de la fonction complete
        options.complete = function(jqXHR, textStatus) {
            if (container && container == 'show_mask') hide_mask();
            if (typeof complete == "function") complete(jqXHR, textStatus);
        };

        // si un pointeur sur formulaire est fourni, on valide ce formulaire
        return form ? jQuery('#' + form).ajaxSubmit(options)
        // sinon on lance la requÃªte ajax
            : jQuery.ajax(options);
    };

    /**
     * @augments elementClicked the element that click will be bind
     * @augments url the url for ajax call
     * @augments dataType The format response from ajax call
     * @return false to block the native click function
     */
    this.popin = function(elementClicked, url, dataType) {
        var that = this;
        // options checks
        if (dataType == undefined) {dataType = 'html';}

        $(document).off("."+elementClicked);
        $(document).on("click."+elementClicked, elementClicked, function() {

            that.ajax({
                url: url == undefined ? $(elementClicked).attr('href') : url,
                dataType: dataType,
                success: function(data) {

                    if (data == undefined) {
                        data = 'test';
                    }
                    if ($.nmTop() !== undefined) {
                        $.nmTop().close();
                    }
                    $.nmData(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    $.nmData('error ajax :' + textStatus);
                }
            });

            return false;
        });
    };

});

(function($){
    $.fn.center_on_screen = function() {
       return this.each(function() {
           $(this).css('position','absolute')
                  .css('top',$(window).scrollTop()+($(window).height() - $(this).height() )/2)
                  .css('left',$(window).scrollLeft()+($(window).width() - $(this).width() )/2);
       });
    };
})(jQuery);