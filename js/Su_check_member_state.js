function check_member_stste(){
    //利用cookie uid確認登入狀態
    if (getCookie("UID01") != "" && getCookie("UID02") != "" && getCookie("UID03") != "") {
        //傳遞至後端驗證 UID
        var jsonData = {};
        jsonData["uid01"] = getCookie("UID01");
        jsonData["uid02"] = getCookie("UID02");
        jsonData["uid03"] = getCookie("UID03");
        console.log(JSON.stringify(jsonData));
        $.ajax({
            type: "POST",
            url: "plant_mem_uid_check_api.php",
            data: JSON.stringify(jsonData),
            dataType: "json",
            success: showdata_uid_check,
            error: function () {
                alert("error-plant_mem_uid_check_api.php");
            }
        });
    }else {
        //uid驗證失敗
        alert("請先登入或註冊會員!");
        location.href = "plant.SPA.html";
    }
    
    //登出按鈕logout_btn監聽
    $("#logout_btn").bind("click",function(){
        setCookie("UID01", "", 7);
        setCookie("UID02", "", 7);
        setCookie("UID03", "", 7);
        location.href="plant.SPA.html";
    });
};

function showdata_uid_check(data) {
    console.log(data);
    if (data.state) {
        //將URL中的查詢參數解析為javascript中的對象
        var currentParams = {};//宣告陣列來儲存參數
        var currentUrl = window.location.href;
        var currentParts = currentUrl.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
            //m為match是整個匹配到的字串
            currentParams[key] = value;
            console.log(value);//會顯示帳號名
        });
        //網址username對應到的值
        var loadedParams = {username: data.data[0].Username};//直接寫成陣列來判斷

        //判斷是否已重新載入（需要將以上陣列轉字串）
        if (JSON.stringify(currentParams) === JSON.stringify(loadedParams)) {
            console.log('已重新載入');
        } else {
            var url = currentUrl.split("=")[0];
            console.log(currentUrl.split("=")[0]);
            location.href = url+'='+data.data[0].Username;
            console.log('第一次載入');
        }
        //uid驗證成功
        //顯示會員帳號相關訊息
        if (data.data[0].UserState == "y") {
            //帳號為啟用狀態
            $("#login_member").text(data.data[0].Username + "會員您好!");
            $("#premission").css("color", "#8dbd95");
            $("#login_member").css("color", "#e7dba6");
        } else {
            alert("帳號已被停權");
            $("#premission").css("color", "#e7aaa6");
            $("#login_member").css("color", "#BEBEBE");
            location.href = "plant.SPA.html";
        }
    } else {
        //uid驗證失敗
        alert("請先登入或註冊會員!");
        location.href = "plant.SPA.html";
    }
}

//form w3c
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));//使用毫秒
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}