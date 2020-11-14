
$(document).ready(function(){
 
    setInterval(function(){
        getAllNotif();
    },1000);
     

      function getAllNotif(){
        $.ajax({
          url:"/getAllNotif",
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

      

});
  
  
  
  
  