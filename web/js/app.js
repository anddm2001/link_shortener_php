$(document).ready(function($) {
    $("#form").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: '/send-url',
            method: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                console.log(data);
                let new_link = '<a href="/' + data.short_url + '" target="_blank">' + data.short_url + '</a>';
                $('#short_url').html(new_link);
                $('#short_url').show();
            }
        });
    });
});