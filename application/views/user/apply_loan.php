<!-- Start content -->

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <!-- <h4 id="das" class="page-title">
            <?php echo $page; ?>
        </h4> -->
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>userprofile/index">Dashboard</a>
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
                        <select class="form-control opt" name="ddloantype" id="ddloantype" onchange="get_loan_plan(this.value)">
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
                        <select class="form-control opt" name="ddloanplan" id="ddloanplan" onchange="add_loan1(this.value)">
                            <option value="-1">Select Loan Type</option>
                        </select>
                        <span id="divddloanplan" style="color:red"></span>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Loan Amount</label>
                            <input type="text" id="txtloanamt" name="txtloanamt" class="form-control numeric" placeholder="Enter Loan Amount">
                        </div>
                        <span id="divtxtloanamt" style="color:red"></span>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Interest Rate </label>
                            <input type="text" id="txtinterst" name="txtinterst" class="form-control empty" placeholder="Interest Rate">
                        </div>
                        <span id="divtxtinterst" style="color:red"></span>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Charges </label>
                            <input type="text" id="txtcharges" name="txtcharges" class="form-control empty" placeholder="Charges">
                        </div>
                        <span id="divtxtcharges" style="color:red"></span>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <button class="btn btn-info" onclick="check_amt('signform')" type="button">Submit</button>
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
                        <!-- <th>Loan Type</th> -->
                        <th>Loan Plan</th>
                        <th>Loan Amount</th>
                        <th>Intrest</th>
                        <!--th>Charges</th-->
                        <th>Apply Loan Data</th>
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

                            <td><?= $rows->ln_plan_name; ?></td>
                            <td><?= $rows->ap_ln_apply_amt; ?></td>
                            <td><?= $rows->ap_ln_interest; ?></td>
                            <!--td><?= $rows->ap_ln_charges; ?></td-->
                            <!-- <td><?= $rows->ln_bk_proc_charges; ?></td> -->
                            <td><?= $rows->ap_ln_date; ?></td>
                            <td><?= $rows->ap_ln_status; ?></td>

                        </tr>
                    <?php $sn++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>