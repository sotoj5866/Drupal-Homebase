# Homebase

# Table of Contents
1. [Summary](#summary)
2. [Author](#author)
3. [Setup](#setup)
4. [Goals](#goals)
5. [Features](#features)
6. [Issues](#issues)
7. [Wishlist](#wishlist)
8. [IP](#ip)

## Summary

A Drupal 8 webpage for managing a little league team.

## Author

David Quisenberry, Matt Kelley, Xia Amendolara, Dylan Stackhouse

## Setup

1. Download [php](https://secure.php.net/)
2. Download [drupal 7](https://www.drupal.org/download)
3. Download [mysql](https://www.mysql.com/)
4. Download [apache](https://httpd.apache.org/)
5. Import the mqsql database (sites/db_backup/pantheon.sql.zip) into your mysql server (Server running on port 8889)
6. Create a user in phpMyAdmin for the pantheon database with the username 'admin-matt' and password 'admin'
7. Set your apache document root as the cloned repo directory
8. Navigate to your local host for your apache server (Port 8888)
9. To run tests `composer install --dev` and choose Homebase tests in `admin/configuration/testing`

## Goals

- Implement custom module
- Use Ajax
- Create Functional and Unit Tests

## Features

- Gamifies the little league experience
- Coaches can add experience to players skills for Hitting, Catching, and Throwing
- Coaches can generate a batting order and position map based on players coming to the game
- Players earn badges by leveling up skills

## Issues

## Wishlist

- Animations for earning badges that track when player logs in.

## IP

MIT Commons
David Quisenberry, Matt Kelley, Xia Amendolara, Dylan Stackhouse 2017
