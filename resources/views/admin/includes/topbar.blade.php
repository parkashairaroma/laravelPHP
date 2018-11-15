<aside class="topbar @if ($isBase) is-base-header @endif">
    <div class="logo">A/A</div>
    <span class="name">Air/Aroma Administration<span class="main-domain">{{ $siteConfig['web_main_domain'] }} @if ($isBase) (BASE) @endif</span></span>
    <ul>
      {{--
      <!--       
      <li><a href="#"><i class="fa fa-user"></i></a></li>
      <li>
        <a href="#"><i class="fa fa-flag"></i>
          <span class="label label-danger">2</span>
        </a>
      </li>
      <li>
        <a href="#"><i class="fa fa-envelope-o"></i>
          <span class="label label-warning">8</span></a>
        </a>
      </li> 
      -->
      --}}
      <li><a href="{{ $basePath }}/admin/logout"><i class="fa fa-sign-out"></i></a></li>
    </ul>
</aside>