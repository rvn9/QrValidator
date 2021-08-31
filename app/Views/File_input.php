<?= $this->extend('include/template'); ?>

<?= $this->section('content'); ?>
    
    <form name="upload" method="post" action="<?= base_url('/file_input')?>" enctype="multipart/form-data" accept-charset="utf-8">
        <label for="myfile">Select a output file:</label>
        <input type="file" id="output_file" name="output_file">

        <br> <br>
            
        <!-- <label for="myfile">Select a excel file:</label>
        <input type="file" id="mapping_file" name="mapping_file"> -->

        <input type="submit">
    </form>
    

<!-- main content area end -->
<?= $this->endSection(); ?>