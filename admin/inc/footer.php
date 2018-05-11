<?php if($page_name != 'login.php'){ ?>
    <footer>
        <div class="container-fluid admin-foo" style="padding-right: 30px;">
            Copyright &copy; by <a href="#"> Sultan Gillani</a>. All Rights Reserved From 2017-<?php echo date("Y"); ?>.
        </div>
    </footer>
<?php
}
?>
</div><!-- wrapper -->
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jq.js"></script>
<script src="../js/ang.js"></script>
<script>
    tinymce.init({
  selector: "textarea",
  height: 450,
  plugins: [
    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
  ],

  toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
  toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
  toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft",
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'],

  menubar: false,
  toolbar_items_size: 'small',

  style_formats: [{
    title: 'Bold text',
    inline: 'b'
  }, {
    title: 'Red text',
    inline: 'span',
    styles: {
      color: '#ff0000'
    }
  }, {
    title: 'Red header',
    block: 'h1',
    styles: {
      color: '#ff0000'
    }
  }, {
    title: 'Example 1',
    inline: 'span',
    classes: 'example1'
  }, {
    title: 'Example 2',
    inline: 'span',
    classes: 'example2'
  }, {
    title: 'Table styles'
  }, {
    title: 'Table row 1',
    selector: 'tr',
    classes: 'tablerow1'
  }],

  templates: [{
    title: 'Test template 1',
    content: 'Test 1'
  }, {
    title: 'Test template 2',
    content: 'Test 2'
  }],
  
  <?php
    $media_query = "SELECT * FROM `media` ORDER BY id DESC";
    $media_run = mysqli_query($conn, $media_query);
    if(mysqli_num_rows($media_run) > 0){
        ?>
            image_list: [
        <?php
            while($media_row = mysqli_fetch_array($media_run)){
                $media_id = $media_row['id'];
                $media_name = $media_row['image'];
                ?>
                    {title: '<?php echo $media_name; ?>', value: 'img/<?php echo $media_name; ?>'},
                <?php
            }
        ?>        
            ],
        <?php
        
  }
  ?>
  init_instance_callback: function () {
    window.setTimeout(function() {
      $("#div").show();
     }, 1000);
  }
});
</script>
</body>
</html>