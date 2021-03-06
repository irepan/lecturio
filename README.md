# Test project
## Setup containerised system using Docker 
### Setup the following containers: 
1. Web frontend:
    1. PHP 7.0.33 
    2. Xdebug 
    3. Apache 
2. MySQL 
3. MongoDB 
### How to test the system 
The Web frontend should run a simple PHP application that connects both to MySQL and MongoDB, reads dummy data from them and displays it. 
Constraints 
* The system should be able to be deployed and run on a Mac (12.2) and Windows computer 
* All configurations should be injected and not hard-coded (for example MySQL DSN, etc.) 
* There is no specification of the DB schema or the PHP application. You are free to do the minimal work required to demo the setup. 
* It should be possible to build dev and prod version of the Web frontend container with PHP Xdebug turned on/off 
Results 
* Git repository with the Docker files 
* Short instruction 

# Solution Instructions
## Prerrequisites
### Docker
Install docker for your platform using the instructions for your platform at [Install-Docker](https://docs.docker.com/compose/install/compose-desktop/).
### Git Cli
Make sure you have a Git CLI installed on your terminal, otherwise try these instructions [Install Git CLI](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)

## Download Source
Create a clone of the code using the following clone instruction:
``` bash
git clone https://github.com/irepan/lecturio.git
cd lecturio
```

## Build the containers
``` bash
docker-compose build
```
## Create an environment file to inject configurations
This file should be named `.env` and should be at same folder as `docker-compose.yaml` file
contents should look like
```properties
MYSQL_DATABASE=test-database
MYSQL_USER=my-user
MYSQL_PASSWORD=mypassword
MYSQL_ROOT_PASSWORD=example
MONGO_INITDB_ROOT_USERNAME=root
MONGO_INITDB_ROOT_PASSWORD=password
ME_CONFIG_BASICAUTH_USERNAME=mexpress
ME_CONFIG_BASICAUTH_PASSWORD=mexpress
```
This file will hold the details to inject variables on environment and values are as follows

* **MYSQL_DATABASE** Means the name of the database to be created and where data is going to be inserted by default on MySQL database

* **MYSQL_USER** The user that will have all privileges granted on the MYSQL_DATABASE database

* **MYSQL_PASSWORD** The password for MYSQL_USER

* **MYSQL_ROOT_PASSWORD** The root password for MySQL

* **MONGO_INITDB_ROOT_USERNAME** MongoDB root user name

* **MONGO_INITDB_ROOT_PASSWORD** MongoDB root user's password

* **ME_CONFIG_BASICAUTH_USERNAME** Mongo Express username

* **ME_CONFIG_BASICAUTH_PASSWORD** MongoExpress password


## Run the environment
Make sure the following ports are free on your local box (or the box you are running the environment at)
* **80** (For the frontend)
* **3306** (For MySQL)
* **8085** (For PhpMyAdmin)
* **27017** ( For MongoDB)
* **8081**  ( For Mongo Express)

```
docker-compose up
```
### Check the php configuration
Open your browser and go to [php-config](http://localhost/phpinfo.php)
### Test the mysql actions
Open your browser and go to [php-mysql](http://localhost/mysql.php)
### Test the MongoDB actions
Open your browser and go to [php-mongo](http://localhost/mongotest.php)

## Check mysql using PhpMyAdmin
Open your browser and go to [php-myadmin](http://localhost:8085) leave the server field empty and you can use either root user with `MYSQL_ROOT_PASSWORD`, or `MYSQL_USER/MYSQL_PASSWORD`
## Check MongoDB activity using MongoExpress
Open your browser and go to [Mongo Express](http://localhost:8081) and use the `ME_CONFIG_BASICAUTH_USERNAME/ME_CONFIG_BASICAUTH_PASSWORD` on your `.env` dile

# Build docker image for production (without xdebug)
cd to Frontend folder and you can build your image using the following instruction:
```bash
docker build .
```
that instruction will make use of the Dockerfile instead of the Dockerfile.dev which is the one that has the xdebug enabled

# Architecture layout Porposal for AWS cloud

![Architecture Layout](./lecturio.png "Layout")

## High Availavility
We are getting use of **MySQL RDS** service from **AWS** and they will manage highg availability on their end, also we are making use of the **Managed MongoDB** service, both are directly connected to the **EKS** cluster's **VPC** so it is accesible for PODS in the cluster.

We suggest to have 3 zones on the cluster, so pods are being scheduled on them, and if one zone goes down there are other 2 up, that will ensure us a 99.95 Up time. If we need to set it on a 99.99 up time, then we will ned to create another cluster on a different region and link them using Multi-cluster ingress or a AWS Load Balancer.

The **self recover** and **scalability** is managed by the K8s HPA controller that makes sure a minimum of (3 in this case) pods are running correctly, and will scale up in case of high CPU and/or memory consumption, as they are all stateless, then they can be created and take down at will without a problem

