### Building and running your application

When you're ready, start your application by running:
`docker compose up --build`.

Your application will be available at http://localhost:9001.

#### Dev workflow

1. Run `docker compose watch`
2. edit code
3. refresh browser

#### DB setup

- On first startup, the MariaDB container automatically runs any .sql, .sql.gz, or .sh files found in the MariaDB folder, because it is mounted to /docker-entrypoint-initdb.d.
- Place your initialization script(s) in MariaDB/. For this project, MariaDB/scripture_structure.sql will be executed to create and seed the schema when the data directory is empty.
- To force re-initialization (and re-run the scripts), remove the volume and start again: `docker compose down -v && docker compose up --build`.

right now the scripts in the MariaDB folder don't include any data, this means that the database is empty and you'll get an error about missing translations when you try to access the site.


### Deploying your application to the cloud

First, build your image, e.g.: `docker build -t myapp .`.
If your cloud uses a different CPU architecture than your development
machine (e.g., you are on a Mac M1 and your cloud provider is amd64),
you'll want to build the image for that platform, e.g.:
`docker build --platform=linux/amd64 -t myapp .`.

Then, push it to your registry, e.g. `docker push myregistry.com/myapp`.

Consult Docker's [getting started](https://docs.docker.com/go/get-started-sharing/)
docs for more detail on building and pushing.