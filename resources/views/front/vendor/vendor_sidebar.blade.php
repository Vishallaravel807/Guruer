
@php
use App\Models\Vendor;

$vendorType = Vendor::where('vendor_id', auth('vendor')->id())
    ->first();
@endphp


<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ Request::is('vendorsDasboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{url('vendorsDasboard')}}">
        <i class="fa fa-th" aria-hidden="true"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item {{ Request::is('ProfileSetting') ? 'active' : '' }}">
      <a class="nav-link" href="{{url('ProfileSetting')}}" >
        <i class="fa fa-user"></i>
        <span class="menu-title">My Profile</span>
        <i class="menu-arrow"></i>
      </a>
    </li>
    <li class="nav-item {{ Request::is('addProduct/*') || Request::is('vendorProduct') ? 'active' : '' }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#tables-menu" aria-expanded="{{ Request::is('addProduct') || Request::is('vendorProduct') ? 'true' : 'false' }}" aria-controls="tables-menu">
            <i class="fas fa-tshirt" aria-hidden="true"></i>
            <span class="menu-title">Products</span>
            <i class="menu-arrow fa fa-chevron-down"></i>
        </a>
        <!-- Dropdown items -->
        <div class="collapse {{ Request::is('addProduct/*') ? 'show' : '' }}" id="tables-menu">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item ">
                    <a class="nav-link {{ Request::is('addProduct/*') ? 'active' : '' }}" href="{{'addProduct'}}">Add Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('vendorProduct') ? 'active' : '' }}" href="{{url('vendorProduct')}}">View Product</a>
                </li>
            </ul>
        </div>
    </li>
    @if($vendorType->vendor_type == '1')
    <li class="nav-item {{ Request::is('Catalogue/*') || Request::is('Catalogue') ? 'active' : '' }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#catalogue-menu" aria-expanded="{{ Request::is('addCatalogue') || Request::is('Catalogue') ? 'true' : 'false' }}" aria-controls="tables-menu">
            <i class="fas fa-tshirt" aria-hidden="true"></i>
            <span class="menu-title">Catalogue</span>
            <i class="menu-arrow fa fa-chevron-down"></i>
        </a>
        <!-- Dropdown items -->
        <div class="collapse {{ Request::is('Catalogue/*') ? 'show' : '' }}" id="catalogue-menu">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item ">
                    <a class="nav-link {{ Request::is('addCatalogue/*') ? 'active' : '' }}" href="{{'addCatalogue'}}">Add Catalogue</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('Catalogue') ? 'active' : '' }}" href="{{('Catalogue')}}">View Catalogue</a>
                </li>
            </ul>
        </div>
    </li>
    @endif

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#" aria-expanded="false" aria-controls="form-elements">
        <i class="fa fa-shopping-cart"></i>
        <span class="menu-title">Orders</span>
        <i class="menu-arrow"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#" aria-expanded="false" aria-controls="charts">
        <i class="fas fa-comment" aria-hidden="true"></i>
        <span class="menu-title">Message</span>
        <i class="menu-arrow"></i>
      </a>

    </li>
    


    <!--li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
        <i class="fa fa-th" aria-hidden="true"></i>
        <span class="menu-title">Icons</span>
        <i class="menu-arrow"></i>
      </a>  
    </!--li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="fa fa-th" aria-hidden="true"></i>
        <span class="menu-title">User Pages</span>
        <i class="menu-arrow"></i>
      </a>
 
    </li>

    <li-- class="nav-item">
      <a class="nav-link" href="../../../docs/documentation.html">
        <i class="fa fa-th" aria-hidden="true"></i>
        <span class="menu-title">Documentation</span>
      </a>
    </li-->
  </ul>
</nav>