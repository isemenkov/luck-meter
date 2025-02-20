Luck Meter
==========

## Setup and run application:
1. Copy `.env` config `cp .env.example .env`
2. (optional) Setup current user name and group `./setup-user-and-group.sh`. This helps to have correct right while 
develop or change files while working into Docker container.
3. Build Docker container `make build` or `docker-compose build`.
4. (optional) Setup local domain name alias `echo "127.0.0.1 luck-meter.localhost" | sudo tee -a /etc/hosts`.
5. Run containers `make up` or `docker-compose up`.
6. Open main page `luck-meter.localhost`.
