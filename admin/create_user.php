<?php

?>

<h3 class="text-center text-primary">Create New User</h3>
<form class="form" method="POST" action="" data-toggle="validator" role="form">
    <input type="hidden" name="type_of_visit" value="briefing">
    <div class="form-group row has-feedback">
        <label>1. Full Name</label>
        <input name="full_name" pattern="^[_A-z0-9-., ]{1,}$"
               data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
               placeholder="Full Name">
        <div class="help-block with-errors"></div>
    </div>

    <div class="form-group row has-feedback">
        <label>2. Rank</label>
        <input name="rank" pattern="^[_A-z0-9-., ]{1,}$"
               data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
               placeholder="Rank">
        <div class="help-block with-errors"></div>
    </div>

    <div class="form-group row has-feedback">
        <label>3. BD/No</label>
        <input name="svc_no" pattern="^[0-9 ]{1,}$"
               data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
               placeholder="BD No">
    </div>

    <div class="form-group row has-feedback">
        <label>4. Branch/Trade</label>
        <input name="br_trade" pattern="^[_A-z0-9-., ]{1,}$"
               data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
               placeholder="Branch/ Trade">
        <div class="help-block with-errors"></div>
    </div>

    <div class="form-group row has-feedback">
        <label class="required">5. Present Unit </label>
        <input type="text" pattern="^[_A-z0-9-., ]{1,}$"
               data-pattern-error="Special Character (&,$,# etc) not allowed" class="form-control"
               id="unit" name="unit" placeholder="Unit">
        <div class="help-block with-errors"></div>
    </div>

    <div class="form-group row">
        <label>6. Date of Birth</label>
        <input type="date" class="form-control" name="dob">
    </div>

    <button style="margin-left: 280px" type="submit" class="btn btn-success" name="btn_submit">Submit
    </button>
</form>
