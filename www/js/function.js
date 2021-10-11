function startLoading()
{
    $("#load_block").show();
    var centerY = $(window).scrollTop() + ($(window).height() + $("#load_img").height())/2;
    var centerX = $(window).scrollLeft() + ($(window).width() + $("#load_img").width())/2;
    $("#load_img").offset({ top:centerY, left:centerX });
}

function stopLoading()
{
    $("#load_block").hide();
}

function make_ajax(type, dataType, url, data, success)
{
    if(type === "") type = "get";
    if(dataType === "") dataType = "json";
    
    var obj = { 
                type: type, dataType: dataType, url: url, 
                beforeSend: startLoading(), success: success
              };
              
    if(data !== "") obj.data = data;
    $.ajax(obj);   
}

function getOrder(client_id, type)
{
    var success = function(data)
                    {
                        stopLoading();
                        if(type == 1)
                        {
                            $('#bg_cont_list_orders').append(data);
                        }
                        else
                        {
                            $('#bg_cont_list_orders').html(data);
                        }
                        Load();
                    };
    make_ajax('', 'html', 'order/get_orders/'+client_id, '', success);
}

function getClient(obj)
{
    var client_id = 0;
    if(obj != null)
    {
        client_id = $(obj).attr('client_id');
    }
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        if(client_id != 0)
                        {
                            $(obj).addClass('bg_cont_list_tr_select');
                        }
                        getOrder(client_id, 0);
                        $('#bg_cont_client_list').html(data);
                        Load();
                    };
    make_ajax('', 'html', 'client/get_client/'+client_id, '', success);
}

function getClientSearch(obj)
{
    var client = $(obj).val().toLowerCase();

    $(".bg_cont_client_lists table tbody tr").each(function (i) {
        if ($(this).text().toLowerCase().indexOf(client)==-1)
        {
            $(this).hide();
        }
        else
        {
            $(this).show();
        }
    });
    $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
    $('#bg_cont_client_list').html('<div class="alert alert-info alert-min">Клиент не выбран</div>');
    $('#bg_cont_list_orders').html('');
}

function clientEdit(obj)
{
    var client_id = $(obj).parent().parent().attr('client_id');
    if(typeof client_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $("#bg_cont_client_block").modal('show');
                            $('#bg_cont_client_add').html(data);
                        };
        make_ajax('', 'html', 'client/client_edit/'+client_id, '', success);
    }
    else
    {
        alert('Выберите клиента из списка!');
    }
}

function getClientList(client_id, type)
{
    var office_id = $('#office_id').val();
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        if(client_id != 0)
                        {
                            $('.bg_cont_list_tr[client_id = '+client_id+']').addClass('bg_cont_list_tr_select');
                            //getOrder(client_id, 0);
                        }
                        $('#bg_cont_list_orders').html('');
                        if(type == 0)
                        {
                            getOrder(client_id, 0);
                        }
                        else if (type == 1)
                        {
                            $('#bg_cont_client_list').html('<div class="alert alert-info alert-min">Клиент не выбран</div>');
                        }
                        Load();
                    };
    make_ajax('', 'html', 'clientlist/get_client_list/'+office_id, '', success);
}

function clientUpdate(obj)
{
    var client_id = $('#client_id').val();
    var fio = $('#client_fio').val();
    var emex_id = $('#client_emex_id').val();
    var vin = $('#client_vin').val();
    var marka_avto = $('#client_marka_avto').val();
    var organization = $('#client_organization').val();
    var phone = $('#client_phone').val();
    var email = $('#client_email').val();
    var comment = $('#client_comment').val();
    var percent_discount = $('#client_percent_discount').val();
    var data = 'action=edit&fio='+fio+'&emex_id='+emex_id+'&vin='+vin+'&marka_avto='+marka_avto+
               '&organization='+organization+'&phone='+phone+'&email='+email+'&comment='+comment+
               '&percent_discount='+percent_discount;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_client_block").on('hidden.bs.modal', function(){
                           // getClientList(client_id);
                          });
                        $("#bg_cont_client_block").modal('hide');
                        $('#bg_cont_client_list').html(data);
                        getClientList(client_id, 0);
                    };
    make_ajax('post', 'html', 'client/save_client/'+client_id, data, success);
}

