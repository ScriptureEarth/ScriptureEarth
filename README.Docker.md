# **ScriptureEarth Application**

## **Set Up and Run Your Application**

To launch your application, execute the command: **docker compose up \--build**. This has to be done once.

Once initiated, your application will be located at [**http://localhost:9001**](http://localhost:9001).

---

## **Development Workflow**

1. **Start Watching for Changes**: Run **docker compose watch** to enable automatic monitoring. If contributors make any changes to the ScriptureEarth GitHub repository, those updates will automatically be reflected in your Docker images and containers.
2. **Code Modifications**: Make any necessary changes to your application code. This is accomplished in Visual Studio as follows.  
   1. Navigate to the "main" branch on the left and click on it.
   2. Create a new branch and give it a name.
   3. Make your code changes.
   4. Click on the icon that resembles "double vertical dots with a single dot being merged" on the left side.
   5. Click on the "Create Pull Request" icon (or click on the "Commit" icon if you want to make additional changes).
   6. Fill in the MERGE, TITLE, and DESCRIPTION, then click on "Create."
   7. Follow the subsequent instructions.
3. **View Updates**: Refresh your web browser to see the changes in real-time.

---

## **Database Configuration**

* **Automated Execution on First Launch**: Upon the initial startup, the MariaDB container will automatically run any files it finds with the extensions **.sql**, **.sql.gz**, or **.sh** in the MariaDB directory, as this directory is mounted to **/docker-entrypoint-initdb.d**.  
* **Initialization Scripts**: Place your database initialization scripts in the MariaDB directory. For this project, **MariaDB/scripture\_structure.sql** will be processed to create and populate the database schema if the data directory is empty.  
* **Reinitialization**: If you need to reinitialize the database and rerun the scripts, simply remove the existing volume and restart the application with the command: **docker compose down \-v && docker compose up \--build**.

Currently, the scripts in the MariaDB folder do not contain any seed data, which means the database will be empty and ScriptureEarth will not work. (If you attempt to access the site, you will encounter an error regarding missing translations.)

---

## **Deploying Your Application to the Cloud**

Start your deployment by building your Docker image with the command: **docker build \-t myapp ..**. If your cloud provider utilizes a different CPU architecture than your local development environment (for instance, if you're working on a Mac M1 and your cloud provider uses amd64), make sure to build the image targeting that architecture by executing: **docker build \--platform=linux/amd64 \-t myapp ..**.

Next, push the built image to your registry using: **docker push myregistry.com/myapp**.

---

## **To Build and Push Docker Images**

For additional information on building and pushing Docker images, refer to Docker’s comprehensive getting started.
