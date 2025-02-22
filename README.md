<div style="display: flex; align-items: center;">
  <img src="assets/images/logo.svg" alt="IU Components Library Logo" width="80" height="80" style="margin-right: 10px;">
  <h1>IU components library</h1>
</div>

## Table of Contents

- [Introduction](#introduction)
- [Technologies](#technologies)
- [Setup](#setup)
- [Users](#users)
- [Screenshots](#screenshots)

## Introduction

IU - library of html/css components

## Technologies

<table>
  <table style="border-collapse: collapse; width: 100%;">
    <tr style="border: none;">
      <td style="border: none;"><img src="https://img.icons8.com/color/48/000000/html-5.png" alt="HTML5" /></td>
      <td style="border: none;"><strong>HTML5</strong>: structure</td>
    </tr>
    <tr style="border: none;">
      <td style="border: none;"><img src="https://img.icons8.com/color/48/000000/css3.png" alt="CSS3" /></td>
      <td style="border: none;"><strong>CSS</strong>: styling</td>
    </tr>
    <tr style="border: none;">
      <td style="border: none;"><img src="https://img.icons8.com/color/48/000000/javascript.png" alt="JavaScript" /></td>
      <td style="border: none;"><strong>JavaScript</strong>: interactivity</td>
    </tr>
    <tr style="border: none;">
      <td style="border: none;"><img src="https://img.icons8.com/color/48/000000/nginx.png" alt="Nginx" /></td>
      <td style="border: none;"><strong>Nginx</strong>: web server</td>
    </tr>
    <tr style="border: none;">
    <td style="border: none;"><img src="https://img.icons8.com/color/48/000000/postgreesql.png" alt="PostgreSQL" /></td>
      <td style="border: none;"><strong>PostgreSQL</strong>: database</td>
    </tr>
    <tr style="border: none;">
      <td style="border: none;"><img src="https://img.icons8.com/plasticine/48/000000/postgreesql.png" alt="PgAdmin" /></td>
      <td style="border: none;"><strong>PgAdmin</strong>: database client</td>
    </tr>
    <tr style="border: none;">
      <td style="border: none;"><img src="https://img.icons8.com/color/48/000000/docker.png" alt="Docker" /></td>
      <td style="border: none;"><strong>Docker</strong>: containers</td>
    </tr>
    <tr style="border: none;">
      <td style="border: none;"><img src="https://img.icons8.com/color/48/000000/git.png" alt="Git" /></td>
      <td style="border: none;"><strong>Git</strong>: version control</td>
    </tr>
    <tr style="border: none;">
      <td style="border: none;"><img src="https://img.icons8.com/color/48/000000/github.png" alt="GitHub" /></td>
      <td style="border: none;"><strong>GitHub</strong>: hosting</td>
    </tr>
  </table>

  <p>Icons by <a href="https://icons8.com" target="_blank">Icons8</a></p>
</table>

## Setup

Clone repository:

```sh
  git clone https://github.com/patrykmil/IU_css-library.git
```

Fill .env file with your own values

Inside the project directory, run:

```sh
  docker compose up -d --build
```

Website will be available at: http://localhost:8080/

pgAdmin will be available at: http://localhost:5050/

## Users

To add new user go to: http://localhost:8080/register

Or login at: http://localhost:8080/login with predefined users:

- Admin 1:
  - email: iuadmin@iu.iu
  - password: adminadmin
- User 2:
  - email: patryk@gmail.com
  - password: iU4qQKZugAR6Tb
- User 3:
  - email: none@proton.me
  - password: py4369t!nM4

## Screenshots

| Page              | Screenshot                                              | Mobile Screenshot                                                     |
| ----------------- | ------------------------------------------------------- | --------------------------------------------------------------------- |
| /start            | ![Start page](assets/screenshots/start_page.png)        | ![Start page mobile](assets/screenshots/start_page_mobile.png)        |
| /register         | ![Register page](assets/screenshots/register.png)       | ![Register page mobile](assets/screenshots/register_mobile.png)       |
| /login            | ![Login page](assets/screenshots/login.png)             | ![Login page mobile](assets/screenshots/login_mobile.png)             |
| /browse           | ![Browse page](assets/screenshots/browse.png)           | ![Browse page mobile](assets/screenshots/browse_mobile.png)           |
| /collection       | ![Collection page](assets/screenshots/collection.png)   | ![Collection page mobile](assets/screenshots/collection_mobile.png)   |
| /component/{id}   | ![Component page](assets/screenshots/component.png)     | ![Component page mobile](assets/screenshots/component_mobile.png)     |
| /create           | ![Create component page](assets/screenshots/create.png) | ![Create component page mobile](assets/screenshots/create_mobile.png) |
| /messages         | ![Messages page](assets/screenshots/messages.png)       | ![Messages page mobile](assets/screenshots/messages_mobile.png)       |
| mobile navigation |                                                         | ![Mobile navigation](assets/screenshots/navigation_mobile.png)        |
