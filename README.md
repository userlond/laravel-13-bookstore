# 📝 Laravel Books & Authors

[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?style=for-the-badge&logo=php)](https://www.php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)


> 🎓 **Educational Pet Project**  
> This repository is a project created to demonstrate modern API development practices using **Laravel 13**. It serves
> as a sandbox for exploring up-to-date Laravel concepts.

## ℹ️ Description

An educational Laravel project demonstrating a simple bookstore-like application with:

- an admin interface for managing **books**, **authors**, and **clients**;
- a REST API for clients to subscribe to authors;
- a console command that notifies subscribed clients about new books from their favorite authors.

The project demonstrates common Laravel concepts such as:

- Eloquent relationships;
- admin CRUD (via Filament);
- API routes;
- observers;
- events and listeners;
- jobs and queues;
- notifications;
- console commands.

## 🚀 Getting Started

Follow these instructions to get a local copy of the project up and running.

### Prerequisites

Make sure you have the following installed on your machine:

- Linux OS (Ubuntu/Fedora etc.) recommended
- [Docker](https://www.docker.com)

### Installation

1. **Clone the repository**

```bash
git clone https://github.com/userlond/laravel-13-bookstore.git
cd laravel-13-todolist-api
```

2 **Configure Environment Variables**
Create a .env file in the root directory by copying the .env.example file:

```bash
cp .env.example .env
```

3 **Start the container**

```bash
docker compose -f compose.prod.yaml up -d --build
```

## ✨ Features

### Admin Panel

A simple admin interface allows administrators to manage:

- **Authors**
    - create, edit, delete authors.

- **Books**
    - create, edit, delete books;
    - upload book cover images;
    - set book price;
    - publish/unpublish books;
    - assign one or more authors to a book.

- **Clients**
    - view registered users;
    - view subscriptions and notification-related data.

### Client REST API

Authenticated clients can use the API to:

- register/login;
- subscribe to authors;
- unsubscribe from authors;
- view their subscriptions.

### New Book Notifications

There are 3 isolated steps:

1. Event (Event Sourcing / Event Log): When a book is published, we simply record this fact in the transactional buffer
   table `book_pending_notifications`.
2. Aggregation and Scheduling (Cron/Scheduler): A console command is run once a day (or according to a schedule). It
   selects users who have accumulated new books, groups them, and then pushes one consolidated task into the queue.
3. Dispatch (Queue Workers): The workers disassemble the queue and send notifications.

So user gets one notification with all new books of favourite authors. Not more than one notification per day.

---

## Tech Stack

- PHP 8.5
- Laravel 13
- MySQL / MariaDB
- Laravel Sanctum for API tokens
- Filament V5 for admin CRUD
- Database-driven cache, sessions, and queue
- Laravel Mail / Notifications
