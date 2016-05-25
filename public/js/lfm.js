(function( $ ){

    $.fn.filemanager = function(type = 'image', enable_ext = false, ext_host = "") {

        if (type === 'image' || type === 'images') {
            type = 'Images';
        } else {
            type = 'Files';
        }

        let input_id = this.data('input');
        let preview_id = this.data('preview');

        this.on('click', function(e) {
            localStorage.setItem('target_input', input_id);
            localStorage.setItem('target_preview', preview_id);
            var host = "";
            if (enable_ext) {
                host = ext_host;
                localStorage.setItem('ext_host', ext_host);
            } else {
                localStorage.removeItem('ext_host');
            }
            window.open(host + '/laravel-filemanager?type=' + type, 'FileManager', 'width=900,height=600');
            return false;
        });

        if (enable_ext) {
            function receiveMessage(e) {
                if (e.origin !== ext_host) {
                    return;
                }
                SetUrl(e.data);
            }
            window.addEventListener('message', receiveMessage);
        }
    }

})(jQuery);


function SetUrl(url){
    //set the value of the desired input to image url
    let target_input = $('#' + localStorage.getItem('target_input'));
    target_input.val(url);

    //set or change the preview image src
    let target_preview = $('#' + localStorage.getItem('target_preview'));
    var imgHost = localStorage.getItem('ext_host');
    if (imgHost == null) {
        imgHost = "";
    }
    target_preview.attr('src',imgHost + url);
}
