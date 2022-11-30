<div class="row mt-4" wire:poll.5000ms="update">
    @foreach ($site->devices as $device)
        @foreach ($device->parameters as $parameter)
            @if ($parameter->show)
                <div class="col-xl-2 col-sm-3 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="full-background bg-primary opacity-3 p-auto"></div>
                        <div class="card-body text-start p-3 w-100">
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-primary font-weight-bold text-sm text-uppercase">
                                            {{ $device->name }}
                                        </p>
                                        <h5 class="font-weight-semibold text-lg mb-0">{{ $parameter->name }}
                                        </h5>
                                        <p class="text-sm text-secondary mb-1">Actual value:</p>
                                        @livewire('overview-site-card', ['device_id' => $device->id, 'parameter_slug' => $parameter->slug],, key($parameter->slug))
                                        {{-- <h4 class="mb-2 font-weight-bold">
                                            <span id="live_{{ $parameter->slug }}"><i
                                                    class="text-warning fa-solid fa-exclamation"></i> </span>
                                        </h4>
                                        <div class="d-flex align-items-center">
                                            <span class="text-sm">Last Updated: <span
                                                    id="updated_{{ $parameter->slug }}"></span></span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
</div>
