from flask_wtf import Form
from wtforms import TextField, PasswordField, SubmitField
from wtforms import ValidationError, validators

class Login(Form):
    email = TextField('Username', [validators.Required("Please enter your email."), validators.Email("Please enter your email.")])
    password = PasswordField('Password', [validators.Required("Please enter your password"), validators.Length(min=4, max=15)])
    submit = SubmitField("Enter")