@extends('layouts.app')

@section('page_name', 'Home')

@section('body_class', 'nav-md')

@section('scripts')
    <script src="/vendors/DateJS/build/date.js"></script>
    <script src="/vendors/Flot/jquery.flot.js"></script>
    <script src="/vendors/Flot/jquery.flot.resize.js"></script>
    <script src="/vendors/flot.curvedlines/curvedLines.js"></script>
    <script language="JavaScript">
        var PlotChart = function () {
            return {
                init: function () {
                    if( typeof ($.plot) === 'undefined'){
                        return;
                    }

                    var chart_plot_data = [
                        @foreach($plot_data as $plot_point)
                        {{ js_array($plot_point) }},
                        @endforeach
                    ];

                    var chart_plot_settings = {
                        series: {
                            curvedLines: {
                                apply: true,
                                active: true,
                                monotonicFit: true
                            }
                        },
                        colors: ["#26B99A"],
                        grid: {
                            borderWidth: {
                                top: 0,
                                right: 0,
                                bottom: 1,
                                left: 1
                            },
                            borderColor: {
                                bottom: "#7F8790",
                                left: "#7F8790"
                            }
                        }
                    };

                    var chart_plot_options = {
                        data: chart_plot_data,
                        lines: {
                            fillColor: "rgba(150, 202, 89, 0.12)"
                        },
                        points: {
                            fillColor: "#fff"
                        }
                    };

                    if ($("#chart_plot").length){
                        $.plot( $("#chart_plot"), [chart_plot_options], chart_plot_settings);
                    }
                }
            };
        }();

        $(document).ready(function () {
            PlotChart.init();
        });
    </script>
@endsection

@section('content')
    <div class="row top_tiles">
        @foreach($goals as $goal)
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                <div class="count">$ {{ number_format(App\Item::goal($goal->id)) }}</div>
                <h3>{{$goal->name}}</h3>
                <p>$ {{ number_format(App\Item::monthly($goal->id)) }} Monthly / $ {{ number_format(App\Item::yearly($goal->id)) }} Yearly</p>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Investment Value Over Time</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-9 col-sm-12 col-xs-12">
                        <div class="demo-container" style="height:280px">
                            <div id="chart_plot" class="demo-placeholder"></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div>
                            <form method="post" class="form-horizontal form-label-left">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="monthly_investment" class="control-label">Monthly Investment</label>
                                    <input type="text" name="monthly_investment" class="form-control" value="{{$monthly_investment}}">
                                </div>
                                <div class="form-group">
                                    <label for="interest_rate" class="control-label">Interest Rate</label>
                                    <input type="text" name="interest_rate" class="form-control" value="{{number_format($interest_rate * 100)}}">
                                </div>
                                <button type="submit" class="btn btn-primary">Refresh</button>
                            </form>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($plot_data as $plot_point)
                                    <tr>
                                        <td>{{ $plot_point[0] }}</td>
                                        <td>$ {{ number_format($plot_point[1], 0, '', ',') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
