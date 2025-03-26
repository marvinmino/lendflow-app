Lendflow Application

This repository contains the Lendflow application, a Laravel-based project designed to interact with the New York Times (NYT) Books API. The application is containerized using Docker and includes a queue worker setup for handling asynchronous tasks.
Features

    Laravel Framework: Leverages the robust Laravel framework for rapid development and scalability.​

    Docker Integration: Utilizes Docker Compose for containerized development and deployment.​

    Queue Worker: Implements a queue worker to manage background jobs efficiently.​
    Laracasts+10Medium+10TestDome+10

    Mock Job with Polling: Includes a controller that simulates a job with a delay and provides a polling endpoint to check its status.​

#Prerequisites

#Before setting up the project, ensure you have the following installed:

    Docker

    Docker Compose

#Setup Instructions

#Follow these steps to set up and run the application:

    Clone the Repository:

git clone https://github.com/yourusername/lendflow.git
cd lendflow

#Environment Configuration:

Create a .env file in the project root by copying the example environment file:

cp .env.example .env

#Update the .env file with the necessary configuration, particularly the NYT API credentials:

NYT_API_URL=https://api.nytimes.com/svc/books/v3
NYT_API_KEY=your_nyt_api_key

Note: Ensure that sensitive credentials are not hardcoded in the codebase. Store them securely and pass them to the Docker containers as environment variables.​

#Build and Start the Docker Containers:

Use Docker Compose to build and start the application services:

docker compose up --build -d

This command will build the necessary Docker images and start the containers in detached mode.

#Access the Application:

The application should now be accessible at http://localhost:8000.