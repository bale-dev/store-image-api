
<h1>How the user should init project and use API</h1>

In this project you will fild API endpoint to store images, image title and image description. API is authenticated, so the user must first register and then the user can use the endpoint. 

<br />

Initiate project:
- Download project to your computer.
- Locate downloaded folder with terminal and run `composer install` .
- Now copy content from .env.example, create new file .env, paste the content and save. Or run `composer run-script post-root-package-install ` in your terminal.
- Open terminal and run `php artisan key:generate` to generate key for application.
- Next you must create MySQL database and replace `DB_DATABASE` in .env file. You probably won't have to change `DB_USERNAME` and `DB_PASSWORD`, depending on your setup. 
- Now go back to terminal and run `php artisan migrate` to automatically insert required tables in our empty database.
- Your project is now set up for testing. To start run `php artisan serve`.
- In my case the server is running on http://127.0.0.1:8000 and this will be my baseURL for testing. 

<br />

Testing API endpoints:
- You'll need to create 2 requests in Postman or any other program for API testing.
- First you will create user register request:
	1. Example of user register request :
		- Type: POST
		- BaseURL (in my case): http://127.0.0.1:8000 
		- Endpoint: /api/v1/auth/register 
		- Body (JSON):  
			```json
			{ 
			    "name": "Test",
			    "email" : "test@agiledrop.si",
			    "password" : "agiledrop"
			}
			```
		** note - all fields are required! Password field is minimal 8 characters 
	2. You should get a response looking something like this:
		```json
		{
		    "status": true,
		    "message": "User created successfully",
		    "token": "3|PnEgauTBGhccUcQJI2KR9gB8lebC5Qp11AluKCyF7870a0d8"
		}
		```
		** note that we will need token in our second request

- Second, you will create image store request:
	1. Example of image store request:
		- Type: POST
		- BaseURL (in my case): http://127.0.0.1:8000 
		- Endpoint: /api/v1/store-image
		- Form-data: 
			- "image_name" : (type: mix - not required) 
			- "image_description" : (type: mix - not required)
			- "image_file" : (type: file - required)
	
	2. You should get a response looking something like this:
	```json
	{
    "message": "Image was successfully stored",
    "response": {
        "file_type": "jpg",
        "file_size": "0.053 MB",
        "file_path": "D:/store-image-api/public/images/narsil.jpg"
	    }
	}
	```

<br />

Additionaly I created login endpoint so you don't need to keep registering new accounts. Here is an example of login request:
- Type: POST
- BaseURL (in my case): http://127.0.0.1:8000 
- Endpoint: /api/v1/auth/login 
- Body (JSON):  
	```json
	{ 
		"email" : "test@agildrop.si",
		"password" : "agildrop"
	}
	```
** note - all fields are required


<p>Created by: Timotej Balantič </p>



