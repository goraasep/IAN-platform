<div style="text-align: center">
    {{-- <button wire:click="increment">+</button>
    <h1>{{ $count }}</h1> --}}
    <div wire:poll.1000ms="increment">
        Current time: {{ now() }}
        <h1>{{ $count }}</h1>
    </div>
</div>
