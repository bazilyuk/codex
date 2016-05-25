/**
 * Created by maksim on 28.03.2016.
 */
(function(){
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
    function createSlider(images) {
        //console.log(images);
        var carousel = document.getElementById("image-carousel");
        var slide;
        function createSlide(src) {
            //create slide
            var item = document.createElement('div');
            item.classList.add("item");
            //create image
            var image = document.createElement('img');
            image.setAttribute("src", src);
            //add image to slide
            item.appendChild(image);

            return item;
        }
        for (var i=0;i<images.length;i++){
            slide = createSlider(images[i]);
            carousel.appendChild(slide);
        }
    }
    function load() {

        loadJSON("img.json", function(response) {
            var srcArray = [];
            var actual_JSON = JSON.parse(response);
            var imageCount = actual_JSON.images.length;

            for (var i = 0;i<imageCount;i++){
                srcArray.push(actual_JSON.images[i].src);
                console.log("a: "+srcArray);
            }
            console.log("b: "+srcArray);
            createSlider(srcArray);
        });
    }
    load();
})();