#!/bin/bash
FILE_env=/tmp/testing-env/docker/src/.env
FILE_docker_compose=/tmp/testing-env/docker/src/docker-compose.yml
DIR_repo=/tmp/testing-env
CONFIG="docker-compose --env-file $FILE_env -f $FILE_docker_compose config"

## File checking
if docker-compose --env-file $FILE_env -f $FILE_docker_compose config > /dev/null; then
	echo "Both files exist. Going to run config now!!"
	rm -rf $DIR_repo
	git clone https://github.com/LSVH/hbo-ict-inno-s2-tno.git /tmp/testing-env
	docker-compose --env-file $FILE_env -f $FILE_docker_compose up -d --build 
	sleep 10m
	docker-compose -f $FILE_docker_compose down
	docker system prune -a -f
	rm -rf $DIR_repo
else 
	echo "Something went wrong..." >> /tmp/logs.log
fi
