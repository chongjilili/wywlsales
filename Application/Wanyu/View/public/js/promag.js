/**
 * Created by lili on 2016/11/7.
 */


$(function () {
    $('#addprobtn').click(function (event) {
        event.preventDefault();
        var pname = $("#pname").val();
        var price = $("#price").val();
        if($.trim(pname) == ''){
            layer.msg('产品名称不能为空！');

        }else if($.trim(price) == ''){
            layer.msg('产品价格不能为空！');
        }else {
            $('#apform').submit();
        }

    })
})
