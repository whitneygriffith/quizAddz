from flask import Flask, render_template, request, flash, redirect, session, abort
from forms import Login
from firebaseAPI import login, signup, logout
import os
from sqlalchemy.orm import sessionmaker
from tabledef import *
engine = create_engine('sqlite:///tutorial.db', echo=True)
 

app = Flask(__name__)
app.config.from_object('config')

 
@app.route('/')
def home():
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
 
    Session = sessionmaker(bind=engine)
    s = Session()
    query = s.query(User).filter(User.username.in_([POST_USERNAME]), User.password.in_([POST_PASSWORD]) )
    result = query.first()
    if result:
        session['logged_in'] = True
    else:
        flash('wrong password!')
    return home()
 

@app.route("/logout")
def logout():
    session['logged_in'] = False
    return home()

@app.route('/test')
def test():
 
    POST_USERNAME = "python"
    POST_PASSWORD = "python"
 
    Session = sessionmaker(bind=engine)
    s = Session()
    query = s.query(User).filter(User.username.in_([POST_USERNAME]), User.password.in_([POST_PASSWORD]) )
    result = query.first()
    if result:
        return "Object found"
    else:
        return "Object not found " + POST_USERNAME + " " + POST_PASSWORD

if __name__ == '__main__':
    app.secret_key = os.urandom(12)
    app.run(debug=True)