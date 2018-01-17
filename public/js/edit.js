/**
 * Created by X.P on 1/16/2018.
 */
$(document).ready(function () {
    url = 'orderListEdit/';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('body').on('click', 'button.edit', function() {
        //$('#task-title').text('编辑任务');
        $('#tsave').val('update');
        var tid = $(this).val();
        $('#tid').val(tid);
        $.get(url+tid, function (data) {
            console.log(url+tid);
            console.log(data);
            $('#tname').val(data.status);
        });
        $('#myModal').modal('show');
    });
    $('#tsave').click(function () {
        turl = url + $('#tid').val();
        var type = "PUT"; // edit
        var data = {
            status: $('#status_select').val()
        };
        $.ajax({
            type: type,
            url: turl,
            data: data,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#myModal').modal('hide');
                $('#status_form').trigger('reset');
                /*var newTr = '@if($order-> status == 0 || $order-> status == 1)' +
                    '<tr id="order' + data.id + 'style="background-color:#FFDED9"'+'>' +
                    '<td class="col-sm-3">' + data.itemname + '</td>' +
                    '<td class="col-sm-2">' + data.itemcode + '</td>' +
                    '<td class="col-sm-1">' + data.quantity + '</td>' +
                    '<td class="col-sm-1">' + '@if($order->discount != null)' + data.price + '<br><span class="label label-danger">折扣价:' +
                    data.finalPrice + '</span>' + '@else' + data.price + '@endif' + '</td>'+
                    '<td class="col-sm-1">' + data.username + '</td>' +
                    '<td class="col-sm-1">' + data.userid + '</td>' +
                    '<td class="col-sm-1">' + data.created_at + '</td>' +
                    '<td class="col-sm-2" ><button class="btn btn-default edit" value="' + data.id + '">修改</button>' + data.status(data.status) + '</td>' +
                    '</tr>' + '@else' +
                    '<tr id="order' + data.id + '">' +  '<td class="col-sm-3">' + data.itemname + '</td>' +
                    '<td class="col-sm-2">' + data.itemcode + '</td>' +
                    '<td class="col-sm-1">' + data.quantity + '</td>' +
                    '<td class="col-sm-1">' + '@if($order->discount != null)' + data.price + '<br><span class="label label-danger">折扣价:' +
                    data.finalPrice + '</span>' + '@else' + data.price + '@endif' + '</td>'+
                    '<td class="col-sm-1">' + data.username + '</td>' +
                    '<td class="col-sm-1">' + data.userid + '</td>' +
                    '<td class="col-sm-1">' + data.created_at + '</td>' +
                    '<td class="col-sm-2" >'+ data.status(data.status) +'</td>' +
                    '</tr>' + '@endif';*/
                var statusCode = 0;
                var hasDiscount = 0;
                var statusName;
                if(data.status == 0){
                    statusCode = 1;
                }
                if(data.discount != null){
                    hasDiscount = 1;
                }
                //改成名字
                if(data.status == 0){
                    statusName = '未提货';
                }else if(data.status == 1){
                    statusName = '已提货，未付款';
                }else if(data.status == 2){
                    statusName = '已付款';
                }else if(data.status == 3){
                    statusName = '取消订单';
                }


                //1.红背景 有折扣
                if(statusCode == 1 && hasDiscount == 1){
                    var newTr = '<tr id="order' + data.id + '"style="background-color:#FFDED9"'+'>' +
                        '<td class="col-sm-3">' + data.itemname + '</td>' +
                        '<td class="col-sm-2">' + data.itemcode + '</td>' +
                        '<td class="col-sm-1">' + data.quantity + '</td>' +
                        '<td class="col-sm-1">' + data.price + '<br><span class="label label-danger">折扣价:' +
                        data.finalPrice + '</span>'+ '</td>'+
                        '<td class="col-sm-1">' + data.username + '</td>' +
                        '<td class="col-sm-1">' + data.userid + '</td>' +
                        '<td class="col-sm-1">' + data.created_at + '</td>' +
                        '<td class="col-sm-2" ><button class="btn btn-default edit" value="' + data.id + '">修改</button> ' + statusName + '</td>' +
                        '</tr>'
                }
                //2.红背景 没折扣
                if(statusCode == 1 && hasDiscount == 0){
                    var newTr = '<tr id="order' + data.id + '"style="background-color:#FFDED9"'+'>' +
                        '<td class="col-sm-3">' + data.itemname + '</td>' +
                        '<td class="col-sm-2">' + data.itemcode + '</td>' +
                        '<td class="col-sm-1">' + data.quantity + '</td>' +
                        '<td class="col-sm-1">' + data.price + '</span>'+ '</td>'+
                        '<td class="col-sm-1">' + data.username + '</td>' +
                        '<td class="col-sm-1">' + data.userid + '</td>' +
                        '<td class="col-sm-1">' + data.created_at + '</td>' +
                        '<td class="col-sm-2" ><button class="btn btn-default edit" value="' + data.id + '">修改</button> ' + statusName + '</td>' +
                        '</tr>'
                }
                //3.白背景 有折扣
                if(statusCode == 0 && hasDiscount == 1){
                    var newTr = '<tr id="order' + data.id + '">' +
                        '<td class="col-sm-3">' + data.itemname + '</td>' +
                        '<td class="col-sm-2">' + data.itemcode + '</td>' +
                        '<td class="col-sm-1">' + data.quantity + '</td>' +
                        '<td class="col-sm-1">' + data.price + '<br><span class="label label-danger">折扣价:' +
                        data.finalPrice + '</span>'+ '</td>'+
                        '<td class="col-sm-1">' + data.username + '</td>' +
                        '<td class="col-sm-1">' + data.userid + '</td>' +
                        '<td class="col-sm-1">' + data.created_at + '</td>' +
                        '<td class="col-sm-2" >' +  statusName + '</td>' +
                        '</tr>'
                }
                //3.1白背景 有折扣 有按钮(已提货未付款的情况)
                if(statusCode == 0 && hasDiscount == 1){
                    var newTr = '<tr id="order' + data.id + '">' +
                        '<td class="col-sm-3">' + data.itemname + '</td>' +
                        '<td class="col-sm-2">' + data.itemcode + '</td>' +
                        '<td class="col-sm-1">' + data.quantity + '</td>' +
                        '<td class="col-sm-1">' + data.price + '<br><span class="label label-danger">折扣价:' +
                        data.finalPrice + '</span>'+ '</td>'+
                        '<td class="col-sm-1">' + data.username + '</td>' +
                        '<td class="col-sm-1">' + data.userid + '</td>' +
                        '<td class="col-sm-1">' + data.created_at + '</td>' +
                        '<td class="col-sm-2" ><button class="btn btn-default edit" value="' + data.id + '">修改</button> ' + statusName + '</td>' +
                        '</tr>'
                }

                //4.白背景 没折扣
                if(statusCode == 0 && hasDiscount == 0){
                    var newTr = '<tr id="order' + data.id + '">' +
                        '<td class="col-sm-3">' + data.itemname + '</td>' +
                        '<td class="col-sm-2">' + data.itemcode + '</td>' +
                        '<td class="col-sm-1">' + data.quantity + '</td>' +
                        '<td class="col-sm-1">' + data.price+ '</td>'+
                        '<td class="col-sm-1">' + data.username + '</td>' +
                        '<td class="col-sm-1">' + data.userid + '</td>' +
                        '<td class="col-sm-1">' + data.created_at + '</td>' +
                        '<td class="col-sm-2" >' +  statusName + '</td>' +
                        '</tr>'
                }
                //4.1白背景 没折扣
                if(statusCode == 0 && hasDiscount == 0){
                    var newTr = '<tr id="order' + data.id + '">' +
                        '<td class="col-sm-3">' + data.itemname + '</td>' +
                        '<td class="col-sm-2">' + data.itemcode + '</td>' +
                        '<td class="col-sm-1">' + data.quantity + '</td>' +
                        '<td class="col-sm-1">' + data.price+ '</td>'+
                        '<td class="col-sm-1">' + data.username + '</td>' +
                        '<td class="col-sm-1">' + data.userid + '</td>' +
                        '<td class="col-sm-1">' + data.created_at + '</td>' +
                        '<td class="col-sm-2" ><button class="btn btn-default edit" value="' + data.id + '">修改</button> ' + statusName + '</td>' +
                        '</tr>'
                }


                console.log(status_form);
                 // edit
                $('#order'+data.id).replaceWith(newTr);
                    //toastr.success('编辑成功！');

            },
            error: function (data, json, errorThrown) {
                console.log(data);
                var errors = data.responseJSON;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                //toastr.error( errorsHtml , "Error " + data.status +': '+ errorThrown);
            }
        });
    });
});
