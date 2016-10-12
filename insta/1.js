(function() {
    var class_user_page = '._42elc'; // class of user page
    var class_user_photo = '._8mlbc'; // class of user visible photo on user page
    var class_user_close = '._76rrx'; // Class when user close his account to watch
    var class_user_list_pff = 'ul'; // Class of ul where u can get photo, followers and follow
    var class_user_photos = class_user_page + ' ' + class_user_list_pff + ' li:nth-child(1) span span'; // class of user followers in user page where u can get count
    var class_user_followers = class_user_page + ' ' + class_user_list_pff + ' li:nth-child(2) a span'; // class of user followers in user page
    var class_user_follows = class_user_page + ' ' + class_user_list_pff + ' li:nth-child(3) a span'; // class of user follows in user page
    var class_popup = '._a1rcs'; // class of popup
    var class_popup_photo = class_popup + ' article'; // Class if on popup show photo
    var class_popup_close = '._a1rcs'; // Class of close button on popup
    var class_popup_follow_ul_wrap = class_popup + ' ._4gt3b'; // Class of ul wrapper in followers popup
    var class_popup_follow_description = '._2uju6'; // Class of div where write name of user
    var class_popup_follow_link = '._5lote'; // Class of div where write name of user
    var class_click_like = '.coreSpriteHeartOpen'; // class to like if you don`t like it before
    var class_click_dislike = '.coreSpriteHeartFull'; // class to dislike if you like it before
    var class_btn_need_follow_on_user = '._2hpcs'; // Class on btn if you don`t follow on user
    var class_btn_follow_on_user = '._r4e4p'; // Class on btn if you follow on user
    var DB_name = "bazar25";
    function user() {
        this.id = "";
        this.title = "";
        this.name = "";
        this.link = "";
    };
    var Users = [];
    var i = 0;
    $('._539vh').find('._cx1ua').each(function () {
        var name = $(this).find(class_popup_follow_description).text();
        var title = $(this).find(class_popup_follow_link).text();
        var link = $(this).find(class_popup_follow_link).attr("href");
        var myUser = new user();
        myUser.id = i;
        myUser.title = title;
        myUser.name = name;
        myUser.link = link;
        Users.push(myUser);
        i++;
    });

    function run() {
        if (typeof(Storage) !== "undefined") {
            localStorage.setItem(DB_name, JSON.stringify(Users));
        }
    }
    run();
})();