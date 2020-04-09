@extends('dashboard.layout')
@section('site_title', __('Vigyázók Listája'))
@section('page_title')
    <div class="page-title-icon"><i class="pe-7s-way icon-gradient bg-white"></i></div>
    <div>
        {{ __('Vigyázók Listája') }}
        <div class="page-title-subheading">{{ __('A területemen (azonos postai irányító számon) lakó Vigyázók') }}</div>
    </div>
@endsection

@section('content')
    <h3>{{ __('Vigyázók Listája') }}</h3>
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
                    {{$request->city}}, {{$request->street}} @if(isset($request->house_number)) {{$request->house_number}}-től @else Az Utca elejétől @endif  @if(isset($request->house_number_2)) {{$request->house_number_2}}-ig @else Az Utca Végéig @endif
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
                          data-id="{{$request->volunteer_id}}" id="support_notify_volunteer">Értesítés</span></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div id="request_help_email_modal" class="modal">
        <div class="modal-content">
            <h4 id="modal_title">Üzenet küldése Vigyázónak</h4>

            <h5>{{ __('Kérem adja meg az üzenetét') }}</h5>
            <textarea id="email_text" name="email_text" class="materialize-textarea" data-length="255"></textarea>


        </div>
        <div class="modal-footer">
            <span class="waves-effect waves-green btn" id="modal_send_volunteer_notification">Küldés</span>
            <span class="modal-close waves-effect waves-green btn-flat">Mégse</span>
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