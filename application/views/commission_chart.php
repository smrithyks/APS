<?php if (!empty($comm_details)){?>
<div class="col-lg-12">
          <p>
            <label>Commission Chart </label>
        </p>
        <?php
        ?>
        <table class="table table-hover table-bordered personal-task" id ="tbl_commission">
            <thead>
                <tr>
                     <th>User</th>    
                    <th>Commission Amount</th>   
                    <th>Level</th> 
                 </tr>
            </thead>
            <tbody>
            <?php
                foreach($comm_details as $details){
            ?>
                <tr>
                    <td><?php echo $details->username; ?></td>
                    <td><?php echo $details->commission_amount; ?></td>
                    <td><?php echo $details->level; ?></td>
                </tr>
            <?php } ?>
                 
            </tbody>
        </table>
    </div>
    <?php } ?>