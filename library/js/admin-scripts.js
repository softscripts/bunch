jQuery(document).ready(function($){

var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;

  jQuery('.meta_upload').click(function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = $(this);
    var id = button.attr('id').replace('button_', '');
    _custom_media = true;
    wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {
        $("#"+id).val(attachment.url);
      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }

    wp.media.editor.open(button);
    return false;
  });


var myOptions = {
    // you can declare a default color here,
    // or in the data-default-color attribute on the input
    defaultColor: false,
    // a callback to fire whenever the color changes to a valid color
    change: function(event, ui){},
    // a callback to fire when the input is emptied or an invalid color
    clear: function() {},
    // hide the color picker controls on load
    hide: true,
    // show a group of common colors beneath the square
    // or, supply an array of colors to customize further
    palettes: true
};

    jQuery('.colorpicker-field').wpColorPicker(myOptions);

	jQuery('.theme-option-tabs a').click(function(){
		var hash = jQuery(this).attr('href');
		jQuery(this).parent().children('a').removeClass('nav-tab-active');
		jQuery(this).addClass('nav-tab-active');
		jQuery('.theme-options-tabs').removeClass('current');
		jQuery(hash+'-tab').addClass('current');
		return false;
	});

	jQuery('.theme-options-updated').delay(800).fadeOut(1000);

});
