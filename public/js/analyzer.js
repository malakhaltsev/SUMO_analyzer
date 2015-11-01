/**
 * Created by malakhaltsevpetr on 01/11/15.
 */

var inputCount = 1; // counter for input file blocks
var template = ''; // template of input file block

$(document).ready(function(){

    // reading template from view
    template = $('#input_template').html();

    addInput();
    $("#button_add").click(function(){addInput(); return false;});

});

// Uses template to insert new data file input block
function addInput(){
    $("#input_container").append(template.replace(/%id%/g,inputCount));
    inputCount++;
}