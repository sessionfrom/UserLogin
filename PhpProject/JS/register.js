window.onload=function(){
    code();
    var _faceimg = document.getElementsById('faceimg');
//    var code = document.getElementById('code');
    _faceimg.onclick = function() {
        window.open('face.php','_blank','width:200,height=200,top=0,left=0');
    };
//    code.onclick = function(){
//        this.src='code.php?tm='+Math.random();
//    };
    //表单验证
    var fm = document.getElementsByTagName('form')[0];
    fm.onsubmit = function(){
        //用户名验证
        if(fm.username.value.length < 2 || fm.username.value.length > 20){
            alert('用户名长度不能小于两位或者大于二十位！');
            fm.username.value = ''; //清空表单
            fm.username.focus(); //将焦点移动至表单
            return false;
        }
        if(/[<>\'\"\ \　]/.test(fm.username.value)){
            alert('用户名不得包含非法字符！');
            fm.username.value = ''; //清空表单
            fm.username.focus(); //将焦点移动至表单
            return false;
        }
        //密码验证
        if(fm.password.value.length < 6){
            alert('密码不得小于6位');
            fm.password.value = ''; //清空表单
            fm.password.focus(); //将焦点移动至表单
            return false;
        }
        //密码确认验证
        if(fm.password.value !== fm.notpassword.value){
            alert('密码和密码确认必须一致');
            fm.notpassword.value = ''; //清空表单
            fm.notpassword.focus(); //将焦点移动至表单
            return false;
        }
        //密码提示验证
        if(fm.hint.value.length < 3 || fm.hint.value.length > 20){
            alert('密码提示不得小于3位或者大于20位');
            fm.hint.value = ''; //清空表单
            fm.hint.focus(); //将焦点移动至表单
            return false;
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
