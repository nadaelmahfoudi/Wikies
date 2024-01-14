$(document).ready(function () {
    $('#keyword').on("keyup", function () {
        var input = $(this).val();

        // Handle the 'all' case
        if (input === "") {
            input = 'all';
        }

        $.ajax({
            url: "index.php?action=searchWikiByTitle&keyword=" + input,
            method: "GET",
            success: function (data) {
                $("#showdata").html(data);
            }
        });
    });
});
