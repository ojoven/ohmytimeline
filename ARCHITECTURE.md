ARCHITECTURE
=======

In this document, I'll try to resume the architecture of the project.

It's not a complex project, but this will help in case anyone tries to play around with it.


Framework
----------------
We're using here CakePHP 2.4.6

It's an old version of CakePHP and not the framework I'd use these days, but this project is based in another one I built quite some time ago and I was using CakePHP with this version at that time.


MVC
----------------
The project follows a MVC pattern.

Controllers:
* IndexController: main controller that handles all the requests to the site
* AppController: there are some auxiliary functions that can be reused in all controllers in the case we needed more.

Models:
* TwitterList: single model, it handles all the backend logic of the project, connecting to Twitter API's endpoints, creating the list, etc.

Views:
* Layouts/ajax.ctp: it simply renders the AJAX requests
* Layouts/default.ctp: default layout that includes header and footer.
* Index/index.ctp: it handles the rendering of the home page
* Index/viewer.ctp: it handles the redirection to the Twitter app, it's the page that the users will add as direct access to their mobiles.
* Index/createlist.ctp: this is the iframe that will help us render in real time the progress of the backend process.


Flow
----------------
1. The user arrives to the homepage via / request. 

Notes
----------------
Please be aware that this project would need some refactoring.



Credits
---------------
* [CakePHP](http://www.cakephp.org) - The rapid development PHP framework
* [TwitterOAuth](http://abrah.am) - Twitter OAuth by Abraham Williams
