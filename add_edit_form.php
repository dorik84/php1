<?php

function add_edit_form ($fname="", $lname="", $email="", $phone="", $address="", $city="", $state="", $postal="", $dob="", $id="") {
    $self_server=$_SERVER['PHP_SELF'];
    echo <<<ADDFORMstart
    <form class="row g-3" method="post" action="$self_server">

        <div class="row" >
            <div class="col py-1">
                <label  class="form-label">First Name</label>
                <input type="text" class="form-control" placeholder="First name" name="fname" aria-label="First name" maxlength="30" value="$fname" required>
            </div>
            <div class="col py-1">
                <label  class="form-label">Last Name</label>
                <input type="text" class="form-control" placeholder="Last name" name="lname" aria-label="Last name" maxlength="30" value="$lname" required>
            </div>
        </div>


        <div class="row">
            <div class="col py-1">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="sample@sample.ca" maxlength="30" value="$email" required>
            </div>
            <div class="col py-1">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="inputPassword4" name="phone" placeholder="1-234-567-8899" maxlength="12" value="$phone">
            </div>
        </div>

        <div class="row">
            <div class="col py-1">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address" maxlength="50" value="$address">
            </div>
        </div>

        <div class="row">
            <div class="col py-1">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="New York" maxlength="20" value="$city">
            </div>
            <div class="col py-1">
                <label for="inputState" class="form-label">State</label>
                <select id="inputState" class="form-select" maxlength="2" name="state" >
                    
    ADDFORMstart;
        $provinces=array ("AB", "BC", "MB", "NB", "NL", "NT", "NS", "NU", "ON", "PE", "QC", "SK", "YT");
        foreach ($provinces as $key => $value) {
            if ($value === $state) echo "<option selected>$value</option>"; else echo "<option>$value</option>";
            
        } 


    echo <<<ADDFORMcontinue
                </select>
            </div>
            <div class="col py-1">
                <label for="inputZip" class="form-label">Postal Code</label>
                <input type="text" class="form-control" id="zip" name="postal" placeholder="B2N 0A9" maxlength="7" value="$postal">
            </div>
            <div class="col py-1">
                <label for="inputZip" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" placeholder="yyyy-mm-dd" maxlength="10" value="$dob" required>
            </div>
        </div>
        <div class="col py-1">
        <button type="submit" name="submit" class="btn btn-primary" value="$id">Submit</button>
        <a  class="btn btn-outline-primary" href="menu.php">Cancel</a>
        </div>
    </form>
    ADDFORMcontinue;
}
?>