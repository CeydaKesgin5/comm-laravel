## 1. Üyeler

-   member_id
-   name
-   email
-   role
-   image_url
-   team

## 2. Etkinlikler

-   event_id
-   title
-   description
-   date
-   location
-   image_url
-   status (registered, attended, cancelled)

## 3. Announcements

announcement_id (INT, PRIMARY KEY)
title (VARCHAR)
description (TEXT)
date_posted (DATE / DATETIME)
author_id (INT, FOREIGN KEY → users.user_id)
category (VARCHAR)
is_active (BOOLEAN)
image_url (VARCHAR)
