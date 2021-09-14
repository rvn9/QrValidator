<?php

namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class File_input_controller extends BaseController{

    
	public function index(){
        
        
        if(isset($_FILES['mapping_file'])){
            // import excel reader //
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($_FILES['mapping_file']['tmp_name']); // get excel file //
            $sheetCount = $spreadsheet->getSheetCount(); // get worksheet count //
            $sheetName = $spreadsheet->getSheetNames(); // get worksheet name //
            
            //create array //
            $allTestCase = array();

            // loop for each worksheet //
            for($k=0; $k<$sheetCount;$k++){
                // get all merged cells //
                $DuplicatedSheetData = array_keys($spreadsheet->getSheet($k)->getMergeCells());
                
                // loop to fill empty value from merged cells //
                for($i=0; $i<count($DuplicatedSheetData);$i++){
                    // explode merge cells range //
                    $CellIndex = explode(":", $DuplicatedSheetData[$i]);

                    // get main cell with value, ex N25:N27 , the value only stored in N25 //
                    $CellValue = $spreadsheet->getSheet($k)->getCell($CellIndex[0])->getValue();

                    // starting index //
                    $StartIndex = (int) substr($CellIndex[0],1,2);

                    // ending index // 
                    $EndIndex = (int) substr($CellIndex[1],1,2);
                    
                    // column name example "A" ,"B" //
                    $ColumnName = substr($CellIndex[0],0,1);      
                    
                    // loop to copy the value from main cell, to other cell //
                    for($j = $StartIndex;$j <= $EndIndex; $j++){
                        $spreadsheet->getSheet($k)->setCellValue($ColumnName.$j , $CellValue);
                    }
                }
                
                // map to array and remove empty value //
                $sheetData = array_values(array_map('array_filter', $spreadsheet->getSheet($k)->toArray()));
                    
                $test_case_index = 0;
                // map sheet data into test case // 
                for($j=4;$j<count($sheetData);$j++){
                    if($sheetData[$j] == null){
                        break;
                    }else{
                        $test_case[$test_case_index] = array();
                        // $type = explode(" - ", $sheetData[$j][2]); // explode chip - terminal value //


                        $temp_data = [
                            "Transaction Type" => $sheetData[$j][0],
                            "Condition" => str_replace(array("\n", "\r"), ' ', $sheetData[$j][2]),
                            "Action" => $sheetData[$j][3],
                            "Response Code" =>  substr($sheetData[$j][4],2),
                            "Amount" => str_replace(array("\n", "\r"), ' ', $sheetData[$j][5]),

                        ]; 

                        $test_case[$test_case_index] = array_merge($test_case[$test_case_index], $temp_data);
                        $test_case_index++;
                    }
                }

                if($sheetName[$k] == "Bank as Acquirer"){
                    $type = "acq";
                }else if($sheetName[$k] == "Bank as Issuer"){
                    $type = "iss";
                }

                $data = [
                    $type => $test_case,
                ];

                $allTestCase = array_merge($allTestCase,$data);
            }
            echo json_encode($allTestCase);
        }else {
            
        }
        
       
      
      
        // // read txt file from view //
        // if ($_FILES['output_file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['output_file']['tmp_name'])) { 
        //     //read txt //
        //     $output_file = file_get_contents($_FILES['output_file']['tmp_name']); 
            
        //     // // loop each test case //
        //     // for($i=0; $i<count($test_case);$i++){
        //     //     if($test_case[$i]["Card Type"] == "Chip"){
        //     //         $isomsg = preg_match_all('/Message Type.*?123212367744.*?00000777410000077741/s', $output_file, $isomsg); // Message Type + RNN + S-123 //
        //     //         $chip = true;  
        //     //     }else{
        //     //         $isomsg = preg_grep("/0(.*)121810490111(.*)/", explode("\n", $output_file)); // 0+RNN//
        //     //         $chip = false;
        //     //     }

        //     //     // NORMAL TRANSACTION // 
        //     //     if(count($isomsg) == 2){
        //     //         $data = [
        //     //             0 => $isomsg[array_keys($isomsg)[0]],
        //     //             1 => $isomsg[array_keys($isomsg)[1]]
        //     //         ];
        //     //     }// REVERSAL TRANSACTION // 
        //     //     elseif(count($isomsg) == 4){
        //     //         $data = [
        //     //             0 => $isomsg[array_keys($isomsg)[0]],
        //     //             1 => $isomsg[array_keys($isomsg)[1]],
        //     //             2 => $isomsg[array_keys($isomsg)[2]],
        //     //             3 => $isomsg[array_keys($isomsg)[3]]
        //     //         ];
        //     //     }
        //     //     // parse the iso //
        //     //     $parser->Iso_parse($data,$chip);

        //     // }
        // }

       
    }
}
