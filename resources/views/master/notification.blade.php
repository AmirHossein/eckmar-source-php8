
<div class="{{ $size or 'col-md-6 col-md-offset-3'}}">
  <div class="panel panel-default">
    <div class="panel-heading">
      {{ $title or 'Notification' }}
    </div>
    <div class="panel-body">
        {{ $slot }}

    </div>
  </div>
</div>
