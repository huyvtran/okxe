$(document).ready(function(){
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    jQuery('.search-input-date').datepicker({
        format:'DD/MM/YYYY'
    });

    $('#options').click(function(){
      $("input:checkbox.checkBoxes").prop('checked',this.checked);
    });
    
    $(function() {
        setTimeout(function() {
            $("#message").hide('blind', {}, 500)
        }, 4000);
        
        setTimeout(function() {
            $(".itemTable-error").hide('blind', {}, 500)
        }, 3000);

        setTimeout(function() {
            $(".accountTable-error").hide('blind', {}, 500)
        }, 3000);
    });
    
    (function(){
        window.orderColumns = function(columnsO = []){
            var columns = [];
            columnsO.forEach(function(key) {
                ele = {"data" : key.data , "class" : key.class };
                columns.push(ele);
            });
            return columns;
        }

        window.orderFalse = function(columns = []){
            var columnDefs = [];
            columns.forEach(function(key) {
                ele = {"targets" : key , "orderable" : false };
                columnDefs.push(ele);
            });
            return columnDefs;
        }

        window.renderList = function(tableId,columns,url,columnDefs) { 
            var dataTable = $(tableId).DataTable( {
            "autoWidth": false,
            "processing": true,
            "sDom": 'Rlfrtip',
            "columnDefs": columnDefs,
            "columns": columns,
            "serverSide": true,
            "language": {
                url: '/datatableslang',
            },
            "ajax":{
                url :url, 
                type: "post",  
                error: function(){  
                $(".itemTable-error").html("");
                $("#itemTable").append('<tbody class="itemTable-error"><tr><th colspan="8" style="background:white;">'+ jsLang.error_msg +'</th></tr></tbody>');
                $("#itemTable_processing").css("display","none");
                
                }
            }
            } );
            $('#itemTable_filter').css( 'display','none');  // hiding global search box
            $('.search-input-text').on( 'keypress', function (e) {   // for text boxes
                if(e.which === 13){
                    var i =$(this).attr('data-column');  // getting column index
                    var v =$(this).val();  // getting search input value
                    dataTable.columns(i).search(v).draw();
                }
            } );
            $('.search-input-text').on( 'blur', function () {   // for date boxes
                var i =$(this).attr('data-column');  // getting column index
                var v =$(this).val();  // getting search input value
                dataTable.columns(i).search(v).draw();
            } );
            $('.search-input-date').on( 'change', function () {   // for date boxes
            var i =$(this).attr('data-column');  // getting column index
            var v =$("#dayFrom").val() + '-' +$("#dayTo").val();  // getting search input value
            dataTable.columns(i).search(v).draw();
            } );
            $('.search-input-select').on( 'change', function () {   // for select box
            var i =$(this).attr('data-column');  
            var v =$(this).val();  
            dataTable.columns(i).search(v).draw();
            } );
            $('.select-input-status').on('click', function () {   // for status label
            var v =$(this).data('val');
            dataTable.search(v).draw();
            } );

        };
    }).call(this);
    
    function change_alias(alias) {
        var str = alias;
        str = str.toLowerCase();
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a"); 
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e"); 
        str = str.replace(/ì|í|ị|ỉ|ĩ/g,"i"); 
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u"); 
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y"); 
        str = str.replace(/đ/g,"d");
        str = str.replace(/ + /g," ");
        str = str.trim(); 
        return str;
    }

    displayErr = function(e,selfID,feedback){
        if(e === true){
            if(selfID == 0){
                $('.check-exists').addClass('taken').removeClass('available');
                $('#add').attr('disabled',true);
            }else{
                feedback.children().removeClass('available').addClass('taken');
            }
        }else{
            if(selfID == 0){
                $('.check-exists').addClass('available').removeClass('taken');
                $('#add').attr('disabled',false);
            }else{
                feedback.children().removeClass('taken').addClass('available');
            }
        }
    }

    $.fn.existsChecker = function(url) {
        $(this).on('keyup',function(){
            var self = $(this),
                selfID = self.parent().data('id'),
                stt,
                feedback = $('.brand_name[data-id='+ selfID +']'),
                regex = /^[a-zA-Z0-9\s]*$/;
                stt = (regex.test(change_alias(self.val())) && change_alias(self.val()).length > 0) ? false : true ;
                displayErr(stt,selfID,feedback);
        });
    }
});