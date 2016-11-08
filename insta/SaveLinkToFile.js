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
    var DB_name = "bazar25";
    var UsersOld = [];
    var Users = [];
    var openFollows = false;

    var Try_Send_file = 0;

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
    function SaveToFile(count,user_in_popup) {
        user_in_popup;
        console.log("Users: ");
        console.log(Users);
        console.log("DB: "+DB_name);
        console.log("openFollows: "+openFollows);
        /**
         * 7 13
         * This function save all data to file in our server
         * name off database - this is name of this file
         */
        $.ajax({
            type: 'POST',
            url: 'https://insta.bazar25.com.ua/index.php',
            crossDomain: true,
            data: {
                file: DB_name,
                property: "update",
                data: JSON.stringify(Users)
            },
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            dataType: 'html',
            success: function(e){
                console.log(e);
                console.log("save to file.");
                console.log("count: "+count);
                console.log("Users: "+user_in_popup);
                if (count <= user_in_popup) {
                    if (!openFollows) {
                        ClosePopup();
                        setTimeout(function () {
                            OpenFollows();
                        },100);

                    } else {
                        console.log("finish!");
                    }
                } else {
                    if (Try_Send_file<4) {
                        Try_Send_file++;
                        ShowScrollUsers(count);
                    } else {
                        if (!openFollows) {
                            ClosePopup();
                            setTimeout(function () {
                                OpenFollows();
                            },100);

                        } else {
                            console.log("finish!");
                        }
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError){
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function GetFromFilesData(link_class, count) {
        /**
         * 3 9
         * This function Read file and get old data
         */
        var data = "";
        $.ajax({
            type: 'POST',
            url: 'https://insta.bazar25.com.ua/index.php',
            crossDomain: true,
            data: {
                file: DB_name,
                property: "read"
            },
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            dataType: 'html',
            success: function(e){
                if (e) {
                    data = JSON.parse(e);
                    console.log("User from "+DB_name+" database: ");
                    console.log(data);
                    UsersOld = data;
                } else {
                    console.log(DB_name+" database is empty. Will create new database");
                }
                workWithFollowers(link_class, count);
            },
            error: function(xhr, ajaxOptions, thrownError){
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
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
    function saveFollowers(count) {
        /**
         * 6 12
         * This function save all follovers that show in popup
         */
        var user_in_popup = 0;
        if (UsersOld) {
            var i = UsersOld.length;
        } else {
            var i = 0;
        }
        $(class_popup_follow_ul_wrap).find('li').each(function () {
            var name = $(this).find(class_popup_follow_description).text();
            var title = $(this).find(class_popup_follow_name).text();
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
            user_in_popup++;
        });
        if (UsersOld) {
            Users = UsersOld;
        }
        SaveToFile(count,user_in_popup);
    }
    function scrollUsers() {
        /**
         * scroll down in popup
         */
        $(class_popup_follow_ul_wrap).scrollTop(1000000000000000000000000);
        var scrTop = $(class_popup_follow_ul_wrap).scrollTop();
        return scrTop;
    }
    function ShowScrollUsers(count) {
        /**
         * 5 11
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
                if (i>2) {
                    if (topArray[topArray.length-2] != topArray[topArray.length-1]) {
                        y = 0;
                        Try_Send_file = 0;
                        setTimeout(go, time1+200);
                    } else {
                        y++;
                        if (y>3) {
                            setTimeout(saveFollowers(count), 1800);
                        } else {
                            setTimeout(go, time1+200);
                        }
                    }
                } else {
                    setTimeout(go, time1+200);
                }
                console.log(y);
            }, 100);
        } else {
            console.log("popup not open");
        }
    }
    function workWithFollowers(tag, count) {
        /**
         * 4 10
         * This function open popups with followers or follows
         */
        // GetFromLocalStorage();
        console.log("will save: "+count+" users.");
        if (count != "0") {
            $(tag).click();
            setTimeout(function () {
                ShowScrollUsers(count);
            },100);
        } else {
            console.log("This user don`t have followers");
        }
    }
    function OpenFollowers() {
        /**
         * 2
         * Open popup with followers
         */
        console.log("Open Followers");
        var followersCount = $(class_user_followers).text();
        GetFromFilesData(class_user_followers, followersCount);
    }
    function OpenFollows() {
        /**
         * 8
         * Open popup with follows
         */
        openFollows = true;
        console.log("Open Follows");
        var followsCount = $(class_user_follows).text();
        GetFromFilesData(class_user_follows, followsCount);
        // workWithFollowers(class_user_follows, followsCount);
    }
    function FollowOnUser() {
        $(class_btn_need_follow_on_user).click();
    }
    function UserPage() {
        FollowOnUser();
        /**
         * 1
         * Check if it Profile page
         */
        if ($(class_user_page)[0]) {
            console.log("Start");
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