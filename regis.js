$.holdReady(true);

var province = {};
$.getJSON('./province.json', (json) => {
    province = json;
    $.holdReady(false);
})

$(document).ready(() => {
    $.each(province, function (i, item) {
        $('#province').append($('<option>', { 
            value: item.id,
            text : item.name_th 
        }));
    });

    $("#age").on("change", () => {
        if($("#age").val() < 1)
            $("#age").val("1")
    })

    $("form").on("submit", (e) => {
        if( $("#user").val() == "" | $("#pass").val() == "" || $("#fname").val() == "" || $("#lname").val() == "" || $("#gender").val() == 0 || $("#province").val() == 0 || $("#email").val() == ""){
            alert("โปรดกรอกข้อมูลให้ครบ")
            e.preventDefault();
            return;
        }
        if( $("#pass").val().length < 8){
            alert("password ต้องยาวกว่า 8 ตัวอักษร");
            e.preventDefault();
            return;
        }
        if( !checkStrength($("#pass").val())){
            alert("password ต้องมีตัวอักษรภาษาอักงกฤษตัวเล็ก ตัวใหญ่และตัวเลข");
            e.preventDefault();
            return;
        }
        if( $("#pass").val() != $("#pass2").val()){
            alert("password ไม่ตรงกัน");
            e.preventDefault();
        }
    })

});
function checkStrength(password){
    const reg = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/
    return (String(password).match(reg))
}