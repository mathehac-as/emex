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

function getUser(obj)
{
    var user_id = $(obj).attr('user_id');
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_user_list').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        $(obj).addClass('bg_cont_list_tr_select');
                    }
    make_ajax('', 'html', 'user/get_user/'+user_id, '', success);
}

function getUserList()
{
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list').html(data);
                    };
    make_ajax('', 'html', 'user/get_user_list/', '', success);
}

function userUpdate(obj)
{
    var user_id = $(obj).parent().parent().attr('user_id');
    var fio = $('#fio').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var office_id = $('#office_id').val();
    var is_active = $('#is_active').prop("checked");
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_user_list').html(data);
                        getUserList();
                    };
    var data = 'action=edit&fio='+fio+'&username='+username+'&password='+password+'&office_id='+office_id+'&is_active='+is_active;
    make_ajax('post', 'html', 'user/save_user/'+user_id, data, success);
}

function userSave(obj)
{
    var fio = $('#fio').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var office_id = $('#office_id').val();
    var is_active = $('#is_active').prop("checked");
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_user_list').html(data);
                        getUserList();
                    };
    var data = 'action=add&fio='+fio+'&username='+username+'&password='+password+'&office_id='+office_id+'&is_active='+is_active;
    make_ajax('post', 'html', 'user/save_user/', data, success);
}

function userDel(obj)
{
    var user_id = $(obj).parent().parent().attr('user_id');
    if(typeof user_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $('#bg_cont_user_list').html(data);
                            getUserList();
                        };
        make_ajax('', 'html', 'user/del_user/'+user_id, '', success);
    }
    else
    {
        alert('Выберите пользователя из списка!');
    }
}

function userAdd(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_user_list').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                    };
    make_ajax('', 'html', 'user/user_add/', '', success);
}

function userCansel(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_user_list').html(data);
                    };
    make_ajax('', 'html', 'user/get_user/', '', success);
}

function userEmexEdit(obj)
{
    var user_id = $(obj).parent().parent().attr('user_id');
    if(typeof user_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $('#bg_cont_user_emex_block').modal('show');
                            $('#bg_cont_user_emex_edit').html(data);
                        };
        make_ajax('', 'html', 'user/user_edit_emex/'+user_id, '', success);
    }
    else
    {
        alert('Выберите пользователя из списка!');
    }
}

function userEmexSave(obj)
{
    var user_id = $('#user_id').val();
    var emex_id = $('#emex_id').val();
    var emex_pass = $('#emex_pass').val();
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_user_emex_block').modal('hide');
                        $('#bg_cont_user_list').html(data);
                    };
    var data = 'action=emex_edit&emex_id='+emex_id+'&emex_pass='+emex_pass;
    make_ajax('post', 'html', 'user/save_user/'+user_id, data, success);
}

function getOfficeList()
{
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list_offices').html(data);
                    };
    make_ajax('', 'html', 'officelist/get_office_list/', '', success);
}

function officeAdd(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_offices_block").modal('show');
                        $('#bg_cont_offices_add').html(data);
                    };
    make_ajax('', 'html', 'office/office_add/', '', success);
}

function officeEdit(obj)
{
    var office_id = $(obj).parent().attr('office_id');
    if(typeof office_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $("#bg_cont_offices_block").modal('show');
                            $('#bg_cont_offices_add').html(data);
                        };
        make_ajax('', 'html', 'office/office_edit/'+office_id, '', success);
    }
    else
    {
        alert('Выберите офис из списка!');
    }
}

function officeUpdate(obj)
{
    var office_id = $('#office_id').val();
    var name = $('#name').val();
    var phone = $('#phone').val();
    var comment = $('#comment').val();
    var data = 'action=edit&name='+name+'&phone='+phone+'&comment='+comment;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_offices_block").on('hidden.bs.modal', function(){
                            getOfficeList();
                          });
                        $("#bg_cont_offices_block").modal('hide');
                        $('#bg_cont_user_list').html(data);
                    };
    make_ajax('post', 'html', 'office/save_office/'+office_id, data, success);
}

