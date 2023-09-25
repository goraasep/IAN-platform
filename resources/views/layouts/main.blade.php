<!--
=========================================================
* Corporate UI - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/corporate-ui
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/iot/favicon.png">
    <link rel="icon" type="image/png" href="/assets/img/iot/favicon.png">
    <title>
        IAN Monitoring Platform
    </title>
    {{-- <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" /> --}}
    <link href="/assets/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/iot.css">
    <style>
        #map {
            width: "100%";
            height: 600px;
        }

        .pac-container {
            z-index: 99999;
        }
    </style>
    <link id="pagestyle" href="/assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
    <link href="/assets/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="/assets/css/daterangepicker.css" rel="stylesheet" />
    @livewireStyles()

</head>

<body class="g-sidenav-show bg-gray-100">
    @include('sweetalert::alert')
    @include('layouts.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4 px-5">
            @yield('container')
            @include('layouts.footer')
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="/assets/js/jquery-3.5.1.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script src="/assets/js/plugins/swiper-bundle.min.js" type="text/javascript"></script>
    <script src="/assets/js/all.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dist/echarts.js"></script>
    <script src="/assets/js/moment.min.js"></script>
    <script src="/assets/js/daterangepicker.min.js"></script>

    {{-- @if (Request::is('devices'))
        <script>
            $(document).ready(function() {
                $('#device_list').DataTable({
                    "processing": false, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('alldevices') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}"
                        }
                    },
                });
            });
        </script>
    @endif
    @if (Request::is('sites'))
        <script>
            $(document).ready(function() {
                $('#site_list').DataTable({
                    "processing": false, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('allsites') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}"
                        }
                    },
                });
            });
        </script>
    @endif
    @if (Request::is('sites') || Request::is('sites/*/*'))
        <script>
            function initMap() {
                @if (Request::is('sites/*/*'))
                    const myLatlng = {
                        lat: {{ $site->lat }},
                        lng: {{ $site->lng }}
                    };
                @elseif (Request::is('sites'))
                    const myLatlng = {
                        lat: -6.193739172824711,
                        lng: 106.76588773727418
                    };
                @endif


                const map = new google.maps.Map(document.getElementById("googleMap"), {
                    zoom: 15,
                    center: myLatlng,
                    streetViewControl: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    gestureHandling: "greedy",
                });


                // Create the initial InfoWindow.
                let infoWindow = new google.maps.InfoWindow({
                    content: "Click the map to get Lat/Lng!",
                    position: myLatlng,
                });

                infoWindow.open(map);
                const input = document.getElementById("pac-input");
                const autocomplete = new google.maps.places.Autocomplete(input);
                google.maps.event.addListener(autocomplete, 'place_changed', function() {
                    var place = autocomplete.getPlace();
                    infoWindow.close();
                    infoWindow = new google.maps.InfoWindow({
                        position: {
                            lat: place.geometry.location.lat(),
                            lng: place.geometry.location.lng()
                        },
                    });
                    infoWindow.setContent(
                        JSON.stringify({
                            lat: place.geometry.location.lat(),
                            lng: place.geometry.location.lng()
                        }, null, 2)

                    );
                    infoWindow.open(map);
                    $("#site-latitude").val(place.geometry.location.lat());
                    $("#site-longitude").val(place.geometry.location.lng());
                });

                // Configure the click listener.
                map.addListener("click", (mapsMouseEvent) => {
                    // Close the current InfoWindow.
                    infoWindow.close();

                    // Create a new InfoWindow.
                    infoWindow = new google.maps.InfoWindow({
                        position: mapsMouseEvent.latLng,
                    });
                    infoWindow.setContent(
                        JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)

                    );
                    infoWindow.open(map);
                    $("#site-latitude").val(mapsMouseEvent.latLng.toJSON().lat);
                    $("#site-longitude").val(mapsMouseEvent.latLng.toJSON().lng);
                });

            }
            $(document).ready(
                initMap
            );
        </script>
        <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key=AIzaSyD8qpfVRZSZsQfuGZdN8DF9HGo9Xt_NC8U&libraries=places"></script>
    @endif
    @if (Request::is('sites/*') && !Request::is('sites/*/*'))
        <script>
            function initMap() {
                const myLatlng = {
                    lat: {{ $site->lat }},
                    lng: {{ $site->lng }}
                };
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 10,
                    center: myLatlng,
                    streetViewControl: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    gestureHandling: "greedy",
                    // gestureHandling: "cooperative",
                    // zoomControl: false,
                });
                new google.maps.Marker({
                    position: myLatlng,
                    map,
                    // title: "Hello Gora!",
                });

            }
            $(document).ready(
                initMap
            );
            $(document).ready(function() {
                let getLiveData = function() {
                    @foreach ($site->devices as $device)
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('livedata_overview') }}',
                            async: true,
                            dataType: 'json',
                            data: {
                                _token: "{{ csrf_token() }}",
                                device_id: "{{ $device->id }}",
                            },
                            success: function(data) {
                                @foreach ($device->parameters as $parameter)
                                    $('#live_{{ $parameter->slug }}').html(data.value[
                                            '{{ $parameter->slug }}'] !== undefined ? data.value[
                                            '{{ $parameter->slug }}'] + ' ' +
                                        '{{ $parameter->unit }}' : "NULL");
                                    $('#updated_{{ $parameter->slug }}').html(data.value[
                                        'created_at'] !== undefined ? data.value[
                                        'created_at'] : "NULL");
                                @endforeach
                            }
                        });
                    @endforeach
                }
                getLiveData();
                setInterval(getLiveData, 5000);
            });
        </script>
        <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key=AIzaSyAkvuKagRiFJGavzz2vXIhRJ4SWbd-A3-Y&libraries=places"></script>
    @endif
    @if (Request::is('devices/*') && !Request::is('devices/*/*'))
        <script>
            function waitForElement(elementPath, callBack) {
                window.setTimeout(function() {
                    if ($(elementPath).length) {
                        callBack(elementPath, $(elementPath));
                    } else {
                        waitForElement(elementPath, callBack);
                    }
                }, 500)
            }
            $(function() {
                var url = new URL(("{{ $request->fullUrl() }}").replace('&amp;', '&'));
                var start = url.searchParams.has('from') ? moment.unix(url.searchParams.get('from')) : moment()
                    .startOf(
                        'hour').subtract(1, "days");
                var end = url.searchParams.has('to') ? moment.unix(url.searchParams.get('to')) : moment().startOf(
                    'hour');

                function cb_date(start, end) {

                    // window.location.replace('google.com');
                    var url2 = new URL((
                            "{{ $request->fullUrlWithQuery(['range' => null, 'from' => null, 'to' => null]) }}"
                        )
                        .replace('&amp;', '&'));
                    url2.searchParams.set('from', start.unix());
                    url2.searchParams.set('to', end.unix());
                    window.location.replace(url2);

                    // fetch({{ url('/') }})
                }
                $('#datetimerange').daterangepicker({
                    timePicker: true,
                    startDate: start,
                    endDate: end,
                    // startDate: moment().startOf('hour'),
                    // endDate: moment().startOf('hour').add(32, 'hour'),
                    locale: {
                        separator: " to ",
                        format: 'YYYY-MM-DD HH:mm:ss'
                    }
                    // cb_date(start, end);
                }, cb_date);
                $('#datetimerange span').html(start.format('YYYY-MM-DD HH:mm:ss') + ' To ' + end.format(
                    'YYYY-MM-DD HH:mm:ss'));

            });
            $(document).ready(function() {
                $('#parameter_list').DataTable({
                    "processing": false, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('allparameters') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            device_id: "{{ $device->id }}",
                            device_uuid: "{{ $device->uuid }}"
                        }
                    },
                });
                $('#alert_list').DataTable({
                    "processing": false, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('allalerts') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            device_id: "{{ $device->id }}",
                        }
                    },
                });
                $('#historical_log').DataTable({
                    "processing": false, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('historicallog') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            device_id: "{{ $device->id }}",
                            parameters: {!! $parameters->where('type', '<>', 'special')->map(function ($query) {
                                return $query->slug;
                            }) !!}
                        }
                    }
                });
            });
            $(document).ready(function() {
                let created_at;
                let datapoll;
                let isLoaded = false;
                let getLiveDataOnce = function() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('livedata_once') }}',
                        async: true,
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            device_id: "{{ $device->id }}",
                            range: {{ request('range') ?: 'null' }},
                            from: {{ request('from') ?: 'null' }},
                            to: {{ request('to') ?: 'null' }},
                        },
                        success: function(data) {
                            @foreach ($parameters_number as $parameter)
                                window.{{ $charts['charts_gauge'][$loop->index]->id }}
                                    .setOption({
                                        series: [{
                                            data: [{
                                                value: data.value[
                                                    '{{ $parameter->slug }}'
                                                ]
                                            }]
                                        }]
                                    });
                                window.{{ $charts['charts_line'][$loop->index]->id }}
                                    .setOption({
                                        series: [{
                                            data: data.log.map(
                                                function(row) {
                                                    created_at = row[
                                                        'created_at'
                                                    ]
                                                    return [row[
                                                        'created_at'
                                                    ], row[
                                                        '{{ $parameter->slug }}'
                                                    ]];
                                                })
                                        }]
                                    });
                            @endforeach
                            @foreach ($parameters_string as $parameter)
                                $('#live_{{ $parameter->slug }}').html(data.value[
                                    '{{ $parameter->slug }}'] ? data.value[
                                    '{{ $parameter->slug }}'] : "NULL");
                                $('#previous_{{ $parameter->slug }}').html(data.log[1] !== undefined ?
                                    (data.log[1][
                                        '{{ $parameter->slug }}'
                                    ] ? data.log[1][
                                        '{{ $parameter->slug }}'
                                    ] : "NULL") : "NULL");
                            @endforeach
                            @foreach ($parameters_special as $parameter)
                                $('#live_{{ $parameter->slug }}').html(data.special[
                                    '{{ $parameter->slug }}'] ? data.special[
                                    '{{ $parameter->slug }}'] : "NULL");
                            @endforeach
                            datapoll = data.log;
                            isLoaded = true;
                        }
                    });
                }
                let getLiveData = function() {
                    if (isLoaded) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('livedata') }}',
                            async: true,
                            dataType: 'json',
                            data: {
                                _token: "{{ csrf_token() }}",
                                device_id: "{{ $device->id }}",
                                range: {{ request('range') ?: 'null' }},
                                from: {{ request('from') ?: 'null' }},
                                to: {{ request('to') ?: 'null' }},
                            },
                            success: function(data) {
                                if (created_at != data.value['created_at']) {
                                    datapoll.push(data.value);
                                    @foreach ($parameters_number as $parameter)
                                        window.{{ $charts['charts_gauge'][$loop->index]->id }}
                                            .setOption({
                                                series: [{
                                                    data: [{
                                                        value: data.value[
                                                            '{{ $parameter->slug }}'
                                                        ]
                                                    }]
                                                }]
                                            });
                                        window.{{ $charts['charts_line'][$loop->index]->id }}
                                            .setOption({
                                                series: [{
                                                    data: datapoll.map(
                                                        function(row) {
                                                            return [row[
                                                                'created_at'
                                                            ], row[
                                                                '{{ $parameter->slug }}'
                                                            ]];
                                                        })
                                                }]
                                            });
                                    @endforeach
                                    created_at = data.value['created_at'];
                                }
                                @foreach ($parameters_string as $parameter)
                                    $('#live_{{ $parameter->slug }}').html(data.value[
                                        '{{ $parameter->slug }}'] ? data.value[
                                        '{{ $parameter->slug }}'] : "NULL");
                                    $('#previous_{{ $parameter->slug }}').html(data.log[1] !==
                                        undefined ?
                                        (data.log[1][
                                            '{{ $parameter->slug }}'
                                        ] ? data.log[1][
                                            '{{ $parameter->slug }}'
                                        ] : "NULL") : "NULL");
                                @endforeach
                            }
                        });
                    }
                }
                waitForElement(
                    "#{{ $charts['charts_line'] ? $charts['charts_line'][sizeof($charts['charts_line']) - 1]->id : 0 }}",
                    function() {
                        getLiveDataOnce();
                        setInterval(getLiveData, 5000);
                    });


                // getLiveDataOnce();
                // setInterval(getLiveData, 5000);

            });
        </script>
        <script>
            $(document).ready(function() {
                $('#parameter-type').change(function() {
                    let selectedType = $(this).children("option:selected").val();
                    if (selectedType == 'special') {
                        $('#dynamic-form').empty();
                        let inner = `<div class="form-group">
                                                    <label for="base-parameter" class="col-form-label">Base
                                                        parameter</label>
                                                    <select class="form-select" id="base-parameter" name="base_parameter">
                                                        @foreach ($parameters as $parameter)
                                                        @if ($parameter->type == 'number')
                                                        <option value="{{ $parameter->slug }}">{{ $parameter->name }}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Condition</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="form-select" name="operator">
                                                                <option value="=">==</option>
                                                                <option value="<>">!=</option>
                                                                <option value=">=">&gt;=</option>
                                                                <option value="<=">&lt;=</option>
                                                                <option value=">">&gt;</option>
                                                                <option value="<">&lt;</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="number" step="any" class="form-control" name="condition_value" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <select class="form-select" name="condition_rule">
                                                                <option value="last">Last</option>
                                                                <option value="first">First</option>
                                                                <option value="count">Count</option>
                                                                <option value="max">Max</option>
                                                                <option value="min">Min</option>
                                                                <option value="average">Average</option>
                                                                <option value="sum">Sum</option>
                                                                <option value="difference">Difference (Last - First)
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>`;
                        var div1 = document.getElementById("dynamic-form");
                        div1.insertAdjacentHTML('beforeend', inner);
                    } else if (selectedType == 'number') {
                        $('#dynamic-form').empty();
                        let inner = `
                        <div class="form-group">
                                                    <label for="parameter-unit" class="col-form-label">Unit:</label>
                                                    <input type="text" class="form-control" id="parameter-unit"
                                                        name="unit" value="{{ old('unit') }}">
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="parameter-th-H" class="col-form-label">Threshold
                                                                High:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="number" step="any" class="form-control"
                                                                id="parameter-th-H" name="th_H"
                                                                value="{{ old('th_H', 0) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="form-select" name="th_H_enable">
                                                                <option value="0">Disable</option>
                                                                <option value="1">Enable</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="parameter-th-L" class="col-form-label">Threshold
                                                                Low:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="number" step="any" class="form-control"
                                                                id="parameter-th-L" name="th_L"
                                                                value="{{ old('th_L', 0) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="form-select" name="th_L_enable">
                                                                <option value="0">Disable</option>
                                                                <option value="1">Enable</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="parameter-max" class="col-form-label">Maximum
                                                        Value:</label>
                                                    <input type="number" step="any" class="form-control"
                                                        id="parameter-max" name="max" value="{{ old('max', 0) }}"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="parameter-min" class="col-form-label">Minimum
                                                        Value:</label>
                                                    <input type="number" step="any" class="form-control"
                                                        id="parameter-min" name="min" value="{{ old('min', 0) }}"
                                                        required>
                                                </div>
                        `;
                        var div1 = document.getElementById("dynamic-form");
                        div1.insertAdjacentHTML('beforeend', inner);
                    } else if (selectedType == 'string') {
                        $('#dynamic-form').empty();
                    }
                });
            });
        </script>
    @endif --}}

    @if (Request::is('admin-panel'))
        <script>
            $(document).ready(function() {
                $('#parameter_list').DataTable({
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('datatables/parameter_list') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}"
                        }
                    },
                });
                $('#dashboard_list').DataTable({
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('datatables/dashboard_list') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}"
                        }
                    },
                });
                $('#user_list').DataTable({
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('datatables/user_list') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}"
                        }
                    },
                });
            });
        </script>
    @endif
    @if (Request::is('admin-panel/parameter/*'))
        <script>
            function waitForElement(elementPath, callBack) {
                window.setTimeout(function() {
                    if ($(elementPath).length) {
                        callBack(elementPath, $(elementPath));
                    } else {
                        waitForElement(elementPath, callBack);
                    }
                }, 500)
            }
            $(document).ready(function() {
                let getLiveData = function() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('livedata') }}',
                        async: true,
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            parameter_id: "{{ $parameter->id }}",
                        },
                        success: function(data) {
                            if (data.type == 'number') {
                                window.{{ $charts['chart_gauge']->id }}
                                    .setOption({
                                        series: [{
                                            data: [{
                                                value: data.actual_value
                                            }]
                                        }]
                                    });
                                if (data.alert == 'High' || data.alert == 'Low') {
                                    $('#alert-parameter').html(
                                        `<i class="fa-solid fa-exclamation-triangle ms-2 text-danger"></i>`
                                    );
                                } else {
                                    $('#alert-parameter').html(
                                        ``
                                    );
                                }
                            }
                        }
                    });
                }
                waitForElement(
                    "#{{ $charts['chart_gauge']->id }}",
                    function() {
                        setInterval(getLiveData, 3000);
                    });
            });
            $(document).ready(function() {
                let getLiveString = function() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('livedata') }}',
                        async: true,
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            parameter_id: "{{ $parameter->id }}",
                        },
                        success: function(data) {
                            data.actual_value
                            $('#live_string').html(data.actual_string);
                        }
                    });
                }
                setInterval(getLiveString, 3000);
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#historical_log').DataTable({
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    order: [
                        [0, 'desc']
                    ],
                    "ajax": {
                        "url": "{{ url('datatables/historical_log') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            "parameter_id": {{ $parameter->id }},
                            "datetimerange": "{{ $datetimerange }}"
                        }
                    },
                });
                @if ($parameter->type == 'number')
                    $('#alert_log').DataTable({
                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        order: [
                            [0, 'desc']
                        ],
                        "ajax": {
                            "url": "{{ url('datatables/alert_log') }}",
                            "type": "POST",
                            "data": {
                                _token: "{{ csrf_token() }}",
                                "parameter_id": {{ $parameter->id }},
                                "datetimerange": "{{ $datetimerange }}"
                            }
                        },
                    });
                @endif
            });
        </script>
        <script>
            $(function() {
                $('input[name="datetimerange"]').daterangepicker({
                    timePicker: true,
                    timePicker24Hour: true,
                    locale: {
                        separator: " to ",
                        format: 'YYYY-MM-DD HH:mm:ss'
                    }
                });
            });
        </script>
    @endif

    @if (Request::is('admin-panel/dashboard/*'))
        <script>
            $(document).ready(function() {
                let getLiveData = function() {
                    @foreach ($dashboard->panels as $panel)
                        @if ($panel->parameter)
                            @if ($panel->parameter->type == 'number')
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('livedata') }}',
                                    async: true,
                                    dataType: 'json',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        parameter_id: "{{ $panel->parameter->id }}",
                                    },
                                    success: function(data) {
                                        if (data.type == 'number') {
                                            window.{{ $charts[$loop->index]->id }}
                                                .setOption({
                                                    series: [{
                                                        data: [{
                                                            value: data.actual_value
                                                        }]
                                                    }]
                                                });
                                            if (data.alert == 'High' || data.alert == 'Low') {
                                                $('#alert-parameter-' + data.id).html(
                                                    `<i class="fa-solid fa-exclamation-triangle ms-2 text-danger"></i>`
                                                );
                                            } else {
                                                $('#alert-parameter-' + data.id).html(
                                                    ``
                                                );
                                            }
                                        }
                                    }
                                });
                            @else
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('livedata') }}',
                                    async: true,
                                    dataType: 'json',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        parameter_id: "{{ $panel->parameter->id }}",
                                    },
                                    success: function(data) {
                                        data.actual_value
                                        $('#live_string-{{ $panel->parameter->id }}').html(data
                                            .actual_string);
                                    }
                                });
                            @endif
                        @endif
                    @endforeach

                }
                setInterval(getLiveData, 3000);
            });
        </script>
    @endif

    @if (Request::is('admin-panel/user/*'))
        <script>
            $(document).ready(function() {
                $('#access_list').DataTable({
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "ajax": {
                        "url": "{{ url('datatables/access_list') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            "user_id": {{ $user->id }}
                        }
                    },
                });
            });
        </script>
    @endif

    @if (Request::is('dashboard/*') && !Request::is('dashboard/*/*'))
        <script>
            $(document).ready(function() {
                let getLiveData = function() {
                    @foreach ($dashboard->panels as $panel)
                        @if ($panel->parameter)
                            @if ($panel->parameter->type == 'number')
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('userlivedata') }}',
                                    async: true,
                                    dataType: 'json',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        parameter_id: "{{ $panel->parameter->id }}",
                                    },
                                    success: function(data) {
                                        if (data.type == 'number') {
                                            window.{{ $charts[$loop->index]->id }}
                                                .setOption({
                                                    series: [{
                                                        data: [{
                                                            value: data.actual_value
                                                        }]
                                                    }]
                                                });
                                            if (data.alert == 'High' || data.alert == 'Low') {
                                                $('#alert-parameter-' + data.id).html(
                                                    `<i class="fa-solid fa-exclamation-triangle ms-2 text-danger"></i>`
                                                );
                                            } else {
                                                $('#alert-parameter-' + data.id).html(
                                                    ``
                                                );
                                            }
                                        }
                                    }
                                });
                            @else
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ url('userlivedata') }}',
                                    async: true,
                                    dataType: 'json',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        parameter_id: "{{ $panel->parameter->id }}",
                                    },
                                    success: function(data) {
                                        data.actual_value
                                        $('#live_string-{{ $panel->parameter->id }}').html(data
                                            .actual_string);
                                    }
                                });
                            @endif
                        @endif
                    @endforeach

                }
                setInterval(getLiveData, 3000);
            });
        </script>
    @endif

    @if (Request::is('dashboard/parameter/*'))
        <script>
            function waitForElement(elementPath, callBack) {
                window.setTimeout(function() {
                    if ($(elementPath).length) {
                        callBack(elementPath, $(elementPath));
                    } else {
                        waitForElement(elementPath, callBack);
                    }
                }, 500)
            }
            $(document).ready(function() {
                let getLiveData = function() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('userlivedata') }}',
                        async: true,
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            parameter_id: "{{ $parameter->id }}",
                        },
                        success: function(data) {
                            if (data.type == 'number') {
                                window.{{ $charts['chart_gauge']->id }}
                                    .setOption({
                                        series: [{
                                            data: [{
                                                value: data.actual_value
                                            }]
                                        }]
                                    });
                                if (data.alert == 'High' || data.alert == 'Low') {
                                    $('#alert-parameter').html(
                                        `<i class="fa-solid fa-exclamation-triangle ms-2 text-danger"></i>`
                                    );
                                } else {
                                    $('#alert-parameter').html(
                                        ``
                                    );
                                }
                            }
                        }
                    });
                }
                waitForElement(
                    "#{{ $charts['chart_gauge']->id }}",
                    function() {
                        setInterval(getLiveData, 3000);
                    });
            });
            $(document).ready(function() {
                let getLiveString = function() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('userlivedata') }}',
                        async: true,
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            parameter_id: "{{ $parameter->id }}",
                        },
                        success: function(data) {
                            data.actual_value
                            $('#live_string').html(data.actual_string);
                        }
                    });
                }
                setInterval(getLiveString, 3000);
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#historical_log').DataTable({
                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    order: [
                        [0, 'desc']
                    ],
                    "ajax": {
                        "url": "{{ url('datatables/user_historical_log') }}",
                        "type": "POST",
                        "data": {
                            _token: "{{ csrf_token() }}",
                            "parameter_id": {{ $parameter->id }},
                            "datetimerange": "{{ $datetimerange }}"
                        }
                    },
                });
                @if ($parameter->type == 'number')
                    $('#alert_log').DataTable({
                        "processing": true, //Feature control the processing indicator.
                        "serverSide": true, //Feature control DataTables' server-side processing mode.
                        order: [
                            [0, 'desc']
                        ],
                        "ajax": {
                            "url": "{{ url('datatables/user_alert_log') }}",
                            "type": "POST",
                            "data": {
                                _token: "{{ csrf_token() }}",
                                "parameter_id": {{ $parameter->id }},
                                "datetimerange": "{{ $datetimerange }}"
                            }
                        },
                    });
                @endif
            });
        </script>
        <script>
            $(function() {
                $('input[name="datetimerange"]').daterangepicker({
                    timePicker: true,
                    timePicker24Hour: true,
                    locale: {
                        separator: " to ",
                        format: 'YYYY-MM-DD HH:mm:ss'
                    }
                });
            });
        </script>
    @endif

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    {{-- @if (Request::is('/'))
        <script type="text/javascript">
            function initMap() {
                const myLatLng = {
                    lat: -6.2734719,
                    lng: 110.7512559
                };
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 5,
                    center: myLatLng,
                });

                //ajax needed

                $.ajax({
                    type: 'POST',
                    url: '{{ url('sitemap') }}',
                    async: true,
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        // console.log(data);
                        for (i = 0; i < data.length; i++) {
                            marker = new google.maps.Marker({
                                position: data[i].location,
                                map,
                                url: data[i].url
                            });
                            var hoverListener = google.maps.event.addListener(marker, 'mouseover', (
                                function(marker, i) {
                                    return function() {
                                        var infowindow = new google.maps.InfoWindow({
                                            content: data[i].contentData
                                        });
                                        infowindow.open(map, marker);
                                        google.maps.event.addListener(marker, 'mouseout', (function(
                                            marker, i) {
                                            return function() {
                                                infowindow.close();
                                            }
                                        })(marker, i))
                                    }
                                }
                            )(marker, i));
                            google.maps.event.addListener(marker, 'click', (
                                function(marker, i) {
                                    return function() {
                                        window.location.href = marker.url;
                                    }
                                }
                            )(marker, i));
                        }
                    }
                });

                //

            }

            window.initMap = initMap;
        </script>
        <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key=AIzaSyAkvuKagRiFJGavzz2vXIhRJ4SWbd-A3-Y&callback=initMap"></script>
    @endif --}}
    <!-- Github buttons -->
    <!-- Control Center for Corporate UI Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/assets/js/corporate-ui-dashboard.js?v=1.0.0"></script>
    @livewireScripts()
</body>

</html>
