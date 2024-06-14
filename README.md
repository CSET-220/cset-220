# CSET 220 Final Project - Retirement Home Management WebApp

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![jQuery](https://img.shields.io/badge/jquery-%230769AD.svg?style=for-the-badge&logo=jquery&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)

## About

This project is a web application for managing a retirement home. It's built with Laravel, jQuery, and Tailwind CSS.

## Features

- Logging of patients' meals, medications, and appointments
- Addition, deletion, and editing of patients and their information
- Seeding of fake database information for testing purposes using the Faker library

## Installation

1. Clone the repository
2. Install dependencies with `composer install` and `npm install`
3. Copy `.env.example` to `.env` and configure your environment variables
4. Run `php artisan key:generate` to generate an app key
5. Run `php artisan migrate` to run database migrations
6. Run `npm run dev` to compile your assets