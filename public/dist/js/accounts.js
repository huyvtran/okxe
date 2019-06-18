$(document).ready(function(){
  
    var columns = [
        { "data": "id" , "class" : "width5percent" }, 
        { "data": "phone" , "class" : "width5percent" },
        { "data": "name" , "class" : "width5percent" },
        { "data": "items" , "class" : "width5percent" },
        { "data": "underreview" ,"class" : "width5percent" },
        { "data": "active" , "class" : "width5percent" },
        { "data": "inactive" , "class" : "width5percent" },
        { "data": "rejected" , "class" : "width5percent" },
        { "data": "cancelled" , "class" : "width5percent" },
        { "data": "status" , "class" : "width5percent" },
        { "data": "created_at" , "class" : "width5percent" },
        { "data": "last_visit" , "class" : "width5percent" },
        { "data": "action" , "class" : "width5percent" },
        { "data": "checkbox" , "class" : "width2percent" }
    ]
  
    renderList('#itemTable',orderColumns(columns),'/admin/getaccountlist',orderFalse([13,12,9]));

    var dataTable = $('#itemTable').DataTable();

    $("#itemTable").on("click",".action", function(){
        if (!confirm(jsLang.confirm_txt)){
            return false;
        }else{
            var stt = ( $(this).hasClass('ban') ) ? 'Banned' : 'Active';
            $.ajax({
                url: "/admin/accounts/action",
                type: 'PATCH',
                data: { 'id': $(this).parent().siblings(":first").text(), 'status': stt },
                success: function( msg ) {
                    msg.status ? ( dataTable.ajax.reload(null, false) ) : alert(msg.msg);
                }
            });
        }
    });

    $('.search-regis-date').datepicker({
        format:'DD/MM/YYYY'
    });
    $('.search-visit-date').datepicker({
        format:'DD/MM/YYYY'
    });

  });
