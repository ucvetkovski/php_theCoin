<div class="col-md-12" id="bgLogReg">
    <div class="col-md-5" id="backLogReg">
        <form class="form-control d-flex flex-column p-3" id="regForm" action="" method="POST">
            <div id="response"></div>
            <div class="form-group">
                <label for="firstName">Name:</label>
                <input class="form-control" type="text" name="firstName" id="firstName" placeholder="Name" />
                <span id="firstNameError"></span>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input class="form-control" type="text" name="lastName" id="lastName" placeholder="Last Name" />
                <span id="lastNameError"></span>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input class="form-control" type="text" name="username" id="username" placeholder="Username" />
                <span id="usernameError"></span>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="mail@example.com" />
                <span id="emailError"></span>
            </div>
            <div class="form-group">
                <label for="pass">Enter Your password:</label>
                <input class="form-control" type="password" name="pass" id="pass" placeholder="******" />
                <span id="passError"></span>
            </div>
            <div class="form-group">
                <label for="passCheck">Repeat Your password:</label>
                <input class="form-control" type="password" name="passCheck" id="passCheck" placeholder="******" />
                <span id="passCheckError"></span>
                <br />
            </div>
            <input type="button" id="regSubmit" class="btn btn-warning" value="Register" />
            <span class="mt-4">Already have an account? <a href="index.php?page=login">Login here</a>.</span>
        </form>
    </div>
</div>