<?php
get_header();

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<style>

    table, th, td {
        border: 1px solid #888888;
        border-collapse: collapse;
        word-wrap:break-word;
        table-layout: auto;
        text-align: center;
        padding: 3px;
    }
    table {
        margin-top: 40px;
    }
    /*#AGG {*/
    /*    display: none;*/
    /*}*/
    /*#PDL {*/
    /*    display: none;*/
    /*}*/
</style>
<?php
########################################################################################################################
// Function to get temporary token
########################################################################################################################
function getToken() {
   $curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://dna.magnetmail.net/ApiAdapter/Rest/Authenticate/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>"",
    CURLOPT_HTTPHEADER => array(
        "Authorization: Basic ",
        "Content-Type: application/json"
    ),
));

$response = curl_exec($curl);
curl_close($curl);
$token = json_decode(json_encode((array)simplexml_load_string($response)), true);
echo json_encode($token['SessionID']);
//echo '<pre>';
//print_r($token);
//echo '</pre>';


}



function getGroups(){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://dna.magnetmail.net/ApiAdapter/Rest/SearchRecipient/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 2000,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ",
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    //echo $response;
    $unsubs = json_decode(json_encode((array)simplexml_load_string($response)), true);

$count = 0;
    foreach ($unsubs as $key => $value) {
        foreach ($value as $i => $item) {
            foreach ($item as $g => $k) {
                if(!is_array($k)) {
                        //echo  $g .'--->'. $k . '<br/>' ;

                            echo  $g .'--->'. $k . '<br/>' ;

                }
            }
            $count ++;
            echo $count;
            echo "<hr>\n";
        }
    }

echo '<pre>';
print_r ($unsubs);

}
getGroups();















########################################################################################################################
// Function to get Aggregate Info by specific Mailing Id
########################################################################################################################
function getAggregateData($mailId){

    $userToken = "Basic ";
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.postup.com/api/mailingstatistics/'.$mailId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: " . $userToken
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $data =json_decode($response, true);
    return $data;
}

########################################################################################################################
// Function to get User's info (npi, address, etc) in demographics inner array
########################################################################################################################
function findUserId($id){

    $userToken = "Basic ";
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.postup.com/api/recipient/'.$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: " . $userToken
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    // Decode JSON object into assoc array
    $data =json_decode($response, true);
    return $data['recipientId'];
}

########################################################################################################################
// Function to get Campaign Data
########################################################################################################################
function getCampDetails($campaignid){

    $userToken = "Basic ";
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.postup.com/api/mailing?campaignid='.$campaignid,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: " . $userToken
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    // Decode JSON object into assoc array
    $data =json_decode($response, true);
    return $data;


}





########################################################################################################################
// Function to get All Campaigns
########################################################################################################################
function getAllCampaigns(){

    $userToken = "Basic ";
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.postup.com/api/campaign',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: " . $userToken
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    // Decode JSON object into assoc array
    $data =json_decode($response, true);

        return $data;


}


########################################################################################################################
// Function to get All Campaigns
########################################################################################################################
function getList($listIdArray){

    $userToken = "Basic dGdhcnlhZXZhQGFtZXJpY2FubWVkaWNhbGNvbW0uY29tOk9sZWNoa2EwNA==";
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.postup.com/api/list/'. $listIdArray,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: " . $userToken
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    // Decode JSON object into assoc array
    $data =json_decode($response, true);
   return $data ['title'];


}






########################################################################################################################
// Function to get User's info (npi, address, etc) in demographics inner array
########################################################################################################################
function user_demo($userId, $fieldID=null){

    $userToken = "Basic dGdhcnlhZXZhQGFtZXJpY2FubWVkaWNhbGNvbW0uY29tOk9sZWNoa2EwNA==";
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.postup.com/api/recipient/'.$userId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: " . $userToken
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    // Decode JSON object into assoc array
    $data =json_decode($response, true);
    if($fieldID != null){
        return $data['demographics'][$fieldID];
    }
    else {
        return $data;
    }
}
echo "<br>";

########################################################################################################################
// Function to process PDL info
########################################################################################################################

