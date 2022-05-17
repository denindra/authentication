  SPESIFICATION
        1 PHP 8.0
        2. Laravel Framework 8.83.12
        3. menggunakan repository pattern design
        4. API Auth ===> Sanctum
  STANDARISASI
    - log format
     {nama_module};{method};{deskripsi};{dieksekusi oleh};{status ( success, failed )}

    -JOURNEY PATTERN
    /app
        1. ROUTES                           --> routing
            API/{GROUPNAME}
                    /{PRIVATE} {MIDDLEWARE}
                    /{PUBLIC}
        2. REQUEST                          --> data validation
            HTTP/{NamaModul}
                    /{namamodul}Request
        2. CONTROLLER                       --> business logic
                    /{NamaModule}Controller
                    /FORM VALIDATION {PHP ARTISAN MAKE:REQUEST}
        3. SERVICES                         --> code Logic
                /Services
                    /{NamaModul}Services
                        /{NamaModul}COMMAND {UNTUK INSERT, UPDATE, DETELE HANDLE}
                        /{NamaModul}QUERY   {UNTUK GET HANDLE}
        4. REPOSITORIES                      --> query database
                /Repositories
                    /{NamaModule}Repository
        5. PIPELINEFILTER                   --> query condition
                /PipelineFilter
                    /{namaModule}PipeLine
                        /{pipelineName}
        6. DATA RESOURCE                     --> data manipulation
            /HTTP
                /{namaModule}Resource
                    /{JenisCollection}Resource

        //====apabila butuh jobs
        7. JOBS
            /Jobs
                /{modul}Jobs
                    /{namaTask}Jobs

    -JOB PROCESS
        1. reset password / forgot password --> queuename : resetEmailNotif 
        2. verify user account              --> queuename : verifyuserNotif   
        
        -Testing Jobs
            1.php artisan queue:listen
                - hanya berjalan apabila isi dari kolum queuenya default
                - apabila ada spesific namenya harus jalankan namaqueuename nya
            2.php artisan queue:work --queue={nama queuenameny} 
                -spesific ke nama terkait
            3.php artisan queue:work --queue=high,{nama queuenameny} 
                -high di situ menenjukan menjalankan sebagai prioritas

    -FITUR
        1.  login
        2.  forgot password
        3.  reset password
        4.  user profile
        5.  logout
        6.  get scrf token
        7.  create account
        8.  delete user
        9.  edit user
        10. list user
        11. verify user
    -SETUP
        1. COMPOSER INSTALL
        2. COPY .ENV.EXAMPLE KE .ENV
        3. php artisan migrate
        4. php artisan key:generate
        5. isi .env yang sesuai 
            - include URL (jgn lupa mailer account beserta frontend url untuk pengembalian token forgot password)
            - database connection
        6. recheck timezone == > config/app.php
        7. ubah QUEUE_CONNECTION=sync MENJADI database
        8. apabila di server install supervisor di ubuntu
    


