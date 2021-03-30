<?php
    $element_id = $_POST['element_id'];
    if(isset( $_POST['elements']))
        $elements = $_POST['elements'];
    else
        $elements = null;
    $element_placeholder = $_POST['element_placeholder'];
    $element_event_listener = $_POST['element_event_listener'];
?>

<div id="<?php echo $element_id; ?>" class="multiselect button-group">
    <button type="button" id="comboCheck" class="form-control dropdown-toggle" data-toggle="dropdown"><div><div class="dropdown-label"><?php echo $element_placeholder; ?></div><span class="caret"></span></div></button>

    <ul class="dropdown-menu">
     
<?php
    if($elements != null){
        foreach($elements as $element){
?> 

            <li><a id="<?php echo $element['id']; ?>" data-value="<?php echo $element['id']; ?>" name="<?php echo $element['id']; ?>" tabIndex="<?php echo $element['id']; ?>"><input type="checkbox"/><label for="">&nbsp; <?php echo $element['name']; ?></label></a></li>
<?php
        }
    }
?>
    </ul>
</div>

<script>
    data.current_crimes = {
        element_id: '<?php echo $element_id; ?>',
        data: []
    };

    $( "#<?php echo $element_id; ?> .dropdown-menu a" ).on( "click", function( event ) {
    
    var $target = $( event.currentTarget ),
        val = $target.attr( "data-value" ),
        $inp = $target.find( "input" ),
        idx;
    
    if ( ( idx = data.current_crimes.data.indexOf( val ) ) > -1 ) {
        data.current_crimes.data.splice( idx, 1 );
        setTimeout( function() { $inp.prop( "checked", false ) }, 0);
    } else {
        data.current_crimes.data.push( val );
        setTimeout( function() { $inp.prop( "checked", true ) }, 0);
    }
    
    $( event.target ).blur();
        
    console.log( data.current_crimes.data );
    return false;
    });

</Script>