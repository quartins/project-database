# project-database  
Laravel project for project-database.  

- Runs Laravel migrations inside the Sail container to create or update database tables:
```bash
./vendor/bin/sail artisan migrate 
```

Up product in database:
./vendor/bin/sail artisan migrate:fresh --seed
  

Up git (if in vs code use wsl) -  
git config --global user.name "Your Name"
git config --global user.email "your_email@example.com"


Start the development server:
./vendor/bin/sail npm run dev


