@extends('dashboard.layout')
@section('site_title', __('Teljesítetlen segítségkérések'))
@section('page_title')
    <div class="page-title-icon"><i class="pe-7s-unlock icon-gradient bg-white"></i></div>
    <div>
        {{ __('dashboard.uncomplete_requests') }}
        <div class="page-title-subheading">{{ __('dashboard.uncomplete_requests_desc') }}</div>
    </div>
@endsection

@section('content')
    <script>
        var ajaxPostRoute = '{{ $ajaxPostRoute }}';
        var csrfToken = '{{csrf_token()}}';
    </script>
    <table class="display" id="open-request-table" style="display: none; width: 100%;">
        <thead>
        <tr>
            <th>{{ __('dashboard.name_slash_address') }}</th>
            <th>{{ __('dashboard.type') }}</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($help_requests as $request)
                <tr>
                    <td>
                        <b>{{ $request->u_display_name }}</b>
                        <div class="divider"></div>
                        {{$request->post_code}} {{$request->city}}, {{$request->street}} {{$request->house_number}}
                    </td>
                    <td>{{$request->uds_help_request_name}}</td>
                    <td>
                        <span class="waves-effect green white-text accent-3 btn tooltipped"
                              data-position="bottom" data-tooltip="{{$request->uds_description}}">{{ __('dashboard.description') }}</span>
                        @if($current_user->role_id != 7 && $current_user->volunteer_data->status == 1 && ($current_user->role_id == 1 || $current_user->in_progress_helping_count <= 4))<span class="waves-effect indigo white-text accent-3 btn" data-status="3" data-id="{{$request->uds_id}}" id="volunteer_for_support">{{ __('dashboard.offer_help') }}</span>@endif
                    </td>
                    <td>
                        {{$request->priority}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div id="support_user_data_modal" class="modal">
        <div class="modal-content">
            <h4>{{ __('dashboard.contact_info') }}</h4>
            <table>
                <tr>
                    <td>{{ __('dashboard.name') }}</td>
                    <td id="modal-support-name"></td>
                </tr>
                <tr>
                    <td>{{ __('dashboard.name') }}</td>
                    <td id="modal-support-email"></td>
                </tr>
                <tr>
                    <td>{{ __('dashboard.phone') }}</td>
                    <td id="modal-support-phone"></td>
                </tr>
                <tr>
                    <td>{{ __('dashboard.facebook') }}</td>
                    <td id="modal-support-facebook"></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <span class="modal-close waves-effect waves-green btn-flat">{{ __('dashboard.cancel') }}</span>
        </div>
    </div>
@endsection
@section('dashboard_js')

@endsection