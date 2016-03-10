jQuery(document).ready(function() {
    jQuery(".custom_media_button").click(function() {
        var link = jQuery(this).parent().find('.custom_media_url');
        window.send_to_editor = function(html) {
            imgurl = jQuery('img',html).attr('src');
            hrefurl = jQuery(html).attr('href');
            if(link.get(0).tagName == 'IMG'){
                link.attr('src', imgurl);
            } else {
                link.val(imgurl ? imgurl : hrefurl);
            }
            if(link.get(1).tagName == 'IMG'){
                link.attr('src', imgurl);
            } else {
                link.val(imgurl ? imgurl : hrefurl);
            }
            tb_remove();
        };

        tb_show('', 'media-upload.php?type=image&TB_iframe=true');

        return false;
    });
});