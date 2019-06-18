$(document).ready(function(){
  
  var columns = [
    { data: "id" , "class" : "width8percent" }, 
    { data: "title" , "class" : "width18percent" }, 
    { data: "id_province","class" : "width18percent"  },
    { data: "seri","class" : "width15percent" },  
    { data: "price" ,"class" : "width13percent"},
    { data: "status" , "class":"width15percent" }, 
    { data: "created_at", "class":"width23percent" }, 
    { data: "checkbox","class" : "width8percent"}, 
  ]
  
  renderList('#itemTable',orderColumns(columns),'/admin/getlist',orderFalse([7]));

});