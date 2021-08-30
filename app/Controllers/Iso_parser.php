<?php

namespace App\Controllers;

class Iso_parser extends BaseController{   

    public function check_value($bit_length, $max_bit_length){
        if($bit_length < $max_bit_length){
            return $bit_length;
        }else{
            return $max_bit_length;
        }
    }

	public function Iso_parse($data, $chip){
        // iso 8583 DE // 
        $DATA_ELEMENT = array (
            2 => array('an', 19, 1, "2. Primary Account Number"),
            3 => array('n', 6, 0, "3. Processing Code"),
            4 => array('n', 12, 0, "4. Amount"),
            5 => array('n', 12, 0),
            6 => array('n', 12, 0),
            7 => array('an', 10, 0, "7. Date and Time"),
            8 => array('n', 8, 0),
            9 => array('n', 8, 0),
            10 => array('n', 8, 0),
            11 => array('n', 6, 0, "11. System Trace Number"),
            12 => array('n', 6, 0, "12. Time, Local Trans"),
            13 => array('n', 4, 0, "13. Date, Local Trans"),
            14 => array('n', 4, 0),
            15 => array('n', 4, 0, "Date Settlement"),
            16 => array('n', 4, 0),
            17 => array('n', 4, 0, "Date Capture"),
            18 => array('n', 4, 0, "Merchant Type"),
            19 => array('n', 3, 0),
            20 => array('n', 3, 0),
            21 => array('n', 3, 0),
            22 => array('n', 3, 0, "POS Entry Mode"),
            23 => array('n', 3, 0),
            24 => array('n', 3, 0),
            25 => array('n', 2, 0),
            26 => array('n', 2, 0),
            27 => array('n', 1, 0),
            28 => array('n', 9, 0, 'Transaction Fee'),
            29 => array('an', 9, 0),
            30 => array('n', 8, 0),
            31 => array('an', 9, 0),
            32 => array('n', 11, 1, "Acquiring Institution"),
            33 => array('n', 11, 1, "Forwarding Institution"),
            34 => array('an', 28, 1),
            35 => array('z', 37, 1),
            36 => array('n', 104, 1),
            37 => array('an', 12, 0, "Retrieval Reference No"),
            38 => array('an', 6, 0, "Authorisation Number"),
            39 => array('an', 2, 0, "Response Code"),
            40 => array('an', 3, 0),
            41 => array('ans', 16, 0, "Terminal ID"),
            42 => array('ans', 15, 0, "Card Accept ID"),
            43 => array('ans', 40, 0, "Card Accept Name"),
            44 => array('an', 25, 1),
            45 => array('an', 76, 1),
            46 => array('an', 999, 1),
            47 => array('an', 999, 1),
            48 => array('ans', 999, 1, "Additional Data Private."),
            49 => array('an', 3, 0, "Currency Code"),
            50 => array('an', 3, 0),
            51 => array('a', 3, 0),
            52 => array('an', 16, 0),
            53 => array('an', 18, 0),
            54 => array('an', 120, 0),
            55 => array('ans', 765, 1, "Integrated Circuit Card Data"),
            56 => array('ans', 999, 1),
            57 => array('ans', 999, 1, "Topup Data"),
            58 => array('ans', 999, 1),
            59 => array('ans', 99, 1),
            60 => array('ans', 60, 1),
            61 => array('ans', 99, 1),
            62 => array('ans', 999, 1),
            63 => array('ans', 999, 1),
            64 => array('b', 16, 0),
            65 => array('b', 16, 0),
            66 => array('n', 1, 0),
            67 => array('n', 2, 0),
            68 => array('n', 3, 0),
            69 => array('n', 3, 0),
            70 => array('n', 3, 0),
            71 => array('n', 4, 0),
            72 => array('ans', 999, 1),
            73 => array('n', 6, 0),
            74 => array('n', 10, 0),
            75 => array('n', 10, 0),
            76 => array('n', 10, 0),
            77 => array('n', 10, 0),
            78 => array('n', 10, 0),
            79 => array('n', 10, 0),
            80 => array('n', 10, 0),
            81 => array('n', 10, 0),
            82 => array('n', 12, 0),
            83 => array('n', 12, 0),
            84 => array('n', 12, 0),
            85 => array('n', 12, 0),
            86 => array('n', 15, 0),
            87 => array('an', 16, 0),
            88 => array('n', 16, 0),
            89 => array('n', 16, 0),
            90 => array('an', 42, 0, "Original Data Elements"),
            91 => array('an', 1, 0),
            92 => array('n', 2, 0),
            93 => array('n', 5, 0),
            94 => array('an', 7, 0),
            95 => array('an', 42, 0),
            96 => array('an', 8, 0),
            97 => array('an', 17, 0),
            98 => array('ans', 25, 0),
            99 => array('n', 11, 1),
            100 => array('n', 8, 1, "Receiving ID"),
            101 => array('ans', 17, 0),
            102 => array('ans', 28, 1, "Account 1"),
            103 => array('ans', 28, 1),
            104 => array('an', 99, 1),
            105 => array('ans', 999, 1),
            106 => array('ans', 999, 1),
            107 => array('ans', 999, 1),
            108 => array('ans', 999, 1),
            109 => array('ans', 999, 1),
            110 => array('ans', 999, 1),
            111 => array('ans', 999, 1),
            112 => array('ans', 999, 1),
            113 => array('n', 11, 1),
            114 => array('ans', 999, 1),
            115 => array('ans', 999, 1),
            116 => array('ans', 999, 1),
            117 => array('ans', 999, 1),
            118 => array('ans', 999, 1),
            119 => array('ans', 999, 1),
            120 => array('ans', 999, 1),
            121 => array('ans', 999, 1),
            122 => array('ans', 999, 1),
            123 => array('ans', 999, 1, "Delivery Channel ID"),
            124 => array('ans', 255, 1),
            125 => array('ans', 50, 1),
            126 => array('ans', 6, 1),
            127 => array('ans', 999, 1),
            128 => array('b', 16, 0)
        );

        // instantiate iso msg //
		$iso_msg = $data;
        
        // CHIP CARD // 
        if($chip){
            for($i=0;$i<count($iso_msg);$i++){
                $iso_msg_array = explode("\n", $iso_msg[$i]);
                
                $result[$i] = array();

                for($j = 0; $j<count($iso_msg_array);$j++){
                    
               
                    // special case bit 48  //
                    if(substr($iso_msg_array[$j], 0,3) == "48."){
                        $iso_msg_value = explode(".·", $iso_msg_array[$j]);
                    }else{
                        $iso_msg_value = explode(". ", $iso_msg_array[$j]);
                    }
                

                    $iso_key = explode("..",$iso_msg_value[0]);
                    $parsed_iso = [
                        $iso_key[0] => $iso_msg_value[1]
                    ];

                    // // // // print_r($parsed_iso);
                    $result[$i] = array_merge($result[$i], $parsed_iso);
                    
                }
            }
           
        }// NON CHIP CARD //
        else{
            for($i=0; $i<count($iso_msg); $i++){
            
                // counter iso msg bit //
                $msg_readed = 0;
    
                // Set empty array to hold bit on or true value // 
                $bit_is_on = array();
    
                // Find bitmap length // 
                $first_digit_bitmap = base_convert(substr($iso_msg[$i],4,1),16,2);
                if(substr($first_digit_bitmap,0,1) == 0){
                    $bit_map_length = 16;
                }elseif(substr($first_digit_bitmap,0,1) == 1){
                    $bit_map_length = 32;
                }
    
                // bitmap value // 
                $bitmap =substr($iso_msg[$i],4,$bit_map_length);
    
                // bitmap to binary // 
                $bitmap_to_binary =  gmp_strval(gmp_init($bitmap, 16), 2);  
                
                //split binary bitmap to array //
                $bitmap_binary_array = str_split($bitmap_to_binary);
                
                // Loopp to find true or on bit //
                for($j=0; $j<count($bitmap_binary_array);$j++){
                    if($bitmap_binary_array[$j] == "1"){
                        array_push($bit_is_on,$j+1);
                    }
                }
    
                // parsed message //
                $result[$i] = [
                    "Message Type" => substr($iso_msg[$i],0,4), 
                    "Bit Map" => $bitmap,
                ];
    
                // +4 byte from message type //
                $msg_readed = $bit_map_length + 4;
    
                // Loop each bit map to DE //
                for($k=1; $k<count($bit_is_on);$k++){
                    $key_index = $bit_is_on[$k]; // (1) bit value //
    
                    $max_bit_length = $DATA_ELEMENT[$key_index][1]; // Max bit length, for certain DE //
    
                    // Conf DE //
                    // PAN //
                    if($key_index == 2){
                        $bit_length = (int)substr($iso_msg[$i],$msg_readed,2); 
                        $msg_readed += 2; // +2 used for DE Lengths, example (08) , +3 example (031) // 
                        $bit_length = $this->check_value($bit_length, $max_bit_length); // check how many bits we need to take certain DE //
                    }// Acquiring Institution //
                    else if($key_index == 32){
                        $bit_length = substr($iso_msg[$i],$msg_readed,2);
                        $msg_readed += 2; 
                        $bit_length = $this->check_value($bit_length, $max_bit_length);
                    }// Forwarding Institution
                    else if($key_index == 33){
                        $bit_length = (int)substr($iso_msg[$i],$msg_readed,2);
                        $msg_readed += 2; 
                        $bit_length = $this->check_value($bit_length, $max_bit_length);
                    }// Additional Data // 
                    else if($key_index == 48){
                        $bit_length = (int)substr($iso_msg[$i],$msg_readed,3);
                        $msg_readed += 3; 
                        $bit_length = $this->check_value($bit_length, $max_bit_length);
    
                        $bit_48_msg = substr($iso_msg[$i],$msg_readed,$bit_length);
                        
                        $PI_data = substr($bit_48_msg, strpos($bit_48_msg,"PI") + 4 , 4);
                        $CD_data = substr($bit_48_msg, strpos($bit_48_msg,"CD") + 4 , (int)substr($bit_48_msg,strpos($bit_48_msg,"CD") + 2));
                        $MC_data = substr($bit_48_msg, strpos($bit_48_msg,"MC") + 4 , (int)substr($bit_48_msg,strpos($bit_48_msg,"MC") + 2));
    
                        // inserting bit 48 detail data // 
                        $parsed_iso = [
                            "DE 48 Length" => "(". str_pad($bit_length, 3, "0", STR_PAD_LEFT) . ")",
                            "48. PI Product Indicator" => $PI_data,
                            "48. CD Customer Name" => $CD_data,
                            "48. MC Merchant Code" => $MC_data
                        ];
    
                    }// Topup Data // 
                    else if($key_index == 57){
                        $bit_length = (int)substr($iso_msg[$i],$msg_readed,3);
                        $msg_readed += 3;
                        $bit_length = $this->check_value($bit_length, $max_bit_length);
                    }// Receiving ID //
                    else if($key_index == 100){
                        $bit_length = (int)substr($iso_msg[$i],$msg_readed,2);
                        $msg_readed += 2;
                        $bit_length = $this->check_value($bit_length, $max_bit_length);
                    }// Account 1 //
                    else if($key_index == 102){
                        $bit_length = (int)substr($iso_msg[$i],$msg_readed,2);
                        $msg_readed += 2;
                        $bit_length = $this->check_value($bit_length, $max_bit_length);
                    }// Delivery Channel ID //
                    else if($key_index == 123){
                        $bit_length = (int)substr($iso_msg[$i],$msg_readed,3);
                        $msg_readed += 3;
                        $bit_length = $this->check_value($bit_length, $max_bit_length);
                    }
                    // Normal Bit //
                    else{
                        $bit_length = $max_bit_length;
                    }
    
                    // inserting data // 
                    if($key_index != 48 && $key_index != 55){
                        $parsed_iso = [
                            $DATA_ELEMENT[$key_index][3] => substr($iso_msg[$i],$msg_readed,$bit_length),
                        ];
                    }
                   
    
                
                    // updatae msg readed bit // 
                    $msg_readed += $bit_length;
    
                    // merge with the result before //
                    $result[$i] = array_merge($result[$i], $parsed_iso);
                }
            }
        }        
 
        print_r($result);
        // return $result;
        
	}
}
