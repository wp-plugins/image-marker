(function($) {
    'use strict';


    // This method is copied from:
    // http://stackoverflow.com/questions/133925/javascript-post-request-like-a-form-submit
    var post = function(path, params, method) {
        method = method || "post"; // Set method to post by default if not specified.

        // The rest of this code assumes you are not using a library.
        // It can be made less wordy if you use one.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);

        for (var key in params) {
            if (params.hasOwnProperty(key)) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);

                form.appendChild(hiddenField);
            }
        }

        document.body.appendChild(form);
        form.submit();
    };

    var handleResponse = function(data) {
        var response = $.parseJSON(data);
        if (response.lat && response.lon) {
            // post to the target page to create the map marker
            post(response.target_url, response);
        } else {
            if (response.message) {
                alert(response.message);
            } else {
                alert('Unknown error');
            }
        }
    };

    $(function() {
        $(".image-marker-create").click(function() {
            var id = $(this).data('id');
            $.post(my_ajax_obj.ajax_url, {
                _ajax_nonce: my_ajax_obj.nonce,
                action: "image_marker_create",
                id: id
            }, handleResponse);
        });
        $(".ngg-image-marker-create").click(function() {
            var id = $(this).data('id');
            $.post(my_ajax_obj.ajax_url, {
                _ajax_nonce: my_ajax_obj.nonce,
                action: "ngg_image_marker_create",
                id: id
            }, handleResponse);
        });
    });

})(jQuery);