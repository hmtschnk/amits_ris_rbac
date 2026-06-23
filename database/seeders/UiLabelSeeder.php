<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UiLabel;

class UiLabelSeeder extends Seeder
{
    public function run(): void
    {
        $labels = [
            'dsb_asof'            => 'as of',
            'dsb_forlast'         => 'For last',
            'dsb_months'          => 'months',
            'dsb_graph1_title'    => 'Total Service Completed by Month',
            'dsb_graph2_title'    => 'Upload Case vs Image View',
            'dsb_summary_rad'     => 'Summary By Radiologist / Cardiologist',
            'dsb_name_rad'        => 'Name',
            'dsb_total'           => 'Total',
            'dsb_graph1_complete' => 'Completed',
            'dsb_graph1_late'     => 'Late',
            'dsb_graph1_ontime'   => 'On Time',
            'dsb_graph1_y'        => 'Cases',
            'dsb_graph1_x'        => 'Months',
            'dsb_graph2_upload'   => 'Uploaded',
            'dsb_graph2_view'     => 'Views',
            'dsb_graph2_y'        => 'Total Count',
            'dsb_graph2_x'        => 'Days',
        ];

        foreach ($labels as $key => $text) {
            UiLabel::updateOrCreate(
                ['label_key' => $key, 'language' => 'en'],
                ['label_text' => $text]
            );
        }
    }
}