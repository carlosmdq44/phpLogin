

<?php $__env->startSection('content'); ?>
<form action="/login" method="POST">
    <?php echo csrf_field(); ?>
    <h1>Login</h1>
    <?php echo $__env->make('layouts.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Username / Email address</label>
        <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword2" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword2">
    </div>
    <div class="mb-3">
        <a href="/register">Create account</a>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\carlo\OneDrive\Escritorio\php\loginLaravel\resources\views/auth/login.blade.php ENDPATH**/ ?>