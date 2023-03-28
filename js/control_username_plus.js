//後台管理系統網址帳號名
function control_username_plus(){
    //取得網址參數
    var urlParams = new URLSearchParams(window.location.search);
    var username = urlParams.get('username');

    //回到首頁
    var myLink01 = document.getElementById('main');
    myLink01.href = 'plant.SPA.html?username=' + username;
    //會員資料
    var myLink02 = document.getElementById('memberinfo');
    myLink02.href = 'plant_mem_control_panel.html?username=' + username;
    //會員相關數據
    var myLink03 = document.getElementById('memberdata');
    myLink03.href = 'memberData.html?username=' + username;
    //會員種植資料
    var myLink04 = document.getElementById('plantlist');
    myLink04.href = 'plantlist.html?username=' + username;
    //合作店家
    var myLink05 = document.getElementById('mise');
    myLink05.href = '#?username=' + username;
    //合作專家
    var myLink06 = document.getElementById('expert');
    myLink06.href = '#?username=' + username;
    //聯絡內部
    var myLink07 = document.getElementById('employee');
    myLink07.href = 'employee.html?username=' + username;
}