function clientSave(obj)
{
    var client_id = 0;
    var office_id = $('#office_id').val();
    var fio = $('#client_fio').val();
    var emex_id = $('#client_emex_id').val();
    var vin = $('#client_vin').val();
    var marka_avto = $('#client_marka_avto').val();
    var organization = $('#client_organization').val();
    var comment = $('#client_comment').val();
    var phone = $('#client_phone').val();
    var email = $('#client_email').val();
    var percent_discount = $('#client_percent_discount').val();
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_client_block").on('hidden.bs.modal', function(){
                            //getClientList(0);
                          });
                        $("#bg_cont_client_block").modal('hide');
                        $('#bg_cont_client_list').html(data);
                        client_id = $('#client_id').val();
                        if(client_id == 'undefined')
                        {
                            client_id = 0;
                        }
                        getClientList(client_id, 0);
                    };
    var data = 'action=add&fio='+fio+'&emex_id='+emex_id+'&vin='+vin+'&marka_avto='+marka_avto+
               '&organization='+organization+'&comment='+comment+'&phone='+phone+'&email='+email+
               '&office_id='+office_id+'&percent_discount='+percent_discount;
    make_ajax('post', 'html', 'client/save_client/', data, success);
}

function clientAdd(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_client_block").modal('show');
                        $('#bg_cont_client_add').html(data);
                    };
    make_ajax('', 'html', 'client/client_add/', '', success);
}

function clientCansel(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_user_list').html(data);
                    };
    make_ajax('', 'html', 'client/get_client/', '', success);
}

function getDiscounthistoryList(discount_id, type)
{
    var success = function(data)
                    {
                        stopLoading();
                        if(type == 1)
                        {
                            $('#bg_cont_list_historys').append(data);
                        }
                        else
                        {
                            $('#bg_cont_list_historys').html(data);
                        }
                    };
    make_ajax('', 'html', 'discounthistory/get_discounthistorys/'+discount_id, '', success);
}

function getDiscountchangehistoryList(discount_id, type)
{
    var success = function(data)
                    {
                        stopLoading();
                        if(type == 1)
                        {
                            $('#bg_cont_list_change_historys').append(data);
                        }
                        else
                        {
                            $('#bg_cont_list_change_historys').html(data);
                        }
                    };
    make_ajax('', 'html', 'discountchangehistory/get_discountchangehistorys/'+discount_id, '', success);
}

function getDiscount(obj)
{
    var discount_id = 0;
    if(obj != null)
    {
        discount_id = $(obj).attr('discount_id');
    }
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        if(discount_id != 0)
                        {
                            $(obj).addClass('bg_cont_list_tr_select');
                        }
                        getDiscounthistoryList(discount_id, 0);
                        getDiscountchangehistoryList(discount_id, 0);
                        $('#bg_cont_discount_list').html(data);
                    };
    make_ajax('', 'html', 'discount/get_discount/'+discount_id, '', success);
}

function getDiscountSearch(obj)
{
    var discount = $(obj).val().toLowerCase();

    $(".bg_cont_discount_lists table tbody tr").each(function (i) {
        if ($(this).text().toLowerCase().indexOf(discount)==-1)
        {
            $(this).hide();
        }
        else
        {
            $(this).show();
        }
    });
    $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
    $('#bg_cont_discount_list').html('<div class="alert alert-info alert-min">Карта не выбрана</div>');
    $('#bg_cont_list_historys').html('');
}

function discountEdit(obj)
{
    var discount_id = $(obj).parent().parent().attr('discount_id');
    if(typeof discount_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $("#bg_cont_discount_block").modal('show');
                            $('#bg_cont_discount_add').html(data);
                            $('#discount_birthday').datepicker({autoclose: true, language: 'ru'});
                        };
        make_ajax('', 'html', 'discount/discount_edit/'+discount_id, '', success);
    }
    else
    {
        alert('Выберите карту из списка!');
    }
}

function getDiscountList(discount_id, type)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        if(discount_id != 0)
                        {
                            $('.bg_cont_list_tr[discount_id = '+discount_id+']').addClass('bg_cont_list_tr_select');
                        }
                        $('#bg_cont_list_historys').html('');
                        if(type == 0)
                        {
                            getDiscounthistoryList(discount_id, 0);
                            getDiscountchangehistoryList(discount_id, 0);
                        }
                        else if (type == 1)
                        {
                            $('#bg_cont_discount_list').html('<div class="alert alert-info alert-min">Карта не выбрана</div>');
                        }
                    };
    make_ajax('', 'html', 'discountlist/get_discount_list/', '', success);
}

