FROM python:alpine3.14

# https://stackoverflow.com/questions/57787424/django-docker-python-unable-to-install-pillow-on-python-alpine
RUN apk update \
    && apk add --virtual build-deps gcc python3-dev musl-dev \
    && apk add postgresql \
    && apk add postgresql-dev \
    && pip install psycopg2 \
    && apk add jpeg-dev zlib-dev libjpeg \
    && pip install Pillow \
    && apk del build-deps

RUN apk --no-cache add libffi-dev openssl-dev g++
RUN pip3 install greenlet

WORKDIR /app
COPY ./data /app/data/
COPY ./generate-insert.py /app/

# Docker hub documentations : https://hub.docker.com/_/python?tab=description&page=1&name=alpine
COPY requirements.txt ./
RUN pip install --no-cache-dir -r requirements.txt