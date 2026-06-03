<?php

namespace App\Http\Controllers;



use App\Models\PatientReferral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientReferralController extends Controller
{
    /**
     * LISTING PAGE
     */
    public function listing(Request $request)
   {
    $query = PatientReferral::query();

    // If reset button clicked, ignore all filters
    if ($request->submit !== 'reset') {
        if ($request->patient_id) {
            $query->where('patient_id', 'LIKE', '%' . $request->patient_id . '%');
        }
        if ($request->patient_name) {
            $query->where('patient_name', 'LIKE', '%' . $request->patient_name . '%');
        }
        if ($request->referring_clinic_id) {
            $query->where('referring_clinic', $request->referring_clinic_id);
        }
        if ($request->xray_panel_id) {
            $query->where('xray_panel', $request->xray_panel_id);
        }
    }

    $referrals = $query->latest()->paginate(10);
    
    // Clear search data if reset
    $search = $request->submit === 'reset' ? [] : $request->all();

    /** @var \App\Models\User $user */
    $user = Auth::user();

    $showReferringClinic = true;
    $showXrayPanel = true;
    $showAddButton = true;
    $showDeleteButton = $user ? $user->hasRoles(['MASTER_ADMIN', 'MANAGER']) : false;

    $referringClinicSel = [
        'SENA REFERRING CLINIC (TESTING 1)' => 'SENA REFERRING CLINIC (TESTING 1)',
    ];

    $xrayPanelSel = [
        'KLINIK ZAHRA GEMAS' => 'KLINIK ZAHRA GEMAS',
    ];

    return view('patient_referral.listing', compact(
        'referrals',
        'search',
        'showReferringClinic',
        'showXrayPanel',
        'showAddButton',
        'showDeleteButton',
        'referringClinicSel',
        'xrayPanelSel',
    ));
   }
    /**
     * SHOW CREATE FORM
     */
    public function create()
    {
        // 1. Hardcoded X-ray Types list
        $xrayTypes = [
            'Plain X-Ray',
            'Mammogram',
            'Ultrasound/Echocardiography',
            'CT Scan',
            'MRI',
            'Electricardiogram'
        ];

        // 2. Mocking object structures just to keep form.blade.php text blocks happy
        $referringClinic = (object)[
            'id' => 'SENA REFERRING CLINIC (TESTING 1)',
            'name' => 'SENA REFERRING CLINIC (TESTING 1)',
            'address1' => 'Lot 123, Jalan Bukit',
            'address2' => 'Presint 1',
            'address3' => null,
            'address4' => null,
            'postal' => '63000',
            'city' => 'Cyberjaya',
            'state' => 'Selangor',
            'company' => (object)['phone' => '+60 3-1234 5678']
        ];

        $xrayPanel = (object)[
            'id' => 'KLINIK ZAHRA GEMAS',
            'name' => 'KLINIK ZAHRA GEMAS',
            'address1' => 'No. 45, Main Road',
            'address2' => 'Pekan Gemas',
            'address3' => null,
            'address4' => null,
            'postal' => '73200',
            'city' => 'Gemas',
            'state' => 'Negeri Sembilan',
            'company' => (object)['phone' => '+60 6-8765 4321']
        ];

        return view('patient_referral.form', compact('xrayTypes', 'referringClinic', 'xrayPanel'));
    }

    /**
     * STORE DATA
     */
    public function store(Request $request)
    {
        // Save form inputs directly as raw text data strings to match database schema columns
        PatientReferral::create([
            'patient_id'       => $request->patient_id,
            'patient_name'     => $request->patient_name,
            'gender'           => $request->gender,
            'age'              => $request->age,
            'xray_type_id'     => $request->xray_type_id, // This holds the string 'Plain X-Ray', etc.
            
            // Add these missing fields so they are actually saved on creation:
            'birthdate'        => $request->birthdate,
            'patient_email'    => $request->patient_email,
            'referring_dr'     => $request->referring_dr,
            'clinical_reason'  => $request->clinical_reason,
            
            'referring_clinic' => $request->referring_clinic_id, // Saves string 'SENA REFERRING CLINIC (TESTING 1)'
            'xray_panel'       => $request->xray_panel_id,       // Saves string 'KLINIK ZAHRA GEMAS'
        ]);

        return redirect()
            ->route('patient_referral.listing')
            ->with('success', 'Patient referral created successfully');
    }
    /**
     * EDIT PAGE
     */
   public function edit($id)
  {
    $record = PatientReferral::findOrFail($id);

    $xrayTypes = [
        'Plain X-Ray',
        'Mammogram',
        'Ultrasound/Echocardiography',
        'CT Scan',
        'MRI',
        'Electricardiogram'
    ];

    $referringClinic = (object)[
        'id'      => 'SENA REFERRING CLINIC (TESTING 1)',
        'name'    => 'SENA REFERRING CLINIC (TESTING 1)',
        'address1'=> 'Lot 123, Jalan Bukit',
        'address2'=> 'Presint 1',
        'address3'=> null,
        'address4'=> null,
        'postal'  => '63000',
        'city'    => 'Cyberjaya',
        'state'   => 'Selangor',
        'company' => (object)['phone' => '+60 3-1234 5678']
    ];

    $xrayPanel = (object)[
        'id'      => 'KLINIK ZAHRA GEMAS',
        'name'    => 'KLINIK ZAHRA GEMAS',
        'address1'=> 'No. 45, Main Road',
        'address2'=> 'Pekan Gemas',
        'address3'=> null,
        'address4'=> null,
        'postal'  => '73200',
        'city'    => 'Gemas',
        'state'   => 'Negeri Sembilan',
        'company' => (object)['phone' => '+60 6-8765 4321']
    ];

    return view('patient_referral.form', compact('record', 'xrayTypes', 'referringClinic', 'xrayPanel'));
   }
    
    /**
     * UPDATE DATA
     */
    public function update(Request $request, $id)
   {
    $record = PatientReferral::findOrFail($id);

    $record->update([
        'patient_id'       => $request->patient_id,
        'patient_name'     => $request->patient_name,
        'gender'           => $request->gender,
        'age'              => $request->age,
        'xray_type_id'     => $request->xray_type_id,
        'birthdate'        => $request->birthdate,
        'patient_email'    => $request->patient_email,
        'referring_dr'     => $request->referring_dr,
        'clinical_reason'  => $request->clinical_reason,
        'referring_clinic' => $request->referring_clinic_id,
        'xray_panel'       => $request->xray_panel_id,
    ]);

    return redirect()
        ->route('patient_referral.listing')
        ->with('success', 'Patient referral updated successfully');
    }

    /**
     * DELETE
     */
    public function delete($id)
    {
        $record = PatientReferral::findOrFail($id);

        $record->delete();

        return redirect()
            ->route('patient_referral.listing')
            ->with('success', 'Patient referral deleted successfully');
    }

    /**
     * VIEW DETAILS
     */
    public function view($id)
    {
        $record = PatientReferral::findOrFail($id);

        return view('patient_referral.form', compact('record'));
    }
}
