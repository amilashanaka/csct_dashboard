<?php include_once('inc/function.php');?>


<!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-brain"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">LSTM Time Steps</span>
                <a href="user_daily_statement_dash.php"><span class="info-box-number"><?=get_time_steps($conn)?></span></a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-trophy"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Accurecy</span>
                <a href="winner_paid_list.php"><span class="info-box-number"><?=get_accurecy($conn)?> %</span></a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-person-chalkboard"></i></span>
      

              <div class="info-box-content">
                  
                <span class="info-box-text">Times Trained</span>
                <a href="game_list.php"><span class="info-box-number"><?=get_epochs($conn)?></span></a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>

             <div class="info-box-content">
                <span class="info-box-text">Train Time</span>
                  <a href="user_list.php"><span class="info-box-number"><?= get_execute_time($conn)?> minutes</span>
                  </a>
              </div>
            
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
