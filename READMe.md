# QuizAddz 

## A web app that teaches first grade students in the US how to add a set of numbers, which can vary between adding one number, or adding five numbers. 

[Based on the Flask tutorial](https://blog.miguelgrinberg.com/post/the-flask-mega-tutorial-part-i-hello-world)

[Flask + Firebase](https://burhan.io/flask-web-api-with-firebase/) 

[Login Auth with Flash](https://pythonspot.com/login-authentication-with-flask/)

[Linux for Windows Venv Setup](http://timmyreilly.azurewebsites.net/python-with-ubuntu-on-windows/)

[The Wireframe Link](https://wireframe.cc/pro/pp/9be4d63ef204139/) 

There is a wireframe.pdf but it don't look good so use the link above please.


## To run
- Clone Repo
- Ensure you have python and pip install on your local environment 
- Cd into the project and create a virtual environment name venv by running the following command: 
```virtualenv venv```
- Activate your virtual environment, venv
```source venv/bin/activate```
- Confirm the virtual environment have been activated by checking to see if (venv) is in the command prompt 
- Install all the python dependencies in local virtual environment:
```pip install -r requirements.txt```
- Create a ```.env``` file to add [application configs](https://docs.google.com/document/d/13_Xjs_kcCqXCH41h3DVKtDAiLDu-3wSkAvgLAproglQ/edit?usp=sharing)
- Run program
```
export FLASK_APP=app.py
export FLASK_ENV=development
flask run 
```

OR

```python app.py```


## General Guidelines
- When ever you add a new pip package please also add it to your requirements.txt
```pip freeze > requirements.txt```


## Frontend 

- The QuizAddz, Learn how to add is a base template that will persist on all pages

- To create a new page, duplicate index.html and edit below the first line. 

## User Stories

The following **required** user stories are:

- [x] User can to login/logout.
- [ ] User can create challenge with a name at least 3 questions in challenge.
- [ ] User can answer challenge, see scores, and quit challenge.
- [ ] User can view all created challenges.
- [ ] User can delete challenges.

The following **optional** user stories are:

- [ ] User can complete other users challenges.
- [ ] User can compete with other users on same challenge.
- [ ] User can attempt questions multiple times.
- [ ] Challenge will reveal the answer after multiple failed attempts.

## Walkthroughs


Here's a walkthrough of implemented user stories:

<img src='https://imgur.com/v4UFdGK.gif'  title='Login/Logout' width='' alt='Video Walkthrough' />

GIF created with [LiceCap](http://www.cockos.com/licecap/).