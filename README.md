# Desarmaduria PHP

This is a project for a development class at the University. It is a web application for a car parts store. It is built using PHP, MySQL, and Docker.

## Installation 

Instructions on how to install and get the project running.

```bash
git clone https://github.com/cjguajardo/desarmaduria-php.git
cd desarmaduria-php
```

## Docker Installation

This project uses Docker to create a reproducible environment. If you don't have Docker installed, you'll need to install it before you can run this project.

### For Windows and MacOS

1. Download Docker Desktop from the [official Docker website](https://www.docker.com/products/docker-desktop).
2. Install Docker Desktop by following the instructions in the installer.

### For Linux

1. Update your existing list of packages: `sudo apt-get update`
2. Install a few prerequisite packages which let apt use packages over HTTPS: `sudo apt-get install apt-transport-https ca-certificates curl software-properties-common`
3. Add the GPG key for the official Docker repository to your system: `curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -`
4. Add the Docker repository to APT sources: `sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"`
5. Update the package database with the Docker packages from the newly added repo: `sudo apt-get update`
6. Make sure you are about to install from the Docker repo instead of the default Ubuntu repo: `apt-cache policy docker-ce`
7. Install Docker: `sudo apt-get install docker-ce`

For more detailed instructions, refer to the [official Docker documentation](https://docs.docker.com/get-docker/).

## Building and Running the Docker Containers

Once you have Docker installed, you can build and run the containers defined in this project using Docker Compose.

1. Navigate to the project directory in your terminal.

```bash
cd path/to/your/project

```

2. Build the Docker images. This may take a few minutes the first time you run it, as Docker needs to download the base images and build your containers.

```bash
docker-compose build
```

3. Once the images are built, you can start the containers:
  
```bash
docker-compose up -d
```

The -d flag tells Docker to run the containers in the background.

You should now have your containers running. You can check the status of your containers by running:

```bash
docker-compose ps
```

For more detailed instructions on using Docker Compose, refer to the official Docker Compose documentation.

## Running the Application

Once you have your containers running, you can open the web application in http://localhost:8080

## Compile Sass - Docker

This project uses Sass for styling. If you make any changes to the Sass files, you'll need to compile your changes to CSS.

1. Navigate to the project directory in your terminal.

```bash
cd path/to/your/project
```

2. Run the following command to compile your Sass to CSS:

```bash
docker-compose run --rm node npm run sass
```

## Compile Sass - Local

If you prefer, you can compile your Sass locally instead of using Docker.

1. Navigate to the project directory in your terminal.

```bash
cd path/to/your/project
```

you must be in the web folder to run the following command

```bash

2. Run the following command to compile your Sass to CSS:

```bash
npm run sass
```