function discountUpdate(obj)
{
    var discount_id = $('#discount_id').val();
    var number = $('#discount_number').val();
    var number_code = $('#discount_number_code').val();
    var fio = $('#discount_fio').val();
    var birthday = $('#discount_birthday').val();
    var phone = $('#discount_phone').val();
    var address = $('#discount_address').val();
    var percent = $('#discount_percent').val();
    var bonus = $('#discount_bonus').val();
    var bonus_before = $('#discount_bonus_before').val();
    var bonus_no_writeoff = 0;
    if($('#discount_bonus_no_writeoff').prop("checked"))
    {
        bonus_no_writeoff = 1;
    }
    var percent_fixed = 0;
    if($('#discount_percent_fixed').prop("checked"))
    {
        percent_fixed = 1;
    }
    var data = 'action=edit&number='+number+'&number_code='+number_code+'&fio='+fio+'&birthday='+birthday+
               '&phone='+phone+'&address='+address+'&percent='+percent+'&bonus='+bonus+'&bonus_no_writeoff='+bonus_no_writeoff+
               '&percent_fixed='+percent_fixed+'&bonus_before='+bonus_before;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_discount_block").modal('hide');
                        $('#bg_cont_discount_list').html(data);
                        getDiscountList(discount_id, 0);
                    };
    make_ajax('post', 'html', 'discount/save_discount/'+discount_id, data, success);
}

function discountSave(obj)
{
    var discount_id = 0;
    var number = $('#discount_number').val();
    var number_code = $('#discount_number_code').val();
    var fio = $('#discount_fio').val();
    var birthday = $('#discount_birthday').val();
    var phone = $('#discount_phone').val();
    var address = $('#discount_address').val();
    var percent = $('#discount_percent').val();
    var bonus = $('#discount_bonus').val();
    var bonus_no_writeoff = 0;
    if($('#discount_bonus_no_writeoff').prop("checked"))
    {
        bonus_no_writeoff = 1;
    }
    var percent_fixed = 0;
    if($('#discount_percent_fixed').prop("checked"))
    {
        percent_fixed = 1;
    }
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_discount_block").modal('hide');
                        $('#bg_cont_discount_list').html(data);
                        discount_id = $('#discount_id').val();
                        if(discount_id == 'undefined')
                        {
                            discount_id = 0;
                        }
                        getDiscountList(discount_id, 0);
                    };
    var data = 'action=add&number='+number+'&number_code='+number_code+'&fio='+fio+'&birthday='+birthday+
               '&phone='+phone+'&address='+address+'&percent='+percent+'&bonus='+bonus+'&bonus_no_writeoff='+bonus_no_writeoff+
               '&percent_fixed='+percent_fixed;
    make_ajax('post', 'html', 'discount/save_discount/', data, success);
}

function discountAdd(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_discount_block").modal('show');
                        $('#bg_cont_discount_add').html(data);
                        $('#discount_birthday').datepicker({autoclose: true, language: 'ru'});
                    };
    make_ajax('', 'html', 'discount/discount_add/', '', success);
}

function discountCansel(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_user_list').html(data);
                    };
    make_ajax('', 'html', 'discount/get_discount/', '', success);
}

function discountRefresh()
{
    getDiscountList(0, 1);
}

function getCreditCard(obj)
{
    var order_id = $(obj).attr('order_id');
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").modal('toggle');
                        $('#bg_cont_order_add').html(data);
                    };
    make_ajax('', 'html', 'creditcard/get_creditcard/'+order_id, '', success);
}

function orderCreditCardAdd(obj)
{
    var order_id = $('#creditcard_order_id').val();
    var client_id = $('#client_id').val();
    var creditcard = $('#creditcard_order_number').val();
    var data = '&creditcard='+creditcard+'&order_id='+order_id;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").modal('hide');
                        $('.alert').remove();
                        $('#bg_cont_list_orders').html(data);
                        getOrder(client_id, 1);
                    };
    make_ajax('post', 'html', 'creditcard/save_creditcard/', data, success);
}

function getCreditBonus(obj)
{
    var order_id = $(obj).attr('order_id');
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").modal('toggle');
                        $('#bg_cont_order_add').html(data);
                    };
    make_ajax('', 'html', 'creditbonus/get_creditbonus/'+order_id, '', success);
}

