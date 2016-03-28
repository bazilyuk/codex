/**
 * Created by maksim on 28.03.2016.
 */
(function(){
    var deleteLink = document.querySelectorAll('.box');
    var TicTacToe = document.getElementById("TicTacToe");
    var click = 0;
    /**
     * refresh game
     */
    document.getElementById("restart").onclick = function() {restart()};
    function restart() {
        click = 0;
        TicTacToe.setAttribute("data-cursor", "noughts");
        for (var i = 0; i < deleteLink.length; i++) {
            deleteLink[i].setAttribute("data-figure", "");
        }
    }
    /**
     * check if empty
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
     * Whoose turn
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
                if (noughtsTurn(click)){
                    this.setAttribute("data-figure", "noughts");
                    TicTacToe.setAttribute("data-cursor", "noughts");
                } else {
                    this.setAttribute("data-figure", "crosses");
                    TicTacToe.setAttribute("data-cursor", "crosses");
                }
            }
        });
    }
})();