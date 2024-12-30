<div>
    @if($isOpen)
        <div class="modal fade show" tabindex="-1" style="display: block;">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form</h5>
                        <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                    </div>
    
                    <div class="modal-body">
                        <form wire:submit.prevent="save">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Fullname
                                    <span class="required text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    wire:model="name"
                                >
                                @error('name') 
                                    <span class="error">{{ $message }}</span> 
                                @enderror
                            </div>
    
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email
                                    <span class="required text-danger">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    wire:model="email"
                                >
                                @error('email') 
                                    <span class="error">{{ $message }}</span> 
                                @enderror
                            </div>
    
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    Password
                                    @empty($userId)
                                        <span class="required text-danger">*</span>
                                    @endempty
                                </label>
                                <input 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    wire:model="password"
                                >
                                @error('password') 
                                    <span class="error">{{ $message }}</span> 
                                @enderror
                            </div>
                        </form>
                    </div>
    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                        <button type="button" class="btn btn-primary" wire:click="save">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>