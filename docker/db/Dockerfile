FROM postgres
 
ENV POSTGRES_PASSWORD docker
ENV POSTGRES_DB db
ENV POSTGRES_USER docker
 
COPY . /app/database

COPY database_schema/schema.sql /docker-entrypoint-initdb.d/
COPY database_schema/data.sql /docker-entrypoint-initdb.d/