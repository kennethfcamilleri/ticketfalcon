<div class="col-md-8 col-md-offset-2">
    <h3>Search Results</h3>
    <br>

    <?php if (count($search_results) > 0): ?>

    <div class="list-group">
      <?php foreach ($search_results as $event): ?>

      <?php $event_url = base_url() . "events/show/".$event->event_id."/"; ?>

      <a href="<?php echo $event_url; ?>" class="list-group-item">
        <h4 class="text-primary"><?php echo $event->event_name; ?></h4>
        <p><span class="glyphicon glyphicon-time"></span> <?php echo date('l jS \of F Y h:i A',strtotime($event->start_date)); ?></p>
        <p><span class="glyphicon glyphicon-map-marker"></span> <?php echo $event->event_location; ?></p>
      </a>
      <br>

      <?php endforeach; ?>

    </div>

    <?php else: ?>

      <p>No results found!</p>

    <?php endif; ?>

</div>
