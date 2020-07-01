#!/bin/bash
#Git clone repo
rm -rf $DIR_repo
git clone https://github.com/LSVH/hbo-ict-inno-s2-tno.git /tmp/testing-env


FILE_env=/tmp/testing-env/docker/src/.env
FILE_docker_compose=/tmp/testing-env/docker/src/docker-compose.yml
DIR_repo=/tmp/testing-env
CONFIG="docker-compose --env-file $FILE_env -f $FILE_docker_compose config"

## File checking
if docker-compose --env-file $FILE_env -f $FILE_docker_compose config > /dev/null; then
        echo "Both files exist. Going to run config now!!"
        docker-compose --env-file $FILE_env -f $FILE_docker_compose up -d --build
        echo "Going to sleep for 10 minutes!!"
        sleep 10m
        echo "Going to stop the containers!!"
        docker-compose -f $FILE_docker_compose down
        echo "Going to clean docker engine!!"
        docker system prune -a -f
        echo "Going to clean the setup!!"
        rm -rf $DIR_repo
else
        echo "Something went wrong..." >> /tmp/logs.log
fi
