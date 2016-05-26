<div class="container">
  <form>
    <div class="row">
      <div class="col-sm-6"><img src="{{ $imgsrc }}" class="img-thumbnail"/></div>
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-heading">{{ Lang::get('laravel-filemanager::lfm.edit-info-base') }}</div>
          <div class="panel-body">
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-img-id') }}</label>
              <input class="form-control" name="imgid"/>
            </div>
            <div class="form-gorup">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-img-cat') }}</label>
              <div class="row">
                <div class="col-sm-6">
                  <select class="form-control"></select>
                </div>
                <div class="col-sm-6">
                  <select class="form-control"></select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <hr/>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-heading">{{ Lang::get('laravel-filemanager::lfm.edit-info-ch') }}</div>
          <div class="panel-body">
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-subject-ch') }}</label>
              <input class="form-control"/>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-author-ch') }}</label>
              <input class="form-control"/>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-desc-ch') }}</label>
              <textarea rows="5" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-src-ch') }}</label>
              <select class="form-control"></select>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-heading">{{ Lang::get('laravel-filemanager::lfm.edit-info-en') }}</div>
          <div class="panel-body">
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-subject-en') }}</label>
              <input class="form-control"/>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-author-en') }}</label>
              <input class="form-control"/>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-desc-en') }}</label>
              <textarea rows="5" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-src-en') }}</label>
              <select class="form-control"></select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="form-group pull-right">
          <div class="btn-group">
            <button class="btn btn-primary">儲存</button>
            <button class="btn btn-danger" onclick="trash('{{ $img }}')" type="button">刪除</button>
            <button class="btn btn-info" onclick="loadItems()">{{ Lang::get('laravel-filemanager::lfm.btn-cancel') }}</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  $(document).ready(function () {
    $("#height_display").html($("#resize").height() + "px");
    $("#width_display").html($("#resize").width() + "px");

    $("#resize").resizable({
      aspectRatio: true,
      containment: "#containment",
      handles: "n, e, s, w, se, sw, ne, nw",
      resize: function (event, ui) {
        $("#width").val($("#resize").width());
        $("#height").val($("#resize").height());
        $("#height_display").html($("#resize").height() + "px");
        $("#width_display").html($("#resize").width() + "px");
      }
    });
  });

  {{--function doResize() {--}}
    {{--$.ajax({--}}
      {{--type: "GET",--}}
      {{--dataType: "text",--}}
      {{--url: "/laravel-filemanager/doresize",--}}
      {{--data: {--}}
        {{--img: '{{ $img }}',--}}
        {{--working_dir: $("#working_dir").val(),--}}
        {{--dataX: $("#dataX").val(),--}}
        {{--dataY: $("#dataY").val(),--}}
        {{--dataHeight: $("#height").val(),--}}
        {{--dataWidth: $("#width").val()--}}
      {{--},--}}
      {{--cache: false--}}
    {{--}).done(function (data) {--}}
      {{--if (data == "OK") {--}}
        {{--loadItems();--}}
      {{--} else {--}}
        {{--notify(data);--}}
      {{--}--}}
    {{--});--}}
  {{--}--}}
</script>
