import pyrebase 
import os

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

def signup(username, password):
    user = auth.create_user_with_email_and_password(email, password)
    return auth.get_account_info(user['idToken'])

def login(username, password):
    return True

#TODO: andrervincent - review this once users can enter to landing page
def logout():
	return auth.signOut()
	



