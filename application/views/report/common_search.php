<?= form_open(fetch_class().'/'.fetch_method().'/'.uri(3).'/'.uri(4), array("class" => "cmxform horizontal-form", "id" => "signupForm")); ?>

<div class="row">

    <!--div class="col-md-4">
        <div class="form-group">
            <label class="control-label">Login Id<span class="required"> * </span>
            </label>
            <input type="text" id="txtlogin" name="txtlogin"  class="form-control input-inline input-medium" placeholder="Enter login id.">
        </div>
    </div-->

    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label">Mobile No</label>
            <input type="text" id="txtmob" name="txtmob" class="form-control input-inline input-medium" placeholder="Enter Mobile No.">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label">Name</label>
            <input type="text" id="txtname" name="txtname" class="form-control input-inline input-medium" placeholder="Enter Name.">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label">From Joining Date<span class="required"> * </span>
            </label>
            <div class="input-daterange input-group" id="date-range" data-date-format="yyyy-mm-dd">
                <input type="text" class="form-control" name="start" autocomplete="off" />
                <span class="input-group-addon bg-custom b-0 text-white">to</span>
                <input type="text" class="form-control" name="end" autocomplete="off" />
            </div>
        </div>
    </div>

    <!--div class="col-md-4">
        <div class="form-group">
            <label class="control-label">Type</label>
            <select id="ddtype" name="ddtype" class="form-control">
                <option selected="selected" value="-1">Select Type</option>
                <?php
                foreach ($rank->result() as $p) {
                ?>
                <option value="<?php echo $p->m_des_id; ?>">
                    <?php echo $p->m_des_name; ?></option>
                <?php
                }
                ?>
            </select>
            <span id="divddtype" style="color:red"/>
        </div>
    </div-->

</div>
<div class="row">
    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            <button class="btn btn-info" type="submit">Submit</button>
            <button type="button" class="btn btn-danger">Cancel</button>
        </div>
    </div>
</div>
<?php echo form_close(); ?>