function officeSave(obj)
{
    var name = $('#name').val();
    var phone = $('#phone').val();
    var comment = $('#comment').val();
    var data = 'action=add&name='+name+'&phone='+phone+'&comment='+comment;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_offices_block").on('hidden.bs.modal', function(){
                            getOfficeList();
                          });
                        $("#bg_cont_offices_block").modal('hide');
                        $('#bg_cont_user_list').html(data);
                    };
    make_ajax('post', 'html', 'office/save_office/', data, success);
}

function officeDel(obj)
{
    var office_id = $(obj).parent().attr('office_id');
    if(typeof office_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $('#bg_cont_user_list').html(data);
                            getOfficeList();
                        };
        make_ajax('post', 'html', 'office/del_office/'+office_id, '', success);
    }
    else
    {
        alert('Выберите офис из списка!');
    }
}

function officeLink(obj)
{
    var office_id = $(obj).parent().attr('office_id');
    if(typeof office_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $("#bg_cont_offices_block").modal('show');
                            $('#bg_cont_offices_add').html(data);
                        };
        make_ajax('', 'html', 'office/office_link/'+office_id, '', success);
    }
    else
    {
        alert('Выберите офис из списка!');
    }
}

function officeLinkSave(obj)
{
    var office_id = $('#office_link_id').val();
    var group_id = $('#office_link_group_id').val();
    var data = 'action=link&&group_id='+group_id;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_offices_block").on('hidden.bs.modal', function(){
                            getOfficeList();
                          });
                        $("#bg_cont_offices_block").modal('hide');
                        $('#bg_cont_user_list').html(data);
                    };
    make_ajax('post', 'html', 'office/save_office/'+office_id, data, success);
}

function officeUnlink(obj)
{
    var office_id = $(obj).parent().attr('office_id');
    if(typeof office_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $('#bg_cont_user_list').html(data);
                            getOfficeList();
                        };
        make_ajax('post', 'html', 'office/save_office/'+office_id, 'action=unlink', success);
    }
    else
    {
        alert('Выберите офис из списка!');
    }
}

function getOfficeCash(obj, type)
{
    var office_id = $(obj).parent().parent().attr('office_id');
    var data = 'type='+type;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_offices_block").modal('show');
                        $('#bg_cont_offices_add').html(data);
                    };
    make_ajax('post', 'html', 'officecash/get_cash/'+office_id, data, success);
}

function officeCashSave(obj)
{
    var office_id = $('#cash_office_id').val();
    var type = $('#cash_office_type').val();
    var sum = $('#cash_office_sum').val();
    var comment = $('#cash_office_comment').val();
    var data = 'type='+type+'&sum='+sum+'&comment='+comment;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_offices_block").on('hidden.bs.modal', function(){
                            getOfficeList();
                          });
                        $("#bg_cont_offices_block").modal('hide');
                        $('#bg_cont_user_list').html(data);
                    };
    make_ajax('post', 'html', 'officecash/save_cash/'+office_id, data, success);
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
                            getOrder(client_id,0);
                        }
                        $('#bg_cont_client_list').html(data);
                        Load();
                    };
    make_ajax('', 'html', 'client/get_client/'+client_id, '', success);
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

function getClientList(client_id)
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
                            getOrder(client_id, 0);
                        }
                        else
                        {
                            $('#bg_cont_client_list').html('<div class="alert alert-info alert-min">Клиент не выбран</div>');
                        }
                        $('#bg_cont_list_orders').html('');
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
                            getClientList(client_id);
                          });
                        $("#bg_cont_client_block").modal('hide');
                        $('#bg_cont_client_list').html(data);
                    };
    make_ajax('post', 'html', 'client/save_client/'+client_id, data, success);
}