function getPDL($mailingID) {
    // User's credentials can be inserted by current user--> need to insert to form
    //echo "getPLD triggered with mailingID: ".$mailingID;

    $access_token = getToken();
    $username = 'tgaryaeva@americanmedicalcomm.com';
    $password = 'Olechka04';
    $userToken = "Basic dGdhcnlhZXZhQGFtZXJpY2FubWVkaWNhbGNvbW0uY29tOk9sZWNoa2EwNA==";

    $curl = curl_init();
    // this fetches specific mailing with OPEN type
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://login.postup.com/amyhft/ExternalDownload.do?siteID=33CF394E-2D04-4257-8BBD-EE0B41E3908F&mailingID=' . $mailingID . '&type=OPEN&user=' . $username . '&token='.$access_token,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic " . $userToken,
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    print_r($response);
    $textLines = explode("\r\n", $response);
    $textArray = array();
    $headers = array();
    foreach ($textLines as $index => $line) {
        $fields = explode("\t", $line);
        foreach ($fields as $findex => $field) {
            if ($index == 0) {
                $headers[] = $field;
            } else {
                $textArray[$index - 1][$headers[$findex]] = $field;
            }
        }
    }
    return $textArray;
    // echo '<pre>';
    // print_r($textArray);
    // echo '</pre>';

}




########################################################################################################################
//The actions begin here
########################################################################################################################

?>







<!-- This is section with PDL data -->
<!--<div id="PDL" class="container">
    <div class="row"  >
        <div class="col-sm">
            <form action="<?php /*echo $_SERVER['PHP_SELF']; */?>" method="GET">
                <div class="input-group">
                    <label for="mailingID"></label>
                    <input type="text" class="form-control" placeholder="Enter PLD Mailing ID" id="mailingID"
                           name="mailingID"  >
                    <input type="hidden" class="form-control" id="checkSearch" name="checkPLD" value="1">
                    <div class="input-group-append">
                        <input class="btn btn-outline-secondary" id="toggleBtn" type="submit"
                               value="submit" >

                        <a href="#" class="export btn btn-info" >Export as CSV</a>

                    </div>
                </div>
            </form>
            <div  class="container" id="dvData">

                <table id="data" style="width:100%;" >
                    <thead>
                    <tr>

                        <th>Recipient Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>NPI</th>
                        <th>Email</th>
                        <th>Open Time</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip Code</th>
                        <th>Country</th>
                    </tr>
                    </thead>
                    --><?php
/*

                    if(isset($_GET['mailingID'])) {
                    // These are input values from the form
                    $mailingID = $_GET['mailingID'];
                    //start the session
                    // session_start();
                    // $_SESSION['mailingID'] = $mailingID;

                    $pdl = getPDL($mailingID);

                    foreach ($pdl as $item ) {
                    $openRecipId = $item['RecipID'];
                    $userID = findUserId($openRecipId);
                    $userInfo = user_demo($userID);
                    // To see the entire object
                    //print_r($userInfo);

                    // This is Recipient Id from the main object
                    $userRecipId = $userInfo['recipientId'];
                    // These are Recipient Info from demographic array
                    $firstName = str_replace("FirstName=", "", $userInfo['demographics'][0]);
                    $lastName = str_replace("LastName=", "", $userInfo['demographics'][1]);
                    $Address1 = str_replace("_Address1=", "", $userInfo['demographics'][2]);
                    $city = str_replace("_City=", "", $userInfo['demographics'][4]);
                    $state = str_replace("_State=", "", $userInfo['demographics'][5]);
                    $zipCode = str_replace("_PostalCode=", "", $userInfo['demographics'][6]);
                    $country = str_replace("_Country=", "", $userInfo['demographics'][7]);
                    $npi = str_replace("npi=", "", $userInfo['demographics'][24]);


                    if($userID == $openRecipId){
                    */?>


<!--
                    <tr>
                        <td><?php /*echo $item['RecipID']; */?></td>
                        <td><?php /*echo $firstName; */?></td>
                        <td><?php /*echo $lastName; */?></td>
                        <td><?php /*echo $npi; */?></td>
                        <td><?php /*echo $item['Address']; */?></td>
                        <td><?php /*echo $item['OpenTime']; */?></td>
                        <td><?php /*echo $Address1; */?></td>
                        <td><?php /*echo $city; */?></td>
                        <td><?php /*echo $state; */?></td>
                        <td><?php /*echo $zipCode; */?></td>
                        <td><?php /*echo $country;}}}*/?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>-->
<!--------------------------------------------------------------------------------------------------------------->

