function textGet(source) {
    'use strict';

    let translation = '';
    $.ajax({
        type: 'get',
        url: 'core/ajax/textget.php',
        async: false,
        data: {source: source},
        dataType: 'text',
        success: function (data) {
            translation = data;
        },
        error: function (xhr, status, error) {
            let errorMessage = xhr.status + ': ' + xhr.statusText
            alert('Error - ' + errorMessage);
        }
    });
    return translation;
}
