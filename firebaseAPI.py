import pyrebase 
import os
from flask import session

config = {
    "apiKey":    os.environ.get('API_KEY'),
    "authDomain":    os.environ.get('AUTH_DOMAIN'),
    "databaseURL":    os.environ.get('DATABASE_URL'),
    "projectId":    os.environ.get('PROJECT_ID'),
    "storageBucket":    os.environ.get('STORAGE_BUCKET'),
    "messagingSenderId":    os.environ.get('MESSAGING_SENDER_ID')
}


firebase = pyrebase.initialize_app(config)

auth = firebase.auth()
db = firebase.database()

def signups(username, password):
    user = auth.create_user_with_email_and_password(username, password)
    print (user['idToken'], "was created")
    session['logged_in'] = True
    session['current_user'] = user
    return user

def login(username, password):
    user = auth.sign_in_with_email_and_password(username, password)
    print (user['idToken'], "was logged in")
    session['logged_in'] = True
    session['current_user'] = user
    return user

#TODO: andrervincent - review this once users can enter to landing page
def logout():
	return auth.signOut()

def getChallenges():
    challenges = db.child("challenges").get()
    print(challenges.val())
    return (challenges.val())
    
def createChallenges(challenge):
    #challenge is an object that contains whatever info a challenge has
    db.child("challenges").push(challenge)
    return True

def removeChallenge(challenge):
    #challenge is an object that contains whatever info a challenge has
    db.child("challenges").child("challenge").remove(challenge['idToken'])
    return True


	



