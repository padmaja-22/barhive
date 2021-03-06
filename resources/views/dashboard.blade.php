@extends('layouts.dashboard')

@section('title')
    Dashboard
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel {{ (\App\Ticket::all()->count() > 0) ? 'panel-yellow' : 'panel-success' }}">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-list alt fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ \App\Ticket::all()->count() }}</div>
                            <div>Open tickets</div>
                        </div>
                    </div>
                </div>
                <a href="/tickets">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel {{ ( \App\Inventory::whereRaw('iInventory < iMinimumInventory')->count() > 0) ? 'panel-yellow' : 'panel-success' }}">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-dropbox fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ \App\Inventory::whereRaw('iInventory < iMinimumInventory')->count() }}</div>
                            <div>Products that require stocking</div>
                        </div>
                    </div>
                </div>
                <a href="/inventory">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> <span id="morris-area-chart-title">Todays sales</span>
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" id="morris-area-chart-action">
                                Today
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#" onclick="areaVue.timeframeDay(event);">Today</a>
                                </li>
                                <li><a href="#" onclick="areaVue.timeframeMonth(event);">This month</a>
                                </li>
                                <li><a href="#" onclick="areaVue.timeframeYear(event);">This year</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="/analytics/sales"><strong>See more</strong></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-area-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>

        <div class="col-lg-4">

            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <h1>Today</h1>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="huge">€ {{ App\Sales::where(DB::raw('MONTH(created_at)'), '=', date('n'))->get()->sum('fPrice') }}</div>
                            <div>Worth in sales</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <h1>Yesterday</h1>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="huge">€ {{ App\Sales::where(DB::raw('MONTH(created_at)'), '=', date('n'))->get()->sum('fPrice') }}</div>
                            <div>Worth in sales</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <h1>{{ date('M') }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="huge">€ {{ App\Sales::where(DB::raw('MONTH(created_at)'), '=', date('n'))->get()->sum('fPrice') }}</div>
                            <div>Worth in sales</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <h1>All</h1>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="huge">€ {{ App\Sales::where(DB::raw('MONTH(created_at)'), '=', date('n'))->get()->sum('fPrice') }}</div>
                            <div>Worth in sales</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/vue.min.js') }}"></script>
    <script src="{{ asset('js/vue-resource.min.js') }}"></script>
    <script src="{{ asset('js/Dashboard.js') }}"></script>
@endsection
