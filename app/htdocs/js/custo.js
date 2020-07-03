function saveComment(callBack) {
    var input_val = getInputValue();
    if(input_val.length <= 0) {
        return;
    }
    var xhttp;
    var php_save_url = "save_curr_remarq.php?q="
    xhttp=new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        callBack(this);
      }
    };
    xhttp.open("GET", php_save_url+encodeURIComponent(input_val), true);
    xhttp.send();
}

function getInputValue() {
    var input_value;
    input_value = document.getElementById("input-text-value").value;
    return input_value;
}

function getCurrentComments() {
    var comments_list;
    var php_show_url = "show_curr_remarq.php"
    comments_list=new XMLHttpRequest();
    comments_list.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("icomments").innerHTML = this.responseText;
        }
    };
    comments_list.open("GET", php_show_url, true);
    comments_list.send();
}

// Reinjecter le resultat dans le DOM
function callBack(xttp_response) {
    //Si erreur 
    if(xttp_response.length > 0) {
        document.getElementById("icomments").innerHTML = xhttp_response.responseText;
    }
    else {
        //On demande la liste à jour des commentaires
        getCurrentComments();
    }
}

/*
On ne charge plus Jquery.min -> gain moyen de 170ms sur chaque appel :)
$( ".button-save" ).click(function(){
    $.ajax({
        url: "save_curr_remarq.php",
        data: {"input-texte-value": $(".input-text-value").html()},
        cache: false,
        dataType: "json",
        error: function(request, error) {
            alert("Erreur : "+request.responseText);
        },
        success: function(data) {
            alert(data.commentsArray);
            $( "icomments" ).html(data.commentsArray);
        }
    });
});
*/