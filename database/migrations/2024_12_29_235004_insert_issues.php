<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::table('categories')->insert([
            ['id' => 1, 'title' => 'Low',],
            ['id' => 2, 'title' => 'Medium',],
            ['id' => 3, 'title' => 'High',],
        ]);

        DB::table('issues')->insert([
            ['id' => 1, 'category_id' => '1','resolution_timeline'=>10,
            'procedure' =>'Go to User in acumatica search the user account and click reset password <br> input default password: BCDA1234',
            'title' => 'Acumatica forgot password', 
            'mains_id' => '2', 'type' => 'SYSTEMS'],

            ['id' => 2, 'category_id' => '1',
            'resolution_timeline' =>10, 
            'title' => 'Google Account forgot Password',
            'procedure' =>'Go to Admin Console of Google and <br>search the user account and click reset password<br>input default password: BCDA1234', 
            'mains_id' => '2', 'type' => 'SYSTEMS'],

            ['id' => 3,'category_id' => '1', 
             'title' => 'AODOCS Automation (VR) Request State Change', 'resolution_timeline' => 5, 
             'procedure' => 'Go to  the specific VR and select administrator action edit work flow', 
             'mains_id' => 2, 'type' => 'SYSTEMS'],

            ['id' => 4, 'category_id' => '1',
             'resolution_timeline' =>10, 
             'title' => 'Google Account Deactivation',
             'procedure' =>'',
             'mains_id' => '2', 'type' => 'SYSTEMS'],
          
            ['id' => 5, 'category_id' => '1',
             'resolution_timeline' =>10, 
             'title' => 'Request Access to Lotus Notes, SAP',
             'procedure' =>'',
             'mains_id' => '99', 'type' => 'NIS'],

            ['id' => 6, 
             'category_id' => '3', 
             'resolution_timeline'=>960, 
             'procedure' => 'Re-install the Trend Micro agent', 
             'title' => 'C&C Call back Detection/Infection', 
             'mains_id' => '3', 
             'type' => 'NIS'],

            ['id' => 7, 
             'category_id' => '3', 
             'resolution_timeline'=>960, 
             'procedure' => 'Isolate the PC then investigate and/or escalate to the Third Party Supplier', 
             'title' => 'Ransomware Detection', 'mains_id' => '3', 
             'type' => 'NIS'],

            ['id' => 8, 
             'category_id' => '3', 
             'resolution_timeline'=>960, 
             'procedure' => 'Isolate the PC then investigate and/or escalate to the Third Party Supplier', 
             'title' => 'Ransomware Infection (Minimal)', 'mains_id' => '3', 
             'type' => 'NIS'],

            ['id' => 9, 
             'category_id' => '3', 
             'resolution_timeline'=>2400, 
             'procedure' => 'Isolate the PC then investigate and/or escalate to the Third Party Supplier', 
             'title' => 'Ransomware Infection (Outbreak)', 'mains_id' => '3', 
             'type' => 'NIS'],

            ['id' => 10, 'category_id' => '2', 
            'resolution_timeline'=>180, 
            'procedure' => 'Manual Scanning then get the Result ', 
            'title' => 'Web Reputation/Behavior Monitoring/Device Control/SuspiciousFiles/ Malware Detection/ Infection', 
            'mains_id' => '3', 'type' => 'NIS'],

            ['id' => 11, 
            'category_id' => '3', 
            'resolution_timeline'=>45, 
            'procedure' => 'Report/Block the email then Delete ', 
            'title' => 'Phishing Email Detection/Spam', 
            'mains_id' => '3', 
            'type' => 'NIS'], 
             
            ['id' => 12, 'category_id' => '2','resolution_time'=> 20, 
            'title' => 'Add scan or scan issue (SMB/FTP)', 
            'procedure' => 'Check if the user exists in the Scan Shared Folder and its file. Add to SSF(1) or the printer machine(2), share config(3), or map the SMB file to the users desktop(4).',
            'mains_id' => '4', 
            'type' => 'NIS'],

            ['id' => 13, 'category_id' => '2','resolution_time'=> 15, 
            'title' => 'Add Printer/Installation', 
            'procedure' => 'Check if the user is connected to the designated printer (IP) department, config acctng if available, default paper size to a4. If not, add it to the printer base in the nearest printer using machine driver.',
            'mains_id' => '4', 
            'type' => 'NIS'],

            ['id' => 14, 'category_id' => '1','resolution_time'=> 10, 
            'title' => 'Replace Printer Toner/Supplies', 
            'procedure' => 'You can check what Toner to replace <br>Go to the IP Printer -> Status -> Consumables',
            'mains_id' => '4', 
            'type' => 'NIS'],

            ['id' => 15, 'category_id' => '1','resolution_time'=> 15, 
            'title' => 'Problem Printing a specific size of paper', 
            'procedure' => 'Check and change print settings (Paper size, tray, etc.)',
            'mains_id' => '4', 
            'type' => 'NIS'],
            
            ['id' => 16, 'category_id' => '2',
            'resolution_time'=> 10, 
            'title' => 'PC Unlock / Reset Account', 
            'procedure' => 'Unlock/Reset the Account in Active Directory',
            'mains_id' => '4', 
            'type' => 'NIS'],

            ['id' => 17, 
            'category_id' => '1',
            'resolution_time'=> 10, 
            'title' => 'IP Phone Directory - Change Name', 
            'procedure' => 'Go to Mitel Directory -> Administration -> Users -> Change Name ',
            'mains_id' => '4', 
            'type' => 'NIS'],
            
            ['id' => 18, 
            'category_id' => '2',
            'resolution_time'=> 60, 
            'title' => 'IP Phone Installation', 
            'procedure' => 'Go to Mitel Directory -> Administration -> Users -> Change Name ',
            'mains_id' => '4', 
            'type' => 'NIS'],

            ['id' => 19, 
            'category_id' => '3',
            'resolution_time'=> 30, 
            'title' => 'IP Phone No Service/No Power', 
            'procedure' => 'Reconnect the LAN / Check the connection ',
            'mains_id' => '4', 
            'type' => 'NIS'],

            ['id' => 20, 'category_id' => '1',
            'resolution_timeline'=>'10',
            'procedure' =>'Ask the contact person if there is a setup for an online meeting or an onsite presentation' , 
            'title' => 'Setup or Assistance for Meeting', 
            'mains_id' => '1', 
            'type' => 'NIS'],

            ['id' => 21, 'category_id' => '2',
            'resolution_timeline'=>10,
            'procedure' =>'Ask the contact person if there is a setup for an online meeting or an onsite presentation' , 
            'title' => 'Zoom/Google Meet Issue', 
            'mains_id' => '1', 'type' => 'NIS'],

            
            ['id' => 22, 'category_id' => '3',
            'resolution_timeline'=>15,
            'procedure' =>'' , 
            'title' => 'Create Banner display/Bulletin board', 
            'mains_id' => '99', 'type' => 'NIS'],

            ['id' => 23, 'category_id' => '2',
            'resolution_timeline'=>60,
            'procedure' =>'' , 
            'title' => 'Software Problem (Drivers/Software update, system reboot)', 
            'mains_id' => '4', 'type' => 'NIS'],

            ['id' => 24, 'category_id' => '1',
            'resolution_timeline'=>30,
            'procedure' =>'' , 
            'title' => 'Hardware Problem (loose contact issue, Power)', 
            'mains_id' => '4', 'type' => 'NIS'],

            ['id' => 25, 'category_id' => '2',
            'resolution_timeline'=>'10',
            'procedure' =>'' , 
            'title' => 'Projector/Document Camera Setup', 
            'mains_id' => '1', 
            'type' => 'NIS'],

            ['id' => 26, 'category_id' => '1',
            'resolution_timeline'=>'15',
            'procedure' =>'' , 
            'title' => 'Recording Retrieval', 
            'mains_id' => '1', 
            'type' => 'NIS'],

            ['id' => 27, 'category_id' => '1',
            'resolution_timeline'=>'10',
            'procedure' =>'' , 
            'title' => 'Request for Peripherals (Webcam, DOcCam, etc)', 
            'mains_id' => '1', 
            'type' => 'NIS'],

            ['id' => 28, 'category_id' => '3',
            'resolution_timeline'=>'10',
            'procedure' =>'' , 
            'title' => 'Wi-Fi / LAN Connectivity Issues', 
            'mains_id' => '4', 
            'type' => 'NIS'],
       
            ['id' => 29, 'category_id' => '1',
            'resolution_timeline'=>'20',
            'procedure' =>'' , 
            'title' => 'VPN Connection Setup or Troubleshooting', 
            'mains_id' => '4', 
            'type' => 'NIS'],
            
            ['id' => 30, 'category_id' => '1',
            'resolution_timeline'=>'15',
            'procedure' =>'' , 
            'title' => 'Adobe or Autodesk Software Issues', 
            'mains_id' => '4', 
            'type' => 'NIS'],

             ['id' => 31, 'category_id' => '1',
            'resolution_timeline'=>'20',
            'procedure' =>'' , 
            'title' => 'Microsoft Office Problems(Word,Excel,PPT, etc)', 
            'mains_id' => '4', 
            'type' => 'NIS'],

             ['id' => 32, 'category_id' => '1','resolution_timeline'=>10,
            'procedure' =>'Go to HRIS search the user account and click reset failed attempts',
            'title' => 'HRIS Reset User Failed Attempts', 
            'mains_id' => '2', 'type' => 'SYSTEMS'],

            ['id' => 33, 'category_id' => '1','resolution_timeline'=>10,
            'procedure' =>'Go to User in acumatica search the user account and click unlock button',
            'title' => 'Acumatica Unlock User Account', 
            'mains_id' => '2', 'type' => 'SYSTEMS'],

            ['id' => 34, 'category_id' => '2','resolution_timeline'=>60,
            'procedure' =>'',
            'title' => 'Google Workspace Script Error', 
            'mains_id' => '2', 'type' => 'SYSTEMS'],

            ['id' => 35, 'category_id' => '1','resolution_timeline'=>20,
            'procedure' =>'',
            'title' => 'Google Spreadsheet Formula', 
            'mains_id' => '2', 'type' => 'SYSTEMS'],

             ['id' => 36, 'category_id' => '2','resolution_timeline'=>60,
            'procedure' =>'',
            'title' => 'Microsoft Excel Script Error', 
            'mains_id' => '2', 'type' => 'SYSTEMS'],

            ['id' => 37, 'category_id' => '1','resolution_timeline'=>20,
            'procedure' =>'',
            'title' => 'Microsoft Excel Formula', 
            'mains_id' => '2', 'type' => 'SYSTEMS'],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
