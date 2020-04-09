@extends('dashboard.layout')
@section('title', $siteTitle ?? '')
@section('page_title')
    <div class="page-title-icon"><i class="pe-7s-home icon-gradient bg-white"></i></div>
    <div>
        {{ __('Kezdőlap') }}
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
                                <div class="widget-heading">{{ __('Saját profil') }}</div>
                                <div class="widget-subheading">{{ __('Frissítse adatait, hogy a lehető legpontosabban működjön a rendszer') }}</div>
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
                                <div class="widget-heading">{{ __('Új segítségkérés') }}</div>
                                <div class="widget-subheading">{{ __('Hozzon létre új segítségkérést, hogy a Vigyázók a lehető leghamarabb segítséget tudjanak nyújtani') }}</div>
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
                                    <div class="widget-heading">{{ __('Várakozó segítségkérések') }}</div>
                                    <div class="widget-subheading">{{ __('') }}</div>
                                @else
                                    <div class="widget-heading">{{ __('Saját segítségkéréseim') }}</div>
                                    <div class="widget-subheading">{{ __('Tekintse át segítségkéréseit és azok állapotát') }}</div>
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
                                <div class="widget-heading">{{ __('Vigyázók listája') }}</div>
                                <div class="widget-subheading">{{ __('Nézze meg az aktív Vigyázók listáját, hogy kik elérhetőek a közelében') }}</div>
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