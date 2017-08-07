<div class="box box-danger box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-info"></i> Item Detail:</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <label for="code" class="col-sm-4">Code</label>
          <div class="col-sm-8">
            <span>{{$item->code}}</span>
          </div>
        </div>
        <div class="form-group row">
          <label for="code" class="col-sm-4">Name</label>
          <div class="col-sm-8">
            <span>{{$item->name}}</span>
          </div>
        </div>
        <div class="form-group row">
          <label for="code" class="col-sm-4">Measurement</label>
          <div class="col-sm-8">
            <span>{{$item->measurement}}</span>
          </div>
        </div>
        <div class="form-group row">
          <label for="code" class="col-sm-4">Price</label>
          <div class="col-sm-8">
            <span>{{number_format($item->price)}}</span>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label for="code" class="col-sm-4">Target by</label>
          <div class="col-sm-8">
            <span>
              @if ($item->target_by == 1)
                Quantity
              @else
                Outlet
              @endif
            </span>
          </div>
        </div>
        <div class="form-group row">
          <label for="code" class="col-sm-4">Target Count</label>
          <div class="col-sm-8">
            <span>{{number_format($item->target_count)}}</span>
          </div>
        </div>
        <div class="form-group row">
          <label for="code" class="col-sm-4">Start Date</label>
          <div class="col-sm-8">
            <span>{{$item->start_date->format('d M Y')}}</span>
          </div>
        </div>
        <div class="form-group row">
          <label for="code" class="col-sm-4">End Date</label>
          <div class="col-sm-8">
            <span>{{$item->end_date->format('d M Y')}}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
