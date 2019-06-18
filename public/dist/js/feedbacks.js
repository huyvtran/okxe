$(document).ready(function(){

    var columns = [
      { data: "id" , "class" : "width5percent" }, 
      { data: "phone" , "class" : "width8percent" }, 
      { data: "name","class" : "width8percent"  },
      { data: "content","class" : "width28percent" },  
      { data: "rating" ,"class" : "width8percent"},
      { data: "contactable" ,"class" : "width8percent"},
      { data: "status" , "class":"width8percent" }, 
      { data: "created_at", "class":"width12percent" }, 
      { data: "checkbox","class" : "width8percent"}, 
    ]
    
    renderList('#itemTable',orderColumns(columns),'/admin/feedbacks/getlist',orderFalse([8]));

  });