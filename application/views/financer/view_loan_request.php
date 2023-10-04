<!-- Start content -->



<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <h4 id="das" class="page-title">
            <?php echo $page; ?>
        </h4>
        <ol class="breadcrumb">
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li class="active">
                <?php echo $form_name; ?>
            </li>
        </ol>
    </div>
</div>
<!-- Page-Title -->
<div class="row">
    <!--iv class="col-lg-12">
        <div class="card-box">
            <h4 class="m-t-0 header-title">
                <b>
                    <?php echo $form_name; ?>
                </b>
            </h4>
            <p class="text-muted font-13 m-b-30" />

            <div class="form">
            <?= form_open(fetch_class().'/'.fetch_method().'/'.uri(3).'/'.uri(4), array("class" => "cmxform horizontal-form", "id" => "signupForm")); ?>

                <div class="row">


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
            </div>
        </div>
    </div-->

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
                        <th>User Name|Contact Number</th>
                        <th>Loan Plan</th>
                        <th>Loan Amount</th>
                        <th>Apply Loan Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="userid">
                    <?php
                    $sn = 1;
                    foreach ($applyLoan as $rows) { ?>
                        <tr>
                            <td>
                                <?php echo $sn; ?>
                            </td>
                            <td><?= $rows->user_name; ?> | <?= $rows->user_mobile_no; ?></td>
                            <td><?= $rows->ln_plan_name; ?></td>
                            <td><?= $rows->ap_ln_apply_amt; ?></td>
                            <td><?= date('d-m-y', strtotime($rows->ap_ln_date)); ?></td>
                            <td><?= $rows->ap_ln_status; ?></td>
                            <td class="text-center">
                                <?php
                                if ($rows->ap_ln_status == 'Pending') {
                                ?>
                                    <a href="javascript:void(0)" onclick="link_submit('<?= base_url().fetch_class() ?>/approve_loan/<?= $rows->ap_ln_id; ?>/1')" class=" btn btn-xs btn-success">
                                        Approved
                                    </a>
                                    <a href="javascript:void(0)" onclick="link_submit('<?= base_url().fetch_class() ?>/Reject_loan/<?= $rows->ap_ln_id;; ?>')" class="btn btn-xs btn-danger">
                                        Reject
                                    </a>
                                <?php } else { ?>

                                <?php } ?>

                            </td>
                        </tr>
                    <?php $sn++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>