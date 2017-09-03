$(document).ready(function() {
    /**
     * настройка модального окна из активировавшей его кнопки
     */
    $('#modal-confirm').on('show.bs.modal', function (event) {
        var $button = $(event.relatedTarget); // Button that triggered the modal
        var url     = $button.data('url');
        var message = $button.data('message');
        var title   = $button.data('title');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var $modal = $(this);
        $modal.find('.modal-header').text(title);
        $modal.find('.modal-body').text(message);

        var $buttonOk = $modal.find('.js-confirm-btn');
        $buttonOk.data('url', url);

        $buttonOk.click(function(event) {
            event.stopImmediatePropagation();
            var $button = $(this);

            $.post($button.data('url'))
                .done(function (response) {
                    $modal.modal('hide');
                    window.location.href=response.redirect;
                })
                .fail(function () {
                    $modal.find('.modal-body').html('<div class="bg-danger">Возникла ошибка!</div>');
                });
        });
    });
});