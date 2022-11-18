<div wire:poll.5000ms>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row my-4">
        @if (!$parameters->count())
            <h3 class="col-12 text-center opacity-5">No data available.</h3>
        @else
            @foreach ($parameters as $parameter)
                <div class="col-xl-2 col-sm-3 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-sm text-secondary mb-1">{{ $parameter->name }}</p>
                                        <h4 class="mb-2 font-weight-bold">
                                            {{ $parameters_log ? $parameters_log->{$parameter->slug} : 'NULL' }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        {{-- <div class="col-xl-2 col-sm-3 mb-xl-0">
            <div class="card border shadow-xs mb-4">
                <div class="card-body text-start p-3 w-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="w-100">
                                <p class="text-sm text-secondary mb-1">Door 1</p>
                                <h4 class="mb-2 font-weight-bold">Close</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-3 mb-xl-0">
            <div class="card border shadow-xs mb-4">
                <div class="card-body text-start p-3 w-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="w-100">
                                <p class="text-sm text-secondary mb-1">Door 1</p>
                                <h4 class="mb-2 font-weight-bold">Close</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-3 mb-xl-0">
            <div class="card border shadow-xs mb-4">
                <div class="card-body text-start p-3 w-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="w-100">
                                <p class="text-sm text-secondary mb-1">Door 1</p>
                                <h4 class="mb-2 font-weight-bold">Close</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-3 mb-xl-0">
            <div class="card border shadow-xs mb-4">
                <div class="card-body text-start p-3 w-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="w-100">
                                <p class="text-sm text-secondary mb-1">Door 1</p>
                                <h4 class="mb-2 font-weight-bold">Close</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
