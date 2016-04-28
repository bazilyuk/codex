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
    document.getElementById("menu").onclick = function() {
        information.className = (information.className != 'active' ? 'active' : '' );
    };
    var chooseField = document.getElementById("chooseField");
    var Boxes = chooseField.options[chooseField.selectedIndex].value; //How many rows and cols in this row
    Boxes = 3;
    var TicTacToe = document.getElementById("TicTacToe");
    var popup = document.getElementById("popup");
    var information = document.getElementById("information");
    var playername1 = document.getElementById("playername1");
    var playername2 = document.getElementById("playername2");
    var secondTurn, firstTurn = "crosses";
    var click = 0;
    var EmptyFields = []; //Add fields that empty
    var GameFields = []; //Array with real boxes
    var GameLines = []; //Array with lines
    var Bot = false, finish = false;
    var SmartBot = true;
    function addToFields(i) {
        var mybox = new box();
        mybox.id = i;
        GameFields[i] = mybox;
    };
    function CreateFields(){
        GameFields = [];
        EmptyFields = [];
        for (var i=0;i<Boxes*Boxes;i++) {
            EmptyFields[i] = i;
            addToFields(i);
        }
    };
    function box() {
        this.id = "";
        this.turn = "";
        this.figure = "";
        this.win = false;
        this.fill = false;
    };
    function line() {
        this.id = "";
        this.summ = "";
        this.crosses = 0;
        this.noughts = 0;
        this.name = "";
        this.boxesIds = [];
    }
    function generateLine(){
        /**
         * Create Array with all lines in Game field
         * @type {Array}
         */
        GameLines = [];
        var BoxesNumber = Number(Boxes);
        for(var i=0;i<(BoxesNumber*2+2);i++) {
            createLine(i);
        }
        function createLine(i){
            var myline = new line();
            myline.id = i;
            GameLines.push(myline);
        }
        addBoxesToLine();
    }
    function addBoxesToLine() {
        /**
         * Add boxes to Lines GameField
         * @param id
         */
        function addBoxesToLineIds(id){
            var BoxesNumber = Number(Boxes);
            var BoxesArray = [];
            var someNumber = 0;
            if (id<BoxesNumber){
                /**
                 * fill only Horizontal lines
                 */
                for (var i=(id*BoxesNumber);i<(BoxesNumber+(id*BoxesNumber));i++){
                    BoxesArray.push(GameFields[i]);
                }
            } else if ((id>=BoxesNumber)&&(id<BoxesNumber*2)){
                /**
                 * fill only Vertical lines
                 */
                for (var i=0;i<BoxesNumber;i++){
                    someNumber = (i*BoxesNumber)+(id-BoxesNumber);
                    BoxesArray.push(GameFields[someNumber]);
                }
            } else if (id==BoxesNumber*2) {
                for (var i=0;i<BoxesNumber;i++){
                    someNumber = (BoxesNumber+1)*i;
                    BoxesArray.push(GameFields[someNumber]);
                }
            } else {
                for (var i=0;i<BoxesNumber;i++){
                    someNumber = (BoxesNumber-1)*(i+1);
                    BoxesArray.push(GameFields[someNumber]);
                }
            }
            GameLines[id].boxesIds = BoxesArray;
        }
        for (var i=0;i<GameLines.length;i++) {
            addBoxesToLineIds(i);
        }
    }
    function addInfoToLine(id,name) {
        for (var i=0;i<GameLines.length;i++) {
            var lineId = GameLines[i].id;
            if (lineId==id) {
                GameLines[i].name = name;
            }
        }
    }
    function SetInfoToLines() {
        var BoxesNumber = Number(Boxes);
        for (var i=0;i<BoxesNumber;i++) {
            addInfoToLine(i,"Horizontal "+i);
            addInfoToLine(i+BoxesNumber,"Vertical "+i);
        }
        addInfoToLine(BoxesNumber*2,"Diagonal 1");
        addInfoToLine(BoxesNumber*2+1,"Diagonal 2");
    };
    /**
     * Generete TicTacToe field with rows and cols
     * @param cols
     * @constructor
     */
    function CreateHtml(cols) {
        while (TicTacToe.firstChild) {
            TicTacToe.removeChild(TicTacToe.firstChild);
        }
        function addCol(i,y){
            var col = document.createElement('div');
            var number = i*cols+y;
            var divId = "box"+number;
            var divClass = "col-"+cols;
            var divClass1 = "box";
            col.setAttribute("name",number);
            col.classList.add(divClass);
            col.classList.add(divClass1);
            col.setAttribute("id", divId);
            col.setAttribute("data-figure", "");
            col.setAttribute("data-number", number);
            return col;
        }
        function addRow(i){
            var row = document.createElement('div');
            row.classList.add("row");
            for (var y=0;y<cols;y++) {
                row.appendChild(addCol(i,y));
            }
            return row;
        }
        var row = document.createElement('div');
        row.classList.add("row");
        for (var i=0;i<cols;i++) {
            TicTacToe.appendChild(addRow(i));
        }
    }
    //CreateHtml(Boxes);
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
    function addName(input) {
        if (input.id=="playername1") {
            player1.name = input.value;
        } else {
            player2.name = input.value;
        }
    }
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
    function GenerateAll() {
        Boxes = chooseField.options[chooseField.selectedIndex].value;
        CreateFields();
        generateLine();
        SetInfoToLines();
        CreateHtml(Boxes);
        BoxesElement = document.querySelectorAll('.box');
        whoFirst();
        console.log(GameFields);
        console.log(GameLines);
    }
    document.getElementById("start").onclick = function() {start()};
    function start() {
        GenerateAll();
        var st = document.getElementById("start");
        var rest = document.getElementById("restart");
        addClass(st,"hidden");
        removeClass(rest,"hidden");
        removeClass(information,"active");
        ClickToBox();
    }
    /**
     * Restart game
     */
    document.getElementById("restart").onclick = function() { Bot = false; restart() };
    document.getElementById("playmore").onclick = function() { restart() };
    var BoxesElement = document.querySelectorAll('.box');
    function restart() {
        GenerateAll();
        removeClass(popup, "active");
        removeClass(information,"active");
        click = 0;
        finish = false;
        ClickToBox();
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
            var figure = "crosses";
            var next = "noughts";
        } else {
            var figure = "noughts";
            var next = "crosses";
        }
        box.setAttribute("data-figure", who);
        TicTacToe.setAttribute("data-cursor", next);
        checkWin(figure);
        if ((click==(Boxes*Boxes-1))&&(!finish)) {
            draw();
        }
    }
    /**
     * Check if in one line all figure of one kind, then whoose turn, that player win
     */
    function setLines() {
        for (var a=0;a<GameLines.length;a++){
            var noug = 0;
            var cross = 0;
            for (var b=0;b<GameLines[a].boxesIds.length;b++){
                if (GameLines[a].boxesIds[b].figure=="crosses") {
                    cross++;
                } else if (GameLines[a].boxesIds[b].figure=="noughts") {
                    noug++;
                }
            }
            GameLines[a].crosses = cross;
            GameLines[a].noughts = noug;
        }
    }
    function checkWin(turn) {
        setLines();
        if (click+1>((Number(Boxes)*2)-2)) {
            for (var a = 0; a < GameLines.length; a++) {
                var noug = GameLines[a].noughts;
                var cross = GameLines[a].crosses;
                if ((cross == Number(Boxes)) || (noug == Number(Boxes))) {
                    var boxID = -1;
                    for (var b1 = 0; b1 < GameLines[a].boxesIds.length; b1++) {
                        boxID = GameLines[a].boxesIds[b1].id;
                        GameFields[boxID].win = true;
                    }
                    finish = true;
                    win(turn);
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
                var id = "#box"+GameFields[a].id;
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
            var boxNumber = GameFields[i].id;
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
    function BotCheckBoxes(figure){
        var nougArr = [];
        var crossArr = [];
        var noug = 0;
        var cross = 0;
        var nextBox = 5;
        for (var a=0;a<GameLines.length;a++){
            nougArr[a] = GameLines[a].noughts;
            crossArr[a] = GameLines[a].crosses;
        }
        noug = Math.max.apply(null, nougArr);
        cross = Math.max.apply(null, crossArr);
        if (figure=="crosses") {
            //if can win
            if ((cross>noug)||(cross==Number(Boxes)-1)) {
                var lineIndex = crossArr.indexOf(cross);
                for (var a1=0;a1<Number(Boxes);a1++){
                    if (!GameLines[a1].boxesIds[a1].fill){
                        nextBox = GameLines[a1].boxesIds[a1].id;
                    }
                }
            }
        }
    }
    function startBot(figure) {
        figure = figure == "crosses" ? "noughts" : "crosses";
        if (!SmartBot) {
            var rand = EmptyFields[Math.floor(Math.random() * EmptyFields.length)];
            var id = "#box"+rand;
            var that = document.querySelector(id);
        } else {
            BotCheckBoxes(figure);
            var rand = EmptyFields[Math.floor(Math.random() * EmptyFields.length)];
            var id = "#box"+rand;
            var that = document.querySelector(id);
        }

        FillGameField(that,figure,click);
        boxClick(that,figure,click);
        click++;
    }
    /**
     * Click to box
     */
    function ClickToBox() {
        for (var i = 0; i < Boxes*Boxes; i++) {
            BoxesElement[i].addEventListener('click', function(event) {
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
                console.log(GameLines);
                console.log(EmptyFields);
            });
        }
    }
})();