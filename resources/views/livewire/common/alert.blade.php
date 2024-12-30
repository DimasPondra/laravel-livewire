<div>
    @if ($isAlert)
        @if ($status === 'success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" wire:click="closeAlert"></button>
            </div>
        @else
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" wire:click="closeAlert"></button>
            </div>
        @endif
    @endif
</div>
