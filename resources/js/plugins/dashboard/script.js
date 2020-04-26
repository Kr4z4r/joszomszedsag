$(document).ready(function() {
    $('#open-request-table').show().DataTable( {
        order: [[ 3, 'asc' ], [ 0, 'asc' ]],
        columnDefs: [
            {
                'targets': 2,
                'orderable': false
            },
            {
                'targets': 3,
                'visible': false,
                "searchable": false
            },
        ],
        responsive: true,
        language: {
            url: '/js/plugins/datatables/hu_HU.json'
        }
    } );

    $('#own-request-table, #own-finished-request-table').show().DataTable( {
        "columnDefs": [
            {
                'targets': 2,
                'orderable': false
            }
        ],
        responsive: true,
        language: {
            url: '/js/plugins/datatables/hu_HU.json'
        }
    } );

    $('#my-request-table, #my-finished-request-table').show().DataTable( {
        "columnDefs": [
            {
                'targets': 3,
                'orderable': false
            }
        ],
        responsive: true,
        language: {
            url: '/js/plugins/datatables/hu_HU.json'
        }
    } );

    $('#area-volunteers-table').show().DataTable( {
        "columnDefs": [
            {
                "width": "60px",
                'targets': 2,
                'orderable': false
            }
        ],
        responsive: true,
        language: {
            url: '/js/plugins/datatables/hu_HU.json'
        }
    } );

    $('.tooltipped').tooltip();

    $(document).on('click', '#volunteer_for_support', function() {
        $.ajax({
            url: ajaxPostRoute,
            type: 'post',
            data: {
                id: $(this).data('id'),
                _token: csrfToken,
                status: $(this).data('status')
            },
            success: function(response) {
                let jsonResponse = JSON.parse(response);

                let $modal = $('#support_user_data_modal');

                $('#modal-support-name').html(jsonResponse.name);
                $('#modal-support-email').html(jsonResponse.email);
                $('#modal-support-phone').html(jsonResponse.phone);
                $('#modal-support-facebook').html(jsonResponse.facebook_profile?'<a href="'+jsonResponse.facebook_profile+'">Facebook Profil</a>':'-');

                M.Modal.init($modal, {
                    onCloseStart: function() {
                        location.reload();
                    }
                });

                var instance = M.Modal.getInstance($modal);
                instance.open();
            }
        })
    });

    $(document).on('click', '#cancel_support, #complete_support, #reactivate_support', function() {
        $.ajax({
            url: ajaxPostRoute,
            type: 'post',
            data: {
                id: $(this).data('id'),
                _token: csrfToken,
                status: $(this).data('status')
            },
            success: function(response) {
                let jsonResponse = JSON.parse(response);
                if(jsonResponse.error === undefined)
                    location.reload();
                else
                    console.log(jsonResponse.error);

            }
        })
    });

    $(document).on('click', '#get_support_details', function() {
        $.ajax({
            url: ajaxMoreInfoRoute,
            type: 'post',
            data: {
                id: $(this).data('id'),
                _token: csrfToken,
                type: 7
            },
            success: function(response) {
                let jsonResponse = JSON.parse(response);

                if(jsonResponse.error === undefined) {

                    let $modal = $('#support_user_data_modal');

                    $('#modal-support-name').html(jsonResponse.name);
                    $('#modal-support-email').html(jsonResponse.email);
                    $('#modal-support-phone').html(jsonResponse.phone);
                    $('#modal-support-facebook').html(jsonResponse.facebook_profile?'<a href="'+jsonResponse.facebook_profile+'">Facebook Profil</a>':'-');
                    $('#modal-support-description').html(jsonResponse.description??'-');

                    M.Modal.init($modal);

                    var instance = M.Modal.getInstance($modal);
                    instance.open();
                }
                else
                    console.log(jsonResponse.error);

            }
        })
    });

    $(document).on('click', '#get_volunteer_details', function() {
        $.ajax({
            url: ajaxMoreInfoRoute,
            type: 'post',
            data: {
                id: $(this).data('id'),
                _token: csrfToken,
                type: 6
            },
            success: function(response) {
                let jsonResponse = JSON.parse(response);

                if(jsonResponse.error === undefined) {

                    let $modal = $('#support_user_data_modal');

                    $('#modal-support-name').html(jsonResponse.name);
                    $('#modal-support-email').html(jsonResponse.email);
                    $('#modal-support-phone').html(jsonResponse.phone);
                    $('#modal-support-facebook').html(jsonResponse.facebook_profile?'<a href="'+jsonResponse.facebook_profile+'">Facebook Profil</a>':'-');
                    $('#modal-support-description').html(jsonResponse.description??'-');

                    M.Modal.init($modal);

                    var instance = M.Modal.getInstance($modal);
                    instance.open();
                }
                else
                    console.log(jsonResponse.error);

            }
        })
    });

    let dropdowns = document.querySelectorAll('.dropdown-trigger');
    let dInstances = M.Dropdown.init(dropdowns, {alignment: 'right'});
});