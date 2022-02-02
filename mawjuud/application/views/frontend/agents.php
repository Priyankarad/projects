<?php include APPPATH.'views/frontend/includes/header.php';  ?>
<div class="compares-pma main-agent-mw">
    <div class="container">
        <h2>Real Estate Agents</h2>
        <table id="agentsTable"  class="table table-bordered responsive-table" style="width:100%">
            <thead>
                <tr>
                    <th style="width:33.33%"></th>
                    <th style="width:33.33%"></th>
                    <th style="width:33.33%"></th>
                </tr>
            </thead>
        </table>
        <div class="row">


        </div> 

    </div>
</div>


<?php include APPPATH.'views/frontend/includes/footer.php'; ?>
<?php include APPPATH.'views/frontend/includes/footer_script.php'; ?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/datatables.min.js?<?php echo $timeStamp;?>"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/login.js?<?php echo $timeStamp;?>"></script>
<script type="text/javascript">
    $('#agentsTable').DataTable({
        processing: true,
        lengthMenu: [6],
        serverSide: true,
        ordering: false,
        ajax:{
            url: baseUrl+'user/agentsData',
            dataType: "json",
            type: "POST",
        },
        drawCallback: function(settings){
        },
        columns: [
        { "data": "agent1" },
        { "data": "agent2" },
        { "data": "agent3" },
        ]   
    });
</script>