<!-- This is section with AGG data -->
<div id="AGG" class="container">
    <h1 class="display-4 mb-1">Mailing Reporting System </h1>
    <p class="lead mb-5">
        Mailing Reporting System allows you to fetch an aggregate data for a specific mailing
        by entering Campaign Name and Mailing Id and export it as .csv file.
    </p>
    <div class="row" >
        <div class="col-sm">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text text-white bg-info" for="inputGroupSelect01"> Campaign Options</label>
                        </div>
                        <label for="campOpt"></label>
                        <select name="campOpt" class="custom-select " id="campOpt" >
                            <option>select one</option>
                            <?php
                            $camps = getAllCampaigns();
                            foreach ($camps as $item ) :
                                echo '<option value="'.$item['campaignId'] .'">'.$item['title'] .'</option>'; //close your tags!!
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="mailID"></label>
                        <input type="text" class="form-control" placeholder="Enter Aggregate Mailing ID" id="mailID" name="mailID" >
                        <input type="hidden" class="form-control" id="checkSearch" name="checkAGG" value="1">
                        <div class="input-group-append">
                            <input class="btn btn-outline-secondary" id="toggleButton" type="submit" value="search">
                            <a href="#" class="export btn btn-info" >Export as CSV</a>

                        </div>
                    </div>
            </form>
            <div id="dvData" >

                <table id="data" class="table table-sm table-dark"  >
                    <thead>
                    <tr>
                        <th>Month</th>
                        <th>Supplier</th>
                        <th>Brand</th>
                        <th>Vehicle</th>
                        <th>Placement_Name</th>
                        <th>CMI_PlacementID</th>
                        <th>Target_List_ Segment</th>
                        <th>Target_List_Tier</th>
                        <th>Other_nonTL_ segment</th>
                        <th>Specialty</th>
                        <th>Subject_Line</th>
                        <th>Headline_Copy</th>
                        <th>Creative_Message</th>
                        <th>Answers</th>
                        <th>Answers_correct</th>
                        <th>Answers_incorrect</th>
                        <th>Answers_unique</th>
                        <th>Asset_advancement</th>
                        <th>Asset_completes</th>
                        <th>Asset_start_interactions</th>
                        <th>Asset_undos</th>
                        <th>Bounces</th>
                        <th>Clicks</th>
                        <th>Clicks_Brand Site</th>
                        <th>Clicks_Drivers</th>
                        <th>Clicks_EN</th>
                        <th>Clicks_PI_ISI</th>
                        <th>CTR</th>
                        <th>Delivered_AL</th>
                        <th>Delivered_DM</th>
                        <th>Delivered_EM</th>
                        <th>Delivered_WB</th>
                        <th>Downloads_Offers</th>
                        <th>Downloads_Info</th>
                        <th>Expansions</th>
                        <th>Views_Headline</th>
                        <th>Impressions</th>
                        <th>Impressions_drivers</th>
                        <th>Open Rate</th>
                        <th>Opens</th>
                        <th>Opens_Unique</th>
                        <th>Page Views</th>
                        <th>Quiz or Survey_Completes</th>
                        <th>Quiz or Survey_Delivered</th>
                        <th>Quiz or Survey_Opens</th>
                        <th>Quiz or Survey_Started</th>
                        <th>Reach</th>
                        <th>Reach_Unique Cumulative </th>
                        <th>Read_EM</th>
                        <th>Redeemed</th>
                        <th>Registrations_Completed</th>
                        <th>Registrations_Intent</th>
                        <th>Request_Info_Completed</th>
                        <th>Request_Info_Intent</th>
                        <th>Request_Sample_Completed </th>
                        <th>Request_Sample_Intent</th>
                        <th>Responses_DM</th>
                        <th>Sent</th>
                        <th>Sent_DM</th>
                        <th>Shared</th>
                        <th>Time Spent</th>
                        <th>Time Spent_unique </th>
                        <th>Undelivered_DM </th>
                        <th>Unsubscribe_email</th>
                        <th>Visits </th>
                    </tr>
                    </thead>


                    <?php
                    if ( isset($_GET['mailID']) && isset($_GET['campOpt'])) {
                    // These are input values from the form
                    $camp = $_GET['campOpt'];
                    $mailID = $_GET['mailID'];
                    echo '<br>';
                    echo '<span class="h6" >Report for Mailing ID: </span> ' .$mailID ;
                    echo '<br>';

                    //Assigning getAggregateData function to var agg
                    $agg = getAggregateData($mailID);
                    $delivered = floatval($agg['sent']);
                    $totalOpens = $agg['totalOpens'];
                    // Total Bounces
                    $totalBounces =  floatval($agg['hardBounces']) + floatval($agg['softBounces'])+ floatval($agg['blockBounces']);
                    $totalRecipients = floatval($agg['scheduled']) ;
                    // Calculating open rate
                    $openRate = sprintf('%0.2f',($totalOpens *100) / ($totalRecipients - $totalBounces)) ;
                    // Calculating CTN by dividing click by sent
                    $CTR = sprintf('%0.2f',($agg['totalHtmlClick']  * 100) / $agg['totalOpens']) ;


                    //Assigning getCampDetails function to var details
                    $details = getCampDetails($camp);
                    foreach ($details as $detail) :
                    // Check if mailingID is matching user's MailingId input
                    if($detail['mailingId'] == $mailID) : ?>

                   <?php echo '<span class="h6" >Mailing Title: </span> ' .$detail['title'];
                    echo '<br>'; ?>

                    <tr>
                        <td><?php
                            $timestamp = strtotime($detail['scheduledTime']);
                            $newDate = date('F-Y', $timestamp);
                            echo $newDate; //outputs 02-March-2011
                           // echo $detail['scheduledTime'];
                            ?></td>
                        <td></td>
                        <td></td>
                        <td>Email</td>
                        <td></td>
                        <td></td>
                        <td><?php
                            $listArray = $detail['listIds'];
                            foreach ($listArray as $list ) {
                                echo getList($list) . '<br> ';

                            }?></td>
                        <td></td>
                        <td></td>
                        <td></td>

                        <td><?php echo $detail['content']['subject'];  ?></td>
                    <?php endif;
                    endforeach; ?>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $totalBounces; ?></td>
                        <td><?php echo $agg['totalHtmlClick']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $CTR . '%'; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $agg['totalOpens']; ?></td>
                        <td></td>
                        <td><?php echo $openRate . '%' ?></td>
                        <td><?php echo $agg['totalOpens']; ?></td>
                        <td><?php echo $agg['uniqueOpens']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $agg['scheduled']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> </td>
                        <td></td>
                        <td></td>
                        <td><?php echo $agg['sent']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td> </td>
                        <td></td>
                        <td><?php echo $agg['unsubscribes'];} ?> </td>
                        <td> </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>




