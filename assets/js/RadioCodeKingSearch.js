//RadioCodeKing Ford V & M Calculator
jQuery(document).ready(function($){
        var placeHolder = ['V690301','M605302','V123456','M123456'];
        var n=0;
        var loopLength=placeHolder.length;

        setInterval(function(){
           if(n<loopLength){
              var newPlaceholder = placeHolder[n];
              n++;
              $("#CodeSearchBox").attr('placeholder',newPlaceholder);
			} else {
              $("#CodeSearchBox").attr('placeholder',placeHolder[0]);
              n=0;
           }
        },2000);
    });


document.getElementById("CodeSearchBox").addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById("CalcCode").click();
    }
});

function checkthestatus () {

//loading results	
document.getElementById("content123").innerHTML = my_options.loadinghtm;	

CurrentSerial = document.getElementById("CodeSearchBox").value;

var data = {
action: 'rck_lookup_by_ser',
Serial: CurrentSerial
};

jQuery.post(my_options.ajaxurl, data, function(response) {
document.getElementById("content123").innerHTML = response;
});

}