function orderCreditBonusAdd(obj)
{
    var order_id = $('#creditbonus_order_id').val();
    var client_id = $('#client_id').val();
    var creditbonus = $('#creditbonus_order_bonus_real').val();
    var data = 'creditbonus='+creditbonus+'&order_id='+order_id;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").modal('hide');
                        $('.alert').remove();
                        $('#bg_cont_list_orders').html(data);
                        getOrder(client_id, 1);
                    };
    make_ajax('post', 'html', 'creditbonus/save_creditbonus/', data, success);
}

function getJournals(obj)
{
    var office_id = $('#office_id').val();
    var date_sel = $(obj).attr('date_sel');
    var data = 'date='+date_sel;
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_panel').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        $(obj).addClass('bg_cont_list_tr_select');
                    };
    make_ajax('post', 'html', 'journal/get_journals/'+office_id, data, success);
}

function getJournalList(obj)
{
    var office_id = $(obj).val();
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        $('#bg_cont_journal_list').html('<div class="alert alert-info alert-min">Не выбрана дата</div>');
                    };
    make_ajax('', 'html', 'journallist/get_journal_list/'+office_id, '', success);
}

function getPrintInvoice(obj)
{
    var link = $(obj).parent();
    var order_id = $(obj).attr('order_id');
    link.attr('href', 'print/print_invoice/'+order_id);
}

function getPrintCashRegister(obj)
{      
    var link = $(obj).parent();
    var order_id = $(obj).attr('order_id');
    link.attr('href', 'print/print_cash_register/'+order_id);
}

function getPrintCashRegisterFast(obj)
{
    var link = $(obj).parent();
    var order_id = $(obj).attr('order_id');
    link.attr('href', 'print/print_cash_register_fast/'+order_id);
}

function orderSave(obj)
{
    var post = [];
    var valid_sum = true;
    var valid_comment = true;
    $('.order_lists').each(function(i){
        valid_sum = ($(this).find("input[order_cod=order_sum]").val() != '');  
        valid_comment = ($(this).find("textarea[order_cod=order_comment]").val() != '');
        post[i] = {
                    'order_comment': $(this).find("textarea[order_cod=order_comment]").val(),
                    'order_count': $(this).find("input[order_cod=order_count]").val(),
                    'order_sum': $(this).find("input[order_cod=order_sum]").val()
                  };
    });
    var client_id = $('#order_client_id').val();
    var delivery = $("input[order_cod=order_delivery_time]").val();
    var percent_discount = $("input[order_cod=order_percent_discount]").val();
    var abcp_number = $('#order_abcp_id').val();
    if(valid_comment == false)
    {
        alert('Не заполнено поле Комментарии!');
        return false;
    } 
    if(valid_sum == false)
    {
        alert('Не заполнено поле Cумма!');
        return false;
    }
    if(delivery == '')
    {
        alert('Не заполнено поле Срок поставки!');
        return false;
    }
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").on('hidden.bs.modal', function(){
                            //getOrder(client_id, 1);
                          });
                        $("#bg_cont_order_block").modal('hide');
                        $('.alert').remove();
                        $('#bg_cont_list_orders').html(data);
                        getOrder(client_id, 1);
                    };
    var data = 'action=add&client_id='+client_id+'&delivery='+delivery+'&percent_discount='+percent_discount+'&abcp_number='+abcp_number+'&data=' + JSON.stringify(post);
    make_ajax('post', 'html', 'order/save_order/', data, success);
}

function orderUpdate(obj)
{
    var post = [];
    var valid_sum = ($('.order_lists').find("input[order_cod=order_sum]").val() != '');  
    var valid_comment = ($('.order_lists').find("textarea[order_cod=order_comment]").val() != '');
    
    var order_comment = $('.order_lists').find("textarea[order_cod=order_comment]").val();
    var order_sum = $('.order_lists').find("input[order_cod=order_sum]").val();
    
    var client_id = $('#order_client_id').val();
    var order_id = $('#order_order_id').val();
    var delta_balance = $('#order_delta_balance').val();
    var delivery = $("input[order_cod=order_delivery_time]").val();
    var percent_discount = $("input[order_cod=order_percent_discount]").val();
    var sub_comment = $("textarea[order_cod=order_sub_comment]").val();
    if(valid_comment == false)
    {
        alert('Не заполнено поле Комментарии!');
        return false;
    } 
    if(valid_sum == false)
    {
        alert('Не заполнено поле Cумма!');
        return false;
    }
    if(delivery == '')
    {
        alert('Не заполнено поле Срок поставки!');
        return false;
    }
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").on('hidden.bs.modal', function(){
                            //getOrder(client_id, 1);
                          });
                        $("#bg_cont_order_block").modal('hide');
                        $('.alert').remove();
                        $('#bg_cont_list_orders').html(data);
                        getOrder(client_id, 1);
                    };
    var data = 'action=edit&client_id='+client_id+'&delta_balance='+delta_balance+'&delivery='+delivery;
    data = data + '&percent_discount='+percent_discount+'&comment='+order_comment+'&sum='+order_sum+'&order_id='+order_id+'&sub_comment='+sub_comment;
    make_ajax('post', 'html', 'order/save_order/', data, success);
}

