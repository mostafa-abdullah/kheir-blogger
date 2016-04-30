# Kheir Blogger
This project is built using laravel 5.2

#### Server Deployment
You can run the server using artisan:
```
$ php artisan serve
```

It will run on `localhost` port `8000`. The command has options to change the host and port configurations. To run the server forever, you will need something like
**Supervisor**.

#### Scheduling
There are some scheduled tasks that run periodically. For example, the server needs to send notifications to volunteers registering for recently finished events to confirm their attendance. To run the schedule for only one time, run the following command:
```
$ php artisan schedule:run
```

To synchronize the schedule run, add this cron entry to the server:
```
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

Schedule commands can be found in `app/Console/Kernel.php`. Current commands are set to one minute for development. You can set them to more reasonable values in case of production.

#### Elasticsearch Server
Search engine works with Elasticsearch. For the engine to work, you will need to install Elasticsearch server and run it on the default port `9300`. organizations and events are added/deleted to the Elasticsearch index on their creation/deletion. For more control on the indices, two artisan commands are added
```
$ php artisan elastic:create index_name
```
This will create a new Elasticsearch index and add currently created records
that exist in the database to the index.
```
$ php artisan elastic:delete index_name
```
This will delete an existing Elasticsearch index from the server.

Available index_name: `organizations`, `events`

#### Mail Server
Needed for email verifications and password reset. To configure the mail server

- Go to .env file
- **Assuming you are using Gmail**, make the email configuration as follows:
```
MAIL_DRIVER=smtp MAIL_HOST=smtp.gmail.com MAIL_PORT=587 MAIL_USERNAME=<< Your email here >> MAIL_PASSWORD=<< Your password here >> MAIL_ENCRYPTION=tls
```
- Go to config\mail.php and find this line
```
'from' => ['address' => 'mostafaabdullahahmed@gmail.com', 'name' => 'Kheir Blogger'],
```
Change the address to the email you entered in the .env file. Now the volunteer and the organization can reset their password and the email is sent from the entered email.
