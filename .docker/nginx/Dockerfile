FROM nginx:alpine

RUN apk --update add supervisor

RUN rm /var/cache/apk/*

COPY app.conf /etc/nginx/nginx.conf
COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
