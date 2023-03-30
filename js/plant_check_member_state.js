//確認會員登入狀態
//會員名稱 設定為 #login_member
//登出按鈕 設定為 #logout_btn
//用於管理者及使用者的驗證(全部)

function check_member_state(){
    //利用cookie uid確認登入狀態
    if(getCookie("UID01") && getCookie("UID02")){
        if (getCookie("UID01") != "" && getCookie("UID02") != "" && getCookie("UID03") != "") {
        //傳遞至後端驗證 UID 
        //管理者
        var jsonData01 = {};
        jsonData01["uid01"] = getCookie("UID01");
        jsonData01["uid02"] = getCookie("UID02");
        jsonData01["uid03"] = getCookie("UID03");
        console.log(JSON.stringify(jsonData01));
        $.ajax({
            type: "POST",
            url: "plant_mem_uid_check_api.php",
            data: JSON.stringify(jsonData01),
            dataType: "json",
            success: showdata_uid_check,
            error: function () {
                alert("error-plant_mem_uid_check_api.php");
            }
        });
    }else{
        //使用者
        var jsonData02 = {};
        jsonData02["uid01"] = getCookie("UID01");
        jsonData02["uid02"] = getCookie("UID02");
        console.log(JSON.stringify(jsonData02));
        $.ajax({
            type: "POST",
            url: "Su_mem_uid_check_api.php",
            data: JSON.stringify(jsonData02),
            dataType: "json",
            success: showdata_Suuid_check,
            error: function () {
                alert("error-Su_mem_uid_check_api.php");
            }
        });
    }
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
//管理者
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
        $("#link").show();
        $("#main").show();
        $("#link_control").hide();
        $("#restaurantmap").show();
        if (data.data[0].UserState == "y") {
            //帳號為啟用狀態
            $("#login_member").text(data.data[0].Username +" 會員您好!");
            $("#premission").css("color", "#8dbd95");
            $("#login_member").css("color", "#e7dba6");
            $("#username_btn").removeClass("disabled");
            $("#name_btn").removeClass("disabled");
            $("#role_btn").removeClass("disabled");
            $("#ext_btn").removeClass("disabled");
            $("#email_btn").removeClass("disabled");
        } else {
            //帳號為停權狀態
            alert("帳號已被停權");
            $("#login_member").text(data.data[0].Username +" 會員您好!");
            $("#premission").css("color", "#e7aaa6");
            $("#login_member").css("color", "#4B4B4B");
            $("#username_btn").addClass("disabled");
            $("#name_btn").addClass("disabled");
            $("#role_btn").addClass("disabled");
            $("#ext_btn").addClass("disabled");
            $("#email_btn").addClass("disabled");
            $("#update_btn").css("pointer-events","none");
            $("#delete_btn").css("pointer-events","none");
            $("#update_btn").css("color", "#8D8686");
            $("#delete_btn").css("color", "#8D8686");
            $("#member_center").html('管理者會員中心<span class="text-danger">(已被停權)</span>');
            // location.href = "plant.SPA.html";
        }
     } else {
        //uid驗證失敗
        alert("請先登入或註冊會員!");
        location.href = "plant.SPA.html";
    }
}
//使用者
function showdata_Suuid_check(data) {
    console.log(data);
    if (data.state) {
        $("#link").hide();

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
            $("#username_btn").removeClass("disabled");
            $("#gender_btn").removeClass("disabled");
            $("#city_btn").removeClass("disabled");
            $("#tel_btn").removeClass("disabled");
            $("#email_btn").removeClass("disabled");
           
        } else {
            alert("帳號已被停權");
            $("#login_member").text(data.data[0].Username + "會員您好!");
            $("#premission").css("color", "#e7aaa6");
            $("#login_member").css("color", "#4B4B4B");
            $("#username_btn").addClass("disabled");
            $("#gender_btn").addClass("disabled");
            $("#city_btn").addClass("disabled");
            $("#tel_btn").addClass("disabled");
            $("#email_btn").addClass("disabled");
            //pointer-events：none為不能點選
            $("#update_btn").css("pointer-events","none");
            $("#delete_btn").css("pointer-events","none");
            $("#update_btn").css("color", "#8D8686");
            $("#delete_btn").css("color", "#8D8686");
            $("#ok_btn").css("pointer-events","none");
            $("#ok_btn").text("不得新增");
            $("#ok_btn").css("color", "#8D8686");
            $("#user_center").html('會員中心<span class="text-danger">(已被停權)</span>');
            // location.href = "plant.SPA.html";
        }
    } else {
        //uid驗證失敗
        alert("請先登入或註冊會員!");
        location.href = "plant.SPA.html";
    }
}

//from w3school
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