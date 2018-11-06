# QuizAddz 

## A web app that teaches first grade students in the US how to add a set of numbers, which can vary between adding one number, or adding five numbers. 

[Based on the Flask tutorial](https://blog.miguelgrinberg.com/post/the-flask-mega-tutorial-part-i-hello-world)

[Flask + Firebase]( https://burhan.io/flask-web-api-with-firebase/) 

[Linux for Windows Venv Setup](http://timmyreilly.azurewebsites.net/python-with-ubuntu-on-windows/)


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
- Run program
```python run.py```


## General Guidelines
- When ever you add a new pip package please also add it to your requirements.txt
```pip freeze > requirements.txt```


## Frontend 

- The QuizAddz, Learn how to add is a base template that will persist on all pages

- To create a new page, duplicate index.html and edit below the first line. 

## User Stories

The following **required** user stories are:

- [ ] User can to login/logout.
- [ ] User can create challenge with a name at least 3 questions in challenge.
- [ ] User can answer challenge, see scores, and quit challenge.
- [ ] User can view all created challenges.
- [ ] User can delete challenges.

The following **optional** user stories are:

- [ ] User can complete other users challenges.
- [ ] User can compete with other users on same challenge.
- [ ] User can attempt questions multiple times.
- [ ] Challenge will reveal the answer after multiple failed attempts.
