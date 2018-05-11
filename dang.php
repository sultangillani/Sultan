<?php
//echo $abc = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url') ORDER BY `wp_term_taxonomy`.`count` DESC LIMIT 0,10";
include_once 'functions.php';
global $conn;
?>
<html>
<head>
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){
            var arrA = [];
            var arrB = [];
            var arrC = [];

            $('.sort1').each(function(){
                $(this).click(function(){
                    if($(this).attr('name') == 'sort1') {
                        var ri = $(this).val();
                        var ind = arrA.indexOf(ri);
                        if ($(this).prop("checked")) {
                            
                            arrA.push(ri);
                            alert(arrA);
                        }else{
                            arrA.splice(ind,1);
                            alert(arrA);
                        }
                    }else if($(this).attr('name') == 'sort2') {
                        var ri = $(this).val();
                        var ind = arrB.indexOf(ri);
                        if ($(this).prop("checked")) {
                            
                            arrB.push(ri);
                            alert(arrB);
                        }else{
                            arrB.splice(ind,1);
                            alert(arrB);
                        }
                    }else if($(this).attr('name') == 'sort3') {
                        var ri = $(this).val();
                        var ind = arrC.indexOf(ri);
                        if ($(this).prop("checked")) {
                            
                            arrC.push(ri);
                            alert(arrC);
                        }else{
                            arrC.splice(ind,1);
                            alert(arrC);
                        }
                    }
                    
                });    
            });   
        });
    </script>
</head>
<body>

<?php
?>
<div id="results" style="width: 100%; height: 100px;"></div>
<input class='sort1' type='checkbox' value='A' name='sort1' />
<input class='sort1' type='checkbox' value='V' name='sort1' />
<input class='sort1' type='checkbox' value='C' name='sort1' />

<input class='sort1' type='checkbox' value='G' name='sort2' />
<input class='sort1' type='checkbox' value='T' name='sort2' />

<input class='sort1' type='checkbox' value='W' name='sort3' />
<input class='sort1' type='checkbox' value='W' name='sort3' />
<input class='sort1' type='checkbox' value='E' name='sort3' />
<input class='sort1' type='checkbox' value='B' name='sort3' />

</body>


</html>