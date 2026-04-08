<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        // Manufacturers
        $manufacturers = [
            'Square Pharmaceuticals',
            'Beximco Pharmaceuticals',
            'Incepta Pharmaceuticals',
            'ACI Limited',
            'Opsonin Pharma',
            'Renata Limited',
            'General Pharmaceuticals',
            'Drug International',
        ];

        foreach ($manufacturers as $name) {
            DB::table('prescrip_drug_manufacturers')->insertOrIgnore([
                'name' => $name,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Drug types
        $types = ['Tablet', 'Capsule', 'Syrup', 'Injection', 'Cream', 'Ointment', 'Drop', 'Inhaler', 'Suppository', 'Powder'];

        foreach ($types as $name) {
            DB::table('prescrip_drug_type')->insertOrIgnore([
                'name' => $name,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $tabletId   = DB::table('prescrip_drug_type')->where('name', 'Tablet')->value('id');
        $capsuleId  = DB::table('prescrip_drug_type')->where('name', 'Capsule')->value('id');
        $syrupId    = DB::table('prescrip_drug_type')->where('name', 'Syrup')->value('id');
        $injId      = DB::table('prescrip_drug_type')->where('name', 'Injection')->value('id');
        $creamId    = DB::table('prescrip_drug_type')->where('name', 'Cream')->value('id');

        $square   = DB::table('prescrip_drug_manufacturers')->where('name', 'Square Pharmaceuticals')->value('id');
        $beximco  = DB::table('prescrip_drug_manufacturers')->where('name', 'Beximco Pharmaceuticals')->value('id');
        $incepta  = DB::table('prescrip_drug_manufacturers')->where('name', 'Incepta Pharmaceuticals')->value('id');
        $aci      = DB::table('prescrip_drug_manufacturers')->where('name', 'ACI Limited')->value('id');
        $opsonin  = DB::table('prescrip_drug_manufacturers')->where('name', 'Opsonin Pharma')->value('id');
        $renata   = DB::table('prescrip_drug_manufacturers')->where('name', 'Renata Limited')->value('id');

        $medicines = [
            // Antibiotics
            ['name' => 'Azithromycin', 'generic' => 'Azithromycin', 'strength' => '500 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Azithromycin', 'generic' => 'Azithromycin', 'strength' => '250 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $beximco],
            ['name' => 'Amoxicillin', 'generic' => 'Amoxicillin Trihydrate', 'strength' => '500 mg', 'dosage_id' => $capsuleId, 'manufacturer_id' => $square],
            ['name' => 'Amoxicillin', 'generic' => 'Amoxicillin Trihydrate', 'strength' => '250 mg/5ml', 'dosage_id' => $syrupId, 'manufacturer_id' => $incepta],
            ['name' => 'Ciprofloxacin', 'generic' => 'Ciprofloxacin HCl', 'strength' => '500 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Ciprofloxacin', 'generic' => 'Ciprofloxacin HCl', 'strength' => '250 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $beximco],
            ['name' => 'Metronidazole', 'generic' => 'Metronidazole', 'strength' => '400 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $aci],
            ['name' => 'Cefuroxime', 'generic' => 'Cefuroxime Axetil', 'strength' => '500 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $incepta],
            ['name' => 'Cefixime', 'generic' => 'Cefixime', 'strength' => '200 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Doxycycline', 'generic' => 'Doxycycline Hyclate', 'strength' => '100 mg', 'dosage_id' => $capsuleId, 'manufacturer_id' => $beximco],

            // Analgesic / Antipyretic
            ['name' => 'Napa', 'generic' => 'Paracetamol', 'strength' => '500 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $beximco],
            ['name' => 'Napa Extra', 'generic' => 'Paracetamol + Caffeine', 'strength' => '500 mg + 65 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $beximco],
            ['name' => 'Ace', 'generic' => 'Paracetamol', 'strength' => '500 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Ibuprofen', 'generic' => 'Ibuprofen', 'strength' => '400 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $aci],
            ['name' => 'Diclofenac', 'generic' => 'Diclofenac Sodium', 'strength' => '50 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Diclofenac', 'generic' => 'Diclofenac Sodium', 'strength' => '75 mg/3ml', 'dosage_id' => $injId, 'manufacturer_id' => $incepta],
            ['name' => 'Naproxen', 'generic' => 'Naproxen', 'strength' => '500 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $renata],

            // Antacid / GI
            ['name' => 'Omeprazole', 'generic' => 'Omeprazole', 'strength' => '20 mg', 'dosage_id' => $capsuleId, 'manufacturer_id' => $square],
            ['name' => 'Omeprazole', 'generic' => 'Omeprazole', 'strength' => '40 mg', 'dosage_id' => $capsuleId, 'manufacturer_id' => $beximco],
            ['name' => 'Esomeprazole', 'generic' => 'Esomeprazole', 'strength' => '20 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $incepta],
            ['name' => 'Pantoprazole', 'generic' => 'Pantoprazole', 'strength' => '40 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $aci],
            ['name' => 'Ranitidine', 'generic' => 'Ranitidine HCl', 'strength' => '150 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $opsonin],
            ['name' => 'Domperidone', 'generic' => 'Domperidone', 'strength' => '10 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],

            // Antihistamine
            ['name' => 'Cetirizine', 'generic' => 'Cetirizine HCl', 'strength' => '10 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Fexofenadine', 'generic' => 'Fexofenadine HCl', 'strength' => '120 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $beximco],
            ['name' => 'Loratadine', 'generic' => 'Loratadine', 'strength' => '10 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $incepta],

            // Vitamins / Supplements
            ['name' => 'Vitamin C', 'generic' => 'Ascorbic Acid', 'strength' => '500 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $aci],
            ['name' => 'Vitamin D3', 'generic' => 'Cholecalciferol', 'strength' => '1000 IU', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Calcium + Vitamin D3', 'generic' => 'Calcium Carbonate + Cholecalciferol', 'strength' => '500 mg + 200 IU', 'dosage_id' => $tabletId, 'manufacturer_id' => $beximco],
            ['name' => 'Folic Acid', 'generic' => 'Folic Acid', 'strength' => '5 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $renata],
            ['name' => 'Zinc', 'generic' => 'Zinc Sulfate', 'strength' => '20 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $aci],

            // Antidiabetic
            ['name' => 'Metformin', 'generic' => 'Metformin HCl', 'strength' => '500 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Metformin', 'generic' => 'Metformin HCl', 'strength' => '1000 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $beximco],
            ['name' => 'Glimepiride', 'generic' => 'Glimepiride', 'strength' => '2 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $incepta],

            // Antihypertensive
            ['name' => 'Amlodipine', 'generic' => 'Amlodipine Besilate', 'strength' => '5 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Amlodipine', 'generic' => 'Amlodipine Besilate', 'strength' => '10 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Losartan', 'generic' => 'Losartan Potassium', 'strength' => '50 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $beximco],
            ['name' => 'Atenolol', 'generic' => 'Atenolol', 'strength' => '50 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $aci],

            // Cancer / Oncology related
            ['name' => 'Tamoxifen', 'generic' => 'Tamoxifen Citrate', 'strength' => '20 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Capecitabine', 'generic' => 'Capecitabine', 'strength' => '500 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $incepta],
            ['name' => 'Ondansetron', 'generic' => 'Ondansetron HCl', 'strength' => '8 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $square],
            ['name' => 'Dexamethasone', 'generic' => 'Dexamethasone', 'strength' => '0.5 mg', 'dosage_id' => $tabletId, 'manufacturer_id' => $beximco],
            ['name' => 'Morphine', 'generic' => 'Morphine Sulfate', 'strength' => '10 mg/ml', 'dosage_id' => $injId, 'manufacturer_id' => $opsonin],
        ];

        foreach ($medicines as $medicine) {
            DB::table('prescription_medicine_record')->insertOrIgnore([
                'manufacturer_id' => $medicine['manufacturer_id'],
                'dosage_id'       => $medicine['dosage_id'],
                'name'            => $medicine['name'],
                'generic'         => $medicine['generic'],
                'strength'        => $medicine['strength'],
                'price'           => 0,
                'is_active'       => 1,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
