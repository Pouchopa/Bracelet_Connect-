//Récupération des dates à travers le fichier dates.php

     function showDates() {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp1 = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp1.onreadystatechange = function() {
            if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200) {
                document.getElementById("selectHint").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp1.open("GET","dates.php",true);
        xmlhttp1.send();
    }
