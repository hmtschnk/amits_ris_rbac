<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

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

        // 2. Mock counts matching the layout metrics
        $uploaded = collect(array_fill(0, 500, null));  // Displays 500
        $storage  = collect(array_fill(0, 4864, null)); // Displays 4864
        $new      = collect(array_fill(0, 20, null));   // Displays 20
        $assign   = collect(array_fill(0, 7, null));    // Displays 7
        $review   = collect(array_fill(0, 142799, null)); // Displays 142,799

        // 3. IMPROVED: Structured Monthly Mock (Matches HomeController Raw Query)
        // Expected columns: bulan, mon, final_report, islate
        $months = ['Jul (2025)', 'Aug (2025)', 'Sep (2025)', 'Oct (2025)', 'Nov (2025)', 'Dec (2025)', 'Jan (2026)', 'Feb (2026)', 'Mar (2026)', 'Apr (2026)', 'May (2026)', 'Jun (2026)'];
        $monthly_values = [11000, 10000, 9000, 10500, 10300, 10400, 11000, 9800, 9200, 11500, 11000, 7500];
        
        $summary_monthly = [];
        foreach ($months as $index => $monName) {
            // Mock a database-style month timestamp
            $monthNum = ($index + 7) > 12 ? ($index - 5) : ($index + 7);
            $year = ($index + 7) > 12 ? 2026 : 2025;
            $bulanTimestamp = sprintf("%04d-%02d-01 00:00:00", $year, $monthNum);

            $summary_monthly[] = (object)[
                'bulan'        => $bulanTimestamp,
                'mon'          => $monName,
                'final_report' => $monthly_values[$index],
                'islate'       => rand(200, 800) // Mocked late cases for visual depth
            ];
        }
        
        // 4. IMPROVED: Structured Daily Mock (Matches HomeController 30-Day Query)
        // Expected columns: hari, dd, upload_case, view_image
        $summary_month_daily = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $summary_month_daily[] = (object)[
                'hari'        => $date->format('Y-m-d 00:00:00'),
                'dd'          => $date->format('d-M'),
                'upload_case' => rand(300, 500), // Simulates daily changes
                'view_image'  => rand(400, 800)  // Simulates image-view daily activity
            ];
        }

        // 5. Mock data for the Radiologist Summary Table
        $summary_radiologist = [
            (object)[ 'radiologist_name' => 'Dr. Abdul Rahman', 'assign' => 5, 'final_report' => 1250 ],
            (object)[ 'radiologist_name' => 'Dr. Isa Azzaki', 'assign' => 2, 'final_report' => 980 ],
        ];

        // 6. Safeguards: Mock due limits in case of direct references
        $dueMock = (object)['due' => 0, 'warning' => 0];

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
            
            // Due stats structures
            'due_uploaded'  => $dueMock,
            'due_new'       => $dueMock,
            'due_assign'    => $dueMock,
            'due_review'    => $dueMock,

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
            'summary_radiologist' => $summary_radiologist,
            'ads'                 => [] // Prevent failures if the advertisement section is uncommented
        ]);
    }
}