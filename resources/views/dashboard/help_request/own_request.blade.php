@extends('dashboard.layout')
@section('site_title', __('Általam vállalt segítségkérések'))
@section('page_title')
    <div class="page-title-icon"><i class="pe-7s-lock icon-gradient bg-white"></i></div>
    <div>
        {{ __('Általam vállalt segítségkérések') }}
        <div class="page-title-subheading">{{ __('Általam vállalt segítségkérések listája') }}</div>
    </div>
@endsection

@section('content')
    <script>
        var ajaxPostRoute = '{{ $ajaxPostRoute }}';
        var ajaxMoreInfoRoute = '{{ $ajaxMoreInfoRoute }}';
        var csrfToken = '{{csrf_token()}}';
    </script>
    <h3>{{ __('Folyamatban lévő segítségnyújtásaim') }}</h3>
    <table class="display" id="own-request-table" style="display: none; width: 100%;">
        <thead>
        <tr>
            <th>{{ __('Elvállaltam') }}</th>
            <th>{{ __('Név/Cím') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($help_requests->incomplete as $request)
                <tr>
                    <td>
                        {{$request->uds_updated_at}}
                        <div class="divider"></div>
                        {{ \App\RequestStatus::find($request->uds_status)->name }}
                    </td>
                    <td>
                        <b>{{ $request->u_display_name }}</b>
                        <div class="divider"></div>
                        {{$request->uds_help_request_name}}
                        <div class="divider"></div>
                        {{$request->post_code}} {{$request->city}}, {{$request->street}} {{$request->house_number}}
                    </td>
                    <td>
                        <span class="waves-effect green white-text accent-3 btn" data-id="{{$request->uds_id}}" id="get_support_details">{{ __('Részletek') }}</span>
                        <span class="waves-effect red white-text accent-3 btn" data-status="0" data-id="{{$request->uds_id}}" id="cancel_support">{{ __('Lemondom') }}</span>
                        @if($request->uds_status != 4)<span class="waves-effect yellow black-text accent-3 btn" data-status="4" data-id="{{$request->uds_id}}" id="complete_support">{{ __('Teljesítve') }}</span>@endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="divider"></div>
    <h3>{{ __('Teljesített segítségnyújtásaim') }}</h3>
    <table class="display" id="own-finished-request-table" style="display: none; width: 100%;">
        <thead>
        <tr>
            <th>{{ __('Teljesítve') }}</th>
            <th>{{ __('Név/Cím') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($help_requests->complete as $request)
            <tr>
                <td>
                    {{$request->uds_updated_at}}
                    <div class="divider"></div>
                    {{$request->uds_help_request_name}}
                </td>
                <td>
                    <b>{{ $request->u_display_name }}</b>
                    <div class="divider"></div>
                    {{$request->post_code}} {{$request->city}}, {{$request->street}} {{$request->house_number}}
                </td>
                <td>
                    <span class="waves-effect green white-text accent-3 btn" data-id="{{$request->uds_id}}" id="get_support_details">{{ __('Részletek') }}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div id="support_user_data_modal" class="modal">
        <div class="modal-content">
            <h4>{{ __('Kapcsolattartási információk') }}</h4>
            <table>
                <tr>
                    <th>{{ __('Vigyázó Neve') }}</th>
                    <td id="modal-support-name"></td>
                </tr>
                <tr>
                    <th>{{ __('Vigyázó Emailje') }}</th>
                    <td id="modal-support-email"></td>
                </tr>
                <tr>
                    <th>{{ __('Vigyázó Telefonszáma') }}</th>
                    <td id="modal-support-phone"></td>
                </tr>
                <tr>
                    <th>{{ __('Vigyázó Facebook profilja') }}</th>
                    <td id="modal-support-facebook"></td>
                </tr>
                <tr>
                    <th>{{ __('Általam adott leírás') }}</th>
                    <td id="modal-support-description"></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <span class="modal-close waves-effect waves-green btn-flat">{{ __('Kilépés') }} </span>
        </div>
    </div>
@endsection
@section('dashboard_js')

@endsection