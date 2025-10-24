# project-database  
Laravel project for project-database.  

- Runs Laravel migrations inside the Sail container to create or update database tables:
```bash
./vendor/bin/sail artisan migrate 
```

Up product in database:
```bash
./vendor/bin/sail artisan migrate:fresh --seed

```

Up git (if in vs code use wsl) - 
```bash
git config --global user.name "Your Name"
```

```bash
git config --global user.email "your_email@example.com"
```

Start the development server:
```bash
./vendor/bin/sail npm run dev
git fetch origin
```

Note!!  "freah" mean if you use this data in dbeaver wil be lost all

-./vendor/bin/sail up -d

-./vendor/bin/sail npm run dev
open  http://localhost

