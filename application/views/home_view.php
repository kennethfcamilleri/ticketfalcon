
<div class="col-md-10 col-md-offset-1">

  <div class="text-left">
    <h3>Recently Added Events</h3><br>
  </div>

  <?php if (count($recent_events) > 0): ?>

  <div class="row">

  <?php foreach ($recent_events as $event): ?>

  <?php $event_url = base_url() . "events/show/".$event->event_id."/"; ?>
  
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5 class="text-primary"><?php echo $event->event_name; ?></h5>
        </div>
        <div class="panel-body">
          <p><span class="glyphicon glyphicon-time"></span> <?php echo date('l jS F Y h:i A',strtotime($event->start_date)); ?></p>
          <p><span class="glyphicon glyphicon-map-marker"></span> <?php echo $event->event_location; ?></p>
        </div>
        <div class="panel-footer text-center">
          <a href="<?php echo $event_url ?>" class="btn btn-md btn-primary" role="button">Get Tickets</a>
        </div>
      </div> 
    </div>

  <?php endforeach; ?>

  </div>

  <?php else: ?>

      <p>There are currently no events listed at the moment.</p>

  <?php endif; ?>
  <br>
</div>

