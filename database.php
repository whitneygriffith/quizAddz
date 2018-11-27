<?php

mysql_connect('localhost','root','');
mysql_select_db('quizaddz');

$task = $_POST['task'];
$username = $_POST['username'];

//register
if($task=='register'){
 
$password = $_POST['password'];
$hashPW = hash('sha256', $password);
$role = $_POST['role'];
$time = time();

$query = mysql_query("SELECT * FROM users WHERE user='$username'");
$numrows = mysql_num_rows($query);

if(!$numrows) mysql_query("INSERT INTO users VALUES ('','$username','$role','$hashPW','','',$time)");
else{
    echo 'taken';
    return;
}

echo 'done';

}//if register


//login
if($task=='login'){
    $password = $_POST['password'];
    $hashPW = hash('sha256', $password);
    $query = mysql_query("SELECT * FROM users WHERE user='$username' AND password='$hashPW'");
    $numrows = mysql_num_rows($query);
    if($numrows){
        $get = mysql_fetch_assoc($query);
        echo $get['role'];
        
    }
    else echo "false";
    
}//if login



//create challenge
if($task=='challenge'){
    $numbers = $_POST['numbers'];
    
    $query = mysql_query("SELECT * FROM users WHERE user='$username'");
    $get = mysql_fetch_assoc($query);
    $challenge = $get['challenge'];
    $randNum = rand();
    settype($randNum, "string");
    
    if($challenge!="") $challenge = $challenge.",";
    if($challenge) $challenge = $challenge."=>";
    $addedChallenge = $challenge.$randNum."=>".$numbers;
    mysql_query("UPDATE users SET challenge='$addedChallenge' WHERE user='$username'");
    echo $username;
}//if login


if($task=='get teacher challenges'){
    
    $query = mysql_query("SELECT * FROM users WHERE user='$username'");
    $get = mysql_fetch_assoc($query);
    $challenges = $get["challenge"];
    $challengeArray = "";
    $returnDiv = "";
    
    if(!$challenges) return;
    
    $challengesArray = explode("=>",$challenges);
    
    for($i = 0; $i < count($challengesArray)-1; $i+=2){
        $challengeId = $challengesArray[$i];
        
        $challengeArray = $challengesArray[$i+1];//questions in a challenge
        $challengeArray = str_replace("[","",$challengeArray);
        $challengeArray = explode(']',$challengeArray);
        $returnDiv .= "<div class='link' id='".$challengeId."'><b>Delete challenge</b></div>";
        for($y = 0; $y < count($challengeArray); $y++){
            $problemFormat = trim($challengeArray[$y],",");
            if(!$problemFormat) continue;
            $problemFormat = str_replace(","," + ",$problemFormat);
            $returnDiv .= "<div class='problem-row'>".$problemFormat;
            
            $returnDiv .= "</div>";
        }//for
    }//for
    
    echo $returnDiv;
    
}//if get teacher challenges


if($task=='delete task'){
    $deleteId = $_POST['deleteId'];
    $query = mysql_query("SELECT * FROM users WHERE user='$username'");
    $get = mysql_fetch_assoc($query);
    $challenges = $get['challenge'];
    $challenges = explode('=>',$challenges);
    for($i = 0; $i < count($challenges)-1; $i++){
        if($challenges[$i]==$deleteId){
            unset($challenges[$i]);
            unset($challenges[$i+1]);
        }
    }//for
    $challenges = implode('=>',$challenges);
    echo $challenges;
    mysql_query("UPDATE users SET challenge='$challenges' WHERE user='$username'");
}//if


