window.onload=function(){
    code();
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
        };
};

