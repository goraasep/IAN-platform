<tbody wire:poll.5000ms="update">
    @foreach ($site->devices as $device)
        @foreach ($device->parameters as $parameter)
            @if ($parameter->alert != 'Normal')
                <tr>
                    <td>
                        <p class="text-sm text-dark font-weight-semibold mb-0 text-center">{{ $parameter->name }}</p>
                        <p class="text-sm text-secondary mb-0 text-center">{{ $device->name }}</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <span
                            class="badge badge-sm border {{ $parameter->alert == 'High' ? 'border-danger text-danger bg-danger' : 'border-warning text-warning bg-warning' }} ">{{ $parameter->alert }}</span>
                    </td>
                    {{-- <td class="align-middle text-center">
                        <span class="text-secondary text-sm font-weight-normal">$parameter</span>
                    </td> --}}
                </tr>
            @endif
        @endforeach
    @endforeach
</tbody>
