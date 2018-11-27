(function(){
    
    if(document.getElementById('register-form'))
        document.getElementById('register-form').onsubmit = function(e){
        
        e.preventDefault();
        
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var repPassword = document.getElementById('rep-password').value;
        var role = document.getElementById('role').value;
        
        if(!username||!password||!repPassword||!role) return;
        
        $('#message').addClass('hide');
        
        if(password!=repPassword){
            $('#message').removeClass('hide');
            document.getElementById('message').innerHTML = 'Passwords don\'t match';
            return;
        }//if
        
        var postData = {'task':'register', 'username':username, 'password':password, 'role':role};
        
        $.post('database.php', postData, function(data){
            
            if(data=='taken'){
                $('#message').removeClass('hide');
                document.getElementById('message').innerHTML = 'Username taken';
                return;
            }//if
            
            localStorage.setItem('user',username);
            
            if(role=='teacher') window.location.replace('create-problems.html');
            else window.location.replace('challenges.html');
        });
        
    }//register form
    
    
    
    
    
    
    if(document.getElementById('login-form'))
        document.getElementById('login-form').onsubmit = function(e){
        e.preventDefault();
        
        localStorage.removeItem('user');
            
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        
        $('#message').addClass('hide');
            
        if(!username||!password) return;
            
            var postData = {'task':'login','username':username,'password':password};
            
            $.post('database.php',postData,function(data){
                
                if(data=='false'){
                    $('#message').removeClass('hide');
                    document.getElementById('message').innerHTML = 'Wrong username or password';
                    return;
                }//if
                
                localStorage.setItem('user',username);
                if(data=='teacher') window.location.replace('create-problems.html');
                else window.location.replace('challenges.html');
            });
            
    }//if login-form
    
    
    
    
    
    
    var questionSet = 1;//
    if(document.getElementById('add-num'))
        document.getElementById('add-num').onclick = function(){
            
            //Increment when new num is added
            var questNum = document.getElementsByClassName('question-num');
            questNum = questNum[questionSet-1];
            questNum.value = (questNum.value*1)+1;
            
            var addDiv = document.getElementById('add-div');
            
            var additional = "<input type='number' class='num-input bm20'>";
            addDiv.innerHTML = additional;
            addDiv.id = "";
            
            var newEl = document.createElement('div');
            newEl.id = 'add-div';
            
            addDiv.parentNode.insertBefore(newEl, addDiv.nextSibling);
            
        }//on click add num
    
    if(document.getElementById('new-question'))
        document.getElementById('new-question').onclick = function(){
            
        //increment questionSet to indicate moving on to new question
            questionSet++;
            
        var addDiv = document.getElementById('add-div');
            addDiv.parentNode.removeChild(addDiv);
            
        var newQuestion = document.getElementById('new-question-div');
            newQuestion.innerHTML = "<hr><div><input type='hidden' class='question-num' value=2><input type='number' class='num-input bm20'></div><div><input type='number' class='num-input bm20'></div><div id='add-div'></div><div id='new-question-div'></div>";
            newQuestion.id = '';
            
        }
    
    if(document.getElementById('challenge-form'))
        document.getElementById('challenge-form').onsubmit = function(e){
            
            e.preventDefault();
            
            var numArray = '';
            var arrayString = '';
            var number;
            var task = 'challenge';
            var startingFrom = 0;
            
            //array of the hidden fields that indicate number of nums per question
            var questionNums = document.getElementsByClassName('question-num');
            
            //array of fields with numbers
            var numInputs = document.getElementsByClassName('num-input');
            
            
            for(var i = 0; i < questionNums.length; i++){
                
                var numsInQuestion = (questionNums[i].value)*1;
                
                for(var y = startingFrom; y < startingFrom + numsInQuestion*1; y++){
                    number = numInputs[y].value;
                    
                    if(y < (startingFrom + numsInQuestion*1)-1 && number!=='') number += ',';
                    arrayString += number;
                }//for
                if(arrayString) numArray += '['+arrayString+']';
                arrayString = '';
                //if(i < questionNums.length-1) numArray += ',';
                startingFrom += numsInQuestion;
                
            }//for
            
            var userName = localStorage.getItem('user');
            var postData = {'task':task, numbers:numArray, username:userName};
            
            $.post('database.php',postData,function(data){
                
                alert('Challenge created!');
                location.reload();
                
            });//post database.php
            
        };//challenge-form
    
    
    
    //loads created challenges into page
    if(document.getElementById('challenges-div')){
        var task = 'get teacher challenges';
        var userName = localStorage.getItem('user');

        $.post('database.php',{'task':task, username:userName}, function(data){
            
            document.getElementById('challenges-div').innerHTML = data;
            var deletes = document.getElementsByClassName('link');
            for(var i = 0; i < deletes.length; i++){
                deletes[i].onclick = function(){
                    task = 'delete task';
                    deleteId = this.id;
                    $.post('database.php',{username:userName, task:task, deleteId:deleteId}, function(data){
                        
                        location.reload();
                    });
                    
                }//deletes
            
            }//for
        });
        
    }//if
    
    
    
    
    //load challenge list for student
    if(document.getElementById('challenges-div2')){
        var username = localStorage.getItem('user');
        var task = 'get challenges';
        $.post('database.php',{'username':username, task:task},function(data){
            document.getElementById('challenges-div2').innerHTML = data;
        });
    }//if
    
    //load challenge for student
    if(document.getElementById('challenges-div3')){
        var username = localStorage.getItem('user');
        var task = 'get challenge';
        var challengeId = window.location.href;
        url = challengeId.split('?');
        challengeId = url[url.length-2];
        rowId = url[url.length-1];
        
        $.post('database.php',{'username':username, task:task, 'challengeId':challengeId, 'rowId':rowId},function(data){
            document.getElementById('challenges-div3').innerHTML = data;
            if(document.getElementById('submit-answers'))
                document.getElementById('submit-answers').onsubmit = function(e){
                e.preventDefault();
                var rightAnswers = 0;
                var score = 0;
                var answersArray = document.getElementsByClassName('answer-input');
                for(var i = 0; i < answersArray.length; i++){
                    if(answersArray[i].value==answersArray[i].getAttribute('answer')){
                        rightAnswers++;
                    }
                }//for
                score = rightAnswers+'/'+answersArray.length;
                alert('Score: '+score);
                task = 'submit score';
                $.post('database.php',{'username':username, task:task, 'challengeId':challengeId, 'score':score},function(data){
                    location.reload();
                });
                
            }
        });//post
    }//if
    
})();
