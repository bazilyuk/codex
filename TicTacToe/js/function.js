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
    var Boxes = document.querySelectorAll('.box');
    var TicTacToe = document.getElementById("TicTacToe");
    var popup = document.getElementById("popup");
    var information = document.getElementById("information");
    var playername1 = document.getElementById("playername1");
    var playername2 = document.getElementById("playername2");

    var click = 0;
    var BoxNumbers = []; //Array of boxes number 1 2 4 8 16 ...
    var GameFields = []; //Array with real boxes
    (function(){
        for (var i=0;i<Boxes.length;i++) {
            BoxNumbers[i] = Math.pow(2,i);
        }
    })();
    function box(i) {
        this.id = i;
        this.number = BoxNumbers[i];
        this.fill = false;
        this.turn = "";
        this.figure = "";
    };
    var wins = [7, 56, 448, 73, 146, 292, 273, 84];
    var noughts = [], crosses = [];
    function CreateFields(){
        function addToFields(i) {
            var mybox = new box(i);
            GameFields[i] = mybox;
        }
        for (var i=0;i<BoxNumbers.length;i++) {
            addToFields(i);
        }
    }
    CreateFields();

    /**
     * player info
     */
    var player1 = {
        figure : "crosses",
        name: "crosses"
    };
    var player2 = {
        figure: "noughts",
        name: "noughts"
    };
    playername1.onchange = function(){ addName(playername1)};
    playername2.onchange = function(){ addName(playername2)};

    document.getElementById("start").onclick = function() {start()};
    function start() {
        var st = document.getElementById("start");
        var rest = document.getElementById("restart");
        addClass(st,"hidden");
        removeClass(rest,"hidden");
        removeClass(information,"active");
    }
    function addName(input) {
        if (input.id=="playername1") {
            player1.name = input.value;
        } else {
            player2.name = input.value;
        }
    }
    document.getElementById("menu").onclick = function() {
        information.className = (information.className != 'active' ? 'active' : '' );
    };
    /**
     * Play with computer
     */
    document.getElementById("computerPlay").onclick = function() {startBot()};
    function startBot() {

    }
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
        for (var i = 0; i < Boxes.length; i++) {
            Boxes[i].setAttribute("data-figure", "");
            removeClass(Boxes[i], "win");
        }
        GameFields = [];
        CreateFields();
    }
    /**
     * check if this box empty
     */
    function BoxEmpty(item) {
        var id = item.getAttribute("data-id");
        for (var i=0;i<GameFields.length;i++) {
            var boxId = GameFields[i].id;
            var boxFill = GameFields[i].fill;
            if (id == boxId) {
                return GameFields[i].fill;
            }
        }
    }
    /**
     * Check Whoose turn
     */
    function noughtsTurn(click) {
        var noughtTurn = true;
        if (click%2==0){
            noughtTurn = false;
        } else {
            noughtTurn = true;
        }
        return noughtTurn;
    }
    /**
     * click to box
     */
    function boxClick(box,who,click) {
        if (who=="crosses"){
            var figure = crosses;
            var next = "noughts";
        } else {
            var figure = noughts;
            var next = "crosses";
        }
        figure.push(Number(box.getAttribute("data-number")));
        box.setAttribute("data-figure", who);
        TicTacToe.setAttribute("data-cursor", next);
        if (click>=4) {
            checkWin(figure,who);
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
        var winner = "";
        addClass(popup, "active");
        if (figure=="crosses") {
            winner = player1.name;
        } else {
            winner = player2.name;
        }
        document.getElementById('winner').innerHTML = winner;
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
     * Fill game field
     */
    function FillGameField(that,figure,turn) {
        var number = that.getAttribute("data-number");
        for (var i=0;i<GameFields.length;i++) {
            var boxNumber = GameFields[i].number;
            var boxFill = GameFields[i].fill;
            if ((number == boxNumber)&&(!boxFill)) {
                GameFields[i].figure = figure;
                GameFields[i].turn = turn;
                GameFields[i].fill = true;
            }
        }
    }
    /**
     * Click to box
     */
    for (var i = 0; i < Boxes.length; i++) {
        Boxes[i].addEventListener('click', function(event) {
            /**
             * crosses go first
             */
            var figure = "crosses";
            if (!BoxEmpty(this)) {
                if (noughtsTurn(click)){
                    figure = "noughts";
                }
                FillGameField(this,figure,click);
                boxClick(this,figure,click);
                click++;
            }
        });
    }
})();