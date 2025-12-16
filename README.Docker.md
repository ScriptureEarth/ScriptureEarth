## **Setting Up and Running Your Application**

To start your application, use the following command: **docker compose up \--build**.

Your application will be accessible at [**http://localhost:9001**](http://localhost:9001).

---

## **Development Workflow**

1. Run **docker compose watch**.  
2. Make changes to your code.  
3. Refresh your browser to see updates.

---

## **Database Configuration**

* During the first launch, the MariaDB container will automatically execute any files with the extensions .sql, .sql.gz, or .sh located in the MariaDB directory, as this directory is mounted to **/docker-entrypoint-initdb.d**.  
* Place your initialization scripts in the MariaDB directory. For this project, **MariaDB/scripture\_structure.sql** will be run to create and populate the schema if the data directory is empty.  
* To reinitialize the database and rerun the scripts, remove the volume and restart with: **docker compose down \-v && docker compose up \--build**.

Currently, since the scripts in the MariaDB folder don’t contain any data, the database will be empty. Attempting to access the site will result in an error about missing translations.

---

## **Deploying Your Application to the Cloud**

Begin by building your image using: **docker build \-t myapp ..**. If your cloud provider operates on a different CPU architecture than your local machine (for example, if you’re using a Mac M1 and your cloud provider is amd64), build the image for that specific platform by using: **docker build \--platform=linux/amd64 \-t myapp ..**.

Next, push the image to your registry with: **docker push myregistry.com/myapp**.

For further details on building and pushing images, refer to Docker’s getting started documentation.