function orderAdd(obj)
{
    var client_id = $('#client_id').val();
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").modal('show');
                        $('#bg_cont_order_add').html(data);
                    };
    make_ajax('', 'html', 'order/order_add/'+client_id, '', success);
}

function orderEdit(obj)
{
    var client_id = $('#client_id').val();
    var order_id = $(obj).attr('order_id');
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").modal('show');
                        $('#bg_cont_order_add').html(data);
                    };
    var data = 'order_id='+order_id;
    make_ajax('post', 'html', 'order/order_edit/'+client_id, data, success);
}

function orderCansel(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_list_orders').html(data);
                    };
    make_ajax('', 'html', 'order/get_orders/', '', success);
}

function orderAddAutoRow()
{
    var client_id = $('#client_id').val();
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_auto_block").modal('show');
                        $('#bg_cont_order_add_auto').html(data);
                    };
    make_ajax('', 'html', 'order/order_add_auto/'+client_id, '', success);
}

function orderAutoAdd()
{
    $('.order_auto_tbody_lists .order_auto_lists').each(function(i, v){
        if($(v).find("input[type=checkbox]").prop("checked"))
        {
            var global_id = $(v).find('.global_id').html();
            var make_name = $(v).find('.make_name').html();
            var detail_num = $(v).find('.detail_num').html();
            var detail_name_rus_user = $(v).find('.detail_name_rus_user').html();
            var detail_quantity = $(v).find('.detail_quantity').html();
            var price_potr_order_rur = $(v).find('.price_potr_order_rur').html();
            if($('.order_lists:last textarea[order_cod=order_comment]').val() != '')
            {
                orderAddRow();
            }
            $('.order_lists:last').find('textarea[order_cod=order_comment]').val(make_name+': '+detail_num+' - '+detail_name_rus_user);
            $('.order_lists:last').find('input[order_cod=order_count]').val(detail_quantity);
            $('.order_lists:last').find('input[order_cod=order_sum]').val(price_potr_order_rur);
        }
    });
    setOrderAllSum();
    $("#bg_cont_order_auto_block").modal('hide');
}

function orderAddRow()
{
    var order_item = $(".order_item:hidden").clone();
    order_item.removeClass('order_item').addClass('order_lists').show()
    var order_number = order_item.find("td[order_cod=order_number]");
    order_number.html(parseInt(order_number.html()) + 1);
    $(".order_item:hidden").find("td[order_cod=order_number]").html(order_number.html());
    $('.order_lists:last').after(order_item); 
}

function orderDelRow(obj)
{
    $(obj).parent().parent().remove();
    setOrderAllSum();
}

function setOrderAllSum()
{
    var sum = 0;
    var count = 0;
    var percent_discount = $("input[order_cod=order_percent_discount]").val();
    $('.order_lists td input[order_cod=order_sum]').each(function(i)
        {
            count = parseInt($(this).parent().parent().find('td input[order_cod=order_count]').val());
            if($(this).val() != '' && count > 0)
            {
                sum = sum + (parseInt($(this).val()) * count);
            }
        });
    sum = sum - (sum * (percent_discount/100));
    $('.order_all_sum input[order_cod=order_all_sum]').val(sum);
}

function orderShipping(obj)
{
    var client_id = $('#client_id').val();
    var order_id = $(obj).attr('order_id');
    var success = function(data)
                    {
                        stopLoading();
                        $('.alert').remove();
                        $('#bg_cont_list_orders').html(data);
                        getOrder(client_id, 1);
                    };
    var data = 'order_id='+order_id;
    make_ajax('post', 'html', 'order/save_shipping/', data, success);
}

