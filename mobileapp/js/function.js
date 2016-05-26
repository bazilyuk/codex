;/**
 * Created by maksim on 25.05.2016.
 */
(function(){
    /**
     * Load Images
     * add images to page and add name of images to select
     * @param file
     * @param callback
     */
    function loadJSON(file, callback) {
        var xobj = new XMLHttpRequest();
        xobj.overrideMimeType("application/json");
        xobj.open('GET', file, true); // Replace 'my_data' with the path to your file
        xobj.onreadystatechange = function () {
            if (xobj.readyState == 4 && xobj.status == "200") {
                // Required use of an anonymous callback as .open will NOT return a value but simply returns undefined in asynchronous mode
                callback(xobj.responseText);
            }
        };
        xobj.send(null);
    }
    function load() {
        loadJSON("img.json", function(response) {
            CreateAll(response);
        });
    }
    load();
    function CreateAll(response){
        var iteration = 1; //count of slider iteration

        var srcArray = [], nameArray = [];
        var actual_JSON = JSON.parse(response);
        var imageCount = actual_JSON.images.length;

        for (var i = 0;i<imageCount;i++){
            srcArray.push(actual_JSON.images[i].src);
            nameArray.push(actual_JSON.images[i].name);
        }
        createSlider(srcArray);
        createSelect(nameArray);
        iteration = Math.round(Math.random()*(imageCount-1));
        startGame(imageCount,iteration);
    }
    function startGame(imageCount,iteration){
        var spin = document.getElementById("spin");
        var whatImage = 0; //Image that will show after spin
        var select = document.getElementById("select-field");
        var selected; //what user select

        spin.addEventListener('click', function(event) {
            spin.disabled = true;
            selected = select.options[select.selectedIndex].value;
            if (selected) {
                var whatImage = getImage.RunSlider(imageCount,iteration);
                //console.log("selected: "+selected+" whatImage: "+whatImage);
                if (selected==whatImage){
                    win("You win");
                } else {
                    lose("You lose");
                }
            } else {
                lose("select please");
                spin.disabled = false;
            }
        });
    }
    function PlaySound(choose) {
        var spin = document.getElementById("spin");
        document.getElementById("win").pause();
        document.getElementById("win").currentTime = 0;
        document.getElementById("lose").pause();
        document.getElementById("lose").currentTime = 0;
        setTimeout(function() {
            document.getElementById(choose).play();
            spin.disabled = false;
        }, 100);
    }
    function fillText(word) {
        var canvas = document.getElementById("result");
        var ctx = canvas.getContext("2d");
        ctx.clearRect(0,0,260,100);
        ctx.font = "30px Tahoma";
        ctx.fillStyle = "red";
        ctx.textAlign = "center";
        ctx.fillText(word, canvas.width/2, canvas.height/2);
    }
    function win(word){
        fillText(word);
        PlaySound("win");
    }
    function lose(word){
        fillText(word);
        if (word=="You lose"){
            PlaySound("lose");
        }
    }
    function createSlider(srcImages) {
        /**
         * create slider HTML and put image from json
         * @type {HTMLElement}
         */
        var carousel = document.getElementById("image-carousel");
        var slide;
        function createSlide(number,src) {
            //create slide
            var item = document.createElement('div');
            item.classList.add("item");
            item.setAttribute("data-number", number);
            //create image
            var image = document.createElement('img');
            image.setAttribute("src", src);
            //add image to slide
            item.appendChild(image);

            return item;
        }
        for (var i=0;i<srcImages.length;i++){
            slide = createSlide(i,srcImages[i]);
            carousel.appendChild(slide);
        }
    }
    function createSelect(nameImages){
        /**
         * Create select and put name of image to option
         * @type {HTMLElement}
         */
        var select = document.getElementById("select-field");
        var option;
        function createOption(value,name) {
            //create option
            var item = document.createElement('option');
            item.setAttribute("value", value);
            item.text = name;

            return item;
        }
        for (var i=0;i<nameImages.length;i++){
            option = createOption(i,nameImages[i]);
            select.appendChild(option);
        }
    }
})();