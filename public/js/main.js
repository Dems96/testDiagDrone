var interval;

$('#onRegister').on('click', function(){
    console.log("hello");
    username = document.getElementById('username').value
    password = document.getElementById('password').value
    role = document.getElementById('role').value

    // console.log(role, password, username);
    $.ajax({
        url: "/register",
        data:{ role: role, password: password, username: username },
        type: 'POST',
        success: function(result){
            window.location.href = 'http://127.0.0.1:8000/' 
          }
      });
})


$('.getDiscuss').on('click', function(){
    id_conversation_ = $(this).attr('value');
    id_admin = $(this).attr('id');
    $.ajax({
        url: "/discuss",
        data:{ id_conversation: id_conversation_ },
        type: 'POST',
        success: function(result){
            $('.modal').html(result)
            $('.modal').css('display','block')
            var x = document.getElementsByClassName("send")[0];
            x.id= id_admin
            
          },
          complete: function () {
            interval = setInterval(() => {
                  getNewMessage(id_conversation_)
              }, 1000);
          }
      });
})

$('.closeModal').on('click', function(){
    clearInterval(interval)
    $('.modal').css('display','none')
})

$('.send').on('click', function(){
    var id_admin;
    message = document.getElementById('sendMsg').value
    conversation = document.getElementById('sendMsg').className
    id_conversation = conversation.split("_")
    id_conv = id_conversation[1]
    id_admin = $(this).attr('id')
    console.log(id_admin);
    $.ajax({
        url: "/sendMessaage",
        data:{message: message, id_conversation: id_conv, id_admin: id_admin},
        type: 'POST',
        success: function(result){
            console.log("message envoyé");
            $('.modal-content').html('message envoyé !  <a href="listAdmin"><button>Retour</button></a>')
          },
      });
})

function getNewMessage(id_conv) {
    $.ajax({
        url: "/getNewMsg",
        data:{id_conversation: id_conv},
        type: 'POST',
        success: function(result){
            $('.body-modal').html(result)
          },
      });
}

// newMessageModal()

// function newMessageModal() {
//     $( ".getDiscuss" ).each(function() {
//         console.log($( this ).attr( "id" ));
//         if ($( this ).attr( "id" ) == 0) {
//             // id_conv = $( this ).attr( "name" );
//             $(this).click()
//             return
//         }
//     });
// }

