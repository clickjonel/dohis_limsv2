<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyUser;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $filePath = database_path('seeders/csv/properties.csv');

        // if (!file_exists($filePath)) {
        //     $this->command->error("CSV file not found at: $filePath");
        //     return;
        // }

        // $file = fopen($filePath, 'r');

        // if ($file === false) {
        //     $this->command->error("Could not open CSV file: $filePath");
        //     return;
        // }

        // $header = fgetcsv($file); // Read header row

        // if ($header === false) {
        //     $this->command->error("Could not read header from CSV file.");
        //     fclose($file);
        //     return;
        // }

        // try {
        //     DB::beginTransaction();
        
           
        //     while (($row = fgetcsv($file)) !== false) {
        //         $data = array_combine(array_map('trim', $header), $row);
        
        //         $unit_cost =(float) str_replace(',', '', trim($data['unit_cost']));

        //         $property_nos = explode(',',$data['property_no']);

        //         foreach($property_nos as $property_no){
        //             $propertyId = DB::connection('lims')->table('lims_properties')->insertGetId([
        //                 'property_no'       => trim($property_no),
        //                 'measurement_unit'  => $data['measurement_unit'],
        //                 'particulars'       => $data['particulars'],
        //                 'unit_cost'         => $unit_cost,
        //                 'status'            => $data['status'],
        //                 'remarks'           => $data['remarks']
        //             ]);
                
        //             DB::connection('lims')->table('property_user')->insert([
        //                 'property_id'    => $propertyId,
        //                 'user_id'        => (int) $data['end_user'],
        //                 'issuance_date'  => $data['acquisition_date'] ?? null
        //             ]);
                
        //             DB::connection('lims')->table('property_user_history')->insert([
        //                 'property_id'       => $propertyId,
        //                 'user_id'           => (int) $data['end_user'],
        //                 'acquisition_date'  => $data['acquisition_date'] ?? null,
        //                 'return_date'       => null
        //             ]);
        //         }
               
                
        //        dump($property_nos);
        //     }
        
        //     DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     // Handle the exception
        //     echo "Transaction failed: " . $e->getMessage();
        // }

        // fclose($file);

        // $this->command->info('CSV data imported successfully!');
       
        
      $properties = array(
        array(
          'item_no' => 1,
          'property_no' => '2021-1087',
          'issuance_date' => '2021-08-03',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'UPS, EATON 5L 1200 USB, 1200VA/600W, 230V',
          'unit_cost' => 6800,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 2,
          'property_no' => '87-15',
          'issuance_date' => '2015-08-07',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Swivel Chair w/ Arm Rest',
          'unit_cost' => 3699.4,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 3,
          'property_no' => '15-66',
          'issuance_date' => '2015-07-03',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Computer table',
          'unit_cost' => 1361,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 4,
          'property_no' => '2019-457',
          'issuance_date' => '2019-05-16',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Swivel Chair, ergodynamic',
          'unit_cost' => 2995,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 5,
          'property_no' => '2019-881 to 2019-882',
          'issuance_date' => '2019-11-25',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Swivel Chair, black leather',
          'unit_cost' => 6450,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 6,
          'property_no' => '1050-2K',
          'issuance_date' => '1997-04-30',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Computer Desktop',
          'unit_cost' => 62000,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 7,
          'property_no' => '966-11',
          'issuance_date' => '2011-11-11',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Computer Desktop',
          'unit_cost' => 40660,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 8,
          'property_no' => '2020-06-0166',
          'issuance_date' => '2019-12-27',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'CPU Assembled',
          'unit_cost' => 33514.54,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 9,
          'property_no' => '2020-01-005',
          'issuance_date' => '2020-02-18',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Printer, Epson L5190',
          'unit_cost' => 17000,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 10,
          'property_no' => '2023-016',
          'issuance_date' => '2022-12-09',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Paper Shredder, Strip Cut, Acura',
          'unit_cost' => 2180,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 11,
          'property_no' => '2021-1515',
          'issuance_date' => '2021-03-10',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Webcam, Logitech',
          'unit_cost' => 7990,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 12,
          'property_no' => '2023-047',
          'issuance_date' => '2023-12-09',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Puncher',
          'unit_cost' => 145,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 13,
          'property_no' => '2021-1086',
          'issuance_date' => '2021-08-03',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'UPS, EATON 5L 1200 USB, 1200VA/600W, 230V',
          'unit_cost' => 6800,
          'remarks' => 'from: M. Dulnuan',
          'end_user' => 758
        ),
        array(
          'item_no' => 14,
          'property_no' => '2019-856',
          'issuance_date' => '2019-11-18',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Calculator, Casio',
          'unit_cost' => 345,
          'remarks' => 'from: M. Dulnuan',
          'end_user' => 758
        ),
        array(
          'item_no' => 15,
          'property_no' => '2022-189',
          'issuance_date' => '2022-03-11',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Keyboard, A4Tech',
          'unit_cost' => 330,
          'remarks' => 'from: M. Dulnuan',
          'end_user' => 758
        ),
        array(
          'item_no' => 16,
          'property_no' => '2022-548',
          'issuance_date' => '2022-09-30',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Mouse, A4Tech',
          'unit_cost' => 150,
          'remarks' => 'from: M. Dulnuan',
          'end_user' => 758
        ),
        array(
          'item_no' => 17,
          'property_no' => '2022-644',
          'issuance_date' => '2022-09-08',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'CPU Assembled',
          'unit_cost' => 32327,
          'remarks' => 'from: M. Dulnuan',
          'end_user' => 758
        ),
        array(
          'item_no' => 18,
          'property_no' => '2022-483',
          'issuance_date' => '2022-09-05',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Keyboard, A4Tech',
          'unit_cost' => 400,
          'remarks' => 'from: M. Dulnuan',
          'end_user' => 758
        ),
        array(
          'item_no' => 19,
          'property_no' => '2022-475',
          'issuance_date' => '2022-09-02',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Monitor, Viewplus 23.8',
          'unit_cost' => 5671,
          'remarks' => 'from: M. Dulnuan',
          'end_user' => 758
        ),
        array(
          'item_no' => 20,
          'property_no' => '2022-679',
          'issuance_date' => '2022-01-31',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Printer, Brother MFC T920DW',
          'unit_cost' => 14150,
          'remarks' => 'from: M. Dulnuan',
          'end_user' => 758
        ),
        array(
          'item_no' => 21,
          'property_no' => '2021-1528',
          'issuance_date' => '2021-03-10',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Webcam, Logitech',
          'unit_cost' => 7990,
          'remarks' => 'from: M. Dulnuan',
          'end_user' => 758
        ),
        array(
          'item_no' => 22,
          'property_no' => '2022-670',
          'issuance_date' => '2022-11-18',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'UPS, Secure 1000VA',
          'unit_cost' => 3945,
          'remarks' => 'from: M. Dulnuan',
          'end_user' => 758
        ),
        array(
          'item_no' => 23,
          'property_no' => '2023-196',
          'issuance_date' => '2023-05-05',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Drawer Steel Lateral Filing Cabinet, 2 Layers, Drawer Type',
          'unit_cost' => 10990,
          'remarks' => 'from: M. Dulnuan',
          'end_user' => 758
        ),
        array(
          'item_no' => 1,
          'property_no' => '2023-058',
          'issuance_date' => '2023-02-08',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Microwave Oven, Hanabishi',
          'unit_cost' => 4500,
          'remarks' => '',
          'end_user' => 758
        ),
        array(
          'item_no' => 2,
          'property_no' => '2023-072,2023-073,2023-074,2023-075',
          'issuance_date' => '3/1/2023',
          'measurement_30' => 17,
          'quantity' => 4,
          'particulars' => 'Client Chair, Black, Stable',
          'unit_cost' => 1990,
          'remarks' => '',
          'end_user' => 757
        ),
        array(
          'item_no' => 3,
          'property_no' => '2023-502(2)',
          'issuance_date' => '9/8/2022',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Speakerphone, Jabra Speak 510+ MS',
          'unit_cost' => 7950,
          'remarks' => '',
          'end_user' => 759
        ),
        array(
          'item_no' => 4,
          'property_no' => '2023-122',
          'issuance_date' => '3/13/2023',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Basic Combination Blinds, Yellow, 250cm x 130cm',
          'unit_cost' => 6300,
          'remarks' => '',
          'end_user' => 759
        ),
        array(
          'item_no' => 5,
          'property_no' => '2023-197',
          'issuance_date' => '5/5/2023',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Water Dispenser, Hot and Cold, Hamle Brand',
          'unit_cost' => 5990,
          'remarks' => '',
          'end_user' => 758
        )
      );


        try {
            DB::beginTransaction();

            foreach($properties as $property){

              $issuance_date = $property['issuance_date'] === 'NULL' ? null :Carbon::parse($property['issuance_date'])->format('Y-m-d');
              $property_nos = explode(',',$property['property_no']);

              foreach($property_nos as $no){
                  $propertyCreated = Property::create([
                      'property_no'       => trim($no),
                      'measurement_unit'  => $property['measurement_30'],
                      'particulars'       => $property['particulars'],
                      'unit_cost'         => (float) $property['unit_cost'],
                      'status'            => 'Active',
                      'remarks'           => $property['remarks'],
                  ]);
      
                  DB::connection('lims')->table('property_user')->insert([
                      'property_id'    => $propertyCreated->id,
                      'user_id'        => (int) $property['end_user'],
                      'issuance_date'  =>  $issuance_date
                  ]);
              }
            
                // DB::connection('lims')->table('property_user_history')->insert([
                //     'property_id'       => $propertyCreated->id,
                //     'user_id'           => (int) $property['end_user'],
                //     'acquisition_date'  => (new Carbon($property['issuance_date']))->format('Y-m-d') ?? null,
                //     'return_date'       => null
                // ]);
                
            }

            DB::commit();
            echo 'Success';

        } 

        catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }

   }
}
