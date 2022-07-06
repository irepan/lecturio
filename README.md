# Test project
##Setup containerised system using Docker 
###Setup the following containers: 
1. Web frontend: 
a. PHP 7.0.33 
b. Xdebug 
c. Apache 
2. MySQL 
3. MongoDB 
###How to test the system 
The Web frontend should run a simple PHP application that connects both to MySQL and MongoDB, reads dummy data from them and displays it. 
Constraints 
● The system should be able to be deployed and run on a Mac (12.2) and Windows computer 
● All configurations should be injected and not hard-coded (for example MySQL DSN, etc.) 
● There is no specification of the DB schema or the PHP application. You are free to do the minimal work required to demo the setup. 
● It should be possible to build dev and prod version of the Web frontend container with PHP Xdebug turned on/off 
Results 
● Git repository with the Docker files 
● Short instruction 

#Solution Instructions
##Prerrequisites
###Docker
Install docker for your platform using the instructions for your platform at [Install-Docker](https://docs.docker.com/compose/install/compose-desktop/).
###Git Cli
Make sure you have a Git CLI installed on your terminal, otherwise try these instructions [Install Git CLI](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)

##Download Source
Create a clone of the code using the 