if($task=='get challenges'){
    $query = mysql_query("SELECT * FROM users WHERE role='teacher'");
    $returnDiv = "";
    
    while($getArray = mysql_fetch_array($query)){
        
    $challenges = $getArray["challenge"];
    $creator = $getArray['user'];
    $id = $getArray['id'];
    $challengeArray = "";
    
    if(!$challenges) return;
    
    $returnDiv .= "<div><b>Made by ".$creator."</b></div><p>";
        
    $challengesArray = explode("=>",$challenges);
    
    for($i = 0; $i < count($challengesArray)-1; $i+=2){
        $challengeId = $challengesArray[$i];
        
        $challengeArray = $challengesArray[$i+1];//questions in a challenge
        $challengeArray = str_replace("[","",$challengeArray);
        $challengeArray = explode(']',$challengeArray);
        
        //get last score
        $query2 = mysql_query("SELECT * FROM users WHERE user='$username'");
        $get = mysql_fetch_assoc($query2);
        $userChallenges = $get['challenge'];
        $userChallengesArray = explode(',',$userChallenges);
        $lastScore = '';
        for($y = 0; $y < count($userChallengesArray); $y++){
            $scoreInfo = explode(':',$userChallengesArray[$y]);
            $searchId = $scoreInfo[0];
            if($searchId==$challengeId){
                $lastScore = $scoreInfo[1];
            }//if
        }//for
        
        $returnDiv .= "<div class='link' id='".$challengeId."' rowid='".$id."'><a href='do-challenge.html?".$challengeId."?".$id."'><b>Do this challenge</b></a></div> <div>Score: ".$lastScore."</div>";
        for($y = 0; $y < count($challengeArray); $y++){
            $problemFormat = trim($challengeArray[$y],",");
            if(!$problemFormat) continue;
            $problemFormat = str_replace(","," + ",$problemFormat);
            $returnDiv .= "<div class='problem-row'>".$problemFormat;
            
            $returnDiv .= "</div>";
        }//for
        
    }//for
    $returnDiv .= "<hr>";
    }//while
    echo $returnDiv;
}//if


if($task=='get challenge'){
    $postChallengeId = $_POST['challengeId'];
    $rowId = $_POST['rowId'];//row of challenge
    
    $query = mysql_query("SELECT * FROM users WHERE id='$rowId'");
    $get = mysql_fetch_assoc($query);
    $challenges = $get["challenge"];
    $challengeArray = "";
    $returnDiv = "<form id='submit-answers'>";
    
    if(!$challenges) return;
    
    $challengesArray = explode("=>",$challenges);
    
    for($i = 0; $i < count($challengesArray)-1; $i+=2){
        $challengeId = $challengesArray[$i];
        if($challengeId != $postChallengeId) continue;
        $challengeArray = $challengesArray[$i+1];//questions in a challenge
        $challengeArray = str_replace("[","",$challengeArray);
        $challengeArray = explode(']',$challengeArray);
        
        for($y = 0; $y < count($challengeArray)-1; $y++){ //the -1 remove the element create by the last ']'
            $problem = str_replace(',',' + ',$challengeArray[$y]);
            $numArray = explode(' + ',$problem);
            $answer = 0;
            for($x = 0; $x < count($numArray); $x++){
                $answer += $numArray[$x];
            }//for
            $returnDiv .= "<div class='form-label center'>".$problem."</div>";
            $returnDiv .= "<input class='answer-input' answer='".$answer."' type='number' placeholder='='/>";
        }//for
        
    }//for
    
    $returnDiv .= "<div class='form-label center'><input class='form-button' type='submit' value='Submit'></div></form>";
    
    echo $returnDiv;
}//if


if($task == 'submit score'){
    $challengeId = $_POST['challengeId'];
    $score = $_POST['score'];
    
    $query = mysql_query("SELECT * FROM users WHERE user='$username' AND role='student'");
    $get = mysql_fetch_assoc($query);
    $challenges = $get['challenge'];
    $id = $get['id'];
    $challengeFound = false;
    
    $challengesArray = explode(',',$challenges);
   
    for($i = 0; $i < count($challengesArray); $i++){
        $findChallenge = $challengesArray[$i];
        $findChallengeIdArray = explode(':',$findChallenge);
        $findChallengeId = $findChallengeIdArray[0];
        if($findChallengeId==$challengeId){
            $challengeFound = true;
            $newSubmittion = $challengeId.":".$score;
            $challengesArray[$i] = $newSubmittion;//update score
            $submitUpdatedScores = implode(',',$challengesArray);
            mysql_query("UPDATE users SET challenge='$submitUpdatedScores' WHERE id='$id'");
            
        }//if
    }//for
    if(!$challengeFound){
        if($challenges != '') $challenges .= ',';
        $challenges .= $challengeId.':'.$score;
        mysql_query("UPDATE users SET challenge='$challenges' WHERE id='$id'");
    }//if
}//if


?>
