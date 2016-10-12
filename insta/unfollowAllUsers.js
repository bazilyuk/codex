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
    function randSec() {
        /**
         * Return random number from 1 to 10
         * @type {number}
         */
        var rand = Math.ceil(Math.random()*3);
        return rand;
    }
    function ClosePopup() {
        /**
         * Close popup
         */
        if ($(class_popup_close)) {
            $(class_popup_close).click();
        }
        $('body').click();
        setTimeout(function () {
            $('body').click();
        },100);
    }
    function refreshPage() {
        /**
         * 6
         * Unfollow on all user
         */
        ClosePopup();
        location.reload();
    }
    function clearStorage() {
        if (typeof(Storage) !== "undefined") {
            console.log("storage");
            for (var i = 0, len = localStorage.length; i < len; i++) {
                var key = localStorage.key(i);
                var value = localStorage[key];
                console.log(value);
                var word = "bz";
                if (key.indexOf(word) !== -1) {
                    localStorage.setItem(key, "[]");
                    console.log("Clear Storage");
                }
            }
            localStorage.clear();
        }
    }
    function unfollowUser(i) {
        $(class_popup_follow_ul_wrap).find('li:nth-child('+i+')').each(function () {
            var title = $(this).find(class_popup_follow_name).text();
            i++;
            console.log(i+")name: "+title);
            $(this).find(class_btn_follow_on_user).click();
            setTimeout(function () {
                clearStorage();
                ClosePopup();
                clearStorage();
            },800);
            setTimeout(function () {
                clearStorage();
                $(class_user_follows).click();
                clearStorage();
            },1600);
            setTimeout(function () {
                clearStorage();
            },8000);
        });
    }
    function unfollowUsers() {
        var i = 1;
        var btnCount = $(class_btn_follow_on_user).length;
        console.log("btnCount: "+btnCount);
        function repeat() {
            var time = (randSec()+3)*3000;
            if (i <= btnCount) {
                unfollowUser(i);
                i++;
                setTimeout(function () {
                    repeat();
                },time);
            } else {
                refreshPage();
            }
        }
        repeat();
    }
    function scrollUsers() {
        /**
         * 4
         * scroll down in popup
         */
        $(class_popup_follow_ul_wrap).scrollTop(1000000000000000000000000);
        var scrTop = $(class_popup_follow_ul_wrap).scrollTop();
        return scrTop;
    }
    function ShowScrollUsers() {
        /**
         * 3 5
         * This function Scroll popup to the end to show all users
         */
        var a = 0; var b = 1; var i = 0; var y = 0;
        var topArray = [];
        var time1 = 400+y*100;
        function repeat() {
            setTimeout(function () {
                topArray[i] = scrollUsers();
            },time1);
        }
        if ($(class_popup)[0]) {
            var timerId = setTimeout(function go() {
                repeat();
                i++;
                console.log("a: "+topArray[topArray.length-2]+" b: "+topArray[topArray.length-1]+" i: "+i);
                if (i<200) {
                    if (i>2) {
                        if (topArray[topArray.length-2] != topArray[topArray.length-1]) {
                            y = 0;
                            setTimeout(go, time1+200);
                        } else {
                            y++;
                            if (y>3) {
                                setTimeout(deleteFollows(), 1800);
                            } else {
                                setTimeout(go, time1+200);
                            }
                        }
                    } else {
                        setTimeout(go, time1+200);
                    }
                    console.log(y);
                } else {
                    deleteFollows();
                }
            }, 100);
        } else {
            console.log("popup not open");
        }
    }
    function workWithFollowers(tag, count) {
        /**
         * 2
         * This function open popups with followers or follows
         */
        console.log(count);
        if (count != "0") {
            $(tag).click();
            setTimeout(function () {
                // ShowScrollUsers();
                unfollowUsers();
            },500);
        } else {
            console.log("This user don`t have followers");
        }
    }
    function OpenFollows() {
        /**
         * 1
         * Open popup with follows
         */
        var followsCount = $(class_user_follows).text();
        workWithFollowers(class_user_follows, followsCount);
    }
    function FollowOnUser() {
        $(class_btn_need_follow_on_user).click();
    }
    function StartUnfollow() {
        FollowOnUser();
        /**
         * 0
         * Start
         */
        console.log("Move 0: Start");
        OpenFollows();
    }
    StartUnfollow();
});