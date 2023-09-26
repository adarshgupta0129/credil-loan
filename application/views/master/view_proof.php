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
    <div class="col-lg-5">
        <div class="card-box">
            <div class="form">
                <?= form_open(fetch_class() . '/add_proof', array("class" => "", "id" => "signupForm")); ?>

                <div class="form-group">
                    <label class="control-label">Proof Type</label>
                    <select class="form-control opt select2" name="ddprooft" id="ddprooft">
                        <option value="-1">Select Proof Type</option>
                        <option value="1">ID Proof</option>
                        <option value="2">Address Proof</option>

                    </select>
                    <span id="divddprooft" style="color:red"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Proof Name <span class="required">*</span></label>
                    <input type="text" id="txtname" name="txtname" class="form-control empty" placeholder="Enter Proof Name">
                    <span id="divtxtname" style="color:red"></span>
                </div>

                <!-- <div class="form-group">
									<label class="control-label">Gender<span class="required">*</span></label> 
									<input type="text" id="txtgender" name="txtgender" class="form-control empty" placeholder="Enter Gender Name">
									<span id="divtxtgender" style="color:red"></span>
								</div> -->
            </div>

            <div class="form-group">
                <button class="btn btn-info" type="button" onclick="check_submit('signupForm')">Submit</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>


    <div class="col-sm-7">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b><?php echo $table; ?></b></h4>
            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Proof Type</th>
                        <th>Proof Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sn = 1;
                    foreach ($proof as $unit) {
                        if ($unit->proof_status == 1) {
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
                                <select class="form-control opt slog_group" onchange="update_value('<?= $unit->proof_id; ?>', this.value, 'proof_type')">
                                    <option value="1" <?= $unit->proof_type == 'ID Proof' ? "selected" : "" ?>>ID Proof</option>
                                    <option value="2" <?= $unit->proof_type == 'Address Proof' ? "selected" : "" ?>>Address Proof</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" value="<?= $unit->proof_name; ?>" id="<?= $unit->proof_id; ?>" name="<?= $unit->proof_id; ?>" onblur="update_value(this.id, this.value, 'proof_name')" /> </td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-default" onclick="change_status('<?= $unit->proof_id ?>','<?= $stat ?>', 'proof')"><span class='fa fa-refresh' title="Change Status"></span></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>