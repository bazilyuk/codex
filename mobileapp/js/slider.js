/**
 * Created by Максим on 26.05.2016.
 */
var getImage = (function(){
    /**
     * Create slider functionality
     * @param file
     * @param callback
     */
    function startSlider(imageCount,iteration){
        var finish_image = 0;
        var carousel_inner = document.getElementById("carousel_inner");
        var carousel = document.getElementById("image-carousel");
        var speed = 100;
        var turn = Math.ceil(Math.random()*imageCount); //what image should show from 1 to 6
        //turn = 5;
        var slide_height = carousel_inner.offsetHeight;
        function slideDown() {
            document.querySelectorAll(".image-carousel")[0].appendChild(document.querySelectorAll(".image-carousel > div:first-child")[0]);
        }

        var timerId = setInterval(function() {
            slideDown();
        }, speed);

        setTimeout(function() {
            clearInterval(timerId);
        }, turn*speed+(iteration*(imageCount-1)));
        function GetResult(){
            finish_image = document.querySelectorAll(".image-carousel > div:first-child")[0].getAttribute("data-number");
            var result = parseInt(turn) + parseInt(finish_image);
            if (result>5) {
                result = result - 6;
            }
            //console.log("turn: "+turn+" imageCount: "+imageCount+" iteration: "+iteration+" finish_image: "+finish_image+" result: "+result);
            return result;
        }
        return GetResult();
    }
    return {
        RunSlider: startSlider
    }
})();