<div class="modal" tabindex="-1" role="dialog" id="{{$id}}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{$slot}}</h5>
      </div>
      <div class="modal-body">
        <p class="text-center">
            <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
            <span class="sr-only">Loading...</span>
        </p>
      </div>
    </div>
  </div>
</div>