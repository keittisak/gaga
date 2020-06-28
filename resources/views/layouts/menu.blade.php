<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
    <div class="container">
      <div class="row align-items-center">
        {{-- <div class="col-lg-3 ml-auto">
          <form class="input-icon my-3 my-lg-0">
            <input type="search" class="form-control header-search" placeholder="Search&hellip;" tabindex="1">
            <div class="input-icon-addon">
              <i class="fe fe-search"></i>
            </div>
          </form>
        </div> --}}
        <div class="col-lg order-lg-first">
          <ul class="nav nav-tabs border-0 flex-column flex-lg-row prompt-front">
            <li class="nav-item">
              <a href="{{ route('dashboard.index') }}" class="nav-link"><i class="fe fe-home"></i> หน้าแรก</a>
            </li>
            <li class="nav-item">
              <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-file"></i> ออเดอร์</a>
              <div class="dropdown-menu dropdown-menu-arrow">
                <a href="{{ route('orders.create') }}" class="dropdown-item ">สร้างออเดอร์</a>
                <a href="{{ route('orders.index') }}" class="dropdown-item ">จัดการออเดอร์</a>
                <a href="{{ route('orders.index') }}" class="dropdown-item ">ประวัติออเดอร์</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-file"></i> จัดการสินค้า</a>
              <div class="dropdown-menu dropdown-menu-arrow">
                <a href="{{ route('products.index') }}" class="dropdown-item ">สินค้า</a>
                <a href="{{ route('stocks.index') }}" class="dropdown-item ">คลังสินค้า</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a href="#" class="nav-link"><i class="fe fe-check-square"></i> รายงาน</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link"><i class="fe fe-file-text"></i> นำเข้า/ส่งออกข้อมูล</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>