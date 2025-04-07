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
          'property_no' => '16-476,16-477',
          'issuance_date' => '2016-08-11',
          'measurement_30' => 30,
          'quantity' => 2,
          'particulars' => 'Hard Disk Drive, External 1TB',
          'unit_cost' => 5410,
          'remarks' => 'Fr. Moida Binwag',
          'end_user' => 376
        ),
        array(
          'item_no' => 2,
          'property_no' => '2017-12-063',
          'issuance_date' => '2017-12-08',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Desktop Computer, HP 280 G2 Microtower',
          'unit_cost' => 49151.74,
          'remarks' => 'Fr. Moida Binwag',
          'end_user' => 376
        ),
        array(
          'item_no' => 3,
          'property_no' => '16-580',
          'issuance_date' => '2016-11-09',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => '"Tablet, silver grey, dual font facing speakers android 4.2 Jellybean display 8"" HD Display, Samsung"',
          'unit_cost' => 149990,
          'remarks' => 'from  M. Paran',
          'end_user' => 376
        ),
        array(
          'item_no' => 4,
          'property_no' => '2018-512',
          'issuance_date' => '2018-10-22',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Wireless Clicker Pointer, PISEN',
          'unit_cost' => 1999,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 5,
          'property_no' => '2018-665,2018-666',
          'issuance_date' => '2018-11-12',
          'measurement_30' => 30,
          'quantity' => 2,
          'particulars' => 'Portable hard drive, 1 TB external silicon, power shockproof',
          'unit_cost' => 3500,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 6,
          'property_no' => '2018-671',
          'issuance_date' => '2018-11-12',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Printer, all-in-one, print- scan-copy, canon G4010',
          'unit_cost' => 14300,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 7,
          'property_no' => '2018-678',
          'issuance_date' => '2018-11-12',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Extension Cord, 4 Gang, Panther',
          'unit_cost' => 700,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 8,
          'property_no' => '2019-219',
          'issuance_date' => '2019-02-08',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => '"Laptop, Notebook type, Intel Celeron N3350, 3GB DDR 14"" Slim, 500GB, Win 10"',
          'unit_cost' => 14925,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 9,
          'property_no' => '2019-1050,2019-1051',
          'issuance_date' => '2020-01-10',
          'measurement_30' => 30,
          'quantity' => 2,
          'particulars' => 'Stapler, Metal Casing, loading capacity-100 staples, stapling capacity 50 sheets, heavy duty',
          'unit_cost' => 1475,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 10,
          'property_no' => '2020-1019, 2020-1020, 2020-1021, 2020-1022',
          'issuance_date' => '2020-01-30',
          'measurement_30' => 30,
          'quantity' => 4,
          'particulars' => 'Powerbank, 20000mah Dual Output LED Display with USB, VEGER',
          'unit_cost' => 6250,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 11,
          'property_no' => '2020-048',
          'issuance_date' => '2020-01-15',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Poratble Sheet-Fed Document Scanner',
          'unit_cost' => 14850,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 12,
          'property_no' => '2020-1023',
          'issuance_date' => '2020-01-30',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Printer, HP SMART TAnk 615',
          'unit_cost' => 13999,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 13,
          'property_no' => '2020-084, 2020-085, 2020-086, 2020-087, 2020-088',
          'issuance_date' => '2020-01-24',
          'measurement_30' => 17,
          'quantity' => 5,
          'particulars' => 'Steel Cabinet, 4 layers',
          'unit_cost' => 6995,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 14,
          'property_no' => '2020-1161, 2020-1162, 2020-1163, 2020-1164',
          'issuance_date' => '2020-03-16',
          'measurement_30' => 30,
          'quantity' => 4,
          'particulars' => 'Steel Cabinet 400W x 550H x 650mmD, Black',
          'unit_cost' => 3880,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 15,
          'property_no' => '2017-392',
          'issuance_date' => '2017-08-09',
          'measurement_30' => 23,
          'quantity' => 1,
          'particulars' => 'Poratble Microphone w/ Amplifier & Speaker',
          'unit_cost' => 14700,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 16,
          'property_no' => '2020-1283',
          'issuance_date' => '2020-06-25',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Extension Cord, durable, made witn high quality material, easy install, 3 outlet with cord, 5meter, OMNI',
          'unit_cost' => 300,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 17,
          'property_no' => '2020-1100',
          'issuance_date' => '2020-02-07',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Calculator, two-way power, 12 digits, tilt diplay, JS-120',
          'unit_cost' => 920,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 18,
          'property_no' => '2020-049',
          'issuance_date' => '2020-01-14',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'MONITOR, LED 21.5 , HKJ',
          'unit_cost' => 5000,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 19,
          'property_no' => '2020-1763',
          'issuance_date' => '2020-10-22',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'USB Bluetooth Adapter for PC',
          'unit_cost' => 500,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 20,
          'property_no' => '2020-1771',
          'issuance_date' => '2020-10-22',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'External USB Sound Card',
          'unit_cost' => 500,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 21,
          'property_no' => '2020-1759',
          'issuance_date' => '2020-11-17',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'HD PRO Web Camera with tripod (Logitech C930e)',
          'unit_cost' => 9900,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 22,
          'property_no' => '2020-1971,2020-1972',
          'issuance_date' => '2020-11-25',
          'measurement_30' => 30,
          'quantity' => 2,
          'particulars' => 'UPS, AWP 1000VA',
          'unit_cost' => 4500,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 23,
          'property_no' => '21-01-010',
          'issuance_date' => '2020-09-29',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Laptop, Lenovo Ideapad 3',
          'unit_cost' => 42870,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 24,
          'property_no' => '2021-025',
          'issuance_date' => '2021-01-13',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Multimedia Presenter with USB Receiver 1, Pisen Rechargeable',
          'unit_cost' => 1100,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 25,
          'property_no' => '2021-262',
          'issuance_date' => '2021-02-15',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'USB Speakerphone, Jabra Speak 510 UC Conference Kit',
          'unit_cost' => 7280,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 26,
          'property_no' => '2020-1707',
          'issuance_date' => '2020-10-19',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => '"Desktop Monitor,27"" in panel LG 27MK400"',
          'unit_cost' => 11000,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 27,
          'property_no' => '2021-281',
          'issuance_date' => '2021-03-05',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Adapter, USB 2.0 to Rj45 Ethernet',
          'unit_cost' => 315,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 28,
          'property_no' => '2021-711,2021-712',
          'issuance_date' => '2021-05-10',
          'measurement_30' => 17,
          'quantity' => 2,
          'particulars' => 'Puncher, heavy duty, 2-hole (7cm hole punch) with centering gauge',
          'unit_cost' => 220,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 29,
          'property_no' => '2019-645',
          'issuance_date' => '2019-07-16',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Pencil Sharpener, No. Sh308, Manual sharpener',
          'unit_cost' => 285,
          'remarks' => 'from V. Ingen',
          'end_user' => 376
        ),
        array(
          'item_no' => 30,
          'property_no' => '2022-333',
          'issuance_date' => '2022-05-30',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => '5-Layer Steel Cabinet with Glass Sliding Doors',
          'unit_cost' => '',
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 31,
          'property_no' => '2023-360',
          'issuance_date' => '2023-07-20',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => '"Laptop, Lenovo Ideapad Slim 5 Light, 14.5"", Color: clou grey, SN: PF4CB59Z"',
          'unit_cost' => 49500,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 32,
          'property_no' => '2023-547',
          'issuance_date' => '2023-08-25',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'External Hard Drive, 4TB, Seagate One Touch with Password, Silver',
          'unit_cost' => 6150,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 33,
          'property_no' => '2024-164,2024-165',
          'issuance_date' => '2024-01-12',
          'measurement_30' => 30,
          'quantity' => 2,
          'particulars' => 'Portable Tablet, Samsung S9 fe+, 12.4 inches, w/ book cover, keyboard and adapter',
          'unit_cost' => 43900,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 34,
          'property_no' => '2024-174',
          'issuance_date' => '2024-01-12',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Monitor, Asus 27',
          'unit_cost' => 11300,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 35,
          'property_no' => '2024-218,2024-219',
          'issuance_date' => '2024-01-24',
          'measurement_30' => 17,
          'quantity' => 2,
          'particulars' => 'Swivel Chair, High Back, Leatherette, Black, Chrome Base Jersey JS-289',
          'unit_cost' => 4485,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 36,
          'property_no' => '2024-236',
          'issuance_date' => '2024-01-18',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Extension Cord, 15M, Omni',
          'unit_cost' => 1850,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 37,
          'property_no' => 'SPLV-2024-08-753',
          'issuance_date' => '2024-07-17',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Keyboard and Mouse Set, A4Tech',
          'unit_cost' => 800,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 38,
          'property_no' => 'SPHV-202406-636',
          'issuance_date' => '2024-06-21',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Portable Scanner, Epson ES-50',
          'unit_cost' => 7600,
          'remarks' => '',
          'end_user' => 376
        ),
        array(
          'item_no' => 1,
          'property_no' => 'ICS 16-420',
          'issuance_date' => '2016-10-06',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Computer Notebook & Tablet in 1 (acer)',
          'unit_cost' => 14498,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 2,
          'property_no' => '2019-658',
          'issuance_date' => '2019-08-19',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Tablet, Built-in Convenient Stylus Pen, Samsung Tab A w/ Sign Pen, P335',
          'unit_cost' => 14990,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 3,
          'property_no' => '2021-129',
          'issuance_date' => '2021-01-22',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Speakerphone, Mid-range portable USB and Bluetooth Speakerphone Speak 510, Jabra Speak 510',
          'unit_cost' => 8985,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 4,
          'property_no' => '2021-166',
          'issuance_date' => '2021-01-22',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => '4K Webcam with HDR abd Windows Hello support, 4K Ultra HD video calling, Logitech C930e',
          'unit_cost' => 9580,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 5,
          'property_no' => '2021-526',
          'issuance_date' => '2021-04-19',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Water Dispenser, hot and cold water temperature selection, cold: floor standing, KYOWA',
          'unit_cost' => 7950,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 6,
          'property_no' => '2021-828',
          'issuance_date' => '2021-07-05',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Computer Table, CST-838',
          'unit_cost' => 4000,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 7,
          'property_no' => '2021-1804,2021-1805',
          'issuance_date' => '2021-11-18',
          'measurement_30' => 17,
          'quantity' => 2,
          'particulars' => 'Cleopatra Sofa Couch',
          'unit_cost' => 8500,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 8,
          'property_no' => '2021-1566',
          'issuance_date' => '2021-10-04',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Tower Fan, 3D TF10 40W',
          'unit_cost' => 3990,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 9,
          'property_no' => '2022-504,2022-505',
          'issuance_date' => '2022-09-21',
          'measurement_30' => 17,
          'quantity' => 2,
          'particulars' => 'Office Chair, Nordic, Durable A4 carbon, Curved back Rest, Pink',
          'unit_cost' => 2850,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 10,
          'property_no' => '2022-532',
          'issuance_date' => '2022-09-30',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Keyboard, A4TEch',
          'unit_cost' => 400,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 11,
          'property_no' => '2024-044',
          'issuance_date' => '12/29/204',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Portable Tablet, Samsung S9 fe+, 12.4 inches, w/ book cover, keyboard and adapter',
          'unit_cost' => 42615,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 12,
          'property_no' => '2023-827',
          'issuance_date' => '2023-12-01',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Puncher, 2 hole, Wells Brand',
          'unit_cost' => 150,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 13,
          'property_no' => 'SPLV-2024-08-733',
          'issuance_date' => '2024-07-19',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Headset, Redragon H848 IRE Pro Ultra Light Wireless',
          'unit_cost' => 1900,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 14,
          'property_no' => '2018-191',
          'issuance_date' => '2018-06-03',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'EXECUTIVE CHAIR, Adjustable height and reclining, back, Brand: Gobler Dragon 151',
          'unit_cost' => 4395,
          'remarks' => 'from: A. Tolete',
          'end_user' => 38
        ),
        array(
          'item_no' => 15,
          'property_no' => 'SPLV-2024-11-983',
          'issuance_date' => '2024-10-28',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Wireless Mouse, Logitech M185',
          'unit_cost' => 600,
          'remarks' => '',
          'end_user' => 38
        ),
        array(
          'item_no' => 1,
          'property_no' => '2017-12-060',
          'issuance_date' => '',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Desktop Computer, HP 280 G2 Microtower',
          'unit_cost' => 49151.74,
          'remarks' => 'from: S. Aral',
          'end_user' => 250
        ),
        array(
          'item_no' => 3,
          'property_no' => '2022-626',
          'issuance_date' => '2022-10-27',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Projector, Epson EB-X51',
          'unit_cost' => 32990,
          'remarks' => '',
          'end_user' => 250
        ),
        array(
          'item_no' => 4,
          'property_no' => '2023-338',
          'issuance_date' => '2023-07-14',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Printer, Brother DCP T720DW',
          'unit_cost' => 14995,
          'remarks' => '',
          'end_user' => 250
        ),
        array(
          'item_no' => 5,
          'property_no' => '2023-437',
          'issuance_date' => '2023-08-04',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Laptop, Acer Aspire 5',
          'unit_cost' => 43350,
          'remarks' => '',
          'end_user' => 250
        ),
        array(
          'item_no' => 6,
          'property_no' => '2023-438',
          'issuance_date' => '2023-08-04',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Stereo Bluetooth Headset, Jabra Evolve MS Stereo',
          'unit_cost' => 8100,
          'remarks' => '',
          'end_user' => 250
        ),
        array(
          'item_no' => 7,
          'property_no' => '2024-090',
          'issuance_date' => '2024-01-18',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Laptop, Asus TUF FX506, 15.6',
          'unit_cost' => 49999,
          'remarks' => '',
          'end_user' => 250
        ),
        array(
          'item_no' => 8,
          'property_no' => '2024-172',
          'issuance_date' => '2024-01-12',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Portable Tablet, Samsung S9 fe+, 12.4 inches, w/ book cover, keyboard and adapter',
          'unit_cost' => 43900,
          'remarks' => '',
          'end_user' => 250
        ),
        array(
          'item_no' => 9,
          'property_no' => '2024-177',
          'issuance_date' => '2024-01-12',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Monitor, Asus 27',
          'unit_cost' => 11300,
          'remarks' => '',
          'end_user' => 250
        ),
        array(
          'item_no' => 10,
          'property_no' => '2024-239',
          'issuance_date' => '2024-01-18',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Extension Cord, 15M, Omni',
          'unit_cost' => 1850,
          'remarks' => '',
          'end_user' => 250
        ),
        array(
          'item_no' => 11,
          'property_no' => '2024-204',
          'issuance_date' => '2024-01-18',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Wireless Bluetooth Speaker with Mic, Jabra Speak 510',
          'unit_cost' => 7940,
          'remarks' => '',
          'end_user' => 250
        ),
        array(
          'item_no' => 17,
          'property_no' => '2023-046',
          'issuance_date' => '2023-01-18',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'CPU Assembled',
          'unit_cost' => 37153,
          'remarks' => 'from: C. Caluza',
          'end_user' => 250
        ),
        array(
          'item_no' => 21,
          'property_no' => '2019-1049',
          'issuance_date' => '2020-01-10',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Stapler, heavy duty, No. 35, 26/6 staples',
          'unit_cost' => 446.02,
          'remarks' => 'from: C. Caluza',
          'end_user' => 250
        ),
        array(
          'item_no' => 1,
          'property_no' => '2018-103',
          'issuance_date' => '2018-02-19',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => '"Laptop Acer Aspire ES11, 11.6"" LCD, 500GB"',
          'unit_cost' => 14999,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 2,
          'property_no' => '1141-11',
          'issuance_date' => '2011-01-05',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Stethoscope-adult',
          'unit_cost' => 860,
          'remarks' => 'fr. T. Foman-eg',
          'end_user' => 374
        ),
        array(
          'item_no' => 3,
          'property_no' => '2018-382,2018-383',
          'issuance_date' => '2018-09-07',
          'measurement_30' => 30,
          'quantity' => 2,
          'particulars' => 'Storage Box, at least 110 liters, heavy duty',
          'unit_cost' => 1995,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 4,
          'property_no' => '2019-480',
          'issuance_date' => '2019-05-31',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Pedestal Cabinet, Color Beige, 3 drawer',
          'unit_cost' => 5400,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 5,
          'property_no' => '2020-1789',
          'issuance_date' => '2020-11-17',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'UPS, APC 1100 VA',
          'unit_cost' => 7100,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 6,
          'property_no' => '2021-1590',
          'issuance_date' => '2021-10-06',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Monitor, Viewplus 23.8',
          'unit_cost' => 5692.2,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 7,
          'property_no' => '2021-1745',
          'issuance_date' => '2021-11-15',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'USB Speakerphone, Jabra 510',
          'unit_cost' => 8250,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 8,
          'property_no' => '2022-082',
          'issuance_date' => '2021-12-13',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'OTG 3 in 1 USB Flash Drive, HP',
          'unit_cost' => 1100,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 9,
          'property_no' => '21-08-68',
          'issuance_date' => '2021-08-03',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'CPU Assembled',
          'unit_cost' => 44603,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 10,
          'property_no' => '2021-1332',
          'issuance_date' => '2021-08-03',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Mouse, optical, USB connection type, Logitech',
          'unit_cost' => 400,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 11,
          'property_no' => '2022-710',
          'issuance_date' => '12/9/2022',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Laptop, Acer TravelMate P2',
          'unit_cost' => 42800,
          'remarks' => 'from: C. Mamaradlo',
          'end_user' => 374
        ),
        array(
          'item_no' => 12,
          'property_no' => '2016-12-0033',
          'issuance_date' => '2016-12-13',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Asus X550ZE w/ carrying Case (sling bag) & Asus wireless optical mouse',
          'unit_cost' => 35180.08,
          'remarks' => 'from: G. Austria',
          'end_user' => 374
        ),
        array(
          'item_no' => 13,
          'property_no' => '2023-00-10605030-0005-RESU',
          'issuance_date' => '2023-06-09',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'CPU Assembled',
          'unit_cost' => 51605,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 14,
          'property_no' => '2023-443',
          'issuance_date' => '2023-08-07',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Portable Scanner, ScanSncap',
          'unit_cost' => 20000,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 15,
          'property_no' => '2023-494',
          'issuance_date' => '2023-08-09',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Computer Central Processing Unit, Intel Core i7 12700, B660 Motherboard, Kingston 16GB DDR4, 512GB SSD M2, Seagate 1TB, Antec casing, Antec 850W Gold',
          'unit_cost' => 35300,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 16,
          'property_no' => '2022-576',
          'issuance_date' => '2022-09-30',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Mouse, A4Tech',
          'unit_cost' => 150,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 17,
          'property_no' => '2023-517, 2023-518, 2023-519',
          'issuance_date' => '2023-09-07',
          'measurement_30' => 30,
          'quantity' => 3,
          'particulars' => 'UPS, APC 800VA/ 450W',
          'unit_cost' => 5950,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 18,
          'property_no' => '2023-523',
          'issuance_date' => '2023-09-07',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Desktop Computer Assembled Central Processing Unit, Intel i7-12700, MSI B700M-D Motherboard, 16GB DDR4 3200MHz, 512GB SSD M.2, 1TB HDD Seagate, 350W Gold PSU, Antec Black Casing',
          'unit_cost' => 44300,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 19,
          'property_no' => '2023-525, 2023-526, 2023-527',
          'issuance_date' => '2023-09-07',
          'measurement_30' => 30,
          'quantity' => 3,
          'particulars' => '"Monitor, Viewsonic 27"" IPS"',
          'unit_cost' => 8350,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 20,
          'property_no' => '2023-259',
          'issuance_date' => '2023-05-16',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Extension Cord, 5 meters, 4 gang, Deli Brand',
          'unit_cost' => 995,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 21,
          'property_no' => '2024-137',
          'issuance_date' => '2024-01-03',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Microphone, wireless, RIWORAL GA-80 UHF Professional 8 channels and 8 microphones, UHF floating frequency 600HMz, one-key switching frequency of the microphone, 4 antenna receiving distance 100 meters, metal microphone using AA batteries',
          'unit_cost' => 20000,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 22,
          'property_no' => '2024-138',
          'issuance_date' => '2024-01-03',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Audio Interface, Yama AG 06 MK2',
          'unit_cost' => 19500,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 23,
          'property_no' => '2024-013',
          'issuance_date' => '2023-12-29',
          'measurement_30' => 30,
          'quantity' => 2,
          'particulars' => 'Laptop Cooler, Mikuso',
          'unit_cost' => 1400,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 24,
          'property_no' => '2024-017',
          'issuance_date' => '2023-12-29',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Soundbar, Samsung HW-Q600C',
          'unit_cost' => 17500,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 25,
          'property_no' => '2024-018,2024-019',
          'issuance_date' => '2023-12-29',
          'measurement_30' => 30,
          'quantity' => 2,
          'particulars' => 'Condenser Microphone, Samson C01U Pro',
          'unit_cost' => 4800,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 26,
          'property_no' => '2024-020, 2024-021, 2024-022, 2024-023',
          'issuance_date' => '2023-12-29',
          'measurement_30' => 30,
          'quantity' => 4,
          'particulars' => 'Monitor, Viewsonic 27',
          'unit_cost' => 12190,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 27,
          'property_no' => '2024-027, 2024-028, 2024-029',
          'issuance_date' => '2023-12-29',
          'measurement_30' => 30,
          'quantity' => 3,
          'particulars' => 'Keyboard and Mouse, A4Tech',
          'unit_cost' => 680,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 28,
          'property_no' => '2024-033, 2024-034, 2024-035',
          'issuance_date' => '2023-12-29',
          'measurement_30' => 30,
          'quantity' => 3,
          'particulars' => 'UPS, AWP 1000-2000VA',
          'unit_cost' => 4137,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 29,
          'property_no' => '2024-039, 2024-040, 2024-041, 2024-042',
          'issuance_date' => '2023-12-29',
          'measurement_30' => 30,
          'quantity' => 4,
          'particulars' => 'Wireless Presenter Clicker, Rapoo XR200',
          'unit_cost' => 1275,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 30,
          'property_no' => '2024-271',
          'issuance_date' => '2024-01-29',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Smart TV, Samsung 65',
          'unit_cost' => 38300,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 31,
          'property_no' => '2024-00-10605030-04-RESU',
          'issuance_date' => '2023-12-29',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Assembled Central Processing Unit',
          'unit_cost' => 56749,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 32,
          'property_no' => '2024-00-10605030-05-RESU',
          'issuance_date' => '2023-12-29',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Assembled Central Processing Unit',
          'unit_cost' => 56749,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 33,
          'property_no' => '2024-266',
          'issuance_date' => '2024-01-12',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Printer, Epson L6290',
          'unit_cost' => 19401.09,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 34,
          'property_no' => '2023-830',
          'issuance_date' => '2023-12-01',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => "Puncher, 2 hole, Well's Brand",
          'unit_cost' => 150,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 35,
          'property_no' => '2024-278',
          'issuance_date' => '2024-01-18',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Stapler, standard type, SQI Brand',
          'unit_cost' => 165,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 36,
          'property_no' => 'SPHV-2024-02-311',
          'issuance_date' => '2024-01-24',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Swivel Chair, high back, leatherette',
          'unit_cost' => 7500,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 37,
          'property_no' => 'SPLV-2024-03-333',
          'issuance_date' => '2024-03-05',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Mechanical Pencil Sharpener (Rotary)',
          'unit_cost' => 300,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 38,
          'property_no' => 'SPLV-2024-03-367',
          'issuance_date' => '2024-03-08',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Whiteboard, 45x60cm',
          'unit_cost' => 370,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 39,
          'property_no' => 'SPLV-2024-03-388',
          'issuance_date' => '2024-03-08',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Tape Dispenser, Heavy Duty, Table Top, Sure Brand',
          'unit_cost' => 95,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 40,
          'property_no' => 'SPLV-2024-03-406',
          'issuance_date' => '2024-03-08',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Stapler, heavy duty, Joy Brand',
          'unit_cost' => 1050,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 41,
          'property_no' => 'ARE 14-313',
          'issuance_date' => '2014-08-22',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Office Table, Gerry Clerical Desk',
          'unit_cost' => 3995,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 42,
          'property_no' => '2017-12-079',
          'issuance_date' => '2017-07-27',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Projector Multimedia, Epson X31',
          'unit_cost' => 42900,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 43,
          'property_no' => '2020-04-013,2020-04-014',
          'issuance_date' => '2020-04-29',
          'measurement_30' => 30,
          'quantity' => 3,
          'particulars' => 'LAPTOP, HP Elitebook x 360 1030 G2 with carrying Case',
          'unit_cost' => 68650,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 44,
          'property_no' => '2020-1550',
          'issuance_date' => '2020-09-17',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Tripod for Web Cam, with rubberized joint rings and feet for grip',
          'unit_cost' => 1000,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 45,
          'property_no' => '2020-1726',
          'issuance_date' => '2020-10-28',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Extension Cord (Wheel), Omni 15M',
          'unit_cost' => 1995,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 46,
          'property_no' => '2020-1738',
          'issuance_date' => '2020-10-30',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Webcam, Logitech Brio',
          'unit_cost' => 14800,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 47,
          'property_no' => '2021-1659, 2021-1660, 2021-1661, 2021-1662, 2021-1663, 2021-1664, 2021-1665',
          'issuance_date' => '2021-10-25',
          'measurement_30' => 17,
          'quantity' => 6,
          'particulars' => 'Specimen Transport Box',
          'unit_cost' => 1800,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 48,
          'property_no' => '2021-1674,2021-1675',
          'issuance_date' => '2021-10-25',
          'measurement_30' => 17,
          'quantity' => 2,
          'particulars' => 'Insulated Cooler',
          'unit_cost' => 2500,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 49,
          'property_no' => '2020-1729',
          'issuance_date' => '2020-10-28',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Extension Cord (Wheel), Omni 15M',
          'unit_cost' => 1995,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 50,
          'property_no' => '2023-009',
          'issuance_date' => '2022-12-28',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Laptop, Acer TravelMate P4',
          'unit_cost' => 46700,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 51,
          'property_no' => '2022-735',
          'issuance_date' => '2022-12-21',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'HDMI Cable, Votex, 3 meters',
          'unit_cost' => 250,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 52,
          'property_no' => '2022-736',
          'issuance_date' => '2022-12-21',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'HDMI Splitter, Generic, 2 Ports',
          'unit_cost' => 1250,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 53,
          'property_no' => '2023-414, 2023-415, 2023-416',
          'issuance_date' => '2023-07-31',
          'measurement_30' => 17,
          'quantity' => 3,
          'particulars' => 'USB 9 in 1 Type C to HDMI RJ45/Cord Reader',
          'unit_cost' => 1749,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 54,
          'property_no' => '2022-744',
          'issuance_date' => '2022-12-22',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'HDMI to VGA Adapter',
          'unit_cost' => 250,
          'remarks' => 'from: K. Lonogan',
          'end_user' => 374
        ),
        array(
          'item_no' => 55,
          'property_no' => 'SPHV-2024-07-659, SPHV-2024-07-660, SPHV-2024-07-661, SPHV-2024-07-662, SPHV-2024-07-663, SPHV-2024-07-664, SPHV-2024-07-665, SPHV-2024-07-666, SPHV-2024-07-667',
          'issuance_date' => '2024-06-25',
          'measurement_30' => 30,
          'quantity' => 9,
          'particulars' => 'Ergonomic Office Chair, Gaming Chair',
          'unit_cost' => 7500,
          'remarks' => 'SPHV-2024-07-662-WMR 24-11-161',
          'end_user' => 374
        ),
        array(
          'item_no' => 56,
          'property_no' => 'SPHV-2024-07-708',
          'issuance_date' => '2024-07-17',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Portable Tablet, Samsung Tab S9+',
          'unit_cost' => 42900,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 57,
          'property_no' => 'SPHV-2024-09-868',
          'issuance_date' => '2024-09-05',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Table, Stainless Steel',
          'unit_cost' => 14000,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 58,
          'property_no' => 'SPHV-2024-09-809',
          'issuance_date' => '2024-09-05',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Steel Cabinet, 4 drawers, Jersey',
          'unit_cost' => 8500,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 59,
          'property_no' => 'SPLV-2024-03-447',
          'issuance_date' => '2024-03-13',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Keyboard, Logitech',
          'unit_cost' => 700,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 60,
          'property_no' => 'SPHV-2024-10-959',
          'issuance_date' => '2024-10-11',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Air Purifier, Samsung',
          'unit_cost' => 28700,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 61,
          'property_no' => 'SPLV-2024-10-953',
          'issuance_date' => '2024-10-11',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Fixed Wall TV Mount, North Bayou',
          'unit_cost' => 3000,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 62,
          'property_no' => 'SPLV-2024-10-954',
          'issuance_date' => '2024-10-11',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Powerbank, Ugreen 10,000mAh',
          'unit_cost' => 1100,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 63,
          'property_no' => 'SPLV-2024-11-1021,SPLV-2024-11-1023,SPLV-2024-11-1025',
          'issuance_date' => '2024-11-25',
          'measurement_30' => 17,
          'quantity' => 5,
          'particulars' => 'Cooler Box, Orocan 8L, Blue',
          'unit_cost' => 1581,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 64,
          'property_no' => 'SPHV-2024-12-1059,SPHV-2024-12-1060',
          'issuance_date' => '2024-11-27',
          'measurement_30' => 30,
          'quantity' => 2,
          'particulars' => 'Airconditioning Unit, Split Type',
          'unit_cost' => 49500,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 65,
          'property_no' => '2022-701',
          'issuance_date' => '2022-12-02',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Printer, HP Smart 615',
          'unit_cost' => 15300,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 66,
          'property_no' => '2023-017,2023-018',
          'issuance_date' => '2023-01-03',
          'measurement_30' => 17,
          'quantity' => 2,
          'particulars' => 'Heavy Duty Adjustable Metal Shelf',
          'unit_cost' => 3790,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 67,
          'property_no' => '2022-734',
          'issuance_date' => '2022-12-21',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'HDMI Cable, Vortex 5 meters',
          'unit_cost' => 300,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 68,
          'property_no' => '2022-741',
          'issuance_date' => '2022-12-21',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Keyboard, A4Tech',
          'unit_cost' => 350,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 69,
          'property_no' => '2023-053',
          'issuance_date' => '2023-01-19',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'HDMI to VGA Adapter',
          'unit_cost' => 180,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 70,
          'property_no' => '2020-06-0149',
          'issuance_date' => '2020-06-03',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Desktop Computer Set, Acer Veriton M2640G',
          'unit_cost' => 39208,
          'remarks' => 'Keyboard & Mouse-WMR 24-04-045',
          'end_user' => 374
        ),
        array(
          'item_no' => 71,
          'property_no' => '2017-318',
          'issuance_date' => '2017-08-02',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Camera , Canon Powershot SX43015, 20MP, 45x zoom, 90x zoom plus, Wifi & NFC',
          'unit_cost' => 14350,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 72,
          'property_no' => '2019-511',
          'issuance_date' => '11/6/2018',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Steel Cabinet, 3 layers',
          'unit_cost' => 6697.5,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 73,
          'property_no' => '2023-110, 2023-111, 2023-112, 2023-113, 2023-114',
          'issuance_date' => '4/4/2023',
          'measurement_30' => 17,
          'quantity' => 5,
          'particulars' => 'Stapler, standard type, Brand: Joy',
          'unit_cost' => 148.4,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 74,
          'property_no' => '253-14',
          'issuance_date' => '6/29/2014',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Refrigerator, Electrolux',
          'unit_cost' => 8775,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 75,
          'property_no' => '02-12',
          'issuance_date' => '1/4/2012',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Refrigerator, Sharp',
          'unit_cost' => 8958,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 76,
          'property_no' => '2023-493',
          'issuance_date' => '8/9/2023',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Computer Central Processing Unit, Intel Core i7 12700, B660 Motherboard, Kingston 16GB DDR4, 512GB SSD M2, Seagate 1TB, Antec casing, Antec 850W Gold',
          'unit_cost' => 35300,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 77,
          'property_no' => '2023-444',
          'issuance_date' => '8/7/2023',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Portable Scanner, ScanScnap',
          'unit_cost' => 20000,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 78,
          'property_no' => '2023-445, 2023-446, 2023-447',
          'issuance_date' => '8/7/2023',
          'measurement_30' => 17,
          'quantity' => 3,
          'particulars' => 'Web Camera, Logitech C930e',
          'unit_cost' => 7600,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 79,
          'property_no' => '2023-298',
          'issuance_date' => '6/14/2023',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Calculator,TM-12',
          'unit_cost' => 200,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 80,
          'property_no' => '2022-195',
          'issuance_date' => '3/11/2022',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Keyboard, A4Tech',
          'unit_cost' => 330,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 81,
          'property_no' => '2023-520, 2023-521, 2023-522',
          'issuance_date' => '9/7/2023',
          'measurement_30' => 30,
          'quantity' => 3,
          'particulars' => 'UPS, APC 800VA/450W',
          'unit_cost' => 5950,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 82,
          'property_no' => '2024-024, 2024-025, 2024-026',
          'issuance_date' => '12/29/2023',
          'measurement_30' => 30,
          'quantity' => 3,
          'particulars' => 'Monitor, Viewsonic 27',
          'unit_cost' => 12190,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 83,
          'property_no' => '2024-030, 2024-031, 2024-032',
          'issuance_date' => '12/29/2023',
          'measurement_30' => 30,
          'quantity' => 3,
          'particulars' => 'Keyboard and Mouse, A4Tech',
          'unit_cost' => 680,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 84,
          'property_no' => '2024-036, 2024-037, 2024-038',
          'issuance_date' => '12/29/2023',
          'measurement_30' => 30,
          'quantity' => 3,
          'particulars' => 'UPS, AWP 1000-2000VA',
          'unit_cost' => 4137,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 85,
          'property_no' => 'ICS 16-166',
          'issuance_date' => '2016-03-09',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Steel cabinet, 3 layers',
          'unit_cost' => 11000,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 86,
          'property_no' => 'ICS 16-225',
          'issuance_date' => '2016-03-31',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Portable Scanner, Canon',
          'unit_cost' => 10350,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 87,
          'property_no' => '2020-06-0157',
          'issuance_date' => '2020-07-03',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Desktop Computer w/ mouse and keyboard, ACER Veriton M2640G',
          'unit_cost' => 39208,
          'remarks' => 'Keyboard & Mouse-WMR 24-04-045',
          'end_user' => 374
        ),
        array(
          'item_no' => 88,
          'property_no' => '2020-1889',
          'issuance_date' => '2020-12-04',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Tape Dispenser, table top, for 24mm width tape',
          'unit_cost' => 130,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 89,
          'property_no' => '2021-1636',
          'issuance_date' => '2021-07-16',
          'measurement_30' => 17,
          'quantity' => 2,
          'particulars' => 'Stapler, standard',
          'unit_cost' => 189,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 90,
          'property_no' => '2021-1220, 2021-1224',
          'issuance_date' => '2021-08-11',
          'measurement_30' => 17,
          'quantity' => 2,
          'particulars' => 'Puncher/Perforator, paper, heavy duty, with 2 hole guide',
          'unit_cost' => 150,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 91,
          'property_no' => '2020-04-010',
          'issuance_date' => '2020-04-30',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Laptop, HP Elitebook x 360 1030 G2 w/ carrying case',
          'unit_cost' => 68650,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 92,
          'property_no' => '2022-737',
          'issuance_date' => '2022-12-21',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Mouse, A4Tech',
          'unit_cost' => 350,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 93,
          'property_no' => '2022-742',
          'issuance_date' => '2022-12-21',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Keyboard, A4Tech',
          'unit_cost' => 350,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 94,
          'property_no' => '2023-170',
          'issuance_date' => '2023-04-20',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Refrigerator, Panasonic NR-TL381BPKP 12.9 cu ft.',
          'unit_cost' => 31800,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 95,
          'property_no' => '2023-418,2023-419',
          'issuance_date' => '2023-07-31',
          'measurement_30' => 17,
          'quantity' => 2,
          'particulars' => 'HDMI Splitter, Bi-directional, Vention',
          'unit_cost' => 715,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 96,
          'property_no' => '2024-0154, 2024-0155, 2024-0156',
          'issuance_date' => '2024-01-12',
          'measurement_30' => 30,
          'quantity' => 3,
          'particulars' => 'Extension Cord, Compact USB Power Strip, 5 outlets, 4.5ft. length, Omni',
          'unit_cost' => 1050,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 97,
          'property_no' => '2024-158, 2024-159, 2024-160, 2024-161, 2024-162',
          'issuance_date' => '2024-01-12',
          'measurement_30' => 30,
          'quantity' => 5,
          'particulars' => 'Universal Tower Extension Cord, 12 gang universal sockets, 6 ft. length of electrical wire, Omni',
          'unit_cost' => 1695,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 98,
          'property_no' => '2017-261,2017-262',
          'issuance_date' => '2017-03-10',
          'measurement_30' => 30,
          'quantity' => 2,
          'particulars' => 'Flat Screen LED TV, Flicker Free, 32 inches w/ VGA/HDMI Port, 220V (my view)',
          'unit_cost' => 9900,
          'remarks' => 'from: J. Simeon',
          'end_user' => 374
        ),
        array(
          'item_no' => 99,
          'property_no' => 'SPLV-2025-01-040, SPLV-2025-01-042',
          'issuance_date' => '2025-01-15',
          'measurement_30' => 30,
          'quantity' => 3,
          'particulars' => 'Magnetic Hanging LED TAble Lamp Chargeable Stepless Dimming Desk Lamp, Baseus',
          'unit_cost' => 1800,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 100,
          'property_no' => 'SPLV-2025-02-091',
          'issuance_date' => '2025-02-12',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => '"Portable Tablet, Huawei 11.5"" w/ Keyboard Matepad 8+128 Space, Gray"',
          'unit_cost' => 19999,
          'remarks' => '',
          'end_user' => 374
        ),
        array(
          'item_no' => 1,
          'property_no' => '2024-283',
          'issuance_date' => '2024-01-18',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Stapler, standard type, SQI Brand',
          'unit_cost' => 165,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 2,
          'property_no' => 'SPHV-2024-09-806',
          'issuance_date' => '2024-08-27',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Refrigerator, Fujidenzo',
          'unit_cost' => 41500,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 3,
          'property_no' => '2024-129',
          'issuance_date' => '2024-01-09',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'UPS, Eaton 5A 12001-NEMA 1200VA/650W',
          'unit_cost' => 6000,
          'remarks' => 'from: J, Dongbo',
          'end_user' => 358
        ),
        array(
          'item_no' => 4,
          'property_no' => 'SPLV-2024-10-937,SPLV-2024-10-938',
          'issuance_date' => '2024-09-23',
          'measurement_30' => 17,
          'quantity' => 2,
          'particulars' => 'HDMI to HDMI Cable Vention 2M',
          'unit_cost' => 265,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 5,
          'property_no' => 'SPLV-2024-12-1040',
          'issuance_date' => '2024-11-14',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Keyboard, Rapoo',
          'unit_cost' => 1007,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 6,
          'property_no' => 'SPHV-2024-12-1038',
          'issuance_date' => '2024-11-14',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Laptop, MSI Thin',
          'unit_cost' => 48888,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 7,
          'property_no' => 'SPHV-2024-12-1039',
          'issuance_date' => '2024-11-14',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Monitor, Acer 27',
          'unit_cost' => 6885,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 8,
          'property_no' => 'SPHV-2024-12-1041',
          'issuance_date' => '2024-11-14',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Scanner, Brother DS-7400',
          'unit_cost' => 12720,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 9,
          'property_no' => 'SPHV-2024-12-1042',
          'issuance_date' => '2024-11-14',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Printer, Epson L5290',
          'unit_cost' => 16531,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 10,
          'property_no' => 'SPLV-2024-09-813',
          'issuance_date' => '2024-09-03',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Mouse, Wireless, Delux',
          'unit_cost' => 450,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 11,
          'property_no' => 'SPHV-2024-09-812',
          'issuance_date' => '2024-08-30',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Central Processing Unit',
          'unit_cost' => 36500,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 12,
          'property_no' => 'SPHV-2024-09-814',
          'issuance_date' => '2024-09-03',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'UPS,Cyberpower 1500VA',
          'unit_cost' => 5250,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 13,
          'property_no' => 'SPHV-2024-12-1061,SPHV-2024-12-1062',
          'issuance_date' => '2024-08-15',
          'measurement_30' => 30,
          'quantity' => 2,
          'particulars' => 'Air Conditioner, Wall Mount',
          'unit_cost' => 35000,
          'remarks' => '',
          'end_user' => 358
        ),
        array(
          'item_no' => 1,
          'property_no' => 'ICS 16-274',
          'issuance_date' => '2016-04-26',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Portable Scanner',
          'unit_cost' => 10000,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 2,
          'property_no' => '2019-172',
          'issuance_date' => '2019-02-01',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Storage Box, Plastic: size, 50L',
          'unit_cost' => 510,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 3,
          'property_no' => '2019-528',
          'issuance_date' => '2019-06-06',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Laptop, Lenovo s130-11 IGM',
          'unit_cost' => 14950,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 4,
          'property_no' => '2020-1201',
          'issuance_date' => '2020-06-09',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'UPS, APC, 325W/650, Vertiv 650 VA/395 watts',
          'unit_cost' => 2800,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 5,
          'property_no' => '2020-1510',
          'issuance_date' => '2020-09-16',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Hard Drive 1TB, Transcend',
          'unit_cost' => 3500,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 6,
          'property_no' => '2021-048',
          'issuance_date' => '2021-01-14',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Webcam, A4Tech, 1080p',
          'unit_cost' => 1493,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 7,
          'property_no' => '2021-1895',
          'issuance_date' => '2021-12-10',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Printer, HP 615',
          'unit_cost' => 14500,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 8,
          'property_no' => '2021-1376',
          'issuance_date' => '2021-08-26',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Keyboard, Logitech',
          'unit_cost' => 700,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 9,
          'property_no' => '2021-1433',
          'issuance_date' => '2021-08-03',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Mouse, Logitech',
          'unit_cost' => 400,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 10,
          'property_no' => '2019-12-088',
          'issuance_date' => '2020-01-07',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => "Desktop Computer, Acer Veriton with mouse and keyboard, Intel core i7 7700 kabylake 7",
          'unit_cost' => 39208,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 11,
          'property_no' => '2021-1799',
          'issuance_date' => '2021-11-17',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Wireless Presenter Logitech',
          'unit_cost' => 1800,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 12,
          'property_no' => '2022-069',
          'issuance_date' => '2022-01-10',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'Air Purifier, Skyclear',
          'unit_cost' => 5900,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 13,
          'property_no' => '12-05',
          'issuance_date' => '2005-01-31',
          'measurement_30' => 30,
          'quantity' => 1,
          'particulars' => 'CPU Assembled',
          'unit_cost' => 20600,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 14,
          'property_no' => '2021-1858',
          'issuance_date' => '2021-12-02',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Speaker',
          'unit_cost' => 12200,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 15,
          'property_no' => '2021-1860',
          'issuance_date' => '2021-12-02',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Digital Voice Recorder',
          'unit_cost' => 4395,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 16,
          'property_no' => '2023-272',
          'issuance_date' => '2023-05-26',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Dry Seal, standard type',
          'unit_cost' => 3500,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 17,
          'property_no' => '2022-539',
          'issuance_date' => '2022-09-30',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Keyboard, A4Tech',
          'unit_cost' => 400,
          'remarks' => '',
          'end_user' => 145
        ),
        array(
          'item_no' => 18,
          'property_no' => 'ICS 16-343',
          'issuance_date' => '2016-06-07',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Swivel chair, executive , leather, high back',
          'unit_cost' => 3950,
          'remarks' => 'from: N. Cara',
          'end_user' => 145
        ),
        array(
          'item_no' => 19,
          'property_no' => '2023-829',
          'issuance_date' => '2023-12-01',
          'measurement_30' => 17,
          'quantity' => 1,
          'particulars' => 'Puncher, 2 hole, Wells Brand',
          'unit_cost' => 150,
          'remarks' => '',
          'end_user' => 145
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
