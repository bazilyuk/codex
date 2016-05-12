/**
 * Created by maksim on 28.03.2016.
 */
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
    var smartBotBtn = document.getElementById("smartBot");
    var saveGame = document.getElementById("saveGame");
    var continueGame = document.getElementById("continueGame");
    var secondTurn, firstTurn = "crosses";
    var click = 0;
    var EmptyBoxes = []; //Add fields that empty
    var GameBoxes = []; //Array with real boxes
    var GameLines = []; //Array with lines
    var Bot = false, finish = false;
    var SmartBot = smartBotBtn.options[smartBotBtn.selectedIndex].value;
    if (typeof(Storage) !== "undefined") {
        // Store
        if(localStorage.getItem("save")) {
            continueGame.classList.remove("hidden");
        }
        // Retrieve
    }
    function addToFields(i) {
        var mybox = new box();
        mybox.id = i;
        GameBoxes[i] = mybox;
    };
    function CreateFields(){
        GameBoxes = [];
        EmptyBoxes = [];
        for (var i=0;i<Boxes*Boxes;i++) {
            EmptyBoxes[i] = i;
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
                    BoxesArray.push(GameBoxes[i]);
                }
            } else if ((id>=BoxesNumber)&&(id<BoxesNumber*2)){
                /**
                 * fill only Vertical lines
                 */
                for (var i=0;i<BoxesNumber;i++){
                    someNumber = (i*BoxesNumber)+(id-BoxesNumber);
                    BoxesArray.push(GameBoxes[someNumber]);
                }
            } else if (id==BoxesNumber*2) {
                for (var i=0;i<BoxesNumber;i++){
                    someNumber = (BoxesNumber+1)*i;
                    BoxesArray.push(GameBoxes[someNumber]);
                }
            } else {
                for (var i=0;i<BoxesNumber;i++){
                    someNumber = (BoxesNumber-1)*(i+1);
                    BoxesArray.push(GameBoxes[someNumber]);
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
            col.setAttribute("data-figure", GameBoxes[number].figure);
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
        player1.figure = firstTurn;
        player2.figure = secondTurn;
        TicTacToe.setAttribute("data-cursor", firstTurn);
    }
    function GenerateAll() {
        Boxes = chooseField.options[chooseField.selectedIndex].value;
        SmartBot = smartBotBtn.options[smartBotBtn.selectedIndex].value;
        CreateFields();
        generateLine();
        SetInfoToLines();
        CreateHtml(Boxes);
        BoxesElement = document.querySelectorAll('.box');
        whoFirst();
    }
    document.getElementById("start").onclick = function() {start()};
    function start() {
        GenerateAll();
        var st = document.getElementById("start");
        var rest = document.getElementById("restart");
        st.classList.add("hidden");
        rest.classList.remove("hidden");
        information.classList.remove("active");
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
        popup.classList.remove("active");
        information.classList.remove("active");
        click = 0;
        finish = false;
        ClickToBox();
    }
    /**
     * what need to save:
     * Boxes - number of box in one field
     * player1, player2 - Objects where save name and figure of players
     * click - number of turns
     * secondTurn, firstTurn - string of who start first/second
     * EmptyBoxes - array of empty boxes
     * GameBoxes - array where store all boxes
     * GameLines - array where store all lines
     * Bot - boolean if we play with bot, then it true
     * SmartBot - number of bot quality if 0-easy 2-smartest
     */
    /**
     * Save Game
     */
    saveGame.onclick = function() {SaveData()};
    function SaveData() {
        continueGame.classList.remove("hidden");
        if (typeof(Storage) !== "undefined") {
            localStorage.setItem("save", true);
            //game information
            localStorage.setItem("Boxes", Boxes);
            localStorage.setItem("player1", JSON.stringify(player1));
            localStorage.setItem("player2", JSON.stringify(player2));
            localStorage.setItem("click", click);
            localStorage.setItem("secondTurn", secondTurn);
            localStorage.setItem("firstTurn", firstTurn);
            localStorage.setItem("EmptyBoxes", JSON.stringify(EmptyBoxes));
            localStorage.setItem("GameBoxes", JSON.stringify(GameBoxes));
            localStorage.setItem("GameLines", JSON.stringify(GameLines));
            localStorage.setItem("Bot", Bot);
            localStorage.setItem("SmartBot", SmartBot);
            localStorage.setItem("WhoNext", TicTacToe.getAttribute("data-cursor"));
        }
    }
    /**
     * Continue Game
     */
    continueGame.onclick = function() {ContinueData()};
    function ContinueData() {
        if (typeof(Storage) !== "undefined") {
            // Store
            if(localStorage.getItem("save")) {
                continueGame.classList.remove("hidden");
            }
            // get Data
            Boxes = localStorage.getItem("Boxes");
            player1 = JSON.parse(localStorage.getItem("player1"));
            player2 = JSON.parse(localStorage.getItem("player2"));
            click = localStorage.getItem("click");
            secondTurn = localStorage.getItem("secondTurn");
            firstTurn = localStorage.getItem("firstTurn");
            EmptyBoxes = JSON.parse(localStorage.getItem("EmptyBoxes"));
            GameBoxes = JSON.parse(localStorage.getItem("GameBoxes"));
            //GameLines = JSON.parse(localStorage.getItem("GameLines"));
            generateLine();
            SetInfoToLines();
            Bot = localStorage.getItem("Bot");
            SmartBot = localStorage.getItem("SmartBot");
            var WhoNext = localStorage.getItem("WhoNext");
            //play
            CreateHtml(Boxes);
            BoxesElement = document.querySelectorAll('.box');
            TicTacToe.setAttribute("data-cursor", WhoNext);
            popup.classList.remove("active");
            information.classList.remove("active");
            ClickToBox();
        }
    }
    /**
     * Delete Local Storage info
     */
    function deleteStorage(){
        if (typeof(Storage) !== "undefined") {
            localStorage.removeItem("save");
            continueGame.classList.add("hidden");
            //game information
            localStorage.removeItem("Boxes");
            localStorage.removeItem("player1");
            localStorage.removeItem("player2");
            localStorage.removeItem("click");
            localStorage.removeItem("secondTurn");
            localStorage.removeItem("firstTurn");
            localStorage.removeItem("EmptyBoxes");
            localStorage.removeItem("GameBoxes");
            localStorage.removeItem("Bot");
            localStorage.removeItem("SmartBot");
        }
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
        for (var i=0;i<GameBoxes.length;i++) {
            var boxId = GameBoxes[i].id;
            var boxFill = GameBoxes[i].fill;
            if (id == boxId) {
                return GameBoxes[i].fill;
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
                        GameBoxes[boxID].win = true;
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
        //deleteStorage();
        var winner = "";
        popup.classList.add("active");
        if (player1.figure==figure) {
            winner = player1.name;
        } else {
            winner = player2.name;
        }
        document.getElementById('winner').innerHTML = winner;
        for (var a=0;a<GameBoxes.length;a++){
            if (GameBoxes[a].win) {
                var id = "#box"+GameBoxes[a].id;
                var elem = document.querySelector(id);
                elem.classList.add("win");
            }
        }
    }
    function draw(){
        //deleteStorage();
        finish = true;
        popup.classList.add("active");
        document.getElementById('winner').innerHTML = "Draw";
    }
    /**
     * Fill game field
     */
    function FillGameField(that,figure,turn) {
        var number = that.getAttribute("data-number");
        for (var i=0;i<GameBoxes.length;i++) {
            var boxNumber = GameBoxes[i].id;
            var boxFill = GameBoxes[i].fill;
            if ((number == boxNumber)&&(!boxFill)) {
                GameBoxes[i].figure = figure;
                GameBoxes[i].turn = turn;
                GameBoxes[i].fill = true;
            }
        }
        var y = EmptyBoxes.indexOf(Number(number));
        if(y != -1) {
            EmptyBoxes.splice(y, 1);
        }
    }
    /**
     * Bot Goes
     */
    function BotCheckBoxes(figure){
        var MaxBot,MaxPlayer,bot,MaxPlayer,playerArr,player;
        var nougArr = [];//playerArr
        var crossArr = [];//botArr
        var MaxNoug = 0;//MaxPlayer
        var MaxCross = 0;//MaxBot
        var nougs = [];//player
        var cross = [];//bot
        var middleBox = Math.floor(Number(Boxes)*Number(Boxes)/2);
        var nextBox = middleBox;
        var canWin = false;
        var unfigure = "";
        for (var a=0;a<GameLines.length;a++){
            nougArr[a] = GameLines[a].noughts;
            crossArr[a] = GameLines[a].crosses;
        }
        MaxNoug = Math.max.apply(null, nougArr);
        MaxCross = Math.max.apply(null, crossArr);
        if (figure=="crosses") {
            unfigure = "noughts";
            BotTurns(MaxCross,crossArr,cross,MaxNoug,nougArr,nougs);
        } else {
            unfigure = "crosses";
            BotTurns(MaxNoug,nougArr,nougs,MaxCross,crossArr,cross);
        }
        function BotTurns(MaxBot,botArr,bot,MaxPlayer,playerArr,player){
            if ((MaxBot==Number(Boxes)-1)) {
                //check if Bot can win
                for (var i=0;i<botArr.length;i++){
                    //check all lines with max number of figures
                    if (MaxBot==botArr[i]){
                        bot.push(i);
                        for (var a1=0;a1<Number(Boxes);a1++){
                            if (!GameLines[i].boxesIds[a1].fill){
                                nextBox = GameLines[i].boxesIds[a1].id;
                                canWin = true;
                            }
                        }
                    }
                }
            }
            if (!canWin) {
                //if bot can`t win, then it will be defend
                while (player.length==0) {
                    for (var i1=0;i1<playerArr.length;i1++){
                        //check all lines with max number of figures
                        if (MaxPlayer==playerArr[i1]){
                            for (var a2=0;a2<Number(Boxes);a2++){
                                if (!GameLines[i1].boxesIds[a2].fill){
                                    if (player.indexOf(GameLines[i1].boxesIds[a2].id)<0){
                                        player.push(GameLines[i1].boxesIds[a2].id);
                                    }
                                }
                            }
                        }
                    }
                    MaxPlayer--;
                }
                if (player.length>1) {
                    if (player.indexOf(middleBox)>=0) {
                        nextBox = middleBox;
                    } else {
                        var newPlayer = [];
                        if (SmartBot==2) {
                            if (click==3){
                                if (((GameBoxes[0].figure==unfigure)&&(GameBoxes[Number(Boxes)*Number(Boxes)-1].figure==unfigure))||((GameBoxes[Number(Boxes)-1].figure==unfigure)&&(GameBoxes[Number(Boxes)*Number(Boxes)-Number(Boxes)].figure==unfigure))) {
                                    for (var i2=0;i2<player.length;i2++) {
                                        if (player[i2]%2==1) {
                                            newPlayer.push(player[i2]);
                                        }
                                    }
                                } else {
                                    for (var i2=0;i2<player.length;i2++) {
                                        if (player[i2]%2==0) {
                                            newPlayer.push(player[i2]);
                                        }
                                    }
                                }
                            } else {
                                for (var i2=0;i2<player.length;i2++) {
                                    if (player[i2]%2==0) {
                                        newPlayer.push(player[i2]);
                                    }
                                }
                            }
                        }
                        if((newPlayer.length>=1)&&(SmartBot==2)) {
                            nextBox = newPlayer[Math.floor(Math.random() * newPlayer.length)];
                        } else {
                            nextBox = player[Math.floor(Math.random() * player.length)];
                        }
                    }
                } else {
                    nextBox = player[0];
                }
            }
        }
        return nextBox;
    }
    function startBot(figure) {
        figure = figure == "crosses" ? "noughts" : "crosses";
        if (smartBotBtn.checked) {
            SmartBot = true;
        }
        if (SmartBot==0) {
            var rand = EmptyBoxes[Math.floor(Math.random() * EmptyBoxes.length)];
            var id = "#box"+rand;
            var that = document.querySelector(id);
        } else {
            var rand = BotCheckBoxes(figure);
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
                    if ((Bot)&&(!finish)) {
                        startBot(figure);
                    }
                }
                console.log("GameBoxes:");
                console.log(GameBoxes);
                console.log("GameLines:");
                console.log(GameLines);
            });
        }
    }
})();