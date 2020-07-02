#!/bin/bash
FILE_env=/tmp/testing-env/docker/src/.env
FILE_docker_compose=/tmp/testing-env/docker/src/docker-compose.yml
DIR_repo=/tmp/testing-env
NAME_wp=src_wp_1
NAME_mysql=src_db_1
NAME_app=src_app_1

## checking for running containers
if [ ! "$(docker ps -q -f name=$NAME_wp)" ]; then
    docker-compose -f $FILE_docker_compose down
    docker system prune -a -f
fi
if [ ! "$(docker ps -q -f name=$NAME_mysql)" ]; then
    docker-compose -f $FILE_docker_compose down
    docker system prune -a -f
fi
if [ ! "$(docker ps -q -f name=$NAME_app)" ]; then
    docker-compose -f $FILE_docker_compose down
    docker system prune -a -f
fi
if [ $? -eq 0 ]; then
    echo "Online"
    # runing setup
    # cleaning repo
    rm -rf $DIR_repo
    #Git clone repo
    git clone https://github.com/LSVH/hbo-ict-inno-s2-tno.git /tmp/testing-env
    echo "System is ready for running containers..."
    cat /home/ubuntu/TOKEN.txt | docker login https://docker.pkg.github.com/ -u weis999 --password-stdin
    echo "Going to start the containers for 10 minutes!!"
    docker-compose --env-file $FILE_env -f $FILE_docker_compose  up -d --build --force-recreate
    echo "Going to sleep for 10 minutes!!"
    sleep 10m
    echo "Going to stop the containers!!"
    docker-compose --env-file $FILE_env -f $FILE_docker_compose down
    echo "Going to clean docker engine!!"
    docker system prune -a -f
    echo "Going to clean the setup!!"
    rm -rf $DIR_repo
else
    echo "Something went wrong.... Host is probably not accessible from the internet"
fi
exit 0
