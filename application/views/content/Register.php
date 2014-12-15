<?php if (!empty($data)) { ?>
    <div class="row">
        <div class="text-center">
            <h1 class="text-<?php echo $data['code']; ?>">
                <?php echo $data['msg']; ?>
            </h1>
            <a href="/home">Return to home</a>
        </div>
    </div>

<?php } else { ?>
    <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
            <form role="form" method="post" action="/register">
                <h2 class="form-signin-heading">Sing up</h2>

                <div class="form-group">
                    <input type="text" name="username" id="username" class="form-control"
                           placeholder="Name" required>
                </div>

                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control"
                           placeholder="Email Address" required>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="Password" required>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" placeholder="Confirm Password" required>
                        </div>
                    </div>
                </div>

                <input type="submit" name="register" value="Register" class="btn btn-primary btn-block">

            </form>
        </div>
    </div>
<?php } ?>