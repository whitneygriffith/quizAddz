import pyrebase 

config = {
    "apiKey": "AIzaSyDuFipa0L7yKmicV_7qQJLxpFlL55drsLQ",
    "authDomain": "quizadzz.firebaseapp.com",
    "databaseURL": "https://quizadzz.firebaseio.com",
    "projectId": "quizadzz",
    "storageBucket": "quizadzz.appspot.com",
    "messagingSenderId": "276254734113"
}

firebase = pyrebase.initialize_app(config)

auth = firebase.auth()

def signup(username, password):
    user = auth.create_user_with_email_and_password(email, password)
    return auth.get_account_info(user['idToken'])

def login(username, password):
    return True



