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
              <input class="form-control" name="imgid" value="{{$entity->id}}" disabled/>
            </div>
            <div class="form-gorup">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-img-cat') }}</label>
              <div class="row">
                <div class="col-sm-6">
                  <select id='cat_id' class="form-control">
                    @foreach($category as $key => $value)
                      <?php $selected = (property_exists($entity, 'cat_id') && $entity->cat_id == $key) ? 'selected':'';?>
                      <option value="{{$key}}" {{$selected}}>{{ $value }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-6">
                  <select id='subcat_id' class="form-control">
                    <?php reset($category); ?>
                    <?php $cat = !property_exists($entity, 'cat_id') || $entity->cat_id == null ? key($category) : $entity->cat_id ;?>
                    @if(isset($subcat[$cat]))
                      @foreach($subcat[$cat] as $key => $value)
                        <?php $selected = (property_exists($entity, 'subcat_id') && $entity->subcat_id == $key) ? 'selected':'';?>
                        <option value="{{$key}}" {{$selected}}>{{ $value }}</option>
                      @endforeach
                    @endif
                  </select>
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
              <input id='tc_title' class="form-control" value="{{@$entity->tc_title}}"/>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-author-ch') }}</label>
              <input id='tc_author' class="form-control" value="{{@$entity->tc_author}}"/>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-desc-ch') }}</label>
              <textarea id='tc_caption' rows="5" class="form-control">{{@$entity->tc_caption}}</textarea>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-src-ch') }}</label>
              <select id='tc_source_id' class="form-control">
                <option value=""></option>
                @if(!empty($sourcemap[0]))
                @foreach($sourcemap[0] as $key => $value)
                  <?php $selected = (property_exists($entity, 'tc_source_id') && $entity->tc_source_id == $key) ? 'selected':'';?>
                  <option value="{{$key}}" {{$selected}}>{{ $value }}</option>
                @endforeach
                @endif
              </select>
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
              <input id='en_title' class="form-control" value="{{@$entity->en_title}}"/>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-author-en') }}</label>
              <input id='en_author' class="form-control" value="{{@$entity->en_author}}"/>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-desc-en') }}</label>
              <textarea id='en_caption' rows="5" class="form-control">{{@$entity->en_caption}}</textarea>
            </div>
            <div class="form-group">
              <label>{{ Lang::get('laravel-filemanager::lfm.edit-src-en') }}</label>
              <select id='en_source_id' class="form-control">
                <option value=""></option>
                @if(!empty($sourcemap[1]))
                @foreach($sourcemap[1] as $key => $value)
                  <?php $selected = (property_exists($entity, 'en_source_id') && $entity->en_source_id == $key) ? 'selected':'';?>
                  <option value="{{$key}}" {{$selected}}>{{ $value }}</option>
                @endforeach
                @endif
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="form-group pull-right">
          <div class="btn-group">
            <button class="btn btn-primary" onclick="update({{$entity->id}})" type="button">儲存</button>
            <button class="btn btn-danger" onclick="trash('{{ $imgName }}')" type="button">刪除</button>
            <button class="btn btn-info" onclick="loadItems()" type="button">{{ Lang::get('laravel-filemanager::lfm.btn-cancel') }}</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  $(document).ready(function () {

  });

  function update(id) {
    $.ajax({
      type: "POST",
      dataType: "text",
      url: "/laravel-filemanager/update/" + id,
      data: {
        cat_id: $("#cat_id").val(),
        subcat_id: $("#subcat_id").val(),
        tc_title: $("#tc_title").val(),
        tc_author: $("#tc_author").val(),
        tc_caption: $("#tc_caption").val(),
        tc_source_id: $("#tc_source_id").val(),
        en_title: $("#en_title").val(),
        en_author: $("#en_author").val(),
        en_caption: $("#en_caption").val(),
        en_source_id: $("#en_source_id").val(),
        working_dir: $('#working_dir').val()
      },
      cache: false
    }).done(function (data) {
      if (data == "OK") {
        loadItems();
      } else {
        notify(data);
      }
    });
  }

  // watch cat changes
  $('#cat_id').change(function() {
    var pid = $('#cat_id').val();

    var $el = $("#subcat_id");
    $el.empty(); // remove old options
    if (!subcat_map || !subcat_map[pid]) {
      return;
    }
    console.log('here');
    $el.append($("<option></option>"));
    $.each(subcat_map[pid], function(value, key) {
      $el.append($("<option></option>").attr("value", value).text(key));
    });
  });
</script>
