@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-xs-5">
            <!-- small box -->
            <div class="small-box bg-green">
                <a href="#" class="small-box-footer">Average tax rate of the country</a>
                <div class="inner">
                    <h3>{{ round($countryAvgTaxRate, 2) }}<sup style="font-size: 20px">%</sup></h3>
                </div>
                <div class="icon" style="padding-top: 10px">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-xs-7">
            <!-- small box -->
            <div class="small-box bg-green">
                <a href="#" class="small-box-footer">Collected overall taxes of the country</a>
                <div class="inner">
                    <h3><sup style="font-size: 20px">$</sup>{{ number_format($countryCollectedOverallTaxes) }}</h3>
                </div>
                <div class="icon" style="padding-top: 10px">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- solid sales graph -->
            <div class="box box-solid bg-teal-gradient">
                <div class="box-header">
                    <i class="fa fa-th"></i>
                    <h3 class="box-title">Overall and average amount of taxes collected per state</h3>
                </div>
                <div class="box-body">
                    <div class="chart-responsive">
                        <canvas id="collectedTaxesChart" height="150"></canvas>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-5">
            <div class="box box-solid bg-teal-gradient">
                <div class="box-header">
                    <i class="fa fa-th"></i>
                    <h3 class="box-title">Average county tax rate per state</h3>
                </div>
                <div class="box-body">
                    <div class="chart-responsive">
                        <canvas id="avgCountyTaxRateChart" height="150"></canvas>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(function() {
            var config = {
                    labels : [
                        @foreach($states as $state)
                        '{{ $state->name }}',
                        @endforeach
                    ],
                    datasets : [
                        {
                            label: "Overall",
                            fillColor : "rgba(220,220,220,0.2)",
                            strokeColor : "rgba(220,220,220,1)",
                            pointColor : "rgba(220,220,220,1)",
                            pointStrokeColor : "#fff",
                            pointHighlightFill : "#fff",
                            pointHighlightStroke : "rgba(220,220,220,1)",
                            data : [
                                @foreach($states as $state)
                                    {{ $state->counties->sum('collected_taxes') }},
                                @endforeach
                            ]
                        },
                        {
                            label: "Average",
                            fillColor : "rgba(151,187,205,0.2)",
                            strokeColor : "rgba(151,187,205,1)",
                            pointColor : "rgba(151,187,205,1)",
                            pointStrokeColor : "#fff",
                            pointHighlightFill : "#fff",
                            pointHighlightStroke : "rgba(151,187,205,1)",
                            data : [
                                @foreach($states as $state)
                                {{ $state->counties->avg('collected_taxes') }},
                                @endforeach
                            ]
                        }
                    ]

                };

            var ctx = document.getElementById('collectedTaxesChart').getContext('2d');
            new Chart(ctx).Line(config, {
                responsive: true,
                showScale: true,
                scaleShowGridLines: false,
                multiTooltipTemplate: "<%= datasetLabel %>: <%= value %>"
            });
        });

        $(function() {
            var config = {
                    labels : [
                        @foreach($states as $state)
                        '{{ $state->name }}',
                        @endforeach
                    ],
                    datasets : [
                        {
                            fillColor : "rgba(220,220,220,0.2)",
                            strokeColor : "rgba(220,220,220,1)",
                            pointColor : "rgba(220,220,220,1)",
                            pointStrokeColor : "#fff",
                            pointHighlightFill : "#fff",
                            pointHighlightStroke : "rgba(220,220,220,1)",
                            data : [
                                @foreach($states as $state)
                                    {{ $state->counties->avg('tax_rate') }},
                                @endforeach
                            ]
                        }
                    ]

                };

            var ctx = document.getElementById('avgCountyTaxRateChart').getContext('2d');
            new Chart(ctx).Line(config, {
                responsive: true,
                showScale: true,
                scaleShowGridLines: false
            });
        });
    </script>
@endsection
