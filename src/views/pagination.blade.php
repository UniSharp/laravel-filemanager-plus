@if($pages)
<div class="col-md-12 text-center" style='margin-bottom: 40px;'>
  <nav aria-label="Page navigation">
    <ul class="pagination">
      <?php $margin = 3; ?>
      <?php $first_page = $pages[0]; ?>
      <?php $last_page = $pages[count($pages) - 1]; ?>
      @if($current_page - $first_page > $margin)
        <li><a class="paginator" data-page="{{$first_page}}"> << </a></li>
      @endif
@foreach($pages as $page)
@if(abs($page - $current_page) <= $margin)
  <li><a class="paginator" data-page="{{$page}}">{{$page}}</a></li>
@endif
@endforeach
      @if(end($pages) - $current_page > $margin)
        <li><a class="paginator" data-page="{{$last_page}}"> >> </a></li>
      @endif
    </ul>
  </nav>
</div>
@endif
