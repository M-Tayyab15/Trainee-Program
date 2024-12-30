<!-- resources/views/layouts/sidebar.blade.php -->
<nav id="sidebar" class="w3-sidebar w3-top w3-bottom w3-collapse w3-white w3-border-right w3-border-top scrollbar" style="z-index:3;width:230px;height:auto;margin-top:54px;border-color:rgba(0, 0, 0, .1)!important" id="mySidebar">
  <div class="w3-bar-item w3-border-bottom w3-hide-large" style="padding:6px 0">
    <label for="sidebar-control" class="w3-left w3-button w3-large w3-opacity-min" style="background:white!important"><i class="fa fa-bars"></i></label>
    <h5 style="line-height:1; margin:0!important; font-weight:300">
      <a href="{{ URL('/') }}" class="w3-button" style="background:white!important">
        <img src="{{ asset('assets/admin-logo.png') }}" alt="w3mix" class="w3-image"> &nbsp; W3Admin </a>
    </h5>
  </div>
  <div class="w3-bar-block">
    <span class="w3-bar-item w3-padding w3-small w3-opacity" style="margin-top:8px"> MAIN NAVIGATION </span>
    <a href="{{ route('dashboard') }}" class="w3-bar-item w3-button w3-padding-large w3-hover-text-primary">
      <i class="fa fa-fw fa-bar-chart"></i>&nbsp; Dashboard 
    </a>
  </div>
</nav>
