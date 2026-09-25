# Sawtru — Machine Project & Purchasing Management

Sawtru is an internal web dashboard for a custom machine manufacturing workshop. It follows each machine project from the first engineering request, through assembly planning and purchase orders, to delivery. It also keeps engineers, managers and purchasing staff informed with comments and notifications.

## What it does

An **engineer** opens a project request for a new machine. They enter its dimensions, volume, voltage, control type (traditional or PLC), a photo, and the materials it needs (metals, motors and other parts). An **admin/manager** reviews the request. The project then moves through a series of phases, and an admin approves each one before the next can start:

| Phase | Name | What happens |
|---|---|---|
| 0 | **New Request** | Engineer submits the machine spec and bill of materials; assigns a manager. |
| 1 | **Assembling** | Engineer uploads vertical, horizontal, diagram and assembling photos. They also enter labor costs (laser cutting, CNC, lathe, assembling, electrical & automation) and the number of days needed. |
| 2 | **Purchase Order (PO)** | A purchase order is generated from the project's items (code, details, quantity, delivery, photo). |
| 3 | **Purchases** | Purchasing staff price each item, mark items as done or canceled (with a reason), and track progress. |
| 4 | **Completed** | Project finished. |

An admin can approve a phase, which records the approval date and sets a due date. An admin can also send a project back to the previous phase. The dates of each phase are stored on the project.

**Serial numbers:** projects are numbered `YY` + a 5-digit sequence (e.g. `2600012`). Purchase orders are numbered `PO` + `YY` + a 5-digit sequence (e.g. `PO2600007`).

## Features

- **Project management**: create, edit, review and delete machine projects, each with its own metals, motors, other items and photo galleries.
- **Phase workflow**: each phase needs admin approval, and each project tracks its due date.
- **Purchase orders**: generate POs from a project, then price items, track them, and mark them done or canceled.
- **Comments**: comment threads on each project. Deleting a comment hides it and records who removed it and when; nothing is erased.
- **Notifications**: email notifications when a project is created or commented on. The in-app notification log, Firebase push notifications (FCM) and real-time broadcasting all have partial support.
- **Roles & permissions**: access control with [spatie/laravel-permission](https://github.com/spatie/laravel-permission) (see below).
- **User & role management**: admins manage users, roles and permissions from the dashboard.
- **PDF export**: project and purchase-order reports are generated in the browser with jsPDF / pdf-lib.
- **User settings**: profile page and personal theme colors.

## Roles

The database seeder creates three roles:

| Role | Can do |
|---|---|
| **Admin** | Everything: users, roles, settings, all projects and purchases, phase approval, PDF export. |
| **Engineer** | Create projects and manage their own, submit assembling details, create purchase orders. |
| **Purchaser** | View purchase orders, create them, and edit or delete their own. |

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 9 (PHP ≥ 8.0.2) |
| Database | MySQL |
| Frontend | Blade templates, Bootstrap 5, Sass, Vue 3 (via Vite) |
| Auth | Laravel UI (session auth), Laravel Sanctum |
| Permissions | spatie/laravel-permission |
| Real-time | Laravel Echo, Pusher / laravel-websockets, Redis (predis), and a Socket.IO server in `server.js` |
| Notifications | Mail, Firebase Cloud Messaging (larafirebase) |
| PDF | jsPDF, jspdf-autotable, pdf-lib (client-side), barryvdh/laravel-dompdf |

## Project Structure

```
app/
  Http/Controllers/   ProjectController (phase workflow), PurchasesController,
                      UserController, RoleController, SettingsController, HomeController
  Models/             Project, project_metals / motors / others / lasers,
                      project_*_photos, purchases, project_orders, Comments, Notificationtb
  Notifications/      Email, push and real-time notifications
  Events/             Broadcast events
database/
  migrations/         Full schema (projects, items, photos, purchases, orders, comments…)
  seeders/            Roles & permissions, admin user, demo users
resources/views/
  pages/projects/     Create, show, edit, assembling, PO, report screens
  pages/purchases/    Purchase order screens
  auth/               Login, profile, users and roles management
routes/web.php        All dashboard routes (under /dashboard)
server.js             Standalone Socket.IO chat/broadcast server (HTTPS, port 3000)
```

## Data Model (overview)

- `projects` is keyed by `serial_no` and belongs to a creator (`uid`) and an assigned manager (`admin`).
- `project_metals`, `project_motors` and `project_others` hold the project's bill of materials.
- `project_lasers` holds labor and machining costs (laser, CNC, lathe, assembling, electrical).
- `project_vertical_photos`, `project_horizontal_photos`, `project_diagram_photos` and `project_assembling_photos` hold the photo galleries.
- `purchases` holds purchase orders, keyed by `serial_no` (`PO…`) and linked to a project.
- `project_orders` holds the line items of each purchase order.
- `comments` holds comments on projects and purchase orders.
- `notificationtbs` is the in-app notification log.

## Getting Started

### Requirements

- PHP 8.0.2+ and Composer
- Node.js & npm
- MySQL
- Redis (optional, for broadcasting/queues)

### Installation

```bash
git clone <repo-url> sawtru
cd sawtru

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Set your database credentials in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sawtru
DB_USERNAME=root
DB_PASSWORD=
```

Also configure `MAIL_*` for email notifications, and optionally `PUSHER_*` for real-time broadcasting.

Run the migrations and seed the roles and demo users:

```bash
php artisan migrate --seed
```

Create the uploads folder (project photos are saved to `public/uploads/`), then build the assets and start the app:

```bash
mkdir -p public/uploads
npm run dev        # or: npm run build
php artisan serve
```

Open http://localhost:8000 and sign in.

### Demo accounts (seeded)

| Role | Email | Password |
|---|---|---|
| Admin | `admin@sawtru.dev` | `123456` |
| Engineer | `mohammed_alfarra@sawtru.dev` | `123456` |
| Purchaser | `mohammed_ali@sawtru.dev` | `123456` |

> These accounts are for local development only. Change or remove them before deploying.

### Optional: Socket.IO server

`server.js` runs over HTTPS on port 3000 and needs a certificate in the project root. Certificates and keys are not committed to the repo, so generate a self-signed pair first:

```bash
openssl req -x509 -newkey rsa:2048 -nodes -days 365 \
  -keyout selfsigned.key -out selfsigned.crt -subj "/CN=localhost"

node server.js
```

## License

Released under the [Apache License 2.0](LICENSE).
