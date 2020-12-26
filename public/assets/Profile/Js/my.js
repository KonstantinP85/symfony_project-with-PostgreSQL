$(document).ready(function()
{
    search();
})
function search(){

    $(document).on('click','#quest_search', function(){
        var data = $("quest").serialize();
        var id = $(this).attr('name');
        $.ajax(
            {
                url: '',
                method: 'POST',
                dataType: 'html',
                data: {id:id, data:data},


            })
    })
}