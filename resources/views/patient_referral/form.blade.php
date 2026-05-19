@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => isset($record) ? 'Edit Patient Referral' : 'Patient Referral Form'])
    <div class="row mt-4 mx-4">
        {{-- @include('components.alert') --}}
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form role="form" method="POST" action="{{ isset($record) ? route('patient_referral.update', $record->id) : route('patient_referral.store') }}">
                        
                        @csrf
                        @if(isset($record))
                            @method('PUT')
                        @endif

                        {{-- Row 1: Patient ID, Patient Name, Gender, Age --}}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="patient_id" class="form-control-label">Patient ID <span class="text-danger">*</span></label>
                                    <input type="text" 
                                        class="form-control text-xs" 
                                        id="patient_id" 
                                        name="patient_id" 
                                        value="{{ $record->patient_id ?? old('patient_id') }}" 
                                        required>
                                    @error('patient_id')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="patient_name" class="form-control-label">Patient Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                        class="form-control text-xs" 
                                        id="patient_name" 
                                        name="patient_name" 
                                        value="{{ $record->patient_name ?? old('patient_name') }}" 
                                        required>
                                    @error('patient_name')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="gender" class="form-control-label">Gender <span class="text-danger">*</span></label>
                                    <select name="gender" 
                                            id="gender" 
                                            class="form-select form-control text-xs" 
                                            required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ ($record->gender ?? old('gender')) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ ($record->gender ?? old('gender')) == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="age" class="form-control-label">Age <span class="text-danger">*</span></label>
                                    <input type="number" 
                                        class="form-control text-xs" 
                                        id="age" 
                                        name="age" 
                                        min="0" 
                                        max="150" 
                                        value="{{ $record->age ?? old('age') }}" 
                                        required>
                                    @error('age')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Row 2: Birthdate, Patient Email, X-ray Type, Referring Dr --}}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="birthdate" class="form-control-label">Birthdate (optional)</label>
                                    <input type="date" 
                                        class="form-control text-xs" 
                                        id="birthdate" 
                                        name="birthdate" 
                                        value="{{ isset($record) && $record->birthdate ? $record->birthdate->format('Y-m-d') : old('birthdate') }}">                                           
                                    @error('birthdate')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="patient_email" class="form-control-label">Patient Email (optional)</label>
                                    <input type="email" 
                                        class="form-control text-xs" 
                                        id="patient_email" 
                                        name="patient_email" 
                                        value="{{ $record->patient_email ?? old('patient_email') }}" 
                                        placeholder="patient@example.com">
                                    @error('patient_email')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                               <div class="form-group">
                                    <label for="xray_type_id" class="form-control-label">X-ray Type (optional)</label>
                                    <select name="xray_type_id" id="xray_type_id" class="form-select form-control text-xs">
                                        <option value="">Select X-ray Type</option>
                                        @foreach($xrayTypes as $type)
                                            <option value="{{ $type }}" 
                                                {{ ($record->xray_type_id ?? old('xray_type_id') ?? 'Plain X-Ray') == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="referring_dr" class="form-control-label">Referring Dr. (optional)</label>
                                    <input type="text" 
                                        class="form-control text-xs" 
                                        id="referring_dr" 
                                        name="referring_dr" 
                                        value="{{ $record->referring_dr ?? old('referring_dr') }}" 
                                        placeholder="Dr. Name">
                                    @error('referring_dr')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Clinical Reason --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="clinical_reason" class="form-control-label">Clinical Reason <span class="text-danger">*</span></label>
                                    <textarea class="form-control text-xs" 
                                            id="clinical_reason" 
                                            name="clinical_reason" 
                                            rows="4" 
                                            placeholder="Describe the clinical reason for this X-ray referral..."
                                            required>{{ $record->clinical_reason ?? old('clinical_reason') }}</textarea>
                                    @error('clinical_reason')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                       {{-- Clinic Information --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="referring_clinic_info" class="form-control-label">Referring Clinic</label>
                                    <div class="form-control text-xs bg-light" 
                                        style="min-height: 120px; white-space: pre-line; padding: 8px 12px;">
                                        <strong>{{ $referringClinic->name }}</strong>
                                        {{ trim(collect([
                                            $referringClinic->address1,
                                            $referringClinic->address2,
                                            $referringClinic->address3,
                                            $referringClinic->address4,
                                            trim(collect([
                                                $referringClinic->postal,
                                                $referringClinic->city,
                                                $referringClinic->state
                                            ])->filter()->implode(' '))
                                        ])->filter()->implode("\n")) ?: 'No address available' }}
                                        @if($referringClinic->company && $referringClinic->company->phone)
                                        Tel: {{ $referringClinic->company->phone }}
                                        @endif
                                    </div>
                                    {{-- This passes the hardcoded ID when you hit Save --}}
                                    <input type="hidden" name="referring_clinic_id" value="{{ $referringClinic->id }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="xray_panel_info" class="form-control-label">X-ray Panel</label>
                                    <div class="form-control text-xs bg-light" 
                                        style="min-height: 120px; white-space: pre-line; padding: 8px 12px;">
                                        <strong>{{ $xrayPanel->name }}</strong>
                                        {{ trim(collect([
                                            $xrayPanel->address1,
                                            $xrayPanel->address2,
                                            $xrayPanel->address3,
                                            $xrayPanel->address4,
                                            trim(collect([
                                                $xrayPanel->postal,
                                                $xrayPanel->city,
                                                $xrayPanel->state
                                            ])->filter()->implode(' '))
                                        ])->filter()->implode("\n")) ?: 'No address available' }}
                                        @if($xrayPanel->company && $xrayPanel->company->phone)
                                        Tel: {{ $xrayPanel->company->phone }}
                                        @endif
                                    </div>
                                    {{-- This passes the hardcoded ID when you hit Save --}}
                                    <input type="hidden" name="xray_panel_id" value="{{ $xrayPanel->id }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('patient_referral.listing') }}" class="btn btn-outline-secondary btn-sm me-2">
                                <i class="fa fa-times pe-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-save pe-1"></i>{{ isset($record) ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('layouts.footers.auth.footer') --}}
@endsection

@push('js')
<script>
    // Auto-calculate age from birthdate
    $('#birthdate').on('change', function() {
        const birthdate = new Date($(this).val());
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        const monthDiff = today.getMonth() - birthdate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }
        
        $('#age').val(age);
    });
</script>
@endpush