function getOrderCash(obj, type)
{
    var office_id = $('#office_id').val();
    var order_id = $(obj).attr('order_id');
    var data = 'type='+type+'&order_id='+order_id;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").modal('show');
                        $('#bg_cont_order_add').html(data);
                    };
    make_ajax('post', 'html', 'ordercash/get_cash/'+office_id, data, success);
}

function orderCashSave(obj)
{
    var client_id = $('#client_id').val();
    var office_id = $('#cash_office_id').val();
    var order_id = $('#cash_order_id').val();
    var type = $('#cash_order_type').val();
    var sum = $('#cash_order_sum').val();
    var comment = $('#cash_order_comment').val();
    var data = 'type='+type+'&sum='+sum+'&comment='+comment+'&order_id='+order_id;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").on('hidden.bs.modal', function(){
                            //getOrder(client_id, 1);
                          });
                        $("#bg_cont_order_block").modal('hide');
                        $('.alert').remove();
                        $('#bg_cont_list_orders').html(data);
                        getOrder(client_id, 1);
                    };
    make_ajax('post', 'html', 'ordercash/save_cash/'+office_id, data, success);
}

function getOrderCoinsAdd(obj)
{
    var office_id = $('#office_id').val();
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").modal('show');
                        $('#bg_cont_order_add').html(data);
                    };
    make_ajax('', 'html', 'ordercoins/get_coins/'+office_id, '', success);
}

function orderCoinsAdd(obj)
{
    var client_id = $('#client_id').val();
    var office_id = $('#coins_office_id').val();
    var sum = $('#coins_order_sum').val();
    var comment = $('#coins_order_comment').val();
    var cashless = $('#coins_order_cashless').prop("checked");
    if(cashless)
    {
        cashless = 1;
    }
    else
    {
        cashless = 0;
    }
    var data = '&sum='+sum+'&client_id='+client_id+'&cashless='+cashless+'&comment='+comment;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").on('hidden.bs.modal', function(){
                            //getOrder(client_id, 1);
                          });
                        $("#bg_cont_order_block").modal('hide');
                        $('.alert').remove();
                        $('#bg_cont_list_orders').html(data);
                        getOrder(client_id, 1);
                    };
    make_ajax('post', 'html', 'ordercoins/save_coins/'+office_id, data, success);
}

function getPrintCoins(obj)
{
    var link = $(obj).parent();
    var order_id = $(obj).attr('order_id');
    link.attr('href', 'print/print_coins/'+order_id);
}

function clientRefresh()
{
    getClientList(0, 1);
}

function orderRefresh()
{
    var client_id = $('#client_id').val();
    getOrder(client_id, 0);
}

function getExpensesList(typeexpenses_id)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_list_expenses').html(data);
                    };
    make_ajax('', 'html', 'expenses/get_expenses/'+typeexpenses_id, '', success);
}

function getTypeExpenses(obj)
{
    var typeexpenses_id = $(obj).attr('typeexpenses_id');
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_typeexpenses_list').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        if(typeexpenses_id != 0)
                        {
                            $(obj).addClass('bg_cont_list_tr_select');
                            getExpensesList(typeexpenses_id);
                        }
                    };
    make_ajax('', 'html', 'typeexpenses/get_typeexpenses/'+typeexpenses_id, '', success);
}

function typeExpensesAdd(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_typeexpenses_list').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        getExpensesList(0);
                    };
    make_ajax('', 'html', 'typeexpenses/typeexpenses_add/', '', success);
}

function getTypeExpensesList()
{
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list').html(data);
                    };
    make_ajax('', 'html', 'typeexpenseslist/get_typeexpenses_list/', '', success);
}

function typeExpensesSave(obj)
{
    var name = $('#name').val();
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_typeexpenses_list').html(data);
                        getTypeExpensesList();
                        getExpensesList(0);
                    };
    var data = 'action=add&name='+name;
    make_ajax('post', 'html', 'typeexpenses/save_typeexpenses/', data, success);
}


function typeExpensesUpdate(obj)
{
    var typeexpenses_id = $(obj).parent().parent().attr('typeexpenses_id');
    var name = $('#name').val();
    var data = 'action=edit&name='+name;
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_typeexpenses_list').html(data);
                        getTypeExpensesList();
                    };
    make_ajax('post', 'html', 'typeexpenses/save_typeexpenses/'+typeexpenses_id, data, success);
}

