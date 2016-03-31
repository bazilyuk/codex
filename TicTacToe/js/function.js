/**
 * Created by maksim on 28.03.2016.
 */
/*
 * To determine a win condition, each square is "tagged" from left
 * to right, top to bottom, with successive powers of 2.  Each cell
 * thus represents an individual bit in a 9-bit string, and a
 * player's squares at any given time can be represented as a
 * unique 9-bit value. A winner can thus be easily determined by
 * checking whether the player's current 9 bits have covered any
 * of the eight "three-in-a-row" combinations.
 *
 *     273                 84
 *        \               /
 *          1 |   2 |   4  = 7
 *       -----+-----+-----
 *          8 |  16 |  32  = 56
 *       -----+-----+-----
 *         64 | 128 | 256  = 448
 *       =================
 *         73   146   292
 *
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
    var information = document.getElementById("information");
    var click = 0;
    var wins = [7, 56, 448, 73, 146, 292, 273, 84];
    var noughts = [], crosses = [];
    /**
     * player info
     */
    var playername1 = document.getElementById("playername1");
    var playername2 = document.getElementById("playername2");
    var player1 = {
        name: "crosses"
    };
    var player2 = {
        name: "noughts"
    };
    document.getElementById("start").onclick = function() {start()};
    function start() {
        if (playername1.value) {
            player1.name = playername1.value;
        }
        if (playername2.value) {
            player2.name = playername2.value;
        }
        var st = document.getElementById("start");
        var rest = document.getElementById("restart");

        addClass(st,"hidden");
        removeClass(rest,"hidden");
        removeClass(information,"active");
    }
    document.getElementById("menu").onclick = function() {
        information.className = (information.className != 'active' ? 'active' : '' );
    };
    /**
     * Restart game
     */
    document.getElementById("restart").onclick = function() {restart()};
    document.getElementById("playmore").onclick = function() {restart()};
    function restart() {
        removeClass(popup, "active");
        removeClass(information,"active");
        click = 0; noughts = []; crosses = [];
        TicTacToe.setAttribute("data-cursor", "crosses");
        for (var i = 0; i < deleteLink.length; i++) {
            deleteLink[i].setAttribute("data-figure", "");
            removeClass(deleteLink[i], "win");
        }
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
     * click to box
     */
    function boxClick(box,figure,click) {
        var text = ["noughts","crosses"];
        var turn = click%2;
        var winner = text[turn];
        figure.push(Number(box.getAttribute("data-number")));
        box.setAttribute("data-figure", text[turn]);
        if (turn==0) {
            var text1 = text[1];
        } else {
            var text1 = text[0];
        }
        TicTacToe.setAttribute("data-cursor", text1);
        if (click>=5) {
            checkWin(figure,winner);
        }
    }

    /**
     * check if someone win
     */
    function checkWin(figure,turn) {
        var result = 0;
        for (var i=0;i<figure.length-2;i++){
            for (var y=i+1;y<figure.length-1;y++){
                for (var z=y+1;z<figure.length;z++){
                    result = figure[i] + figure[y] +figure[z];
                    if (wins.indexOf(result)>=0) {
                        win(turn,wins.indexOf(crosses));
                    }
                }
            }
        }
    }
    /**
     * When someone win
     */
    function win(figure,line) {
        addClass(popup, "active");
        document.getElementById('winner').innerHTML = figure;
        switch(line) {
            case 0 :
                addClass(document.getElementById("box1"), "win");
                addClass(document.getElementById("box2"), "win");
                addClass(document.getElementById("box4"), "win");
                break;
            case 1 :
                addClass(document.getElementById("box8"), "win");
                addClass(document.getElementById("box16"), "win");
                addClass(document.getElementById("box32"), "win");
                break;
            case 2 :
                addClass(document.getElementById("box64"), "win");
                addClass(document.getElementById("box128"), "win");
                addClass(document.getElementById("box256"), "win");
                break;
            case 3 :
                addClass(document.getElementById("box1"), "win");
                addClass(document.getElementById("box8"), "win");
                addClass(document.getElementById("box64"), "win");
                break;
            case 4 :
                addClass(document.getElementById("box2"), "win");
                addClass(document.getElementById("box16"), "win");
                addClass(document.getElementById("box128"), "win");
                break;
            case 5 :
                addClass(document.getElementById("box4"), "win");
                addClass(document.getElementById("box32"), "win");
                addClass(document.getElementById("box256"), "win");
                break;
            case 6 :
                addClass(document.getElementById("box1"), "win");
                addClass(document.getElementById("box16"), "win");
                addClass(document.getElementById("box256"), "win");
                break;
            case 7 :
                addClass(document.getElementById("box4"), "win");
                addClass(document.getElementById("box16"), "win");
                addClass(document.getElementById("box64"), "win");
                break;
        }
    }
    /**
     * Click to box
     */
    for (var i = 0; i < deleteLink.length; i++) {
        deleteLink[i].addEventListener('click', function(event) {
            if (BoxEmpty(this)) {
                click++;
                if (!noughtsTurn(click)){
                    boxClick(this,crosses,click);
                } else {
                    boxClick(this,noughts,click);
                }
            }
        });
    }
})();