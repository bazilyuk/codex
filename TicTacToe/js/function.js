/**
 * Created by maksim on 28.03.2016.
 */
function addClass(o, c){
    var re = new RegExp("(^|\\s)" + c + "(\\s|$)", "g")
    if (re.test(o.className)) return
    o.className = (o.className + " " + c).replace(/\s+/g, " ").replace(/(^ | $)/g, "")
}

function removeClass(o, c){
    var re = new RegExp("(^|\\s)" + c + "(\\s|$)", "g")
    o.className = o.className.replace(re, "$1").replace(/\s+/g, " ").replace(/(^ | $)/g, "")
}

(function(){
    var deleteLink = document.querySelectorAll('.box');
    var TicTacToe = document.getElementById("TicTacToe");
    var popup = document.getElementById("popup");
    var click = 0;
    /**
     * Restart game
     */
    document.getElementById("restart").onclick = function() {restart()};
    document.getElementById("start").onclick = function() {start()};
    function restart() {
        click = 0;
        TicTacToe.setAttribute("data-cursor", "noughts");
        for (var i = 0; i < deleteLink.length; i++) {
            deleteLink[i].setAttribute("data-figure", "");
        }
        addClass(popup, "active");
    }
    function start() {
        removeClass(popup, "active");
    }
    /**
     * check if this box empty
     */
    function BoxEmpty(item) {
        var full = false;
        var figure = item.getAttribute("data-figure");
        if (!figure){
            full = true;
        }
        return full;
    }
    /**
     * Check Whoose turn
     */
    function noughtsTurn(click) {
        var noughtTurn = true;
        if (click%2==0){
            noughtTurn = true;
        } else {
            noughtTurn = false;
        }
        return noughtTurn;
    }
    /**
     * Click to box
     */
    for (var i = 0; i < deleteLink.length; i++) {
        deleteLink[i].addEventListener('click', function(event) {
            if (BoxEmpty(this)) {
                click++;
                console.log(click);
                if (noughtsTurn(click)){
                    this.setAttribute("data-figure", "crosses");
                    TicTacToe.setAttribute("data-cursor", "noughts");
                } else {
                    this.setAttribute("data-figure", "noughts");
                    TicTacToe.setAttribute("data-cursor", "crosses");
                }
                if (click>=5) {
                    //if (win()){
                    //
                    //}
                }
            }
        });
    }
})();