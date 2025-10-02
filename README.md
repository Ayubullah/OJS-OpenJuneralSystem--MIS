# OJS - Open Journal System (MIS)

A comprehensive Management Information System (MIS) for academic journals built with Laravel and Tailwind CSS. This system provides a complete solution for managing academic publications, peer review processes, and journal administration.

## 🚀 Features

- **Journal Management**: Complete journal administration and configuration
- **Article Submission**: Streamlined article submission process for authors
- **Peer Review System**: Comprehensive peer review workflow management
- **User Management**: Role-based access control for editors, reviewers, and authors
- **Publication Management**: Article publication and issue management
- **Modern UI**: Responsive design built with Tailwind CSS
- **Laravel Framework**: Built on Laravel 12 with modern PHP practices

## 🛠️ Technology Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Tailwind CSS, Alpine.js
- **Database**: SQLite (configurable for MySQL/PostgreSQL)
- **Authentication**: Laravel Breeze
- **Build Tools**: Vite, NPM

## 📋 Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- SQLite (or MySQL/PostgreSQL)

## 🔧 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/OJS-OpenJuneralSystem--MIS.git
   cd OJS-OpenJuneralSystem--MIS
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

## 🎯 Usage

### For Authors
- Register and submit articles
- Track submission status
- Respond to reviewer feedback
- Manage publication history

### For Reviewers
- Access assigned manuscripts
- Submit review reports
- Track review history
- Manage review preferences

### For Editors
- Manage journal content
- Assign reviewers
- Make publication decisions
- Configure journal settings

### For Administrators
- System configuration
- User management
- Journal setup
- Analytics and reporting

## 📁 Project Structure

```
OJS-OpenJuneralSystem--MIS/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   └── Services/            # Business logic services
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Stylesheets
│   └── js/                  # JavaScript files
├── routes/                  # Application routes
├── public/                  # Public assets
└── storage/                 # File storage
```

## 🔐 User Roles

- **Administrator**: Full system access and configuration
- **Editor**: Journal management and editorial decisions
- **Reviewer**: Article review and feedback
- **Author**: Article submission and management

## 🚀 Deployment

### Production Environment

1. **Configure environment**
   ```bash
   # Update .env for production
   APP_ENV=production
   APP_DEBUG=false
   DB_CONNECTION=mysql  # or your preferred database
   ```

2. **Optimize for production**
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   npm run build
   ```

3. **Set up web server**
   - Configure Apache/Nginx to serve from `public/` directory
   - Set proper file permissions
   - Configure SSL certificate

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 📞 Support

For support and questions:
- Create an issue in this repository
- Contact the development team
- Check the documentation

## 🔄 Version History

- **v1.0.0** - Initial release with core journal management features
- **v1.1.0** - Added peer review system
- **v1.2.0** - Enhanced UI with Tailwind CSS
- **v1.3.0** - Improved user management and role-based access

## 🙏 Acknowledgments

- Laravel framework and community
- Tailwind CSS for styling
- Open Journal Systems community
- All contributors and testers

---

**Built with ❤️ for the academic community**