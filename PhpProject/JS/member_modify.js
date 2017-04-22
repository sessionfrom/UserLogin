window.onload = function () {
    code();
    var fm = document.getElementsByTagName('form')[0];
    fm.onsubmit = function () {
        //密码验证
        if (fm.password.value !== '') {
            if (fm.password.value.length < 6) {
                alert('密码不得小于6位');
                fm.password.value = ''; //清空表单
                fm.password.focus(); //将焦点移动至表单
                return false;
            }
        }
        //电子邮件验证
        if(fm.email.value !== ''){
        if(!/^[\w\.\-]+@[\w\.\-]+(\.\w+)+$/.test(fm.email.value)){
            alert('电子邮件不合法!');
            //alert(/^[\w\.\-]+@[\w\.\-]+(\.\w+)+$/.test(fm.email.value));
            fm.email.value = ''; //清空表单
            fm.email.focus(); //将焦点移动至表单
            return false;
        }
    } else {
        alert('电子邮件为空！');
        }
        //QQ号码验证
        if(fm.qq.value !== ''){
        if(fm.qq.value.length < 5 || fm.qq.value.length > 10){
            alert('QQ号码位数不合法');
            fm.qq.value = ''; //清空表单
            fm.qq.focus(); //将焦点移动至表单
            return false;
        }
        if(!/^[1-9]{1}[0-9]{4,9}$/.test(fm.qq.value)){
            alert('QQ号码不合法');
            fm.qq.value = ''; //清空表单
            fm.qq.focus(); //将焦点移动至表单
            return false;
        }
    }
        //主页地址验证
        if(fm.url.value !== ''){
        if(!/^https?:\/\/(\w+\.)?[\w\.\-]+(\.\w+)+$/.test(fm.url.value)){
            alert('主页地址不合法');
            fm.url.value = ''; //清空表单
            fm.url.focus(); //将焦点移动至表单
            return false;
        }
    }
        //验证码长度验证
        if(fm.yzm.value.length !== 4){
            alert('验证码长度不正确');
            fm.yzm.value = ''; //清空表单
            fm.yzm.focus(); //将焦点移动至表单
            return false;
        }
        return true;
    };
};

