@extends('dashboard.layout')
@section('site_title', __('Vigyázók Listája'))
@section('page_title')
    <div class="page-title-icon"><i class="pe-7s-way icon-gradient bg-white"></i></div>
    <div>
        {{ __('dashboard.guardian_list') }}
        <div class="page-title-subheading">{{ __('dashboard.guardian_list_short_desc') }}</div>
    </div>
@endsection

@section('content')
    <h3>{{ __('dashboard.guardian_list') }}</h3>
    <table class="display" id="area-volunteers-table" style="display: none; width: 100%;">
        <thead>
        <tr>
            <th>Cím</th>
            <th>Típus</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($volunteers_list as $request)
            <tr>
                <td>
                    <b>{{ $request->display_name }}</b>
                    <div class="divider"></div>
                    {{$request->city}}, {{$request->street}} @if(isset($request->house_number)) {{$request->house_number}}-től @else {{ __('dashboard.from_street_start') }} @endif  @if(isset($request->house_number_2)) {{$request->house_number_2}}-ig @else {{ __('dashboard.to_street_start') }} @endif
                    @if($request->has_car) <i class="material-icons">drive_eta</i> @endif
                </td>
                <td>
                    <ul style="display: inline">
                        @foreach($request->helping_groups as $help)
                            <li>{{ $help }}</li>
                        @endforeach
                    </ul>
                </td>
                <td><span class="waves-effect yellow black-text accent-3 btn modal-trigger" data-target="request_help_email_modal"
                          data-id="{{$request->volunteer_id}}" id="support_notify_volunteer">{{ __('dashboard.notify') }}</span></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div id="request_help_email_modal" class="modal">
        <div class="modal-content">
            <h4 id="modal_title">{{ __('dashboard.send_message_to_guardian') }}</h4>

            <h5>{{ __('dashboard.type_your_message') }}</h5>
            <textarea id="email_text" name="email_text" class="materialize-textarea" data-length="255"></textarea>


        </div>
        <div class="modal-footer">
            <span class="waves-effect waves-green btn" id="modal_send_volunteer_notification">{{ __('dashboard.send') }}</span>
            <span class="modal-close waves-effect waves-green btn-flat">{{ __('dashboard.cancel') }}</span>
        </div>
    </div>
@endsection
@section('dashboard_js')
    <script>
        var toVolunteerId;
        var toUserId = '{{ Request()->to_user_id }}';
        @if(Request()->to_user_id)
            var toUserDisplayName = '{{ \App\User::find(Request()->to_user_id)->display_name }}';
        @endif


        $(document).ready(function() {
            $('.modal').modal();
            $('textarea#email_text').characterCounter();

            if(toUserId !== '') {
                var instance = M.Modal.getInstance($('.modal'));
                instance.open();

                $('#modal_title').html('Válasz üzenet küldése <b>'+toUserDisplayName+'</b> részére');
            }

            $(document).on('click', '#support_notify_volunteer', function() {
                toVolunteerId = $(this).data('id');
            });

            $(document).on('click', '#modal_send_volunteer_notification', function() {
                if(toUserId !== '') {
                    var postData = {
                        user_id: toUserId,
                        text: $('#email_text').val(),
                        _token: '{{ csrf_token() }}'
                    }
                } else {
                    var postData = {
                        volunteer_id: toVolunteerId,
                        text: $('#email_text').val(),
                        _token: '{{ csrf_token() }}'
                    }
                }

                $.ajax({
                    url: '{{ route('send_volunteer_notification_ajax') }}',
                    method: 'post',
                    data: postData,
                    success: function(response) {
                        if(response === '1') {
                            window.location = window.location.pathname;
                        }
                    }
                });
            });

        });
    </script>
@endsection