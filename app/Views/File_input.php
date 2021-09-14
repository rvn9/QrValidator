<?= $this->extend('include/template'); ?>


<?= $this->section('content'); ?>

    <div class="text-center cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <div class="px-3">
            <div id="alert" style="display:none;" >
                <div style="padding:5px;">
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" id="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Warning!</strong> File Output dan / atau Mapping tidak boleh kosong.
                    </div>
                </div>
            </div>
            
            
            <h1>QR Message Validator</h1>
            <br>
            <div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="output_file" id="output_file" onchange="this.nextElementSibling.innerText = this.files[0].name" accept="text/plain"/>
                    <label id="label_output" class="custom-file-label">Masukan File Output</label>
                </div>
                <br>  <br>
                <div class="custom-file">
                    <input type="file" class="custom-file-input"  name="mapping_file" id="mapping_file" onchange="this.nextElementSibling.innerText = this.files[0].name"  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                    <label id="label_excel" class="custom-file-label">Masukan File Excel</label>
                </div>
            </div>

        

            <div class="row mt-5 justify-content-center">
                <button class="btn btn-primary col-4" id="submit_data" type="button">
                    Submit
                </button>


                <button class="btn btn-danger col-4 ml-5" id="reset" type="button">
                    Reset
                </button>
            </div>


        </div>

     
      
      
    </div>
    <div class="container-fluid" id="accordion" style="display:none;">
        <div class="row justify-content-center">
            <div class="container_accordion rounded col-5">
                <p class="font-weight-bold">Bank As Acquirer</p>
                <div class="accordion" id="accordion_sheet_acq">
                </div>
            </div>

            <div class="container_accordion rounded col-5">
                <p class="font-weight-bold">Bank As Issuer</p>
                <div class="accordion" id="accordion_sheet_iss">
                </div>
            </div>
          
        </div>
    </div>
   


  

    <script>

       

        $(document).ready(function(){
            
            const mapping_file = document.getElementsByName("mapping_file")[0];  // get mapping file //
            const output_file = document.getElementsByName("output_file")[0]; // get output file //
 
            // close alert button //
            $( "#close" ).click(function() {
                $( "#alert" ).hide();
            });

            // reset input button //
            $("#reset").click(function(){                
                $('#output_file').val("")
                $('#mapping_file').val("")
                $('#label_output').text("Masukan File Output")
                $('#label_excel').text("Masukan File Excel")
                $("#submit_data").prop("disabled", false);
                $("#accordion").css("display", "none");
                $(".accordion-item").remove()
            })

            // submit button //
            $("#submit_data").click(function(){

                // file is empty pop up alert //
                if(mapping_file.files[0] == null || output_file.files[0] == null){
                    $("#alert").show();
                }else{
                    
                    // call upload excel func //
                    upload_excel(mapping_file.files[0]);
                    
                    // disable button
                    $('#submit_data').prop("disabled", true);
                }   
            });


            const upload_excel = (file) => {
                const form_data = new FormData();
                form_data.append('mapping_file', file);
                fetch("<?=base_url("/file_input") ?>", {
                    method:"POST",
                    body : form_data
                }).then(function(response){
                    return response.json();
                }).then(function(response){
                    
                    var test_case = Object.keys(response);

                    // test_case 0 == Bank as Acq //
                    // test_case 1 == Bank as Iss //
                    for(var i = 0; i< test_case.length;i++){
                        for(let index = 0; index < response[test_case[i]].length; index++){
                            var action = response[test_case[i]][index]['Action']
                            var response_code = response[test_case[i]][index]['Response Code']
                            var amount = response[test_case[i]][index]['Amount']
                            var condition = response[test_case[i]][index]['Condition']

                            $('#accordion_sheet_' + test_case[i]).append(
                                '<div class="accordion-item">'+
                                    '<h2 class="accordion-header" id="heading'+ index +'">'+
                                        '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_'+ test_case[i]+ index +'"'+
                                                ' aria-expanded="true" aria-controls="collapse'+ test_case[i] +index +'">'+
                                            response[test_case[i]][index]['Transaction Type']+
                                        '</button>'+
                                    '</h2>'+

                                    '<div id="collapse_'+test_case[i]+index +'" class="accordion-collapse collapse" aria-labelledby="heading'+ index +'" data-parent="#discogAccordion">'+
                                        '<div class="accordion-body">'+
                                            'Action: ' + action  +"</br>" +
                                            'Amount: ' + amount  +"</br>" +
                                            'Response Code: ' + response_code  +"</br>" +
                                            'Condition: ' + condition +"</br>" +
                                        '</div>'+
                                    '</div>'+
                                '</div>'
                            );

                            $("#accordion").css("display", "block");
                        }
                    }
                });
            }
            
        });

    
    </script>

<!-- main content area end -->
<?= $this->endSection(); ?>