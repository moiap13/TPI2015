function showPwd()
{
    var tbx_pwd = document.getElementById('tbx_pwd');
    var tbx_pwd_2 = document.getElementById('tbx_pwd_2');
    var ckb_show_pwd = document.getElementById('ckb');

    if(ckb_show_pwd.checked)
    {
        tbx_pwd.type = "text";
        tbx_pwd_2.type = "text";
    }
    else
    {
        tbx_pwd.type = "password";
        tbx_pwd_2.type = "password";
    }

    tbx_pwd.focus();
}

function submit()
{
    document.form.submit();
}