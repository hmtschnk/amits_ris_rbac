<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Mock the user group tracking data expected by topnav
        $userGroupSel = [
            ['id' => '1', 'name' => 'Admin Group'],
            ['id' => '2', 'name' => 'Radiologist Group']
        ];
        $userGroupName = 'Admin';

        // 2. Mock counts matching your layout screen image
        $uploaded = collect(array_fill(0, 500, null)); // Displays 500
        $storage  = collect(array_fill(0, 4864, null)); // Displays 4864
        $new      = collect(array_fill(0, 20, null));  // Displays 20
        $assign   = collect(array_fill(0, 7, null));   // Displays 7
        $review   = collect(array_fill(0, 142799, null)); // Displays 142,799

        // 3. Mock data for the line charts (Total Service Completed By Month)
        // Order: Jul, Aug, Sep, Oct, Nov, Dec, Jan, Feb, Mar, Apr, May, Jun
        $summary_monthly = [11000, 10000, 9000, 10500, 10300, 10400, 11000, 9800, 9200, 11500, 11000, 7500];
        
        // Daily trend mock points (Upload Case vs Image View)
        $summary_month_daily = array_fill(0, 30, 400); 

        // 4. Mock data for the Radiologist Summary Table
        $summary_radiologist = [
            (object)[ 'radiologist_name' => 'Dr. Abdul Rahman', 'assign' => 5, 'final_report' => 1250 ],
            (object)[ 'radiologist_name' => 'Dr. Isa Azzaki', 'assign' => 2, 'final_report' => 980 ],
        ];

        return view('dashboard.dashboard', [
            'userGroupSel'  => $userGroupSel,
            'userGroupName' => $userGroupName,
            'submit'        => '#',
            'showMyself'    => false,
            'uploaded'      => $uploaded,
            'storage'       => $storage,
            'new'           => $new,
            'assign'        => $assign,
            'review'        => $review,
            'month'         => 12, // Show layout text 'For last 12 months'
            
            // X-Ray Facility structural variables
            'xray_facility'        => 632,
            'xray_facility_active' => 617,
            'radiologist'          => 19,

            // Modality breakdown pie chart values
            'xray_cr' => 30,
            'xray_dx' => 45,
            'xray_mg' => 10,
            'xray_us' => 8,
            'xray_ct' => 5,
            'xray_mr' => 2,

            // Charts data arrays
            'summary_monthly'     => $summary_monthly,
            'summary_month_daily' => $summary_month_daily,
            'summary_radiologist' => $summary_radiologist
        ]);
    }
}
