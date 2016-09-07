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
    var DB_name = "AllUsers";
    var UsersOld = [];
    var Users = [];
    var openFollows = false;
    function user() {
        this.id = "";
        this.title = "";
        this.name = "";
        this.link = "";
    };
    function ClosePopup() {
        /**
         * Close popup
         */
        if ($(class_popup_close)) {
            $(class_popup_close).click();
        }
    }
    function SaveToLocalStorage() {
        ClosePopup();
        if (typeof(Storage) !== "undefined") {
            localStorage.setItem(DB_name, JSON.stringify(Users));
        }
        if (!openFollows) {
            OpenFollows();
        } else {
            console.log("finish!");
        }
    }
    function GetFromLocalStorage() {
        if (typeof(Storage) !== "undefined") {
            UsersOld = JSON.parse(localStorage.getItem(DB_name));
        }
    }
    function checkUser(myUser) {
        var inDB = false;
        for (var i=0;i<UsersOld.length;i++) {
            if (UsersOld[i].link == myUser.link) {
                inDB = true;
            }
        }
        return inDB;
    }
    function saveFollowers() {
        if (UsersOld) {
            var i = UsersOld.length;
        } else {
            var i = 0;
        }
        $(class_popup_follow_ul_wrap).find('li').each(function () {
            var name = $(this).find(class_popup_follow_description).text();
            var title = $(this).find(class_popup_follow_link).text();
            var link = $(this).find(class_popup_follow_link).attr("href");
            var myUser = new user();
            myUser.id = i;
            myUser.title = title;
            myUser.name = name;
            myUser.link = link;
            if (UsersOld) {
                if (!checkUser(myUser)) {
                    UsersOld.push(myUser);
                    i++;
                }
            } else {
                Users.push(myUser);
                i++;
            }
        });
        if (UsersOld) {
            Users = UsersOld;
        }
        console.log(Users);
        SaveToLocalStorage();
    }
    function scrollUsers() {
        $(class_popup_follow_ul_wrap).scrollTop(1000000000000000000000000);
        var scrTop = $(class_popup_follow_ul_wrap).scrollTop();
        return scrTop;
    }
    function ShowScrollUsers() {
        var a = 0; var b = 1; var i = 0; var y = 0;
        function repeat() {
            setTimeout(function () {
                a = scrollUsers();
            },300);
            // a = scrollUsers();
            setTimeout(function () {
                b = scrollUsers();
            },900);
        }
        if ($(class_popup)[0]) {
            var timerId = setTimeout(function go() {
                repeat();
                i++;
                console.log("a: "+a+" b: "+b+" i: "+i);
                if (a != b) {
                    y = 0;
                    setTimeout(go, 1500);
                } else {
                    y++;
                    if (y>3) {
                        setTimeout(saveFollowers(), 1800);
                    } else {
                        setTimeout(go, 1500);
                    }
                }
            }, 100);
        } else {
            console.log("popup not open");
        }
    }
    function workWithFollowers(tag, count) {
        GetFromLocalStorage();
        console.log(count);
        if (count != "0") {
            $(tag).click();
            setTimeout(function () {
                ShowScrollUsers();
            },100);
        } else {
            console.log("This user don`t have followers");
        }
    }
    function OpenFollowers() {
        var followersCount = $(class_user_followers).text();
        workWithFollowers(class_user_followers, followersCount);
    }
    function OpenFollows() {
        openFollows = true;
        var followsCount = $(class_user_follows).text();
        workWithFollowers(class_user_follows, followsCount);
    }
    function FollowOnUser() {
        $(class_btn_need_follow_on_user).click();
    }
    function UserPage() {
        FollowOnUser();
        /**
         * Check if it Profile page
         */
        if ($(class_user_page)[0]) {
            console.log("Move 0: Start");
            if ($(class_user_close)[0]) {
                console.log("User close his account for you");
            } else {
                OpenFollowers();
            }
        } else {
            console.log("sorry, it`s not a profile page");
        }
    }
    UserPage();
});