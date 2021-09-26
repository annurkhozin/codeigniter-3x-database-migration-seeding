# CodeIgniter 3.x with Database Migration & Seeding

## About

This is a starter template with CodeIgniter 3.1.11 and database migration & seeding tools.

### Features

- [x] CodeIgniter Migration with CodeIgniter Command Line Interface (CLI)
- [x] CodeIgniter Database seeding with CodeIgniter Command Line Interface (CLI)
- [x] [Faker PHP Library](https://github.com/fzaninotto/Faker)

### Installation

1. Clone this repository
   `git clone https://github.com/annurkhozin/codeigniter-3x-database-migration-seeding.git`
2. Install all required packages with Composer with your CLI: `composer install`.
3. Configure **application/config/database.php**.

### CLI Commands

| Available Command Line Interface (CLI) commands | Description                                         |
| ----------------------------------------------- | --------------------------------------------------- |
| `php cli tools help`                            | Show all CLI commands                               |
| `php cli tools migration "File_Name"`           | Create new migration file                           |
| `php cli tools migrate ["Version_Number"]`      | Run all migrations. The version number is optional. |
| `php cli tools seeder "File_Name"`              | Creates a new seed file.                            |
| `php cli tools seed "File_Name"`                | Run the specified seed file.                        |
| `php cli tools seeds`                           | Run all seed files.                                 |

### Field type documentation

See the [documentation](https://codeigniter.com/userguide3/libraries/migration.html) on codeigniter 3.x

### Example

In **application/database/migrations** is a migrations file and in **application/database/seeds** is a seeder file created for this example.

Type the following commands in your CLI:

1. `php cli tools migration Users`
2. `php cli tools migrate Users` or `php cli tools migrate`
3. `php cli tools seeder UsersSeeder`
4. `php cli tools seed UsersSeeder` or `php cli tools seeds`
5. Check your database changes :)

### Reference

- [aaron5670](https://github.com/aaron5670/CodeIgniter-3-Database-Migration-and-Seeding)
