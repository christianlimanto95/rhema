<form class="form-change-password" method="post" action="<?php echo base_url("admin/do_change_password") ?>">
    <div class="form-item">
        <div class="label">Password Lama</div>
        <input type="password" name="old-password" class="form-input old-password" maxlength="40" />
    </div>
    <div class="form-item">
        <div class="label">Password Baru</div>
        <input type="password" name="new-password" class="form-input new-password" maxlength="40" />
    </div>
    <div class="form-item">
        <div class="label">Confirm Password Baru</div>
        <input type="password" name="confirm-new-password" class="form-input confirm-new-password" maxlength="40" />
    </div>
    <div class="btn btn-submit">Submit</div>
</form>