function getPrintOrder(obj)
{
    var link = $(obj).parent();
    var journal_id = link.parent().parent().attr('journal_id');
    link.attr('href', 'print/print_order/'+journal_id);
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

function setTypeoper(obj)
{
    $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
    $(obj).addClass('bg_cont_list_tr_select');
}

function getTypeoperList()
{
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list').html(data);
                    };
    make_ajax('', 'html', 'typeoperlist/get_typeoper_list/', '', success);
}

function typeoperAdd(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_typeoper_block").modal('show');
                        $('#bg_cont_typeoper_add').html(data);
                    };
    make_ajax('', 'html', 'typeoper/typeoper_add/', '', success);
}

function typeoperEdit(obj)
{
    var typeoper_id = $('.bg_cont_list_tr_select').attr('typeoper_id');
    if(typeof typeoper_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $("#bg_cont_typeoper_block").modal('show');
                            $('#bg_cont_typeoper_add').html(data);
                        };
        make_ajax('', 'html', 'typeoper/typeoper_edit/'+typeoper_id, '', success);
    }
    else
    {
        alert('Выберите операцию из списка!');
    }
}

function typeoperUpdate(obj)
{
    var typeoper_id = $('#typeoper_id').val();
    var name = $('#typeoper_name').val();
    var data = 'action=edit&name='+name;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_typeoper_block").on('hidden.bs.modal', function(){
                            getTypeoperList();
                          });
                        $("#bg_cont_typeoper_block").modal('hide');
                        $('#bg_cont_typeoper_list').html(data);
                    };
    make_ajax('post', 'html', 'typeoper/save_typeoper/'+typeoper_id, data, success);
}

function typeoperSave(obj)
{
    var name = $('#typeoper_name').val();
    var data = 'action=add&name='+name;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_typeoper_block").on('hidden.bs.modal', function(){
                            getTypeoperList();
                          });
                        $("#bg_cont_typeoper_block").modal('hide');
                        $('#bg_cont_typeoper_list').html(data);
                    };
    make_ajax('post', 'html', 'typeoper/save_typeoper/', data, success);
}

function typeoperDel(obj)
{
    var typeoper_id = $('.bg_cont_list_tr_select').attr('typeoper_id');
    if(typeof typeoper_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $('#bg_cont_typeoper_list').html(data);
                            getTypeoperList();
                        };
        make_ajax('post', 'html', 'typeoper/del_typeoper/'+typeoper_id, '', success);
    }
    else
    {
        alert('Выберите операцию из списка!');
    }
}

function setAccount(obj)
{
    $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
    $(obj).addClass('bg_cont_list_tr_select');
}

function getStatistic(obj)
{
    var statistic_id = 0;
    if(obj != null)
    {
        statistic_id = $(obj).attr('statistic_id');
    }
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_panel').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        $(obj).addClass('bg_cont_list_tr_select');
                    };
    make_ajax('', 'html', 'statistic/get_statistic/'+statistic_id, '', success);
}

function getUserSalary(obj)
{
    var user_id = $(obj).attr('user_id');
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_user_list').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        if(user_id != 0)
                        {
                            $(obj).addClass('bg_cont_list_tr_select');
                            getSalaryList(user_id);
                        }
                    };
    make_ajax('', 'html', 'salaryuser/get_user/'+user_id, '', success);
}

function getUserSalaryList()
{
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list').html(data);
                    };
    make_ajax('', 'html', 'salaryuserlist/get_user_list/', '', success);
}

function userSalarySave(obj)
{
    var fio = $('#user_fio').val();
    var position = $('#user_position').val();
    var phone = $('#user_phone').val();
    var office_id = $('#user_office').val();
    var passport = $('#user_passport').val();
    var date_birth = $('#user_date_birth').val();
    var number_card = $('#user_number_card').val();
    var email = $('#user_email').val();
    var comment = $('#user_comment').val();
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_salary_user_block").on('hidden.bs.modal', function(){
                            getUserSalaryList();
                          });
                        $("#bg_cont_salary_user_block").modal('hide');
                        $('#bg_cont_user_list').html(data);
                    };
    var data = 'action=add&fio='+fio+'&position='+position+'&phone='+phone+'&office_id='+office_id+'&passport='+passport+
               '&date_birth='+date_birth+'&number_card='+number_card+'&email='+email+'&comment='+comment;
    make_ajax('post', 'html', 'salaryuser/save_user/', data, success);
}

