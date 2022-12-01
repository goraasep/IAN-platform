<tbody wire:poll.5000ms="update">
    @if ($dashboard)
        @foreach ($sites as $site)
            @foreach ($site->devices as $device)
                @foreach ($device->parameters as $parameter)
                    @if ($parameter->alert != 'Normal')
                        <tr>
                            <td>
                                <p class="text-sm text-dark font-weight-semibold mb-0 text-center">{{ $parameter->name }}
                                </p>
                                <p class="text-center mb-0"><a class="text-sm text-secondary"
                                        href="{{ url('devices/' . $device->uuid) }}">{{ $device->name }}</a></p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span
                                    class="badge badge-sm border {{ $parameter->alert == 'High' ? 'border-danger text-danger bg-danger' : 'border-warning text-warning bg-warning' }} ">{{ $parameter->alert }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <a class="text-secondary text-sm font-weight-normal"
                                    href="{{ url('sites/' . $site->slug) }}">{{ $site->name }}</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        @endforeach
    @else
        @foreach ($site->devices as $device)
            @foreach ($device->parameters as $parameter)
                @if ($parameter->alert != 'Normal')
                    <tr>
                        <td>
                            <p class="text-sm text-dark font-weight-semibold mb-0 text-center">{{ $parameter->name }}
                            </p>
                            <p class="text-sm text-secondary mb-0 text-center">{{ $device->name }}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <span
                                class="badge badge-sm border {{ $parameter->alert == 'High' ? 'border-danger text-danger bg-danger' : 'border-warning text-warning bg-warning' }} ">{{ $parameter->alert }}</span>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    @endif
</tbody>
