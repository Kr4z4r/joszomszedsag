@extends('dashboard.layout')
@section('site_title', __('Saját segítségkéréseim'))
@section('page_title')
    <div class="page-title-icon"><i class="pe-7s-drawer icon-gradient bg-white"></i></div>
    <div>
        {{ __('dashboard.own_requests') }}
        <div class="page-title-subheading">{{ __('dashboard.list_of_own_requests') }}</div>
    </div>
@endsection

@section('content')
    <script>
        var ajaxPostRoute = '{{ $ajaxPostRoute }}';
        var ajaxMoreInfoRoute = '{{ $ajaxMoreInfoRoute }}';
        var csrfToken = '{{csrf_token()}}';
    </script>
    <h3>{{ __('dashboard.pending_requests') }}</h3>
    <table class="display" id="my-request-table" style="display: none; width: 100%;">
        <thead>
        <tr>
            <th>{{ __('dashboard.status_changed') }}</th>
            <th>{{ __('dashboard.guardian_slash_status') }}</th>
            <th>{{ __('dashboard.type') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($help_requests->incomplete as $request)
            <tr>
                <td>{{$request->uds_updated_at}}</td>
                <td>
                    @if($request->uds_status != 2 && $request->uds_status != 0)
                        <b>{{ $request->u_display_name }}</b>
                        <div class="divider"></div>
                        {{ \App\RequestStatus::find($request->uds_status)->name }}
                    @else
                        {{ \App\RequestStatus::find($request->uds_status)->name }}
                    @endif
                </td>
                <td>{{$request->uds_help_request_name}}</td>
                <td>
                    <span class="waves-effect green white-text accent-3 btn"
                          @if($request->uds_volunteer_user_id == null)
                          data-id="{{$request->uds_id}}" id="get_support_details"
                          @else
                          data-id="{{$request->uds_volunteer_user_id}}" id="get_volunteer_details"
                          @endif>{{ __('dashboard.details') }}</span>
                    <span class="waves-effect yellow black-text accent-3 btn" data-status="1" data-id="{{$request->uds_id}}" id="complete_support">{{ __('dashboard.done') }}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="divider"></div>
    <h3>{{ __('dashboard.my_done_requests') }}</h3>
    <table class="display" id="my-finished-request-table" style="display: none; width: 100%;">
        <thead>
        <tr>
            <th>{{ __('dashboard.done') }}</th>
            <th>{{ __('dashboard.guardian') }}</th>
            <th>{{ __('dashboard.type') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($help_requests->complete as $request)
            <tr>
                <td>{{$request->uds_updated_at}}</td>
                <td>{{isset($request->volunteer_first_name)?$request->volunteer_first_name:''}} {{isset($request->volunteer_last_name)?$request->volunteer_last_name:''}}</td>
                <td>{{$request->uds_help_request_name}}</td>
                <td>
                    <span class="waves-effect green white-text accent-3 btn" data-id="{{$request->uds_id}}" id="get_support_details">{{ __('dashboard.details') }}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div id="support_user_data_modal" class="modal">
        <div class="modal-content">
            <h4 id="modal-support-title">{{ __('dashboard.contact_info') }}</h4>
            <table>
                <tr>
                    <th>{{ __('dashboard.name') }}</th>
                    <td id="modal-support-name"></td>
                </tr>
                <tr>
                    <th>{{ __('dashboard.email') }}</th>
                    <td id="modal-support-email"></td>
                </tr>
                <tr>
                    <th>{{ __('dashboard.phone') }}</th>
                    <td id="modal-support-phone"></td>
                </tr>
                <tr>
                    <th>{{ __('dashboard.facebook') }}</th>
                    <td id="modal-support-facebook"></td>
                </tr>
                <tr>
                    <th>{{ __('dashboard.description') }}</th>
                    <td id="modal-support-description"></td>
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