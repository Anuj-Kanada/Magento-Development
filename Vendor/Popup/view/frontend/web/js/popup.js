require(['jquery'], function($) {
    $(document).ready(function() {
        var modal = $('#popup-modal');
        var openModalButton = $('#open-modal');
        var closeButton = $('.close-button');

        openModalButton.on('click', function() {
            modal.show();
        });

        closeButton.on('click', function() {
            modal.hide();
        });

        $(window).on('click', function(event) {
            if ($(event.target).is('#popup-modal')) {
                modal.hide();
            }
        });
    });
});
