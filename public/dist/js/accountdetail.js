$(document).ready(function(){

  var columns = [
    { data: "id" , "class" : "width8percent" }, 
    { data: "title" , "class" : "width15percent" }, 
    { data: "id_province","class" : "width15percent"  },
    { data: "seri","class" : "width15percent" },  
    { data: "price" ,"class" : "width13percent"},
    { data: "status" , "class":"width15percent" }, 
    { data: "created_at", "class":"width23percent"}, 
    { data: "checkbox", "class":"width5percent" }, 
  ]
  
  renderList('#itemTable',orderColumns(columns),"/admin/accounts/getuseritems" + "?id=" + $("#accountid").val(),orderFalse([7]));

  $('#action').click(function(){
    if (!confirm(jsLang.confirm_txt)){
      return false;
    } else {
      var stt = ( $(this).hasClass('ban') ) ? 'Banned' : 'Active';
      $.ajax({
          url: "/admin/changeStatus",
          type: 'POST',
          data: { 'id': $('#accountid').val(), 'status': stt },
          success: function( msg ) {
              msg.status ? location.reload() : alert(jsLang.error_msg);
            }
      });
    } 
  });
});
