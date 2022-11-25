<button style="outline: none;box-shadow: none;" class="btn btn-sm btn-icon mb-0 me-2 border-0" data-bs-toggle="modal"
    data-bs-target="#editParamModal-{{ $parameter->id }}">
    <span class="btn-inner--icon">
        <i class="fa-solid fa-pen-to-square"></i>
    </span>
    {{-- <span class="btn-inner--text">Add Parameter</span> --}}
</button>
<button style="outline: none;box-shadow: none;" class="btn btn-sm btn-icon mb-0 me-2 border-0" data-bs-toggle="modal"
    data-bs-target="#deleteParamModal-{{ $parameter->id }}">
    <span class="btn-inner--icon">
        <i class="fa-solid fa-trash"></i>
    </span>
    {{-- <span class="btn-inner--text">Add Parameter</span> --}}
</button>

<!-- Modal -->
<div class="modal fade" id="editParamModal-{{ $parameter->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/parameter/{{ $parameter->slug }}">
                @method('put')
                @csrf
                <input type="text" class="form-control" id="device-uuid" name="uuid" value="{{ $device_uuid }}"
                    hidden required>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit {{ $parameter->name }}
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body text-start mx-3">
                    <div class="form-group">
                        <label for="parameter-unit" class="col-form-label">Unit:</label>
                        <input type="text" class="form-control" id="parameter-unit" name="unit"
                            value="{{ old('unit', $parameter->unit) }}">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="parameter-th-H" class="col-form-label">Threshold
                                    High:</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" step="any" class="form-control" id="parameter-th-H"
                                    name="th_H" value="{{ old('th_H', $parameter->th_H) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-select" name="th_H_enable">
                                    <option value="0" @if (old('th_H_enable', $parameter->th_H_enable) == 0) selected @endif>Disable
                                    </option>
                                    <option value="1" @if (old('th_H_enable', $parameter->th_H_enable) == 1) selected @endif>Enable
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="parameter-th-L" class="col-form-label">Threshold
                                    Low:</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" step="any" class="form-control" id="parameter-th-L"
                                    name="th_L" value="{{ old('th_L', $parameter->th_L) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-select" name="th_L_enable">
                                    <option value="0" @if (old('th_L_enable', $parameter->th_L_enable) == 0) selected @endif>Disable
                                    </option>
                                    <option value="1" @if (old('th_L_enable', $parameter->th_L_enable) == 1) selected @endif>Enable
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="parameter-max" class="col-form-label">Maximum Value:</label>
                        <input type="text" class="form-control" id="parameter-max" name="max"
                            value="{{ old('max', $parameter->max) }}">
                    </div>
                    <div class="form-group">
                        <label for="parameter-min" class="col-form-label">Minimum Value:</label>
                        <input type="text" class="form-control" id="parameter-min" name="min"
                            value="{{ old('min', $parameter->min) }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteParamModal-{{ $parameter->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/parameter/{{ $parameter->slug }}">
                @method('delete')
                @csrf
                <input type="text" class="form-control" id="device-uuid" name="uuid"
                    value="{{ $device_uuid }}" hidden required>
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="text-gradient text-danger mt-4">Delete {{ $parameter->name }} ?</h4>
                        <p>You will not be able to restore deleted parameter.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
