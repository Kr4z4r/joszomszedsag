@extends('dashboard.layout')
@section('title', $siteTitle ?? '')
@section('page_title')
    <div class="page-title-icon"><i class="pe-7s-home icon-gradient bg-white"></i></div>
    <div>
        {{ __('dashboard.home_page') }}
        <div class="page-title-subheading"></div>
    </div>
@endsection
@section('content')
    <div class="row dashboard-row">
        <div class="col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('admin_profile') }}">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading">{{ __('dashboard.profile') }}</div>
                                <div class="widget-subheading">{{ __('dashboard.profile_menu_subheading') }}</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-success"><i class="pe-7s-play icon-gradient bg-premium-dark"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('admin_new_help_request') }}">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading">{{ __('dashboard.new_help_request') }}</div>
                                <div class="widget-subheading">{{ __('dashboard.new_help_request_subheading') }}</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-warning"><i class="pe-7s-play icon-gradient bg-premium-dark"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-12 col-md-6 col-xl-3">
            @if(\Illuminate\Support\Facades\Auth::user()->role_id == 6)
            <a href="{{ route('admin_open_help_request') }}">
            @else
            <a href="{{ route('admin_own_help_request') }}">
            @endif
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                @if(\Illuminate\Support\Facades\Auth::user()->role_id == 6)
                                    <div class="widget-heading">{{ __('dashboard.waiting_requests') }}</div>
                                    <div class="widget-subheading">{{ __('') }}</div>
                                @else
                                    <div class="widget-heading">{{ __('dashboard.own_requests') }}</div>
                                    <div class="widget-subheading">{{ __('dashboard.own_requests_subheading') }}</div>
                                @endif
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-warning"><i class="pe-7s-play icon-gradient bg-premium-dark"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('admin_volunteers_list') }}">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading">{{ __('dashboard.guardian_list') }}</div>
                                <div class="widget-subheading">{{ __('dashboard.guardian_list_subheading') }}</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-danger"><i class="pe-7s-play icon-gradient bg-premium-dark"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
@section('profile_js')

@endsection