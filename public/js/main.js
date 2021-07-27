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

function getDiscuss() {
    
}

$('.getDiscuss').on('click', function(){
    id_conversation = $(this).attr('value');
    $.ajax({
        url: "/discuss",
        data:{ id_conversation: id_conversation },
        type: 'POST',
        success: function(result){
            console.log(id_conversation);
            console.log(result);
            $('.modal').html(result)
            $('.modal').css('display','block')
            // window.open('/discuss','winname','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=350');
          },
      });
})

$('.closeModal').on('click', function(){
    $('.modal').css('display','none')
})
