<!-- Modal Edit dataNode-->

<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchModalLabel">{{ __('Search Books') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  		<div class="form-group row">
  			<label for="naziv" class="col-md-3 col-form-label text-md-right form-control-sm">{{ __('Naziv') }}</label>
  			<div class="col-md-6">
          <input id="naziv" type="text" class="form-control form-control-sm" name="naziv" value="" placeholder="Full book title" autofocus>
        </div>
  		</div>

      <div class="form-group row">
  			<label for="autor" class="col-md-3 col-form-label text-md-right form-control-sm">{{ __('Autor') }}</label>
  			<div class="col-md-6">
          <input id="autor" type="text" class="form-control form-control-sm" name="autor" value="" placeholder="Author">
        </div>
  		</div>

      <div class="form-group row">
  			<label for="izdavac" class="col-md-3 col-form-label text-md-right form-control-sm">{{ __('Izdavac') }}</label>
  			<div class="col-md-6">
          <input id="izdavac" type="text" class="form-control form-control-sm" name="izdavac" value="" placeholder="Issuer">
        </div>
  		</div>

      <div class="form-group row">
  			<label for="godina_izdanja" class="col-md-3 col-form-label text-md-right form-control-sm">{{ __('Godina izdanja') }}</label>
  			<div class="col-md-6">
          <input id="godina_izdanja" type="text" class="form-control form-control-sm" name="godina_izdanja" value="" placeholder="enter year only">
        </div>
  		</div>

      <div class="form-group row">
  			<label for="last" class="col-md-3 col-form-label text-md-right form-control-sm">{{ __('Godina izdanja-zadnjih') }}</label>
  			<div class="col-md-6">
          <input id="last" type="text" class="form-control form-control-sm" name="last" value="" placeholder="issued last X years">
        </div>
  		</div>

      <div class="form-group row">
  			<label for="before" class="col-md-3 col-form-label text-md-right form-control-sm">{{ __('Izdatio starije od') }}</label>
  			<div class="col-md-6">
          <input id="before" type="text" class="form-control form-control-sm" name="before" value="" placeholder="issued before X years ago">
        </div>
  		</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick="runSearch();">{{ __('Search') }}</button>
      </div>
    </div>
  </div>
</div>
