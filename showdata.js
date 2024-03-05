$(document).ready(() => {
    $('#searchBTN').on("click", () => {
        window.location.href = "./showdata.php?search="+$("#searchText").val();
    })

});