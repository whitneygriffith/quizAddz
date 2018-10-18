from flask import render_template, Flask, request, flash
from app import app
from firebase import firebase
from forms import Login

#Initial Page for the Web App which takes our users to the login screen
@app.route('/', methods = ['GET', 'POST'])
@app.route('/login', methods = ['GET', 'POST'])
def index():
    form = Login()
    if request.method == 'POST':
        if form.validate() == False:
            flash('All fields are required.')
            return render_template('login.html', form = form)
        else:
            return render_template('home.html') #go to home screen
    elif request.method == 'GET':
        return render_template('login.html', form = form)    