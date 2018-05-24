<div class="modal" tabindex="-1" role="dialog" id="{{$id}}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{$slot}}</h5>
      </div>
      <div class="modal-body">
        <p class="text-center">
            <div class="progress">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
        </p>
      </div>
    </div>
  </div>
</div>