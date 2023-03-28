function username_plus(){

    //取得網址參數
    var urlParams = new URLSearchParams(window.location.search);
    var username = urlParams.get('username');

    //管理者會員中心
    var mySLink = document.getElementById('main');
    mySLink.href = 'control_member.html?username=' + username;
    //使用者會員中心
    var myLink = document.getElementById('link_control');
    myLink.href = 'member.html?username=' + username;
    //新增植物
    var myLink01 = document.getElementById('link_control01');
    myLink01.href = 'newplant.html?username=' + username;
    //我的植物
    var myLink02 =  document.getElementById('link_control02');
    myLink02.href = 'plant.html?username=' + username;
    //新增日記
    var myLink03 = document.getElementById('link_control03');
    myLink03.href = '#?username=' + username;
    //我的日記
    var myLink04 = document.getElementById('link_control04');
    myLink04.href = '#?username=' + username;
    //小知識
    var myLink05 = document.getElementById('link_control05');
    myLink05.href = '#l?username=' + username;
    //口罩地圖
    var myLink06 = document.getElementById('maskmap');
    myLink06.href = '20230207_MaskMap.html?username=' + username;
    //餐飲資料地圖
    var myLink07 = document.getElementById('restaurantmap');
    myLink07.href = 'restaurant.html?username=' + username;
    //代辦事項
    var myLink08 = document.getElementById('todolist');
    myLink08.href = '20230306_todos.html?username=' + username;
    //管理者後台管理系統
    var myLink09 = document.getElementById('link');
    myLink09.href = 'plant_mem_control_panel.html?username=' + username;
}