<script>
    /* function getQueryVariable(variable)
     {
         var query = window.location.search.substring(1);
         var vars = query.split("&");
         for (var i=0;i<vars.length;i++) {
             var pair = vars[i].split("=");
             if(pair[0] == variable){return pair[1];}
         }
         return(false);
     }*/
    $(document).ready(function() {

        /*   var aggVar = getQueryVariable("checkAGG");
           var pldVar = getQueryVariable("checkPLD");
           if( aggVar == 1){
               jQuery("#AGG").css("display","block");
           }
           if( pldVar == 1){
               jQuery("#PDL").css("display","block");
           }
           $("#reportOpt").change(function () {
               $(this).find("option:selected").each(function(){
                   if($(this).attr("value")=="PDL"){
                       $("#AGG").hide();
                       $("#PDL").show();


                   }
                   if($(this).attr("value")=="AGG") {
                       $("#PDL").hide();
                       $("#AGG").show();


                   }});
           }).change();*/




        //this is function to convert and download it to csv file
        function exportTableToCSV($table, filename) {

            var $rows = $table.find('tr:has(td),tr:has(th)'),

                // Temporary delimiter characters unlikely to be typed by keyboard
                // This is to avoid accidentally splitting the actual contents
                tmpColDelim = String.fromCharCode(11), // vertical tab character
                tmpRowDelim = String.fromCharCode(0), // null character

                // actual delimiter characters for CSV format
                colDelim = '","',
                rowDelim = '"\r\n"',

                // Grab text from table into CSV formatted string
                csv = '"' + $rows.map(function (i, row) {
                    var $row = $(row), $cols = $row.find('td,th');

                    return $cols.map(function (j, col) {
                        var $col = $(col), text = $col.text();

                        return text.replace(/"/g, '""'); // escape double quotes

                    }).get().join(tmpColDelim);

                }).get().join(tmpRowDelim)
                    .split(tmpRowDelim).join(rowDelim)
                    .split(tmpColDelim).join(colDelim) + '"',

                // Data URI
                csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

            // console.log(csv);

            if (window.navigator.msSaveBlob) { // IE 10+
                //alert('IE' + csv);
                window.navigator.msSaveOrOpenBlob(new Blob([csv], {type: "text/plain;charset=utf-8;"}), "csvname.csv")
            }
            else {
                $(this).attr({ 'download': filename, 'href': csvData, 'target': '_blank' });
            }
        }

        // This must be a hyperlink
        $(".export").on('click', function(event) {
            // CSV
            var args = [$('#dvData>table'), 'export.csv'];

            exportTableToCSV.apply(this, args);

            // If CSV, don't do event.preventDefault() or return false
            // We actually need this to be a typical hyperlink
        });
    });
</script>



