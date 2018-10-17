from flask import render_template
from app import app

#Initial Page for the Web App which takes our users to the login screen
@app.route('/')
@app.route('/login')
def index():
    user = {'nickname': 'Miguel'}  # fake user
    posts = [  # fake array of posts
        { 
            'author': {'nickname': 'John'}, 
            'body': 'Beautiful day in Portland!' 
        },
        { 
            'author': {'nickname': 'Susan'}, 
            'body': 'The Avengers movie was so cool!' 
        }
    ]
    return render_template("login.html",
                           title='Home',
                           user=user,
                           posts=posts)