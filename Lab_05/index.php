<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <form action="formhandle.php" method="POST"   id="formdata"> 
        <label for="salutation">Salutation:</label>
        <select id="" name="salutation" id="salutation">
        <option value="Mr">Mr</option>
        <option value="Mrs">Mrs</option>
        <option value="Ms">Ms</option>
        <option value="Dr">Dr</option>
        <option value="Prof">Prof</option>
        <option value="Sir">Sir</option>
        </select>
        <label for="Fname">First name:</label>
        <input type="text" placeholder="First name" name="Fname" id="Fname" required pattern="[A-Za-z]+">
        <label for="Mname">Middle name:</label>
        <input type="text" placeholder="Middle name" name="Mname" id="Mname" pattern="[A-Za-z]+">
        <label for="Lname">Last name:</label>
        <input type="text" placeholder="Last name" name="Lname" id="Lname" required pattern="[A-Za-z]+">
        <br>
        <label for="age">Age:</label>
        <input type="number" name="age" min="17" placeholder="Age" id="age" required pattern="[0-9]+">
        <label for="email">E-mail:</label>
        <input type="email" name="email" placeholder="e-mail" id="email" required>
        <label for="phone">Phone number:</label>
        <input type="tel" placeholder="xxx-xxxx-xxxx" name="phone" id="phone" pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}">
        <br>
        <label for="arrival">Date of arrival:</label>
        <input type="date" name="arrival" id="arrival" min="<?php echo date("Y-m-d");?>" required>
        <label for="ref">Refference:</label>
        <input type="text" name="ref" id="ref" maxlength="8" minlength="8" required pattern="[A-Za-z-0-9]+">
        <br>
        <input type="submit" value="Submit">
        <br>
        <a href="download.php?file=register.csv">Download</a>
        <br>
        <p>Number of registrations:<?php if(file_exists('register.csv'))echo sizeof(file('register.csv',FILE_SKIP_EMPTY_LINES)) ?> </p>

        </form>
    </body>

</html>
