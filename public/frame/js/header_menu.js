/**
 * Created by Administrator on 2017/2/21.
 */
$('.navbar .nav > li').click(function(){
    $(this).parent().find('.menu').removeClass('active');
    $(this).addClass('active');
    //alert($(this).attr('dataId'));
    $.post('/backend/querymenubypid',{
        parent_id:$(this).attr('dataId'),
        _token:$('meta[name="_token"]').attr('content')
    },function(data){
        //清除左边的菜单
        var dashMenu = $('#dashboard-menu');
        dashMenu.empty();

        for(var i=0;i<data.length;i++){
            var li = $('<li></li>').attr('menuId',data[i].id).addClass('active').click(function(){
                if($(this).hasClass('shut')){
                    $(this).addClass('open').removeClass('shut');
                    $(this).parent().find('ul[menuParentId="'+$(this).attr('menuId')+'"]').show();
                }else{
                    $(this).addClass('shut').removeClass('open');
                    $(this).parent().find('ul[menuParentId="'+$(this).attr('menuId')+'"]').hide();
                }
            }).appendTo(dashMenu);
            var a = $('<a href="javascript:void(0)"></a>').addClass('dropdown-toggle').appendTo(li);
            var icon = $('<span></span>').addClass(data[i].icon).appendTo(a);
            var span = $('<span></span>').css('marginLeft','6px').text(data[i].name).appendTo(a);
            var iNode = $('<i></i>').addClass('icon-chevron-down').appendTo(a);

            if(data[i].children.length>0){
                var ul = $('<ul></ul>').attr('menuParentId',data[i].id).addClass('submenu').show().appendTo(dashMenu);
                for(var j=0;j<data[i].children.length;j++){
                    var subLi = $('<li></li>').appendTo(ul);
                    var subA = $('<a href="'+data[i].children[j].href+'"></a>').text(data[i].children[j].name).appendTo(subLi);

                    if(currentSubMenuId == data[i].children[j].id){
                        var subPointer = $('<div></div>').addClass('pointer').appendTo(subLi);
                        var subArrow = $('<div></div>').addClass('arrow').appendTo(subPointer);
                        var subArrowBorder = $('<div></div>').addClass('arrow_border').appendTo(subPointer);
                    }
                }
            }
        }

    });
});

if(currentMenuId && currentMenuId!=0 && currentMenuId!=null){
    $('.navbar .nav > li').each(function(){
        if($(this).attr('dataId') == currentMenuId){
            $(this).click();
        }
    });
}