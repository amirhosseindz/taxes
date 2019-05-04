# Jobleads Taxes
A software that can be used to calculate statistics about the tax income of a country.

# Installation
1. Clone the repository in your document root and then change the current directory to `jobleads-taxes`:
```
git clone https://github.com/amirhosseindz/jobleads-taxes
cd jobleads-taxes
```
2. Run `composer install`
2. Copy `.env.example` to `.env` and fill the needed parameters for database connection in it.
3. Run `php artisan key:generate`
4. Run `php artisan migrate`

Enjoy!
