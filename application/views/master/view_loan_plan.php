<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <h4 id="das" class="page-title"><?php echo $form; ?></h4>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
            <li class="active"><?php echo $form; ?></li>
        </ol>
    </div>
</div>
<!-- Page-Title -->
<div class="row">
    <div class="col-lg-4">
        <div class="card-box">
            <div class="form">
                <?= form_open(fetch_class() . '/add_loan_plan', array("class" => "", "id" => "signupForm")); ?>

                <div class="form-group">
                    <label class="control-label">Loan Type</label>
                    <select class="form-control opt select2" name="ddloantype" id="ddloantype">
                        <option value="-1">Select Loan Type</option>
                        <?php
                        foreach ($loanType as $bk) {
                        ?>
                            <option value="<?= $bk->ln_type_id; ?>"><?= $bk->ln_type_name; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span id="divddloantype" style="color:red"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Plan Name<span class="required">*</span></label>
                    <input type="text" id="txtplanname" name="txtplanname" class="form-control empty" placeholder="Enter Plan Name.">
                    <span id="divtxtplanname" style="color:red"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Minimum Amount<span class="required">*</span></label>
                    <input type="number" id="txtminamt" name="txtminamt" class="form-control empty" placeholder="Enter Minimum Amount">
                    <span id="divtxtminamt" style="color:red"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Maximum Amount<span class="required">*</span></label>
                    <input type="number" id="txtmaxamt" name="txtmaxamt" class="form-control empty" placeholder="Enter Maximum Amount">
                    <span id="divtxtmaxamt" style="color:red"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Annual Intrest</label>
                    <input type="text" id="txtanint" name="txtanint" class="form-control" placeholder="Enter Annual Intrest In %">
                    <span id="divtxtanint" style="color:red"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Charges</label>
                    <input type="text" id="txtcharges" name="txtcharges" class="form-control" placeholder="Enter Charges In %">
                    <span id="divtxtcharges" style="color:red"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Minimum Month</label>
                    <input type="Number" id="txtminmonth" name="txtminmonth" class="form-control" placeholder="Enter Minimum Month">
                    <span id="divtxtminmonth" style="color:red"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Maximum Month </label>
                    <input type="text" id="txtmaxmonth" name="txtmaxmonth" class="form-control" placeholder="Enter Maximum Month">
                    <span id="divtxtmaxmonth" style="color:red"></span>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-info" type="button" onclick="check_submit('signupForm')">Submit</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>


    <div class="col-sm-8">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b><?php echo $table; ?></b></h4>
            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Loan Type</th>
                        <th>Plan Name</th>
                        <th>Minimum Amount</th>
                        <th>Maximum Amount</th>
                        <th>Annual Intrest (%)</th>
                        <th>Charges(%)</th>
                        <th>Minimum Month</th>
                        <th>Maximum Month</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sn = 1;
                    foreach ($loanPlan as $unit) {
                        if ($unit->ln_plan_status == 1) {
                            $status = "success";
                            $stat = 0;
                        } else {
                            $status = "danger";
                            $stat = 1;
                        }
                    ?>
                        <tr class="<?= $status ?>">
                            <td><?= $sn++; ?></td>
                            <td>
                                <select class="form-control opt slog_group" onchange="update_value('<?= $unit->ln_plan_id; ?>', this.value, 'loanPlanType')">
                                    <?php foreach ($loanType as $v) { ?>
                                        <option value="<?= $v->ln_type_id ?>" <?= $unit->ln_plan_type_id == $v->ln_type_id ? "selected" : "" ?>><?= $v->ln_type_name ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" value="<?= $unit->ln_plan_name; ?>" onblur="update_value('<?= $unit->ln_plan_id; ?>', this.value, 'loanPlanName')" /> </td>
                            <td><input type="text" class="form-control" value="<?= $unit->ln_plan_min_amt; ?>" onblur="update_value('<?= $unit->ln_plan_id; ?>', this.value, 'loanPlanMinAmt')" /> </td>
                            <td><input type="text" class="form-control" value="<?= $unit->ln_plan_max_amt; ?>" onblur="update_value('<?= $unit->ln_plan_id; ?>', this.value, 'loanPlanMaxAmt')" /> </td>
                            <td><input type="text" class="form-control" value="<?= $unit->ln_plan_annual_interest; ?>" onblur="update_value('<?= $unit->ln_plan_id; ?>', this.value, 'loanPlanAnnualInterest')" /> </td>
                            <td><input type="text" class="form-control" value="<?= $unit->ln_plan_proc_fee_percent; ?>" onblur="update_value('<?= $unit->ln_plan_id; ?>', this.value, 'loanPlanFee')" /> </td>
                            <td><input type="text" class="form-control" value="<?= $unit->ln_plan_min_tanure; ?>" onblur="update_value('<?= $unit->ln_plan_id; ?>', this.value, 'loanMinMonth')" /> </td>
                            <td><input type="text" class="form-control" value="<?= $unit->ln_plan_max_tanure; ?>" onblur="update_value('<?= $unit->ln_plan_id; ?>', this.value, 'loanMaxMonth')" /> </td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-default" onclick="change_status('<?= $unit->ln_plan_id ?>','<?= $stat ?>', 'loanPlan')"><span class='fa fa-refresh' title="Change Status"></span></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>