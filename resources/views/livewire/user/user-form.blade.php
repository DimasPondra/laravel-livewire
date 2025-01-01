<div>
    @if($isOpen)
        <!-- Overlay -->
        <div class="modal-backdrop fade show"></div>

        <div class="modal fade show" tabindex="-1" style="display: block;">
            <div class="modal-dialog modal-lg modal-fullscreen-lg-down modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">{{ empty($userId) ? 'Create ' : 'Edit ' }} User</h5>
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
    
                            <div class="row">
                                <div class="col-md-6 col-12">
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
                                </div>

                                <div class="col-md-6 col-12">
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
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="mb-3">
                                        <label for="provinceId" class="form-label">
                                            Province
                                            <span class="required text-danger">*</span>
                                        </label>
                                        <select 
                                            class="form-select @error('provinceId') is-invalid @enderror" 
                                            wire:model.live="provinceId"
                                        >
                                            <option selected>Select a province</option>
                                            @foreach ($provinces as $province)
                                                <option value={{ $province->id }}>{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('provinceId') 
                                            <span class="error">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-3">
                                        <label for="cityId" class="form-label">
                                            City
                                            <span class="required text-danger">*</span>
                                        </label>
                                        <select 
                                            class="form-select @error('cityId') is-invalid @enderror" 
                                            wire:model.live="cityId"
                                        >
                                            <option selected>Select a city</option>
                                            @foreach ($cities as $city)
                                                <option value={{ $city->id }}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cityId') 
                                            <span class="error">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-3">
                                        <label for="subdistrictId" class="form-label">
                                            Subdistrict
                                            <span class="required text-danger">*</span>
                                        </label>
                                        <select 
                                            class="form-select @error('subdistrictId') is-invalid @enderror" 
                                            wire:model.live="subdistrictId"
                                        >
                                            <option selected>Select a subdistrict</option>
                                            @foreach ($subdistricts as $subdistrict)
                                                <option value={{ $subdistrict->id }}>{{ $subdistrict->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('subdistrictId') 
                                            <span class="error">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">
                                    Address
                                    <span class="required text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('address') is-invalid @enderror" 
                                    id="address" 
                                    wire:model="address"
                                >
                                @error('address') 
                                    <span class="error">{{ $message }}</span> 
                                @enderror
                            </div>
                        </form>
                    </div>
    
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-light text-dark me-auto" wire:click="closeModal">Close</button>
                        <button type="button" class="btn btn-success" wire:click="save">
                            {{ empty($userId) ? 'Create ' : 'Edit ' }} User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>