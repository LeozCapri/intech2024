jQuery(document).ready(function($) {
    // Add new featured image button click handler
    $(document).on('click', '#add_new_featured_image_button', function() {
        wp.media.editor.send.attachment = function(props, attachment) {
            var container = $('<div class="featured-image-container"></div>');
            var img = $('<img class="featured-image" src="' + attachment.url + '" />');
            var input = $('<input type="hidden" name="multiple_featured_images[]" value="' + attachment.url + '" />');
            var button = $('<button type="button" class="button button-secondary remove-featured-image">Remove Image</button>');

            container.append(img);
            container.append(input);
            container.append(button);
            $('#multiple-featured-images-container').append(container);
        };
        wp.media.editor.open();
        return false;
    });

    // Remove featured image button click handler
    $(document).on('click', '.remove-featured-image', function() {
        $(this).parent('.featured-image-container').remove();
    });
});
