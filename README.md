# Supply Chain Information System for Food and Beverages in Java Region

![Laravel](https://img.shields.io/badge/Laravel-8.x-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)
![Pentaho](https://img.shields.io/badge/Pentaho-9.x-orange.svg)
![GitHub License](https://img.shields.io/github/license/putuangga-k/Database-Final-Project.svg)

## Table of Contents

- [About](#about)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## About

The **Supply Chain Information System for Food and Beverages in Java Region** is a comprehensive application designed to streamline and manage the supply chain processes within the food and beverage industry in the Java region. This system provides real-time insights, enhances operational efficiency, and facilitates data-driven decision-making.

### Key Highlights

- **Enhanced Dashboard:** The dashboard has been meticulously modified to incorporate a data warehouse architecture, enabling robust data analysis and reporting.
- **Data Warehouse Implementation:** Utilizes **Pentaho** for Extract, Transform, Load (ETL) processes, ensuring seamless data integration and management from multiple sources.
- **Laravel Framework:** Built on the Laravel framework, ensuring a scalable, secure, and maintainable codebase.

## Features

- **Real-Time Inventory Management:** Monitor stock levels, manage orders, and track shipments in real-time.
- **Supplier Management:** Maintain detailed records of suppliers, manage contracts, and evaluate performance.
- **Order Processing:** Streamlined order placement, tracking, and fulfillment processes.
- **Data Analytics:** Advanced reporting and analytics powered by the integrated data warehouse.
- **User Management:** Role-based access control to ensure data security and integrity.
- **Responsive Design:** Accessible on various devices, including desktops, tablets, and smartphones.

## Technologies Used

- **Backend:** Laravel Framework
- **Frontend:** Blade Templating, HTML5, CSS3, JavaScript
- **Database:** MySQL
- **Data Warehouse & ETL:** Pentaho
- **Version Control:** Git & GitHub
- **Others:** Composer, Node.js, NPM

## Installation

Follow these steps to set up the project locally:

### Prerequisites

- **PHP:** Version 7.4 or higher
- **Composer:** Dependency Manager for PHP
- **Node.js & NPM:** For frontend dependencies
- **MySQL:** Database management
- **Git:** Version control
- **Pentaho:** For data warehouse and ETL processes

### Steps

1. **Clone the Repository**

    ```bash
    git clone https://github.com/putuangga-k/Database-Final-Project.git
    ```

2. **Navigate to the Project Directory**

    ```bash
    cd Database-Final-Project
    ```

3. **Install PHP Dependencies**

    Ensure you have Composer installed. Then run:

    ```bash
    composer install
    ```

4. **Install Frontend Dependencies**

    Ensure you have Node.js and NPM installed. Then run:

    ```bash
    npm install
    ```

5. **Compile Frontend Assets**

    ```bash
    npm run dev
    ```

    For production:

    ```bash
    npm run production
    ```

6. **Set Up Environment Variables**

    - Copy the example environment file:

        ```bash
        cp .env.example .env
        ```

    - Open the `.env` file and configure the following settings:

        ```env
        APP_NAME="Supply Chain Information System"
        APP_ENV=local
        APP_KEY=base64:GENERATE_KEY
        APP_DEBUG=true
        APP_URL=http://localhost

        LOG_CHANNEL=stack

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_database_name
        DB_USERNAME=your_database_user
        DB_PASSWORD=your_database_password

        # Pentaho Configuration
        PENTAHO_HOST=your_pentaho_host
        PENTAHO_PORT=your_pentaho_port
        PENTAHO_USERNAME=your_pentaho_username
        PENTAHO_PASSWORD=your_pentaho_password
        ```

7. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

8. **Run Database Migrations and Seeders**

    Ensure your MySQL database is running and the credentials in the `.env` file are correct.

    ```bash
    php artisan migrate --seed
    ```

9. **Configure Pentaho**

    - **Install Pentaho:** If you haven't installed Pentaho, download and install it from the [official website](https://sourceforge.net/projects/pentaho/files/).
    - **Set Up ETL Processes:**
        - Import the provided Pentaho transformation and job files located in the `pentaho` directory of the project.
        - Configure the connections to your MySQL database within Pentaho.
        - Schedule or run ETL jobs as required to populate the data warehouse.

10. **Serve the Application**

    ```bash
    php artisan serve
    ```

    The application will be accessible at `http://localhost:8000`.

## Configuration

After installation, you may need to perform additional configurations:

### Environment Variables

Ensure all necessary environment variables are set in the `.env` file, especially those related to:

- **Database Connection:** Verify `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.
- **Pentaho Integration:** Ensure `PENTAHO_HOST`, `PENTAHO_PORT`, `PENTAHO_USERNAME`, and `PENTAHO_PASSWORD` are correctly configured.

### Scheduled Tasks

If your application uses scheduled tasks (e.g., for periodic ETL processes), set up a cron job:

1. Open the crontab editor:

    ```bash
    crontab -e
    ```

2. Add the following line to run Laravel's scheduler every minute:

    ```bash
    * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
    ```

### Storage Link

Create a symbolic link to the storage folder:

```bash
php artisan storage:link
```

### Usage 

Once the installation and configuration are complete, you can start using the application.

### Accessing the Application

Open your web browser and navigate to 'http://localhost:8000'.

### Navigating the Dashboard
- Home : Overview of supply chain metrics and key performance indicators.
- Kategori: Overview of Category Information that can be add, edit, and delete based on the CRUD Operations
- Produk : Overview of product sold based on the category and unit that can be add, edit, and delete based on the CRUD Operations
- Vendor : Overview of Vendor and it's contact information that can be add, edit, and delete based on the CRUD Operations
- Lokasi : Overview of the list of location that can be add, edit, and delete based on the CRUD Operations
- Stokis : Overview of the list of stockist and it's contact information that can be add, edit, and delete based on the CRUD Operations
- Mitra  : Overview of the list of partners and it's contact information that can be add, edit, and delete based on the CRUD Operations
- Pembelian: Overview of the list of purchase list complete with the quantity and total price (can be calculated by the program automatically) that can be add, edit, and delete based on the CRUD Operations
- Pengiriman: Overview of the list of shipments for monitoring the available stock in the Inventaris page. that can be add, edit, and delete based on the CRUD Operations (Note: The quantity must less than the amount purchased in the Pembelian Page)
- Inventaris: Overview of the stock available at the inventory that is automatically calculated based on the difference of quantity in the Pembelian and Pengiriman page
- Harga Harian Vendor: Overview of the daily prices of each vendor that can be imported from a csv file
- Dashboard Lama: Overview of the old dashboard before the data warehouse based on the ETL process by pentaho

### Contributing
Contributions are welcome! Please follow these steps to contribute to the project:

1. Fork the Repository
   Click the "Fork" button at the top-right corner of the repository page.

2. Clone Your Fork
   ``` bash
   git clone https://github.com/putuangga-k/Database-Final-Project.git
   ```
   
3. Create a New Branch
   ``` bash
   git checkout -b feature/YourFeatureName
   ```
   
4. Make Your Changes
   Implement your feature or bug fix.

5. Commit Your Changes
   ``` bash
   git commit -m "Add your detailed description of the feature"
   ```
6. Push to Your Fork
   ``` bash
   git push origin feature/YourFeatureName
   ```

7. Create a Pull Request
   Navigate to the original repository and click on "Compare & pull request" to submit your changes for        review.

### License
This project is licensed under the MIT License.
