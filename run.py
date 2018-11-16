from flask import Flask, render_template, Flask, request, flash
from forms import Login
from firebaseAPI import login, signup


app = Flask(__name__)
app.config.from_object('config')

#Initial Page for the Web App which takes our users to the login screen
@app.route('/', methods = ['GET', 'POST'])
def index():
    form = Login()
    if request.method == 'GET':
        return render_template('login.html', form = form)
    if request.method == 'POST':
        return render_template('home.html') #go to home screen
    

if __name__ == '__main__':
    app.run(debug=True)