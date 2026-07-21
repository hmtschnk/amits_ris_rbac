<?php

namespace App\Http\Controllers;



use App\Models\PatientReferral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientReferralController extends Controller
{

    public function listing(Request $request)
   {
    $query = PatientReferral::query();

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
    
    $search = $request->submit === 'reset' ? [] : $request->all();

    /** @var \App\Models\User $user */
    $user = Auth::user();

    $showReferringClinic = true;
    $showXrayPanel = true;
    $showAddButton = $user->hasPermission('Patient Referral', 'patref_btn_add', 'EDIT'); 
    $showDeleteButton = $user->hasPermission('Patient Referral', 'patref_btn_delete', 'EDIT'); 

    $isViewOnly = !$showAddButton && !$showDeleteButton && $user->hasPermission('Patient Referral', 'patref_view_list', 'VIEW');

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
        'isViewOnly'
    ));
   }
   

    public function create()
    {
        // 1. Hardcoded X-ray Types list
        $xrayTypes = [
            'Plain X-Ray',
            'Mammogram',
            'Ultrasound/Echocardiography',
            'CT Scan',
            'MRI',
            'Electrocardiogram'
        ];

        // 2. Mocking object structures 
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

   
    public function store(Request $request)
    {
        PatientReferral::create([
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
            ->with('success', 'Patient referral created successfully');
    }
  

   public function edit($id)
  {
    $record = PatientReferral::findOrFail($id);

    /** @var \App\Models\User $user */
    $user = Auth::user();

    $hasEditPermission = $user->hasPermission('Patient Referral', 'patref_btn_add', 'EDIT') || 
                          $user->hasPermission('Patient Referral', 'patref_btn_delete', 'EDIT');

   
    $isViewOnly = !$hasEditPermission && $user->hasPermission('Patient Referral', 'patref_view_list', 'VIEW');

    $xrayTypes = [
        'Plain X-Ray',
        'Mammogram',
        'Ultrasound/Echocardiography',
        'CT Scan',
        'MRI',
        'Electrocardiogram'
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

    return view('patient_referral.form', compact('record', 'xrayTypes', 'referringClinic', 'xrayPanel','isViewOnly' ));
   }
    
    
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

    
    public function delete($id)
    {
        $record = PatientReferral::findOrFail($id);

        $record->delete();

        return redirect()
            ->route('patient_referral.listing')
            ->with('success', 'Patient referral deleted successfully');
    }

   
    public function view($id)
    {
        $record = PatientReferral::findOrFail($id);

        return view('patient_referral.form', compact('record'));
    }
}
