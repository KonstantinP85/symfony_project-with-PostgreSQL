$(document).ready(function() {
    $("#quest_language").change(function() {
        var id = $("#quest_language option:selected").val();

        $.ajax(
            {
                url: 'http://localhost/newproject/myproject/public/profile/search',
                method: 'POST',
                dataType: 'html',
                data: {id:id},
                success: function(result){
                    $('#result').html(result);
                }
            })
    })
})