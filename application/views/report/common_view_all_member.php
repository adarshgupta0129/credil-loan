<table id="datatable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>S No.</th>
            <!--th nowrap>Action</th-->
            <th>LoginId</th>
            <th>Mobile No</th>
            <th>Name</th>
            <th>Date</th>
            <th>City</th>
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
                <!--td nowrap>
                    <a href="<?= base_url() ?>member/view_member_edit/<?= $rows->user_reg_id; ?>" title="Edit Profile"><i class="fa fa-pencil text-primary"></i></a> | 
                    <a href="<?= base_url(); ?>member/resend_msg/<?= $rows->user_reg_id; ?>" title="Send Sms"><i class="md md-email text-primary"></i></a>
                </td-->
                <td><?= $rows->user_u_id; ?></td>
                <td><?= $rows->user_mobile_no; ?></td>
                <td><?= $rows->user_name; ?></td>
                <td><?= date('d-m-y', strtotime($rows->user_joining_date)); ?></td>
                <td><?= $rows->City; ?></td>
            </tr>
        <?php $sn++;
        } ?>
    </tbody>
</table>