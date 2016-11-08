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
    var class_popup_follow_link = '._5lote'; // Class of div where write href of user
    var class_popup_follow_name = '._4zhc5'; // Class of div where write name of user
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
    var DB_name = "testtest";
    var Users_before = [];
    var Users_follow = [];
    var Users_unfollow = [];


    var Users = [];
    var Users_count = 0;
    var Users_count_before = 0;
    var Users_count_unfollow = 0;
    var User_current = 0;
    var NextUserLink = "";

    function GetFollowUser() {
        /**
         * 1
         * Get User that we follow from File
         */
        $.ajax({
            /**
             * Get all data file
             */
            type: 'POST',
            url: 'https://insta.bazar25.com.ua/',
            data: {
                file: DB_name,
                property: "read"
            },
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            dataType: 'html',
            success: function (e) {
                Users_follow = JSON.parse(e);
                console.log("Users_before: ");
                console.log(Users_follow);
                Users_count = Users_follow.length;
                console.log("Users: " + Users_count);
                GetBeforeUser();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function GetBeforeUser() {
        /**
         * 2
         * Get Followers that was before
         */
        var before_file = DB_name + "_follow_before";
        $.ajax({
            /**
             * Get Followers that was before file
             */
            type: 'POST',
            url: 'https://insta.bazar25.com.ua/',
            data: {
                file: before_file,
                property: "read"
            },
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            dataType: 'html',
            success: function (e) {
                Users_before = JSON.parse(e);
                console.log("Users_before: ");
                console.log(Users_before);
                Users_count_before = Users_before.length;
                console.log("Users: " + Users_count_before);
                createUnfollowUsers();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function createUnfollowUsers() {
        /**
         * 3
         * Create Unfollowers list
         */
        if (Users_follow) {
            if (Users_before) {
                Users_unfollow = Users_follow.filter(function(x) { return Users_before.indexOf(x) < 0 })
            } else {
                Users_unfollow = Users_follow;
            }
            SaveUnfollowUsers();
        }
    }
    function SaveUnfollowUsers() {
        var unfollow_file = DB_name + "_unfollow";
        /**
         *4
         * Save unfollowers list to file
         * name off database - this is name of this file
         */
        $.ajax({
            type: 'POST',
            url: 'https://insta.bazar25.com.ua/index.php',
            crossDomain: true,
            data: {
                file: unfollow_file,
                property: "update",
                data: JSON.stringify(Users_unfollow)
            },
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            dataType: 'html',
            success: function(e){
                console.log(e);
                console.log("save to file.");
                console.log("count: "+Users_unfollow.length);
                console.log("Users_unfollow: ");
                console.log(Users_unfollow);
            },
            error: function(xhr, ajaxOptions, thrownError){
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    function start() {
        /**
         * 0
         * start script
         */
        GetFollowUser();
    }
    start();
});