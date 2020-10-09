# See here for image contents: https://github.com/microsoft/vscode-dev-containers/tree/v0.134.0/containers/php/.devcontainer/base.Dockerfile
ARG VARIANT="7.4"
FROM mcr.microsoft.com/vscode/devcontainers/php:0-${VARIANT}

# [Optional] Install a version of Node.js using nvm for front end dev
ARG INSTALL_NODE="true"
ARG NODE_VERSION="lts/*"
RUN if [ "${INSTALL_NODE}" = "true" ]; then su vscode -c "source /usr/local/share/nvm/nvm.sh && nvm install ${NODE_VERSION} 2>&1"; fi

RUN sed -i -e "s/Listen 8080/Listen 8282/g" /etc/apache2/ports.conf 

RUN apt -y install lsb-release apt-transport-https ca-certificates && \
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list

# [Optional] Uncomment this section to install additional OS packages.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends php7.4-{common,mysql,xml,xmlrpc,curl,gd,imagick,cli,dev,imap,mbstring,opcache,soap,zip,intl,bcmath}
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1