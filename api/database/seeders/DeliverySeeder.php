<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('seeders/csv/deliveries.csv'); // Adjust path

        if (!file_exists($filePath)) {
            $this->command->error("CSV file not found at: $filePath");
            return;
        }

        $file = fopen($filePath, 'r');

        if ($file === false) {
            $this->command->error("Could not open CSV file: $filePath");
            return;
        }

        $header = fgetcsv($file); // Read header row

        if ($header === false) {
            $this->command->error("Could not read header from CSV file.");
            fclose($file);
            return;
        }

        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($header, $row);

            DB::connection('lims')->table('lims_deliveries')->insert($data);
        }

        fclose($file);

        $this->command->info('CSV data imported successfully!');
    
    }
}
