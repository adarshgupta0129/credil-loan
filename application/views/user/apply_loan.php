<!-- Start content -->

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <h4 id="das" class="page-title">
            <?php echo $page; ?>
        </h4>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>master/index">Dashboard</a>
            </li>
            <li class="active">
                <?php echo $form_name; ?>
            </li>
        </ol>
    </div>
</div>
<!-- Page-Title -->
<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title">
                <b>
                    <?php echo $form_name; ?>
                </b>
            </h4>
            <p class="text-muted font-13 m-b-30" />

            <div class="form">

                <?= form_open('userprofile/add_apply_loan', array("class" => "cmxform horizontal-form", "id" => "signform")); ?>

                <div class="row">

                    <div class="form-group col-md-4">
                        <label class="control-label">Loan Type</label>
                        <select class="form-control opt select2" name="ddloantype" id="ddloantype" onchange="get_loan_plan(this.value)">
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

                    <div class="form-group col-md-4">
                        <label class="control-label">Loan Plan</label>
                        <select class="form-control" name="ddloanplan" id="ddloanplan" onchange="add_loan(this.value)">
                            <option value="-1">Select Loan Type</option>
                        </select>
                        <span id="divddloanplan" style="color:red"></span>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Loan Amount</label>
                            <input type="text" id="txtloanamt" name="txtloanamt" class="form-control input-inline input-medium" placeholder="Enter Loan Amount.">
                        </div>
                        <span id="divtxtloanamt" style="color:red"></span>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Inteest Rate </label>
                            <input type="text" id="txtinterst" name="txtinterst" class="form-control input-inline input-medium" placeholder="Enter Name.">
                        </div>
                        <span id="divtxtinterst" style="color:red"></span>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Charges </label>
                            <input type="text" id="txtcharges" name="txtcharges" class="form-control input-inline input-medium" placeholder="Enter Name.">
                        </div>
                        <span id="divtxtcharges" style="color:red"></span>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <button class="btn btn-info" onclick="check_amt()" type="button">Submit</button>
                            <button type="button" class="btn btn-danger">Cancel</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="hf_min">
                <input type="hidden" id="hf_max">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <script>
        function check_amt() {
            val = $("#txtloanamt").val();
            if ($("#hf_min").val() <= parseInt(val) && parseInt(val) <= $("#hf_max").val()) {
                $("#signform").submit();
            } else {
                $("#txtloanamt").focus();
                $("#divtxtloanamt").html('Ammount must be between ' + $("#hf_min").val() + " and " + $("#hf_max").val());
            }
        }
    </script>

    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">
                <b>
                    <?php echo $table_name; ?>
                </b>
                <button onclick="exportTableToExcel('datatable', '<?= $table_name; ?>')" class="btn btn-success btn-xs pull-right">Export Data</button>
            </h4>

            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S No.</th>
                        <!--th nowrap>Action</th-->
                        <th>Loan Type</th>
                        <th>Loan Plan</th>
                        <th>Loan Amount</th>
                        <th>Intrest</th>
                        <th>Charges</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="userid">
                    <?php
                    $sn = 1;
                    foreach ($rid->result() as $rows) { ?>
                        <tr>
                            <td>
                                <?php echo $sn; ?>
                            </td>

                            <td><?= $rows->ln_bk_booking_num; ?></td>
                            <td><?= $rows->ln_bk_loan_plan_id; ?></td>
                            <td><?= $rows->ln_bk_loan_amt; ?></td>
                            <td><?= $rows->ln_bk_intrest_rate; ?></td>
                            <td><?= $rows->ln_bk_proc_charges; ?></td>
                            <td><?= $rows->ln_bk_status; ?></td>

                        </tr>
                    <?php $sn++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>