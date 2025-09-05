jQuery(document).ready(function($){
    var frame;
    $('#unmnmnc_gallery_button').on('click', function(e){
        e.preventDefault();
        if(frame) frame.open();
        frame = wp.media({
            title: 'Select or Upload Images',
            button: { text: 'Use these images' },
            multiple: true
        });
        frame.on('select', function(){
            var selection = frame.state().get('selection');
            var ids = [];
            var html = '';
            selection.map(function(attachment){
                attachment = attachment.toJSON();
                ids.push(attachment.id);
                if(attachment.sizes && attachment.sizes.thumbnail) {
                    html += '<img src="'+attachment.sizes.thumbnail.url+'" style="margin:5px;max-width:80px;">';
                } else {
                    html += '<img src="'+attachment.url+'" style="margin:5px;max-width:80px;">';
                }
            });
            $('#unmnmnc_project_gallery').val(ids.join(','));
            $('#unmnmnc_gallery_preview').html(html);
        });
        frame.open();
    });
});