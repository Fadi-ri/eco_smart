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


    <h1 style="color: blue;">Front-end</h1>
    
    --fadi--
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
    first week of october
    * added in fonctions.php multiple flash security checks to be implemented in the code later
    
    * connection parameters for Mysql /XAMPP in db.php
     


