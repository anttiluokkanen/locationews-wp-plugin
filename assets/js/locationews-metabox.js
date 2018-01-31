(function ($) {

  $(function() {
    
    $.fn.invisible = function() {
      return this.each(function() {
        $(this).css('visibility', 'hidden');
      });
    };

    $.fn.visible = function() {
      return this.each(function() {
        $(this).css('visibility', 'visible');
      });
    };
    
    var post_type              = locationews_metabox_init.post_type;
    var display_metabox_always = locationews_metabox_init.display_metabox_always;
    var display_metabox        = locationews_metabox_init.display_metabox;
    var catids                 = locationews_metabox_init.catids;

    // Bootstrap checkbox
    $('[type="checkbox"].locationews').bootstrapSwitch();

    if ( post_type != 'page' && 1 != display_metabox_always ) {
      // Set metabox invisible by default
      $('#locationews').invisible();

      $( document ).on( 'click', '#categorychecklist input[type="checkbox"]', function() {
        if ( 1 != display_metabox ) {
          $('#locationews').invisible();
        }
        $('#categorychecklist input[type="checkbox"]').each( function( i, e ) {
          var id = $(this).attr('id').match(/-([0-9]*)$/i);
          id = ( id && id[1] ) ? parseInt( id[1] ) : null ;

          if ( $.inArray( id, catids ) > -1 && $(this).is(':checked') ) {
            $('#locationews').visible();
          }
        });
      });
    }
    if ( 1 == display_metabox ) {
      $('#locationews').visible();
    }

  });

})(jQuery);
