$(document).ready(function() {
    var $taskStatus = $('#task_status')
    $taskStatus.on('change', function() {
        if ($(this).val() == 4) {
            bootbox.alert('Se o status for alterado para concluido a atividade <strong>não</strong> poderá ser mais alterada.');
        }
    });

    $('#saveTask').on('click', function(e) {
        e.preventDefault();
        msg = '';
        if ($taskStatus.val() == 4 && $('#task_dt_end').val() == '') {
                msg += '<br/>O campo <strong>Data Fim é obrigatório</strong> quando o status for igual a concluído.';
        }

        if (msg != '') {
            bootbox.alert(msg);
        } else {
            if ($taskStatus.val() == 4) {
                bootbox.confirm({
                    message: 'Se o status for alterado para concluido a atividade <strong>não</strong> poderá ser mais alterada, </br><strong>Tem certeza que salvar a atividade?</strong>',
                    buttons: {
                        confirm: {
                            label: 'Salvar',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            $('#formListaAtividade').trigger('submit');
                        }
                    }
                });
            } else {
                $('#formListaAtividade').trigger('submit');
            }
        }
    });
});