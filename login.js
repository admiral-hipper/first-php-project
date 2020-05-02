$('#login').submit(function(){
    uname=$('#uname').val()
    upass=$('#upass').val()
    $.post('checkUser.php',{login:''+uname+' '+upass+''},function(data){
        if(!data){
            $('#info').html(data)
            ret=false
        }
        else ret=true
    })
    return ret
})