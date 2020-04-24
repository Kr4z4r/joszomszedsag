# Docker Setup Guide 

This guide is intended to tech-savy people or developers looking to contribute 
to this project.

## Prerequisites
 - [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
 - [Docker](https://docs.docker.com/get-docker/)
 - [nodejs and npm](https://nodejs.org/en/download/)
 
(!) Stop any services running on port 80. 

## Running the stack

Set up your github account, with a ssh key then clone this repository and run 
the docker compose stack

```bash
git clone git@github.com:Kr4z4r/joszomszedsag.git
cd joszomszedsag
docker-compose up
```

### Add application domain to /etc/hosts

We use a proxy server to allow the application to be served from a convenient .local 
domain. The default domain configured for the application is `joszomszedsag.local`. 
It can be changed in the docker-compose.yml file, however it's recommended to keep 
the defaults.

Open your hosts file (`sudo nano /etc/hosts`) and add the following entry at the end 

```text
127.0.0.1	joszomszedsag.local
```

## Useful commands

 - stopping the stack: either Ctrl+C in the terminal where you started
 with `docker-compose up`, or, in another terminal, navigate to the app 
 folder (the one containing docker-compose.yml file) and run `docker-compose stop`
 - starting the stack: `docker-compose start` 
 - rebuild the stack with `docker-compose down` then `docker-compose up`; 
 (!) Warning this will remove all the cached data in redis.

