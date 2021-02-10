<?php
    if(isset( $_POST['data']))
        $elements = $_POST['data'];
    else
        $elements = null;
?>
       
<?php
    if($elements != null){
        foreach($elements as $element){
?> 
            <div class="<?php echo $element['class']; ?>" id="<?php echo $element['id']; ?>" onclick="loadSection('<?php echo $element['name']; ?>')"><?php echo $element['label']; ?></div>
<?php
        }
    }
?>