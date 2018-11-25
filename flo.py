from flask import Flask, render_template, request, flash, redirect, session, abort
from forms import Login
#from firebaseAPI import login, logout, signups, getChallenges, createChallenges
import os
from sqlalchemy.orm import sessionmaker
from tabledef import *
engine = create_engine('sqlite:///tutorial.db', echo=True)
 

app = Flask(__name__)
app.config.from_object('config')

 
@app.route('/')
def home():
    return render_template('flo.html')
    if not session.get('logged_in'):
        print(os.environ.get('API_KEY'), 'double checking env keys are read')
        return render_template('login.html')
    else:
        return render_template('home.html')

#Initial Page for the Web App which takes our users to the login screen
@app.route('/login', methods = ['POST'])
def do_login():
    POST_USERNAME = str(request.form['username'])
    POST_PASSWORD = str(request.form['password'])
 
    #user = login(POST_USERNAME, POST_PASSWORD)

    #print (user['idToken'], "was logged in")
    return home()

@app.route('/signup', methods = ['POST', 'GET'])
def signup():
    if request.method == 'GET':
        return render_template('signup.html')
    
    POST_USERNAME = str(request.form['username'])
    POST_PASSWORD = str(request.form['password'])
 
    #user = signups(POST_USERNAME, POST_PASSWORD)

    #print (user['idToken'], "was created")
    return home()
 
@app.route("/logout")
def logout():
    session['logged_in'] = False
    return home()


if __name__ == '__main__':
    app.secret_key = os.urandom(12)
    app.run(debug=True)