function typeExpensesDel(obj)
{
    var typeexpenses_id = $(obj).parent().parent().attr('typeexpenses_id');
    if(typeof typeexpenses_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $('#bg_cont_typeexpenses_list').html(data);
                            getTypeExpensesList();
                            getExpensesList(0);
                        };
        make_ajax('', 'html', 'typeexpenses/del_typeexpenses/'+typeexpenses_id, '', success);
    }
    else
    {
        alert('Выберите тип расходов из списка!');
    }
}

function typeExpensesCansel(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_typeexpenses_list').html(data);
                        getExpensesList(0);
                    };
    make_ajax('', 'html', 'typeexpenses/get_typeexpenses/', '', success);
}

function expensesGive(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_expenses_block").modal('show');
                        $('#bg_cont_expenses_add').html(data);
                    };
    make_ajax('', 'html', 'expenses/expenses_add/', '', success);
}

function expensesGiveSave(obj)
{
    var typeexpenses_id = $('.bg_cont_list_tr_select').attr('typeexpenses_id');
    var sum = $('#expenses_sum').val();
    var office_id = $('#expenses_office_id').val();
    var comment = $('#expenses_comment').val();
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_expenses_block").on('hidden.bs.modal', function(){
                            getExpensesList(typeexpenses_id);
                          });
                        $("#bg_cont_expenses_block").modal('hide');
                        $('#bg_cont_expenses_list').html(data);
                    };
    var data = 'action=add&typeexpenses_id='+typeexpenses_id+'&sum='+sum+'&office_id='+office_id+'&comment='+comment;
    make_ajax('post', 'html', 'expenses/save_expenses/', data, success);
}

function discounthistorysClear()
{
    if(confirm('Вы действительно хотите удалить всю историю по карте?'))
    {
        var discount_id = $('#discount_id').val();
        var success = function(data)
                        {
                            stopLoading();
                            $('#bg_cont_list_historys').html(data);
                        };
        make_ajax('', 'html', 'discounthistory/clear_discounthistory/'+discount_id, '', success);
    }
}

function getSendSms(obj)
{
    var client_id = $('#client_id').val();
    var order_id = $(obj).attr('order_id');
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").modal('show');
                        $('#bg_cont_order_add').html(data);
                    };
    var data = 'order_id='+order_id;
    make_ajax('post', 'html', 'order/get_send_sms/', data, success);
}

function sendSms(obj)
{
    var order_id = $('#send_sms_order_id').val();
    var client_id = $('#send_sms_client_id').val();
    var phone_number = $('#phone_number').val();
    var message = $('#message').val();
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_block").on('hidden.bs.modal', function(){
                            //getClientList(client_id, 0);
                          });
                        $('.alert').remove();
                        $("#bg_cont_order_block").modal('hide');
                        $('#bg_cont_list_orders').html(data);
                        getOrder(client_id, 1);
                    };
    var data = 'client_id='+client_id+'&phone_number='+phone_number+'&message='+message+'&order_id='+order_id;
    make_ajax('post', 'html', 'order/send_sms/', data, success);
}

function getClientHistorySearch(obj)
{
    var history = $(obj).val().toLowerCase();

    $(".bg_cont_history_lists table tbody tr").each(function (i) {
        if ($(this).text().toLowerCase().indexOf(history)==-1)
        {
            $(this).hide();
        }
        else
        {
            $(this).show();
        }
    });
    $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
    $('#bg_cont_history_list').html('<div class="alert alert-info alert-min">Клиент не выбран</div>');
}

function getClientDeliverySmsSearch(obj)
{
    var delivery = $(obj).val().toLowerCase();

    $(".client_tbody_lists table tbody tr").each(function (i) {
        if ($(this).text().toLowerCase().indexOf(delivery)==-1)
        {
            $(this).hide();
        }
        else
        {
            $(this).show();
        }
    });
    $('.client_tbody_lists table tbody tr input[type="checkbox"]').attr('checked', false);
}

function getHistory(obj)
{
    var client_id = 0;
    if(obj != null)
    {
        client_id = $(obj).attr('client_id');
    }
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        if(client_id != 0)
                        {
                            $(obj).addClass('bg_cont_list_tr_select');
                        }
                        $('#bg_cont_history_list').html(data);
                    };
    make_ajax('', 'html', 'historysms/get_history/'+client_id, '', success);
}

