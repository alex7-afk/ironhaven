this is my final year project, i'm using Wamp64, My operating system is Windows.
# Iron Haven

This repository contains the source code for my final year project.
It was originally developed on Windows using Wamp64, but it can be served with any web server that supports PHP.

## Setup

The application expects the web root to point to the `PAP` directory. All HTML files reference assets and PHP scripts relative to that folder.

To launch a local development server from the repository root you can use PHP's built-in web server:

```bash
php -S localhost:8080 -t PAP
```

Then open [http://localhost:8080/index.php](http://localhost:8080/index.php) in your browser.

If you prefer to keep the document root somewhere else, configure your web server so that requests to `/src` are mapped to the `PAP` directory. An example Apache configuration would look like:

```apache
Alias /src /path/to/ironhaven/PAP
<Directory /path/to/ironhaven/PAP>
    Require all granted
</Directory>
```

## Requirements

- PHP 7.x or newer
- MySQL or compatible database server
- 
## New: Weight Log Tracking

Logged-in users can record their weight over time. Visit `progresso.php` in the web root to add entries and view your history. Data is stored locally in `weights.json`.
