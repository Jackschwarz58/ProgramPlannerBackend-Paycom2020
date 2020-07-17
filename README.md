# Paycom Summer Engagement Program - Session Planner Backend

##### This is a web application that was created as part of the Paycom Summer Engagement Program. <br> This is the first time I have really dived into PHP, SQL, or React so go easy on me :)

### To view a more general overview of the application and see the Front End codebase, please visit the write-up over on the [Front End Repo](https://github.com/Jackschwarz58/ProgramPlanner-Paycom2020)

---

#### For a video overview and demo, click the video below:
[![Video Overview](https://i.imgur.com/v6ltiJI.jpg)](https://www.youtube.com/watch?v=Z091szPwp2Q)

## About

This is a web application that is designed to help users sign up for, view information about, and edit information regarding sessions in the Paycom Summer Engagement Program. This repo is dedicated to the backend functionality and setup for the application.

![Dashboard](https://i.imgur.com/xUnAq7j.png)

The application is written in Javascript, HTML, CSS, SQL, and PHP with help from external frameworks such as Bootstrap, ReactJS, and Webpack.


## Functionality

### Register and Login/Logout

When the user signs up for an account, a row is added to the connect MySQl database with information regarding the user. This is called upon everytime the application needs to check or get access to user information to authenicate login, check if a user exists, or to create a relationship between the user a defined session.

When logging in, the application will make a API call to a PHP file which validates the user's input against the info stored in the database. In addition to this, a cookie is set confirming the user is logged in and set by defualt to clear itself once the browser session ends. If the user checks the *Keep Me Logged In* box at login, the cookie is instead stored for a month, or until the user logs out. 

I used a cookie as opposed to JWT as different online resources recommended cookies as a viable option for smaller applications and allowed for easier control over things like expiration time. Going forward, this would need to be altered in order to work with JWT tokens, but cookies works just as well for this small scale project.

![Login](https://i.imgur.com/2TMcsM2.png)

### Session Manipulation

The main fuctionality of the application is dedicated to manipulating and interacting with sessions. These sessions are representative of a session within the Paycom Summer Enagagement Program. These functions are all handled through PHP calls to the MySQL database. The `sessions` folder in the `api/` folder contains all of the direct interfaces with the sessions.

The application has error handlers for multiple different unintended outcomes relating to how the data is manipulated. An error is shown in a window popup that conatains information about the unexpected issue and, if applicable, how the user can correct any unintended mistake.

![Edit Description](https://i.imgur.com/8c0bZug.png)


For a better explanation of how the application works generally, I have a writeup over on the [Front End GitHub Repo](https://github.com/Jackschwarz58/ProgramPlanner-Paycom2020)

## Setup Instructions

#### Prerequisites

This setup requires a few things to work correctly:
1. A local XAMPP instance
2. An appropriately setup SQL server on said XAMPP instance

#### Step-By-Step Instructions
1. Pull the GitHub repo and extract it on your computer.
2. Get [XAMPP up and running](https://www.ionos.com/digitalguide/server/tools/xampp-tutorial-create-your-own-local-test-server/) and navigate to the `htdocs/` folder. Make sure the `Apache` and `MySQL` services are running.
3. Copy the contents of the `XAMPP/` folder found in the repo into the root of `htdocs/`. <br> At this point your `htdocs/` folder should look like this. 

```
htdocs    
│
└──paycomProject
   │   assets/
   │   api/
   │   index.html
   │   README.md
   │   paycom-project-db.sql
   └───app
       │   build/
```
3. Make sure XAMPP is running the open up phpMyAdmin by going to `http://localhost/phpmyadmin` in your browser
4. Create a new database named `paycom_project_db` and navigate to the **_import_** tab.
5. Under this tab, drag the file `paycom-project-db.sql` into the browser window. This will populate your database with the correct tables and columns as well as add some sample data. (1)
6. With XAMPP running, find the IP Address shown in application's main view (should look something like 192.168.xx.x) 
7. Navigate to `http://{ip address from previous step}/paycomProject/index`
8. You should be up and running!

##### Notes
(1) For simplicity sake, there is no sql username or password set by default or defined in the PHP files. If you have set one up, you will need to navigate to `htdocs/paycomProject/api/dbh.php` and change the $dB fields. 

#### If there are any issues getting this setup, please let me know by sending me an email at <Jackschwarz58@gmail.com>.