function userSalaryUpdate(obj)
{
    var user_id = $('#user_id').val();
    var fio = $('#user_fio').val();
    var position = $('#user_position').val();
    var phone = $('#user_phone').val();
    var office_id = $('#user_office').val();
    var passport = $('#user_passport').val();
    var date_birth = $('#user_date_birth').val();
    var number_card = $('#user_number_card').val();
    var email = $('#user_email').val();
    var comment = $('#user_comment').val();
    var data = 'action=edit&fio='+fio+'&position='+position+'&phone='+phone+'&office_id='+office_id+'&passport='+passport+
               '&date_birth='+date_birth+'&number_card='+number_card+'&email='+email+'&comment='+comment;;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_salary_user_block").on('hidden.bs.modal', function(){
                            getUserSalaryList();
                          });
                        $("#bg_cont_salary_user_block").modal('hide');
                        $('#bg_cont_user_list').html(data);
                    };
    make_ajax('post', 'html', 'salaryuser/save_user/'+user_id, data, success);
}

function userSalaryDel(obj)
{
    var user_id = $(obj).parent().parent().attr('user_id');
    if(typeof user_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $('#bg_cont_user_list').html(data);
                            getUserSalaryList();
                        };
        make_ajax('', 'html', 'salaryuser/del_user/'+user_id, '', success);
    }
    else
    {
        alert('Выберите сотрудника из списка!');
    }
}

function userSalaryAdd(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_salary_user_block").modal('show');
                        $('#bg_cont_salary_user_add').html(data);
                        $('#user_date_birth').datepicker({autoclose: true, language: 'ru'});
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                    };
    make_ajax('', 'html', 'salaryuser/user_add/', '', success);
}

function userSalaryEdit(obj)
{
    var user_id = $(obj).parent().parent().attr('user_id');
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_salary_user_block").modal('show');
                        $('#bg_cont_salary_user_add').html(data);
                        $('#user_date_birth').datepicker({autoclose: true, language: 'ru'});
                    };
    make_ajax('', 'html', 'salaryuser/user_edit/'+user_id, '', success);
}

function userSalaryCansel(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_user_list').html(data);
                    };
    make_ajax('', 'html', 'salaryuser/get_user/', '', success);
}

function salaryGive(obj)
{
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_salary_block").modal('show');
                        $('#bg_cont_salary_add').html(data);
                    };
    make_ajax('', 'html', 'salary/salary_add/', '', success);
}

function getSalaryList(user_id)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_list_salarys').html(data);
                    };
    make_ajax('', 'html', 'salary/get_salarys/'+user_id, '', success);
}

function salaryGiveSave(obj)
{
    var user_id = $('.bg_cont_list_tr_select').attr('user_id');
    var sum = $('#salary_sum').val();
    var office_id = $('#salary_office_id').val();
    var comment = $('#salary_comment').val();
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_salary_block").on('hidden.bs.modal', function(){
                            getSalaryList(user_id);
                          });
                        $("#bg_cont_salary_block").modal('hide');
                        $('#bg_cont_user_list').html(data);
                    };
    var data = 'action=add&user_id='+user_id+'&sum='+sum+'&office_id='+office_id+'&comment='+comment;
    make_ajax('post', 'html', 'salary/save_salary/', data, success);
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

function getUserAccess(obj)
{
    var user_id = $(obj).attr('user_id');
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_list_accesses').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        $(obj).addClass('bg_cont_list_tr_select');
                    }
    make_ajax('', 'html', 'access/get_accesses/'+user_id, '', success);
}

