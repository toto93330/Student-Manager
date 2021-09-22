let host = window.location.host;
let protocol = window.location.protocol;
let pathname = window.location.pathname
let index = 1;
let button = document.getElementById('loadmorebutton');
let content = document.getElementById('loadmorecontent');

this.window.onload = init();

function init() {

    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            let data = this.response;
            console.log(data);
            if (data.length <= 8 || w >= data.length) {
                button.style.display = "none";
                return;
            }

        }
    }

    let url = "/appointment/ajax/" + index;
    let params = index;
    xhr.open("GET", url);
    xhr.responseType = "json";
    xhr.send(params);
}


function loadMoreAppointments($id) {

    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            let data = this.response;

            if (data.length <= 8 || w >= data.length) {
                button.style.display = "none";
                return;
            }else{

                button.onclick = "loadMoreAppointments("+ ($id + 1) +")";

            }

            for (var i = 8; i < data.length; i++) {

               content.innerHTML += '<tr>' +
                    '<td>' +
                    '<div class="table-data__info">' +
                    '<p>{{appointments.title}}</p>' +
                    '</div>' +
                    '</td>' +
                    '<td>' +
                    '<p>{{appointments.content}}</p>' +
                    '</td>' +
                    '<td>' +
                    '<p>{{appointments.start|date("m/d/Y H:i:s", "Europe/Paris")}}</p>' +
                    '</td>' +
                    '<td>' +
                    '<p>{{appointments.end|date("m/d/Y  H:i:s", "Europe/Paris")}}</p>' +
                    '</td>' +
                    '<td>' +
                    '{% if appointments.allDay == true %}' +
                    '<p>yes</p>' +
                    '{% else %}' +
                    '<p>no</p>' +
                    '{% endif %}' +

                    '</td>' +
                    '<td>' +
                    '<p style="color:{{appointments.backgroundColor}}; padding:3px; text-align:center">{{appointments.backgroundColor}}</p>' +
                    '</td>' +
                    '<td>' +
                    '<p style="color:{{appointments.borderColor}}; padding:3px; text-align:center">{{appointments.borderColor}}</p>' +
                    '</td>' +
                    '<td>' +
                    '<p style="color:{{appointments.textColor}}; padding:3px; text-align:center">{{appointments.textColor}}</p>' +
                    '</td>' +
                    '<td>' +
                    '<p>{{appointments.student.firstname}}' +
                    '{{appointments.student.lastname}}</p>' +
                    '</td>' +
                    '<td>' +
                    '<div class="table-data-feature">' +
                    '<a href="/sendmail/{{appointments.student.email}}">' +
                    '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Send Mail">' +
                    '<i class="zmdi zmdi-mail-send"></i>' +
                    '</button>' +
                    '</a>' +
                    '<a href="/appointment/edit/{{appointments.id}}">' +
                    '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Student">' +
                    '<i class="zmdi zmdi-edit"></i>' +
                    '</button>'
                '</a>'
                '<a href="/appointment/remove/{{appointments.id}}">' +
                '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">' +
                '<i class="zmdi zmdi-delete"></i>' +
                '</button>'
                '</a>' +
                '</td>' +
                +'</td>' +
                '</tr>';

            }
        }

        let url = "/appointment/ajax/" + this.index;

        xhr.open("GET", url);
        xhr.responseType = "json";
        xhr.send();

    }

}