let select = document.getElementById("send_mail_mail_template");
let content = document.getElementsByClassName("cke_editable");

function singleSelectChangeValue(){

let index = select.value;
var xhr = new XMLHttpRequest();

xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        var data = this.response;
        let content = data[0].content;
        CKEDITOR.instances['send_mail_content'].setData(content);
    }
}

var url = "/sendmail/ajax/" + index;


xhr.open("GET", url);
xhr.responseType = "json";
xhr.send();
}