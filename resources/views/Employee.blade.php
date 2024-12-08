<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        form input[type="text"],
        form input[type="date"],
        form input[type="int"],
        form input[type="file"],
        form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            width: 100%;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #4CAF50;
        }
    </style>
</head>
<body>

    <form action="/add" method="POST">
        @csrf
        <h1>Add Employee</h1>
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name">
        
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name">
        
        <label for="address">Address:</label>
        <input type="text" name="address" id="address">
        
        <label for="birthdate">Birth Date:</label>
        <input type="date" name="birthdate" id="birthdate">
        
        <label for="contact_no">Contact:</label>
        <input type="int" name="contact_no" id="contact_no">
        
        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value=""></option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        
        
        <label for="statutory_benefits">Statutory benefits:</label>
        <select id="statutory_benefits" name="statutory_benefits">
        <option value=""></option>
            <option value="SSS">SSS</option>
            <option value="Pag-Ibig">Pag-Ibig</option>
            <option value="PhilHealth">PhilHealth</option>
            <option value="SSS,Pag-Ibig">SSS,Pag-Ibig</option>
            <option value="SSS,PhilHealth">SSS,PhilHealth</option>
            <option value="SSS,Pag-Ibig,PhilHealth">SSS,Pag-Ibig,PhilHealth</option>
            <option value="Pag-Ibig,PhilHealth">Pag-Ibig,PhilHealth</option>
        </select>
        
        <label for="photo">ID Image:</label>
        <input type="file" id="photo" name="photo" accept="image/*" >
        
        <input type="submit" value="Submit">
       
    </form>
    <button class="btn btn-primary mb-3" onclick="window.location.href='/addEmployeeList';">
    <i class="fas fa-plus"></i> back
</button>
</body>
</html>
