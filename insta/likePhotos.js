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
    var numberArray = []; //array of photo that wiil choose
    var countPhoto = document.querySelectorAll(class_user_photo).length; // count of all visible photo on page
    var time_Start = 0; // Time for start of photo session
    var time_Photo = 0; // Time for next click to photo
    var time_Like = 0; // Time for next click on like
    var time_Close = 0; // Time for next click on close
    var time_All = 5000;
    var Photo_increment = 0; // How much photo was open

    function _countPhoto() {
        /**
         * set array of photos
         */
        for(var i=0;i<countPhoto;i++) {
            numberArray[i] = i;
        }
        if (countPhoto) {
            return true;
        } else {
            return false;
        }
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
    function randPhoto() {
        /**
         * Return random number from 3 to 6
         * @type {number}
         */
        if (countPhoto>6) {
            var rand = Math.floor(Math.random()*3) + 3;
        } else {
            var rand = Math.floor(Math.random()*countPhoto);
        }
        console.log("Choose "+rand+" photo on this page;");
        return rand;
    }
    var Photo_items = randPhoto(); // Count of Photo that will choose for 1 user
    function setTime() {
        /**
         * Set time for each move
         */
        console.log("Move 2: Set time for round");
        time_Start = (randHalfSec()+3)*1000;
        time_Photo = (randHalfSec()+3)*1000;
        time_Like = (randHalfSec()+3)*1000;
        time_Close = (randHalfSec()+3)*1000;
        time_All = time_Photo + time_Like + time_Close + 10;
        console.log("time_Start: "+time_Start+"time_Photo: "+time_Photo+"; time_Like: "+time_Like+"; time_Close: "+time_Close+"; time_All: "+time_All);
    }

    // function goToLink(link) {
    //     var resultLink = "https://www.instagram.com" + link;
    //     window.location = resultLink;
    // }
    function FollowOnUser() {
        $(class_btn_need_follow_on_user).click();
    }
    function ClosePhoto() {
        /**
         * Close photo
         */
        console.log("Move 6: Close photo");
        if ($(class_popup_close)) {
            $(class_popup_close).click();
        }
        Photo_increment++;
        console.log("How much photo I click: "+Photo_increment);
        repeatSession();
    }
    function LikePhoto() {
        /**
         * Click like on photo
         */
        console.log("Move 5: Like photo");
        if ($(class_click_like)[0]) {
            $(class_click_like).click();
        } else {
            console.log("sorry, but you like this photo before");
        }
        setTimeout(function () {
            ClosePhoto();
        }, time_Close);
    }

    function clickPhoto(number) {
        /**
         * Click and open Photo
         */
        console.log("Move 4: Click photo");
        var elements = document.querySelectorAll(class_user_photo)[number];
        elements.click();
        // console.log(elements);
        setTimeout(function () {
            LikePhoto();
        }, time_Like);
    }
    function ChoosePhoto() {
        /**
         * Choose what Photo will click
         */
        console.log("Move 3: Chose photo");
        var rand = numberArray[Math.floor(Math.random() * countPhoto)];
        var y = numberArray.indexOf(rand);
        console.log("Choosen photo: "+rand);
        countPhoto--;
        numberArray.splice(rand, 1);
        setTimeout(function () {
            clickPhoto(rand);
        }, time_Photo);
    }


    var day = new Date();
    var min = day.getMinutes();
    var sec = day.getSeconds();
    console.log("Time at this moment: "+min+":"+sec);

    function start() {
        console.log("Move 1: Set all data");
        setTime();
        setTimeout(function() {
            ChoosePhoto();
        }, time_Start);
    }
    function repeatSession() {
        if (Photo_increment<Photo_items) {
            start();
        } else {
            console.log("Finish.");
            setTimeout(function() {
                closeWindow();
            }, 1000);
        }
    }
    function closeWindow() {
        window.close();
    }
    function startSesiion() {
        console.log("Move 1: Set all data");
        if (_countPhoto()) {
            setTime();
            setTimeout(function() {
                ChoosePhoto();
            }, time_Start);
        } else {
            console.log("Finish.");
            setTimeout(function() {
                closeWindow();
            }, 1000);
        }
    }

    function UserPage() {
        /**
         * Check if it Profile page
         */
        if ($(class_user_page)[0]) {
            console.log("Move 0: Start with next photo");
            FollowOnUser();
            startSesiion();
        } else {
            console.log("sorry, it`s not a profile page");
            closeWindow();
        }
    }
    UserPage();
});