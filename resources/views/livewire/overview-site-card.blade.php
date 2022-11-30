<div wire:poll.5000ms="update">
    <h4 class="mb-2 font-weight-bold">
        {{ $single_value }}
    </h4>
    <div class="d-flex align-items-center">
        <span class="text-sm">Last Updated: {{ $created_at }}</span>
    </div>
</div>
