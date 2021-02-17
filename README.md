### How to start it

- cd to proxy folder in images
    - cp .env.example to be .env change the port to anyone available on your machine
    - run `docker-compose up -d`
- go to server folder in images
    - cp .env.example to be .env change the data to yours
    - cd to /etc/hosts on your machine and add `VIRTUAL_HOST`, the one you added in .env then restart your apache
    - run `docker-compose up -d`

- go to code folder and read the README