FROM postgres
 
ENV POSTGRES_PASSWORD docker
ENV POSTGRES_DB db
ENV POSTGRES_USER docker


COPY . /app/database

COPY database_schema/database_init.sql /docker-entrypoint-initdb.d/