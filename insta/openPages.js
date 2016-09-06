$(document).ready(function() {
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
    /**
     * "._4gt3b" - ul wrapper
     * "._539vh" - ul list of all followers
     * "._cx1ua" - li item of follower
     * "._5lote" - a where in href link to this follower
     * @type {Array}
     */
    var Users = [];
    var Users_count = 0;
    var User_current = 0;
    var NextUserLink = "";
    function GetFromLocalStorage() {
        if (typeof(Storage) !== "undefined") {
            Users = JSON.parse(localStorage.getItem("AllUsers"));
        }
        Users_count = Users.length;
    }
    function GetTime() {
        var day = new Date();
        var min = day.getMinutes();
        var sec = day.getSeconds();
        var time = "Time at this moment: "+min+":"+sec;
        // console.log("Time at this moment: "+min+":"+sec);
        return time;
    }
    function randSec() {
        /**
         * Return random number from 1 to 10
         * @type {number}
         */
        var rand = Math.ceil(Math.random()*10);
        return rand;
    }
    function randHalfSec() {
        /**
         * Return random number from 1 to 5
         * @type {number}
         */
        var rand = Math.ceil(Math.random()*5);
        return rand;
    }
    function RepeatUser() {
        var NextUserTime = (randSec()*15000)+60000;
        User_current++;
        console.log("User_current: "+User_current+" NextUserTime: "+NextUserTime);
        console.log(GetTime());
        if (User_current<Users_count) {
            setTimeout(function () {
                OpenUser();
            },NextUserTime);
        } else {
            console.log("End User in DB");
        }
    }
    function OpenUser() {
        var url = "https://www.instagram.com";
        var UserLink = Users[User_current].link;
        NextUserLink = url+UserLink;
        // console.log(link);
        setTimeout(function () {
            console.log(NextUserLink);
            window.open(
                NextUserLink,
                '_blank' // <- This is what makes it open in a new window.
            );
        },500);
        RepeatUser();
    }
    function start() {
        GetFromLocalStorage();
        OpenUser();
    }
    start();
});