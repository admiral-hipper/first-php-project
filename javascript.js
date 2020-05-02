
    $('.btn-menu').click(function(){
        $('.menu-default').toggleClass('menu-after')
        setTimeout('')
        $('.article').toggleClass('article-after')
    })
   $('#add-publ').click(function(){
    $('#new-pub').css('display','grid')
})
function O(obj){
    return typeof obj=='object'?obj:document.getElementById(obj)
}
    
    