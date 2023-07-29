         
var timer;


function showUser(str) {
    
    
        clearTimeout(timer);
   timer=setTimeout(function validate(){ 
   
   

                                        
                                        
                                        
    
    str = str.replace(/\s/g, "");
    str = str.replace(/-/g, "");
    str = str.replace(/_/g, "");
    var element = document.getElementById("txtHint-box");
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";

        return;
    } else if (str.length < 7) {} else {
        document.getElementById("txtHint").innerHTML = "";
                $("#txtHint").addClass("txthint-loading");
 
        
           xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                
              
                document.getElementById("txtHint").innerHTML = this.responseText;
                 $("#txtHint").removeClass("txthint-loading");
  
            }
        };
 
        xmlhttp.open("GET", "php/codeid-geter.php?q=" + str, true);
      
        xmlhttp.send();
    
           
         

    }
},1500);

}

   

$(document).ready(function () {

    $("#txtHint").on("click", "div", function () {
        $("#txtHint div").removeClass("clickedcode");
        $(this).addClass("clickedcode");
        $("#codeid-hidden").val($(this).attr("codeid"));
        $("#codeid-box").val($(this).text());


    });

});
