var bleep = new Audio();
bleep.src = "assets/audio/mixkit-software-interface-back-2575.wav";

function loadContent(num) {
    bleep.play();
    var div1 = document.getElementById("div1");
    div1.innerHTML = "" + num;
}
//============function login=============================
function login(id_form, login_email, frm_notification) {
    $("#" + id_form).on("submit", function(event) {
        event.preventDefault();
        if ($("#" + login_email).val() == "") {
            $("#" + login_email).focus();
        } 
        // else if ($("#" + login_pass).val() == "") {
        //     $("#" + login_pass).focus();
        // } else {
            $.ajax({
                url: "service/sql/login-sql.php?login",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    var dataResult = JSON.parse(data);
                    if (dataResult.statusCode == 200) {
                        location.href = "?home";
                    } else if (dataResult.statusCode == 201) {
                        loadContent(1);
                        notification('' + frm_notification, 4000);
                        $("#login_password").val("");
                        $("#login_password").focus();
                    }else if (dataResult.statusCode == 202) {
                        loadContent(1);
                        notification('' + frm_notification, 4000);
                        $("#login_password").val("");
                        $("#login_password").focus();
                    }
                }
            })
        // }
    });
}


function format(format_class) {
    document.querySelectorAll('.'+format_class).forEach(inp => new Cleave(inp, {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    }));
}


//============function show password=====================

function myFunction(id) {
    var x = document.getElementById("" + id);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
