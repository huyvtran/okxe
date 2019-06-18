$(document).ready(function(){
  
    var columns = [
      { data: "id" , "class" : "width8percent icon-center"}, 
      { data: "name" , "class" : "width18percent icon-center"}, 
      { data: "id_employee","class" : "width18percent icon-center" },  
      { data: "created_at", "class":"width23percent icon-center"},
      { data: "active","class" : "width15percent icon-center"}, 
      { data: "checkbox","class" : "width8percent icon-center"}, 
    ]
    
    renderList('#itemTable',orderColumns(columns),'/admin/brands/getlist',orderFalse([5]));

    $(".onoffswitch-checkbox").on('click',function(){
        $('#status').val() == 2 ? $('#status').val(1) : $('#status').val(2);
        $(".onoffswitch-switch").children().toggleClass("ban fa-times");
        $(this).children().toggleClass();
    })

    $("#itemTable").on("dblclick",".brand_name",function(e){
        e.stopPropagation();
        var currentEle = $(this);
        var value = $(this).html();
        var brandID = $(this).parent().siblings(":first").text();
        if($(this).children().attr("class") === undefined){
            updateVal(currentEle, value, brandID);
        }
    });

    function updateVal(currentEle, value, brandID) {
        $(document).off('click');
        $(currentEle).html('<input class="thVal td-check-exists" data-id="'+ brandID +'" type="text" value="' + value + '" />');
        $(".thVal").focus();
        $(".thVal").keydown(function(e) {
            var code = e.keyCode || e.which;
            if (code == 13 || code == 9) {
                if($(this).hasClass('available')){
                    $.ajax({
                        url: "/admin/brand/update",
                        type: 'PATCH',
                        data: { 'id': $(this).data('id') ,'value': $(this).val()},
                        success: function( msg ) {
                            msg.status ? ( $('#itemTable').DataTable().ajax.reload(null, false) ) : alert(msg.msg);
                        },
                        error: function(){
                            alert(jsLang.error_msg);
                        },
                    });
                }else{
                    alert(jsLang.name_is_not_valid);
                }
            }
        });

        $(document).on("focusout", function(e) {
          $(currentEle).html(value);
        });
    }
    
    $("#itemTable").on("click",".delete",function(){
      if (!confirm(jsLang.confirm_txt)){
          return false;
      }else{
          $.ajax({
              url: "/admin/brand/delete",
              type: 'DELETE',
              data: { 'id': $(this).parent().siblings(":first").text() },
              success: function( msg ) {
                  msg.status ? ( $('#itemTable').DataTable().ajax.reload(null, false) ) : alert(msg.msg);
              },
              error: function(){
                alert(jsLang.error_msg);
              },
          });
      }
    });

    $("#itemTable").on("click",".action",function(){
        if (!confirm(jsLang.confirm_txt)) {
            return false;
        } else {
            var stt = ( $(this).hasClass('ban') ) ? 1 : 0;
            $.ajax({
                url: "/admin/brand/status",
                type: 'POST',
                data: { 'id': $(this).parent().siblings(":first").text(),'status': stt },
                success: function( msg ) {
                    msg.status ? ( $('#itemTable').DataTable().ajax.reload(null, false) ) : alert(msg.msg);
                }
            });
        }
    });

    $("#itemTable").on("focus",".td-check-exists", function(){
         $(this).existsChecker("/admin/brand/checkbrand");
    });

    $(".check-exists").existsChecker("/admin/brand/checkbrand");
    
    $("#add").click(function(){
        var data = $('#add_form').serialize();
        $.ajax({
            type:'POST',
            url: '/admin/brand/add',
            data: data,
            beforeSend: function(){
                $("#add").attr('disabled',true);
            },
            success:function(msg){
                msg.stt ? ( $('#itemTable').DataTable().ajax.reload(null, false) && alert(msg.msg) ) : alert(msg.msg);
                $("#add").attr('disabled',false);
            },
            error: function(){
                alert(jsLang.error_msg);
            },
        });
        return false;
    });

    $("#clear").on('click',function(){
        $('.search-input-text').val('');
        $('.search-input-date').val('');
        $('.search-input-select').val('');
        $('.select-input-status').val('');
        var table = $('#itemTable').DataTable(); 
        table.search('').columns().search('').draw();
    });
  });