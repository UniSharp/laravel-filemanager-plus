<div class="container">
  <div class="row">

    @if(sizeof($files) > 0)

    @if($pages)
    <div class="col-md-12 text-center">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          @foreach($pages as $page)
          <li><a class="paginator">{{$page}}</a></li>
          @endforeach
        </ul>
      </nav>
    </div>
    @endif

    <?php $idx = 0; ?>
    @foreach($files as $key => $file)

    <?php $file_name = $file_info[$key]['name'];?>
    <?php $thumb_src = $thumb_url . $file_name;?>
    <?php if($idx % 6 == 0) {$style = 'clear:left;';} else {$style = '';} ?>
    <div class="col-sm-3 col-md-2 img-row" style="{{$style}}">

      <div class="thumbnail thumbnail-img" data-id="{{ $file_name }}" id="img_thumbnail_{{ $key }}" style="margin-bottom: 0px">
        <img id="{{ $file }}" src="{{ $thumb_src }}" alt="" class="pointer" onclick="useFile('{{ $file_name }}')" width="200px" max-height="200px">
      </div>

      <div class="caption text-center" style="margin-bottom: 20px">
        <div class="btn-group ">
          <button type="button" onclick="useFile('{{ $file_name }}')" class="btn btn-default btn-xs">
            {{--{{ str_limit($file_name, $limit = 10, $end = '...') }}--}}
            {{ '請選擇' }}
          </button>
          <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <!--<li><a href="javascript:rename('{{ $file_name }}')"><i class="fa fa-edit fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-rename') }}</a></li>-->
            <li><a href="javascript:edit('{{ $file_name }}')"><i class="fa fa-edit fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-edit') }}</a></li>
            <li><a href="javascript:fileView('{{ $file_name }}')"><i class="fa fa-image fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-view') }}</a></li>
            <li><a href="javascript:download('{{ $file_name }}')"><i class="fa fa-download fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-download') }}</a></li>
            <li class="divider"></li>
            {{--<li><a href="javascript:notImp()">Rotate</a></li>--}}
            <li><a href="javascript:trash('{{ $file_name }}')"><i class="fa fa-trash fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-delete') }}</a></li>
          </ul>
        </div>
      </div>
    </div>
    <?php $idx++; ?>
    @endforeach

    @if($pages)
    <div class="col-md-12 text-center" style='margin-bottom: 40px;'>
      <nav aria-label="Page navigation">
        <ul class="pagination">
          @foreach($pages as $page)
          <li><a class="paginator">{{$page}}</a></li>
          @endforeach
        </ul>
      </nav>
    </div>
    @endif

    @else
    <div class="col-md-12">
      <p>找不到圖片</p>
    </div>
    @endif

  </div>
</div>
