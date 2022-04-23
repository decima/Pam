# PAM - Personal Assets Management

![](./public/pam.jpg)

Pam is a tool for sort and view assets.


This is a work-in-progress project and still have a lot to do. Here are the expected features : 
- [x] automatic import from folder
- [x] group by categories
- [x] group by tags 
- [ ] crud categories
- [x] crud tags
- [ ] S3 media storage
- [ ] import from browser
- [ ] more awesome features...
- [ ] ML classify helper?


## Getting started

Requirement:
- php 8.1, composer & symfony-cli
- nodejs & yarn (or npm)

You need to install the dependencies:

```
composer install
```

Then you can run the application:

```
symfony serve
```

This will start the api server. Then you can start the frontend:

```
yarn
yarn dev
```