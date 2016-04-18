ifeq (Boot2Docker, $(findstring Boot2Docker, $(shell docker info)))
	PLATFORM := OSX
else
	PLATFORM := Linux
endif

ifeq (composer, $(firstword $(MAKECMDGOALS)))
	COMPOSER_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
        $(eval $(COMPOSER_ARGS):;@:)
endif

ifeq ($(PLATFORM), OSX)
	CONTAINER_HOME = /root
	CREATE_USER =
else
	GROUP_ID = $(shell id -g)
	USER_ID  = $(shell id -u)
	CONTAINER_USERNAME  = dummy
	CONTAINER_GROUPNAME = dummy
	CONTAINER_HOME = /home/$(CONTAINER_USERNAME)

	CREATE_USER = \
	  groupadd -f -g $(GROUP_ID) $(CONTAINER_GROUPNAME) && \
	  useradd -u $(USER_ID) -g $(CONTAINER_GROUPNAME) $(CONTAINER_USERNAME) && \
	  mkdir --parent $(CONTAINER_HOME) && \
	  chown -R $(CONTAINER_USERNAME):$(CONTAINER_GROUPNAME) $(CONTAINER_HOME) && \
	  sudo -u $(CONTAINER_USERNAME)
endif

IMAGE = php

WORKDIR = /app
MOUNT_APP  = -v $(PWD):$(WORKDIR)
MOUNT_COMPOSER = -v $(HOME)/.composer:$(CONTAINER_HOME)/.composer

RUN = docker run --rm -ti $(MOUNT_COMPOSER) $(MOUNT_APP) -w $(WORKDIR) $(IMAGE)

php-version:    build
	$(RUN) php --version

run:    build
	$(RUN) \
	  bash -c '$(CREATE_USER) php app/app.php'

composer:   build
	$(RUN) \
	  bash -c '$(CREATE_USER) composer $(COMPOSER_ARGS)'

cs-fixer:   build
	$(RUN) \
	  bash -c '$(CREATE_USER) vendor/bin/php-cs-fixer fix src'
	$(RUN) \
      bash -c '$(CREATE_USER) vendor/bin/php-cs-fixer fix app'

ls:   build
	$(RUN) \
	  bash -c '$(CREATE_USER) ls -l'

build:
	@docker build -t $(IMAGE) docker