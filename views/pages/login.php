<div class="col-md-12" id="bgLogReg">
    <div class="col-md-5" id="backLogReg"> <br /> <br />
        <form class="form-control d-flex flex-column p-3" action="" method="POST">
            <div id="response"></div>
            <div class="form-group">
                <label for="loginEmail">E-mail or username:</label>
                <br />
                <input class="form-control" type="email" name="loginEmail" id="loginEmail"
                    placeholder="mail@example.com" />
                <span id="loginEmailError"></span>
                <br />
            </div>
            <div class="form-group">
                <label for="loginPass">Password:</label>
                <input class="form-control" type="password" name="loginPass" id="loginPass" placeholder="******" />
                <span id="loginPassError"></span>
                <br />
            </div>
            <input type="button" class="btn btn-warning" id="btnLogin" value="Login" />
            <span class="mt-4">Don't have an account? Create one <a href="index.php?page=registration">here</a>.</span>
        </form>
    </div>
</div>