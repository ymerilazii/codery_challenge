<?php

include 'layouts/header.php';
include 'database/db.php';
include 'database/dataCRUD.php';
$r = '';
if (isset($_GET['error'])) {
    $r = "<p class='text-danger'>This Name already exists!</p>";
} else {
    $_GET['error'] = '';
}
if (isset($_GET['success'])) {
    $r = "<p class='text-success'>Record Created Successfully!</p>";
} else {
    $_GET['success'] = '';
}

$db = new Database();
?>
<?php
$st = new dataCRUD($db->connect()); ?>
    <div class="container mt-5 text-center">
        <div class="container bg-light c-1 mx-auto p-5">
            <h2 class="display-4">User Input Form</h2>
            <?php echo $r;
            $r = '' ?>
            <form id="form_submit" method="post" action="<?php $st->createDataForm();
            $db->disconnect(); ?>" class="mt-5 text-center needs-validation">
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                   placeholder="First Name" required>
                            <label for="firstname">First Name</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                   placeholder="Last Name" required>
                            <label for="lastname">Last Name</label>
                        </div>
                    </div>
                </div>
                <div class="row g-2 my-3">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Email Address" required>
                            <label for="email">Email address</label>
                        </div>
                    </div>
                </div>
                <div class="row g-2 my-3">
                    <div class="col-md-8">
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="phone" name="phone"
                                   placeholder="Phone Number" pattern="[+]{1}[0-9]{7,15}" required>
                            <label for="phone">Phone Number</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select" id="martialstatus" required name="martialstatus">
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="widowed">Widowed</option>
                                <option value="divorced">Divorced</option>
                                <option value="domestic partnership">Domestic Partnership</option>
                            </select>
                            <label for="martialstatus">Martial Status</label>
                        </div>
                    </div>
                    <p class="text-start text-muted fw-light mx-2 my-0" style="font-size: 14px">Format: +38312345678</p>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" name="submit">Submit</button>
            </form>
        </div>
    </div>
<?php
include 'layouts/bottom.php';
?>