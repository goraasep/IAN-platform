<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="row my-4">
        @if (!$parameters->count())
            <h3 class="col-12 text-center opacity-5">Data not found.</h3>
        @else
            @foreach ($parameters as $parameter)
                <div class="col-lg-12 mb-4">
                    <div class="card shadow-xs border">
                        <div class="card-header pb-0">
                            <div class="d-sm-flex align-items-center mb-3">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">{{ $parameter->name }}</h6>
                                    <p class="text-sm mb-sm-0 mb-2">Here you have details {{ $parameter->name }}.</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <button type="button" class="btn btn-sm btn-white mb-0 me-2">
                                        View report
                                    </button>
                                </div>
                            </div>
                            <div class="d-sm-flex align-items-center">
                                {{-- <h3 class="mb-0 font-weight-semibold" wire:poll.5000ms>
                                    {{ $parameters_log ? $parameters_log->{$parameter->slug} : 'NULL' }}
                                    {{ $parameter->unit }}</h3> --}}
                            </div>
                        </div>
                        <div class="card-body p-3 row">
                            <div class="col-lg-3">
                                {{-- GAUGE --}}
                                {!! $charts_gauge[$loop->index]->container() !!}
                                {!! $charts_gauge[$loop->index]->script() !!}
                            </div>
                            <div class="col-lg-9">
                                {{-- Chart
                                <div class="chart mt-n6">
                                    <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                                 --}}
                                <div class="chart mt-n5">
                                    {!! $charts_line[$loop->index]->container() !!}
                                    {!! $charts_line[$loop->index]->script() !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <script>
                    //ajax sending to controller
                    // setInterval(function() {
                    // window.{{ $charts_gauge[$loop->index]->id }}.setOption({
                    //     series: [{
                    //         data: [{
                    //             value: 0
                    //         }]
                    //     }]
                    // });
                    // }, 2000);
                    // $(document).ready(function() {
                    //     setInterval(function() {
                    //         $.ajax({
                    //             type: 'POST',
                    //             url: '/livedata',
                    //             async: true,
                    //             dataType: 'json',
                    //             data: {
                    //                 _token: "{{ csrf_token() }}",
                    //                 slug: "{{ $parameter->slug }}",
                    //                 device_id: "{{ $device_id }}"
                    //             },
                    //             success: function(data) {
                    //                 $("#{{ $charts_gauge[$loop->index]->id }}").setOption({
                    //                     series: [{
                    //                         data: [{
                    //                             value: data.value
                    //                         }]
                    //                     }]
                    //                 });
                    //             }
                    //         });
                    //     }, 5000);
                    // });
                </script>
            @endforeach
        @endif
    </div>
</div>
