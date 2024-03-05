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
        if( $("#fname").val() == "" || $("#lname").val() == "" || $("#gender").val() == 0 || $("#province").val() == 0 || $("#email").val() == ""){
            alert("โปรดกรอกข้อมูลให้ครบ")
            e.preventDefault();
            return;
        }
    })

});