function getSendSmsOne(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_history_block").modal('show');
                        $('#bg_cont_history_send').html(data);
                    };
    make_ajax('', 'html', 'historysms/get_send_sms_one/', '', success);
}

function sendSMSOne()
{
    var phone_number = $('#phone_number').val();
    var message = $('#message').val();
    var success = function(data)
                    {
                        stopLoading();
                        $('.alert').remove();
                        $("#bg_cont_history_block").modal('hide');
                        $('#bg_cont_history_list').html(data);
                    };
    var data = 'phone_number='+phone_number+'&message='+message;
    make_ajax('post', 'html', 'historysms/send_sms_one/', data, success);
}

function getDeliverySMS(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_history_block").modal('show');
                        $('#bg_cont_history_send').html(data);
                        $('#history_client_table_check tr').shifty({
                                className:'select', // класс выделенного элемента
                                select:function(el){el.find(':checkbox').prop('checked','checked');}, // выделение
                                unselect:function(el){el.find(':checkbox').removeAttr('checked');} // снятие выделения
                        });
                    };
    make_ajax('', 'html', 'historysms/get_delivery_sms/', '', success);
}

function deliverySMS()
{
    var message = $('#delivery_sms_message').val();
    var comment = $('#comment_sms_message').val();
    var phone_number = '';
    $('.history_client_tbody_check:checkbox:checked').each(function (i) {
        if($(this).attr('phone_number'))
        {
            phone_number = phone_number + 'phone_number[]=' + $(this).attr('phone_number') + '&';
        }
    });
    if(phone_number == '')
    {
        alert('Выберите клиентов для рассылки!');
    }
    else
    {
        var success = function(data)
                        {
                            stopLoading();
                            $('.alert').remove();
                            $("#bg_cont_history_block").modal('hide');
                            $('#bg_cont_history_list').html(data);
                        };
        var data = phone_number+'message='+message+'&comment='+comment;
        make_ajax('post', 'html', 'historysms/delivery_sms/', data, success);
    }
}

function getOrderSearch()
{
    var order_id = $('#search_order').val();
    var success = function(data)
                    {
                        stopLoading();
                        if(data != 'undefined' && data.client_fio != 'undefined')
                        {
                            $('#search_client').val(data.client_fio);
                            $('#search_client').keypress();
                        }
                    };
    make_ajax('', 'json', 'json/get_order/' + order_id, '', success);
}

function getOrderSearchABCP()
{
    var order_abcp_id = $('#search_order_abcp').val();
    var success = function(data)
                    {
                        stopLoading();
                        if(data != 'undefined' && data.client_fio != 'undefined')
                        {
                            $('#search_client').val(data.client_fio);
                            $('#search_client').keypress();
                        }
                    };
    make_ajax('', 'json', 'json/get_order_abcp/' + order_abcp_id, '', success);
}


function checkAll(obj)
{
    $('.check_auto_order').prop('checked', obj.checked);
}

function Load()
{
    $('#search_order').keydown(function (e) {
        if (e.keyCode == 13) 
        {
            getOrderSearch();
        }
    });

    $('#search_client').keydown(function (e) {
        if (e.keyCode == 13) 
        {
            $('#search_client').keypress();
        }
    });
}

function orderAddAbcpRow()
{
    var client_id = $('#client_id').val();
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_order_abcp_block").modal('show');
                        $('#bg_cont_order_add_abcp').html(data);
                    };
    make_ajax('', 'html', 'order/order_add_abcp/'+client_id, '', success);
}

function orderAddAbcp()
{
    var number_id = $('#order_abcp_number').val();
    var success = function(data)
                    {
                        stopLoading();
                        if(data.data.positions != '')
                        {
                            data.data.positions.forEach(function(item, i) {
                                if(i > 0) orderAddRow();
                                $('.order_lists:last').find('textarea[order_cod=order_comment]').val(item.brand+' / '+item.number+' / '+item.description);
                                $('.order_lists:last').find('input[order_cod=order_count]').val(item.quantity);
                                $('.order_lists:last').find('input[order_cod=order_sum]').val(item.priceOut);
                            });
                             $('#order_abcp_id').val(data.data.number);                            
                            setOrderAllSum();
                        }
                        $("#bg_cont_order_abcp_block").modal('hide');                        
                    };
    make_ajax('', 'json', 'json/get_emex_abcp/'+number_id, '', success);
}

$(function() {
    Load();
});
