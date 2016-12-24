$(document).ready(function(){

   var messageId = 0;
   
   $('#text').keypress(function(e){
      if(e.keyCode==13)
         $('#sendButton').trigger("click");
   });

   function sendData(data,callback){
       $.post( "ajax.php", JSON.stringify(data)).done(callback);
   }
   
  var escape = document.createElement('textarea');
  function escapeHTML(html) {
    escape.textContent = html;
    return escape.innerHTML;
  }

  
   function getMessages(){
       var data = {func:     "getMessages",
                   messageId: messageId};
       sendData(data,function(data){
           var messages = data.data;
           for (var i=0;i<messages.length;i++){
              var newMessage = $("<div>");
              newMessage.html("<b>"+escapeHTML(messages[i].nick)+":</b> "+escapeHTML(messages[i].text));
              $("#messageLog").prepend(newMessage);
           }
           messageId = +data.nextMessageId;
       });
   }

   $("#sendButton").click(function(){     
     var data    = {func: "addMessage",
                    nick: $("#nick").val(),
                    text: $("#text").val()}; 
     sendData(data, function(data){
         
         getMessages();
         //alert(data);         
     });
	 $("#text").val("");
   });
  
   setInterval(getMessages, 2000);
     
});