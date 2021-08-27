<?php

namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class File_input_controller extends BaseController{

    
	public function index(){
        $parser = new \App\Controllers\Iso_parser();
        $chip = true;

        if ($_FILES['output_file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['output_file']['tmp_name'])) { 
            $output_file = file_get_contents($_FILES['output_file']['tmp_name']); 
            $isomsg = preg_grep("/0(.*)123212367744(.*)/", explode("\n", $output_file));


            if($chip) {
                echo "kartu chip boi";
            }else {
                for($i = 0; $i<count($isomsg); $i++){
                    // NORMAL TRANSACTION // 
                    if(count($isomsg) == 2){
                        $data = [
                            0 => $isomsg[array_keys($isomsg)[0]],
                            1 => $isomsg[array_keys($isomsg)[1]]
                        ];
                    }// REVERSAL TRANSACTION // 
                    elseif(count($isomsg) == 4){
                        $data = [
                            0 => $isomsg[array_keys($isomsg)[0]],
                            1 => $isomsg[array_keys($isomsg)[1]],
                            2 => $isomsg[array_keys($isomsg)[2]],
                            3 => $isomsg[array_keys($isomsg)[3]]
                        ];
                    }
                }
            }
         
            
            $parser->Iso_parse($data);
            // print_r($parsed_msg); 
            
        }
        // if($_FILES['mapping_file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['mapping_file']['tmp_name'])){
        //     $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        //     $spreadsheet = $reader->load($_FILES['mapping_file']['tmp_name']);
        //     $sheetData = $spreadsheet->getActiveSheet()->toArray();
            
        //     echo(count($sheetData));

        //     // if(!empty($sheetData)){
        //     //     for($i=4; $i<count($sheetData-3);i++){
        //     //         for($j=0; $j<)
        //     //     }
        //     // }

        //     // echo $sheetData[4][0];
        //     // if (!empty($sheetData)) {
        //     //     for ($i=4; $i<count($sheetData); $i++) {
                 
        //     //         $data = [
        //     //             'TestCase' => $sheetData[$i][0]
        //     //         ];
        //     //     }
        //     // }

        //     print_r($data);
        // }
    }
}
