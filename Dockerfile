FROM node:lts AS frontend
WORKDIR /app
ADD package.json /app
ADD yarn.lock /app
RUN yarn install
ADD postcss.config.js /app
ADD tailwind.config.js /app
ADD vite.config.js /app
ADD assets /app/assets
RUN mkdir -p /app/public
RUN yarn build


FROM decima/php-nginx:8.1
ENV APP_ENV=prod
COPY --chown=app:app  ./ /app
USER root
RUN mkdir /import && chmod a+rwx /import
RUN mkdir /data && chmod a+rwx /data
VOLUME /import
VOLUME /data

RUN echo '\n\
[program:migrate-database]\n\
command=deploy/start.sh\n\
autostart=true\n\
autorestart=false\n\
priority=15\n\
stdout_logfile=/dev/stdout\n\
stderr_logfile=/dev/stderr\n\
stdout_logfile_maxbytes=0\n\
startretries=0\n\
stderr_logfile_maxbytes=0' >> /etc/supervisor/conf.d/supervisord.conf

RUN echo '\n\
[program:import]\n\
command=bin/console pam:import /import -l --cool-down=10\n\
autostart=true\n\
autorestart=true\n\
priority=15\n\
stdout_logfile=/dev/stdout\n\
stderr_logfile=/dev/stderr\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile_maxbytes=0' >> /etc/supervisor/conf.d/supervisord.conf

COPY --from=frontend --chown=app:app /app/public/build /app/public/build
USER app
RUN mkdir /app/var

RUN composer install -o

