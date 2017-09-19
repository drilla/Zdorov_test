$(document).ready(function() {

    /** в указанном контейнере появится текст, который медленно исчезнет */
    var showFlashMessage = function (text, $container, level) {
        var cssClass = 'text-' + level;
        var $flashMessage = $('<span>' + text + '</span>').addClass(cssClass);

        $container.html($flashMessage);
        $flashMessage.fadeOut('slow');
    };

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

    /**
     * Сохранение параметра, при выборе его из DropDown
     */
    $('body').on('change', '.js-active-dropdown', function(event) {
        var $dropDown = $(event.currentTarget);
        var $parentRow = $dropDown.closest('tr');
        var $flashMessageContainer;

        /** убираем старые контейнеры */
        $parentRow.find('.js-flash-message-container').remove();

        /** новый делаем после контрола */
        $flashMessageContainer = $('<div></div>').addClass('js-flash-message-container');
        $dropDown.after($flashMessageContainer);

        var url = $parentRow.data('url');
        $.ajax(url, {
            method: 'post',
            data: {
                orderId: $parentRow.data('orderId'),
                newState: $dropDown.find('option:selected').val()
            },
            success: function (response) {
                if (response.result === 1) {
                    showFlashMessage('Сохранено', $flashMessageContainer, 'success');
                } else {
                    showFlashMessage('Ошибка!', $flashMessageContainer, 'danger');
                }
            },
            error : function () {
                showFlashMessage('Ошибка!', $flashMessageContainer, 'danger');
            }
        });
    });

    /** Стандартная реакция на кнопку удаления - перезагрузка страницы. Эта кнопка без подтверждения
     * data-url - адрес, куда будет направлен пост запрос
     * в случае ошибки - будет выведено сообщение под кнопкой(временное) */
    $('body').on('click', '.js-btn-delete', function(event) {
        var $button = $(event.currentTarget);
        var url = $button.data('url');

        $.ajax(url, {
            method  : 'post',
            success : function () {
                window.location.reload(true);
            },
            error : function() {
                var $container = $('<div></div>');
                $button.after($container);
                showFlashMessage('Ошибка!', $container, 'danger');
            }
        })
    })
});
