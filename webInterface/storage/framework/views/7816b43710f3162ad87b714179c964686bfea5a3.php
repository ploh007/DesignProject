 <?php $__env->startSection('content'); ?>

<body>
    <div class="jumbotron red-jumbotron" data-wow-duration="2s">
        <div class="container">
            <h2>Login to use the Gesture Control Device</h2>
            <p>
                Signing up with the gesture control device enables you to calibrate, manage and use apps with the device.
            </p>
        </div>
    </div>
    <div class="container">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Login</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/login')); ?>">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required autofocus> <?php if($errors->has('email')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span> <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                    <label for="password" class="col-md-4 control-label">Password</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required> <?php if($errors->has('password')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span> <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn custom-btn">
                                            Login
                                        </button>
                                        <a class="btn btn-default" href="<?php echo e(url('/password/reset')); ?>">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('common.basic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>