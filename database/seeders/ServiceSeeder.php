<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Catalog aligned with files under public/services-images (see resolveImagePath).
     *
     * @return list<array{name: string, description: string, duration: int, price: string, image_path: string}>
     */
    protected function catalog(): array
    {
        return [
            [
                'name' => 'AC Tune-Up & Performance',
                'description' => 'Seasonal maintenance: inspect refrigerant levels, clean coils and condensate line, test airflow and thermostat calibration, and note any parts nearing replacement.',
                'duration' => 90,
                'price' => '129.00',
                'image_path' => 'services-images/ac_coolcare/ac_tune_up.png',
            ],
            [
                'name' => 'Coolant Renewal Service',
                'description' => 'Recover and recharge coolant to manufacturer spec, pressure-test lines, and document any seepage that should be scheduled for repair.',
                'duration' => 75,
                'price' => '99.00',
                'image_path' => 'services-images/ac_coolcare/coolant_renewal_service.png',
            ],
            [
                'name' => 'Split AC Setup',
                'description' => 'Mount indoor and outdoor units, run line set and drain, vacuum the circuit, leak-check, and commission with a full startup report for warranty records.',
                'duration' => 240,
                'price' => '449.00',
                'image_path' => 'services-images/ac_coolcare/split_ac_setup.png',
            ],
            [
                'name' => 'AC Filter Replacement & Airflow Tune',
                'description' => 'Replace filters (customer-supplied or standard size on truck stock), inspect blower and return path, and advise on upgrade filters if allergies or pets are a concern.',
                'duration' => 45,
                'price' => '59.00',
                'image_path' => 'services-images/ac_coolcare/filter_replacement.png',
            ],
            [
                'name' => 'Clogged Drain Cleaning',
                'description' => 'Kitchen or bath drains cleared with auger and safe mechanical methods; includes camera-ready flow test and simple maintenance tips to slow buildup.',
                'duration' => 50,
                'price' => '79.00',
                'image_path' => 'services-images/plumber/clogged_drain_cleaning_1.png',
            ],
            [
                'name' => 'Leak Repair',
                'description' => 'Locate and repair leaks on exposed supply or drain lines under sinks and vanities; includes basic materials. Concealed-wall work quoted separately.',
                'duration' => 75,
                'price' => '115.00',
                'image_path' => 'services-images/plumber/leak_repair_2.png',
            ],
            [
                'name' => 'Tank Water Heater Installation',
                'description' => 'Remove old unit where accessible, install new 40–50 gal electric or gas heater per code, fill and purge, set temperature safely, and walk through warranty paperwork.',
                'duration' => 210,
                'price' => '485.00',
                'image_path' => 'services-images/plumber/water_heater_installation_1.png',
            ],
            [
                'name' => 'Sewer Line Cleaning',
                'description' => 'Main-line auger or hydro assist to restore flow from multiple slow fixtures; includes one cleanout access and post-run flow verification.',
                'duration' => 120,
                'price' => '189.00',
                'image_path' => 'services-images/plumber/sewer_line_cleaning.png',
            ],
            [
                'name' => 'Indoor Lighting Installation',
                'description' => 'Install pendants, recessed retrofits, or chandeliers on existing boxes; includes grounding check, dimmer compatibility, and neat cable dressing.',
                'duration' => 120,
                'price' => '155.00',
                'image_path' => 'services-images/electrician/indoor_lighting_installation_1.png',
            ],
            [
                'name' => 'Electrical Fault Diagnosis',
                'description' => 'Methodical testing for tripping breakers, dead outlets, and nuisance trips; written findings with prioritized repair options—no surprise add-ons without approval.',
                'duration' => 90,
                'price' => '125.00',
                'image_path' => 'services-images/electrician/fault_diagnosis_2.png',
            ],
            [
                'name' => 'Deep House Cleaning',
                'description' => 'Living areas, kitchen, and baths: dusting high/low, appliance fronts, floors mopped or vacuumed, and bathroom sanitization. Ideal before events or move-in.',
                'duration' => 240,
                'price' => '219.00',
                'image_path' => 'services-images/cleaning/full_house_cleaning_1.jpeg',
            ],
            [
                'name' => 'Office Cleaning',
                'description' => 'Desks, kitchenette, restrooms, trash, and vacuumed traffic lanes for teams up to ~15 desks; supplies included except specialty floor waxing.',
                'duration' => 120,
                'price' => '169.00',
                'image_path' => 'services-images/cleaning/office_cleaning_1.png',
            ],
            [
                'name' => 'Carpet Cleaning',
                'description' => 'Hot-water extraction for high-traffic rooms with pre-treat on common stains; furniture left in place where safe, blocks quoted if moving heavy pieces.',
                'duration' => 100,
                'price' => '139.00',
                'image_path' => 'services-images/cleaning/carpet_cleaning_1.png',
            ],
            [
                'name' => 'Engine Diagnostics',
                'description' => 'OBD-II readout, live data review, and basic sensor checks with plain-English summary—perfect when a warning light appears but the car still drives.',
                'duration' => 60,
                'price' => '89.00',
                'image_path' => 'services-images/automotive_care/engine_diagnostics.png',
            ],
            [
                'name' => 'Oil Change & Fluid Top-Up',
                'description' => 'Synthetic or conventional oil and filter per spec, plus quick checks on coolant, brake fluid, and washer fluid with sticker for next due date.',
                'duration' => 45,
                'price' => '79.00',
                'image_path' => 'services-images/automotive_care/oil_change_and_fluid_checks.png',
            ],
            [
                'name' => 'Cabinet Fix & Refinish',
                'description' => 'Rehang crooked doors, adjust soft-close hinges, tighten hardware, and spot touch-up on chips and worn edges to extend cabinet life before a full remodel.',
                'duration' => 150,
                'price' => '185.00',
                'image_path' => 'services-images/carpenter/cabinet_fix_and_refinish_1.png',
            ],
            [
                'name' => 'Wedding Photography',
                'description' => 'Full-day coverage with edited highlight set, online gallery, and print release. Timeline and family shot list finalized at pre-event consult.',
                'duration' => 480,
                'price' => '2199.00',
                'image_path' => 'services-images/photography/wedding_photography_1.png',
            ],
            [
                'name' => 'Haircut & Styling',
                'description' => 'Consultation, precision cut, shampoo, and blow-dry style—suitable for maintenance trims or a fresh shape before travel or interviews.',
                'duration' => 60,
                'price' => '58.00',
                'image_path' => 'services-images/salon/haircut_and_styling_1.png',
            ],
            [
                'name' => 'Custom Cake Creations',
                'description' => 'Tiered or sculpted cake with buttercream or fondant finish; tasting flight for two and sketch approval included for orders placed 10+ days ahead.',
                'duration' => 180,
                'price' => '245.00',
                'image_path' => 'services-images/cooking/custom_cake_creations_1.png',
            ],
            [
                'name' => 'Interior Room Painting (One Room)',
                'description' => 'Move light furniture, mask trim, patch minor holes, two coats ceiling-height walls in customer color, and leave brushes/rollers tidied same day.',
                'duration' => 300,
                'price' => '349.00',
                'image_path' => 'services-images/painter/whole_room_painting_1.png',
            ],
            [
                'name' => 'Shrub & Small Tree Pruning',
                'description' => 'Shape ornamentals, remove deadwood, and clear paths for walkways and windows—debris hauled to curb for municipal pickup where allowed.',
                'duration' => 120,
                'price' => '95.00',
                'image_path' => 'services-images/gardener/pruning_and_trimming_1.png',
            ],
            [
                'name' => 'Targeted Bed Bug Treatment',
                'description' => 'Inspection, localized heat/chemical protocol per room severity, mattress encasement advice, and follow-up checklist to protect neighboring units.',
                'duration' => 180,
                'price' => '329.00',
                'image_path' => 'services-images/pest_control/bed_bug_eradication_1.png',
            ],
            [
                'name' => 'Home Theater & TV Wall Setup',
                'description' => 'Mount TV, route cables in stud-safe channels, connect soundbar or receiver, and tune picture modes—remote training included for the household.',
                'duration' => 180,
                'price' => '279.00',
                'image_path' => 'services-images/smart_home/home_theater_setup_2.png',
            ],
            [
                'name' => 'High-Touch Surface Disinfection',
                'description' => 'EPA-listed products on knobs, switches, rails, and shared desks—popular between tenant turns, after illness, or before open houses.',
                'duration' => 90,
                'price' => '159.00',
                'image_path' => 'services-images/sanitization/high_touch_point_disinfection_1.png',
            ],
            [
                'name' => 'Garment Hemming & Length Adjustment',
                'description' => 'Pin-fit hems on trousers, skirts, or sleeves; matching thread and blind or topstitch finish based on fabric—rush options when the queue allows.',
                'duration' => 75,
                'price' => '48.00',
                'image_path' => 'services-images/tailor/hemming_and_length_adjustment_3.png',
            ],
        ];
    }

    protected function resolveImagePath(string $relativePath): ?string
    {
        $full = public_path($relativePath);

        return is_file($full) ? $relativePath : null;
    }

    public function run(): void
    {
        foreach ($this->catalog() as $row) {
            $imagePath = $this->resolveImagePath($row['image_path']);

            if ($imagePath === null && isset($this->command)) {
                $this->command->warn("ServiceSeeder: missing image file, skipping path — {$row['image_path']} ({$row['name']})");
            }

            Service::query()->updateOrCreate(
                ['name' => $row['name']],
                [
                    'description' => $row['description'],
                    'duration' => $row['duration'],
                    'price' => $row['price'],
                    'image_path' => $imagePath,
                ]
            );
        }
    }
}
