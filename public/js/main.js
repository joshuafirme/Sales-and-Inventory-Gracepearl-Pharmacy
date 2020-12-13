
$(document).ready(function(){

    getName();

    getAllNotif();

    setInterval(function(){
        getAllNotif();
    },300000);
     

      function getAllNotif(){
        $.ajax({
          url:"/notification/getAllNotif",
          type:"GET",
          success:function(response){
            console.log(response);
            $("#count-all-notif-bell").text(response[3]);
            $("#count-reorder-notif").text(response[2]);
            $("#count-expired-notif").text(response[1]);
            $("#count-expiry-notif").text(response[0]);
          }
         });
        
      }    

      function getName(){
        $.ajax({
          url:"/maintenance/user/getname",
          type:"GET",
          success:function(response){
            console.log(response);
            $("#auth-name").text(response);
          }
         });
        
      }    
      

});
  
  
  
  
  