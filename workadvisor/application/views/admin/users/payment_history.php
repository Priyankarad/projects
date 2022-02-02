<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span> Payment History
                        
                    </div><br/>
                    <div class="current_games_section">
                        <table id="team_salary" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Amount(in USD)</th>
                                    <th>Payment Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Number Of Days</th>
                                    <th>Payment Status</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($paymentData)){ $i = 1; foreach ($paymentData as $row) { ?>
                            <tr>
                                <td>
                                    <?php echo $i;?>
                                </td>
                                <td>
                                    <?php echo ucfirst($row['firstname'])." ".ucfirst($row['lastname']);?>
                                </td>
                                <td>
                                    <?php echo $row['amount'];?>
                                </td>
                                <td>
                                    <?php echo $row['payment_type'];?>
                                </td>
                                <td>
                                    <?php 
                                    if(isset($row['start_date']))
                                        echo date('d-m-Y',strtotime($row['start_date']));
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    if(isset($row['end_date']))
                                        echo date('d-m-Y',strtotime($row['end_date']));
                                    ?>
                                </td>
                                <td>
                                    <?php echo $row['no_of_days'];?>
                                </td>
                                <td>
                                    <?php echo $row['status'];?>
                                </td>
                                <td>
                                    <?php echo date("d-m-y H:i:s",strtotime($row['created_date']));?>
                                </td>
                           </tr>
                            <?php $i++; } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</section>

