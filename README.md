# phpLoginsystem
A basic login system with PHP &amp; MySQL.

This login system is created using PHP as back-end, MySQL as database and simple HTML, CSS and JavaScript. The framework used for front-end is Bootstrap 5.

<hr>

<h1>Some explanation</h1>
In order to use this module, please fetch the files, configure your database information and set up autoload for PHP classes. Initially Composer was used for autoloading.

<h2>The functionality</h2>
<p>The module is pretty straight forward and simple. This project was a university "homework" from start and later I choose to develop it a bit more. I taught that maybe someone may find it useful for further developing or anything like that.</p>

<p>The system is ofcourse open for improvements but the basic functionality is that you create accout, if everything is ok - account stored in db, and you can use the account to log in. 
The register part has some twerks in order to complete the process. The email can be registered only once, the username must be unique and the password has some simple requirements. 
There is also simple validations to the whole process for inputs. The password is ofcourse hashed and stored in DB - can be improved.</p>

<p>Once you have a registered account, you can try and log in. There are some simple validation processes and checks in order to see if user exists, username correct and password is correct. 
Also there is a attempt counter, allowing a user to try and log in 5 times before locking account and requesting the user to reset the password. This process is little buggy and not 
complete but I added it as a start for further development as "You have made your attempts. Please wait 5 minutes" - stuff or something that way. Also, if log in is successful, 
a token will be created, randomized by digits and chars, which is used for "Remember me"-cookie to check if it is valid. If log in successful, sessions are created and if "Remember me" 
is checked, the cookie will be initialized with the token added to it.</p>

<h2>Further improvments</h2>
<p>With the useage of sessions and cookies, further security measures should be considered configuring the .ini file. I will try and improve this module a bit, as I myself learn more 
on PHP and security. Some ideas that I have, since login systems can be used for many different projects, are as following: </p>

<ul>
<li>Add unit check - if account is logged in from some unknown unit, an email should be sent to the user.</li>
<li>Add register_date and login_date / time to database to have information on sign up / sing in dates and times.</li>
<li>Overall code improvement - as I said being initially a university "homework", the code may need improvement. Feel free to improve it and add your taughts.</li>
</ul>

<p>Note the following: the project is tested locally and needs to be tested on a public server which also means that it may need some simple twerks if it doesn't work propperly. 
Please, feel free to get back with improvements and ideas for further development and also feel free to use this in your own projects.</p>
