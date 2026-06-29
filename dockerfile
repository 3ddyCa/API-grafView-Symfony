FROM httpd:2.4
WORKDIR /usr/local/app

COPY . /usr/local/app


#COPY src /usr/local/app/src
EXPOSE 8080

RUN adduser grafView
USER grafView

CMD ["php", "grafView.main:grafView", "--host", "0.0.0.0", "--port", "8080", "-U",'mMeteo','-p','myD00B1E', '-e','MYSQL_ALLOW_EMPTY_PASSWORD=TRUE']
