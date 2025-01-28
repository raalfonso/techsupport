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
            ['id' => 1, 'category_id' => '1',
            'resolution_timeline'=>'10',
            'procedure' =>'Ask the contact person if there is a setup for an online meeting or an onsite presentation' , 
            'title' => 'Setup boardroom', 
            'mains_id' => '1', 
            'type' => 'request'],

            ['id' => 2, 'category_id' => '1','resolution_timeline'=>10,
            'procedure' =>'Ask the contact person if there is a setup for an online meeting or an onsite presentation',
            'title' => 'Setup Conference room A', 
            'mains_id' => '1', 'type' => 'request'],

            ['id' => 3, 'category_id' => '1','resolution_timeline'=>10,
            'procedure' =>'Ask the contact person if there is a setup for an online meeting or an onsite presentation' , 
            'title' => 'Setup Conference room B', 
            'mains_id' => '1', 'type' => 'request'],

            ['id' => 4, 'category_id' => '1','resolution_timeline'=>10,
            'procedure' =>'Ask the contact person if there is a setup for an online meeting or an onsite presentation' , 
            'title' => 'Setup Conference room C', 
            'mains_id' => '1', 'type' => 'request'],

            ['id' => 5, 'category_id' => '1','resolution_timeline'=>10,
            'procedure' =>'Ask the contact person if there is a setup for an online meeting or an onsite presentation' , 
            'title' => 'Setup Conference room D', 
            'mains_id' => '1', 'type' => 'request'],

            ['id' => 6, 'category_id' => '1','resolution_timeline'=>10,
            'procedure' =>'Ask the contact person if there is a setup for an online meeting or an onsite presentation' , 
            'title' => 'Setup Zoom meeting', 
            'mains_id' => '1', 'type' => 'request'],

            ['id' => 7, 'category_id' => '1','resolution_timeline'=>10,
            'procedure' =>'Ask the contact person if there is a setup for an online meeting or an onsite presentation', 
            'title' => 'Setup Google meet', 
            'mains_id' => '1', 'type' => 'request'],

            ['id' => 8, 'category_id' => '2','resolution_timeline'=>20,
            'procedure' =>'Ask or troubleshoot any potential issues, such as the mic, camera, internet connection, etc.' , 
            'title' => 'Zoom/Google Meet Issue', 
            'mains_id' => '1', 'type' => 'report'],

            ['id' => 9, 'category_id' => '1','resolution_timeline'=>0,
            'procedure' =>'' , 
            'title' => 'Others', 
            'mains_id' => '1', 'type' => 'report'],
           
            
            // Acumatica
            ['id' => 10, 'category_id' => '1','resolution_timeline'=>5,
            'procedure' =>'Go to User in acumatica search the user account and click reset password <br> input default password: BCDA1234' ,
            'title' => 'Acumatica forgot password', 
            'mains_id' => '2', 'type' => 'report'],

            ['id' => 11, 'category_id' => '1', 'resolution_timeline'=>5,
            'procedure' =>'Go to User in acumatica search the user account and click unlock button' ,
            'title' => 'Acumatica lock account', 
            'mains_id' => '2', 'type' => 'report'],

            ['id' => 12, 'category_id' => '1', 
            'title' => 'Updating Report Design in acumatica', 
            'procedure' => 'Open Acumatica Report Designer <br>
            Press Controler L to login<br>
            Input Credentials and report template ',
            'resolution_timeline'=>30, 'mains_id' => '2', 'type' => 'request'],

            ['id' => 13, 'category_id' => '1', 
            'title' => 'Others',
            'procedure'=>'', 
            'resolution_timeline'=>0, 
            'mains_id' => '2', 'type' => 'request'],

         
            //security
            ['id' => 14, 
            'category_id' => '3', 
            'resolution_timeline'=>30, 
            'procedure' => '', 
            'title' => 'Malware detection', 
            'mains_id' => '3', 
            'type' => 'report'], 

            ['id' => 15, 
            'category_id' => '3', 
            'resolution_timeline'=>30, 
            'procedure' => 'Report/Block the email then Delete ', 
            'title' => 'Phishing detection', 
            'mains_id' => '3', 
            'type' => 'report'], 

            ['id' => 16, 
            'category_id' => '3', 
            'resolution_timeline'=>20, 
            'procedure' => 'Re-install the Trend Micro agent', 
            'title' => 'C&C Call back Threats', 
            'mains_id' => '3', 
            'type' => 'report'], 

            ['id' => 17, 
            'category_id' => '3', 
            'resolution_timeline'=>0, 
            'procedure' => 'Isolate the PC then investigate and/or escalate to the Third Party Supplier', 
            'title' => 'Ransomware', 'mains_id' => '3', 
            'type' => 'report'],

            ['id' => 18, 'category_id' => '3', 
            'resolution_timeline'=>0, 'procedure' => 'Manual Scanning then get the Result ', 
            'title' => 'Web Reputation/Behavior Monitoring/Device Control/SuspiciousFiles/ Malware', 
            'mains_id' => '3', 'type' => 'report'],

            ['id' => 19, 'category_id' => '3', 
            'resolution_timeline'=>0, 'procedure' => 'Manual Scanning then get the Result ', 
            'title' => 'Web Reputation/Behavior Monitoring/Device Control/SuspiciousFiles/ Malware', 
            'mains_id' => '3', 'type' => 'report'],

            ['id' => 20, 'category_id' => '3', 
            'resolution_timeline'=>0, 
            'procedure' => '', 
            'title' => 'Others', 
            'mains_id' => '3', 'type' => 'report'],
 




            //hardware
            ['id' => 21, 'category_id' => '2','resolution_time'=> 20, 
            'title' => 'Add scan or scan issue (SMB)', 
            'procedure' => 'Check if the user exists in the Scan Shared Folder and its file. Add to SSF(1) or the printer machine(2), share config(3), or map the SMB file to the users desktop(4).',
            'mains_id' => '4', 
            'type' => 'report'],

            ['id' => 22, 'category_id' => '2','resolution_time'=> 15, 
            'title' => 'Add printer or printer issue', 
            'procedure' => 'Check if the user is connected to the designated printer (IP) department, config acctng if available, default paper size to a4. If not, add it to the printer base in the nearest printer using machine driver.',
            'mains_id' => '4', 
            'type' => 'report'],

            ['id' => 23, 'category_id' => '1','resolution_time'=> 10, 
            'title' => 'Replace printer toner/supplies', 
            'procedure' => 'You can check what Toner to replace <br>Go to the IP Printer -> Status -> Consumables',
            'mains_id' => '4', 
            'type' => 'report'],

            ['id' => 24, 'category_id' => '1','resolution_time'=> 15, 
            'title' => 'Problem printing a specific size of paper', 
            'procedure' => 'Check and change print settings (Paper size, tray, etc.)',
            'mains_id' => '4', 
            'type' => 'report'],

            ['id' => 25, 
            'category_id' => '2',
            'resolution_time'=> 5, 
            'title' => 'PC Unlock / Reset Account', 
            'procedure' => 'Unlock/Reset the Account in Active Directory',
            'mains_id' => '4', 
            'type' => 'report'],

            ['id' => 26, 
            'category_id' => '2',
            'resolution_time'=> 5, 
            'title' => 'IP Phone Directory - Change Name/Redirect Answer/Change number', 
            'procedure' => 'Go to Mitel Directory -> Administration -> Users -> Change Name ',
            'mains_id' => '4', 
            'type' => 'report'],

            ['id' => 27, 
            'category_id' => '2',
            'resolution_time'=> 10, 
            'title' => 'IP Phone No Service', 
            'procedure' => 'Reconnect the LAN / Check the connection ',
            'mains_id' => '4', 
            'type' => 'report'],

            ['id' => 28, 
            'category_id' => '2',
            'resolution_time'=> 10, 
            'title' => 'IP Phone No Service', 
            'procedure' => 'Reconnect the LAN / Check the connection ',
            'mains_id' => '4', 
            'type' => 'report'],

            ['id' => 29, 
            'category_id' => '2',
            'resolution_time'=> 0, 
            'title' => 'Others', 
            'procedure' => '',
            'mains_id' => '4', 
            'type' => 'report'],
            

            
            //network
            ['id' => 30, 
            'category_id' => '2',
            'resolution_time'=> 0, 
            'title' => 'Wi-Fi / LAN Connectivity Issues', 
            'procedure' => 'Ask Sir Alex. (Check Wifi/Lan Connection in DHCP, get IP)',
            'mains_id' => 5, 
            'type' => 'report'],

            ['id' => 31, 
            'category_id' => '1',
            'resolution_time'=> 0, 
            'title' => 'VPN Connection Setup or Troubleshooting', 
            'procedure' => 'Assist seting ip ',
            'mains_id' => 5, 
            'type' => 'report'],

            //AODocs

            ['id' => 32,'category_id' => '2', 'title' => 'AODOCS (VR) Modify Workflow', 'resolution_timeline' => 5, 'procedure' => 'Go to  the specific VR and select administrator action edit work flow', 'mains_id' => 6, 'type' => 'report'],
            ['id' => 33,'category_id' => '2', 'title' => 'Others', 'resolution_timeline' => 0, 'procedure' => '', 'mains_id' => 6, 'type' => 'report'],

            //Software
            ['id' => 34, 
            'category_id' => '1',
            'resolution_time'=> 20, 
            'title' => 'OS/BIOS Issues (Windows/Mac OS)', 
            'procedure' => 'Troubleshoot the device.',
            'mains_id' => 7, 
            'type' => 'report'],

            ['id' => 35, 
            'category_id' => '1',
            'resolution_time'=> 10, 
            'title' => 'Adobe or Autodesk Software Issues', 
            'procedure' => 'Troubleshoot or update the software.',
            'mains_id' => 7, 
            'type' => 'report'],

            ['id' => 36, 
            'category_id' => '1',
            'resolution_time'=> 20, 
            'title' => 'Microsoft Office Problems (Word, Excel, PPT, etc.)', 
            'procedure' => 'Troubleshoot MS Ofiice.',
            'mains_id' => 7, 
            'type' => 'report'],

            ['id' => 37, 
            'category_id' => '1',
            'resolution_time'=> 0, 
            'title' => 'Others', 
            'procedure' => '',
            'mains_id' => 7, 
            'type' => 'report'],


            //Gsuite google workspace

            ['id' => 38, 'category_id' => '1',
            'resolution_timeline' =>5, 
            'title' => 'Google forgot Password',
            'procedure' =>'Go to Admin Console of Google and <br>search the user account and click reset password<br>input default password: BCDA1234', 
            'mains_id' => '8', 'type' => 'report'],
            ['id' => 39, 'category_id' => '1',
            'resolution_timeline' =>60, 
            'title' => 'Google Account Deactivation',
            'procedure' =>'1. Log in to the Admin Console
                <br> • Navigate to the Admin Console.
                <br> • Authenticate using your admin credentials.

                 <br> <br>2. Reset the Password
                 <br>• Locate the user account to be deleted.
                 <br>• Reset the account password for secure access. (BCDA1234)

                <br><br>3. Transfer Drive Ownership
                <br>• In the Admin Console, go to:
                <br>• Apps > Google Workspace > Drive and Docs > Transfer Ownership.
                <br>• Transfer ownership of files from the user account to ictd_admin@bcda.gov.ph.

                <br><br>4. Reset Security Settings
                <br>• Locate the User Again
                <br>• In the Security tab:
                <br>• Reset OTP and Recovery Email.
                <br>• Turn off Login Challenge temporarily (for 10 minutes).
                <br>
                <br>5. Access the ICTD Admin Google Drive
                <br>• Open the Google Drive of the ictd_admin@bcda.gov.ph account.
                <br>• Locate the folder containing the email of the user.
                <br>• Move the folder to: BCDA Google > SCRP.
                <br>• Rename the folder to: From Google Drive of [user email].

                <br><br>6. Create a Google Takeout Archive
               <br>• Log in to the user account to be deleted.
               <br>• Visit takeout.google.com.
               <br>• Deselect all services except the following:
                   <br>○ Contacts
                   <br>○ Calendar
                   <br>○ Mail
                   <br>○ Photos
                   <br>○ Drive
                   <br>○ Chat
                <br>• Initiate the archive export:
                <br>• Select "Add to Drive"
                <br>• Click Create Export.
                <br>• Wait for the notification of export completion.

                <br><br>7. Complete Final Drive Ownership Transfer
                <br>• Open the Admin Console.
                <br>• Re-initiate the file ownership transfer to ictd_admin@bcda.gov.ph.
                <br>• Move the user folder to: ARCHIVED GMAIL ACCOUNTS (Starred).
                <br>• Rename the folder to: [Date of Archiving].

                <br><br>8. Delete the User Account
                <br>• Log back into the Admin Console.
                <br>• Locate the user account.
                <br>• Delete the account permanently.

                <br><br>9. Update the Monitoring Sheet
                <br>• Open the organizational monitoring sheet.
                <br>• Input the following details:
                <br>• User account information.
                <br>• Date of deletion.
                <br>• Untick the Enterprise Starter and Enterprise Standard subscriptions.', 
                'mains_id' => '8', 'type' => 'report'],

            ['id' => 40, 'category_id' => '2', 
            'title' => 'Google Account Creation',
            'resolution_timeline' => 15, 
            'procedure'=>'
                <br>1. Update the Monitoring Sheet
                <br>• Open the organizational monitoring sheet.
                <br>• Insert the following details for the new account:
                    <br>○ First Name
                    <br>○ Last Name
                    <br>○ Primary Email (e.g., name@scrp.bcda.gov.ph)
                    <br>○ Org Unit: SCRP
                <br>○ Default Password: Welcome2SCRP!
                <br>• Save and verify the entry.

               <br>2. Add the User to Google Admin Console
               <br>• Log in to the Admin Console.
               <br>• Navigate to Directory > Users.
               <br>• Click Add User and input the following information:
                   <br>○ First Name: Users first name.
                   <br>○ Last Name: Users last name.
                   <br>○ Primary Email: name@scrp.bcda.gov.ph.
                   <br>○ Password: Use the default password Welcome2SCRP!.
                   <br>○ Assign the user to the SCRP Org Unit.

                <br>3. Add the User to Groups
                <br>• In the Admin Console, go to Groups.
                <br>• Add the new user to the following groups:
                    <br>○ MANPOWER
                    <br>○ SUBIC-CLARK
                <br>• Verify that the user appears in both groups.

                <br>4. Add the User to Space Chat
                <br>• Open Google Chat.
                <br>• Search for the space named SCRP IT SUPPORT.
                <br>• Add the new user to the space.
                   <br>○ Click the space name > Manage Members > Add People & Apps.
                   <br>○ Search for the users email and click Add.', 
                'mains_id' => '8', 'type' => 'request'],
            ['id' => 41, 'category_id' => '2', 
            'title' => 'RC Account Configuration', 
            'resolution_timeline'=>15,
            'procedure'=>'1. Add the User to Group Emails
            <br>• Log in to the Admin Console.
                <br>• Navigate to Groups.
                <br>• Search for the relevant group emails based on department and site:
                <br>    ○ Per Dept RC Group Email.
                <br>    ○ Per Site (e.g., OW, BTC).
                <br>• Add the new RCs email to the respective groups:
                <br>    ○ Open the group > Manage Members > Add Members.
                <br>    ○ Input the new RCs email and save changes.
                <br>
                <br>2. Update the Organizational Unit (ORG UNIT)
                <br>• In the Admin Console, go to Directory > Users.
                <br>• Locate the newly created RC account.
                <br>• Edit the accounts Org Unit and change it to: AODOCS.
                <br>• Save and verify the update.
                <br>
                <br>3. Update the Script "Autofill Dept Head" in AODOCS
                <br>• Access the script responsible for autofilling department head details in AODOCS.
                <br>    ○ Open the associated Google Script project.
                <br>    ○ Open  "Autofill Dept Head" script.
                <br>• Add the new RC email to the script:
                <br>    ○ Identify the relevant section for department head or RC email mapping.
                <br>    ○ Insert the new email in the correct format and section.
                <br>• Save the changes and deploy the updated script.', 
                'mains_id' => '8', 'type' => 'report'],
                ['id' => 42, 'category_id' => '1', 
                'title' => 'Others', 
                'resolution_timeline'=>15,
                'procedure'=>'', 
                'mains_id' => '8', 'type' => 'report'],

                ['id' => 43, 'category_id' => '1', 
                'title' => 'Others', 
                'resolution_timeline'=>15,
                'procedure'=>'', 
                'mains_id' => '9', 'type' => 'report'],

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
