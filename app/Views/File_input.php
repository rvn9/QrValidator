<?= $this->extend('include/template'); ?>


<?= $this->section('content'); ?>

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <main class="px-3">
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
        </main>
    </div>

    

    <script>

       

        $(document).ready(function(){

            const mapping_file = document.getElementsByName("mapping_file")[0]; 
            const excel_file = document.getElementsByName("output_file")[0];
 
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
            })

            $("#submit_data").click(function(){

                if(mapping_file.files[0] == null || excel_file.files[0] == null){
                    $("#alert").show();
                }else{
                    
                    upload_excel(mapping_file.files[0]);
            
                    // // disable button
                    // $(this).prop("disabled", true);
                    // // add spinner to button
                    // $(this).html(
                    //     ` <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...`
                    // );
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
                    console.log(response)
                    // var test_case = response["test_case"]
                    // for(let index = 0; index < response["test_case"].length; index++){
                    //     $('#accordion').append(
                    //         '<div class="card">'+
                    //             '<div class="card-header" id="heading'+ index +'">'+
                    //                 '<h5 class="mb-0">'+
                    //                     '<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse'+ index +'"'+
                    //                             ' aria-expanded="false" aria-controls="collapse'+ index +'">'+
                    //                         response["test_case"][index]['Transaction Type']+
                    //                     '</button>'+
                    //                 '</h5>'+
                    //             '</div>'+

                    //             '<div id="collapse'+ index +'" class="collapse" aria-labelledby="heading'+ index +'" data-parent="#discogAccordion">'+
                    //                 '<div class="card-body">'+
                    //                     'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf'+
                    //                 '</div>'+
                    //             '</div>'+
                    //         '</div>'
                    //     );
                    // }
                });
            }
            
        });

    
    </script>

<!-- main content area end -->
<?= $this->endSection(); ?>