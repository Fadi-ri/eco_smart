Hi Team,
this document is going to include:
 - instructions to improve working habits 
 - the general working steps to create the app 
 - the individual dev progress

* You will need to update this file with your progress necessarily at every PR, and every few commits would be preferable to help me review your PR. Please write in your specified section so we know who to address when we are inquiring about a specific feature (if you don't find your section, make one by writing your name, like this --name-- then write under it)

    * Git working habits to adopt:
    
 - to start working on a feature please create a new branch by running the following on your terminal
 <code>
 git branch the_branches_name 
 git switch the_branches_name
 </code>
 <br>
 then you'll need to create a PR to dev from your branch on the Github web site (easier and most preferably) or by running the following
 <code>
 gh pr create --base dev --head hero_creation --title "write your message here" --body "Details of changes" --reviewer <Fadi-ri>
 </code>
 don't forget to add me (fadi-ri) to review your PR


* Front-end we are going to<b style="color : red"> heavily</b> use the bootstrap framework for both the css and JS to facilite the work
i would aim at 80% to 90% of the code 
You will find the color pallet from Kay's work in the style.css file and we are going to improve the styling of the bootstrap class to better fit our app

* For now 08/10/2026
    <h1 style="color: blue;">General project architecture and organizing</h1>
    after the teams last september weekly  
    the team have agreed on the final project idea and the different features functionality and agreed on the "cahier des charges created by Fadi"
    after the weekly
    fadi created the BDD of the app (the diagram is added to the cahier des charges)
    and finished writing le cahier des charges 
    and created the general project structure on git 
    
    <h1 style="color: blue;">Design UI/UX</h1>
    kay has made progress on the general design on figma he completed the following :
    
    - A global visual identity for the app 
    - The ui/ux bases
    - The design for the :
                - Header
                - Footer
                - landing page (hero, inf ..)
                - feed (post format)
                - formulaire

    still a work in progress ordered by urgency :
                - project page 
                - Crud dashboard page 
                - personal account page
                - pdf styling
                - dark mode
                -login
                -sign-up(follow the sql tabel)

    <h1 style="color: blue;">Front-end</h1>
    
    --fadi--
    <br>
     Worked on creating html structure for the following (using REACT classes to make it easier) :
    - footer
    - header
    - hero
     still to do :
    - everything else

    <h1 style="color: blue;">Back-end</h1>


    --fadi--

    * created the database for the app and configured it for the form and project
    still working on the database to add profiles and to store posts

    
    <h1 style="color: blue;">Security</h1>
    --fadi-- 
    <br>
    first week of october
    * added in fonctions.php multiple flash security checks to be implemented in the code later
    
    * connection parameters for Mysql /XAMPP in db.php
     
    --


* For now 16/10/2026
    <h1 style="color: blue;">General project architecture and organizing</h1>
    the base of the app is now standing, you can go from the landing page to the feed, to the projects catalogue and to the submission form without a dead link
    config.php is now the single entry point of every page : it starts the session then loads includes/db.php and includes/functions.php, so please never require db.php directly anymore, just put
    <code>
    require_once __DIR__ . '/config.php';
    </code>
    at the top of your page and you get the connexion plus all the helpers
    also renamed includes/hearder.php to includes/header.php (the typo was breaking the includes on the pages created after it), so update your branch before you complain that the header disappeared
    there is a .gitignore now, uploads/ and debug_upload.php are in it. so the images you upload while you test stay on your machine and the posts of the feed will look broken on the others, it is normal, do not try to fix it by commiting your uploads folder

    <h1 style="color: blue;">Design UI/UX</h1>
    the list from the 08/10 is moving, what is now done and integrated in the code :

    - Header styling
    - Hero styling
    - feed (post format)
    - formulaire
    - pdf styling (the recap sheet exports with jsPDF)
    - dark mode (started, see below)
    - login / sign-up

    still a work in progress ordered by urgency :
                - Crud dashboard page
                - personal account page
                - project page detail (the catalogue is there, the single project view is not)

    <h1 style="color: blue;">Front-end</h1>

    --fadi--
    <br>
    * the color pallet and the bootstrap overrides are all in css/style.css, it grew a lot this week so look there before writing new css, there is a good chance the class already exists
    * dark mode : started but NOT finished, do not count on it yet. js/main.js only holds applyTheme() which sets data-theme on <html> and <body> and swaps the toggle icon. the DOMContentLoaded calls initThemeManager(), initBootstrapComponents() and initInteractiveUI() and none of those three is written, so the file throws as soon as a page loads it. i take it, nobody else touch main.js for now. the dark variables are in style.css, if you add a new component please declare its colors for the two themes or it will look broken at night
    * built the following pages :
    - feed.php (list of the posts with their image)
    - projets.php (catalogue of the submitted projects with the status badges)
    - inscription.php (the big submission form, 3 steps with a live progress bar)
    - create_post.php (small form to publish a post with an image)
    * js/form-validation.js does the live validation and moves the progress bar, js/jspdf-export.js builds the pdf from the recap panel
     still to do :
    - admin.php, contact.php and a_propos.php are still empty files, they are in the repo only to hold the place
    - the single project page

    <h1 style="color: blue;">Back-end</h1>

    --fadi--

    * database.sql now carries 4 tables : users, projets_inscriptions, posts and thematiques, so the database is not only about the form anymore, it stores the accounts and the posts like i said last week
    * actions/create.php receives the submission form, checks the CSRF token, checks the required fields, then inserts in projets_inscriptions. the pattern is : traitement in actions/, affichage in the page, please keep it that way for your own features
    * includes/functions.php got the helpers everybody is going to need :
    - e() to escape before echoing
    - set_flash() / display_flash() for the messages between two pages
    - get_status_badge(), format_currency(), format_date() for the display
    - generate_csrf_token() / verify_csrf_token()
    - get_project_stats() for the numbers of the future dashboard
    * includes/db.php : if MySQL/XAMPP is not started it falls back on a local sqlite file and recreates the tables it needs, that way you can keep working on your laptop without launching the whole stack. Database::getConnection() is kept as an alias so the older pages do not break
     still to do :
    - create_post.php still writes 'Admin' as the author, it has to read the session now that the login exists

    --damian--
    <br>
    * added login.php, the connexion form and its traitement

    * merge of future/login cleaned up, what was broken and is now fixed :
    - login.php was querying a table named utilisateurs which does not exist, it reads users now and takes the prenom with it
    - the sqlite fallback of includes/db.php did not have the users table, so the login was dead as soon as MySQL was off, the table is there now and follows the same schema as the MySQL one
    - creat_acount.php had its own inline stylesheet and inserted into utilisateurs, it uses the shared header/footer and css/style.css now and writes in users
    - removed a body { display:flex } in css/style.css that was squeezing the navbar, the content and the footer into one centered column

    <h1 style="color: blue;">Security</h1>

    --damian--
    <br>
    * login.php validates the email with filter_var before touching the database, the query is prepared and the password is checked with password_verify

    --fadi--
    <br>
    second week of october
    * reworked login.php : session_regenerate_id(true) right after a successful connexion so we do not keep the id of the visitor, and the error message stays the same whether it is the email or the password that is wrong, otherwise you hand an attacker a list of the valid accounts
    * creat_acount.php for the registration, the password goes through password_hash before the insert, never store it in clear even for the tests
    * the CSRF token is generated in the submission form and verified in actions/create.php, do the same on every form you add
    * every value coming from the database or from $_POST is printed through e(), if you write a new page and you echo something raw it will be refused at the PR

    --
