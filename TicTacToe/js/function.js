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
    document.getElementById("menu").onclick = function() {
        information.className = (information.className != 'active' ? 'active' : '' );
    };

    var Boxes = document.querySelectorAll('.box');
    var TicTacToe = document.getElementById("TicTacToe");
    var popup = document.getElementById("popup");
    var information = document.getElementById("information");
    var playername1 = document.getElementById("playername1");
    var playername2 = document.getElementById("playername2");
    var secondTurn, firstTurn = "crosses";
    var click = 0;
    var EmptyFields = []; //Add fields that empty
    var BoxNumbers = []; //Array of boxes number 1 2 4 8 16 ...
    var GameFields = []; //Array with real boxes
    var Bot = false, finish = false;
    function CreateFields(){
        for (var i=0;i<Boxes.length;i++) {
            BoxNumbers[i] = Math.pow(2,i);
            EmptyFields[i] = BoxNumbers[i];
            addToFields(i);
        }
    };
    function box() {
        this.id = "";
        this.number = "";
        this.turn = "";
        this.figure = "";
        this.win = false;
        this.fill = false;
    };
    var wins = [7, 56, 448, 73, 146, 292, 273, 84];
    var noughts = [], crosses = []; //in this array add all object that we click
    function addToFields(i) {
        var mybox = new box();
        mybox.id = i;
        mybox.number = BoxNumbers[i];
        GameFields[i] = mybox;
    }
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
    function whoFirst() {
        if (document.getElementById("crossesTurn").checked) {
            firstTurn = "crosses";
            secondTurn = "noughts";
        } else {
            firstTurn = "noughts";
            secondTurn = "crosses";
        }
        TicTacToe.setAttribute("data-cursor", firstTurn);
    }
    function start() {
        CreateFields();
        whoFirst();
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
    /**
     * Restart game
     */
    document.getElementById("restart").onclick = function() {Bot = false;restart()};
    document.getElementById("playmore").onclick = function() {restart()};
    function restart() {
        whoFirst();
        removeClass(popup, "active");
        removeClass(information,"active");
        click = 0; noughts = []; crosses = [];
        finish = false;
        for (var i = 0; i < Boxes.length; i++) {
            Boxes[i].setAttribute("data-figure", "");
            removeClass(Boxes[i], "win");
        }
        GameFields = [];
        EmptyFields = [];
        CreateFields();
    }
    /**
     * Play with computer
     */
    document.getElementById("computerPlay").onclick = function() {Bot = true; restart()};
    /**
     * check if this box empty
     */
    function BoxEmpty(item) {
        var id = item.getAttribute("name");
        for (var i=0;i<GameFields.length;i++) {
            var boxId = GameFields[i].id;
            var boxFill = GameFields[i].fill;
            if (id == boxId) {
                return GameFields[i].fill;
            }
        }
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
        if ((click==8)&&(!finish)) {
            draw();
        }
    }
    /**
     * Create all sum that we can get from array of numbers of this figure
     * if sum equal one element from wins array, then this figure win.
     */
    function checkWin(figure,turn) {
        var result = 0;
        for (var i=0;i<figure.length-2;i++){
            for (var y=i+1;y<figure.length-1;y++){
                for (var z=y+1;z<figure.length;z++){
                    result = figure[i] + figure[y] +figure[z];
                    if (wins.indexOf(result)>=0) {
                        finish = true;
                        for (var a=0;a<GameFields.length;a++){
                            if ((GameFields[a].number == figure[i])||(GameFields[a].number == figure[y])||(GameFields[a].number == figure[z])){
                                GameFields[a].win = true;
                            }
                        }
                        win(turn);
                    }
                }
            }
        }
    }
    /**
     * When someone win
     */
    function win(figure) {
        var winner = "";
        addClass(popup, "active");
        if (figure=="crosses") {
            winner = player1.name;
        } else {
            winner = player2.name;
        }
        document.getElementById('winner').innerHTML = winner;
        for (var a=0;a<GameFields.length;a++){
            if (GameFields[a].win) {
                var id = "#box"+GameFields[a].number;
                var elem = document.querySelector(id);
                elem.classList.add("win");
            }
        }
    }
    function draw(){
        addClass(popup, "active");
        document.getElementById('winner').innerHTML = "Draw";
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
        var y = EmptyFields.indexOf(Number(number));
        if(y != -1) {
            EmptyFields.splice(y, 1);
        }
    }
    /**
     * Bot Goes
     */
    function startBot(figure) {
        figure = figure == "crosses" ? "noughts" : "crosses";
        var rand = EmptyFields[Math.floor(Math.random() * EmptyFields.length)];
        var id = "#box"+rand;
        var that = document.querySelector(id);
        FillGameField(that,figure,click);
        boxClick(that,figure,click);
        click++;
    }
    /**
     * Click to box
     */
    for (var i = 0; i < Boxes.length; i++) {
        Boxes[i].addEventListener('click', function(event) {
            var figure = firstTurn;
            if (!BoxEmpty(this)) {
                if (click%2==1){
                    figure = secondTurn;
                }
                FillGameField(this,figure,click);
                boxClick(this,figure,click);
                click++;
            }
            if ((Bot)&&(!finish)) {
                startBot(figure);
            }
        });
    }
})();