function setAccessUserCheck(obj)
{
    var user_id = $('.bg_cont_list_tr_select').attr('user_id');
    var access_id = $(obj).attr('access_id');
    var check = 0;
    if($(obj).prop('checked'))
    {
        check = 1;
    }
    var success = function(data)
                    {
                        stopLoading();
                        $('#msg_alert_access').html(data);
                    };
    var data = 'user_id='+user_id+'&access_id='+access_id+'&check='+check;
    make_ajax('post', 'html', 'access/access_check/', data, success);
}

function getSetting(obj)
{
    var settings_id = $(obj).attr('settings_id');
    var success = function(data)
                    {
                        stopLoading();
                        $('#bg_cont_list_settings').html(data);
                        $('.bg_cont_list_tr_select').removeClass('bg_cont_list_tr_select');
                        $(obj).addClass('bg_cont_list_tr_select');
                    }
    make_ajax('', 'html', 'settings/get_settings/'+settings_id, '', success);
}

function settingEdit(obj)
{
    var setting_id = $(obj).attr('setting_id');
    if(typeof setting_id != 'undefined')
    {
        var success = function(data)
                        {
                            stopLoading();
                            $("#bg_cont_settings_block").modal('show');
                            $('#bg_cont_settings_add').html(data);
                        };
        make_ajax('', 'html', 'settings/setting_edit/'+setting_id, '', success);
    }
    else
    {
        alert('Выберите настройку из списка!');
    }
}

function getSettingList(setting_id)
{
    var success = function(data)
                    {
                        stopLoading();
                        $('.bg_cont_list').html(data);
                        if(setting_id != 0)
                        {
                            $('.bg_cont_list_tr[settings_id = '+setting_id+']').removeClass('bg_cont_list_tr').addClass('bg_cont_list_tr_select');
                        }
                    };
    make_ajax('', 'html', 'settingslist/get_settings_list/', '', success);
}

function settingUpdate(obj)
{
    var setting_id = $('#setting_id').val();
    var comment = $('#setting_comment').val();
    var percent = $('#setting_percent').val();
    var sum = $('#setting_sum').val();
    var data = 'action=edit&comment='+comment+'&percent='+percent+'&sum='+sum;
    var success = function(data)
                    {
                        stopLoading();
                        $("#bg_cont_settings_block").on('hidden.bs.modal', function(){
                            getSettingList(setting_id);
                          });
                        $("#bg_cont_settings_block").modal('hide');
                        $('#bg_cont_list_settings').html(data);
                    };
    make_ajax('post', 'html', 'settings/save_setting/'+setting_id, data, success);
}

function getOrderList(obj)
{
    if($(obj).attr('status') == 'plus')
    {
        var item_id = $(obj).attr('item_id');
        var str_code = $('#statistic_str_code').val();
        var expand_tr = $(obj).parent('td').parent('tr');
        var data = 'str_code='+str_code;
        var success = function(data)
                        {
                            stopLoading();
                            $(obj).attr("status", "minus");
                            $(obj).attr("src","/img/minus.png");
                            expand_tr.after('<tr><td colspan="5">'+data+'</td></tr>');
                        }
        make_ajax('post', 'html', 'statistic/get_order_list/'+item_id, data, success);
    }
    else if($(obj).attr('status') == 'minus')
    {
        var expand_tr = $(obj).parent('td').parent('tr');
        $(obj).attr("status", "plus");
        $(obj).attr("src","/img/plus.png");
        $(expand_tr).next('tr').remove();
    }
}

function exportCSV(obj)
{
    var str_code = $('#statistic_str_code').val();
    window.open("action/export_csv/"+str_code);
    /*var success = function(data)
                    {
                        stopLoading();
                    };
    make_ajax('', 'html', 'action/export_csv/'+statistic_id, '', success);*/
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

$(function() {
    Load();
});