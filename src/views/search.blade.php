<div class="container">

  @if(sizeof($files) > 0)
  @include('laravel-filemanager::pagination')
  @endif

  <div class="row">

    @if(sizeof($files) > 0)

    <?php $idx = 0; ?>
    @foreach($files as $key => $file)

    <?php $file_name = $file_info[$key]['name'];?>
    <?php $image_not_found = $file_info[$key]['size'] == 'unknown';?>
    <?php $long_name = $file_info[$key]['long_name'];?>
    <?php $thumb_src = $thumb_url . $long_name;?>
    <?php $original_src = str_replace(public_path(), '', $file);?>
    <?php if($idx % 6 == 0) {$style = 'clear:left;';} else {$style = '';} ?>
    <div class="col-sm-3 col-md-2 img-row" style="{{$style}}">

      @if($image_not_found)
      <div class="thumbnail thumbnail-img text-center" data-id="{{ $file_name }}" id="img_thumbnail_{{ $key }}">
        <i id="{{ $file }}" class="fa {{ $file_info[$key]['icon'] }} fa-5x" style="height:200px;cursor:pointer;padding-top:60px;"></i>
        <p style="margin-top: -65px; padding-bottom: 35px">找不到圖片</p>
      </div>
      @else
      <div class="thumbnail thumbnail-img" data-id="{{ $file_name }}" id="img_thumbnail_{{ $key }}" style="margin-bottom: 0px">
        <img id="{{ $file }}" src="{{ $thumb_src }}" alt="" class="pointer" onclick="useFile('{{ $long_name }}')" width="200px" max-height="200px" onerror="this.src='{{$original_src}}'">
      </div>
      @endif
      <p style="color:#999">{{$file_info[$key]['folders']}}</p>
      <div class="caption text-center" style="margin-bottom: 20px">
        <div class="btn-group ">
          <button type="button" onclick="useFile('{{ $long_name }}')" class="btn btn-default btn-xs">
            {{--{{ str_limit($file_name, $limit = 10, $end = '...') }}--}}
            {{ '請選擇' }}
          </button>
          <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <!--<li><a href="javascript:rename('{{ $file_name }}')"><i class="fa fa-edit fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-rename') }}</a></li>-->
            <li><a href="javascript:edit('{{ $long_name }}')"><i class="fa fa-edit fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-edit') }}</a></li>
            <li><a href="javascript:fileView('{{ $long_name }}')"><i class="fa fa-image fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-view') }}</a></li>
            <li><a href="javascript:download('{{ $long_name }}')"><i class="fa fa-download fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-download') }}</a></li>
            <li class="divider"></li>
            {{--<li><a href="javascript:notImp()">Rotate</a></li>--}}
            <li><a href="javascript:trash('{{ $long_name }}')"><i class="fa fa-trash fa-fw"></i> {{ Lang::get('laravel-filemanager::lfm.menu-delete') }}</a></li>
          </ul>
        </div>
      </div>
    </div>
    <?php $idx++; ?>
    @endforeach

    @else
    <div class="col-md-12">
      <p>找不到圖片</p>
    </div>
    @endif

  </div>

  @if(sizeof($files) > 0)
  @include('laravel-filemanager::pagination')
  @endif

</div>
