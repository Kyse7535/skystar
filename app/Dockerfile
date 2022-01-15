FROM node:16.13-alpine3.15

# installation bash
RUN apk --no-cache update && apk --no-cache add bash git
# FROM php:8-fpm-alpine3.14

# # installation bash
# RUN apk --no-cache update && apk --no-cache add bash git npm yarn

# config de git, a modifier dans votre container (inutile en réalité)
RUN git config --global user.email "justin.lecas@etu.univ-orleans.fr" \
&& git config --global user.name "univ orleans"

# le cli
RUN npm install -g @angular/cli

COPY /dev/package.json /app/

WORKDIR /app

RUN yarn install

COPY /dev /app/

CMD ng serve --host 0.0.0.0