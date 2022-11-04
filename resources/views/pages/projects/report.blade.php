<?php
// Include config file
require_once "../../env.php";

$id = $_POST['id'];

$query = "
SELECT
projects.cd_items, projects.id, projects.photo, users.fullname, users.username, projects.pname, projects.photo, projects.deskphotos, projects.gs_names, projects.gs_description, projects.cd_items, projects.cd_values_sum, projects.cd_values_usd_sum, projects.isApproved, projects.made_date
FROM projects
INNER JOIN users ON projects.UID=users.ID
WHERE projects.id=$id;
";

   $result = mysqli_query($link, $query);

   if ($row = mysqli_fetch_array($result)) {

    //load mpdf pdf creator repo
    require_once __DIR__ . "/../../vendor/autoload.php";

    // declare mpdf variable as Mpdf
    $mpdf = new \Mpdf\Mpdf();

    // declare and init data
    $data = '<table><tbody><tr><td><img src="' . LOGO . '" width="200px" /></td><td style="direction:rtl"><img style="float:right" src="./ce.png" width="100px" /></td></tr>';

    $data .= '<tr><td colspan="2"><strong>Project Name </strong>' . $row['pname'] .'<strong> by Eng. '. ($row['fullname'] === null || $row['fullname'] === '' ? $row['username'] : $row['fullname']) .'</strong></td></tr>';
    $data .= '<tr><td colspan="2"><img width="700px" src="/upload/' . $row['photo'] . '"/></td></tr>';



    $dsp = json_decode($row['deskphotos'],true);

    foreach($dsp as $key => $val){
        if($key === 0 || $key % 2 === 0){
            $data .= '<tr><td>';
            $data .= '<img width="315px" style="padding:10px" src="/upload/' . $val . '"/>';
            $data .= '</td>';
        }else if( $key % 2 !== 0){
            $data .= '<td>';
            $data .= '<img width="315px" style="padding:10px" src="/upload/' . $val . '"/>';
            $data .= '</td></tr>';
        }
    }
    if(!str_ends_with($data, '</tr>')){
        $data .= '</tr>';
    }

    $data .= '<tr><td colspan="2">';
    // general specifications Table
    $gs = json_decode($row['gs_names'],true);
    $data .= '<strong>General Specifications:</strong><br />';
    $data .= '<table>';
    $data .= '<thead>
            <tr>
                <th>
                    Item
                </th>
                <th>
                    Value
                </th>
            <tr>
        <thead><tbody>';
    foreach($gs as $key => $val){
        $data .= "<tr>";
        foreach($gs["$key"] as $key1 => $val1){
            $data .=  "<td>" . $val1 . "</td>";
        }
        $data .= "</tr>";
    }
    $data .= '<tr><td colspan="2"><strong>Description </strong><br />' . $row['gs_description'] .'</td></tr></tbody></table>';
    $data .= '</td></tr>';


    $data .= '<strong>Cost Details:</strong><br />';
    $data .= '<table>';
    $data .= '<thead>
        <tr>
            <th>
                Item
            </th>
            <th>
                expected price
            </th>
            <th>
                actual price
            </th>
            <th>
                USD?
            </th>
            <th>
                KDV
            </th>
            <th>
                Image
            </th>
        <tr>
    <thead><tbody>';
    $cd = json_decode($row['cd_items'],true);
    foreach($cd as $key => $val){
        $data .= "<tr>";
        foreach($cd["$key"] as $key1 => $val1){
            if($key1 == 'cdimg' && $val1 != ''){
                $data .=  '<td><img width="80px" style="padding:10px" src="/upload/' . $val1 . '"/>  </td>';
            }else{
                $data .=  "<td>" . $val1 . "</td>";
            }
        }
        $data .= "</tr>";
    }
    $data .= '</tbody></table><br />';

    $data .= '<tr><td colspan="2"><table><tr><td><strong>Cost TRY </strong>' . $row['cd_values_sum'] .'</td>';
    $data .= '<td><strong>Cost USD </strong>' . $row['cd_values_usd_sum'] .'</td>';
    $data .= '<td><strong>Status </strong>' . ($row['isApproved'] === '0' ? '<span class="new">New</span>' : ($row['isApproved'] === '1' ? '<span class="success">Approaved</span>' : ($row['isApproved'] === '2' ? '<span class="viewed">Viewed</span>' : '<span class="fail">Declined</span>'))) .'</td>';
    $data .= '<td><strong>Requested at </strong>' . $row['made_date']  .'</td></tr></table></td></tr>';

    $data .= '</tbody></table>';
    //{"cdlbl" : "plastik","cdepr" : "4","cdapr" : "4","cdimg" : ""}
    $mpdf->defaultheaderfontsize=10;
    $mpdf->defaultheaderfontstyle='B';
    $mpdf->defaultheaderline=0;
    $mpdf->defaultfooterfontsize=10;
    $mpdf->defaultfooterfontstyle='BI';
    $mpdf->defaultfooterline=0;

    $mpdf->SetFooter('{PAGENO}');




   }

?>
