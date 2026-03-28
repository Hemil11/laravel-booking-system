<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * @return list<array{name: string, description: string, duration: int, price: string, image_path: string}>
     */
    protected function catalog(): array
    {
        return [
            [
                'name' => 'AC Tune-Up & Performance',
                'description' => 'Full inspection, coil cleaning, refrigerant check, and airflow test to keep your AC efficient and reliable.',
                'duration' => 90,
                'price' => '129.00',
                'image_path' => 'services-images/ac_coolcare/ac_tune_up.png',
            ],
            [
                'name' => 'Coolant Renewal Service',
                'description' => 'Safe coolant top-up or renewal with leak screening to restore cooling performance.',
                'duration' => 60,
                'price' => '89.00',
                'image_path' => 'services-images/ac_coolcare/coolant_renewal_service.png',
            ],
            [
                'name' => 'Split AC Setup',
                'description' => 'Professional indoor and outdoor unit mounting, piping, vacuum, and commissioning for split systems.',
                'duration' => 180,
                'price' => '249.00',
                'image_path' => 'services-images/ac_coolcare/split_ac_setup.png',
            ],
            [
                'name' => 'Clogged Drain Cleaning',
                'description' => 'Clear kitchen or bathroom drains using auger and safe solvents; includes flow test.',
                'duration' => 45,
                'price' => '75.00',
                'image_path' => 'services-images/plumber/clogged_drain_cleaning_1.png',
            ],
            [
                'name' => 'Leak Repair',
                'description' => 'Locate and repair pipe leaks under sinks or accessible lines; materials quoted if needed.',
                'duration' => 60,
                'price' => '95.00',
                'image_path' => 'services-images/plumber/leak_repair_2.png',
            ],
            [
                'name' => 'Indoor Lighting Installation',
                'description' => 'Install fixtures, dimmers, and LED upgrades with neat cable management and safety checks.',
                'duration' => 120,
                'price' => '140.00',
                'image_path' => 'services-images/electrician/indoor_lighting_installation_1.png',
            ],
            [
                'name' => 'Electrical Fault Diagnosis',
                'description' => 'Systematic testing for tripping breakers, dead outlets, and intermittent faults with a clear report.',
                'duration' => 90,
                'price' => '110.00',
                'image_path' => 'services-images/electrician/fault_diagnosis_2.png',
            ],
            [
                'name' => 'Deep House Cleaning',
                'description' => 'Top-to-bottom cleaning for living areas, kitchen, and bathrooms including floors and surfaces.',
                'duration' => 240,
                'price' => '199.00',
                'image_path' => 'services-images/cleaning/full_house_cleaning_1.jpeg',
            ],
            [
                'name' => 'Office Cleaning',
                'description' => 'Desks, common areas, restrooms, and trash service tailored to small offices.',
                'duration' => 120,
                'price' => '159.00',
                'image_path' => 'services-images/cleaning/office_cleaning_1.png',
            ],
            [
                'name' => 'Carpet Cleaning',
                'description' => 'Hot-water extraction or dry method for high-traffic rooms and stain treatment.',
                'duration' => 90,
                'price' => '125.00',
                'image_path' => 'services-images/cleaning/carpet_cleaning_1.png',
            ],
            [
                'name' => 'Engine Diagnostics',
                'description' => 'OBD scan, sensor checks, and road-test notes to pinpoint drivability or warning-light issues.',
                'duration' => 60,
                'price' => '85.00',
                'image_path' => 'services-images/automotive_care/engine_diagnostics.png',
            ],
            [
                'name' => 'Cabinet Fix & Refinish',
                'description' => 'Hinge alignment, drawer slides, touch-up, and light refinishing for kitchen cabinets.',
                'duration' => 150,
                'price' => '175.00',
                'image_path' => 'services-images/carpenter/cabinet_fix_and_refinish_1.png',
            ],
            [
                'name' => 'Wedding Photography',
                'description' => 'Coverage block with edited highlights; timeline and shot list agreed in advance.',
                'duration' => 480,
                'price' => '1899.00',
                'image_path' => 'services-images/photography/wedding_photography_1.png',
            ],
            [
                'name' => 'Haircut & Styling',
                'description' => 'Consultation, cut, blow-dry, and light styling for everyday or event-ready looks.',
                'duration' => 60,
                'price' => '55.00',
                'image_path' => 'services-images/salon/haircut_and_styling_1.png',
            ],
            [
                'name' => 'Custom Cake Creations',
                'description' => 'Bespoke layered cakes with fondant or buttercream; flavors and design confirmed before baking.',
                'duration' => 180,
                'price' => '220.00',
                'image_path' => 'services-images/cooking/custom_cake_creations_1.png',
            ],
        ];
    }

    public function run(): void
    {
        foreach ($this->catalog() as $row) {
            Service::query()->updateOrCreate(
                ['name' => $row['name']],
                [
                    'description' => $row['description'],
                    'duration' => $row['duration'],
                    'price' => $row['price'],
                    'image_path' => $row['image_path'],
                ]
            );
        }
    }
}
